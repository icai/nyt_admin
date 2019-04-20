<?php

//decode by http://www.yunlu99.com/
namespace app\api\controller;

use think\Db;
require EXTEND_PATH . "Wxpay/WxPay.Api.php";
class Pay extends Base
{
	public function index()
	{
		$rs = ["status" => "success", "msg" => "购买成功"];
		$data = input("param.");
		$info = Db::name("user_honorary")->where("much_id", $data["much_id"])->find();
		$user_info = Db::name("user")->where("id", $data["uid"])->find();
		$design = Db::name("design")->where("much_id", $data["much_id"])->find();
		if ($data["time"] == 1 && $info["first_discount"] == 1 && $user_info["vip_end_time"] == '') {
			$money = sprintf("%.1f", $info["discount_scale"] * $info["hono_price"]);
		} else {
			$money = $data["time"] * $info["hono_price"];
		}
		$msg = "购买会员（" . $data["time"] . "个月）";
		if ($user_info["conch"] < $money) {
			$rs = ["status" => "error", "msg" => $design["currency"] . "不足，请充值！"];
			return json_encode($rs);
		}
		$ins["user_id"] = $data["uid"];
		$ins["category"] = "2";
		$ins["ruins_time"] = time();
		$ins["solution"] = $msg;
		$ins["much_id"] = $data["much_id"];
		$ins["finance"] = -$money;
		$ins["evaluate"] = 0;
		$ins["poem_fraction"] = $user_info["fraction"];
		$ins["poem_conch"] = $user_info["conch"];
		$ins["surplus_conch"] = $user_info["conch"] - $money;
		Db::startTrans();
		try {
			$db_ins = Db::name("user_amount")->insert($ins);
			if ($db_ins) {
				$dec = Db::name("user")->where("id", $data["uid"])->setDec("conch", $money);
				if (!$dec) {
					Db::rollback();
					$rs = ["status" => "error", "msg" => "购买失败！"];
					return json_encode($rs);
				}
				if ($user_info["vip_end_time"] < time()) {
					$vip_end_time = time() + 86400 * $data["time"] * 30;
				} else {
					$vip_end_time = $user_info["vip_end_time"] + 86400 * $data["time"] * 30;
				}
				$up_vip = Db::name("user")->where("id", $data["uid"])->update(["vip_end_time" => $vip_end_time]);
				if (!$up_vip) {
					Db::rollback();
					$rs = ["status" => "error", "msg" => "购买失败！"];
					return json_encode($rs);
				}
			} else {
				Db::rollback();
				$rs = ["status" => "error", "msg" => "购买失败！"];
				return json_encode($rs);
			}
			Db::commit();
			return json_encode($rs);
		} catch (\Exception $e) {
			Db::rollback();
			$rs = ["status" => "error", "msg" => "网络不稳定，请重试！" . $e->getMessage()];
			return json_encode($rs);
		}
	}
	public function do_pay()
	{
		$data = input("param.");
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
		define("APPID", $getConfig["app_id"]);
		define("MCHID", $getConfig["app_mchid"]);
		define("KEY", $getConfig["app_key"]);
		define("APPSECRET", $getConfig["app_secret"]);
		$design = Db::name("design")->where("much_id", $data["much_id"])->find();
		$msg = "充值" . substr(sprintf("%.3f", $data["money"]), 0, -1) . $design["currency"];
		return $this->pay($data, $getConfig, $msg, substr(sprintf("%.3f", $data["money"]), 0, -1));
	}
	public function pay($data, $getConfig, $msg, $money)
	{
		$order_no = time() . rand(10000, 999999);
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($msg);
		$input->SetOut_trade_no($order_no);
		$input->SetTotal_fee($money * 100);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($data["openid"]);
		$input->SetNotify_url($getConfig["pay_react"]);
		$order = \WxPayApi::unifiedOrder($input);
		header("Content-Type: application/json");
		$order["app_info"] = $getConfig;
		Db::name("user_serial")->insert(["add_time" => time(), "money" => $money, "user_id" => $data["uid"], "single_mark" => $order_no, "much_id" => $data["much_id"]]);
		return json_encode($order);
	}
}