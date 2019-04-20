<?php

//decode by http://www.yunlu99.com/
namespace app\common;

class Assembly
{
	public static function transfer($quickenType, $config)
	{
		if ($quickenType == 1) {
			return self::ossUpload($config);
		} else {
			if ($quickenType == 2) {
				return self::qiniuUpload($config);
			} else {
				if ($quickenType == 3) {
					return self::cosUpload($config);
				}
			}
		}
	}
	public function ossUpload($config)
	{
		require_once EXTEND_PATH . "OSS/autoload.php";
		$accessKeyId = $config["accessKeyId"];
		$accessKeySecret = $config["accessKeySecret"];
		$endpoint = $config["endpoint"];
		$bucket = $config["bucket"];
		$newly = self::uuid() . "." . $config["extend"];
		$object = $newly;
		$filePath = $config["path"];
		try {
			$ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
			$ossClient->uploadFile($bucket, $object, $filePath);
			unlink($config["path"]);
			return ["status" => "success", "url" => $config["far_url"] . "/" . $newly, "title" => $newly];
		} catch (\Exception $e) {
			unlink($config["path"]);
			return ["status" => "error"];
		}
	}
	public function qiniuUpload($config)
	{
		try {
			require_once EXTEND_PATH . "Qiniu/autoload.php";
			$accessKey = $config["accessKey"];
			$secretKey = $config["secretKey"];
			$auth = new \Qiniu\Auth($accessKey, $secretKey);
			$token = $auth->uploadToken($config["bucket"]);
			$uploadMgr = new \Qiniu\Storage\UploadManager();
			$newly = self::uuid() . "." . $config["extend"];
			$result = $uploadMgr->putFile($token, $newly, $config["path"]);
			unlink($config["path"]);
			if ($result[0] != null && $result[0] != '' && !empty($result[0])) {
				return ["status" => "success", "url" => $config["far_url"] . "/" . $newly, "title" => $newly];
			} else {
				return ["status" => "error"];
			}
		} catch (\Exception $e) {
			unlink($config["path"]);
			return ["status" => "error"];
		}
	}
	public function cosUpload($config)
	{
		try {
			require EXTEND_PATH . "COS/vendor/autoload.php";
			$qcloudConfig = array("region" => $config["region"], "credentials" => array("appId" => $config["appId"], "secretId" => $config["secretId"], "secretKey" => $config["secretKey"]));
			$cosClient = new \Qcloud\Cos\Client($qcloudConfig);
			$newly = self::uuid() . "." . $config["extend"];
			$result = $cosClient->putObject(array("Bucket" => $config["bucket"], "Key" => $newly, "Body" => fopen($config["path"], "rb")));
			$result = is_object($result);
			unlink($config["path"]);
			if ($result) {
				return ["status" => "success", "url" => $config["far_url"] . "/" . $newly, "title" => $newly];
			} else {
				return ["status" => "error"];
			}
		} catch (\Exception $e) {
			unlink($config["path"]);
			return ["status" => "error"];
		}
	}
	private function uuid()
	{
		$str = md5(uniqid(mt_rand(), true));
		$uuid = substr($str, 0, 8) . "-";
		$uuid .= substr($str, 8, 4) . "-";
		$uuid .= substr($str, 12, 4) . "-";
		$uuid .= substr($str, 16, 4) . "-";
		$uuid .= substr($str, 20, 12);
		$uuid = md5($uuid . uniqid(mt_rand(), true) . time());
		return $uuid;
	}
}