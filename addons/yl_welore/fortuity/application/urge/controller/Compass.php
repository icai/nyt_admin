<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use app\api\service\TmplService;
use think\Db;
class Compass extends Base
{
	private function defaultQuery()
	{
		$urlFirst = request()->query();
		$urlSecond = explode("=/", $urlFirst);
		$urlThird = explode("&", $urlSecond[1]);
		$url = "/" . $urlThird[0];
		return $url;
	}
	public function nav()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		if ($hazy_name) {
			$list = Db::name("needle")->where("name", "like", "{$hazy_name}%")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("needle")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url]]);
		}
		$this->assign("list", $list);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function slue()
	{
		if (request()->isPost() && request()->isAjax()) {
			$syid = request()->post("asyId");
			$scores = request()->post("dalue");
			$result = Db::name("needle")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
	}
	public function rulnav()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$navData = Db::name("needle")->where("name", $data["name"])->where("much_id", $this->much_id)->find();
			if (empty($navData) || !isset($navData)) {
				$data["much_id"] = $this->much_id;
				$result = Db::name("needle")->insert($data);
				if ($result !== false) {
					return json(["code" => 1, "msg" => "保存成功"]);
				} else {
					return json(["code" => 0, "msg" => "保存失败"]);
				}
			} else {
				return json(["code" => 0, "msg" => "保存失败，广场名已存在"]);
			}
		}
		return $this->fetch();
	}
	public function uplnav()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$suplid = $data["uplid"];
			$navData = Db::name("needle")->where("name", $data["name"])->where("id", "<>", $suplid)->where("much_id", $this->much_id)->find();
			if (empty($navData) || !isset($navData)) {
				unset($data["uplid"]);
				$result = Db::name("needle")->where("id", $suplid)->where("much_id", $this->much_id)->update($data);
				if ($result !== false) {
					return json(["code" => 1, "msg" => "保存成功"]);
				} else {
					return json(["code" => 0, "msg" => "保存失败"]);
				}
			} else {
				return json(["code" => 0, "msg" => "保存失败，广场名已存在"]);
			}
		}
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$navList = Db::name("needle")->where("id", $uplid)->where("much_id", $this->much_id)->find();
			if ($navList) {
				$this->assign("list", $navList);
				return $this->fetch();
			} else {
				return $this->redirect("nav");
			}
		} else {
			return $this->redirect("nav");
		}
	}
	public function navlint()
	{
		if (request()->isPost() && request()->isAjax()) {
			$ecid = request()->post("ecid");
			$tory = Db::name("territory")->where("needle_id", $ecid)->where("much_id", $this->much_id)->find();
			if ($tory) {
				return json(["code" => 0, "msg" => "删除失败，当前广场下存在绑定的圈子"]);
			}
			Db::startTrans();
			try {
				Db::name("needle")->where("id", $ecid)->where("much_id", $this->much_id)->delete();
				Db::name("territory_petition")->where("needle_id", $ecid)->where("much_id", $this->much_id)->delete();
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "删除成功"]);
			} else {
				return json(["code" => 0, "msg" => "删除失败"]);
			}
		}
	}
	public function fence()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		if ($hazy_name) {
			$list = Db::name("territory")->alias("tory")->join("needle ne", "tory.needle_id=ne.id", "left")->where("tory.realm_name|ne.name", "like", "{$hazy_name}%")->where("tory.much_id", $this->much_id)->order("tory.scores asc,tory.id desc")->field("tory.id,\ttory.realm_icon,tory.realm_name,ne.name,tory.concern,tory.status,tory.scores,tory.rising_time")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("territory")->alias("tory")->join("needle ne", "tory.needle_id=ne.id", "left")->where("tory.much_id", $this->much_id)->order("tory.scores asc,tory.id desc")->field("tory.id,\ttory.realm_icon,tory.realm_name,ne.name,tory.concern,tory.status,tory.scores,tory.rising_time")->paginate(10, false, ["query" => ["s" => $url]]);
		}
		$this->assign("list", $list);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function utsun()
	{
		if (request()->isPost() && request()->isAjax()) {
			$syid = request()->post("asyId");
			$scores = request()->post("dalue");
			$result = Db::name("territory")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
	}
	public function rulfence()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["realm_name"] = request()->post("name");
			$fenceData = Db::name("territory")->where("realm_name", $data["realm_name"])->where("much_id", $this->much_id)->find();
			if (empty($fenceData) || !isset($fenceData)) {
				$data["realm_icon"] = request()->post("sngimg");
				$data["needle_id"] = request()->post("needle_id");
				$data["realm_synopsis"] = request()->post("intro");
				$data["attention"] = request()->post("attention");
				$data["atence"] = request()->post("atence");
				$data["atcipher"] = request()->post("atcipher");
				$data["status"] = request()->post("status");
				$data["concern"] = request()->post("concern");
				$data["scores"] = request()->post("scores");
				$data["rising_time"] = time();
				$data["much_id"] = $this->much_id;
				$result = Db::name("territory")->insert($data);
				if ($result !== false) {
					return json(["code" => 1, "msg" => "保存成功"]);
				} else {
					return json(["code" => 0, "msg" => "保存失败"]);
				}
			} else {
				return json(["code" => 0, "msg" => "保存失败，圈子名称已存在"]);
			}
		}
		$needleList = Db::name("needle")->where("much_id", $this->much_id)->order("scores")->select();
		$this->assign("needleList", $needleList);
		return $this->fetch();
	}
	public function uplfence()
	{
		if (request()->isPost() && request()->isAjax()) {
			$suplid = request()->post("uplid");
			$data["realm_name"] = request()->post("name");
			$data["realm_icon"] = request()->post("sngimg");
			$data["needle_id"] = request()->post("needle_id");
			$data["realm_synopsis"] = request()->post("intro");
			$data["attention"] = request()->post("attention");
			$data["atence"] = request()->post("atence");
			$data["atcipher"] = request()->post("atcipher");
			$data["status"] = request()->post("status");
			$data["concern"] = request()->post("concern");
			$data["scores"] = request()->post("scores");
			$tory = db("territory")->where("id", "<>", $suplid)->where("realm_name", $data["realm_name"])->where("much_id", $this->much_id)->find();
			if ($tory) {
				return json(["code" => 0, "msg" => "保存失败，圈子名称已存在"]);
			}
			$result = Db::name("territory")->where("id", $suplid)->where("much_id", $this->much_id)->update($data);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$navList = Db::name("territory")->where("id", $uplid)->where("much_id", $this->much_id)->find();
			if ($navList) {
				$needleList = Db::name("needle")->where("much_id", $this->much_id)->order("scores")->select();
				$this->assign("list", $navList);
				$this->assign("needleList", $needleList);
				return $this->fetch();
			} else {
				return $this->redirect("fence");
			}
		} else {
			return $this->redirect("fence");
		}
	}
	public function getOpenId()
	{
		if (request()->isGet() && request()->isAjax()) {
			$openid = request()->get("openid");
			$data = Db::name("user")->where("uvirtual", 0)->where("user_wechat_open_id", $openid)->where("much_id", $this->much_id)->field("user_nick_name,user_head_sculpture")->find();
			if ($data) {
				return json(["name" => subtext(emoji_decode($data["user_nick_name"]), 20), "userhead" => $data["user_head_sculpture"]]);
			} else {
				return json(["name" => '']);
			}
		}
	}
	public function solicit()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", '');
		$where = ["tep.realm_name|us.user_nick_name" => ["like", "%{$hazy_name}%"], "tep.realm_status" => $hazy_egon, "tep.much_id" => $this->much_id];
		$inquire = ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name];
		if (!$hazy_name) {
			unset($where["tep.realm_name|us.user_nick_name"]);
			unset($inquire["hazy_name"]);
		}
		if (!is_numeric($where["tep.realm_status"])) {
			unset($where["tep.realm_status"]);
			unset($inquire["egon"]);
		}
		$list = Db::name("territory_petition")->alias("tep")->join("needle ne", "tep.needle_id=ne.id")->join("user us", "tep.user_id=us.id", "left")->where($where)->field("tep.id,tep.realm_name,ne.name,us.user_nick_name,us.user_wechat_open_id,tep.solicit_rate,tep.realm_status,tep.found_lasting,tep.review_lasting")->order("tep.found_lasting")->paginate(10, false, ["query" => $inquire]);
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function aspsolicit()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["uplid"] = request()->post("uplid");
			$data["pical"] = request()->post("pical");
			if ($data["pical"] == 1) {
				$topn = Db::name("territory_petition")->where("id", $data["uplid"])->where("much_id", $this->much_id)->find();
				$setory = Db::name("territory")->where("realm_name", $topn["realm_name"])->where("much_id", $this->much_id)->find();
				if ($setory) {
					Db::startTrans();
					try {
						Db::name("territory_petition")->where("id", $data["uplid"])->where("much_id", $this->much_id)->update(["realm_status" => 4, "review_lasting" => time()]);
						Db::name("user_smail")->insert(["user_id" => $topn["user_id"], "maring" => "很抱歉，圈子{$topn["realm_name"]}已存在！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
						Db::commit();
						return json(["code" => 0, "msg" => "数据异常，该圈子已经存在"]);
					} catch (\Exception $e) {
						Db::rollback();
						return json(["code" => 0, "msg" => "数据异常"]);
					}
				}
				if ($topn["is_gnaw_qulord"] == 1) {
					$user = Db::name("user")->where("uvirtual", 0)->where("id", $topn["user_id"])->where("much_id", $this->much_id)->find();
					$getLear["bulord"] = "['{$user["user_wechat_open_id"]}']";
				}
				$tory["realm_icon"] = $topn["realm_icon"];
				$tory["realm_name"] = $topn["realm_name"];
				$tory["needle_id"] = $topn["needle_id"];
				$tory["realm_synopsis"] = $topn["realm_synopsis"];
				$tory["attention"] = $topn["attention"];
				$tory["status"] = 0;
				$tory["concern"] = 0;
				$tory["scores"] = 0;
				$tory["rising_time"] = time();
				$tory["much_id"] = $this->much_id;
				Db::startTrans();
				try {
					$estory = Db::name("territory")->insertGetId($tory);
					if ($topn["is_gnaw_qulord"] == 1) {
						$getLear["tory_id"] = $estory;
						$getLear["much_id"] = $this->much_id;
						Db::name("territory_learned")->insert($getLear);
						Db::name("user_trailing")->insert(["user_id" => $user["id"], "tory_id" => $estory, "ling_time" => time(), "much_id" => $this->much_id]);
						Db::name("territory")->where("id", $estory)->where("much_id", $this->much_id)->setInc("concern", 1);
					}
					Db::name("territory_petition")->where("id", $data["uplid"])->where("much_id", $this->much_id)->update(["realm_status" => $data["pical"], "review_lasting" => time()]);
					Db::name("user_smail")->insert(["user_id" => $topn["user_id"], "maring" => "恭喜您，圈子{$topn["realm_name"]}申请已经通过审核！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					Db::commit();
					return json(["code" => 1, "msg" => "操作成功"]);
				} catch (\Exception $e) {
					Db::rollback();
					return json(["code" => 0, "msg" => "操作失败"]);
				}
			} else {
				$data["reason"] = request()->post("reason");
				Db::startTrans();
				try {
					Db::name("territory_petition")->where("id", $data["uplid"])->where("much_id", $this->much_id)->update(["realm_status" => $data["pical"], "review_lasting" => time()]);
					$toryTion = Db::name("territory_petition")->where("id", $data["uplid"])->where("much_id", $this->much_id)->find();
					Db::name("user_smail")->insert(["user_id" => $toryTion["user_id"], "maring" => "很抱歉，圈子{$toryTion["realm_name"]}申请已被拒绝！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					$result = true;
					Db::commit();
				} catch (\Exception $e) {
					$result = false;
					Db::rollback();
				}
				if ($result !== false) {
					return json(["code" => 1, "msg" => "操作成功"]);
				} else {
					return json(["code" => 0, "msg" => "操作失败"]);
				}
			}
		}
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$navList = Db::name("territory_petition")->alias("tep")->join("needle ne", "tep.needle_id=ne.id", "left")->join("user us", "tep.user_id=us.id", "left")->where("tep.id", $uplid)->where("tep.much_id", $this->much_id)->field("tep.*,ne.name,us.user_head_sculpture,us.user_nick_name,us.user_wechat_open_id,us.status ustatus")->find();
			if ($navList) {
				$this->assign("list", $navList);
				return $this->fetch();
			} else {
				return $this->redirect("solicit");
			}
		} else {
			return $this->redirect("solicit");
		}
	}
	public function savour()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_bering = request()->get("hazy_bering", '');
		$hazy_egon = request()->get("egon", 0);
		$tory = Db::name("territory")->where("id", $hazy_bering)->where("much_id", $this->much_id)->find();
		if (!$tory) {
			return $this->redirect("compass/fence");
		}
		switch ($hazy_egon) {
			case 0:
				$list = Db::name("territory_interest")->alias("ti")->join("user us", "ti.user_id=us.id", "left")->join("territory tory", "ti.tory_id=tory.id", "left")->where("us.user_nick_name|us.user_wechat_open_id", "like", "%{$hazy_name}%")->where("tory.id", $hazy_bering)->where("ti.much_id", $this->much_id)->order("status", "asc")->order("rest_time", "desc")->order("sult_time", "asc")->field("ti.*,us.user_nick_name,us.user_head_sculpture,us.user_wechat_open_id,tory.realm_name")->paginate(10, false, ["query" => ["s" => $url, "hazy_bering" => $hazy_bering, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 1:
				$list = Db::name("territory_interest")->alias("ti")->join("user us", "ti.user_id=us.id", "left")->join("territory tory", "ti.tory_id=tory.id", "left")->where("us.user_nick_name|us.user_wechat_open_id", "like", "%{$hazy_name}%")->where("tory.id", $hazy_bering)->where("ti.status", 0)->where("ti.much_id", $this->much_id)->order("status", "asc")->order("rest_time", "desc")->order("sult_time", "asc")->field("ti.*,us.user_nick_name,us.user_head_sculpture,us.user_wechat_open_id,tory.realm_name")->paginate(10, false, ["query" => ["s" => $url, "hazy_bering" => $hazy_bering, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 2:
				$list = Db::name("territory_interest")->alias("ti")->join("user us", "ti.user_id=us.id", "left")->join("territory tory", "ti.tory_id=tory.id", "left")->where("us.user_nick_name|us.user_wechat_open_id", "like", "%{$hazy_name}%")->where("tory.id", $hazy_bering)->where("ti.status", 1)->where("ti.much_id", $this->much_id)->order("status", "asc")->order("rest_time", "desc")->order("sult_time", "asc")->field("ti.*,us.user_nick_name,us.user_head_sculpture,us.user_wechat_open_id,tory.realm_name")->paginate(10, false, ["query" => ["s" => $url, "hazy_bering" => $hazy_bering, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 3:
				$list = Db::name("territory_interest")->alias("ti")->join("user us", "ti.user_id=us.id", "left")->join("territory tory", "ti.tory_id=tory.id", "left")->where("us.user_nick_name|us.user_wechat_open_id", "like", "%{$hazy_name}%")->where("tory.id", $hazy_bering)->where("ti.status", 2)->where("ti.much_id", $this->much_id)->order("status", "asc")->order("rest_time", "desc")->order("sult_time", "asc")->field("ti.*,us.user_nick_name,us.user_head_sculpture,us.user_wechat_open_id,tory.realm_name")->paginate(10, false, ["query" => ["s" => $url, "hazy_bering" => $hazy_bering, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
		}
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_bering", $hazy_bering);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function savour_tance()
	{
		if (request()->isGet() && request()->isAjax()) {
			$ecid = request()->get("ecid");
			$inter = Db::name("territory_interest")->where("id", $ecid)->where("much_id", $this->much_id)->find();
			return json(["info" => strip_tags($inter["reason"])]);
		}
	}
	public function arcanum()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["suid"] = request()->post("suid");
			$data["status"] = request()->post("status");
			Db::startTrans();
			try {
				$inter = Db::name("territory_interest")->where("id", $data["suid"])->where("much_id", $this->much_id)->find();
				if ($inter["status"] == 0 && ($data["status"] == 1 || $data["status"] == 2)) {
					Db::name("territory_interest")->where("id", $data["suid"])->where("much_id", $this->much_id)->update(["rest_time" => time(), "status" => $data["status"]]);
					$userTrailing = Db::name("user_trailing")->where("user_id", $inter["user_id"])->where("tory_id", $inter["tory_id"])->where("much_id", $this->much_id)->find();
					$tory = Db::name("territory")->where("id", $inter["tory_id"])->where("much_id", $this->much_id)->find();
					if (!$userTrailing) {
						Db::name("user_trailing")->insert(["user_id" => $inter["user_id"], "tory_id" => $inter["tory_id"], "ling_time" => time(), "much_id" => $this->much_id]);
						Db::name("territory")->where("id", $inter["tory_id"])->where("much_id", $this->much_id)->setInc("concern", 1);
					} else {
						if ($data["status"] == 2) {
							Db::name("user_trailing")->where("user_id", $inter["user_id"])->where("tory_id", $inter["tory_id"])->where("much_id", $this->much_id)->delete();
							Db::name("territory")->where("id", $inter["tory_id"])->where("much_id", $this->much_id)->setDec("concern", 1);
						}
					}
					$defaultNavigate = self::defaultNavigate();
					Db::name("user_smail")->insert(["user_id" => $inter["user_id"], "maring" => $data["status"] == 1 ? "您申请关注的{$defaultNavigate["landgrave"]}《{$tory["realm_name"]}》已通过审核！" : "您申请关注的{$defaultNavigate["landgrave"]}《{$tory["realm_name"]}》已被拒绝！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					$merger = ["much_id" => $this->much_id, "user_id" => $inter["user_id"], "at_id" => "AT0330", "page" => "yl_welore/pages/packageA/circle_info/index?id=" . $tory["id"], "keyword1" => "申请加入: {$tory["realm_name"]}", "keyword2" => $data["status"] == 1 ? "申请通过" : "申请拒绝", "keyword3" => date("Y年m月d日 H:i:s", time())];
					$templet = new TmplService();
					$templet->add_template($merger);
					$result = true;
					Db::commit();
				} else {
					$result = false;
					Db::rollback();
				}
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "操作成功"]);
			} else {
				return json(["code" => 1, "msg" => "操作失败"]);
			}
		}
	}
	public function savour_link()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["suid"] = request()->post("suid");
			Db::startTrans();
			try {
				Db::name("territory_interest")->where("id", $data["suid"])->where("much_id", $this->much_id)->delete();
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "删除成功"]);
			} else {
				return json(["code" => 1, "msg" => "删除失败"]);
			}
		}
	}
	public function sminor()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$toryId = $data["toryid"];
			$ublord = json_encode($data["bulord"], 320);
			$bulord = $ublord != "null" ? $ublord : null;
			$getLear = self::tangled($toryId);
			Db::startTrans();
			try {
				if ($data["bulord"]) {
					foreach ($data["bulord"] as $key => $value) {
						$userInfo = Db::name("user")->where("user_wechat_open_id", $value)->where("much_id", $this->much_id)->find();
						$utr = Db::name("user_trailing")->where("user_id", $userInfo["id"])->where("tory_id", $toryId)->where("much_id", $this->much_id)->find();
						if (!$utr) {
							Db::name("user_trailing")->insert(["user_id" => $userInfo["id"], "tory_id" => $toryId, "ling_time" => time(), "much_id" => $this->much_id]);
						}
					}
				}
				Db::name("territory_learned")->where("id", $getLear["id"])->where("tory_id", $toryId)->where("much_id", $this->much_id)->update(["snvite_bulord" => null, "bulord" => $bulord]);
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
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$learList = Db::name("territory")->alias("tory")->join("territory_learned lear", "lear.tory_id=tory.id", "left")->where("tory.id", $uplid)->where("tory.much_id", $this->much_id)->field("tory.realm_name,lear.snvite_bulord,lear.bulord")->find();
			$bulord = json_decode($learList["bulord"], true);
			$bulord = array_unique($bulord);
			$learList["bulord"] = [];
			foreach ($bulord as $key => $value) {
				$learList["bulord"][$key]["openid"] = $value;
				$bulordUser = Db::name("user")->where("uvirtual", 0)->where("user_wechat_open_id", $value)->where("much_id", $this->much_id)->field("user_nick_name,user_head_sculpture")->find();
				$learList["bulord"][$key]["username"] = $bulordUser["user_nick_name"];
				$learList["bulord"][$key]["userhead"] = $bulordUser["user_head_sculpture"];
			}
			$snvite_bulord = json_decode($learList["snvite_bulord"], true);
			$learList["snvite_bulord"] = [];
			foreach ($snvite_bulord as $key => $value) {
				$learList["snvite_bulord"][$key]["openid"] = $value["openid"];
				$learList["snvite_bulord"][$key]["upshot"] = $value["upshot"];
				$learUser = Db::name("user")->where("uvirtual", 0)->where("user_wechat_open_id", $value["openid"])->where("much_id", $this->much_id)->field("user_nick_name,user_head_sculpture")->find();
				$learList["snvite_bulord"][$key]["username"] = $learUser["user_nick_name"];
				$learList["snvite_bulord"][$key]["userhead"] = $learUser["user_head_sculpture"];
			}
			$learList["tory_id"] = $uplid;
			$this->assign("list", $learList);
			return $this->fetch();
		} else {
			return $this->redirect("compass/fence");
		}
	}
	public function pinhead()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$toryId = $data["toryid"];
			$uslord = json_encode($data["sulord"], 320);
			$sulord = $uslord != "null" ? $uslord : null;
			$getLear = self::tangled($toryId);
			Db::startTrans();
			try {
				if ($data["sulord"]) {
					foreach ($data["sulord"] as $key => $value) {
						$userInfo = Db::name("user")->where("user_wechat_open_id", $value)->where("much_id", $this->much_id)->find();
						$utr = Db::name("user_trailing")->where("user_id", $userInfo["id"])->where("tory_id", $toryId)->where("much_id", $this->much_id)->find();
						if (!$utr) {
							Db::name("user_trailing")->insert(["user_id" => $userInfo["id"], "tory_id" => $toryId, "ling_time" => time(), "much_id" => $this->much_id]);
						}
					}
				}
				Db::name("territory_learned")->where("id", $getLear["id"])->where("tory_id", $toryId)->where("much_id", $this->much_id)->update(["envite_sulord" => null, "sulord" => $sulord]);
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
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$learList = Db::name("territory")->alias("tory")->join("territory_learned lear", "lear.tory_id=tory.id", "left")->where("tory.id", $uplid)->where("tory.much_id", $this->much_id)->field("tory.realm_name,lear.envite_sulord,lear.sulord")->find();
			$sulord = json_decode($learList["sulord"], true);
			$sulord = array_unique($sulord);
			$learList["sulord"] = [];
			foreach ($sulord as $key => $value) {
				$learList["sulord"][$key]["openid"] = $value;
				$bulordUser = Db::name("user")->where("uvirtual", 0)->where("user_wechat_open_id", $value)->where("much_id", $this->much_id)->field("user_nick_name,user_head_sculpture")->find();
				$learList["sulord"][$key]["username"] = $bulordUser["user_nick_name"];
				$learList["sulord"][$key]["userhead"] = $bulordUser["user_head_sculpture"];
			}
			$envite_sulord = json_decode($learList["envite_sulord"], true);
			$learList["envite_sulord"] = [];
			foreach ($envite_sulord as $key => $value) {
				$learList["envite_sulord"][$key]["openid"] = $value["openid"];
				$learList["envite_sulord"][$key]["upshot"] = $value["upshot"];
				$learUser = Db::name("user")->where("uvirtual", 0)->where("user_wechat_open_id", $value["openid"])->where("much_id", $this->much_id)->field("user_nick_name,user_head_sculpture")->find();
				$learList["envite_sulord"][$key]["username"] = $learUser["user_nick_name"];
				$learList["envite_sulord"][$key]["username"] = $learUser["user_head_sculpture"];
			}
			$learList["tory_id"] = $uplid;
			$this->assign("list", $learList);
			return $this->fetch();
		} else {
			return $this->redirect("compass/fence");
		}
	}
	protected function tangled($toryId)
	{
		$getLear = Db::name("territory_learned")->where("tory_id", $toryId)->where("much_id", $this->much_id)->find();
		if (!$getLear) {
			$getLear = ["tory_id" => $toryId, "much_id" => $this->much_id];
			$getLear["id"] = Db::name("territory_learned")->insertGetId($getLear);
		}
		return $getLear;
	}
	public function citlint()
	{
		if (request()->isPost() && request()->isAjax()) {
			$ecid = request()->post("ecid");
			Db::startTrans();
			try {
				Db::name("territory_petition")->where("id", $ecid)->where("much_id", $this->much_id)->delete();
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "删除成功"]);
			} else {
				return json(["code" => 0, "msg" => "删除失败"]);
			}
		}
	}
	public function topping()
	{
		if (request()->isPost() && request()->isAjax()) {
			$prid = request()->post("prid");
			Db::startTrans();
			try {
				Db::name("paper")->where("id", $prid)->where("much_id", $this->much_id)->update(["topping_time" => 0]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				Db::rollback();
				return json(["code" => 0, "msg" => "error , " . $e->getMessage()]);
			}
			if ($result === true) {
				return json(["code" => 1, "msg" => "取消置顶成功"]);
			}
		}
		$url = self::defaultQuery();
		$toryId = request()->get("tory_id", '');
		if ($toryId) {
			$getTory = Db::name("territory")->where("id", $toryId)->where("much_id", $this->much_id)->find();
			if ($getTory) {
				$this->assign("realmName", $getTory["realm_name"]);
				$hazy_name = request()->get("hazy_name", '');
				if ($hazy_name) {
					$list = Db::name("paper")->alias("per")->join("user us", "per.user_id=us.id", "left")->where("per.study_title|per.study_content", "like", "%{$hazy_name}%")->where("per.tory_id", $getTory["id"])->where("per.topping_time", "<>", 0)->where("per.whether_delete", 0)->where("per.much_id", $this->much_id)->where("us.uvirtual", 0)->order("per.topping_time", "asc")->field("per.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "tory_id" => $toryId, "hazy_name" => $hazy_name]]);
				} else {
					$list = Db::name("paper")->alias("per")->join("user us", "per.user_id=us.id", "left")->where("per.tory_id", $getTory["id"])->where("per.topping_time", "<>", 0)->where("per.whether_delete", 0)->where("per.much_id", $this->much_id)->where("us.uvirtual", 0)->order("per.topping_time", "asc")->field("per.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "tory_id" => $toryId]]);
				}
				$this->assign("list", $list);
				$this->assign("hazy_name", $hazy_name);
				$this->assign("tory_id", $toryId);
				$page = request()->get("page", 1);
				$this->assign("page", $page);
				return $this->fetch();
			} else {
				return $this->redirect("compass/fence");
			}
		} else {
			return $this->redirect("compass/fence");
		}
	}
}