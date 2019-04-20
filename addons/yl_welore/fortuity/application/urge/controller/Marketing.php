<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Db;
class Marketing extends Base
{
	private function defaultQuery()
	{
		$urlFirst = request()->query();
		$urlSecond = explode("=/", $urlFirst);
		$urlThird = explode("&", $urlSecond[1]);
		$url = "/" . $urlThird[0];
		return $url;
	}
	public function friendly()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		if ($hazy_name) {
			$list = Db::name("tribute")->where("tr_name", "like", "%{$hazy_name}%")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("tribute")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url]]);
		}
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		$this->assign("list", $list);
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
			$result = Db::name("tribute")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
	}
	public function rufriendly()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["tr_name"] = request()->post("name");
			$data["tr_icon"] = request()->post("icon");
			$data["tr_conch"] = request()->post("conch");
			$data["status"] = request()->post("status");
			$data["scores"] = request()->post("scores");
			$buteData = Db::name("tribute")->where("tr_name", $data["tr_name"])->where("much_id", $this->much_id)->find();
			if (empty($buteData) || !isset($buteData)) {
				$data["much_id"] = $this->much_id;
				$result = Db::name("tribute")->insert($data);
				if ($result != false) {
					return json(["code" => 1, "msg" => "保存成功"]);
				} else {
					return json(["code" => 0, "msg" => "保存失败"]);
				}
			} else {
				return json(["code" => 0, "msg" => "保存失败，礼物名已存在"]);
			}
		}
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		return $this->fetch();
	}
	public function upfriendly()
	{
		if (request()->isPost() && request()->isAjax()) {
			$suplid = request()->post("uplid");
			$data["tr_name"] = request()->post("name");
			$data["tr_icon"] = request()->post("icon");
			$data["tr_conch"] = request()->post("conch");
			$data["status"] = request()->post("status");
			$data["scores"] = request()->post("scores");
			$buteData = Db::name("tribute")->where("tr_name", $data["tr_name"])->where("id", "<>", $suplid)->where("much_id", $this->much_id)->find();
			if (empty($buteData) || !isset($buteData)) {
				$result = Db::name("tribute")->where("id", $suplid)->where("much_id", $this->much_id)->update($data);
				if ($result !== false) {
					return json(["code" => 1, "msg" => "保存成功"]);
				} else {
					return json(["code" => 0, "msg" => "保存失败"]);
				}
			} else {
				return json(["code" => 0, "msg" => "保存失败，礼物名已存在"]);
			}
		}
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$buteList = Db::name("tribute")->where("id", $uplid)->where("much_id", $this->much_id)->find();
			if ($buteList) {
				$defaultNavigate = self::defaultNavigate();
				$this->assign("defaultNavigate", $defaultNavigate);
				$this->assign("list", $buteList);
				return $this->fetch();
			} else {
				return $this->redirect("friendly");
			}
		} else {
			return $this->redirect("friendly");
		}
	}
	public function defriendly()
	{
		if (request()->isPost() && request()->isAjax()) {
			$suplid = request()->post("ecid");
			$result = Db::name("tribute")->where("id", $suplid)->where("much_id", $this->much_id)->delete();
			if ($result !== false) {
				return json(["code" => 1, "msg" => "删除成功"]);
			} else {
				return json(["code" => 0, "msg" => "删除失败"]);
			}
		}
	}
	public function fabulous()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["hono_price"] = request()->post("price");
			$data["first_discount"] = request()->post("discount");
			$data["discount_scale"] = request()->post("scale") * 0.01;
			Db::startTrans();
			try {
				Db::name("user_honorary")->where("id", $usid)->where("much_id", $this->much_id)->cache("honor_" . $this->much_id)->update($data);
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
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		$honorList = self::defaultHonorablePrice($this->much_id);
		$this->assign("list", $honorList);
		return $this->fetch();
	}
	public function taxing()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["taxing"] = request()->post("taxing") * 0.01;
			Db::startTrans();
			try {
				Db::name("tribute_taxation")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
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
		$taxaList = Db::name("tribute_taxation")->where("much_id", $this->much_id)->find();
		$this->assign("list", $taxaList);
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		return $this->fetch();
	}
	public function stype()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		if ($hazy_name) {
			$list = Db::name("shop_type")->where("name", "like", "%{$hazy_name}%")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("shop_type")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url]]);
		}
		$this->assign("list", $list);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function rustype()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$data["stype_time"] = time();
			$data["much_id"] = $this->much_id;
			$getStype = Db::name("shop_type")->where("name", $data["name"])->where("much_id", $this->much_id)->find();
			if ($getStype) {
				return json(["code" => 0, "msg" => "保存失败，分类名称已存在！"]);
			}
			Db::startTrans();
			try {
				Db::name("shop_type")->insert($data);
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
	public function upstype()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["name"] = request()->post("name");
			$data["status"] = request()->post("status");
			$data["scores"] = request()->post("scores");
			$getStype = Db::name("shop_type")->where("id", "<>", $usid)->where("name", $data["name"])->where("much_id", $this->much_id)->find();
			if ($getStype) {
				return json(["code" => 0, "msg" => "保存失败，保存的分类名称存在重复！"]);
			}
			Db::startTrans();
			try {
				Db::name("shop_type")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
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
			$stypeList = Db::name("shop_type")->where("id", $uplid)->where("much_id", $this->much_id)->find();
			if ($stypeList) {
				$this->assign("list", $stypeList);
				return $this->fetch();
			} else {
				return $this->redirect("marketing/stype");
			}
		} else {
			return $this->redirect("marketing/stype");
		}
	}
	public function stypelint()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("ecid");
			Db::startTrans();
			try {
				$getShop = Db::name("shop")->where("product_type", $usid)->where("much_id", $this->much_id)->find();
				if (!$getShop) {
					Db::name("shop")->where("id", $usid)->where("much_id", $this->much_id)->delete();
					$result = true;
					Db::commit();
				} else {
					Db::rollback();
					return json(["code" => 0, "msg" => "删除失败，分类下存在关联商品"]);
				}
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
	public function shop()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", 0);
		switch ($hazy_egon) {
			case 0:
				$list = Db::name("shop")->alias("sp")->join("shop_type stype", "sp.product_type=stype.id", "left")->where("sp.product_name", "like", "%{$hazy_name}%")->where("sp.trash", 0)->where("sp.much_id", $this->much_id)->order("sp.scores", "asc")->order("sp.id", "asc")->field("sp.*,stype.name as tpname")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 1:
				$list = Db::name("shop")->alias("sp")->join("shop_type stype", "sp.product_type=stype.id", "left")->where("sp.product_name", "like", "%{$hazy_name}%")->where("sp.trash", 0)->where("sp.status", 1)->where("sp.much_id", $this->much_id)->order("sp.scores", "asc")->order("sp.id", "asc")->field("sp.*,stype.name as tpname")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 2:
				$list = Db::name("shop")->alias("sp")->join("shop_type stype", "sp.product_type=stype.id", "left")->where("sp.product_name", "like", "%{$hazy_name}%")->where("sp.trash", 0)->where("sp.status", 0)->where("sp.much_id", $this->much_id)->order("sp.scores", "asc")->order("sp.id", "asc")->field("sp.*,stype.name as tpname")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 3:
				$list = Db::name("shop")->alias("sp")->join("shop_type stype", "sp.product_type=stype.id", "left")->where("sp.product_name", "like", "%{$hazy_name}%")->where("sp.trash", 0)->where("sp.product_inventory", 0)->where("sp.much_id", $this->much_id)->order("sp.scores", "asc")->order("sp.id", "asc")->field("sp.*,stype.name as tpname")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 4:
				$list = Db::name("shop")->alias("sp")->join("shop_type stype", "sp.product_type=stype.id", "left")->where("sp.product_name", "like", "%{$hazy_name}%")->where("sp.trash", 0)->where("sp.noble_exclusive", 1)->where("sp.much_id", $this->much_id)->order("sp.scores", "asc")->order("sp.id", "asc")->field("sp.*,stype.name as tpname")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 5:
				$list = Db::name("shop")->alias("sp")->join("shop_type stype", "sp.product_type=stype.id", "left")->where("sp.product_name", "like", "%{$hazy_name}%")->where("sp.trash", 1)->where("sp.much_id", $this->much_id)->order("sp.scores", "asc")->order("sp.id", "asc")->field("sp.*,stype.name as tpname")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
		}
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function rushop()
	{
		if (request()->isPost() && request()->isAjax()) {
			$uercive = request()->post();
			$data["product_name"] = $uercive["name"];
			$data["product_type"] = $uercive["type"];
			$data["product_synopsis"] = $uercive["synopsis"];
			$data["product_detail"] = $uercive["detail"];
			$data["product_img"] = json_encode($uercive["multipleImg"], 320);
			$data["product_inventory"] = $uercive["inventory"];
			$data["product_restrict"] = $uercive["restrict"];
			$data["product_price"] = $uercive["price"];
			$data["noble_exclusive"] = $uercive["exclusive"];
			$data["open_discount"] = $uercive["opdiscount"];
			$data["noble_discount"] = $uercive["nodiscount"] * 0.01;
			$data["noble_rebate"] = $uercive["rebate"];
			$data["sales_volume"] = $uercive["volume"];
			$data["status"] = $uercive["status"];
			$data["scores"] = $uercive["scores"];
			$data["trash"] = 0;
			$data["much_id"] = $this->much_id;
			Db::startTrans();
			try {
				Db::name("shop")->insert($data);
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
		$stypeList = Db::name("shop_type")->where("status", 1)->where("much_id", $this->much_id)->select();
		$this->assign("stypeList", $stypeList);
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		return $this->fetch();
	}
	public function upshop()
	{
		if (request()->isPost() && request()->isAjax()) {
			$uercive = request()->post();
			$usid = $uercive["usid"];
			$data["product_name"] = $uercive["name"];
			$data["product_type"] = $uercive["type"];
			$data["product_synopsis"] = $uercive["synopsis"];
			$data["product_detail"] = $uercive["detail"];
			$data["product_img"] = json_encode($uercive["multipleImg"], 320);
			$data["product_inventory"] = $uercive["inventory"];
			$data["product_restrict"] = $uercive["restrict"];
			$data["product_price"] = $uercive["price"];
			$data["noble_exclusive"] = $uercive["exclusive"];
			$data["open_discount"] = $uercive["opdiscount"];
			$data["noble_discount"] = $uercive["nodiscount"] * 0.01;
			$data["noble_rebate"] = $uercive["rebate"];
			$data["sales_volume"] = $uercive["volume"];
			$data["status"] = $uercive["status"];
			$data["scores"] = $uercive["scores"];
			Db::startTrans();
			try {
				Db::name("shop")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
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
		$usid = request()->get("usid", '');
		if ($usid) {
			$shopList = Db::name("shop")->where("id", $usid)->where("trash", 0)->where("much_id", $this->much_id)->find();
			if ($shopList) {
				$stypeList = Db::name("shop_type")->where("status", 1)->where("much_id", $this->much_id)->select();
				$shopList["product_img"] = json_decode($shopList["product_img"], true);
				$this->assign("list", $shopList);
				$this->assign("stypeList", $stypeList);
				$defaultNavigate = self::defaultNavigate();
				$this->assign("defaultNavigate", $defaultNavigate);
				return $this->fetch();
			} else {
				return $this->redirect("marketing/shop");
			}
		} else {
			return $this->redirect("marketing/shop");
		}
	}
	public function shoplint()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("suid");
			$thorough = request()->post("thorough");
			Db::startTrans();
			try {
				if ($thorough == 0) {
					Db::name("shop")->where("id", $usid)->where("much_id", $this->much_id)->update(["status" => 0, "trash" => 1]);
				} else {
					Db::name("shop")->where("id", $usid)->where("much_id", $this->much_id)->delete();
				}
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
	public function resume()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("suid");
			Db::startTrans();
			try {
				Db::name("shop")->where("id", $usid)->where("much_id", $this->much_id)->update(["trash" => 0]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "恢复成功"]);
			} else {
				return json(["code" => 0, "msg" => "恢复失败"]);
			}
		}
	}
	public function dopslue()
	{
		if (request()->isPost() && request()->isAjax()) {
			$syid = request()->post("asyId");
			$scores = request()->post("dalue");
			Db::startTrans();
			try {
				Db::name("shop")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "排序成功"]);
			} else {
				return json(["code" => 0, "msg" => "排序失败"]);
			}
		}
	}
	public function sorder()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		$hazy_egon = request()->get("egon", 0);
		switch ($hazy_egon) {
			case 0:
				$list = Db::name("shop_order")->alias("sord")->join("user us", "sord.user_id=us.id", "left")->where("sord.order_number|sord.product_name|us.user_nick_name", "like", "%{$hazy_name}%")->where("sord.much_id", $this->much_id)->order("sord.buy_time", "asc")->field("sord.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 1:
				$list = Db::name("shop_order")->alias("sord")->join("user us", "sord.user_id=us.id", "left")->where("sord.order_number|sord.product_name|us.user_nick_name", "like", "%{$hazy_name}%")->where("sord.status", 0)->where("sord.much_id", $this->much_id)->order("sord.buy_time", "asc")->field("sord.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 2:
				$list = Db::name("shop_order")->alias("sord")->join("user us", "sord.user_id=us.id", "left")->where("sord.order_number|sord.product_name|us.user_nick_name", "like", "%{$hazy_name}%")->where("sord.status", 1)->where("sord.much_id", $this->much_id)->order("sord.buy_time", "asc")->field("sord.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 3:
				$list = Db::name("shop_order")->alias("sord")->join("user us", "sord.user_id=us.id", "left")->where("sord.order_number|sord.product_name|us.user_nick_name", "like", "%{$hazy_name}%")->where("sord.status", 2)->where("sord.much_id", $this->much_id)->order("sord.buy_time", "asc")->field("sord.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 4:
				$list = Db::name("shop_order")->alias("sord")->join("user us", "sord.user_id=us.id", "left")->where("sord.order_number|sord.product_name|us.user_nick_name", "like", "%{$hazy_name}%")->where("sord.status", 4)->where("sord.much_id", $this->much_id)->order("sord.buy_time", "asc")->field("sord.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
			case 5:
				$list = Db::name("shop_order")->alias("sord")->join("user us", "sord.user_id=us.id", "left")->where("sord.order_number|sord.product_name|us.user_nick_name", "like", "%{$hazy_name}%")->where("sord.status", 3)->where("sord.much_id", $this->much_id)->order("sord.buy_time", "asc")->field("sord.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
				break;
		}
		$defaultNavigate = self::defaultNavigate();
		$this->assign("defaultNavigate", $defaultNavigate);
		$this->assign("list", $list);
		$this->assign("egon", $hazy_egon);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function seorder()
	{
		$usid = request()->get("usid", '');
		if ($usid) {
			$sorderList = Db::name("shop_order")->alias("sord")->join("user us", "sord.user_id=us.id", "left")->where("sord.id", $usid)->where("sord.much_id", $this->much_id)->field("sord.*,us.user_nick_name,us.user_wechat_open_id")->find();
			if ($sorderList) {
				$defaultNavigate = self::defaultNavigate();
				$this->assign("defaultNavigate", $defaultNavigate);
				$this->assign("list", $sorderList);
				return $this->fetch();
			} else {
				return $this->redirect("marketing/sorder");
			}
		} else {
			return $this->redirect("marketing/sorder");
		}
	}
	public function shiporder()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["buyer_name"] = request()->post("buyer_name");
			$data["buyer_phone"] = request()->post("buyer_phone");
			$data["buyer_address"] = request()->post("buyer_address");
			$data["shipment"] = request()->post("shipment");
			$data["ship_time"] = time();
			$data["status"] = 1;
			Db::startTrans();
			try {
				$sorder = Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->find();
				if ($sorder["status"] == 0) {
					Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
					if ($sorder["status"] == 2) {
						Db::name("user_smail")->insert(["user_id" => $sorder["user_id"], "maring" => "您申请的订单号为 : {$sorder["order_number"]} 的退款已被管理员拒绝，如有疑问请联系在线客服！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					}
					Db::name("user_smail")->insert(["user_id" => $sorder["user_id"], "maring" => "您兑换 订单号为 : {$sorder["order_number"]} 的商品已发货，请及时关注物流信息，确认无误后再收货！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					$result = true;
					Db::commit();
				} else {
					$result = false;
				}
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "发货成功"]);
			} else {
				return json(["code" => 0, "msg" => "发货失败"]);
			}
		} else {
			return $this->redirect("marketing/sorder");
		}
	}
	public function unshier()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["shipment"] = request()->post("shipment");
			Db::startTrans();
			try {
				Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
				$sorder = Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->find();
				Db::name("user_smail")->insert(["user_id" => $sorder["user_id"], "maring" => "您兑换 订单号为 : {$sorder["order_number"]} 的商品物流信息已被重新编辑，请及时查看，确认无误后再收货！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "修改成功"]);
			} else {
				return json(["code" => 0, "msg" => "修改失败"]);
			}
		} else {
			return $this->redirect("marketing/sorder");
		}
	}
	public function charger()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			Db::startTrans();
			try {
				$sorder = Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->find();
				if ($sorder["status"] == 1) {
					if ($sorder["is_noble"] == 1 && $sorder["product_rebate"] != 0) {
						$userEL = Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->find();
						Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->setInc("fraction", $sorder["product_rebate"]);
						$userER = Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->find();
						Db::name("user_amount")->insert(["user_id" => $sorder["user_id"], "category" => 3, "finance" => $sorder["actual_price"], "poem_fraction" => $userEL["fraction"], "poem_conch" => $userEL["conch"], "surplus_fraction" => $userER["fraction"], "surplus_conch" => $userER["conch"], "ruins_time" => time(), "solution" => "商品订单完成 ( 赠送积分 )", "evaluate" => 1, "much_id" => $this->much_id]);
					}
					Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->update(["status" => 4]);
					Db::name("user_smail")->insert(["user_id" => $sorder["user_id"], "maring" => "已完成收货，感谢您的惠顾，再见！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					$result = true;
					Db::commit();
				} else {
					$result = false;
				}
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "收货成功"]);
			} else {
				return json(["code" => 0, "msg" => "收货失败"]);
			}
		} else {
			return $this->redirect("marketing/sorder");
		}
	}
	public function canlorder()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			Db::startTrans();
			try {
				$sorder = Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->find();
				if ($sorder["status"] != "3" && $sorder["status"] != "4") {
					$defaultNavigate = self::defaultNavigate();
					$userEL = Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->find();
					Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->setInc("conch", $sorder["actual_price"]);
					$userER = Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->find();
					Db::name("user_amount")->insert(["user_id" => $sorder["user_id"], "category" => 3, "finance" => $sorder["actual_price"], "poem_fraction" => $userEL["fraction"], "poem_conch" => $userEL["conch"], "surplus_fraction" => $userER["fraction"], "surplus_conch" => $userER["conch"], "ruins_time" => time(), "solution" => "商品订单取消 ( 退还{$defaultNavigate["currency"]} )", "evaluate" => 0, "much_id" => $this->much_id]);
					Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->update(["status" => 3]);
					Db::name("user_smail")->insert(["user_id" => $sorder["user_id"], "maring" => "很抱歉，您兑换 订单号为 : {$sorder["order_number"]} 的商品已被取消，兑换消耗的{$defaultNavigate["currency"]}已返还到您的账户上，如有疑问请联系在线客服！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					$result = true;
					Db::commit();
				} else {
					$result = false;
				}
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "取消成功"]);
			} else {
				return json(["code" => 0, "msg" => "取消失败"]);
			}
		} else {
			return $this->redirect("marketing/sorder");
		}
	}
	public function refuntreat()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$uentreat = request()->post("uentreat");
			Db::startTrans();
			try {
				$sorder = Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->find();
				if ($sorder["status"] != "3" && $sorder["status"] != "4") {
					if ($uentreat == 0) {
						if ($sorder["shipment"] != '') {
							$data["status"] = 1;
						} else {
							$data["status"] = 0;
						}
						Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
						Db::name("user_smail")->insert(["user_id" => $sorder["user_id"], "maring" => "您申请的订单号为 : {$sorder["order_number"]} 的退款已被管理员拒绝，如有疑问请联系在线客服！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					} else {
						$defaultNavigate = self::defaultNavigate();
						$userEL = Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->find();
						Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->setInc("conch", $sorder["actual_price"]);
						$userER = Db::name("user")->where("uvirtual", 0)->where("id", $sorder["user_id"])->where("much_id", $this->much_id)->find();
						Db::name("user_amount")->insert(["user_id" => $sorder["user_id"], "category" => 3, "finance" => $sorder["actual_price"], "poem_fraction" => $userEL["fraction"], "poem_conch" => $userEL["conch"], "surplus_fraction" => $userER["fraction"], "surplus_conch" => $userER["conch"], "ruins_time" => time(), "solution" => "商品订单取消 ( 退还{$defaultNavigate["currency"]} )", "evaluate" => 0, "much_id" => $this->much_id]);
						Db::name("shop_order")->where("id", $usid)->where("much_id", $this->much_id)->update(["status" => 3]);
						Db::name("user_smail")->insert(["user_id" => $sorder["user_id"], "maring" => "您申请的订单号为 : {$sorder["order_number"]} 的退款已成功，兑换消耗的{$defaultNavigate["currency"]}已返还到您的账户上，如有疑问请联系在线客服！", "clue_time" => time(), "status" => 0, "much_id" => $this->much_id]);
					}
					$result = true;
					Db::commit();
				} else {
					$result = false;
				}
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => $uentreat == 0 ? "拒绝退款成功" : "同意退款成功"]);
			} else {
				return json(["code" => 0, "msg" => $uentreat == 0 ? "拒绝退款失败" : "同意退款失败"]);
			}
		} else {
			return $this->redirect("marketing/sorder");
		}
	}
}