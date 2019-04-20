<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Db;
class School extends Base
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
		if ($hazy_name) {
			$list = Db::name("school")->where("school_name", "like", "{$hazy_name}%")->where("much_id", $this->much_id)->order("scores", "asc")->order("id", "asc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("school")->where("much_id", $this->much_id)->order("scores", "asc")->order("id", "asc")->paginate(10, false, ["query" => ["s" => $url]]);
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
			$result = Db::name("school")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
	}
	public function ruschool()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["school_name"] = request()->post("name");
			$data["status"] = request()->post("status");
			$data["scores"] = request()->post("scores");
			$data["much_id"] = $this->much_id;
			Db::startTrans();
			try {
				Db::name("school")->insert($data);
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
		return $this->fetch();
	}
	public function upschool()
	{
		if (request()->isPost() && request()->isAjax()) {
			$ecid = request()->post("ecid");
			$data["school_name"] = request()->post("name");
			$data["status"] = request()->post("status");
			$data["scores"] = request()->post("scores");
			Db::startTrans();
			try {
				Db::name("school")->where("id", $ecid)->where("much_id", $this->much_id)->update($data);
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
		$upid = request()->get("uplid", '');
		if ($upid) {
			$schoolInfo = Db::name("school")->where("id", $upid)->where("much_id", $this->much_id)->find();
			if ($schoolInfo) {
				$this->assign("list", $schoolInfo);
				return $this->fetch();
			} else {
				return $this->error("参数错误", "school/index");
			}
		} else {
			return $this->error("参数错误", "school/index");
		}
	}
	public function quality()
	{
		$check = request()->get("active", '');
		if ($check != "UN6IWRCP29G8RITA") {
			return $this->error("参数错误", "index/index");
		}
		Db::startTrans();
		try {
			$motion = Db::name("motion")->where("mot_name", "学校管理")->where("mot_url", "school/index")->where("pid", 15)->find();
			if (!$motion) {
				Db::name("motion")->insert(["mot_name" => "学校管理", "mot_url" => "school/index", "pid" => 15, "divulge" => 1, "sort" => 1]);
			}
			$existSchool = Db::query("show tables like \"yl_welore_school\"");
			if (!$existSchool) {
				$SchoolSql = "                CREATE TABLE IF NOT EXISTS `yl_welore_school` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `school_name` varchar(1000) DEFAULT NULL,\r\n                  `status` int(11) unsigned NOT NULL DEFAULT '1',\r\n                  `scores` int(11) unsigned NOT NULL DEFAULT '0',\r\n                  `much_id` int(11) unsigned DEFAULT NULL,\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `status` (`status`),\r\n                  KEY `scores` (`scores`),\r\n                  KEY `much_id` (`much_id`)\r\n                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				Db::execute($SchoolSql);
			}
			$existSchoolPaper = Db::query("show tables like \"yl_welore_school_paper\"");
			if (!$existSchoolPaper) {
				$SchoolPaperSql = "                CREATE TABLE IF NOT EXISTS `yl_welore_school_paper` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `paper_id` int(11) unsigned DEFAULT NULL,\r\n                  `school_id` int(11) unsigned DEFAULT NULL,\r\n                  `much_id` int(11) unsigned DEFAULT NULL,\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `paper_id` (`paper_id`),\r\n                  KEY `school_id` (`school_id`),\r\n                  KEY `much_id` (`much_id`)\r\n                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				Db::execute($SchoolPaperSql);
			}
			$existUserSchool = Db::query("show tables like \"yl_welore_user_school\"");
			if (!$existUserSchool) {
				$UserSchoolSql = "                CREATE TABLE IF NOT EXISTS `yl_welore_user_school` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) unsigned DEFAULT NULL,\r\n                  `school_id` int(11) unsigned DEFAULT NULL,\r\n                  `much_id` int(11) unsigned DEFAULT NULL,\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `user_id` (`user_id`),\r\n                  KEY `school_id` (`school_id`),\r\n                  KEY `much_id` (`much_id`)\r\n                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				Db::execute($UserSchoolSql);
			}
			$result = true;
			Db::commit();
		} catch (\Exception $e) {
			$result = false;
			Db::rollback();
		}
		cookie("acid", 1, ["path" => "/addons/yl_welore/web"]);
		cookie("ucid", 1, ["path" => "/addons/yl_welore/web"]);
		if ($result !== false) {
			return $this->success("成功", "index/index");
		} else {
			return $this->error("失败", "index/index");
		}
	}
}