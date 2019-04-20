<?php

//decode by http://www.yunlu99.com/
error_reporting(0);
function emoji_encode($str)
{
	$strEncode = '';
	$length = mb_strlen($str, "utf-8");
	$i = 0;
	while ($i < $length) {
		$_tmpStr = mb_substr($str, $i, 1, "utf-8");
		if (strlen($_tmpStr) >= 4) {
			$strEncode .= "[[EMOJI:" . rawurlencode($_tmpStr) . "]]";
		} else {
			$strEncode .= $_tmpStr;
		}
		$i++;
	}
	return $strEncode;
}
function emoji_decode($str)
{
	$strDecode = preg_replace_callback("|\\[\\[EMOJI:(.*?)\\]\\]|", function ($matches) {
		return rawurldecode($matches[1]);
	}, $str);
	return $strDecode;
}
function numToWord($num)
{
	$chiNum = array('', "一", "二", "三", "四", "五", "六", "七", "八", "九");
	$chiUni = array('', "十", "百", "千", "万", "亿", "十", "百", "千");
	$chiStr = '';
	$num_str = (string) (int) $num;
	$count = strlen($num_str);
	$last_flag = true;
	$zero_flag = true;
	$temp_num = null;
	$chiStr = '';
	if ($count == 2) {
		$temp_num = $num_str[0];
		$chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num] . $chiUni[1];
		$temp_num = $num_str[1];
		$chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
	} else {
		if ($count > 2) {
			$index = 0;
			$i = $count - 1;
			while ($i >= 0) {
				$temp_num = $num_str[$i];
				if ($temp_num == 0) {
					if (!$zero_flag && !$last_flag) {
						$chiStr = $chiNum[$temp_num] . $chiStr;
						$last_flag = true;
					}
				} else {
					$chiStr = $chiNum[$temp_num] . $chiUni[$index % 9] . $chiStr;
					$zero_flag = false;
					$last_flag = false;
				}
				$index++;
				$i--;
			}
		} else {
			$chiStr = $chiNum[$num_str[0]];
		}
	}
	return $chiStr;
}
function formatTime($date)
{
	$str = '';
	$timer = $date;
	$diff = $_SERVER["REQUEST_TIME"] - $timer;
	$day = floor($diff / 86400);
	$free = $diff % 86400;
	if ($day > 0) {
		return $day . "天前";
	} else {
		if ($free > 0) {
			$hour = floor($free / 3600);
			$free = $free % 3600;
			if ($hour > 0) {
				return $hour . "小时前";
			} else {
				if ($free > 0) {
					$min = floor($free / 60);
					$free = $free % 60;
					if ($min > 0) {
						return $min . "分钟前";
					} else {
						if ($free > 0) {
							return $free . "秒前";
						} else {
							return "刚刚";
						}
					}
				} else {
					return "刚刚";
				}
			}
		} else {
			return "刚刚";
		}
	}
}
function formatNumber($number)
{
	if (empty($number) || !is_numeric($number)) {
		return $number;
	}
	$unit = '';
	if ($number > 10000) {
		$leftNumber = floor($number / 10000);
		$rightNumber = round($number % 10000 / 10000, 2);
		$number = floatval($leftNumber + $rightNumber);
		$unit = "万";
	} else {
		$decimals = $number > 1 ? 2 : 6;
		$number = (float) number_format($number, $decimals, ".", '');
	}
	return (string) $number . $unit;
}
function filter_emoji($str)
{
	$str = preg_replace_callback("/./u", function (array $match) {
		return strlen($match[0]) >= 4 ? '' : $match[0];
	}, $str);
	return $str;
}
function subtext($text, $length)
{
	if (mb_strlen($text, "utf8") > $length) {
		return mb_substr($text, 0, $length, "utf8") . "…";
	}
	return $text;
}
function authcode($string, $operation = "DECODE", $key = '', $expiry = 0)
{
	$ckey_length = 4;
	$key = md5($key ? $key : $GLOBALS["discuz_auth_key"]);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? $operation == "DECODE" ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length) : '';
	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == "DECODE" ? base64_decode(substr($string, $ckey_length)) : sprintf("%010d", $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	$i = 0;
	while ($i <= 255) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		$i++;
	}
	$j = $i = 0;
	while ($i < 256) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
		$i++;
	}
	$a = $j = $i = 0;
	while ($i < $string_length) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ $box[($box[$a] + $box[$j]) % 256]);
		$i++;
	}
	if ($operation == "DECODE") {
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace("=", '', base64_encode($result));
	}
}
function ciphertext($string)
{
	$wteh = substr($string, 0, 3);
	$yeth = substr($string, -4);
	return $wteh . "********" . $yeth;
}
function athumbnail($data)
{
	$data = json_decode($data, true);
	return $data[0];
}
function contract($time)
{
	if ($time == '' || empty($time)) {
		return 0;
	}
	$nowTime = time();
	$timeOut = $nowTime - $time;
	return $timeOut >= 604800 ? 1 : 0;
}
function urlBridging($url)
{
	$absAddress = explode("index.php", $_SERVER["SCRIPT_NAME"]);
	$absRessReplace = "https://" . $_SERVER["HTTP_HOST"] . $absAddress[0];
	$absRess = str_replace("\\", "/", $absRessReplace);
	return $absRess . $url;
}