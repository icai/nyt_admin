<?php

//decode by http://www.yunlu99.com/
namespace app\api\service;

use app\common\Tension;
use think\Db;
use think\Request;
class UserService
{
    protected $config = array("url" => "https://api.weixin.qq.com/sns/jscode2session", "appid" => '', "secret" => '', "grant_type" => "authorization_code");
    public function checkLogin($code, $much_id)
    {
        if (cache("fatal_" . $much_id)) {
            $getConfig = cache("fatal_" . $much_id);
        } else {
            $getConfig = Db::name("config")->where("much_id", $much_id)->find();
            if ($getConfig) {
                foreach ($getConfig as $key => $value) {
                    if ($key != "id" && $key != "pay_react" && $key != "much_id") {
                        $getConfig[$key] = authcode($getConfig[$key], "DECODE", "YuluoNetwork", 0);
                    }
                }
                cache("fatal_" . $much_id, $getConfig);
            }
        }
        $params = array("appid" => $getConfig["app_id"], "secret" => $getConfig["app_secret"], "js_code" => $code, "grant_type" => $this->config["grant_type"]);
        $res = $this->makeRequest($this->config["url"], $params);
        return $res["result"];
    }
    protected function makeRequest($url, $params = array(), $expire = 0, $extend = array(), $hostIp = '')
    {
        if (empty($url)) {
            return array("code" => "100");
        }
        $_curl = curl_init();
        $_header = array("Accept-Language: zh-CN", "Connection: Keep-Alive", "Cache-Control: no-cache");
        if (!empty($hostIp)) {
            $urlInfo = parse_url($url);
            if (empty($urlInfo["host"])) {
                $urlInfo["host"] = substr(DOMAIN, 7, -1);
                $url = "http://{$hostIp}{$url}";
            } else {
                $url = str_replace($urlInfo["host"], $hostIp, $url);
            }
            $_header[] = "Host: {$urlInfo["host"]}";
        }
        if (!empty($params)) {
            curl_setopt($_curl, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($_curl, CURLOPT_POST, true);
        }
        if (substr($url, 0, 8) == "https://") {
            curl_setopt($_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($_curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($_curl, CURLOPT_URL, $url);
        curl_setopt($_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($_curl, CURLOPT_USERAGENT, "API PHP CURL");
        curl_setopt($_curl, CURLOPT_HTTPHEADER, $_header);
        if ($expire > 0) {
            curl_setopt($_curl, CURLOPT_TIMEOUT, $expire);
            curl_setopt($_curl, CURLOPT_CONNECTTIMEOUT, $expire);
        }
        if (!empty($extend)) {
            curl_setopt_array($_curl, $extend);
        }
        $result["result"] = curl_exec($_curl);
        $result["code"] = curl_getinfo($_curl, CURLINFO_HTTP_CODE);
        $result["info"] = curl_getinfo($_curl);
        if ($result["result"] === false) {
            $result["result"] = curl_error($_curl);
            $result["code"] = -curl_errno($_curl);
        }
        curl_close($_curl);
        return $result;
    }
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;
    public function decryptData($encryptedData, $sessionKey, $app_id, $iv, &$data)
    {
        if (strlen($sessionKey) != 24) {
            return self::$IllegalAesKey;
        }
        $aesKey = base64_decode($sessionKey);
        if (strlen($iv) != 24) {
            return self::$IllegalIv;
        }
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            return self::$IllegalBuffer;
        }
        if ($dataObj->watermark->appid != $app_id) {
            return self::$IllegalBuffer;
        }
        $data = $result;
        return self::$OK;
    }
    public function examine($id, $much_id)
    {
        $paper_info = Db::name("paper")->where("id", $id)->where("much_id", $much_id)->find();
        Db::startTrans();
        try {
            $shaky_fission = Db::name("shaky_fission")->where("much_id", $much_id)->find();
            if (!empty($shaky_fission)) {
                $check_paper = Db::name("paper")->where("user_id", $paper_info["user_id"])->whereTime("adapter_time", "today")->where("much_id", $much_id)->count();
                if ($shaky_fission["release_single"] != 0) {
                    if ($check_paper <= $shaky_fission["release_single"]) {
                        $user_info = Db::name("user")->where("id", $paper_info["user_id"])->where("much_id", $much_id)->find();
                        $amount_j["user_id"] = $user_info["id"];
                        $amount_j["category"] = 3;
                        $amount_j["finance"] = $shaky_fission["release_fraction"];
                        $amount_j["poem_fraction"] = $user_info["fraction"];
                        $amount_j["poem_conch"] = $user_info["conch"];
                        $amount_j["surplus_fraction"] = $user_info["fraction"] + $shaky_fission["release_fraction"];
                        $amount_j["surplus_conch"] = $user_info["conch"];
                        $amount_j["ruins_time"] = time();
                        $amount_j["solution"] = "发贴获得积分";
                        $amount_j["evaluate"] = 1;
                        $amount_j["much_id"] = $much_id;
                        $amount_j_res = Db::name("user_amount")->insert($amount_j);
                        if (!$amount_j_res) {
                            Db::rollback();
                            return json_encode(["status" => "error", "id" => 0, "msg" => "审核失败，请稍候重试！1"]);
                        }
                        $user_j_res = Db::name("user")->where("id", $user_info["id"])->where("much_id", $much_id)->update(["fraction" => $amount_j["surplus_fraction"]]);
                        if (!$user_j_res) {
                            Db::rollback();
                            return json_encode(["status" => "error", "id" => 0, "msg" => "审核失败，请稍候重试！2"]);
                        }
                        $paper_src = Db::name("paper")->where("id", $id)->where("much_id", $much_id)->update(["prove_time" => time(), "study_status" => 1]);
                        if (!$paper_src) {
                            Db::rollback();
                            return json_encode(["status" => "error", "id" => 0, "msg" => "审核失败，请稍候重试！3"]);
                        }
                    }
                }
            }
            Db::commit();
            return json_encode(["status" => "success", "msg" => "审核成功！"]);
        } catch (\Exception $e) {
            Db::rollback();
            return json_encode(["status" => "error", "id" => 0, "msg" => "审核失败，请稍候重试！" . $e->getMessage()]);
        }
    }
    public function user_reward($data)
    {
        $tribute_taxation = Db::name("tribute_taxation")->where("much_id", $data["much_id"])->find();
        $li_wu = Db::name("tribute")->where("id", $data["li_id"])->where("much_id", $data["much_id"])->find();
        $conch = $data["num"] * $li_wu["tr_conch"];
        $is["much_id"] = $data["much_id"];
        $is["con_user_id"] = $data["uid"];
        $is["sel_user_id"] = $data["user_id"];
        $is["bute_name"] = $data["num"] . "个" . $li_wu["tr_name"];
        $is["bute_price"] = $li_wu["tr_conch"];
        $is["allow_scale"] = 1 - $tribute_taxation["taxing"];
        $is["bute_time"] = time();
        $fraction = $conch * $is["allow_scale"] * 10;
        Db::startTrans();
        try {
            $user_amount = $this->add_user_amount($data["user_id"], 3, $conch, "获赠礼物收益并扣除手续费", $data["much_id"], $is["allow_scale"]);
            if (!$user_amount) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return $rs;
            }
            $ins = Db::name("user_subsidy")->insert($is);
            if (!$ins) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return $rs;
            }
            $up_user = Db::name("user")->where("id", $data["user_id"])->setInc("fraction", $fraction);
            if (!$up_user) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return $rs;
            }
            Db::commit();
            $rs = ["status" => "success", "msg" => "赠送成功！"];
            return $rs;
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
            return $rs;
        }
    }
    public function add_user_amount($user_id, $category, $finance, $solution, $much_id, $tribute_taxation)
    {
        $user_info = Db::name("user")->where("id", $user_id)->where("much_id", $much_id)->find();
        $data["user_id"] = $user_id;
        $data["category"] = $category;
        $data["ruins_time"] = time();
        $data["solution"] = $solution;
        $data["much_id"] = $much_id;
        if ($category == 3) {
            $data["evaluate"] = 1;
            $data["finance"] = $finance * $tribute_taxation * 10;
            $data["poem_fraction"] = $user_info["fraction"];
            $data["surplus_fraction"] = $user_info["fraction"] + $finance * $tribute_taxation * 10;
        }
        if ($category == 2) {
            $data["evaluate"] = 0;
            $data["finance"] = -$finance;
            $data["poem_conch"] = $user_info["conch"];
            $data["surplus_conch"] = $user_info["conch"] - $finance;
        }
        $ins = Db::name("user_amount")->insert($data);
        if ($ins) {
            return true;
        } else {
            return false;
        }
    }
}