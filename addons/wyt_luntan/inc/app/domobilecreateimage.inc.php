<?php
global $_W,$_GPC;
$action = $_GPC['action']?$_GPC['action']:'';
include 'phpqrcode.php';
$today = date('Y-m-d',time());
$uniacid = $_W['uniacid'];
$uid     = $_W['member']['uid'];
$url =  $_W['siteroot'].str_replace('./','app/',$this->createmobileurl('index')).'&fid='.$uid;
$file = IMG_DAKA_PATH.$uniacid.'/qrcode/qrcode_'.$uniacid.'_'.$uid.'.jpg';
$headimage = $_W['siteroot'].str_replace('./','app/',$this->createMobileUrl('Wxheadimgcurl',array("uid"=>$uid)));
$nick_name = $_W['fans']['nickname'];
$row = CreateImage($url,$headimage,$nick_name);
if($row['State']==200){
    $row['State'] = 200;
    $row['Msg']=$file;
}
$row = json_encode($row);

echo $row;
exit;

function CreateImage($url,$headimage,$nick_name){
    global $_W,$_GPC;
    $setting = pdo_fetch('SELECT * FROM ' . tablename('wyt_luntan_config') . ' WHERE uniacid ='.$_W['uniacid']);
    $others =json_decode($setting['other_setting'],true);
    $uniacid =  $_W['uniacid'];
    $uid     = $_W['member']['uid'];
//    header("content-type: image/jpeg");//如果要看报什么错，可以先注释调这个header
    //海报背景
    $set = json_decode($setting['poster_setting'],true);
    $data = json_decode($set['data'],true);
    $bg = tomedia($set['hb_bg']);
    $is_z = $set['zhanji'];

    if(empty($set['hb_bg'])){
        $bg = MODULE_ROOT."/images/yq.jpg";
    }
    $head = array();
    $qr = array();
    $nick = array();
    foreach($data as $item){
        if($item['type']=='img'){
            $head['qiyong']=1;
            $head['left']=2*$item['left'];
            $head['top']=2*$item['top'];
            $head['width']=2*$item['width'];
            $head['height']=2*$item['height'];
        }
        if($item['type']=='qr'){
            $qr['qiyong']=1;
            $qr['left']=2*$item['left'];
            $qr['top']=2*$item['top'];
            $qr['width']=2*$item['width'];
            $qr['height']=2*$item['height'];
        }
        if($item['type']=='name'){
            $nick['qiyong']=1;
            $nick['left']=2*$item['left'];
            $nick['top']=2*($item['top']+$item['height']);
            $nick['width']=$item['width'];
            $nick['height']=$item['height'];
            $nick['size']=$item['size'];
            $nick['color']=$item['color'];
        }
    }
    $bg = imagecreatefromjpeg($bg);
    ///创建和背景一样大小的真彩色画布
    $image_3 = imagecreatetruecolor(imagesx($bg),imagesy($bg));
    //为真彩色画布创建白色背景，再设置为透明
    $color = imagecolorallocate($image_3, 255, 255, 255);
    imagefill($image_3, 0, 0, $color);
    imagecolortransparent($image_3, $color);
    //首先将背景画布采样copy到真彩色画布中，不会失真
    imagecopyresampled($image_3,$bg,0,0,0,0,imagesx($bg),imagesy($bg),imagesx($bg),imagesy($bg));

    if($nick['qiyong']==1){
        $nickname = $_W['fans']['nickname'];//微信昵称
        $color = hex2rgb($nick['color']);
        $font_color = imagecolorallocate($image_3,$color['r'],$color['g'],$color['b']);
        $font = MODULE_ROOT."/fonts/Arial.ttf";  //写的文字用到的字体
        $str = mb_convert_encoding($nickname, "html-entities", "utf-8");//解决乱码问题
        imagettftext($image_3,$nick['size'],0,$nick['left'],$nick['top'] - 60,$font_color,$font,$str); //字体大小，旋转角度，x,y文字基点，字体的颜色，字体，内容
    }
    //$prefix = substr($avatar,0,4);
	//if($prefix != 'reso'){
		if($head['qiyong']==1){
			$imginfo= getimagesize($headimage);
			if(strpos($imginfo['mime'], 'jpeg')){
				$headerimgs = imagecreatefromjpeg($headimage);
			}else if(strpos($imginfo['mime'], 'png')){
				$headerimgs = imagecreatefrompng($headimage);
			}else if(strpos($imginfo['mime'], 'gif')){
				$headerimgs = imagecreatefromgif($headimage);
			}
	        imagecopyresampled($image_3,$headerimgs,$head['left'],$head['top'],0,0,$head['width'],$head['height'],imagesx($headerimgs),imagesy($headerimgs));  //左，上，右，下，新宽度，新高度，原宽度，原高度
	    }
	//}
    if($qr['qiyong']==1){
        //$erweimaurl = "http://qr.liantu.com/api.php?&w=".$qr['width']."&text=".urlencode($url);//二维码
		$qrfile_path = MODULE_ROOT.'/'.$uniacid.'/qrcode_cache';
	    if (!file_exists($qrfile_path)) {
	        load()->func('file');
	        mkdirs($qrfile_path);
	    }
		$open_gd2 = extension_loaded("gd");
		if(!$open_gd2){
			$row['State'] = 2001;
	        $row['Msg']='PHP环境需要开启GD2扩展库';
			return $row;exit;
		}
		$errorLevel = "L";
        QRcode::png($url,MODULE_ROOT.'/'.$uniacid.'/qrcode_cache/qrcode_'.$uniacid.'_'.$uid.'.png',$errorLevel,10,$margin=2);
		$qrfile = $qrfile_path.'/qrcode_'.$uniacid.'_'.$uid.'.png';
		$ret = resize_image($qrfile, $qrfile, $qr['width'], $qr['width']);
		if($ret){
			$erweimaurl = imagecreatefrompng($qrfile);
        	imagecopymerge($image_3,$erweimaurl, $qr['left'],$qr['top'],0,0,imagesx($erweimaurl),imagesy($erweimaurl), 100);
		}
    }

    $file_name = 'qrcode_'.$uniacid.'_'.$uid.'.jpg';
    $file_path = MODULE_ROOT.'/'.$uniacid.'/qrcode';

    if (!file_exists($file_path)) {
        load()->func('file');
        mkdirs($file_path);
    }
    $file = $file_path.'/'.$file_name;
    imagejpeg($image_3,$file);//保存到本地
    imagedestroy($image_3);
	$result = diy_account_userinfo();
	if (!empty($result) &&$_W['fans']['follow'] == 1) {
		return Send_Img_Message($_W['fans']['openid'],$file,IMG_DAKA_PATH.$uniacid.'/qrcode/qrcode_'.$uniacid.'_'.$uid.'.jpg');
	}else{
		$row['State'] = 200;
        $row['src'] = IMG_DAKA_PATH.$uniacid.'/qrcode/qrcode_'.$uniacid.'_'.$uid.'.jpg';
        $row['Msg']='海报生成成功';
		return $row;
	}
    //return Send_Img_Message($_W['fans']['openid'],$file,IMG_DAKA_PATH.$uniacid.'/qrcode/qrcode_'.$uniacid.'_'.$uid.'.jpg');

}
function Send_Img_Message($openid,$pic,$src){
    $account_api = WeAccount::create();
    //任意指定一个文件上传
    $result = $account_api->uploadMedia($pic, 'image');
    $message = array(
        'touser' => $openid,
        'msgtype' => 'image',
        'image' => array('media_id' => $result['media_id']) //微信素材media_id，微擎中微信上传组件可以得到此值
    );
    $status = $account_api->sendCustomNotice($message);//调用微擎内部的函数
    if (is_error($status)) {
        $row['State'] = 202;
        $row['src'] = $src;
        $row['Msg']='海报发送失败'.$status['message'];
    }else{
        $row['State'] = 200;
        $row['src'] = $src;
        $row['Msg']='海报已发送至你的微信，请查看';
    }
   logResult('发送图片'.$status);
    return $row;
}
function hex2rgb($hexColor) {
    $color = str_replace('#', '', $hexColor);
    if (strlen($color) > 3) {
        $rgb = array(
            'r' => hexdec(substr($color, 0, 2)),
            'g' => hexdec(substr($color, 2, 2)),
            'b' => hexdec(substr($color, 4, 2))
        );
    } else {
        $color = $hexColor;
        $r = substr($color, 0, 1) . substr($color, 0, 1);
        $g = substr($color, 1, 1) . substr($color, 1, 1);
        $b = substr($color, 2, 1) . substr($color, 2, 1);
        $rgb = array(
            'r' => hexdec($r),
            'g' => hexdec($g),
            'b' => hexdec($b)
        );
    }
    return $rgb;
}
function logResult($params) {
    global $_W,$_GPC;
    $file_name = MODULE_ROOT.'/pay_log.txt';
    $file_path = MODULE_ROOT;
    if (!file_exists($file_path)) {
        load()->func('file');
        mkdirs($file_path);
    }
    file_put_contents($file_name,$params,FILE_APPEND);
}
/*function Get_header_img(){
    global $_W;
    $headimgurl = $_W['fans']['headimgurl'];
    if(empty($headimgurl)){
        $fans = mc_oauth_userinfo();
        $headimgurl = preg_replace('/\/0$/', '/96', stripslashes($fans['avatar']));
    }
    return $headimgurl;
}*/
?>