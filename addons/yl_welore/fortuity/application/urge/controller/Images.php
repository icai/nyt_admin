<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Db;
class Images extends Base
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
			$gclassify = db("gallery_classify")->where("name", "like", "{$hazy_name}%")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]])->each(function ($item, $key) {
				$item["count"] = db("gallery")->where("classify_id", $item["id"])->where("much_id", $this->much_id)->count();
				return $item;
			});
		} else {
			$gclassify = db("gallery_classify")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url]])->each(function ($item, $key) {
				$item["count"] = db("gallery")->where("classify_id", $item["id"])->where("much_id", $this->much_id)->count();
				return $item;
			});
		}
		$this->assign("gclassify", $gclassify);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function sfrieng()
	{
		if (request()->isPost() && request()->isAjax()) {
			$syid = request()->post("asyId");
			$scores = request()->post("dalue");
			Db::startTrans();
			try {
				Db::name("gallery_classify")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
				dump($e->getMessage());
				exit;
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "排序成功"]);
			} else {
				return json(["code" => 0, "msg" => "排序失败"]);
			}
		}
	}
	public function superviseImages()
	{
		$url = self::defaultQuery();
		$gclasid = request()->get("gclasid", 0);
		$gclassify = db("gallery_classify")->where("status", 1)->where("much_id", $this->much_id)->order("scores", "asc")->order("id", "asc")->select();
		$gallery = db("gallery")->where("classify_id", $gclasid)->where("much_id", $this->much_id)->order("id", "desc")->paginate(15, false, ["query" => ["s" => $url, "gclasid" => $gclasid]]);
		$this->assign("gclassify", $gclassify);
		$this->assign("gallery", $gallery);
		$this->assign("gclasid", $gclasid);
		return $this->fetch();
	}
	public function stirGallery()
	{
		if (request()->isPost() && request()->isAjax()) {
			$euid = request()->post("euid");
			$gclasid = request()->post("gclasid");
			Db::startTrans();
			try {
				db("gallery")->where("id", $euid)->where("much_id", $this->much_id)->update(["classify_id" => $gclasid]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "移动成功"]);
			} else {
				return json(["code" => 0, "msg" => "移动失败"]);
			}
		}
	}
	public function dialogImages()
	{
		$url = self::defaultQuery();
		$gclasid = request()->get("gclasid", 0);
		if ($gclasid > 0) {
			$gcy = db("gallery_classify")->where("id", $gclasid)->where("status", 1)->where("much_id", $this->much_id)->find();
			if (!$gcy) {
				return $this->redirect("images/dialogImages");
			}
		}
		$gclassify = db("gallery_classify")->where("status", 1)->where("much_id", $this->much_id)->order("scores", "asc")->order("id", "asc")->select();
		foreach ($gclassify as $key => $value) {
			$gclassify[$key]["count"] = db("gallery")->where("classify_id", $value["id"])->where("much_id", $this->much_id)->count();
		}
		if ($gclasid > 0) {
			$gallery = db("gallery")->where("classify_id", $gclasid)->where("much_id", $this->much_id)->order("id", "desc")->paginate(15, false, ["query" => ["s" => $url, "gclasid" => $gclasid]]);
			$this->assign("gclasid", $gclasid);
		} else {
			$gallery = db("gallery")->where("classify_id", $gclassify[0]["id"])->where("much_id", $this->much_id)->order("id", "desc")->paginate(15, false, ["query" => ["s" => $url, "gclasid" => 0]]);
			$this->assign("gclasid", $gclassify[0]["id"]);
		}
		$this->assign("gclassify", $gclassify);
		$this->assign("gallery", $gallery);
		return $this->fetch();
	}
	public function unimgs()
	{
		if (request()->isPost() && request()->isAjax()) {
			$euid = request()->post("euid");
			Db::startTrans();
			try {
				db("gallery")->where("id", $euid)->where("much_id", $this->much_id)->delete();
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
	public function eturvys()
	{
		if (request()->isPost() && request()->isAjax()) {
			$euid = request()->post("euid");
			$status = request()->post("status");
			Db::startTrans();
			try {
				db("gallery_classify")->where("id", $euid)->where("much_id", $this->much_id)->update(["status" => $status]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "更改成功"]);
			} else {
				return json(["code" => 0, "msg" => "更改失败"]);
			}
		}
	}
	public function newImgs()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["name"] = request()->post("name");
			$data["scores"] = request()->post("scores");
			$data["much_id"] = $this->much_id;
			Db::startTrans();
			try {
				db("gallery_classify")->insert($data);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "新增成功"]);
			} else {
				return json(["code" => 0, "msg" => "新增失败"]);
			}
		}
		return $this->fetch();
	}
	public function unImagesSify()
	{
		if (request()->isPost() && request()->isAjax()) {
			$suid = request()->post("suid");
			$gcy = db("gallery")->where("classify_id", $suid)->where("much_id", $this->much_id)->find();
			if ($gcy) {
				return json(["code" => 0, "msg" => "删除失败，请把图库下的图片移动到其他图库或删除清空后再进行删库操作！"]);
			}
			Db::startTrans();
			try {
				db("gallery_classify")->where("id", $suid)->where("much_id", $this->much_id)->delete();
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
}