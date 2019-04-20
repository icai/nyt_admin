<?php

//decode by http://www.yunlu99.com/
namespace app\api\controller;

use think\Controller;
use think\Db;
use think\Log;
class Notify extends Controller
{
	public function get_notify()
	{
		$notify_data = input("param.");
		file_put_contents("db2.txt", var_export($notify_data, true));
		$user_serial = Db::name("user_serial")->where("single_mark", $notify_data["out_trade_no"])->find();
		$user_info = Db::name("user")->where("id", $user_serial["user_id"])->find();
		file_put_contents("db.txt", var_export($user_serial, true));
		if ($user_serial["status"] == 1) {
			exit("<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>");
		}
		$data["serial_id"] = $user_serial["id"];
		$data["user_id"] = $user_serial["user_id"];
		$data["category"] = 0;
		$data["finance"] = $user_serial["money"];
		$data["ruins_time"] = time();
		$data["much_id"] = $user_serial["much_id"];
		$design = Db::name("design")->where("much_id", $user_serial["much_id"])->find();
		$data["solution"] = "充值" . $design["currency"];
		$data["poem_fraction"] = $user_info["fraction"];
		$data["poem_conch"] = $user_info["conch"];
		$data["evaluate"] = 0;
		$data["surplus_conch"] = $user_serial["money"] + $user_info["conch"];
		Db::startTrans();
		try {
			$up = Db::name("user_serial")->where("single_mark", $notify_data["out_trade_no"])->update(["status" => 1, "pay_money" => $notify_data["cash_fee"] / 100]);
			if (!$up) {
				Db::rollback();
			}
			$inc = Db::name("user_amount")->insert($data);
			if (!$inc) {
				Db::rollback();
			}
			$bei = Db::name("user")->where("id", $user_serial["user_id"])->setInc("conch", $user_serial["money"]);
			if (!$bei) {
				Db::rollback();
			}
			Db::commit();
		} catch (\Exception $e) {
			Log::write($e->getMessage(), "pay_exc");
			Db::rollback();
		}
		Log::write($notify_data["out_trade_no"] . ",支付状态更改成功", "shop_pay_state_change_success");
		exit("<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>");
	}
}