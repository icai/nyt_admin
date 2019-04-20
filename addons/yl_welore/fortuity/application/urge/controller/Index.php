<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use app\common\Tension;
use think\Cache;
use think\Db;
class Index extends Base
{
	public function index()
	{
		self::issue();
		$new_user_today = Db::name("user")->where("uvirtual", 0)->where("much_id", $this->much_id)->whereTime("user_reg_time", "today")->count();
		$this->assign("new_user_today", $new_user_today);
		$new_toryon_today = Db::name("territory_petition")->where("much_id", $this->much_id)->whereTime("found_lasting", "today")->count();
		$this->assign("new_toryon_today", $new_toryon_today);
		$new_paper_today = Db::name("paper")->where("much_id", $this->much_id)->where("whether_delete", 0)->whereTime("adapter_time", "today")->count();
		$this->assign("new_paper_today", $new_paper_today);
		$new_punch_today = Db::name("user_punch")->where("much_id", $this->much_id)->whereTime("punch_time", "today")->count();
		$this->assign("new_punch_today", $new_punch_today);
		$new_sorder_today = Db::name("shop_order")->where("much_id", $this->much_id)->whereTime("buy_time", "today")->count();
		$this->assign("new_sorder_today", $new_sorder_today);
		$new_userial_today = Db::name("user_serial")->where("much_id", $this->much_id)->where("status", 1)->whereTime("add_time", "today")->sum("pay_money");
		$this->assign("new_userial_today", $new_userial_today);
		$new_subsicont_today = Db::name("user_subsidy")->where("much_id", $this->much_id)->whereTime("bute_time", "today")->sum("bute_price");
		$this->assign("new_subsicont_today", $new_subsicont_today);
		$new_subsidy_today = Db::name("user_subsidy")->where("much_id", $this->much_id)->whereTime("bute_time", "today")->field("sum(bute_price * (1 - allow_scale)) as deduction")->find();
		$this->assign("new_subsidy_today", number_format($new_subsidy_today["deduction"], 2));
		$large_user = Db::name("paper")->alias("per")->join("user us", "us.id=per.user_id", "left")->where("per.much_id", $this->much_id)->where("per.whether_delete", 0)->where("us.uvirtual", 0)->whereTime("per.adapter_time", "week")->field("us.user_nick_name, us.user_head_sculpture ,us.user_wechat_open_id , per.user_id, count(per.user_id) as hasty")->group("per.user_id")->order("hasty", "desc")->limit(6)->select();
		$large_total = 0;
		foreach ($large_user as $key => $value) {
			$large_total += (int) $large_user[$key]["hasty"];
		}
		foreach ($large_user as $key => $value) {
			$large_user[$key]["percentage"] = round((int) $large_user[$key]["hasty"] / $large_total / 0.01, 2);
		}
		$this->assign("large_total", $large_total);
		$this->assign("large_user", $large_user);
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		Tension::otherwise();
		$tension = new Tension();
		$astounding = $tension->astounding();
		$this->assign("astounding", $astounding["rand_code"]);
		return $this->fetch();
	}
	public function userCount()
	{
		$data = [];
		$sigma = date("t");
		$first_day = date("Y-m", time());
		$i = 1;
		while ($i <= $sigma) {
			$data[] = Db::name("user")->where("uvirtual", 0)->where("much_id", $this->much_id)->whereTime("user_reg_time", "between", [$first_day . "-" . $i, $first_day . "-" . $i . " 23:59:59"])->count();
			$i++;
		}
		return $data;
	}
	private function issue()
	{
		$version = Db::name("version")->where("sign_code", "1.0.23")->where("much_id", $this->much_id)->find();
		if (!$version) {
			Db::name("version")->insert(["sign_code" => "1.0.23", "status" => 0, "much_id" => $this->much_id]);
		}
	}
	public function awake()
	{
		if (request()->isPost() && request()->isAjax()) {
			$uetype = request()->post("uetype");
			if ($uetype == 0) {
				Db::startTrans();
				try {
					Db::name("prompt_msg")->where("type", 0)->where("much_id", $this->much_id)->update(["status" => 1]);
					$notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $this->much_id)->count("*");
					cache("notices_" . $this->much_id, $notices);
					$vacants = Db::name("prompt_msg")->where("status", 0)->where("type", 1)->where("much_id", $this->much_id)->count("*");
					cache("vacants_" . $this->much_id, $vacants);
					Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->update(["barg" => $notices + $vacants]);
					$result = true;
					Db::commit();
				} catch (\Exception $e) {
					$result = false;
					Db::rollback();
				}
				if ($result !== false) {
					return json(["code" => 1, "msg" => "全部标为已读成功"]);
				} else {
					return json(["code" => 0, "msg" => "全部标为已读失败"]);
				}
			} else {
				$usid = request()->post("usid");
				Db::startTrans();
				try {
					if ($uetype == 1) {
						Db::name("prompt_msg")->where("id", $usid)->where("type", 0)->where("much_id", $this->much_id)->update(["status" => 1]);
					} else {
						if ($uetype == 2) {
							Db::name("prompt_msg")->where("id", $usid)->where("type", 0)->where("much_id", $this->much_id)->delete();
						}
					}
					$notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $this->much_id)->count("*");
					cache("notices_" . $this->much_id, $notices);
					$vacants = Db::name("prompt_msg")->where("status", 0)->where("type", 1)->where("much_id", $this->much_id)->count("*");
					cache("vacants_" . $this->much_id, $vacants);
					Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->update(["barg" => $notices + $vacants]);
					$result = true;
					Db::commit();
				} catch (\Exception $e) {
					$result = false;
					Db::rollback();
				}
				if ($result !== false) {
					return json(["code" => 1, "msg" => $uetype == 1 ? "标为已读成功" : "删除提醒成功"]);
				} else {
					return json(["code" => 0, "msg" => $uetype == 1 ? "标为已读失败" : "删除提醒失败"]);
				}
			}
		}
		$url = request()->query();
		$url = explode("=/", $url);
		$url = explode("&", $url[1]);
		$url = "/" . $url[0];
		$list = Db::name("prompt_msg")->where("type", 0)->where("much_id", $this->much_id)->order("msg_time", "desc")->paginate(10, false, ["query" => ["s" => $url]]);
		$this->assign("list", $list);
		return $this->fetch();
	}
	public function message()
	{
		if (request()->isPost() && request()->isAjax()) {
			$uetype = request()->post("uetype");
			if ($uetype == 0) {
				Db::startTrans();
				try {
					Db::name("prompt_msg")->where("type", 1)->where("much_id", $this->much_id)->update(["status" => 1]);
					$notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $this->much_id)->count("*");
					cache("notices_" . $this->much_id, $notices);
					$vacants = Db::name("prompt_msg")->where("status", 0)->where("type", 1)->where("much_id", $this->much_id)->count("*");
					cache("vacants_" . $this->much_id, $vacants);
					Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->update(["barg" => $notices + $vacants]);
					$result = true;
					Db::commit();
				} catch (\Exception $e) {
					$result = false;
					Db::rollback();
				}
				if ($result !== false) {
					return json(["code" => 1, "msg" => "全部标为已读成功"]);
				} else {
					return json(["code" => 0, "msg" => "全部标为已读失败"]);
				}
			} else {
				$usid = request()->post("usid");
				Db::startTrans();
				try {
					if ($uetype == 1) {
						Db::name("prompt_msg")->where("id", $usid)->where("type", 1)->where("much_id", $this->much_id)->update(["status" => 1]);
					} else {
						if ($uetype == 2) {
							Db::name("prompt_msg")->where("id", $usid)->where("type", 1)->where("much_id", $this->much_id)->delete();
						}
					}
					$notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $this->much_id)->count("*");
					cache("notices_" . $this->much_id, $notices);
					$vacants = Db::name("prompt_msg")->where("status", 0)->where("type", 1)->where("much_id", $this->much_id)->count("*");
					cache("vacants_" . $this->much_id, $vacants);
					Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->update(["barg" => $notices + $vacants]);
					$result = true;
					Db::commit();
				} catch (\Exception $e) {
					$result = false;
					Db::rollback();
				}
				if ($result !== false) {
					return json(["code" => 1, "msg" => $uetype == 1 ? "标为已读成功" : "删除消息成功"]);
				} else {
					return json(["code" => 0, "msg" => $uetype == 1 ? "标为已读失败" : "删除消息失败"]);
				}
			}
		}
		$url = request()->query();
		$url = explode("=/", $url);
		$url = explode("&", $url[1]);
		$url = "/" . $url[0];
		$list = Db::name("prompt_msg")->where("type", 1)->where("much_id", $this->much_id)->order("msg_time", "desc")->paginate(10, false, ["query" => ["s" => $url]]);
		$this->assign("list", $list);
		return $this->fetch();
	}
	public function logout()
	{
		$this->M = null;
		$this->much = null;
		$this->much_id = null;
		unset($_SESSION["make_variable"]);
		$keySymbol = "addons" . DS . "yl_welore" . DS . "web" . DS . "index.php";
		$pathLeft = explode($keySymbol, $_SERVER["SCRIPT_NAME"]);
		$pathRight = "web/index.php?c=home&a=welcome&do=platform&";
		$absPath = $pathLeft[0] . $pathRight;
		return $this->redirect($absPath);
	}
	public function purgeCache()
	{
		$pathLeft = $_SERVER["DOCUMENT_ROOT"];
		$pathRight = explode("web" . DS . "index.php", $_SERVER["SCRIPT_NAME"]);
		$absPath = $pathLeft . $pathRight[0] . "fortuity" . DS . "runtime";
		self::rmdirs($absPath);
		Cache::clear();
		return 1;
	}
	protected function rmdirs($absPath)
	{
		$absPath_arr = scandir($absPath);
		foreach ($absPath_arr as $key => $val) {
			if ($val != "." && $val != "..") {
				if (is_dir($absPath . DS . $val)) {
					if (@rmdir($absPath . DS . $val) != "true") {
						self::rmdirs($absPath . DS . $val);
					}
				} else {
					unlink($absPath . DS . $val);
				}
			}
		}
	}
}