<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use app\api\service\WxCompany;
use think\Db;
class Rawls extends Base
{
	private function defaultQuery()
	{
		$urlFirst = request()->query();
		$urlSecond = explode("=/", $urlFirst);
		$urlThird = explode("&", $urlSecond[1]);
		$url = "/" . $urlThird[0];
		return $url;
	}
	public function setting()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["open_withdrawals"] = request()->post("openWithdrawals");
			$data["open_offline_payment"] = request()->post("openOfflinePayment");
			$data["auto_review_payment"] = request()->post("autoReviewPayment");
			$data["lowest_money"] = request()->post("lowestMoney", 1);
			$data["payment_tariff"] = request()->post("paymentTariff", 0) * 0.01;
			$data["notice"] = request()->post("notice");
			Db::startTrans();
			try {
				db("raws_setting")->where("much_id", $this->much_id)->update($data);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		$rwasList = self::defaultRawsSetting();
		$this->assign("list", $rwasList);
		return $this->fetch();
	}
	private function defaultRawsSetting()
	{
		$defaultRawsSetting = db("raws_setting")->where("much_id", $this->much_id)->find();
		if (!$defaultRawsSetting) {
			$defaultRawsSetting = ["open_withdrawals" => 0, "open_offline_payment" => 0, "auto_review_payment" => 0, "payment_tariff" => 0, "lowest_money" => 1, "much_id" => $this->much_id];
			Db::startTrans();
			try {
				$defaultRawsSetting["id"] = db("raws_setting")->insertGetId($defaultRawsSetting);
				Db::commit();
			} catch (\Exception $e) {
				Db::rollback();
			}
		}
		return $defaultRawsSetting;
	}
	public function stand()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", 0);
		switch ($hazy_egon) {
			case 0:
				$list = Db::name("user_withdraw_money")->alias("uwm")->join("user us", "uwm.user_id=us.id", "left")->where("us.user_nick_name", "like", "%{$hazy_name}%")->where("uwm.much_id", $this->much_id)->order("status", "asc")->order("uwm.seek_time", "asc")->field("uwm.*,us.user_nick_name")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 1:
				$list = Db::name("user_withdraw_money")->alias("uwm")->join("user us", "uwm.user_id=us.id", "left")->where("us.user_nick_name", "like", "%{$hazy_name}%")->where("uwm.status", 0)->where("uwm.much_id", $this->much_id)->order("status", "asc")->order("uwm.seek_time", "asc")->field("uwm.*,us.user_nick_name")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 2:
				$list = Db::name("user_withdraw_money")->alias("uwm")->join("user us", "uwm.user_id=us.id", "left")->where("us.user_nick_name", "like", "%{$hazy_name}%")->where("uwm.status", 1)->where("uwm.much_id", $this->much_id)->order("status", "asc")->order("uwm.seek_time", "asc")->field("uwm.*,us.user_nick_name")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 3:
				$list = Db::name("user_withdraw_money")->alias("uwm")->join("user us", "uwm.user_id=us.id", "left")->where("us.user_nick_name", "like", "%{$hazy_name}%")->where("uwm.status", 2)->where("uwm.much_id", $this->much_id)->order("status", "asc")->order("uwm.seek_time", "asc")->field("uwm.*,us.user_nick_name")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
		}
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function austive()
	{
		$defaultNavigate = self::defaultNavigate();
		if (request()->isPost() && request()->isAjax()) {
			$suid = request()->post("suid");
			$thesis = request()->post("thesis");
			if ($thesis == 1) {
				Db::startTrans();
				try {
					$uwmInfo = db("user_withdraw_money")->where("id", $suid)->where("much_id", $this->much_id)->find();
					if ($uwmInfo["status"] == 0) {
						$userInfo = db("user")->where("id", $uwmInfo["user_id"])->where("much_id", $this->much_id)->find();
						$wxcom = new WxCompany();
						$company = $wxcom->companyToPocket($userInfo["user_wechat_open_id"], $uwmInfo["actual_amount"], '', "提现", '', $this->much_id);
						if ($company["status"] == 0) {
							db("user_withdraw_money")->where("id", $suid)->where("much_id", $this->much_id)->update(["status" => 1, "verify_time" => time()]);
							db("user_smail")->insert(["user_id" => $uwmInfo["user_id"], "maring" => "提现成功，提现资金已付款到您的微信钱包，请注意查收！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
							$result = true;
						} else {
							$result = false;
							$res = $company;
						}
						$apiclientCert = EXTEND_PATH . "Wxpay" . DS . "Cert" . DS . "apiclient_cert_" . $this->much_id . ".pem";
						$apiclientKey = EXTEND_PATH . "Wxpay" . DS . "Cert" . DS . "apiclient_key_" . $this->much_id . ".pem";
						@unlink($apiclientCert);
						@unlink($apiclientKey);
					} else {
						$result = false;
					}
					Db::commit();
				} catch (\Exception $e) {
					Db::rollback();
					return json(["code" => 0, "msg" => "提现失败" . $e->getMessage()]);
				}
				if ($result !== false) {
					return json(["code" => 1, "msg" => "提现成功，资金已付款到用户微信账户上！"]);
				} else {
					if ($res != '') {
						return json(["code" => 0, "msg" => "提现失败，{$res["msg"]}"]);
					} else {
						return json(["code" => 0, "msg" => "提现状态不正确，请刷新页面后重试！"]);
					}
				}
			} else {
				$argument = request()->post("argument");
				Db::startTrans();
				try {
					$uwmInfo = db("user_withdraw_money")->where("id", $suid)->where("much_id", $this->much_id)->find();
					if ($uwmInfo["status"] == 0) {
						db("user_withdraw_money")->where("id", $suid)->where("much_id", $this->much_id)->update(["status" => 2, "verify_time" => time()]);
						$userBefore = db("user")->where("id", $uwmInfo["user_id"])->where("much_id", $this->much_id)->find();
						db("user")->where("id", $uwmInfo["user_id"])->where("much_id", $this->much_id)->setInc("conch", $uwmInfo["display_money"]);
						$userRear = db("user")->where("id", $uwmInfo["user_id"])->where("much_id", $this->much_id)->find();
						db("user_amount")->insert(["user_id" => $uwmInfo["user_id"], "category" => 0, "finance" => $uwmInfo["display_money"], "poem_fraction" => $userBefore["fraction"], "poem_conch" => $userBefore["conch"], "surplus_fraction" => $userRear["fraction"], "surplus_conch" => $userRear["conch"], "ruins_time" => time(), "solution" => "提现失败，返还{$defaultNavigate["currency"]}", "evaluate" => 0, "much_id" => $this->much_id]);
						db("user_smail")->insert(["user_id" => $uwmInfo["user_id"], "maring" => "提现失败，管理员拒绝了您的提现申请，拒绝理由如下：{$argument}", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
						$result = true;
					} else {
						$result = false;
					}
					Db::commit();
				} catch (\Exception $e) {
					Db::rollback();
					return json(["code" => 0, "msg" => "拒绝失败" . $e->getMessage()]);
				}
				if ($result !== false) {
					return json(["code" => 1, "msg" => "拒绝成功，提现时扣除的{$defaultNavigate["currency"]}已返还给用户"]);
				} else {
					return json(["code" => 0, "msg" => "提现状态不正确，请刷新页面后重试！"]);
				}
			}
		}
		$renum = request()->get("renum");
		if ($renum) {
			$getUwm = db("user_withdraw_money")->alias("uwm")->join("user us", "uwm.user_id=us.id", "left")->where("uwm.id", $renum)->where("uwm.much_id", $this->much_id)->field("uwm.*,us.user_head_sculpture,us.user_nick_name,us.gender,us.user_wechat_open_id,us.conch,us.fraction,us.status as uats")->find();
			if ($getUwm) {
				$this->assign("defaultNavigate", $defaultNavigate);
				$this->assign("list", $getUwm);
				return $this->fetch();
			} else {
				return $this->redirect("rawls/stand");
			}
		} else {
			return $this->redirect("rawls/stand");
		}
	}
}