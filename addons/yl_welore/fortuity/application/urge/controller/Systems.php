<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Cache;
use think\Db;
class Systems extends Base
{
	private function defaultQuery()
	{
		$urlFirst = request()->query();
		$urlSecond = explode("=/", $urlFirst);
		$urlThird = explode("&", $urlSecond[1]);
		$url = "/" . $urlThird[0];
		return $url;
	}
	public function annex()
	{
		if (request()->isPost() && request()->isAjax()) {
			$quickType = request()->post("quicken_type");
			if ($quickType == 0) {
				$uickData["quicken_type"] = 0;
			} else {
				if ($quickType == 1) {
					$uickData["quicken_type"] = 1;
					$systemOutlying = self::exalize();
					$accessKeyId = request()->post("oss_access_key_id", '') ?: $systemOutlying["oss_follow"]["oss_access_key_id"];
					$accesskeySecret = request()->post("oss_access_key_secret", '') ?: $systemOutlying["oss_follow"]["oss_access_key_secret"];
					$bucket = request()->post("oss_bucket", '') ?: $systemOutlying["oss_follow"]["oss_bucket"];
					$endpoint = request()->post("oss_endpoint", '') ?: $systemOutlying["oss_follow"]["oss_endpoint"];
					$url = request()->post("oss_url", '') ?: $systemOutlying["oss_follow"]["oss_url"];
					$data["oss_access_key_id"] = authcode($accessKeyId, "ENCODE", "YuluoNetwork", 0);
					$data["oss_access_key_secret"] = authcode($accesskeySecret, "ENCODE", "YuluoNetwork", 0);
					$data["oss_bucket"] = authcode($bucket, "ENCODE", "YuluoNetwork", 0);
					$data["oss_endpoint"] = authcode($endpoint, "ENCODE", "YuluoNetwork", 0);
					$data["oss_url"] = authcode($url, "ENCODE", "YuluoNetwork", 0);
					$uickData["oss_follow"] = json_encode($data, 320);
				} else {
					if ($quickType == 2) {
						$uickData["quicken_type"] = 2;
						$systemOutlying = self::exalize();
						$accessKey = request()->post("qiniu_access_key", '') ?: $systemOutlying["qiniu_follow"]["qiniu_access_key"];
						$secretKey = request()->post("qiniu_secret_key", '') ?: $systemOutlying["qiniu_follow"]["qiniu_secret_key"];
						$bucket = request()->post("qiniu_bucket", '') ?: $systemOutlying["qiniu_follow"]["qiniu_bucket"];
						$url = request()->post("qiniu_url", '') ?: $systemOutlying["qiniu_follow"]["qiniu_url"];
						$data["qiniu_access_key"] = authcode($accessKey, "ENCODE", "YuluoNetwork", 0);
						$data["qiniu_secret_key"] = authcode($secretKey, "ENCODE", "YuluoNetwork", 0);
						$data["qiniu_bucket"] = authcode($bucket, "ENCODE", "YuluoNetwork", 0);
						$data["qiniu_url"] = authcode($url, "ENCODE", "YuluoNetwork", 0);
						$uickData["qiniu_follow"] = json_encode($data, 320);
					} else {
						if ($quickType == 3) {
							$uickData["quicken_type"] = 3;
							$systemOutlying = self::exalize();
							$appId = request()->post("cos_app_id", '') ?: $systemOutlying["cos_follow"]["cos_app_id"];
							$secretId = request()->post("cos_secret_id", '') ?: $systemOutlying["cos_follow"]["cos_secret_id"];
							$secretKey = request()->post("cos_secret_key", '') ?: $systemOutlying["cos_follow"]["cos_secret_key"];
							$bucket = request()->post("cos_bucket", '') ?: $systemOutlying["cos_follow"]["cos_bucket"];
							$region = request()->post("cos_region", '') ?: $systemOutlying["cos_follow"]["cos_region"];
							$url = request()->post("cos_url", '') ?: $systemOutlying["cos_follow"]["cos_url"];
							$data["cos_app_id"] = authcode($appId, "ENCODE", "YuluoNetwork", 0);
							$data["cos_secret_id"] = authcode($secretId, "ENCODE", "YuluoNetwork", 0);
							$data["cos_secret_key"] = authcode($secretKey, "ENCODE", "YuluoNetwork", 0);
							$data["cos_bucket"] = authcode($bucket, "ENCODE", "YuluoNetwork", 0);
							$data["cos_region"] = authcode($region, "ENCODE", "YuluoNetwork", 0);
							$data["cos_url"] = authcode($url, "ENCODE", "YuluoNetwork", 0);
							$uickData["cos_follow"] = json_encode($data, 320);
						}
					}
				}
			}
			$result = Db::name("outlying")->where("much_id", $this->much_id)->cache("outlying_" . $this->much_id)->update($uickData);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		$systemOutlying = self::exalize();
		if (Cache::get("ossEndpoint")) {
			$ossEndpoint = Cache::get("ossEndpoint");
		} else {
			$ossEndpoint = Db::name("outlying_allude")->where("status", 1)->where("type", 0)->cache("ossEndpoint")->select();
		}
		if (Cache::get("ossRegion")) {
			$ossRegion = Cache::get("ossRegion");
		} else {
			$ossRegion = Db::name("outlying_allude")->where("status", 1)->where("type", 1)->cache("ossRegion")->select();
		}
		$this->assign("list", $systemOutlying);
		$this->assign("ossEndpoint", $ossEndpoint);
		$this->assign("ossRegion", $ossRegion);
		return $this->fetch();
	}
	private function exalize()
	{
		if (Cache::get("outlying_" . $this->much_id)) {
			$systemOutlying = Cache::get("outlying_" . $this->much_id);
		} else {
			$systemOutlying = Db::name("outlying")->where("much_id", $this->much_id)->find();
			if ($systemOutlying) {
				if (!empty($systemOutlying["oss_follow"]) && $systemOutlying["oss_follow"] != '') {
					$systemOutlying["oss_follow"] = json_decode($systemOutlying["oss_follow"], true);
					foreach ($systemOutlying["oss_follow"] as $key => $value) {
						$systemOutlying["oss_follow"][$key] = authcode($value, "DECODE", "YuluoNetwork", 0);
					}
				}
				if (!empty($systemOutlying["qiniu_follow"]) && $systemOutlying["qiniu_follow"] != '') {
					$systemOutlying["qiniu_follow"] = json_decode($systemOutlying["qiniu_follow"], true);
					foreach ($systemOutlying["qiniu_follow"] as $key => $value) {
						$systemOutlying["qiniu_follow"][$key] = authcode($value, "DECODE", "YuluoNetwork", 0);
					}
				}
				if (!empty($systemOutlying["cos_follow"]) && $systemOutlying["cos_follow"] != '') {
					$systemOutlying["cos_follow"] = json_decode($systemOutlying["cos_follow"], true);
					foreach ($systemOutlying["cos_follow"] as $key => $value) {
						$systemOutlying["cos_follow"][$key] = authcode($value, "DECODE", "YuluoNetwork", 0);
					}
				}
			} else {
				$systemOutlying = ["quicken_type" => 0, "much_id" => $this->much_id];
				Db::startTrans();
				try {
					Db::name("outlying")->insert($systemOutlying);
					Db::commit();
				} catch (\Exception $e) {
					Db::rollback();
				}
			}
			Cache::set("outlying_" . $this->much_id, $systemOutlying, 600);
		}
		return $systemOutlying;
	}
	public function warrior()
	{
		if (request()->isPost() && request()->isAjax()) {
			$suid = request()->post("id");
			$data["title"] = request()->post("title");
			$data["sgraph"] = request()->post("sngimg");
			$data["cust_phone"] = request()->post("phone");
			$data["copyright"] = request()->post("copyright");
			$data["prevent_duplication"] = request()->post("preventDuplication");
			$data["noble_arbor"] = request()->post("nobleArbor");
			$data["wallet_arbor"] = request()->post("walletAbor");
			$result = Db::name("authority")->where("id", $suid)->where("much_id", $this->much_id)->cache("knight_" . $this->much_id)->update($data);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		return $this->fetch();
	}
	public function help()
	{
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		if ($hazy_name) {
			$list = Db::name("help")->where("trouble", "like", "%{$hazy_name}%")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("help")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url]]);
		}
		$this->assign("list", $list);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function shelp()
	{
		$suid = request()->post("asyId");
		$dalue = request()->post("dalue");
		$result = Db::name("help")->where("id", $suid)->where("much_id", $this->much_id)->update(["scores" => $dalue]);
		if ($result !== false) {
			return json(["code" => 1, "msg" => "保存成功"]);
		} else {
			return json(["code" => 0, "msg" => "保存失败"]);
		}
	}
	public function ruhelp()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$data["time"] = time();
			$data["much_id"] = $this->much_id;
			$result = Db::name("help")->insert($data);
			if ($result != false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		return $this->fetch();
	}
	public function uphelp()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$usid = $data["usid"];
			unset($data["usid"]);
			$data["time"] = time();
			$result = Db::name("help")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$helpList = Db::name("help")->where("id", $uplid)->where("much_id", $this->much_id)->find();
			if ($helpList) {
				$this->assign("list", $helpList);
				return $this->fetch();
			} else {
				return $this->redirect("help");
			}
		} else {
			return $this->redirect("help");
		}
	}
	public function helplint()
	{
		$usid = request()->post("ecid");
		$result = Db::name("help")->where("id", $usid)->where("much_id", $this->much_id)->delete();
		if ($result !== false) {
			return json(["code" => 1, "msg" => "删除成功"]);
		} else {
			return json(["code" => 0, "msg" => "删除失败"]);
		}
	}
	public function applets()
	{
		if (request()->isPost() && request()->isAjax()) {
			$getWiper = self::wiper();
			$usid = request()->post("usid");
			$appName = request()->post("appName", '') ?: $getWiper["app_name"];
			$appId = request()->post("appId", '') ?: $getWiper["app_id"];
			$appSecret = request()->post("appSecret", '') ?: $getWiper["app_secret"];
			$appMchid = request()->post("appMchid", '') ?: $getWiper["app_mchid"];
			$appKey = request()->post("appKey", '') ?: $getWiper["app_key"];
			$apiclientCert = request()->post("apiclientCert", '') ?: $getWiper["apiclient_cert"];
			$apiclientKey = request()->post("apiclientKey", '') ?: $getWiper["apiclient_key"];
			$data["app_name"] = $appName ? authcode($appName, "ENCODE", "YuluoNetwork", 0) : null;
			$data["app_id"] = $appId ? authcode($appId, "ENCODE", "YuluoNetwork", 0) : null;
			$data["app_secret"] = $appSecret ? authcode($appSecret, "ENCODE", "YuluoNetwork", 0) : null;
			$data["app_mchid"] = $appMchid ? authcode($appMchid, "ENCODE", "YuluoNetwork", 0) : null;
			$data["app_key"] = $appKey ? authcode($appKey, "ENCODE", "YuluoNetwork", 0) : null;
			$data["apiclient_cert"] = $apiclientCert ? authcode($apiclientCert, "ENCODE", "YuluoNetwork", 0) : null;
			$data["apiclient_key"] = $apiclientKey ? authcode($apiclientKey, "ENCODE", "YuluoNetwork", 0) : null;
			$result = Db::name("config")->where("id", $usid)->where("much_id", $this->much_id)->cache("fatal_" . $this->much_id)->update($data);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		$configList = self::wiper();
		$this->assign("configList", $configList);
		return $this->fetch();
	}
	private function wiper()
	{
		if (cache("fatal_" . $this->much_id)) {
			$getConfig = cache("fatal_" . $this->much_id);
		} else {
			$getConfig = Db::name("config")->where("much_id", $this->much_id)->find();
			if ($getConfig) {
				foreach ($getConfig as $key => $value) {
					if ($key != "id" && $key != "pay_react" && $key != "much_id") {
						$getConfig[$key] = authcode($getConfig[$key], "DECODE", "YuluoNetwork", 0);
					}
				}
			} else {
				$absRess = explode("index.php", $_SERVER["SCRIPT_NAME"]);
				$payReactURLReplace = "https://" . $_SERVER["HTTP_HOST"] . $absRess[0] . "payReact.php";
				$payReactURL = str_replace("\\", "/", $payReactURLReplace);
				$getConfig = ["pay_react" => $payReactURL, "much_id" => $this->much_id];
				Db::startTrans();
				try {
					$getConfig["id"] = Db::name("config")->insertGetId($getConfig);
					Db::commit();
				} catch (\Exception $e) {
					Db::rollback();
				}
			}
			cache("fatal_" . $this->much_id, $getConfig);
		}
		return $getConfig;
	}
	public function symbol()
	{
		$url = self::defaultQuery();
		$list = Db::name("polling")->where("much_id", $this->much_id)->order("scores", "asc")->paginate(10, false, ["query" => ["s" => $url]]);
		$this->assign("list", $list);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function slymben()
	{
		if (request()->isPost() && request()->isAjax()) {
			$syid = request()->post("asyId");
			$scores = request()->post("dalue");
			$result = Db::name("polling")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
	}
	public function rusymbol()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$data["much_id"] = $this->much_id;
			$result = Db::name("polling")->insert($data);
			if ($result != false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		return $this->fetch();
	}
	public function upsymbol()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$usid = $data["usid"];
			unset($data["usid"]);
			$result = Db::name("polling")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
			if ($result !== false) {
				return json(["code" => 1, "msg" => "保存成功"]);
			} else {
				return json(["code" => 0, "msg" => "保存失败"]);
			}
		}
		$uplid = request()->get("uplid", '');
		if ($uplid) {
			$poList = Db::name("polling")->where("id", $uplid)->where("much_id", $this->much_id)->find();
			if ($poList) {
				$this->assign("list", $poList);
				return $this->fetch();
			} else {
				return $this->redirect("symbol");
			}
		} else {
			return $this->redirect("symbol");
		}
	}
	public function symlint()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("ecid");
			$result = Db::name("polling")->where("id", $usid)->where("much_id", $this->much_id)->delete();
			if ($result !== false) {
				return json(["code" => 1, "msg" => "删除成功"]);
			} else {
				return json(["code" => 0, "msg" => "删除失败"]);
			}
		}
	}
	public function punch()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["aver_min"] = request()->post("averMin");
			$data["aver_max"] = request()->post("averMax");
			$data["noble_min"] = request()->post("nobleMin");
			$data["noble_max"] = request()->post("nobleMax");
			$data["invite_min"] = request()->post("inviteMin");
			$data["invite_max"] = request()->post("inviteMax");
			Db::startTrans();
			try {
				Db::name("user_punch_range")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
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
		$punchRangeList = Db::name("user_punch_range")->where("much_id", $this->much_id)->find();
		$this->assign("list", $punchRangeList);
		return $this->fetch();
	}
	public function partake()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["whether_open"] = request()->post("wetopen");
			$data["title"] = request()->post("title");
			$data["reis_img"] = request()->post("sngimg");
			Db::startTrans();
			try {
				Db::name("reissue")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
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
		$resList = Db::name("reissue")->where("much_id", $this->much_id)->find();
		$this->assign("list", $resList);
		return $this->fetch();
	}
	public function proclaim()
	{
		if (request()->isPost() && request()->isAjax()) {
			$usid = request()->post("usid");
			$data["adstory"] = request()->post("adstory");
			$data["adsper"] = request()->post("adsper");
			$data["isolate"] = request()->post("isolate");
			$data["adunit_id"] = request()->post("adunitId");
			Db::startTrans();
			try {
				Db::name("advertise")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
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
		$advList = Db::name("advertise")->where("much_id", $this->much_id)->find();
		$this->assign("list", $advList);
		return $this->fetch();
	}
	public function navigate()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			$data["pattern_data"] = json_encode($data["pattern_data"], 320);
			Db::startTrans();
			try {
				db("design")->where("much_id", $this->much_id)->cache("design_" . $this->much_id)->update($data);
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
		$list = self::defaultNavigate();
		$list["pattern_data"] = json_decode($list["pattern_data"], true);
		$this->assign("list", $list);
		return $this->fetch();
	}
	public function antetype()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data = request()->post();
			Db::startTrans();
			try {
				db("mouldboard")->where("much_id", $this->much_id)->update(["prototype_data" => json_encode($data, true)]);
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
		$getAntetype = self::defaultAntetype();
		$this->assign("list", $getAntetype);
		return $this->fetch();
	}
	private function defaultAntetype()
	{
		$getAntetype = db("mouldboard")->where("much_id", $this->much_id)->find();
		if (!$getAntetype) {
			$getAntetype = ["prototype_data" => json_encode(["AT2310" => '', "AT2295" => '', "AT1803" => '', "AT0330" => '', "AT1235" => ''], true), "much_id" => $this->much_id];
			Db::startTrans();
			try {
				$getAntetype["id"] = db("mouldboard")->insertGetId($getAntetype);
				Db::commit();
			} catch (\Exception $e) {
				Db::rollback();
			}
		}
		$getAntetype["prototype_data"] = json_decode($getAntetype["prototype_data"], true);
		return $getAntetype;
	}
	public function audit()
	{
		if (request()->isPost() && request()->isAjax()) {
			$euid = request()->post("euid");
			$data["status"] = request()->post("status");
			Db::startTrans();
			try {
				Db::name("version")->where("id", $euid)->where("much_id", $this->much_id)->update($data);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "更改状态成功"]);
			} else {
				return json(["code" => 0, "msg" => "更改状态失败"]);
			}
		}
		$url = self::defaultQuery();
		$hazy_name = request()->get("hazy_name", '');
		if ($hazy_name) {
			$list = Db::name("version")->where("sign_code", "like", "{$hazy_name}")->where("much_id", $this->much_id)->order("id", "desc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
		} else {
			$list = Db::name("version")->where("much_id", $this->much_id)->order("id", "desc")->paginate(10, false, ["query" => ["s" => $url]]);
		}
		$this->assign("list", $list);
		$authorityInfo = Db::name("authority")->where("much_id", $this->much_id)->find();
		$this->assign("authorityInfo", $authorityInfo);
		$this->assign("hazy_name", $hazy_name);
		$page = request()->get("page", 1);
		$this->assign("page", $page);
		return $this->fetch();
	}
	public function limuda()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["ensure_arbor"] = request()->post("status");
			Db::startTrans();
			try {
				Db::name("authority")->where("much_id", $this->much_id)->update($data);
				$result = true;
				Db::commit();
			} catch (\Exception $e) {
				$result = false;
				Db::rollback();
			}
			if ($result !== false) {
				return json(["code" => 1, "msg" => "更改状态成功"]);
			} else {
				return json(["code" => 0, "msg" => "更改状态失败"]);
			}
		}
	}
	public function video()
	{
		if (request()->isPost() && request()->isAjax()) {
			$data["video_setting"] = request()->post("videoSetting");
			Db::startTrans();
			try {
				Db::name("authority")->where("much_id", $this->much_id)->update($data);
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
		$video = Db::name("authority")->where("much_id", $this->much_id)->field("video_setting")->find();
		$this->assign("list", $video);
		return $this->fetch();
	}
}