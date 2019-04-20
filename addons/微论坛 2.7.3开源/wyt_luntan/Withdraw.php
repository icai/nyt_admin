<?php
class Withdraw{

    public function txian($openid,$uid,$money) {
        global $_GPC,$_W;
        $time = strtotime(date('Y-m-d H:i:s'));
        $set =  pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));
        $tx_money = $money*100;
        //发放单号
        $fafang_number = $uid.$time;
        $pars = array();
        $pars['mch_appid'] =$_W['account']['key'];
        $pars['mchid'] = $set['mch_id'];
        //产生随机字符串
        $pars['nonce_str'] = $this->createNoncestr();
        // 商户订单号
        $pars['partner_trade_no'] = $fafang_number;
        // 用户openid
        $pars['openid'] =$openid;
        // 校验用户姓名选项
        $pars['check_name'] = "NO_CHECK";
        // 企业付款金额  单位为分
        $pars['amount'] =$tx_money;
        // 企业付款描述信息
        $pars['desc'] = '提现';
        // 调用接口的机器IP地址  自定义
        $pars['spbill_create_ip'] =$_SERVER["REMOTE_ADDR"];
        //生成签名
        $pars['sign'] =$this->getSign($pars);
        $xml = $this->createXml($pars);
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $response = $this->curl_post_ssl($url, $xml);
        if( !empty($response) ) {
            $data = simplexml_load_string($response, null, LIBXML_NOCDATA);
            $jsonStr = json_encode($data);
            $jsonArray = json_decode($jsonStr,true);
            //微信交易单号
            $jiaoyi_number = $jsonArray['payment_no'];
            $jiaoyi_time = strtotime($jsonArray['payment_time']);
            if($jsonArray['result_code']=='SUCCESS'){
                return 1;exit;
            }else{
                return  $response;exit;
            }
        }else{
            //message($jsonArray['err_code_des'], $this->createMobileUrl('index'), 'error');
            return json_encode( array('return_code' => 'FAIL', 'return_msg' => 'transfers_接口出错', 'return_ext' => array()));
        }

    }

    /**
     * 生成请求xml数据
     * @return string
     */
    function createXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            $xml.="<".$key.">".$val."</".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     *  作用：产生随机字符串，不长于32位
     */
    function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    /**
     *  作用：格式化参数，签名过程需要使用
     */
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar="";
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }

    /**
     *  作用：生成签名
     */
    function getSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);

        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        global $_W,$_GPC;
        $uniacid =  $this->uniacid;

        $set =  pdo_get('wyt_luntan_set',array('acid'=>$_W['account']['acid']));
        $String = $String."&key=".$set['partnerkey'];
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;


    }

    function curl_post_ssl($url, $vars, $second=30,$aHeader=array())
    {

        global $_W,$_GPC;
        $url1 = MODULE_ROOT."/pay/".$_W['account']['acid'];
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

        //以下两种方式需选择一种

        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$url1.'/cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$url1.'/key.pem');

        //第二种方式，两个文件合成一个.pem文件
        //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);

        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }


    public function code_random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = '1234567899876543210159402101203261561';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }





}

?>