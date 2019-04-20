<?php
global $_W,$_GPC;
$action=$_GPC['action']?$_GPC['action']:'';
$openid=$_W['fans']['openid'];
$acid=$_W['account']['acid'];
if (empty($_W['fans']['nickname'])||empty($_W['fans']['openid'])) {
    mc_oauth_userinfo();
}
$moduleadmin=pdo_getall('wyt_luntan_module',array('acid'=>$acid));
foreach ($moduleadmin as $k =>$v){
    if ($v['admin']==$openid){
        $adminstr[]=$v['name'];
    }
}
$set=pdo_get('wyt_luntan_set',array('acid'=>$acid));

$advpage=$set['mobiletime'];
$admins = explode('/',$set['admin']);//管理员
$auth=$set['postauth'];
foreach ($admins as $k=>$v){
    if($v==$openid){
        $admin=$openid;
    }
}
//关注公众号开关
if (!empty($set['follow'])){
    if (empty($_W['fans']['follow'])){
        //用户没有关注公众号跳转引导关注页
        header('location:https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz='.$set['biz_id'].'==&scene=110#wechat_redirect');
    }
}
$user = pdo_get('wyt_luntan_user',array('openid'=>$openid,'acid'=>$acid));//当前用户信息
if($user == ""&&$openid !=''){
    if (!empty($_GPC['fid'])){
        mc_credit_update($_GPC['fid'], 'credit1', $set['credit1'], array($_GPC['fid'], '邀请好友获得'. $set['credit1'].'积分'));
    }
    $data_user=array(
        'openid'=>$openid,
        'nickname'=>$_W['fans']['nickname'],
        'avatar'=>$_W['fans']['avatar'],
        'uid'=>$_W['fans']['uid'],
        'acid'=>$acid,
        'pid'=>!empty($_GPC['fid'])?$_GPC['fid']:0,
    );
    
    pdo_insert('wyt_luntan_user',$data_user);
    $ifm = pdo_get('wyt_luntan_information',array('acid'=>$acid));
    $data_ifm['user'] = $ifm['user']+1;
    $ifm = pdo_update('wyt_luntan_information', $data_ifm,array('acid'=>$acid));
}
if($user['state']==1){
    message('你已被拉黑','' ,'error');exit;
}


//最新贴
    $newthread = pdo_fetchall("SELECT id FROM " . tablename("wyt_luntan_thread") . " WHERE acid = ".$_W['account']['acid'] ." AND shstate = 0". " ORDER BY time DESC LIMIT 5");
	//最热贴
    $hotthread = pdo_fetchall("SELECT id FROM " . tablename("wyt_luntan_thread") . " WHERE acid = ".$_W['account']['acid'] ." AND shstate = 0". " ORDER BY looks DESC LIMIT 5");
	
	$newthreads = array($newthread[0]['id'],$newthread[1]['id'],$newthread[2]['id'],$newthread[3]['id'],$newthread[4]['id']);
	$hotthreads = array($hotthread[0]['id'],$hotthread[1]['id'],$hotthread[2]['id'],$hotthread[3]['id'],$hotthread[4]['id']);
	$json_newthreads = json_encode($newthreads);
	$json_hotthreads = json_encode($hotthreads);

$award_thread=pdo_getall('wyt_luntan_thread',array('award !='=>0,'award_id'=>0,'award_time <'=>date('Y-m-d H:i:s')));
foreach ($award_thread as $k=>$v){

    $pl=pdo_get('wyt_luntan_pinglun',array('thread_id'=>$v['id']));
    if(!$pl){
        $me=pdo_get('wyt_luntan_user',array('openid'=>$v['openid']));
        pdo_update('wyt_luntan_thread',array('award'=>0),array('id'=>$v['id']));
        pdo_update('mc_members',array('credit2 +='=>$v['award']),array('uid'=>$me['uid']));
    }else{
        $user=pdo_get('wyt_luntan_user',array('openid'=>$pl['user_id']));
        pdo_update('wyt_luntan_thread',array('award_id'=>$pl['id']),array('id'=>$v['id']));
        pdo_update('mc_members',array('credit2 +='=>$v['award']),array('uid'=>$user['uid']));
    }
}
if($action == ""){  //进入主页
//        $title=!empty($_GPC['fenlei'])?trim($_GPC['fenlei']):'';
//        $page=!empty($_GPC['page'])?intval(($_GPC['page']-1)) * 5:1;

    //查看广告设置多少页显示广告 如果为一页进去就添加广告
    if ($advpage==1){
        $adv=pdo_fetch('select * from '.tablename('wyt_luntan_ads').'where acid=:acid order by  display desc ',array(':acid'=>$_W['uniacid']));

    }

    if($_GPC['sou']!=''){
        $sou=$_GPC['sou'];
        $row = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_thread")." WHERE acid = ".$_W['account']['acid']." AND shstate = 0"." AND " . " (info like '%".$_GPC['sou']."%'"." or " . " title like '%".$_GPC['sou']."%')");
    }
    $ads=pdo_getall('wyt_luntan_ads',array('acid'=>$acid));

    $notice=pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_thread") . " WHERE acid = ".$_W['account']['acid'] ." AND ggstate = 1");
    $information=pdo_get('wyt_luntan_information',array('acid'=>$acid));
    $zdrow = pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_thread") . " WHERE acid = ".$_W['account']['acid'] ." AND zdstate = 1");
    foreach ($zdrow as $k=>$v){
        $zdrow[$k]['info']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
    }
    $qiandao=pdo_get('wyt_luntan_qiandao',array('openid'=>$openid,'time'=>date('Y-m-d'),'acid'=>$acid));
    $data=array(
        'fangwen'=>$information['fangwen']+1
    );

    pdo_update('wyt_luntan_information',$data,array('acid'=>$acid));
    $fenlei=pdo_getall('wyt_luntan_module',array('acid'=>$acid));
    $sumrow=pdo_getall('wyt_luntan_thread',array('acid'=>$acid));
//    if (!empty($title)&&$title!='undefined'){
//        $row = pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_thread") . " WHERE acid = ".$_W['account']['acid'] ." AND shstate = 0 and fenlei =:title ". "  ORDER BY  zdstate desc,pl_time desc, time DESC LIMIT  ".($page)." ,5",array(':title'=>$title));
//    }
//    else
        if($_GPC['sou']=='') {
//        $row = pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_thread") . " WHERE acid = ".$_W['account']['acid'] ." AND shstate = 0". " ORDER BY zdstate desc, pl_time desc, time DESC LIMIT   ".($page).",5");
            $row = pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_thread") . " WHERE acid = ".$_W['account']['acid'] ." AND shstate = 0". " ORDER BY zdstate desc, time DESC ,pl_time desc LIMIT 5");
    }

    $zong=0;
    $huati =count($sumrow);
    $rows=pdo_getall('wyt_luntan_thread',array('acid'=>$acid));
    foreach ($rows as $a => $b){
        $zong += $b['looks'];
    }
    foreach ($row as $k => $v){
        $row[$k]['looked']=pdo_get('wyt_luntan_looked',array('openid'=>$openid,'thread_id'=>$v['id'],'acid'=>$acid));
		//是否点赞
		$row[$k]['dianzan']=pdo_get('wyt_luntan_zan',array('user_id'=>$openid,'thread_id'=>$v['id'],'acid'=>$acid));
        $row[$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);

        $row[$k]['admin']=in_array($v['openid'],$admins);
        if (!empty($v['video'])){
            $row[$k]['fengmian']=unserialize($v['fengmian']);
            $row[$k]['fengmian']=empty($row[$k]['fengmian'][0]['name'])?'s':$row[$k]['fengmian'][0]['name'];
        }
        if($v['biaoshi']==2){
            $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=$v['images']?explode(" ",$v['images']):"";
        }
    }    
	
    include $this->template("index");
  }
  //进入修改帖子页面
if ($action == 'upd'){
    $res=pdo_get('wyt_luntan_thread',array('id'=>$_GPC['id']));
    $res['info']=base64_encode(base64_decode($res['info']))== $res['info']? base64_decode($res['info']) : $res['info'];
    if (!empty($res['video'])){
        $res['fengmian']=unserialize($res['fengmian']);
        $res['fengmian']=empty($res['fengmian'][0]['name'])?'s':$res['fengmian'][0]['name'];
    }
    if($res['biaoshi']==2){
        $res['images'] = unserialize($res['images']);
    }else{
        $res['images']='';
    }
    $fenlei=pdo_getall('wyt_luntan_module',array('acid'=>$acid));



    include $this->template("upthread");
  //  include $this->template("upd");
}
//确认修改
if ($action == 'update'){
	//var_dump($_POST);
    if ($_W['ispost']) {
        $ids = $_GPC['images'];
        $fengmians = $_GPC['fengmian'];
        $filelist = '';
        if ($ids != "") {
            $filelist = array();
            $check_ids = explode(",", $ids);
            if (count($check_ids) != 0) {
                @$filelist = Base::downloadimgages($ids);  //图片上传
            }
        }
        $fengmian = array();
        if ($fengmians != "") {

            $check_idss = explode(",", $fengmians);
            if (count($check_idss) != 0) {
                @$fengmian = Base::downloadimgages($fengmians);  //图片上传
            }
        }

        $res = pdo_get('wyt_luntan_thread', array('id' => $_GPC['id'], 'acid' => $acid));
        $a1 = unserialize($res['images']);
        if (!empty($a1)) {
            $a2 =$_POST['rimages']? explode(",", $_POST['rimages']):'';
			if(!empty($a2)){
				foreach ($a2 as $k => $v) {
	                unset($a1[$v]);
	            }
			}
            if(!empty($a1)){
	            foreach ($a1 as $k => $v) {
	                $filelist[] = $v;
	            }
			}

        }

        $data = array(
            'title' => $_GPC['title'],
            'video' => $_GPC['sss'],
            'images' => serialize($filelist),
            'fengmian' =>$fengmian? serialize($fengmian):$res['fengmian'],
            'address' => $_GPC['address'],
            'info' => base64_encode($_GPC['info']),
            'fenlei' => $_GPC['fenlei1'],
            'time' => date('m-d H:i'),
            'pl_time' => date('Y-m-d H:i'),
            'biaoshi' => 2,
            'checkp' => $_GPC['checkp'],
            'checkd' => $_GPC['checkd'],
            'award'	 => $_GPC['award']
        );


        $res = pdo_update('wyt_luntan_thread', $data, array('id' => $_GPC['id']));

        if ($res) {
            message('修改成功',$this->CreateMobileUrl('index',array('action'=>'info','id'=>$_GPC['id'])), 'success');
        }else{
            message('修改失败', referer(), 'success');
        }


    }

//    $msg = "修改成功";
//	if($set['state'] == 1){
//		$data['shstate'] = 1;
//		$msg = "修改成功，待审核";
//	}
//    $data['info']=base64_encode($_GPC['info']);
//    $t=pdo_update('wyt_luntan_thread',$data,array('id'=>$_GPC['id']));
//    if ($t!=false){
//        message($msg, $this->createMobileUrl('index', array('action' => '')), 'success');exit;
//    }else{
//        message('修改失败', $this->createMobileUrl('index', array('action' => '')), 'error');exit;
//    }
}

if($action == "fatie"){//进入发帖页面

    $fenlei=pdo_getall('wyt_luntan_module',array('acid'=>$acid));
	
    include $this->template("fatie");
}

if($action == "tixian"){//提现 
	if(empty($_GPC['money'])){
		message('请输入有效的提现金额', $this->createMobileUrl('index', array('action' => 'user')), 'error');exit;
	}
	if($_GPC['money'] < $set['tixian_limit']){
		message('提现金额不能小于'.$set['tixian_limit'], $this->createMobileUrl('index', array('action' => 'user')), 'error');exit;
	}
	if($set['tstate'] != 1){
		if(empty($_GPC['zhanghao'])){
			message('请输入支付宝账号', $this->createMobileUrl('index', array('action' => 'user')), 'error');exit;
		}
	}
	
    $money=pdo_get('mc_members',array('uid'=>$_GPC['uid']));
    if($_GPC['money']>$money['credit2']){
        message('提现金额大余额', $this->createMobileUrl('index', array('action' => 'user')), 'error');exit;
    }
    $yuer= pdo_query("UPDATE ".tablename('mc_members')." SET credit2=credit2-".$_GPC['money']." WHERE uid=".$_GPC['uid']);
    if($yuer){
        $data = $_POST;
        $data['acid'] = $acid;
        $data['time'] = date('Y-m-d H:i');
        $res=pdo_insert('wyt_luntan_tixian',$data);
    }
    if($res){
        message('已申请提现', $this->createMobileUrl('index', array('action' => 'user')), 'success');
    }
}
if($action == "tixianjl"){//提现记录页面
    $tixian = pdo_getall('wyt_luntan_tixian',array('openid'=>$openid));
    include $this->template("user/tixian");
}


if($action == "de_thread"){//删除帖子

    $res=pdo_delete('wyt_luntan_thread',array('id'=>$_GPC['id'],'acid'=>$acid));
    if ($res!=false){
        message('删除成功', $this->createMobileUrl('index', array('action' => 'user')), 'success');
    }die;
    header('Location:' . $this->createMobileUrl('Index', array('action'=>'')));
}
if($action == "lahei"){//拉黑
    if ($admin==$openid) {
        $res = pdo_update('wyt_luntan_user', array('state' => 1), array('openid' => $_GPC['openid'], 'acid' => $acid));
    }
    header('Location:' . $this->createMobileUrl('Index', array('action'=>'')));
}

if($action=="fatie_quanxian"){
    $module = pdo_get('wyt_luntan_module',array('name'=>$_GPC['fenlei1'],'acid'=>$acid));
    $send = pdo_get('mc_members',array('uid'=>$_W['fans']['uid']));
    if($module['send']>$send['credit1']){
        echo 0;exit;
    }else{
        echo 1;exit;
    }
}

if($action == "fatie1"){//发布帖子
    if ($_W['ispost']) {
        $ids = $_GPC['images'];
        $fengmians=$_GPC['fengmian'];

        if($ids != "")
        {
            $filelist = array();
            $check_ids = explode(",",$ids );
            if(count($check_ids) != 0)
            {
//                $filelist = $this->downloadFromWxServer($ids, $this->settings);
                @$filelist = Base::downloadimgages($ids);  //图片上传
            }
        }
//        var_dump($filelist);exit;
        if($fengmians != "")
        {
            $fengmian = array();
            $check_idss = explode(",",$fengmians );
            if(count($check_idss) != 0)
            {
//                $filelist = $this->downloadFromWxServer($ids, $this->settings);
                @$fengmian = Base::downloadimgages($fengmians);  //图片上传
            }
        }
    $res =pdo_get('wyt_luntan_thread',array('openid'=>$openid,'info'=>$_GPC['info'],'acid'=>$acid));
    if($res){
        message('该贴已存在请勿重复发帖', $this->createMobileUrl('index', array('action' => 'fatie')), 'success');exit;
    }
    $data = array(
        'shstate'=>$set['state'],
        'title'=>$_GPC['title'],
        'video'=>$_GPC['sss'],
        'images'=>serialize($filelist),
        'fengmian'=>serialize($fengmian),
        'address'=>$_GPC['address'],
        'info'=>base64_encode($_GPC['info']),
        'fenlei'=>$_GPC['fenlei1'],
        'openid' => $_W['fans']['openid'],
        'uid' => $_W['fans']['uid'],
        'nickname' => $_W['fans']['nickname'],
        'avatar' => $_W['fans']['tag']['avatar'],
        'time'=>date('m-d H:i'),
        'award_time'=> date('Y-m-d H:i:s',strtotime('+'.$set['award_days'].' day')),
        'pl_time'=>date('Y-m-d H:i'),
        'biaoshi'=>2,
        'checkp'=>$_GPC['checkp'],
        'checkd'=>$_GPC['checkd'],
        'acid' => $_W['account']['acid'],
    );
	
	//判断如果是七牛云存储 则返回保持视频封面 视频地址+?vframe/png/offset/5  参数5 代表第二秒
	if(empty($fengmian)){
	   $prefix = strpos($_GPC['sss'],".clouddn.com");
		if($prefix > 0){
			$poster[0]['name'] = $_GPC['sss']."?vframe/png/offset/5";
			$data['fengmian'] = serialize($poster);
		}
	}		

    $res=pdo_insert('wyt_luntan_thread', $data);
	$thread_id = pdo_insertid();
    if($res){
        $module = pdo_get('wyt_luntan_module',array('name'=>$_GPC['fenlei1']));
        pdo_query("UPDATE ".tablename('mc_members')." SET credit1=credit1+".$module['jifen']." WHERE uid=".$_W['fans']['uid']);
		
        if($_GPC['award']>0){
            //$res=pdo_get('wyt_luntan_thread', $data);
            $data=array(
                'thread_id'=>$thread_id,
                'topenid'=>$_W['fans']['openid'],
                'money'=>$_GPC['award'],
                'dopenid'=>'award',
                'time'=>date('Y-m-d H:i:s'),
                'acid' => $_W['account']['acid'],
                'serial'=>time().rand(0000,9999)
            );
            $max = pdo_insert('wyt_luntan_pay',$data);
            if($max){
                header('Location:' . $this->createMobileUrl('pay', array('orderid' => $data['serial'])));exit;
            }
        }

        message('发表成功', $this->createMobileUrl('index', array('action' => '')), 'success');
    }
    }else{
        header('Location:' . $this->createMobileUrl('Index', array('action'=>'')));
    }
}
if($action=='award_pl'){
    $thread=pdo_get('wyt_luntan_thread',array('id'=>$_GPC['thread_id']));
    $pl=pdo_get('wyt_luntan_pinglun',array('id'=>$_GPC['id']));
    $user=pdo_get('wyt_luntan_user',array('openid'=>$pl['user_id']));
    pdo_update('wyt_luntan_thread',array('award_id'=>$_GPC['id']),array('id'=>$_GPC['thread_id']));
    pdo_update('mc_members',array('credit2 +='=>$thread['award']),array('uid'=>$user['uid']));
    message('奖励成功', referer(), 'success');
}
if($action == "toggle"){

    include $this->template("toggle");
}
if ($action == 'zhiding'){
    if ($_GPC['zhiding']==1){
        $t=pdo_update('wyt_luntan_thread',array('zdstate'=>0,'pl_time'=>time()),array('id'=>$_GPC['id']));
        echo 0;die;
    }else{
        $t=pdo_update('wyt_luntan_thread',array('zdstate'=>1),array('id'=>$_GPC['id']));
        echo 1;die;
    }
}

if($action == 'upload_video')//上传视频
{
    load()->func('file');

    if($_FILES['file'])
    {
        $video = $this->file_upload_luntan($_FILES['file'], 'video');
        if($video) {

            $path= tomedia($video['path']);
            @$res=file_remote_upload($video['path']);

        }
       echo tomedia($video['path']);
    }
}
if($action == "collection"){//帖子收藏
        $data = array(
            'openid'=>$openid,
            'thread_id'=>$_GPC['id'],
            'date' => date('m-d H:i'),
            'acid' => $_W['account']['acid'],
        );
        $res=pdo_insert('wyt_luntan_collection', $data);
        if($res){
            echo 1;exit;
        }else{
        echo 0;exit;
    }
}

if($action == "other"){//查看他人信息
    if($openid==$_GPC['openid']){
        header('Location:' . $this->createMobileUrl('Index', array('action'=>'user')));
    }
    $uopenid=$_GPC['openid'];
    $user = pdo_get('wyt_luntan_user',array('openid'=>$_GPC['openid'],'acid'=>$acid));
    $guanzhu = pdo_get('wyt_luntan_guanzhu',array('bopenid'=>$_GPC['openid'],'openid'=>$openid,'acid'=>$acid));
    $row = pdo_fetchall("SELECT * FROM " . tablename("wyt_luntan_thread") ." WHERE acid = ".$_W['account']['acid']." AND shstate = 0"." AND openid = '".$uopenid."'"." ORDER BY time DESC LIMIT 0,5");
    foreach ($row as $k => $v){
        $row[$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
        if($v['biaoshi']==2){
            $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=explode(" ",$v['images']);
        }
		
		if (!empty($v['video'])){
            $row[$k]['fengmian']=unserialize($v['fengmian']);
            $row[$k]['fengmian']=empty($row[$k]['fengmian'][0]['name'])?'s':$row[$k]['fengmian'][0]['name'];
        }
    }
    include $this->template("other");
}

if($action =="info"){//进入帖子内页
    //贴子游览记录

    if(!empty($openid)){
        $browse_id=pdo_fetchcolumn('select id from '.tablename('wyt_luntan_browse').'where thread_id=:thread_id and openid=:openid and uniacid=:uniacid',array(':openid'=>$openid,'uniacid'=>$acid,':thread_id'=>$_GPC['id']));
        if (!empty($_GPC['id'])){
            if (!empty($browse_id)){
                pdo_update('wyt_luntan_browse',array('add_time'=>time()),array('id'=>$browse_id));
            }else{
                $data['openid']=$openid;
                $data['uniacid']=$acid;
                $data['add_time']=time();
                $data['thread_id']=$_GPC['id'];
                pdo_insert('wyt_luntan_browse',$data);
            }
        }
    }
    $page=$_GPC['page'];
    $pay=pdo_getall('wyt_luntan_pay',array('thread_id'=>$_GPC['id'],'state'=>1),array(),'' , 'time DESC');
    $collection=pdo_get('wyt_luntan_collection',array('thread_id'=>$_GPC['id'],'openid'=>$openid,'acid'=>$acid));
    $sumpay=count($pay);
    foreach($pay as $k => $v){
        $pay[$k]['avatar']= pdo_get('wyt_luntan_user',array('openid'=>$v['dopenid'],'acid'=>$acid));
    }
    $res=pdo_get('wyt_luntan_thread',array('id'=>$_GPC['id']));
    if (!empty($res['video'])){
        $res['fengmian']=unserialize($res['fengmian']);
        $res['fengmian']=empty($res['fengmian'][0]['name'])?'s':$res['fengmian'][0]['name'];
    }
	//此贴是否点赞
	$res['dianzan']=pdo_get('wyt_luntan_zan',array('user_id'=>$openid,'thread_id'=>$_GPC['id'],'acid'=>$acid));
    $moudel=pdo_get('wyt_luntan_module',array('name'=>$res['fenlei']));
         $data=array(
            'looks'=>$res['looks']+1
         );
        $looks=pdo_update('wyt_luntan_thread',$data,array('id'=>$_GPC['id'],'acid'=>$acid));

    $res['info1']=text(base64_encode(base64_decode($res['info']))== $res['info']? base64_decode($res['info']) : $res['info']);
//var_dump(base64_encode(base64_decode($res['info']))== $res['info']? base64_decode($res['info']) : $res['info']);
    if($res['biaoshi']==2){
            $res['images'] = unserialize($res['images']);
        }else{
            $res['images']=explode(" ",$res['images']);
        }
    //$pl=pdo_getall('wyt_luntan_pinglun',array('thread_id'=>$_GPC['id'],'pid'=>0));
    if($openid==$res['openid']){
        $info_admin= $openid;
    }

    $pl = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_pinglun")." WHERE thread_id = ".$_GPC['id']." AND pid = '0'"."  ORDER BY zan DESC  ");
	//@TODO
    foreach($pl as $k => $v){
        $pl[$k]['hui1']=pdo_getall('wyt_luntan_pinglun',array('thread_id'=>$_GPC['id'],'pid'=>$v['id'],'acid'=>$acid));
		//此评论是否点赞
		$pl[$k]['dianzan']=pdo_get('wyt_luntan_zan',array('user_id'=>$openid,'pl_id'=>$v['id'],'acid'=>$acid));
        $pl[$k]['images'] = unserialize($v['images']);

    }
    $looks=pdo_get('wyt_luntan_looked',array('openid'=>$openid,'thread_id'=>$_GPC['id'],'acid'=>$acid));
    if ($looks=='') {
        $looked =array(
            'openid'=>$openid,
            'thread_id'=>$_GPC['id'],
            'acid'=>$acid
        );
        pdo_insert('wyt_luntan_looked',$looked);
    }
    include $this->template("info");
}

if($action == "quxiao"){//取消收藏
    $res=pdo_delete('wyt_luntan_collection', array('thread_id'=>$_GPC['id'],'openid'=>$openid,'acid'=>$acid));
    if($res){
        echo 1;exit;
    }else{
        echo 0;exit;
    }
}
if($action == "share"){//分享
    $share = pdo_get('wyt_luntan_thread',array('id'=>$_GPC['id'],'acid'=>$acid));
    $res=pdo_update('wyt_luntan_thread', array('share'=>$share['share']+1),array('id'=>$_GPC['id']));
    if($res){
        echo 1;exit;
    }else{
        echo 0;exit;
    }
}
if($action == "bguanzhu"){//取消关注

    $res=pdo_delete('wyt_luntan_guanzhu', array('openid'=>$openid,'bopenid'=>$_GPC['id'],'acid'=>$acid));
    if($res){
        echo 1;exit;
    }else{
        echo 0;exit;
    }
}
if($action == "guanzhu"){//关注

    $data = array(
        'openid'=>$openid,
        'bopenid'=>$_GPC['id'],
        'date' => date('m-d H:i'),
        'acid' => $_W['account']['acid'],
    );
    $res=pdo_insert('wyt_luntan_guanzhu', $data);
    if($res){
        echo 1;exit;
    }else{
        echo 0;exit;
    }
}
if($action == "pinglun"){ //评论
    if ($_W['ispost']) {
        $media = $_GPC['images'];
        if ($media != "") {
            $images = serialize(Base::downloadimgages($media));  //图片上传
        }
        
        $data = array(
            'thread_id' => $_GPC['tid'],
            'user_id' => $openid,
            'images' => $images,
            'info' => $_GPC['info'],
            'nickname' => $_W['fans']['nickname'],
            'avatar' => $_W['fans']['tag']['avatar'],
            'time' => date('m-d H:i',time()),
            'acid' => $_W['account']['acid'],

        );

        pdo_insert('wyt_luntan_pinglun', $data);
        $thread = pdo_get('wyt_luntan_thread', array('id' => $_GPC['tid'],'acid'=>$acid));
        $data1 = array(
            'pl' => $thread['pl'] + 1,
            'pl_time' => date('Y-m-d H:i'),
        );
        $thread1 = pdo_update('wyt_luntan_thread', $data1, array('id' => $_GPC['tid'],'acid'=>$acid));
		$tie_info = base64_encode(base64_decode($thread['info']))== $thread['info']? base64_decode($thread['info']) : $thread['info'];
        $aa = $this->templetemsg($set['mes'],$thread['openid'],$data['nickname'],$tie_info,$thread['id'],'有人回复了您的帖子');
//        echo $thread['openid'],"<br>",$set['mes'],"<br>";
//        print_r($aa);die;
        message('评论成功', $this->createMobileUrl('Index', array('action' => 'info', 'id' => $_GPC['tid'])));
    }else{
        header('Location:' . $this->createMobileUrl('Index', array('action'=>'')));
    }
}
if($action=='qiandao'){ //签到
    $qiandao=pdo_get('wyt_luntan_qiandao',array('openid'=>$openid,'time'=>date('Y-m-d'),'acid'=>$acid));
    $num=pdo_fetchcolumn('select count(id) from '.tablename('wyt_luntan_qiandao').'where openid=:openid and acid=:acid',array(':openid'=>$openid,':acid'=>$acid));
    if (!empty($num)){
        $creait=$set['sign1'];
    }else{
        $creait=$set['sign'];
    }
    if (empty($openid)){
        echo 3;die;
    }
    if($qiandao){
        echo 1;exit;
    }else{
        $data1=array(
            'openid'=>$openid,
            'time'=>date('Y-m-d'),
            'acid' => $_W['account']['acid'],
        );
        $dao=pdo_insert('wyt_luntan_qiandao',$data1);
        pdo_query("UPDATE ".tablename('mc_members').'SET credit1=credit1+'.$creait.' WHERE uid='.$_W['fans']['uid']);
        echo 2;exit;
    }
}
if($action=='dashang'){
    $res=pdo_get('wyt_luntan_thread',array('id'=>$_GPC['id'],'acid'=>$acid));
	$dashang_money_list = explode(",",$set['dashang_moneys']);
    include $this->template("dashang");
}

if($action=='dashang_order'){
	//action=dashang&id=565&do=Index&m=wyt_luntan
	if($_GPC['money'] < $set['dashang_limit']){
		message('打赏金额不得小于'.$set['dashang_limit'], $this->createMobileUrl('index', array('action' => 'dashang','id' => $_GPC['tid'])), 'error');exit;
	}
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
        $topenid=pdo_get('wyt_luntan_user',array('openid'=>$thread_id['topenid']));
        $dashang = $thread_id['money'] - ($thread_id['money'] * $set['shouxu']/100);
       // $this->templetemsg($set['mes'],$thread_id['topenid'],'打赏消息','被打赏啦！快去看看~',$thread_id['thread_id'],'有人打赏了您的帖子');
        //var_dump($set['shouxu']);exit;
        $credit = pdo_get('mc_members',array('uid'=>$topenid['uid']),array('credit2'));
        $credit2 = $credit['credit2'] + $dashang;
        //$yuer= pdo_query("UPDATE ".tablename('mc_members')." SET credit2=credit2+".$dashang." WHERE uid=".$topenid['uid']);
		$yuer= pdo_update('mc_members',array('credit2'=>$credit2),array('uid'=>$topenid['uid']));
        if($yuer){
        	message('打赏成功', $this->createMobileUrl('Index', array('action' => 'info','id' => $thread_id['thread_id'])), 'success');
            //header('Location:' . $this->createMobileUrl('Index', array('action'=>'info','id'=>$thread_id['thread_id'])));
        }else{
        	message('打赏失败', $this->createMobileUrl('Index', array('action' => 'info','id' => $thread_id['thread_id'])), 'error');
        }
    }
}
if($action=='del_pl'){//删除评论
    $res=pdo_delete('wyt_luntan_pinglun',array('id'=>$_GPC['id']));
    $res1=pdo_delete('wyt_luntan_pinglun',array('pid'=>$_GPC['id']));
    $res2=pdo_delete('wyt_luntan_zan',array('pl_id'=>$_GPC['id']));
    header('Location:' . $this->createMobileUrl('Index', array('action'=>'info','id'=>$_GPC['thread_id'])));
}
if($action=='huifu'){
    if (empty($openid)){
        echo "想回帖！请从微信端打开！";die;
    }
    include $this->template("pinglun");
}
if($action=='pinglun1'){
    if (empty($openid)){
        echo "想回帖！请从微信端打开！";die;
    }
    include $this->template("pinglun");
}
if($action=='huifu2'){
    if (empty($openid)){
        echo "想回帖！请从微信端打开！";die;
    }
    include $this->template("pinglun");

}
if($action=='huifu3'){
    if (empty($openid)){
        echo "想回帖！请从微信端打开！";die;
    }
    if ($_W['ispost']) {
        $media = $_GPC['images'];
        if ($media != "") {
            $images = serialize(Base::downloadimgages($media));  //图片上传
        }
        $data = array(
            'thread_id' => $_GPC['tid'],
            'user_id' => $openid,
            'images' => $images,
            'pid' => $_GPC['pid'],
            'hid' => $_GPC['hid'],
            'hname' => $_GPC['hname'],
            'info' => $_GPC['info'],
            'nickname' => $_W['fans']['nickname'],
            'avatar' => $_W['fans']['tag']['avatar'],
            'time' => date('m-d H:i',time()),
            'acid' => $_W['account']['acid'],
        );


        $res = pdo_insert('wyt_luntan_pinglun', $data);
        //var_dump($_GPC['hid']);exit;
        if ($res) {
            $thread = pdo_get('wyt_luntan_thread', array('id' => $_GPC['tid'],'acid'=>$acid));
			$tie_info = base64_encode(base64_decode($thread['info']))== $thread['info']? base64_decode($thread['info']) : $thread['info'];
            $aa = $this->templetemsg($set['mes'],$_GPC['userid'],$data['nickname'],$tie_info,$thread['id'],'有人回复了您');

//            echo $_GPC['userid'],"<br>",$set['mes'],"<br>";
//            print_r($aa);die;
            message('评论成功', $this->createMobileUrl('Index', array('action' => 'info', 'id' => $_GPC['tid'])));
        }
    }else{
        header('Location:' . $this->createMobileUrl('Index', array('action'=>'')));
    }
}
if($action=='huifu1'){
    if ($_W['ispost']) {
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
        'time'=>date('m-d H:i'),
        'acid' => $_W['account']['acid'],
    );
    $res=pdo_insert('wyt_luntan_pinglun', $data);

    if($res){
        $thread = pdo_get('wyt_luntan_thread', array('id' => $_GPC['tid'],'acid'=>$acid));
		$tie_info = base64_encode(base64_decode($thread['info']))== $thread['info']? base64_decode($thread['info']) : $thread['info'];		
        $aa = $this->templetemsg($set['mes'],$_GPC['userid'],$data['nickname'],$tie_info,$thread['id'],'有人回复了您');
//        echo $_GPC['userid'],"<br>",$set['mes'],"<br>";
//        print_r($aa);die;
        message('评论成功',$this->createMobileUrl('Index',array('action'=>'info','id'=>$_GPC['tid'])));
    }
    }else{
        header('Location:' . $this->createMobileUrl('Index', array('action'=>'')));
    }
}
if($action == "my_index"){
    //var_dump(11);exit;
    $user = pdo_get('wyt_luntan_user',array('openid'=>$openid));
    $row = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_thread")." WHERE acid = ".$_W['account']['acid']." AND openid = '".$openid."'"." ORDER BY time DESC LIMIT  0,5 ");
    //$row = pdo_fetchall("SELECT * FROM ".tablename("wyt_luntan_thread")." WHERE acid = ".$_W['account']['acid']." ORDER BY time DESC LIMIT 0,4");
    foreach ($row as $k => $v){
        $row[$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
		if (!empty($v['video'])){
            $row[$k]['fengmian']=unserialize($v['fengmian']);
            $row[$k]['fengmian']=empty($row[$k]['fengmian'][0]['name'])?'s':$row[$k]['fengmian'][0]['name'];
        }
        if($v['biaoshi']==2){
        $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=explode(" ",$v['images']);
        }
    }
    include $this->template("user/my_index");
}
if($action == "user"){
    $user = pdo_get('wyt_luntan_user',array('openid'=>$openid,'acid'=>$acid));
    $self = pdo_getall('wyt_luntan_self',array('acid'=>$acid));
    //var_dump($self);exit;
    $thread = pdo_getall('wyt_luntan_thread',array('openid'=>$openid,'acid'=>$acid));
    $sum_thread=count($thread);
    include $this->template("user");
}
if($action == "zan"){
    if (empty($openid)){
        return false;
    }
    $tid=$_GPC['tid'];
    $zan=pdo_get('wyt_luntan_zan',array('user_id'=>$openid,'thread_id'=>$tid,'acid'=>$acid));

    //$zan = pdo_fetch("SELECT * FROM ".tablename("wyt_luntan_zan")." WHERE openid = $openid AND thread_id = $tid AND ")
    if($zan){
        echo 'no';exit;
    }else{
        $thread=pdo_get('wyt_luntan_thread',array('id'=>$tid,'acid'=>$acid));
        $data=array(
            'zan'=>$thread['zan']+1
        );
        $thread=pdo_update('wyt_luntan_thread',$data,array('id'=>$tid,'acid'=>$acid));
        $data1=array(
            'user_id'=>$openid,
            'thread_id'=>$tid,
            'acid'=>$acid,
            'time'=>date('m-d H:i'),
        );
        $zan1=pdo_insert('wyt_luntan_zan',$data1);
       // pdo_query("UPDATE ".tablename('mc_members')." SET credit1=credit1+1 WHERE uid=".$thread['uid']);
        echo 'yes';exit;
    }
}

if($action == "zan1"){
    if (empty($openid)){
        return false;
    }
    $pid=$_GPC['pid'];
    $zan=pdo_getall('wyt_luntan_zan',array('user_id'=>$openid,'pl_id'=>$pid,'acid'=>$acid));

    //$zan = pdo_fetch("SELECT * FROM ".tablename("wyt_luntan_zan")." WHERE openid = $openid AND thread_id = $tid AND ")
    if($zan){
        echo 1;exit;
    }else{
        $pl=pdo_get('wyt_luntan_pinglun',array('id'=>$pid,'acid'=>$acid));
        $data=array(
            'zan'=>$pl['zan']+1
        );
        $pl=pdo_update('wyt_luntan_pinglun',$data,array('id'=>$pid,'acid'=>$acid));
        $data1=array(
            'user_id'=>$openid,
            'pl_id'=>$pid,
            'acid'=>$acid,
            'time'=>date('m-d H:i'),
        );
        $zan1=pdo_insert('wyt_luntan_zan',$data1);
        $user=pdo_get('wyt_luntan_user',array('openid'=>$pl['openid'],'acid'=>$acid));
        $data2=array(
            'jifen'=>$user['jifen']+1,

        );
        $user1=pdo_update('wyt_luntan_user',$data2,array('openid'=>$pl['openid'],'acid'=>$acid));
        echo 2;exit;
    }
}

//已举报的不给再举报
if ($action == 'jubaos'){
    $id=$_GPC['id'];

    $t=pdo_fetchcolumn('select id from '.tablename('wyt_luntan_report').'where openid=:openid and uniacid=:acid and thread_id=:id',array(':openid'=>$openid,':acid'=>$acid,':id'=>$id));
    if (!empty($t)){
        echo json_encode(array('code'=>1,'msg'=>'您已举报过该帖'));die;
    }else{
        echo json_encode(array('code'=>99));die;
    }
}
//举报帖子
if($action=='jubao'){
    if (empty($_GPC['msg'])){
        echo json_encode(array('code'=>1,'msg'=>'您想举报什么，请认真填写。'));die;
    }
    if (empty($openid)){
        echo json_encode(array('code'=>2,'msg'=>'请从微信端打开再举报'));die;
    }
    $data['msg']=$_GPC['msg'];
    $data['thread_id']=$_GPC['id'];
    $data['add_time']=time();
    $data['uniacid']=$_W['uniacid'];
    $data['openid']=$openid;
    $t=pdo_insert('wyt_luntan_report',$data);
    if ($t!=false){
        echo json_encode(array('code'=>99,'msg'=>'举报信息提交成功'));die;
    }else{
        echo json_encode(array('code'=>3,'msg'=>'举报失败'));die;
    }
}

if($action == "data_thread"){
    $page=(int)$_GPC['page'];
    $size=5;
    $row=pdo_fetchall(' SELECT * FROM '.tablename('wyt_luntan_thread')." WHERE acid = ".$_W['account']['acid']." AND shstate = 0"." AND openid ='".$openid."'"." ORDER BY time DESC LIMIT ".($page-1) * $size.','.$size);
    foreach ($row as $k => $v){
        $row[$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
        if($v['biaoshi']==2){
            $row[$k]['images'] = unserialize($v['images']);
        }else{
            $row[$k]['images']=explode(" ",$v['images']);
        }
		
		if (!empty($v['video'])){
            $row[$k]['fengmian']=unserialize($v['fengmian']);
            $row[$k]['fengmian']=empty($row['data'][$k]['fengmian'][0]['name'])?'s':$row['data'][$k]['fengmian'][0]['name'];
        }
    }
    if($row){
        echo json_encode($row);exit;
    }else{
        echo 0;exit;
    }
}
if($action == "load_data"){
    $page=(int)$_GPC['page'];
    $cid=$_GPC['fenlei'];
    $size=5;

    if($cid ==''){
        $row['data']=pdo_fetchall(' SELECT * FROM '.tablename('wyt_luntan_thread')." WHERE acid = ".$_W['account']['acid']." AND shstate = 0"." ORDER BY zdstate desc, time desc , pl_time desc LIMIT ".($page-1) * $size.','.$size);//" ORDER BY pl_time desc, time DESC
    }else{
        $row['data']=pdo_fetchall(' SELECT * FROM '.tablename('wyt_luntan_thread')." WHERE acid = ".$_W['account']['acid']." AND shstate = 0"." AND fenlei = '".$cid."'"." ORDER BY  zdstate desc, time  desc , pl_time desc LIMIT ".($page-1) * $size.','.$size);
    }
    $set=pdo_get('wyt_luntan_set',array('acid'=>$acid));
    $admins = explode('/',$set['admin']);
    foreach ($admins as $k=>$v){
        if($v==$openid){
            $admin=$openid;
        }
    }
    foreach ($row['data'] as $k => $v){
        $row['data'][$k]['looked']=pdo_get('wyt_luntan_looked',array('openid'=>$openid,'thread_id'=>$v['id'],'acid'=>$acid));
		
		//是否点赞
		$row['data'][$k]['dianzan']=pdo_get('wyt_luntan_zan',array('user_id'=>$openid,'thread_id'=>$v['id'],'acid'=>$acid));
		
        $row['data'][$k]['admin']=in_array($v['openid'],$admins);
        $row['data'][$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
        if (strlen($row['data'][$k]['info1'])>80){
            $row['data'][$k]['info1']= mb_substr(text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']), 0,80, 'utf-8').'...';
        }else{
            $row['data'][$k]['info1']=text(base64_encode(base64_decode($v['info']))== $v['info']? base64_decode($v['info']) : $v['info']);
        }
        //var_dump($row[$k]['info1'].=$row[$k]['info1'].'...');
        if (!empty($v['video'])){
            $row['data'][$k]['fengmian']=unserialize($v['fengmian']);
            $row['data'][$k]['fengmian']=empty($row['data'][$k]['fengmian'][0]['name'])?'s':$row['data'][$k]['fengmian'][0]['name'];
        }
        if($v['biaoshi']==2){
            $row['data'][$k]['images'] = unserialize($v['images']);
        }else{
        	$th_image = array();
			$th_images = array();
        	$th_images = $v['images']?explode(" ",$v['images']):"";	
			if(!empty($th_images)){
			   foreach($th_images as $val){
				    $th_image[] = tomedia($val);
				} 
			}				
            $row['data'][$k]['images'] = $th_image;

        }
    }

    if (!empty($advpage)){
        $advlimit=$page/$advpage;
    }
    if($row['data']){

        if (is_int($advlimit)){
            if (!empty($cid)){
             $id=pdo_fetchcolumn('select id from '.tablename('wyt_luntan_ads').'where title=:cid',array(':cid'=>$cid));
             $adv = pdo_fetch('select * from ' . tablename('wyt_luntan_ads') . 'where acid=:acid order by  display desc ,id desc limit ' . ($advlimit - 1) . ',1 ', array(':acid' => $_W['uniacid']));
            }else {
                $adv = pdo_fetch('select * from ' . tablename('wyt_luntan_ads') . 'where acid=:acid order by  display desc ,id desc limit ' . ($advlimit - 1) . ',1 ', array(':acid' => $_W['uniacid']));
            }
            if (empty($adv)) {
                    $adv = pdo_fetch('SELECT * FROM ' . tablename('wyt_luntan_ads') . 'where acid=:acid  ORDER BY RAND() LIMIT 1', array(':acid' => $_W['uniacid']));
                }

                if (is_array($adv)) {
                    $adv['images'] = tomedia($adv['images']);
                }

        $row['adv']=$adv;
        }

        $row['advlimit']=$advlimit;
        $row['page']=$page;
        echo json_encode($row);exit;
    }else{
        echo 0;exit;
    }
}
//管理员审核
if ($action == 'sh'){

    $res=pdo_getall('wyt_luntan_thread',array('acid'=>$acid,'shstate'=>1,'fenlei'=>$_GPC['adminstr']));

    include $this->template("sh");die;
}
//通过审核
if ($action == 'tgsh'){
    pdo_update('wyt_luntan_thread',array('shstate'=>0),array('id'=>$_GPC['id']));
    message('审核通过',$this->createMobileUrl('Index',array('action'=>'user')));
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
