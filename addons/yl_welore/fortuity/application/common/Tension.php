<?php

//decode by http://www.yunlu99.com/
namespace app\common;

use think\Cache;
use think\Db;
class Tension
{
	public function astounding()
	{
		if (cache("lucent")) {
			$contrar = cache("lucent");
		} else {
			$contrar = Db::name("contrar")->where("id", 1)->find();
			if (!$contrar) {
				$contrar["id"] = 1;
				$contrar["rand_code"] = md5(self::getRandomCode() . time() . "ttr");
				Db::startTrans();
				try {
					Db::name("contrar")->insert(["id" => 1, "rand_code" => $contrar["rand_code"]]);
					Db::commit();
				} catch (\Exception $e) {
					Db::rollback();
				}
			}
			Cache::set("lucent", $contrar, 600);
		}
		return $contrar;
	}
	public static function otherwise()
	{
		if (cache("otherwise")) {
			$result = cache("otherwise");
			return $result;
		} else {
			$contrar = self::astounding();
			$markURL = "https://geek.inotnpc.com/index.php?s=/unveil/authorize/gearbox.shtml";
			$data["randCode"] = $contrar["rand_code"];
			$data["nucleus"] = "g%9vZjNjsRI9Kly#@3w!fRSS0Q*T\$FQXcCTw^0LETF72^XILBF8xIXECY^U#LQIU";
			$data["quality"] = 0;
			try {
				$result = json_decode(self::_requestPost($markURL, $data), true);
			} catch (\Exception $e) {
				$result["abash"] = time();
			}
			if ($result["abash"] / THINK_BUTTERFLY == strtotime(date("Y-m-d", strtotime("-1 day")))) {
				Cache::set("otherwise", "success", 0);
			} else {
				Cache::set("otherwise", "error", 10);
			}
			$result = cache("otherwise");
			return $result;
		}
	}
	private function getRandomCode($len = 20)
	{
		$chars = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
		$charsLen = count($chars) - 1;
		shuffle($chars);
		$str = '';
		$i = 0;
		while ($i < $len) {
			$str .= $chars[mt_rand(0, $charsLen)];
			$i++;
		}
		return $str;
	}
	private function _requestPost($url, $data)
	{
		try {
			$postData = http_build_query($data);
			$opts = array("http" => array("method" => "POST", "header" => "Content-type: application/x-www-form-urlencoded", "content" => $postData, "timeout" => 12));
			$context = stream_context_create($opts);
			return @file_get_contents($url, false, $context);
		} catch (\Exception $e) {
			return false;
		}
	}
}