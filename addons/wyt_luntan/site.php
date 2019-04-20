<?php
/**
 * 微论坛/社区2.0模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define("DAKA_PATH", '/addons/wyt_luntan/');
define("IMG_DAKA_PATH", '../addons/wyt_luntan/');
define("MODULE_NAME", 'wyt_luntan');
include_once 'Core/Base.class.php';
include_once 'Common/functions.php';
include_once 'Common/ali_mssage/sendSms.php';
class Wyt_luntanModuleSite extends WeModuleSite {
//    function __construct() {
//        $setting = pdo_fetch('SELECT * FROM ' . tablename('zdaka_config') . ' WHERE uniacid ='.$_W['uniacid']);
//        $others =json_decode($setting['other_setting'],true);
//        // $other =json_decode($setting['other_setting'],true);
//        $set = json_decode($setting['settings'],true);
//    }

    public function doMobileIndex() {
       
        $this->app(__FUNCTION__);
    }
    public function doMobileYaoqing() {

        $this->app(__FUNCTION__);
    }
    public function doMobileCreateImage() {
        $this->app(__FUNCTION__);
    }
    public function doMobileUser() {
        $this->app(__FUNCTION__);
    }

	//微信网络头像通过IP和curl实现快速读取头像，用于海报生成时提升生成海报速度
	public function doMobileWxheadimgcurl() {
        global $_GPC,$_W;
        $this->app('wxheadimgcurl');
    }

    public function doWebPostersetting() {
        $this->web(__FUNCTION__);
    }
    public function doWebSet() {
        $this->web(__FUNCTION__);
    }
    public function doWebAds() {
        $this->web(__FUNCTION__);
    }
    public function doWebUser() {
        $this->web(__FUNCTION__);
    }
    public function doWebThread() {
        $this->web(__FUNCTION__);
    }
    public function doWebList() {
        $this->web(__FUNCTION__);
    }
    public function doWebInformation() {
        $this->web(__FUNCTION__);
    }
    public function doWebModule() {
        $this->web(__FUNCTION__);
    }
    public function doWebSelf() {
        $this->web(__FUNCTION__);
    }
    public function doWebSign() {
        $this->web(__FUNCTION__);
    }
    public function web($name=null){
        include_once 'Core/Base.class.php';
        define("ASSETS_PATH",MODULE_URL."assets/");
        include "inc/web/".strtolower($name).".inc.php";
    }
    public function app($name=null){
        global $_GPC,$_W;
        include_once 'Core/Base.class.php';
//        include_once 'Common/Public/Function.php';
//        include_once 'phpqrcode/phpqrcode.php';
        define("ASSETS_PATH",MODULE_URL."assets/");
        $blist=pdo_fetchall('SELECT * FROM '. tablename('wyt_luntan_list').' WHERE acid ='.$_W['account']['acid'].'  order by xuhao limit 0,4 ');

        include "inc/app/".strtolower($name).".inc.php";

    }
  public function export(){
      global $_GPC,$_W;
      include 'ExportExcel.php';
      $obj=new ExportExcel();
      $data = pdo_fetchall("SELECT nickname,info FROM ".tablename("wyt_luntan_thread")."where acid =".$_W['account']['acid']);
//  $data = array(
//      array('a11','a22','a33'),
//      array('b11','b22','b33'),
//      array('c11','c22','c33'),
//      array('d11','d22','d33'),
//      array('e11','e22','e33'),
//      array('f11','f22','f33'),
//     );
     $excelHead = "用户帖子信息";
     $title = date('Y-m-d H:i');   #文件命名
     $headtitle= "<tr><th  colspan='3' >{$excelHead}</th></tr>";
     $titlename = "<tr> 
                       <th style='width:70px;'>姓名</th> 
                       <th style='width:70px;'>内容</th>      
                  </tr>";
        $filename = $title.".xls";
        $obj->excelData($data,$titlename,$headtitle,$filename);
}

    public function txian($openid,$uid,$money){
        include 'Withdraw.php';
        $obj=new Withdraw();
        $result = $obj->txian($openid,$uid,$money);
        return $result;

    }


    public function templetemsg($templete,$openid,$info,$title,$id,$vall){
        global $_W,$_GPC;
        $account_api = WeAccount::create();
        $account_api->clearAccessToken();
        $token = $account_api->getAccessToken();
        $msg_url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $time = date("Y-m-d H:i:s",time());
        $url =$_W['siteroot'].'app/index.php?i='.$_W['account']['acid'].'&c=entry&do=Index&action=info&id='.$id.'&m=wyt_luntan'; ////这个链接是点击图文 跳转的链接,换行只能用n 不能用<Br/>
        ////请求包为一个json：
        $msg_json= '{
            "touser":"'.$openid.'",
            "template_id":"'.$templete.'",
            "url":"'.$url.'",
            "topcolor":"#FF0000",
            "data":{
                "first":{
                "value":"'.$vall.'",
                "color":"#FF0000"
                },
                "keyword1":{
                "value":"'.$title.'",
                "color":"#000000"
                },
                "keyword2":{
                "value":"'.$info.'",
                "color":"#000000"
                },
                "keyword3":{
                "value":"'.$time.'",
                "color":"#000000"
                },
                "remark":{
                "value":"点击查看详情",
                "color":""
                }
               
            }
        }';
        //var_dump($msg_json);exit;
        $result = $this->wtw_request($msg_url,$msg_json);

        return $result;
    }

    public function wtw_request($url,$data){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        if($data != null){
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 300); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $info = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            //echo 'Errno:'.curl_getinfo($curl);//捕抓异常
            //dump(curl_getinfo($curl));
        }
        return $info;
    }



    //支付api调用
    public function doMobilePay(){
        global $_W,$_GPC;
        if (empty($_W['fans']['nickname'])) {
            mc_oauth_userinfo();
        }
        $order=pdo_get('wyt_luntan_pay',array('serial' =>$_GPC['orderid']));
        ! $order && message('订单不存在', '', 'error');
        $params = array(
            'tid'     => $order['serial'],      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
            'ordersn' => $order['serial'],  //收银台中显示的订单号
            'title'   => '账户充值',          //收银台中显示的标题
            'fee'     => $order['money'],      //收银台中显示需要支付的金额,只能大于 0
            'user'    => $_W['fans']['nickname']    //付款用户, 付款的用户名(选填项)
        );

        //调用pay方法
        $this->pay($params);

    }

    public function payResult($params) {
        global $_W;
       	$order=pdo_get('wyt_luntan_pay',array('serial' =>$params['tid']));
        $set=pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));

        if($order['dopenid'] =='award'){
            if ($params['result'] == 'success' && $params['from'] == 'notify') {
                pdo_update('wyt_luntan_thread',array('award'=>$order['money']),array('id'=>$order['thread_id']));
            }
            if ($params['from'] == 'return') {
                if ($params['result'] == 'success') {
                    message("支付成功", $this->createMobileUrl('Index'), "success");
                }else{
                    message("支付失败", $this->createMobileUrl('Index' ), "error");
                }
            }

            exit;
        }



        if($params['result'] == 'success'){
            $this->templetemsg($set['mes'],$order['topenid'],$_W['fans']['nickname'],'被打赏啦！快去看看~',	$order['thread_id'],'有人打赏了您的帖子');
        }
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            header("Location:" . $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&action=pay_s&orderid=".$params['tid']."&do=Index&m=".MODULE_NAME);
        }
        if ($params['from'] == 'return') {
            if ($params['result'] == 'success') {
				message('打赏成功', $this->createMobileUrl('Index', array('action' => 'info','id' => $order['thread_id'])), 'success');
            }
        }
    }


    public function doMobileToken()
    {
        global $_W,$_GPC;
        $account_api = WeAccount::create();
        $account_api->clearAccessToken();
        $token = $account_api->getAccessToken();
        $url = $_GPC['url'];
        $tocket_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$token."&type=jsapi";

        $tic_data = ihttp_get($tocket_url);
        $tic_json = json_decode($tic_data['content'],true);
        $ticket = $tic_json['ticket'];

        $time = 1414587462;
        $nonceStr = "wyt_luntan";
        $urls = $url;

        $str = "jsapi_ticket={$ticket}&noncestr={$nonceStr}&timestamp={$time}&url={$urls}";
        $config = array(
            'time' => 1414587462,
            'nonceStr' => $nonceStr,
            'singatura' => sha1($str),
            'url' => $url
        );
        echo json_encode($config);


    }

    static function downloadFromWxServer($media_ids, $settings)
    {
        global $_W, $_GPC;
        $media_ids = explode(',', $media_ids);
        if (!$media_ids) {
            echoJson(array('res' => '101', 'message' => 'media_ids error'));
        }
//		load()->classs('weixin.account');

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$_W['account']['key']."&secret=".$_W['account']['secret'];

        $data_token = ihttp_get($url);

        $token = json_decode($data_token['content'],true);


        $access_token = $token['access_token'];
//        load()->func('communication');
//        load()->func('file');
        $contentType["image/gif"] = ".gif";
        $contentType["image/jpeg"] = ".jpeg";
        $contentType["image/png"] = ".png";
        foreach ($media_ids as $id) {
//            load()->func('logging');
//            logging_run($id,'trace','file00001');
            $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=" . $access_token . "&media_id=" . $id;
            $data = ihttp_get($url);
            $filetype = $data['headers']['Content-Type'];

            if($filetype == "image/jpeg")
            {
                $filename = date('YmdHis') .'_' . rand(1000, 9999) . $contentType[$filetype];
                $wr = file_write('/images/wyt_luntan/' . $filename, $data['content']);
                if ($wr) {
                    $file_succ[] = array('name' => $filename, 'path' => '/images/wyt_luntan/' . $filename, 'type' => 'local');
                }
            }
            else
            {
                $file_succ[] = array('name' => "", 'path' => '', 'type' => '');
            }
        }

        foreach ($file_succ as $key => $value) {
            $r = file_remote_upload('images/wyt_luntan/' . $value['name']);
            if (is_error($r)) {
                unset($file_succ[$key]);
                continue;
            }
            if($file_succ[$key]['name'] != "")
            {
                $file_succ[$key]['name'] = tomedia('images/wyt_luntan/' . $value['name']);
                $file_succ[$key]['type'] = 'other';
            }
        }

        return $file_succ;
    }


	/**
	 * 说明：
	 *
	 * @return  
	 * @param   type 
	 * @author  daixinguo57@163.com
	 */
	public function file_upload_luntan($file, $type = 'image', $name = '', $compress = false) {
		$harmtype = array('asp', 'php', 'jsp', 'js', 'css', 'php3', 'php4', 'php5', 'ashx', 'aspx', 'exe', 'cgi');
		if (empty($file)) {
			return error(-1, '没有上传内容');
		}
		if (!in_array($type, array('image', 'thumb', 'voice', 'video', 'audio'))) {
			return error(-2, '未知的上传类型');
		}
		global $_W;
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$ext = strtolower($ext);
		$setting = setting_load('upload');
		switch ($type) {
			case 'image':
			case 'thumb':
				$allowExt = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'ico');
				$limit = $setting['upload']['image']['limit'];
				break;
			case 'voice':
			case 'audio':
				$allowExt = array('mp3', 'wma', 'wav', 'amr');
				$limit = $setting['upload']['audio']['limit'];
				break;
			case 'video':
				$allowExt = array('rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4', 'mov');
				$limit = $setting['upload']['audio']['limit'];
				break;
		}
		$setting = $_W['setting']['upload'][$type];
		if (!empty($setting)) {
			$allowExt = array_merge($setting['extentions'], $allowExt);
		}
		if (!in_array(strtolower($ext), $allowExt) || in_array(strtolower($ext), $harmtype)) {
			return error(-3, '不允许上传此类文件');
		}
		if (!empty($limit) && $limit * 1024 < filesize($file['tmp_name'])) {
			return error(-4, "上传的文件超过大小限制，请上传小于 {$limit}k 的文件");
		}

		$result = array();
		if (empty($name) || $name == 'auto') {
			$uniacid = intval($_W['uniacid']);
			$path = "{$type}s/{$uniacid}/" . date('Y/m/');
			mkdirs(ATTACHMENT_ROOT . '/' . $path);
			$filename = file_random_name(ATTACHMENT_ROOT . '/' . $path, $ext);
	
			$result['path'] = $path . $filename;
		} else {
			mkdirs(dirname(ATTACHMENT_ROOT . '/' . $name));
			if (!strexists($name, $ext)) {
				$name .= '.' . $ext;
			}
			$result['path'] = $name;
		}
	
		$save_path = ATTACHMENT_ROOT . '/' . $result['path'];
		if (!file_move($file['tmp_name'], $save_path)) {
			return error(-1, '保存上传文件失败');
		}
	
		if ($type == 'image' && $compress) {
					file_image_quality($save_path, $save_path, $ext);
		}
	
		$result['success'] = true;
	
		return $result;
	}

}