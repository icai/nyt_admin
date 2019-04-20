<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Db;
class Copyright extends Base
{
	public function recluse()
	{
		if ($this->M["role"] == "founder") {
			if (request()->isPost() && request()->isAjax()) {
				$data["hermit"] = request()->post("hermit");
				if ($data["hermit"] != "0" && $data["hermit"] != "1") {
					return json(["code" => 0, "msg" => "参数错误"]);
				}
				Db::startTrans();
				try {
					Db::name("copyright")->where("id", 1)->cache("globalRecluse")->update($data);
					$result = true;
					Db::commit();
				} catch (\Exception $e) {
					Db::rollback();
					return json(["code" => 0, "msg" => "error , " . $e->getMessage()]);
				}
				if ($result) {
					return json(["code" => 1, "msg" => "保存成功"]);
				}
			}
			return $this->fetch();
		} else {
			return $this->redirect("index/index");
		}
	}
}