<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';

if($action=='opinion'){
    $pagesize=10;
    $pageindex =max(1,intval($_GPC['page']));
    $total = count(pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_opinion")."where acid =".$_W['account']['acid']));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex-1) * $pagesize;
    $res1 = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_opinion")."where acid =".$_W['account']['acid']." ORDER BY id DESC LIMIT ".$p.",".$pagesize);

    foreach ($res1 as $k=>$v){
        $res1[$k]['user']=pdo_get('wyt_luntan_user',array('openid'=>$v['openid'],'acid'=>$_W['account']['acid']));
    }
}

if($action=='delete'){
    $res = pdo_delete('wyt_luntan_ads',array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
    if($res){
        message('删除成功' ,$this->createWebUrl('information',array('action'=>'')),'success');
    }
}
if($action=='opinion_delete'){
    $res = pdo_delete('wyt_luntan_opinion',array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
    if($res){
        message('删除成功' ,$this->createWebUrl('information',array('action'=>'opinion')),'success');
    }
}

if($action=='add'){
    if($_GPC['id']) {
        $res1 = pdo_get('wyt_luntan_opinion', array('id' => $_GPC['id'],'acid'=>$_W['account']['acid']));
       $res1['user']=pdo_get('wyt_luntan_user', array('openid' => $res1['openid'],'acid'=>$_W['account']['acid']));
        $this->createWebUrl('ads', array('action' => 'info'));
    }
}
$res = pdo_fetch("SELECT * FROM ".tablename("wyt_luntan_information")."where acid =".$_W['account']['acid']);
if(!$res){
    pdo_insert("wyt_luntan_information",array('acid'=>$_W['account']['acid']));
}
$user=pdo_getall("wyt_luntan_user",array('acid'=>$_W['account']['acid']));
$thread=pdo_getall("wyt_luntan_thread",array('acid'=>$_W['account']['acid']));

if ($action =='report'){
    $res=pdo_fetchall('select a.*,b.nickname,b.avatar from '.tablename('wyt_luntan_report').'as a left join '.tablename('wyt_luntan_user').'as b on a.openid=b.openid where a.uniacid=:acid',array(':acid'=>$_W['uniacid']));

}
if ($action == 'report_info'){
    $id=$_GPC['id'];
    $res=pdo_get('wyt_luntan_report',array('id'=>$id));
}



include $this->template('web/information');