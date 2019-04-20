<?php

//decode by http://www.yunlu99.com/
defined("IN_IA") or define("IN_IA", true);
try {
	require __DIR__ . "/../../../../data/config.php";
	$database = array();
	if (empty($config["db"]["master"])) {
		$database = $config["db"];
	} else {
		$database = $config["db"]["master"];
	}
} catch (\Exception $e) {
	header("Content-type: text/html; charset=utf-8");
	echo "读取数据库配置文件失败，需开发者协助处理。错误信息：" . $e->getMessage();
	die;
}
return ["type" => "mysql", "hostname" => $database["host"], "database" => $database["database"], "username" => $database["username"], "password" => $database["password"], "hostport" => $database["port"], "dsn" => '', "params" => [], "charset" => $database["charset"], "prefix" => "yl_welore_", "debug" => true, "deploy" => 0, "rw_separate" => false, "master_num" => 1, "slave_no" => '', "fields_strict" => true, "resultset_type" => "array", "auto_timestamp" => false, "datetime_format" => "Y-m-d H:i:s", "sql_explain" => false];