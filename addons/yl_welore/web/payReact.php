<?php
error_reporting(0);
//接收信息
$notify_data = file_get_contents("php://input");
file_put_contents('pay.txt', $notify_data);
//xml to arr
$values = json_decode(json_encode(simplexml_load_string($notify_data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
//获取域名
$absAddress = explode("payReact.php", $_SERVER['SCRIPT_NAME']);
$absRessReplace = 'https://' . $_SERVER['HTTP_HOST'] . $absAddress[0] . 'index.php?s=/api/notify/get_notify';
$absRess = str_replace('\\', '/', $absRessReplace);
try {
    $postdata = http_build_query($values);
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60
        )
    );
    $context = stream_context_create($opts);
    return file_get_contents($absRess, false, $context);
} catch (Exception $e) {
    return false;
}