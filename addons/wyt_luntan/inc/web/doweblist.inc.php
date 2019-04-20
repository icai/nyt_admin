<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';
$acid=$_W['account']['acid'];
if($action==''){
    $res=pdo_getall('wyt_luntan_list',array('acid'=>$acid));

}
if($action=='add'){
    if($_GPC['id']!=''){
        $res=pdo_get('wyt_luntan_list',array('id'=>$_GPC['id'],'acid'=>$acid));

    }
    if($_W['ispost']){
        $data = $_POST;
        $data['acid'] = $acid;
        if($_GPC['id']==''){
            pdo_insert('wyt_luntan_list',$data,array('acid' => $acid));
            message('添加成功' ,$this->createWebUrl('list',array('action'=>'')),'success');
        }else{
            pdo_update('wyt_luntan_list',$data,array('acid' => $acid,'id'=>$_GPC['id']));
            message('修改成功' ,$this->createWebUrl('list',array('action'=>'')),'success');
        }

    }


}
if($action=='delete'){
    pdo_delete('wyt_luntan_list',array('id'=>$_GPC['id'],'acid' => $acid));
    message('删除成功' ,$this->createWebUrl('list',array('action'=>'')),'success');

}


include $this->template('web/list');
