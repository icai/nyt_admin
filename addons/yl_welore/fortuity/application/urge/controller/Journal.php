<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Db;
class Journal extends Base
{
	private function defaultQuery()
	{
		$urlFirst = request()->query();
		$urlSecond = explode("=/", $urlFirst);
		$urlThird = explode("&", $urlSecond[1]);
		$url = "/" . $urlThird[0];
		return $url;
	}
	public function report()
	{
		if (request()->isGet() && request()->isAjax()) {
			$data = Db::name("paper_complaint")->where("id", request()->get("ksin"))->where("much_id", $this->much_id)->field("tale_content as content")->find();
			if ($data) {
				return json(emoji_decode(strip_tags($data["content"])));
			} else {
				return "error";
			}
		}
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$where = ["us.user_nick_name" => ["like", "%{$hazy_name}%"], "pait.much_id" => $this->much_id];
		$inquire = ["s" => $url, "hazy_name" => $hazy_name];
		if (!$hazy_name) {
			unset($where["us.user_nick_name"]);
			unset($inquire["hazy_name"]);
		}
		$pritList = Db::name("paper_complaint")->alias("pait")->join("territory tory", "pait.tory_id=tory.id", "left")->join("user us", "pait.user_id=us.id", "left")->where($where)->where(function ($query) {
			$query->where("pait.tale_type", 0)->whereOr("pait.tale_type", 1);
		})->order("acceptance_status")->order("transact_time", "desc")->order("petition_time")->field("pait.*,us.user_nick_name,us.user_wechat_open_id,tory.realm_name")->paginate(10, false, ["query" => $inquire])->each(function ($item, $key) {
			if ($item["tale_type"] == 0) {
				$item["satisfy"] = Db::name("paper")->alias("per")->join("user us", "per.user_id=us.id", "left")->where("per.id", $item["paper_id"])->where("per.much_id", $this->much_id)->field("per.*,us.user_nick_name,us.user_wechat_open_id")->find();
			} else {
				if ($item["tale_type"] == 1) {
					$item["satisfy"] = Db::name("paper_reply")->alias("eply")->join("user us", "eply.user_id=us.id", "left")->where("eply.id", $item["prely_id"])->where("eply.much_id", $this->much_id)->field("eply.*,us.user_nick_name,us.user_wechat_open_id")->find();
				}
			}
			return $item;
		});
		$this->assign("list", $pritList);
		return $this->fetch();
	}
	public function adjudic()
	{
		if (request()->isPost() && request()->isAjax()) {
			$sngid = request()->post("sngid");
			$setale = request()->post("setale");
			$nstruct = request()->post("nstruct");
			$sfell = request()->post("sfell");
			$nvgid = request()->post("nvgid");
			$nvame = $setale == 0 ? "paper" : "paper_reply";
			Db::startTrans();
			try {
				$uname = Db::name($nvame)->where("id", $nvgid)->where("much_id", $this->much_id)->find();
				if ($setale == 0) {
					if ($uname["study_title"]) {
						$msguer = $uname["study_title"];
					} else {
						$msguer = "帖子 " . subtext($uname["study_content"], 10) . " ";
					}
				} else {
					$msguer = "回复 " . subtext($uname["reply_content"], 10);
				}
				$pemit = Db::name("paper_complaint")->where("id", $sngid)->where("much_id", $this->much_id)->find();
				if ($sfell == 1) {
					Db::name($nvame)->where("id", $nvgid)->where("much_id", $this->much_id)->update(["whether_type" => 1, "whether_reason" => "用户举报删帖", "whether_delete" => 1, "whetd_time" => time(), "token" => md5(time())]);
					Db::name("user_smail")->insert(["user_id" => $uname["user_id"], "maring" => "您的 {$msguer} 被大量用户投诉，管理员已经进行删帖，请注意您的言行举止！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					if ($setale == 0) {
						$factor = trim("paper_id");
						$prelyId = trim($pemit["paper_id"]);
					} else {
						$factor = trim("prely_id");
						$prelyId = trim($pemit["prely_id"]);
					}
					$pulet = Db::name("paper_complaint")->where($factor, $prelyId)->where("much_id", $this->much_id)->select();
					foreach ($pulet as $key => $value) {
						Db::name("user_smail")->insert(["user_id" => $value["user_id"], "maring" => "您举报的 {$msguer} 已成功，管理员已经进行删帖，感谢您对平台做出的努力与贡献，谢谢！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					}
					Db::name("paper_complaint")->where($factor, $prelyId)->where("much_id", $this->much_id)->update(["acceptance_status" => 1, "transact_time" => time(), "tale_instruct" => $nstruct, "is_strike" => $sfell]);
				} else {
					Db::name("paper_complaint")->where("id", $sngid)->where("much_id", $this->much_id)->update(["acceptance_status" => 1, "transact_time" => time(), "tale_instruct" => $nstruct, "is_strike" => $sfell]);
					Db::name("user_smail")->insert(["user_id" => $pemit["user_id"], "maring" => "很抱歉，您举报的 {$msguer} 失败，举报理由不成立！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
				}
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "处理成功"]);
			} else {
				return json(["code" => 0, "msg" => "处理失败"]);
			}
		} else {
			return $this->redirect("report");
		}
	}
	public function rejudic()
	{
		if (request()->isPost() && request()->isAjax()) {
			$sngid = request()->post("sngid");
			$setale = request()->post("setale");
			$sfell = request()->post("sfell");
			$nvgid = request()->post("nvgid");
			$nvame = $setale == 0 ? "paper" : "paper_reply";
			Db::startTrans();
			try {
				if ($sfell == 1) {
					Db::name($nvame)->where("id", $nvgid)->where("much_id", $this->much_id)->update(["whether_type" => 0, "whether_reason" => null, "whether_delete" => 0, "whetd_time" => null, "token" => null]);
				}
				Db::name("paper_complaint")->where("id", $sngid)->where("much_id", $this->much_id)->update(["acceptance_status" => 0, "transact_time" => null, "tale_instruct" => null, "is_strike" => 0]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "处理成功"]);
			} else {
				return json(["code" => 0, "msg" => "处理失败"]);
			}
		} else {
			return $this->redirect("report");
		}
	}
	public function appeal()
	{
		if (request()->isGet() && request()->isAjax()) {
			$data = Db::name("paper_complaint")->where("id", request()->get("ksin"))->where("much_id", $this->much_id)->field("tale_content as content")->find();
			if ($data) {
				return json(emoji_decode(strip_tags($data["content"])));
			} else {
				return "error";
			}
		}
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$where = ["us.user_nick_name" => ["like", " % {$hazy_name} % "], "pait.much_id" => $this->much_id];
		$inquire = ["s" => $url, "hazy_name" => $hazy_name];
		if (!$hazy_name) {
			unset($where["us.user_nick_name"]);
			unset($inquire["hazy_name"]);
		}
		$pritList = Db::name("paper_complaint")->alias("pait")->join("territory tory", "pait.tory_id=tory.id", "left")->join("user us", "pait.user_id=us.id", "left")->where($where)->where(function ($query) {
			$query->where("pait.tale_type", 2)->whereOr("pait.tale_type", 3);
		})->order("acceptance_status")->order("transact_time", "desc")->order("petition_time")->field("pait.*,us.user_nick_name,tory.realm_name")->paginate(10, false, ["query" => $inquire])->each(function ($item, $key) {
			if ($item["tale_type"] == 2) {
				$item["satisfy"] = Db::name("paper")->where("id", $item["paper_id"])->where("much_id", $this->much_id)->find();
			} else {
				if ($item["tale_type"] == 3) {
					$item["satisfy"] = Db::name("paper_reply")->where("id", $item["prely_id"])->where("much_id", $this->much_id)->find();
				}
			}
			return $item;
		});
		$this->assign("list", $pritList);
		return $this->fetch();
	}
	public function rejupeal()
	{
		if (request()->isPost() && request()->isAjax()) {
			$sngid = request()->post("sngid");
			$setale = request()->post("setale");
			$nstruct = request()->post("nstruct");
			$sfell = request()->post("sfell");
			$nvgid = request()->post("nvgid");
			if ($setale == 2) {
				$nvame = "paper";
			} else {
				$nvame = "paper_reply";
			}
			Db::startTrans();
			try {
				if ($sfell == 0) {
					$pult = Db::name($nvame)->where("id", $nvgid)->where("much_id", $this->much_id)->update(["whether_type" => 0, "whether_reason" => null, "whether_delete" => 0, "whetd_time" => null, "token" => null]);
					if ($pult === false) {
						Db::rollback();
						return json(["code" => 0, "msg" => "处理失败"]);
					}
					if ($setale == 2) {
						$snvame = "paper_id";
						$setale = 0;
					} else {
						$snvame = "prely_id";
						$setale = 1;
					}
					$repall = Db::name("paper_complaint")->where($snvame, $nvgid)->where("tale_type", $setale)->whereNotIn("id", $sngid)->where("much_id", $this->much_id)->delete();
					if ($repall === false) {
						Db::rollback();
						return json(["code" => 0, "msg" => "处理失败"]);
					}
				}
				$result = Db::name("paper_complaint")->where("id", $sngid)->where("much_id", $this->much_id)->update(["acceptance_status" => 1, "transact_time" => time(), "tale_instruct" => $nstruct, "is_strike" => $sfell]);
				if ($result !== false) {
					Db::commit();
					return json(["code" => 1, "msg" => "处理成功"]);
				} else {
					Db::rollback();
					return json(["code" => 0, "msg" => "处理失败"]);
				}
			} catch (\Exception $e) {
				Db::rollback();
				return json(["code" => 0, "msg" => "处理失败"]);
			}
		} else {
			return $this->redirect("report");
		}
	}
	public function spread()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", '');
		$where = ["tory.realm_name|us.user_nick_name" => ["like", "%{$hazy_name}%"], "la.status" => $hazy_egon, "la.ment_type" => 0, "la.much_id" => $this->much_id];
		$inquire = ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name];
		if (!$hazy_name) {
			unset($where["tory.realm_name|us.user_nick_name"]);
			unset($inquire["hazy_name"]);
		}
		if (!is_numeric($where["la.status"])) {
			unset($where["la.status"]);
			unset($inquire["egon"]);
		}
		$list = Db::name("lament")->alias("la")->join("user us", "la.proof_id=us.id", "left")->join("territory tory", "la.tory_id=tory.id", "left")->where($where)->field("la.*,tory.realm_name,us.user_nick_name")->order("la.ment_time")->paginate(10, false, ["query" => $inquire]);
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function safety()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", '');
		$where = ["tory.realm_name|us.user_nick_name" => ["like", "%{$hazy_name}%"], "la.status" => $hazy_egon, "la.ment_type" => 1, "la.much_id" => $this->much_id];
		$inquire = ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name];
		if (!$hazy_name) {
			unset($where["tory.realm_name|us.user_nick_name"]);
			unset($inquire["hazy_name"]);
		}
		if (!is_numeric($where["la.status"])) {
			unset($where["la.status"]);
			unset($inquire["egon"]);
		}
		$list = Db::name("lament")->alias("la")->join("user us", "la.proof_id=us.id", "left")->join("territory tory", "la.tory_id=tory.id", "left")->where($where)->field("la.*,tory.realm_name,us.user_nick_name")->order("la.ment_time")->paginate(10, false, ["query" => $inquire])->each(function ($item, $key) {
			$user = Db::name("user")->where("uvirtual", 0)->where("id", $item["user_id"])->find();
			$item["username"] = $user["user_nick_name"];
			return $item;
		});
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function usmur()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", '');
		$where = ["us.user_nick_name" => ["like", "%{$hazy_name}%"], "la.status" => $hazy_egon, "la.ment_type" => 2, "la.much_id" => $this->much_id];
		$inquire = ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name];
		if (!$hazy_name) {
			unset($where["us.user_nick_name"]);
			unset($inquire["hazy_name"]);
		}
		if (!is_numeric($where["la.status"])) {
			unset($where["la.status"]);
			unset($inquire["egon"]);
		}
		$list = Db::name("lament")->alias("la")->join("user us", "la.proof_id=us.id", "left")->where($where)->field("la.*,us.user_nick_name")->order("la.ment_time")->paginate(10, false, ["query" => $inquire])->each(function ($item, $key) {
			$user = Db::name("user")->where("uvirtual", 0)->where("id", $item["user_id"])->find();
			$item["username"] = $user["user_nick_name"];
			return $item;
		});
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	protected function sflock()
	{
		$preCount = Db::name("prompt_msg")->where("status", 0)->where("much_id", $this->much_id)->count("*");
		return $preCount;
	}
	public function jaureak()
	{
		if (request()->isPost() && request()->isAjax()) {
			$suid = request()->post("suid");
			$mopid = request()->post("moid");
			Db::startTrans();
			try {
				Db::name("prompt_msg")->where("id", $mopid)->where("type", 1)->where("much_id", $this->much_id)->cache("vacants_" . $this->much_id)->update(["status" => 1]);
				$result = Db::name("lament")->where("id", $suid)->where("much_id", $this->much_id)->update(["status" => 1]);
				if ($result !== false) {
					Db::commit();
					$barg = self::sflock();
					Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->update(["barg" => $barg]);
					return json(["code" => 1, "msg" => "标记成功"]);
				} else {
					Db::rollback();
					return json(["code" => 0, "msg" => "标记失败 "]);
				}
			} catch (\Exception $e) {
				Db::rollback();
				return json(["code" => 0, "msg" => "标记失败 "]);
			}
		}
	}
	public function sprelint()
	{
		if (request()->isPost() && request()->isAjax()) {
			$suid = request()->post("suid");
			$mopid = request()->post("moid");
			Db::startTrans();
			try {
				Db::name("prompt_msg")->where("id", $mopid)->where("much_id", $this->much_id)->cache("vacants_" . $this->much_id)->delete();
				$result = Db::name("lament")->where("id", $suid)->where("much_id", $this->much_id)->delete();
				if ($result !== false) {
					Db::commit();
					$barg = self::sflock();
					Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->update(["barg" => $barg]);
					return json(["code" => 1, "msg" => "删除成功"]);
				} else {
					return json(["code" => 0, "msg" => "删除失败 "]);
				}
			} catch (\Exception $e) {
				Db::rollback();
				return json(["code" => 0, "msg" => "删除失败 "]);
			}
		}
	}
}