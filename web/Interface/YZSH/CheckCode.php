<?php 
require_once('../../Db/pdo/sqlite.class.php'); 
require_once '../Db_config.php';

$return = array();

if(!$_POST['Phone'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}
// 'sykt2013-09-30'; md5 后10位为秘钥

//$Key = '3bde1c26e7';//秘钥
$Phone = $_POST['Phone'];
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Sign=strtolower($_POST['Sign']);//签名

$MySign = md5($Phone.$Date.$Random.$Key);

//echo $MySign;
//exit;

if($Sign != $MySign){
	$return['error'] = '1';
	$return['error_msg'] = '验签出错';
	//print_r($return);
	echo json_encode($return);
	return false;
}else{
	$return['error'] = '0';
	$return['error_msg'] = '';
	$code = getCode($Phone);
	//$str = '您申请的手机认证服务验证码为'.$code.',30分钟内有效,如非本人操作,请联系客服！[华商在线游戏中心]';
	//$str =  iconv("UTF-8","GB2312",$str);
	//$url = 'http://www.qz004.com/http/SendSms?Account=852139&Password=202cb962ac59075b964b07152d234b70&Phone='.$Phone.'&Content='.$str.'&Content=&SubCode=&SendTime=';     
	//sendSms($url);
	$target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
	//替换成自己的测试账号,参数顺序和wenservice对应
	$post_data = "account=cf_sulifu&password=a123456&mobile=".$Phone."&content=".rawurlencode("您申请的手机认证服务验证码为：".$code.",30分钟内有效,如非本人操作,请联系客服！");
	//$binarydata = pack("A", $post_data);
	Post($post_data, $target);
	
	echo json_encode($return);
	return false;
}

function getCode($Phone){
	$sqlite = new db_sqlite();
    $sqlite->sqlite('../../Db/hs.db');
    $str = '123456789';
    $count = strlen($str);
    $check_code = '';
    $str1 = '';
    $rs = array();
    for($i=0;$i<4;$i++){
    	$str1 = $str{rand(0, $count-1)};
    	$check_code = $check_code.$str1;
    }

    $sql = 'select phone,code,send_num,insertdate from check_code where type=3 and phone="'.$Phone.'"';
	if(!$rs = $sqlite->query($sql)->fetchAll()){
		$arr = array('phone'=>$Phone,'code'=>$check_code,'insertdate'=>date('Y-m-d H:i:s'),'type'=>3);
		$sqlite->insert('check_code', $arr);
		return $check_code;
	}
	if($rs[0]['code']==$check_code){
		getCode($Phone);
	}else{
		if(date('Y-m-d')==date('Y-m-d',strtotime($rs[0]['insertdate']))){
			$arr = array('code'=>$check_code,'insertdate'=>date('Y-m-d H:i:s'),'send_num'=>$rs[0]['send_num']+1);
			$condition = array('phone'=>$Phone,'type'=>3);
			$sqlite->update('check_code', $arr,$condition);
			if($rs['0']['send_num']>50){
				return false;
			}
		}else{
				$arr = array('code'=>$check_code,'insertdate'=>date('Y-m-d H:i:s'),'send_num'=>1);
				$condition = array('phone'=>$Phone,'type'=>3);
				$sqlite->update('check_code', $arr,$condition);
		}
		return $check_code;
	}				
	
}

function sendSms($url){
	$curl_handle=curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_handle, CURLOPT_HEADER, 0);
	curl_exec($curl_handle);
	curl_close($curl_handle);
}
function Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}
