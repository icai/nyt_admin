<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';

if ($action == ''){

    $res = pdo_fetchall('SELECT a.*,b.name,b.acid FROM '.tablename("wyt_luntan_ads").'a left join '.tablename('wyt_luntan_module').' b on a.mobile = b.id where  a.acid ='.$_W['account']['acid'] );

}


if($action=='add1'){
    $data = array(
        'mobile'=>$_GPC['mobile'],
        'display'=>$_GPC['display'],
        'title'=>$_GPC['title'],
        'images'=>$_GPC['images'],
        'url'=>$_GPC['url'],
        'place'=>$_GPC['place'],
        'acid' => $_W['account']['acid'],
    );
    if($_GPC['id'] == ""){
        pdo_insert('wyt_luntan_ads',$data);
        message('添加成功' ,$this->createWebUrl('ads',array('action'=>'')),'success');
    }else{
        pdo_update('wyt_luntan_ads',$data,array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
        message('修改成功' ,$this->createWebUrl('ads',array('action'=>'')),'success');
    }
}

if($action=='delete'){
    $res = pdo_delete('wyt_luntan_ads',array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
    if($res){
        message('删除成功' ,$this->createWebUrl('ads',array('action'=>'')),'success');
    }
}

if($action=='add'){
    $mobilelist=pdo_getall('wyt_luntan_module',array('acid'=>$_W['uniacid']));
    if($_GPC['id']){
        $res1 = pdo_get('wyt_luntan_ads',array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
        $this->createWebUrl('ads',array('action'=>'add'));
    }else{
        $this->createWebUrl('ads',array('action'=>'add'));
    }
}



if($action=='notice_add1'){
    $data = array(
        'title'=>$_GPC['title'],
        'info'=>$_GPC['info'],
        'acid' => $_W['account']['acid'],
    );
    if($_GPC['id'] == ""){
        pdo_insert('wyt_luntan_notice',$data);
        message('添加成功' ,$this->createWebUrl('ads',array('action'=>'notice')),'success');
    }else{
        pdo_update('wyt_luntan_notice',$data,array('id'=>$_GPC['id']));
        message('修改成功' ,$this->createWebUrl('ads',array('action'=>'notice')),'success');
    }
}

if($action=='notice_delete'){
    $res = pdo_delete('wyt_luntan_notice',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功' ,$this->createWebUrl('ads',array('action'=>'notice')),'success');
    }
}

if($action=='notice_add'){
    if($_GPC['id']){
        $res1 = pdo_get('wyt_luntan_notice',array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
        $this->createWebUrl('ads',array('action'=>'notice_add'));
    }else{
        $this->createWebUrl('ads',array('action'=>'notice_add'));
    }
}

if($action=='notice'){
    $res1 = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_notice")."where acid =".$_W['account']['acid']);
}




include $this->template('web/ads');