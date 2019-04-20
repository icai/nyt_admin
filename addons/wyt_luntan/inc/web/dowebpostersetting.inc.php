<?php
global $_W,$_GPC;
$setting = pdo_fetch('SELECT * FROM ' . tablename('wyt_luntan_config') . ' WHERE uniacid ='.$_W['uniacid']);
$set = json_decode($setting['poster_setting'],true);
$data = json_decode($set['data'],true);

if($_GPC['op']==""||$_GPC['op']=='poster_bg'){
$operation = 'poster_bg';

}
else if($_GPC['op']=='poster_dis'){
$operation = 'poster_dis';
}

if (checksubmit ()) {
$data = array (
'hb_bg' => $_GPC ['hb_bg'],
'zhanji' => $_GPC ['zhanji'],
'data' => htmlspecialchars_decode($_GPC ['data']),
);
$jsonStr = json_encode($data);
if (!$set) {
$d = array(
'uniacid' => $_W['uniacid'],
'poster_setting' =>$jsonStr,
);
pdo_insert('wyt_luntan_config', $d);
}
else{
pdo_update('wyt_luntan_config', array('poster_setting' =>$jsonStr),array('uniacid' => $_W['uniacid']));
}
message('操作成功',referer(),'success');
}
include $this->template('web/postersetting');