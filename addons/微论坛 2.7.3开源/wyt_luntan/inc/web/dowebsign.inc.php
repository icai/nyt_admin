<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';

$pagesize=10;
$pageindex =max(1,intval($_GPC['page']));
$total = count(pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_qiandao")."where acid =".$_W['account']['acid']));
$pager = pagination($total, $pageindex, $pagesize);
$p = ($pageindex-1) * $pagesize;
$res = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_qiandao")."where acid =".$_W['account']['acid']." ORDER BY time DESC LIMIT ".$p.",".$pagesize);
foreach ($res as $k => $v){
    $user=pdo_get('wyt_luntan_user',array('acid'=>$_W['account']['acid'],'openid'=>$v['openid']));
    $res[$k]['member']=pdo_get('mc_members',array('uid'=>$user['uid']));
}
include $this->template('web/sign');


