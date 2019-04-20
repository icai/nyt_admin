<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';
$set=pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));
if($action=='add1'){
    $data = array(
        'avatar'=>$_GPC['images'],
        'nickname'=>$_GPC['nickname'],
        'send'=>$_GPC['send'],
        'jifen'=>$_GPC['jifen'],
        'acid' => $_W['account']['acid'],
    );
    if($_GPC['id'] == ""){
        pdo_insert('wyt_luntan_user',$data);
        message('添加成功' ,$this->createWebUrl('user',array('action'=>'')),'success');
    }else{
        $uid=pdo_fetchcolumn('select uid from '.tablename('wyt_luntan_user').'where id=:id ',array(':id'=>$_GPC['id']));
        mc_credit_update($uid, 'credit1',$_GPC['jifen'], array($uid, '后台更改积分: '.$data['jifen']));
        pdo_update('wyt_luntan_user',$data,array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
        $data['avatar']=tomedia($_GPC['images']);
        pdo_update('wyt_luntan_user',$data,array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
        message('修改成功' ,$this->createWebUrl('user',array('action'=>'')),'success');
    }
}

if($action=='delete'){
    $res = pdo_delete('wyt_luntan_user',array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
    if($res){
        message('删除成功' ,$this->createWebUrl('user',array('action'=>'')),'success');
    }
}
if($action=='invite'){
    $invite = pdo_getall('wyt_luntan_user',array('pid'=>$_GPC['uid'],'acid' => $_W['account']['acid']));
    foreach ($invite  as $k => $v){
        $invite [$k]['fatie']=pdo_getall("wyt_luntan_thread",array('openid'=>$v['openid']));
        $invite [$k]['jifen1']=pdo_get("mc_members",array('uid'=>$v['uid']));
    }

}

if($action=='tixian'){
    $pagesize=10;
    $pageindex =max(1,intval($_GPC['page']));
    $total = count(pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_tixian")."where acid =".$_W['account']['acid']));
    $pager1 = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex-1) * $pagesize;
    $tixian = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_tixian")."where acid =".$_W['account']['acid']." ORDER BY id DESC LIMIT ".$p.",".$pagesize);
    include $this->template('web/user');exit;
}
if($action=='tixian1') {
    $data= pdo_get('wyt_luntan_tixian',array('id' => $_GPC['id']));
    if($_GPC['aa']==1){
        $aa=$this->txian($data['openid'],$data['uid'],$data['money']);
       if($aa==1){
           $tixian = pdo_update('wyt_luntan_tixian', array('state' => 2), array('id' => $_GPC['id']));
           echo $tixian;exit;
       }
    }
    $tixian = pdo_update('wyt_luntan_tixian', array('state' => 2), array('id' => $_GPC['id']));
    if($tixian){
        message('提现成功',$this->createWebUrl('User',array('action'=>'tixian')),'success');
    }
}

if($action=='lahei'){
    $data = array(
        'state'=>1,
    );
    $res =  pdo_update('wyt_luntan_user',$data,array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
    message('拉黑成功' ,$this->createWebUrl('user',array('action'=>'')),'success');
}
if($action=='labai'){
    $data = array(
        'state'=>0,
    );
    $res =  pdo_update('wyt_luntan_user',$data,array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
    message('拉白成功' ,$this->createWebUrl('user',array('action'=>'')),'success');
}


if($action=='add'){
    $id = $_GPC['id'];

    if($_GPC['id']){

        $userinfo=pdo_fetch("select * from ".tablename('wyt_luntan_user')."where id = {$id} and  acid =:acid",array(':acid'=>$_W['account']['acid']));
        $userinfo['credit1']=pdo_fetchcolumn('select credit1 from '.tablename('mc_members').'where uid =:uid',array(':uid'=>$userinfo['uid']));

//        $res1 = pdo_get('wyt_luntan_user',array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));

        $this->createWebUrl('user',array('action'=>'add1'));

    }else{
        message('用户不存在' ,$this->createWebUrl('user',array('action'=>'')),'error');
    }
}

if($action=='heimingdan'){
    $pagesize=10;
    $pageindex =max(1,intval($_GPC['page']));

    $condition ="where state = 1 and acid =".$_W['account']['acid'];

    $nickname=$_GPC['username'];

    $total = count(pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_user").$condition));

    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex-1) * $pagesize;
    $res = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_user").$condition." ORDER BY id DESC LIMIT ".$p.",".$pagesize);
    foreach ($res as $k => $v){
        $res[$k]['fatie']=pdo_getall("wyt_luntan_thread",array('openid'=>$v['openid']));
        $res[$k]['jifen1']=pdo_get("mc_members",array('uid'=>$v['uid']));
    }
    include $this->template('web/user');die;
}

$pagesize=10;
$pageindex =max(1,intval($_GPC['page']));

$condition ="where acid =".$_W['account']['acid'];

if (!empty($_GPC['username'])){

        $condition.=' and nickname like  "%'.$_GPC['username'].'%"';

}
$nickname=$_GPC['username'];

$total = count(pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_user").$condition));

$pager = pagination($total, $pageindex, $pagesize);
$p = ($pageindex-1) * $pagesize;
$res = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_user").$condition." ORDER BY id DESC LIMIT ".$p.",".$pagesize);
foreach ($res as $k => $v){
    $res[$k]['fatie']=pdo_getall("wyt_luntan_thread",array('openid'=>$v['openid']));
    $res[$k]['jifen1']=pdo_get("mc_members",array('uid'=>$v['uid']));
}
include $this->template('web/user');