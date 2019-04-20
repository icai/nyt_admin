<?php

//decode by http://www.yunlu99.com/
namespace app\api\service;

use app\common\Tension;
use think\Db;
use think\Request;
class TmplService
{
	public function add_template($data)
	{
		if (cache("fatal_" . $data["much_id"])) {
			$getConfig = cache("fatal_" . $data["much_id"]);
		} else {
			$getConfig = Db::name("config")->where("much_id", $data["much_id"])->find();
			if ($getConfig) {
				foreach ($getConfig as $key => $value) {
					if ($key != "id" && $key != "pay_react" && $key != "much_id") {
						$getConfig[$key] = authcode($getConfig[$key], "DECODE", "YuluoNetwork", 0);
					}
				}
				cache("fatal_" . $data["much_id"], $getConfig);
			}
		}
		if (cache("access_token_" . $data["much_id"])) {
			$exp = json_decode(cache("access_token_" . $data["much_id"]));
			if ($exp["expires_in"] < time()) {
				$url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
				$json_access_token = file_get_contents($url_access_token);
				$arr_access_token = json_decode($json_access_token, true);
				$arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
				cache("access_token_" . $data["much_id"], $arr_access_token);
				$access_token = $arr_access_token["access_token"];
			} else {
				$access_token = $exp["access_token"];
			}
		} else {
			$url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
			$json_access_token = file_get_contents($url_access_token);
			$arr_access_token = json_decode($json_access_token, true);
			$arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
			cache("access_token_" . $data["much_id"], $arr_access_token);
			$access_token = $arr_access_token["access_token"];
		}
		$tmpl_url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
		$user_form_id = Db::name("user_form_info")->where("user_id", $data["user_id"])->where("much_id", $data["much_id"])->order("create_time desc")->find();
		$tmpl_sql = Db::name("mouldboard")->where("much_id", $data["much_id"])->find();
		$json = json_decode($tmpl_sql["prototype_data"], true);
		if ($data["at_id"] == "AT2310") {
			$tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT2310"], "page" => $data["page"], "form_id" => $user_form_id["formid"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]]));
		}
		if ($data["at_id"] == "AT2295") {
			$tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT2295"], "page" => $data["page"], "form_id" => $user_form_id["formid"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]]));
		}
		if ($data["at_id"] == "AT1803") {
			$tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT1803"], "page" => $data["page"], "form_id" => $user_form_id["formid"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]], "keyword4" => ["value" => $data["keyword4"]]));
		}
		if ($data["at_id"] == "AT0330") {
			$tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT0330"], "form_id" => $user_form_id["formid"], "page" => $data["page"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]]));
		}
		$result = $this->_requestPost($tmpl_url, json_encode($tmpl_data));
		$error_json = json_decode($result, true);
		if ($error_json["errcode"] == 0) {
			Db::name("user_form_info")->where("id", $user_form_id["id"])->delete();
		}
		return $error_json["errcode"];
	}
	public function _requestPost($url, $data, $ssl = true)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		$user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "\r\n    Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4";
		curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		if ($ssl) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		}
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		if (false === $response) {
			echo "<br>", curl_error($curl), "<br>";
			return false;
		}
		curl_close($curl);
		return $response;
	}
}