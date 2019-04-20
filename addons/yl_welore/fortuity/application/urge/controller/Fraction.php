<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Db;
class Fraction extends Base
{
	public function stationery()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["release_single"] = request()->post("releaseSingle");
			$data["release_fraction"] = request()->post("releaseFraction");
			$data["reply_single"] = request()->post("replySingle");
			$data["reply_fraction"] = request()->post("replyFraction");
			$data["packet_single"] = request()->post("packetSingle");
			Db::startTrans();
			try {
				Db::name("shaky_fission")->where("much_id", $this->much_id)->update($data);
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
		$shakyFission = self::defaultShakyFission($this->much_id);
		$this->assign("list", $shakyFission);
		return $this->fetch();
	}
}