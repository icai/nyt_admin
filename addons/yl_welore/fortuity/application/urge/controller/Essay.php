<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use app\api\service\UserService;
use think\Db;
use think\Url;
class Essay extends Base
{
	private function defaultQuery()
	{
		$urlFirst = request()->query();
		$urlSecond = explode("=/", $urlFirst);
		$urlThird = explode("&", $urlSecond[1]);
		$url = "/" . $urlThird[0];
		return $url;
	}
	public function index()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", '');
		$where = ["pa.study_title|us.user_nick_name|tory.realm_name" => ["like", "%{$hazy_name}%"], "pa.study_status" => $hazy_egon, "pa.much_id" => $this->much_id, "pa.whether_delete" => 0, "tory.status" => 1];
		$inquire = ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name];
		if (!$hazy_name) {
			unset($where["pa.study_title|us.user_nick_name"]);
			unset($inquire["hazy_name"]);
		}
		if (!is_numeric($where["pa.study_status"])) {
			unset($where["pa.study_status"]);
			unset($inquire["egon"]);
		}
		$list = Db::name("paper")->alias("pa")->join("territory tory", "pa.tory_id=tory.id", "left")->join("user us", "pa.user_id=us.id", "left")->where($where)->field("us.user_nick_name,us.user_wechat_open_id,tory.realm_name,pa.*")->order("pa.study_status")->order("pa.prove_time", "desc")->order("pa.adapter_time")->paginate(10, false, ["query" => $inquire]);
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		if ($hazy_name) {
			$this->assign("hazy_name", $hazy_name);
		}
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function setails()
	{
		if (request()->isPost() && request()->isAjax()) {
			$uplid = request()->post("uplid");
			$pical = request()->post("pical");
			if ($pical == 1) {
				$result = Db::name("paper")->where("id", $uplid)->where("much_id", $this->much_id)->update(["prove_time" => time(), "study_status" => 1]);
				$toryTion = Db::name("paper")->where("id", $uplid)->where("much_id", $this->much_id)->find();
				Db::name("user_smail")->insert(["user_id" => $toryTion["user_id"], "maring" => "您的发帖" . subtext($toryTion["study_title"], 10) . "已通过审核！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
				if ($result !== false) {
					$user = new UserService();
					$user->examine($uplid, $this->much_id);
					return json(["code" => 1, "msg" => "操作成功"]);
				} else {
					return json(["code" => 0, "msg" => "操作失败"]);
				}
			} else {
				$reason = request()->post("reason");
				if ($pical == 2) {
					$result = Db::name("paper")->where("id", $uplid)->where("much_id", $this->much_id)->update(["prove_time" => time(), "study_status" => 2, "reject_reason" => $reason]);
					$toryTion = Db::name("paper")->where("id", $uplid)->where("much_id", $this->much_id)->find();
					Db::name("user_smail")->insert(["user_id" => $toryTion["user_id"], "maring" => "您的发帖" . subtext($toryTion["study_title"], 10) . "已被打回！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					if ($result !== false) {
						return json(["code" => 1, "msg" => "操作成功"]);
					} else {
						return json(["code" => 0, "msg" => "操作失败"]);
					}
				} else {
					if ($pical == 3) {
						$result = Db::name("paper")->where("id", $uplid)->where("much_id", $this->much_id)->update(["prove_time" => time(), "study_status" => 1, "whether_type" => 1, "whether_reason" => $reason, "whether_delete" => 1, "whetd_time" => time(), "token" => md5(time())]);
						$toryTion = Db::name("paper")->where("id", $uplid)->where("much_id", $this->much_id)->find();
						Db::name("user_smail")->insert(["user_id" => $toryTion["user_id"], "maring" => "您的发帖" . subtext($toryTion["study_title"], 10) . "已被系统管理员删除，请注意您的言行举止！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
						if ($result !== false) {
							return json(["code" => 1, "msg" => "删帖成功"]);
						} else {
							return json(["code" => 0, "msg" => "删帖失败"]);
						}
					} else {
						return json(["code" => 0, "msg" => "非法操作"]);
					}
				}
			}
		}
		$uplid = request()->get("uplid", '');
		$token = request()->get("token", '');
		if ($uplid) {
			if ($token) {
				$kind = "pa.token";
				$wed = $token;
			} else {
				$kind = "pa.whether_delete";
				$wed = 0;
			}
			return self::exSetails($uplid, $kind, $wed);
		} else {
			return $this->redirect("index");
		}
	}
	private function exSetails($uplid, $kind, $wed)
	{
		$navList = Db::name("paper")->alias("pa")->join("territory tory", "pa.tory_id=tory.id", "left")->join("user us", "pa.user_id=us.id", "left")->where("pa.id", $uplid)->where("pa.much_id", $this->much_id)->where($kind, $wed)->field("pa.*,us.user_nick_name,tory.realm_name")->find();
		if ($navList) {
			$navList["image_part"] = json_decode($navList["image_part"], true);
			$this->assign("list", $navList);
			return $this->fetch();
		} else {
			$url = Url::build("index");
			return "<script>alert('很抱歉，您当前所查看的 帖子不存在 或 已被删除 ！');location.href='{$url}';</script>";
		}
	}
	public function reply()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		if ($hazy_name) {
			$list = Db::name("paper_reply")->alias("rep")->join("paper per", "rep.paper_id=per.id", "left")->join("user us", "rep.user_id=us.id", "left")->where("rep.reply_content|us.user_nick_name", "like", "%{$hazy_name}%")->where("rep.much_id", $this->much_id)->where("rep.whether_delete", 0)->where("per.whether_delete", 0)->order("rep.apter_time", "desc")->field("rep.*,per.study_title,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("paper_reply")->alias("rep")->join("paper per", "rep.paper_id=per.id", "left")->join("user us", "rep.user_id=us.id", "left")->where("rep.much_id", $this->much_id)->where("rep.whether_delete", 0)->where("per.whether_delete", 0)->order("rep.apter_time", "desc")->field("rep.*,per.study_title,per.tory_id,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url]])->each(function ($item, $key) {
				$item["tory"] = Db::name("territory")->where("id", $item["tory_id"])->where("much_id", $this->much_id)->field("realm_name")->find();
				return $item;
			});
		}
		$this->assign("list", $list);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function repas()
	{
		if (request()->isPost() && request()->isAjax()) {
			$uplid = request()->post("uplid");
			$reason = request()->post("reason");
			$result = Db::name("paper_reply")->where("id", $uplid)->where("much_id", $this->much_id)->update(["whether_type" => 1, "whether_reason" => $reason, "whether_delete" => 1, "whetd_time" => time()]);
			$toryTion = Db::name("paper_reply")->where("id", $uplid)->where("much_id", $this->much_id)->find();
			Db::name("user_smail")->insert(["user_id" => $toryTion["user_id"], "maring" => "您的帖子回复" . subtext($toryTion["reply_content"], 10) . "已被系统管理员删除，请注意您的言行举止！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "删除成功"]);
			} else {
				return json(["code" => 0, "msg" => "删除失败"]);
			}
		}
		$uplid = request()->get("uplid", '');
		$token = request()->get("token", '');
		$uplid = request()->get("uplid", '');
		$token = request()->get("token", '');
		if ($uplid) {
			if ($token) {
				$kind = "rep.token";
				$wed = $token;
			} else {
				$kind = "rep.whether_delete";
				$wed = 0;
			}
			return self::exRepas($uplid, $kind, $wed);
		} else {
			return $this->redirect("reply");
		}
	}
	public function exRepas($uplid, $kind, $wed)
	{
		$navList = Db::name("paper_reply")->alias("rep")->join("paper per", "rep.paper_id=per.id", "left")->join("user us", "rep.user_id=us.id", "left")->where("rep.id", $uplid)->where("rep.much_id", $this->much_id)->where("per.whether_delete", 0)->where($kind, $wed)->field("rep.*,per.study_title,us.user_nick_name")->find();
		if ($navList) {
			$navList["image_part"] = json_decode($navList["image_part"], true);
			$this->assign("list", $navList);
			return $this->fetch();
		} else {
			$url = Url::build("reply");
			return "<script>alert('很抱歉，您当前所查看的 回复 不存在 或 已被删除 ！');location.href='{$url}';</script>";
		}
	}
	public function ritual()
	{
		if (request()->isPost() && request()->isAjax()) {
			$uplid = request()->post("uplid");
			$data["auto_review"] = request()->post("review");
			$data["number_limit"] = request()->post("numit");
			$data["notice"] = request()->post("notice");
			$result = Db::name("paper_smingle")->where("id", $uplid)->where("much_id", $this->much_id)->update($data);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		$tuaList = Db::name("paper_smingle")->where("much_id", $this->much_id)->find();
		$this->assign("list", $tuaList);
		return $this->fetch();
	}
}