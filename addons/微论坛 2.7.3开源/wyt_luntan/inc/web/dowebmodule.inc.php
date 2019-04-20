<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';

if($action=='add1'){
    $data = array(
        'images'=>$_GPC['images'],
        'name'=>$_GPC['name'],
        'admin'=>$_GPC['admin'],
        'send'=>$_GPC['send'],
        'reply'=>$_GPC['reply'],
        'jifen'=>$_GPC['jifen'],
        'acid' => $_W['account']['acid'],
    );
    if($_GPC['id'] == ""){
        pdo_insert('wyt_luntan_module',$data);
        message('添加成功' ,$this->createWebUrl('module',array('action'=>'')),'success');
    }else{
        pdo_update('wyt_luntan_module',$data,array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
        message('修改成功' ,$this->createWebUrl('module',array('action'=>'')),'success');
    }
}

if($action=='delete'){
    $res = pdo_delete('wyt_luntan_module',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功' ,$this->createWebUrl('module',array('action'=>'','acid'=>$_W['account']['acid'])),'success');
    }
}
if($action=='add'){
    if($_GPC['id']){
        $res1 = pdo_get('wyt_luntan_module',array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
        $this->createWebUrl('module',array('action'=>'add'));
    }else{
        $this->createWebUrl('module',array('action'=>'add'));
    }
}


$res = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_module")."where acid =".$_W['account']['acid']);

include $this->template('web/module');