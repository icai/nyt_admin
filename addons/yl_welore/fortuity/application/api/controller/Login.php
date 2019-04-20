<?php

//decode by http://www.yunlu99.com/
namespace app\api\controller;

use app\api\service\UserService;
use app\common\Tension;
use think\Controller;
use think\Db;
use think\Request;
class Login extends Controller
{
    public function index()
    {
        $rs = array("code" => 0, "info" => array());
        $code = input("param.code");
        $much_id = input("param.much_id");
        $user = new UserService();

        $info = $user->checkLogin($code, $much_id);
        $rs["info"] = json_decode($info, true);
        return json_encode($rs);
    }
    public function do_login()
    {
        $rs = array("code" => 0);
        $data = input("param.");
        $prevent_duplication = Db::name("authority")->where("much_id", $data["uniacid"])->find();
        $wx_d["user_head_sculpture"] = $data["userInfo"]["avatarUrl"];
        if ($prevent_duplication["prevent_duplication"] == 1) {
            $wx_d["user_nick_name"] = $this->user_nick_name(5);
        } else {
            $wx_d["user_nick_name"] = emoji_encode($data["userInfo"]["nickName"]);
        }
        $wx_d["gender"] = $data["userInfo"]["gender"];
        $wx_d["user_wechat_open_id"] = $data["wx_openid"];
        $wx_d["user_reg_time"] = time();
        $wx_d["much_id"] = $data["uniacid"];
        $wx_d["token"] = $this->create_uuid();
        $wx_d["autograph"] = '';
        $check = Db::name("user")->where("user_wechat_open_id", $data["wx_openid"])->find();
        if ($check) {
            $rs["id"] = $check["id"];
            Db::name("user")->where("id", $check["id"])->update(["token" => $this->create_uuid()]);
            $check_token = Db::name("user")->where("id", $rs["id"])->find();
            $rs["token"] = $check_token["token"];
        } else {
            $res = Db::name("user")->insertGetId($wx_d);
            $rs["id"] = $res;
            $check_token = Db::name("user")->where("id", $res)->find();
            $rs["token"] = $check_token["token"];
        }
        return json_encode($rs);
    }
    public function create_uuid($prefix = "Q")
    {
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8) . '';
        $uuid .= substr($str, 8, 4) . '';
        $uuid .= substr($str, 12, 4) . '';
        $uuid .= substr($str, 16, 4) . '';
        $uuid .= substr($str, 20, 12);
        return $prefix . $uuid;
    }
    public function user_nick_name($len)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $string = time();
        while ($len >= 1) {
            $position = rand() % strlen($chars);
            $position2 = rand() % strlen($string);
            $string = substr_replace($string, substr($chars, $position, 1), $position2, 0);
            $len--;
        }
        return "wx_" . $string;
    }
}