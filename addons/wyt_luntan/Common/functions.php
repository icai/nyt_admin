<?php
	/**
	 * 返回JSON格式数据
	 * @param type $status
	 * @param type $return
	 */
    function show_json($status = 1, $return = null)
    {
        $ret = array(
            'status' => $status,
            'result' => $status == 1 ? array('url' => referer()) : array()
        );

        if (!is_array($return)) {
            if ($return) {
                $ret['result']['message'] = $return;
            }
            die(json_encode($ret));
        } else {
            $ret['result'] = $return;
        }

        if (isset($return['url'])) {
            $ret['result']['url'] = $return['url'];
        } else if ($status == 1) {
            $ret['result']['url'] = referer();
        }
        die(json_encode($ret));
    }
	
	/**
	 * 说明：print_r 打印
	 *
	 * @return  
	 * @param   type 
	 * @author  daixinguo57@163.com
	 */
	function pd($val){
	    echo "<pre>";
		print_r($val);
		echo "</pre>";
		die;
	}
	
	function pp($val){
	    echo "<pre>";
		print_r($val);
		echo "</pre>";
	}
	
	function getuid(){
		global $_W,$_GPC;
		return $_W['member']['uid'];
	}
	
	/**
	 * 说明：注册和绑定的时候判断用户手机号码是否存在
	 *
	 * @return  
	 * @param   type 
	 * @author  daixinguo57@163.com
	 */
	function existMobile($mobile){
		global $_W,$_GPC;
	    $sql = 'SELECT `uid`,`mobile`,`password`,`salt`,`nickname` FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid AND `mobile`=:mobile';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$pars[':mobile'] = $mobile;
		$user = pdo_fetch($sql, $pars);
		if(!empty($user)){
		    return $user;
		}else{
			return FALSE;
		}
	}
	
	/**
	 * 说明：
	 *
	 * @return  
	 * @param   type 
	 * @author  daixinguo57@163.com
	 */
	function addheadimg($arr){
	    foreach($arr as $k=>$val){
	        $arr[$k]['headimgurl'] = Get_header_imgs($val['uid']);
	    }
		return $arr;
	}
	
	/**
	 * 说明：
	 *
	 * @return  
	 * @param   type 
	 * @author  daixinguo57@163.com
	 */
	function addmobile($arr){
	    foreach($arr as $k=>$val){
	        $arr[$k]['mobile'] = Get_mobile($val['uid']);
	    }
		return $arr;
	}
	
	function Get_header_imgs($uid=''){
        global $_W;
		if(!empty($uid)){
		    $uid = $uid;			
		}else{
			$uid = $_W['member']['uid'];
		}
		
		$imgurl = pdo_get('wyt_luntan_user', array('uid'=>$uid), array('avatar'));			
		//历史遗留问题 数据库该字段默认为一个空格 此处必须这样判断
		if(strlen($imgurl['avatar']) > 4){
			$prefix = substr($imgurl['avatar'],0,4);
			if($prefix == 'http'){
				$headimgurl = $imgurl['avatar'];
			}else{
				$headimgurl = IMG_DAKA_PATH.$imgurl['avatar'];
			}
		}

		if(empty($headimgurl)){
        	if ($_W['container'] == 'wechat') {
        		if($uid == $_W['member']['uid']){
        			$result = diy_account_userinfo();
					if (!empty($result)) {
		            	$fans = mc_oauth_userinfo();
		            	$headimgurl = preg_replace('/\/0$/', '/96', stripslashes($fans['avatar']));
					}	
        		}        		
        	}        	
        }
		
		if(empty($headimgurl)){
		    $headimgurl = 'resource/images/heading.jpg';
		}
		
        return $headimgurl;
    }
	
	function Get_mobile($uid=''){
        global $_W;
		if(!empty($uid)){
		    $uid = $uid;			
		}else{
			$uid = $_W['member']['uid'];
		}
		
		$user = pdo_get('zdaka_user', array('uid'=>$uid), array('mobile'));	
		$mobile = $user['mobile'];
		
        return $mobile;
    }

	function diy_account_userinfo($url = '') {
		global $_W;
		if (!empty($_SESSION['openid']) && intval($_W['account']['level']) >= 3) {
			$oauth_account = WeAccount::create();
			$userinfo = $oauth_account->fansQueryInfo($_SESSION['openid']);
			if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['nickname'])) {
				$userinfo['nickname'] = stripcslashes($userinfo['nickname']);
				$userinfo['avatar'] = $userinfo['headimgurl'];
				$_SESSION['userinfo'] = base64_encode(iserializer($userinfo));
				$fan = mc_fansinfo($_SESSION['openid']);
				if (!empty($fan)) {
					$record = array(
						'updatetime' => TIMESTAMP,
						'nickname' => stripslashes($userinfo['nickname']),
						'follow' => $userinfo['subscribe'],
						'followtime' => $userinfo['subscribe_time'],
						'tag' => base64_encode(iserializer($userinfo))
					);
					pdo_update('mc_mapping_fans', $record, array('openid' => $_SESSION['openid'], 'acid' => $_W['acid'], 'uniacid' => $_W['uniacid']));
				} else {
					$record = array();
					$record['updatetime'] = TIMESTAMP;
					$record['nickname'] = stripslashes($userinfo['nickname']);
					$record['tag'] = base64_encode(iserializer($userinfo));
					$record['openid'] = $_SESSION['openid'];
					$record['acid'] = $_W['acid'];
					$record['uniacid'] = $_W['uniacid'];
					$record['unionid'] = $userinfo['unionid'];
					pdo_insert('mc_mapping_fans', $record);
				}
	
				if (!empty($fan['uid']) || !empty($_SESSION['uid'])) {
					$uid = intval($fan['uid']);
					if (empty($uid)) {
						$uid = intval($_SESSION['uid']);
					}
					$member = mc_fetch($uid, array('nickname', 'gender', 'residecity', 'resideprovince', 'nationality', 'avatar'));
					$record = array();
					if (empty($member['nickname']) && !empty($userinfo['nickname'])) {
						$record['nickname'] = stripslashes($userinfo['nickname']);
					}
					if (empty($member['gender']) && !empty($userinfo['sex'])) {
						$record['gender'] = $userinfo['sex'];
					}
					if (empty($member['residecity']) && !empty($userinfo['city'])) {
						$record['residecity'] = $userinfo['city'] . '市';
					}
					if (empty($member['resideprovince']) && !empty($userinfo['province'])) {
						$record['resideprovince'] = $userinfo['province'] . '省';
					}
					if (empty($member['nationality']) && !empty($userinfo['country'])) {
						$record['nationality'] = $userinfo['country'];
					}
					if (empty($member['avatar']) && !empty($userinfo['headimgurl'])) {
						$record['avatar'] = $userinfo['headimgurl'];
					}
					if (!empty($record)) {
						pdo_update('mc_members', $record, array('uid' => $uid));
						cache_build_memberinfo($uid);
					}
				}
				return $userinfo;exit;
			}
		}
	
		if (empty($_W['account']['oauth'])) {
			return FALSE;exit;
		}
		if (empty($_W['account']['oauth']['key'])) {
			return FALSE;exit;
		}
		if (intval($_W['account']['oauth']['level']) < 4 && !in_array($_W['account']['oauth']['level'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WXAPP_WORK))) {
			return FALSE;exit;
		}
		return TRUE;
		exit;
	}

	/**
	 * 说明：记住用户登录状态
	 *
	 * @return  
	 * @param   type 
	 * @author  daixinguo57@163.com
	 */
	function rememberLogin($user,$path){
	    setcookie('asdf',$user['uid'],time()+3600*24*7,$path);
	}
	
	/** 
	 * 改变图片的宽高 
	 *  
	 * @author flynetcn (2009-12-16) 
	 *  
	 * @param string $img_src 原图片的存放地址或url  
	 * @param string $new_img_path  新图片的存放地址  
	 * @param int $new_width  新图片的宽度  
	 * @param int $new_height 新图片的高度 
	 * @return bool  成功true, 失败false 
	 */  
	function resize_image($img_src, $new_img_path, $new_width, $new_height){  
	    $img_info = @getimagesize($img_src);  
	    if (!$img_info || $new_width < 1 || $new_height < 1 || empty($new_img_path)) {  
	        return false;  
	    }  
	    if (strpos($img_info['mime'], 'jpeg') !== false) {  
	        $pic_obj = imagecreatefromjpeg($img_src);  
	    } else if (strpos($img_info['mime'], 'gif') !== false) {  
	        $pic_obj = imagecreatefromgif($img_src);  
	    } else if (strpos($img_info['mime'], 'png') !== false) {  
	        $pic_obj = imagecreatefrompng($img_src);  
	    } else {  
	        return false;  
	    }  
	    $pic_width = imagesx($pic_obj);  
	    $pic_height = imagesy($pic_obj);  
	    if (function_exists("imagecopyresampled")) {  
	        $new_img = imagecreatetruecolor($new_width,$new_height);  
	        imagecopyresampled($new_img, $pic_obj, 0, 0, 0, 0, $new_width, $new_height, $pic_width, $pic_height);  
	    } else {  
	        $new_img = imagecreate($new_width, $new_height);  
	        imagecopyresized($new_img, $pic_obj, 0, 0, 0, 0, $new_width, $new_height, $pic_width, $pic_height);  
	    }  
	    if (preg_match('~.([^.]+)$~', $new_img_path, $match)) {  
	        $new_type = strtolower($match[1]);  
	        switch ($new_type) {  
	            case 'jpg':  
	                imagejpeg($new_img, $new_img_path);  
	                break;  
	            case 'gif':  
	                imagegif($new_img, $new_img_path);  
	                break;  
	            case 'png':  
	                imagepng($new_img, $new_img_path);  
	                break;  
	            default:  
	                imagejpeg($new_img, $new_img_path);  
	        }  
	    } else {  
	        imagejpeg($new_img, $new_img_path);  
	    }  
	    imagedestroy($pic_obj);  
	    imagedestroy($new_img);  
	    return true;  
	}  	
	
	//过滤空格换行 用户微信分享时 desc不能包含空格和换行的处理方法
	function colationStr($str){
    	$search = array(" ","　","\n","\r","\t");
    	$replace = array("","","","","");
    	return str_replace($search, $replace, $str);
    }

?>