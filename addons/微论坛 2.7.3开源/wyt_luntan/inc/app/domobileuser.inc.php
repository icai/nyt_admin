<?php
global $_W,$_GPC;
$action=$_GPC['action']?$_GPC['action']:'';
$openid=$_W['fans']['openid'];
$acid=$_W['account']['acid'];
if (empty($_W['fans']['nickname'])) {
    mc_oauth_userinfo();
}
$set=pdo_get('wyt_luntan_set',array('acid'=>$acid));
if($action == ""){
    $user = pdo_get('wyt_luntan_user',array('openid'=>$openid));
    if(!$user){
        $data_user=array(
            'openid'=>$openid,
            'nickname'=>$_W['fans']['nickname'],
            'avatar'=>$_W['fans']['avatar'],
            'acid'=>$acid
        );
        pdo_insert('wyt_luntan_user',$data_user);
    }
    //$set=pdo_get('wyt_luntan_set',array('acid'=>$acid));
    $ads=pdo_getall('wyt_luntan_ads',array('acid'=>$acid));
    $information=pdo_get('wyt_luntan_information',array('acid'=>$acid));
    $qiandao=pdo_get('wyt_luntan_qiandao',array('openid'=>$openid,'time'=>date('Y-m-d')));
    $data=array(
        'fangwen'=>$information['fangwen']+1
    );
    pdo_update('wyt_luntan_information',$data,array('acid'=>$acid));
    //var_dump($information);
    $fenlei=pdo_getall('wyt_luntan_module',array('acid'=>$acid));
    $sumrow=pdo_getall('wyt_luntan_thread',array('acid'=>$acid));
    $row = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_thread")." ORDER BY time DESC LIMIT 0,4");
    $huati =count($sumrow);
    foreach ($row as $k => $v){
        //$lv=pdo_get('wyt_luntan_user',array('openid'=>$v['openid']));
        //$row[$k]['lv']=$lv['lv'];
        $row[$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
        if($v['biaoshi']==2){
            $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=explode(" ",$v['images']);
        }
    }

    include $this->template("index");
}

if($action == "fatie"){
    $fenlei=pdo_getall('wyt_luntan_module',array('acid'=>$acid));
    include $this->template("fatie");
}
if($action == "other"){
    if($openid==$_GPC['openid']){
        header('Location:' . $this->createMobileUrl('Index', array('action'=>'user')));
    }
    $user = pdo_get('wyt_luntan_user',array('openid'=>$_GPC['openid']));
    include $this->template("other");
}
if($action == "info"){
    $res=pdo_get('wyt_luntan_thread',array('id'=>$_GPC['id']));
         $data=array(
            'looks'=>$res['looks']+1
         );
        $looks=pdo_update('wyt_luntan_thread',$data,array('id'=>$_GPC['id']));
        $res['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
        if($res['biaoshi']==2){
            $res['images'] = unserialize($res['images']);
        }else{
            $res['images']=explode(" ",$res['images']);
        }
    $pl=pdo_getall('wyt_luntan_pinglun',array('user_id'=>$openid,'thread_id'=>$_GPC['id'],'pid'=>0));
    foreach($pl as $k => $v){
        $pl[$k]['hui1']=pdo_getall('wyt_luntan_pinglun',array('user_id'=>$openid,'thread_id'=>$_GPC['id'],'pid'=>$v['id']));
            $pl[$k]['images'] = unserialize($v['images']);

    }


    include $this->template("info");
}



if($action == "pinglun"){
    $media = $_GPC['images'];
    if($media != "")
    {
        $images = serialize(Base::downloadimgages($media));  //图片上传
    }
    $data=array(
        'thread_id'=>$_GPC['tid'],
        'user_id'=>$openid,
        'images'=>$images,
        'info'=>$_GPC['info'],
        'nickname' => $_W['fans']['nickname'],
        'avatar' => $_W['fans']['tag']['avatar'],
        'time'=>date('m-d H:s'),
        'acid' => $_W['account']['acid'],

    );

    pdo_insert('wyt_luntan_pinglun', $data);
    $thread=pdo_get('wyt_luntan_thread',array('id'=>$_GPC['tid']));
    $data1=array(
        'pl'=>$thread['pl']+1
    );
    $thread=pdo_update('wyt_luntan_thread',$data1,array('id'=>$_GPC['tid']));
    message('评论成功',$this->createMobileUrl('Index',array('action'=>'info','id'=>$_GPC['tid'])));
}
if($action=='qiandao'){

    $qiandao=pdo_get('wyt_luntan_qiandao',array('openid'=>$openid,'time'=>date('Y-m-d')));

    //$zan = pdo_fetch("SELECT * FROM ".tablename("wyt_luntan_zan")." WHERE openid = $openid AND thread_id = $tid AND ")
    if($qiandao){
        echo 1;exit;
    }else{

        $data1=array(
            'openid'=>$openid,
            'time'=>date('Y-m-d'),
            'acid' => $_W['account']['acid'],
        );
        $dao=pdo_insert('wyt_luntan_qiandao',$data1);
        pdo_query("UPDATE ".tablename('mc_members')." SET credit1=credit1+".$jifen['qiandao']." WHERE uid=".$_W['fans']['uid']);
        echo 2;exit;
    }
}
if($action=='dashang'){
    $res=pdo_get('wyt_luntan_thread',array('id'=>$_GPC['id']));
    include $this->template("dashang");
}

if($action=='dashang_order'){
    $data=array(
        'thread_id'=>$_GPC['tid'],
        'topenid'=>$_GPC['topenid'],
        'money'=>$_GPC['money'],
        'dopenid'=>$openid,
        'time'=>date('Y-m-d H:i:s'),
        'acid' => $_W['account']['acid'],
        'serial'=>time().rand(0000,9999)
    );
    $max = pdo_insert('wyt_luntan_pay',$data);
    if($max){
        header('Location:' . $this->createMobileUrl('pay', array('orderid' => $data['serial'])));
        }
}

if($action=='pay_s'){
    $data['serial'] = $_GPC['orderid'];

    $max = pdo_update('wyt_luntan_pay',array('state'=>1),$data);
    if($max){
        $thread_id =pdo_get('wyt_luntan_pay',$data);
        $thread =pdo_get('wyt_luntan_thread',array('id'=>$thread_id['thread_id']));
        $data1['money'] = $thread['money']+$thread_id['money'];
        $hh=pdo_update('wyt_luntan_thread',$data1,array('id'=>$thread_id['thread_id']));

        header('Location:' . $this->createMobileUrl('Index', array('action'=>'info','id'=>$thread_id['thread_id'])));}
}

if($action=='huifu'){
    include $this->template("pinglun");
}

if($action=='pinglun1'){
    include $this->template("pinglun");
}
if($action=='huifu2'){
    include $this->template("pinglun");

}
if($action=='huifu3'){
    $media = $_GPC['images'];
    if($media != "")
    {
        $images = serialize(Base::downloadimgages($media));  //图片上传
    }
    $data=array(
        'thread_id'=>$_GPC['tid'],
        'user_id'=>$openid,
        'images'=>$images,
        'pid'=>$_GPC['pid'],
        'hid'=>$_GPC['hid'],
        'hname'=>$_GPC['hname'],
        'info'=>$_GPC['info'],
        'nickname' => $_W['fans']['nickname'],
        'avatar' => $_W['fans']['tag']['avatar'],
        'time'=>date('m-d H:s'),
        'acid' => $_W['account']['acid'],
    );
    $res=pdo_insert('wyt_luntan_pinglun', $data);
    if($res){
        message('评论成功',$this->createMobileUrl('Index',array('action'=>'info','id'=>$_GPC['tid'])));
    }

    include $this->template("pinglun");
}
if($action=='huifu1'){

    $media = $_GPC['images'];
    if($media != "")
    {
        $images = serialize(Base::downloadimgages($media));  //图片上传
    }
    $data=array(
        'thread_id'=>$_GPC['tid'],
        'user_id'=>$openid,
        'images'=>$images,
        'pid'=>$_GPC['pid'],
        'hid'=>$_GPC['hid'],
        'hname'=>$_GPC['hname'],
        'info'=>$_GPC['info'],
        'nickname' => $_W['fans']['nickname'],
        'avatar' => $_W['fans']['tag']['avatar'],
        'time'=>date('m-d H:s'),
        'acid' => $_W['account']['acid'],
    );
    $res=pdo_insert('wyt_luntan_pinglun', $data);
    if($res){
        message('评论成功',$this->createMobileUrl('Index',array('action'=>'info','id'=>$_GPC['tid'])));
    }
    var_dump($data);exit;
    include $this->template("pinglun");

}
if($action == "fatie1"){
    $media = $_GPC['images'];
    //var_dump($_GPC['images']);exit;
    if($media != "")
    {
        $images = serialize(Base::downloadimgages($media));  //图片上传
    }
    $data = array(
        'title'=>$_GPC['title'],
        'images'=>$images,
        'address'=>$_GPC['address'],
        'info'=>$_GPC['info'],
        'fenlei'=>$_GPC['fenlei1'],
        'openid' => $_W['fans']['openid'],
        'uid' => $_W['fans']['uid'],
        'nickname' => $_W['fans']['nickname'],
        'avatar' => $_W['fans']['tag']['avatar'],
        'time'=>date('m-d H:s'),
        'biaoshi'=>2,
        'acid' => $_W['account']['acid'],
    );
    $res=pdo_insert('wyt_luntan_thread', $data);
        if($res){
        message('发表成功', $this->createMobileUrl('index', array('action' => '')), 'success');
        }
}

if($action == "my_index"){
    $row = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_thread")." WHERE openid = '".$openid."'"." ORDER BY time DESC LIMIT  0,4 ");
    foreach ($row as $k => $v){
        $row[$k]['info1']=text($v['info']);
        if($v['biaoshi']==2){
        $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=explode(" ",$v['images']);
        }
    }
    include $this->template("user/my_index");
}
if($action == "user"){
    $user = pdo_get('wyt_luntan_user',array('openid'=>$openid));
    $thread = pdo_get('wyt_luntan_thread',array('openid'=>$openid));
    $sum_thread=count($thread);
    include $this->template("user");
}
if($action == "zan"){
    $tid=$_GPC['tid'];
    $zan=pdo_get('wyt_luntan_zan',array('user_id'=>$openid,'thread_id'=>$tid));

    //$zan = pdo_fetch("SELECT * FROM ".tablename("wyt_luntan_zan")." WHERE openid = $openid AND thread_id = $tid AND ")
    if($zan){
        echo 1;exit;
    }else{
        $thread=pdo_get('wyt_luntan_thread',array('id'=>$tid));
        $data=array(
            'zan'=>$thread['zan']+1
        );
        $thread=pdo_update('wyt_luntan_thread',$data,array('id'=>$tid));
        $data1=array(
            'user_id'=>$openid,
            'thread_id'=>$tid,
            'time'=>date('m-d H:s'),
        );
        $zan1=pdo_insert('wyt_luntan_zan',$data1);
        $user=pdo_get('wyt_luntan_user',array('openid'=>$thread['openid']));
        $data2=array(
            'jifen'=>$user['jifen']+1,

        );
        $user1=pdo_update('wyt_luntan_user',$data2,array('openid'=>$thread['openid']));
        echo 2;exit;
    }
}

if($action == "zan1"){
    $pid=$_GPC['pid'];
    $zan=pdo_get('wyt_luntan_zan',array('user_id'=>$openid,'pl_id'=>$pid));

    //$zan = pdo_fetch("SELECT * FROM ".tablename("wyt_luntan_zan")." WHERE openid = $openid AND thread_id = $tid AND ")
    if($zan){
        echo 1;exit;
    }else{
        $pl=pdo_get('wyt_luntan_pinglun',array('id'=>$pid));
        $data=array(
            'zan'=>$pl['zan']+1
        );
        $pl=pdo_update('wyt_luntan_pinglun',$data,array('id'=>$pid));
        $data1=array(
            'user_id'=>$openid,
            'pl_id'=>$pid,
            'time'=>date('m-d H:s'),
        );
        $zan1=pdo_insert('wyt_luntan_zan',$data1);
        $user=pdo_get('wyt_luntan_user',array('openid'=>$pl['openid']));
        $data2=array(
            'jifen'=>$user['jifen']+1,

        );
        $user1=pdo_update('wyt_luntan_user',$data2,array('openid'=>$pl['openid']));
        echo 2;exit;
    }
}


if($action == "data_thread"){

    $page=(int)$_GPC['page'];
    $size=4;
    $row=pdo_fetchall(' SELECT * FROM '.tablename('wyt_luntan_thread')."WHERE fenlei = $cid ORDER BY time DESC LIMIT ".($page-1) * $size.','.$size);
    foreach ($row as $k => $v){
        $row[$k]['info1']=text($v['info']);
        if($v['biaoshi']==2){
            $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=explode(" ",$v['images']);
        }
    }
    if($row){
        echo json_encode($row);exit;
    }else{
        echo 0;exit;
    }
}

//意见反馈
if($action == "opinion"){
    if($_W['ispost']){
        $data['info']=$_GPC['info'];
        $data['openid']=$_W['fans']['openid'];
        $data['acid']=$_W['account']['acid'];
        $res=pdo_insert('wyt_luntan_opinion',$data);
        if($res){
            message('感谢您的反馈',$this->createMobileUrl('User'));
        }
    }
    include $this->template("user/opinion");
}
if($action == "dashangjl"){
    $pays = pdo_getall('wyt_luntan_pay',array('topenid'=>$openid,'state'=>1), array() , '' , 'time DESC');
    $sumpays=count($pays);
    foreach ($pays as $k=>$v){
        $pays[$k]['user'] = pdo_get('wyt_luntan_user',array('openid'=>$v['dopenid']));
    }
    include $this->template("user/dashangjl");
}
if($action == "collection"){
    $user = pdo_get('wyt_luntan_user',array('openid'=>$openid));
    $row = pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_collection") ." WHERE acid = ".$_W['account']['acid']." AND openid = '".$openid."'");
    foreach ($row as $k => $v){
        $row[$k]['col'] =pdo_fetch("SELECT * FROM " . tablename("wyt_luntan_thread") ." WHERE acid = ".$_W['account']['acid']." AND id = '".$v['thread_id']."'");
        $row[$k]['col']['info1']=text($v['info']);
            if($row[$k]['col']['biaoshi']==2){
                $row[$k]['col']['images'] = unserialize($row[$k]['col']['images']);
            }else{
                $row[$k]['col']['images']=explode(" ",$row[$k]['col']['images']);
            }

    }

    include $this->template("user/collection");
}
if($action == "quxiao"){

    $res=pdo_delete('wyt_luntan_collection', array('id'=>$_GPC['id']));
    if($res){
        header('Location:' . $this->createMobileUrl('user', array('action'=>'collection')));
    }
}
if($action == "guanzhu"){
    $user = pdo_get('wyt_luntan_user',array('openid'=>$openid));
    $row = pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_guanzhu") ." WHERE acid = ".$_W['account']['acid']." AND openid = '".$openid."'");
    foreach ($row as $k => $v){
        $row[$k]['col'] =pdo_fetch("SELECT * FROM " . tablename("wyt_luntan_user") ." WHERE acid = ".$_W['account']['acid']." AND openid = '".$v['bopenid']."'");
    }
    include $this->template("user/guanzhu");
}

if($action == "bguanzhu"){
    $res=pdo_delete('wyt_luntan_guanzhu', array('bopenid'=>$_GPC['id'],'openid'=>$openid,'acid'=>$acid));
    if($res){
        header('Location:' . $this->createMobileUrl('user', array('action'=>'guanzhu')));
    }
}
if($action == "load_data"){
    $page=(int)$_GPC['page'];
    $cid=$_GPC['fenlei'];
    $size=4;
    $row=pdo_fetchall(' SELECT * FROM '.tablename('wyt_luntan_thread')." WHERE acid=".$acid." and openid = '".$cid."'"." ORDER BY time DESC LIMIT ".($page-1) * $size.','.$size);
    foreach ($row as $k => $v){
        $row[$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
        if($v['biaoshi']==2){
            $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=explode(" ",$v['images']);
        }
    }
    if($row){
        echo json_encode($row);exit;
    }else{
        echo 0;exit;
    }
}


function text($str){
    $str = preg_replace("/<style .*?<\\/style>/is", "", $str);
    $str = preg_replace("/<script .*?<\\/script>/is", "", $str);
    $str = preg_replace("/<br \\s*\\/>/i", ">>>>", $str);
    $str = preg_replace("/<\\/?p>/i", ">>>>", $str);
    $str = preg_replace("/<\\/?td>/i", "", $str);
    $str = preg_replace("/<\\/?div>/i", ">>>>", $str);
    $str = preg_replace("/<\\/?blockquote>/i", "", $str);
    $str = preg_replace("/<\\/?li>/i", ">>>>", $str);
    $str = preg_replace("/ /i", " ", $str);
    $str = preg_replace("/ /i", " ", $str);
    $str = preg_replace("/&/i", "&", $str);
    $str = preg_replace("/&/i", "&", $str);
    $str = preg_replace("/</i", "<", $str);
    $str = preg_replace("/</i", "<", $str);
    $str = preg_replace("/“/i", '"', $str);
    $str = preg_replace("/&ldquo/i", '"', $str);
    $str = preg_replace("/‘/i", "'", $str);
    $str = preg_replace("/&lsquo/i", "'", $str);
    $str = preg_replace("/'/i", "'", $str);
    $str = preg_replace("/&rsquo/i", "'", $str);
    $str = preg_replace("/>/i", ">", $str);
    $str = preg_replace("/>/i", ">", $str);
    $str = preg_replace("/”/i", '"', $str);
    $str = preg_replace("/&rdquo/i", '"', $str);
    $str = strip_tags($str);
    $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/&#.*?;/i", "", $str);
    return $str;
}
