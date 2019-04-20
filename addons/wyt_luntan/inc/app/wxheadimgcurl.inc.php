<?php
	global $_W,$_GPC;
	$avatar = Get_header_imgs($_GPC['uid']);
	$curl_img = wxHeadimgCurl($avatar);
	echo $curl_img;
	exit;
	
	/**
	 * 说明：处理微信网络图片拼海报请求慢的解决方案
	 *
	 * @return  
	 * @param   type 
	 * @author  daixinguo57@163.com
	 */
	function wxHeadimgCurl($avatar){
	    header('Content-Type: image/jpeg');
		global $_W,$_GPC;
		$prefix = substr($avatar,0,7);
		$prefixs = substr($avatar,0,8);
		$headurlarr = explode("/",$avatar);
		if($prefix == 'http://'){		
			$ip = gethostbyname($headurlarr[2]);
			$headurlarr[2] = $ip;
			$newheadurl = implode("/",$headurlarr);
			$newheadimg = getImgForCurl($newheadurl,$qrfile_path);
		}else if($prefixs == 'https://'){
			if($headurlarr[2] == 'thirdwx.qlogo.cn'){
				//微信服务器头像 使用IP替换域名时可忽略证书（https协议）
				$ip = gethostbyname($headurlarr[2]);
				$headurlarr[2] = $ip;
				$newheadurl = implode("/",$headurlarr);
				$need_ssl = 0;
				$newheadimg = getImgForCurl($newheadurl,$qrfile_path,$need_ssl);
			}else{
				$newheadimg = getImgForCurl($avatar,$qrfile_path);	
			}
		}else{
			$avatar = str_replace('.._','../',$avatar);
			$newheadimg = file_get_contents($avatar,true);		
		}
		return $newheadimg;
	}
	//curl请求微信服务上的网络地址头像
	function getImgForCurl($url, $path, $need_ssl = 1){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		if($need_ssl == 0){
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//忽略证书
		}
		$file = curl_exec($ch);		 
	    curl_close($ch);
		return $file;  
		
	    //saveAsImage($url, $file, $path);
	}
	//下载微信头像到本地
  	function saveAsImage($url, $file, $path){
		$filename = pathinfo($url, PATHINFO_BASENAME);
		$resource = fopen($path . $filename, 'a');
		fwrite($resource, $file);		
		fclose($resource);
		return $resource;
	}
?>