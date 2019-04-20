<?php
global $_W,$_GPC;
$setting = pdo_fetch('SELECT * FROM ' . tablename('wyt_luntan_config') . ' WHERE uniacid ='.$_W['uniacid']);
$others =json_decode($setting['other_setting'],true);
$uniacid =  $_W['uniacid'];
$uid     = $_W['member']['uid'];
$today = date('Y-m-d',time());
$uid = $_W['member']['uid'];
//var_dump($_W['member']['uid']);exit;
//$setting = pdo_fetch('SELECT * FROM ' . tablename('zdaka_config') . ' WHERE uniacid ='.$uniacid);
//$other =json_decode($setting['other_setting'],true);
//$yajins=explode(",",$other['yajin']);
//$share =json_decode($setting['share_setting'],true);

$url =  $_W['siteroot'].str_replace('./','app/',$this->createmobileurl('index')).'&fid='.$uid;
$is_fenxiao=1;
$is_file = 0;
$file = IMG_DAKA_PATH.$uniacid.'/qrcode/qrcode_'.$uniacid.'_'.$uid.'.jpg';
//$file = IMG_DAKA_PATH.$uniacid.'/qrcode/qrcode_'.$uniacid.'1.jpg';
//echo $file;die;
if (file_exists($file)) {
    $is_file=1;
}
include $this->template('yaoqing');


