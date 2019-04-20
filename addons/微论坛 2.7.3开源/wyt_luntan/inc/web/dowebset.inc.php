<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';

if($action==''){
    $res = pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));
    if($_W['ispost']){

        $data = array(
            'name'=>$_GPC['name'],
            'state'=>$_POST['state'],
            'vstate'=>$_POST['vstate'],
            'jianjie'=>$_GPC['jianjie'],
            'logo'=>$_GPC['logo'],
            'erwei'=>$_GPC['erwei'],
            'beij'=>$_GPC['beij'],
            'member'=>$_GPC['member'],
            'thread'=>$_GPC['thread'],
            'send'=>$_GPC['send'],
            'reply'=>$_GPC['reply'],
            'shouxu'=>$_GPC['shouxu'],
            'mes'=>$_GPC['mes'],
            'dingdan'=>$_GPC['dingdan'],
            'zengjia'=>$_GPC['zengjia'],
            'acid' => $_W['account']['acid'],
            'admin'=>$_GPC['admin'],
            'mobiletime'=>$_GPC['mobiletime'],
            'postauth'=>$_GPC['postauth'],
            'follow'=>$_GPC['follow'],
            'biz_id'=>$_GPC['biz_id'],
            'sign'=>$_GPC['sign']<=1?1:$_GPC['sign'],
            'sign1'=>$_GPC['sign1']<=1?1:$_GPC['sign1'],
            'tixian_limit'=>trim($_GPC['tixian_limit']),
            'dashang_limit'=>trim($_GPC['dashang_limit']),
            'credit1'=>trim($_GPC['credit1']),
            'award_days'=>$_GPC['award_days'],
            'dashang_moneys'=>trim($_GPC['dashang_moneys']),
            'qq_address_key'=>trim($_GPC['qq_address_key'])
        );
        if($res == ""){
            pdo_insert('wyt_luntan_set',$data);
            message('添加成功' ,$this->createWebUrl('Set',array('action'=>'')),'success');
        }else{
            pdo_update('wyt_luntan_set',$data,array('acid'=>$_W['account']['acid']));
            message('修改成功' ,$this->createWebUrl('Set',array('action'=>'')),'success');
        }

    }

}



if($action=='admin'){
    $res = pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));
    if($_W['ispost']) {
        $data = array(
            'nickname' => $_GPC['nickname'],
            'avatar' => $_GPC['avatar'],
            'address' => $_GPC['address'],
            'openid' => $_GPC['openid'],
            'uid' => $_GPC['uid'],
        );
        pdo_update('wyt_luntan_set', $data, array('acid' => $_W['account']['acid']));
        message('修改成功', $this->createWebUrl('Set', array('action' => 'admin')), 'success');
    }
}
if($action=='self'){
    $res1 = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_self")."where acid =".$_W['account']['acid']);
}
if($action=='withdraw'){
    $res = pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));
    if($_W['ispost']) {
        load()->func('file');
        mkdirs(MODULE_ROOT."/pay/".$_W['account']['acid']);
        $url1 = MODULE_ROOT."/pay/".$_W['account']['acid'];
        if($_GPC['cert'] !=''){
            file_put_contents($url1.'/cert.pem',trim($_GPC['cert']));
        }
        if($_GPC['key'] !=''){
            file_put_contents($url1.'/key.pem',trim($_GPC['key']));
        }
        $data = array(
            'tstate'=>$_GPC['tstate'],
            'appsecret' => trim($_GPC['appsecret']),
            'mch_id' => trim($_GPC['mch_id']),
            'partnerkey' => trim($_GPC['partnerkey']),
        );
        pdo_update('wyt_luntan_set', $data, array('acid' => $_W['account']['acid']));
        message('修改成功', $this->createWebUrl('Set', array('action' => 'withdraw')), 'success');
    }



}



if($action=='self_add1'){
    $data = array(
        'title'=>$_GPC['title'],
        'images'=>$_GPC['images'],
        'url'=>$_GPC['url'],
//        'place'=>$_GPC['place'],
        'acid' => $_W['account']['acid'],
    );
    if($_GPC['id'] == ""){
        pdo_insert('wyt_luntan_self',$data);
        message('添加成功' ,$this->createWebUrl('set',array('action'=>'self')),'success');
    }else{
        pdo_update('wyt_luntan_self',$data,array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
        message('修改成功' ,$this->createWebUrl('set',array('action'=>'self')),'success');
    }
}

if($action=='self_delete'){
    $res = pdo_delete('wyt_luntan_self',array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
    if($res){
        message('删除成功' ,$this->createWebUrl('set',array('action'=>'self')),'success');
    }
}

if($action=='self_add'){
    if($_GPC['id']){
        $res1 = pdo_get('wyt_luntan_self',array('id'=>$_GPC['id'],'acid'=>$_W['account']['acid']));
        $this->createWebUrl('set',array('action'=>'self_add'));
    }else{
        $this->createWebUrl('set',array('action'=>'self_add'));
    }
}

include $this->template('web/set');