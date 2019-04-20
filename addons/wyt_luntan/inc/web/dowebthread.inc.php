<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';

if($action=='add1'){

    $data = array(
        'shstate'=>$_GPC['shstate'],
        'title'=>$_GPC['title'],
        'info'=>base64_encode($_GPC['info']),
        'images'=>$_GPC['images']? implode(" ",$_GPC['images']):'',
        'biaoshi'=>1,
        'fenlei'=>$_GPC['fenlei'],
        'nickname'=>$_GPC['nickname'],
        'acid' => $_W['account']['acid'],

    );

        pdo_update('wyt_luntan_thread',$data,array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
        message('修改成功' ,$this->createWebUrl('thread',array('action'=>'')),'success');

}
//显示浏览记录
if ($action == 'browse'){
    $id=$_GPC['id'];
    $userinfo=pdo_fetchall('select a.id,a.add_time,a.openid,b.nickname,b.avatar from '.tablename('wyt_luntan_browse').'as a left join '.tablename('wyt_luntan_user').'as b on a.openid = b.openid where a.thread_id=:id and a.uniacid=:acid',array(':id'=>$id,':acid'=>$_W['uniacid']));

}
if ($action == 'browse_del'){
    $id=$_GPC['id'];
    pdo_delete('wyt_luntan_browse',array('id'=>$id));
    message('删除记录成功' ,$this->createWebUrl('thread',array('action'=>'')),'success');
}


if($action=='shenghe'){

    if($_GPC['id']!=''&&$_GPC['id']!='')
        $res = pdo_update('wyt_luntan_thread',array('shstate'=>$_GPC['shstate']),array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
        echo 1;exit;
    }else{
    echo "";
}
if($action=='zhiding'){
    if($_GPC['id']!=''&&$_GPC['id']!='')
        $res = pdo_update('wyt_luntan_thread',array('zdstate'=>$_GPC['zdstate']),array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
    echo 1;exit;
}else{
    echo "";
}


if($action=='notice'){
    //echo $_GPC['id'];exit;
    if($_GPC['id']!=''&&$_GPC['ggstate']!='')
        $res = pdo_update('wyt_luntan_thread',array('ggstate'=>$_GPC['ggstate']),array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
    echo 1;exit;
}else{
    echo "";
}

if($action=='back'){
	$luntan_module=pdo_getall('wyt_luntan_module',array('acid'=>$_W['account']['acid']));
}

if($action=='addback'){
    $set=pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));

    $data = array(
        'title'=>$_GPC['title'],
        'info'=>base64_encode($_GPC['info']),
        'images'=>$_GPC['images']? implode(" ",$_GPC['images']):'',
        'nickname'=>$set['nickname'],
        'openid'=>$set['openid'],
        'uid'=>$set['uid'],
        'biaoshi'=>1,
        'tbiaoshi'=>1,
        'acid' => $_W['account']['acid'],
        'address'=>$set['address'],
        'fenlei'=>$_GPC['fenlei'],
        'avatar' => $set['avatar'],
        'time'=>date('m-d H:i'),
        'pl_time'=>date('Y-m-d H:i'),


    );
        pdo_insert('wyt_luntan_thread',$data);
        message('添加成功' ,$this->createWebUrl('thread',array('action'=>'')),'success');
}

if($action=='delete'){
    $res = pdo_delete('wyt_luntan_thread',array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
    if($res){
        message('删除成功' ,$this->createWebUrl('thread',array('action'=>'')),'success');
    }
}

if($action=='add'){
    if($_GPC['id']){
        $res1 = pdo_get('wyt_luntan_thread',array('id'=>$_GPC['id'],'acid' => $_W['account']['acid']));
		$res1['info']=base64_encode(base64_decode($res1['info']))== $res1['info']? base64_decode($res1['info']) : $res1['info'];
        $luntan_module=pdo_getall('wyt_luntan_module',array('acid'=>$_W['account']['acid']));

        if($res1['biaoshi']==2){
           $images1 = unserialize($res1['images']);           
		   if(!empty($images1)){
		      foreach ($images1 as $k=>$v){
	               if(isset($v['name'])){
	                   $images2[$k]=$v['name'];
	               }else{
	                   $images2[$k]=$v;
	               }
	
	           } 
		   }           
       }else{
           $images=explode(" ",$res1['images']);
       }


        $this->createWebUrl('thread',array('action'=>'add'));
    }
}

if($action=='export'){
   $a= $this->export();
    var_dump($a);
}

$set=pdo_get('wyt_luntan_set',array('acid'=>$acid));
$pagesize=10;
$pageindex =max(1,intval($_GPC['page']));
$total = count(pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_thread")."where acid =".$_W['account']['acid']));
$pager = pagination($total, $pageindex, $pagesize);
$p = ($pageindex-1) * $pagesize;
$res = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_thread")."where acid =".$_W['account']['acid']." ORDER BY id DESC LIMIT ".$p.",".$pagesize);
foreach ($res as $k => $v){
    $res[$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
    $res[$k]['info2']=mb_substr($res[$k]['info1'], 0,20, 'utf-8');

}
include $this->template('web/thread');


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
