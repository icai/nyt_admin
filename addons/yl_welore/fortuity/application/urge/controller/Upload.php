<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use app\common\Assembly;
use think\Cache;
use think\Db;
class Upload
{
	public $much_id = null;
	public function __construct($uniacid = null)
	{
		@session_start();
		$this->much_id = $_SESSION["make_variable"]["uniacid"];
		if (!isset($this->much_id) || empty($this->much_id)) {
			$this->much_id = $uniacid;
		}
	}
	public function operate()
	{
		$file = request()->file("sngpic");
		$editorid = request()->param("editorid", '');
		$picture = request()->param("picture", '');
		if ($file) {
			if (Cache::get("outlying_" . $this->much_id)) {
				$systemOutlying = Cache::get("outlying_" . $this->much_id);
			} else {
				$systemOutlying = Db::name("outlying")->where("much_id", $this->much_id)->find();
				if (!$systemOutlying) {
					$systemOutlying = ["quicken_type" => 0, "much_id" => $this->much_id];
					Db::startTrans();
					try {
						Db::name("outlying")->insert($systemOutlying);
						Db::commit();
					} catch (\Exception $e) {
						Db::rollback();
					}
				}
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
				Cache::set("outlying_" . $this->much_id, $systemOutlying, 600);
			}
			$info = $file->validate(["ext" => "png,gif,jpg,jpeg,bmp,mp4,mp3"])->move(ROOT_PATH . ".." . DS . "web" . DS . "static" . DS . "uploads");
			if ($info) {
				$absLocalRess = ROOT_PATH . ".." . DS . "web" . DS . "static" . DS . "uploads" . DS . $info->getSaveName();
				if ($systemOutlying["quicken_type"] == 0) {
					$absAddress = explode("index.php", $_SERVER["SCRIPT_NAME"]);
					$absRess = "https://" . $_SERVER["HTTP_HOST"] . $absAddress[0];
					if ($editorid != "detail") {
						if ($picture) {
							Db::startTrans();
							try {
								db("gallery")->insert(["classify_id" => request()->param("gclasid"), "img_url" => $absRess . "static" . DS . "uploads" . DS . $info->getSaveName(), "img_title" => $info->getSaveName(), "much_id" => $this->much_id]);
								$result = true;
								Db::commit();
							} catch (\Exception $e) {
								$result = false;
								Db::rollback();
							}
							if ($result !== false) {
								return ["status" => "success"];
							} else {
								return ["status" => "error"];
							}
						} else {
							$imgURLReplace = $absRess . "static/uploads/" . $info->getSaveName();
							$imgURL = str_replace("\\", "/", $imgURLReplace);
							return ["status" => "success", "url" => $imgURL];
						}
					} else {
						$umAnswer = ["state" => "SUCCESS", "url" => $absRess . "static" . DS . "uploads" . DS . $info->getSaveName(), "title" => $info->getSaveName()];
						return json_encode($umAnswer, true);
					}
				} else {
					if ($systemOutlying["quicken_type"] == 1) {
						$config = array("accessKeyId" => $systemOutlying["oss_follow"]["oss_access_key_id"], "accessKeySecret" => $systemOutlying["oss_follow"]["oss_access_key_secret"], "endpoint" => $systemOutlying["oss_follow"]["oss_endpoint"], "bucket" => $systemOutlying["oss_follow"]["oss_bucket"], "extend" => $info->getExtension(), "path" => $absLocalRess, "far_url" => $systemOutlying["oss_follow"]["oss_url"]);
						$assembly = Assembly::transfer(1, $config);
						if ($editorid != "detail") {
							if ($picture) {
								Db::startTrans();
								try {
									db("gallery")->insert(["classify_id" => request()->param("gclasid"), "img_url" => $assembly["url"], "img_title" => $assembly["title"], "much_id" => $this->much_id]);
									$result = true;
									Db::commit();
								} catch (\Exception $e) {
									$result = false;
									Db::rollback();
								}
								if ($result !== false) {
									return ["status" => "success"];
								} else {
									return ["status" => "error"];
								}
							} else {
								return $assembly;
							}
						} else {
							$umAnswer = ["state" => "SUCCESS", "url" => $assembly["url"], "title" => $assembly["title"]];
							return json_encode($umAnswer, true);
						}
					} else {
						if ($systemOutlying["quicken_type"] == 2) {
							$config = array("accessKey" => $systemOutlying["qiniu_follow"]["qiniu_access_key"], "secretKey" => $systemOutlying["qiniu_follow"]["qiniu_secret_key"], "bucket" => $systemOutlying["qiniu_follow"]["qiniu_bucket"], "extend" => $info->getExtension(), "path" => $absLocalRess, "far_url" => $systemOutlying["qiniu_follow"]["qiniu_url"]);
							$assembly = Assembly::transfer(2, $config);
							if ($editorid != "detail") {
								if ($picture) {
									Db::startTrans();
									try {
										db("gallery")->insert(["classify_id" => request()->param("gclasid"), "img_url" => $assembly["url"], "img_title" => $assembly["title"], "much_id" => $this->much_id]);
										$result = true;
										Db::commit();
									} catch (\Exception $e) {
										$result = false;
										Db::rollback();
									}
									if ($result !== false) {
										return ["status" => "success"];
									} else {
										return ["status" => "error"];
									}
								} else {
									return $assembly;
								}
							} else {
								$umAnswer = ["state" => "SUCCESS", "url" => $assembly["url"], "title" => $assembly["title"]];
								return json_encode($umAnswer, true);
							}
						} else {
							if ($systemOutlying["quicken_type"] == 3) {
								$config = array("region" => $systemOutlying["cos_follow"]["cos_region"], "appId" => $systemOutlying["cos_follow"]["cos_app_id"], "secretId" => $systemOutlying["cos_follow"]["cos_secret_id"], "secretKey" => $systemOutlying["cos_follow"]["cos_secret_key"], "extend" => $info->getExtension(), "bucket" => $systemOutlying["cos_follow"]["cos_bucket"], "path" => $absLocalRess, "far_url" => $systemOutlying["cos_follow"]["cos_url"]);
								$assembly = Assembly::transfer(3, $config);
								if ($editorid != "detail") {
									if ($picture) {
										Db::startTrans();
										try {
											db("gallery")->insert(["classify_id" => request()->param("gclasid"), "img_url" => $assembly["url"], "img_title" => $assembly["title"], "much_id" => $this->much_id]);
											$result = true;
											Db::commit();
										} catch (\Exception $e) {
											$result = false;
											Db::rollback();
										}
										if ($result !== false) {
											return ["status" => "success"];
										} else {
											return ["status" => "error"];
										}
									} else {
										return $assembly;
									}
								} else {
									$umAnswer = ["state" => "SUCCESS", "url" => $assembly["url"], "title" => $assembly["title"]];
									return json_encode($umAnswer, true);
								}
							}
						}
					}
				}
			} else {
				if ($editorid != "detail") {
					return ["status" => "error"];
				} else {
					return json_encode(["status" => "error"], true);
				}
			}
		}
	}
}