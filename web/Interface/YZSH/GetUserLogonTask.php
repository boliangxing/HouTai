<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$UserID=$_POST['UserID'];
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Sign=strtolower($_POST['Sign']);//签名

//$MySign = md5(userid+时间戳+随机数+密码+密钥)

$MySign = md5($UserID.$Date.$Random.$Key);
//echo $MySign;
//exit;
if($Sign != $MySign){
	$return['error'] = '1';
	$return['error_msg'] = '验签出错';
	//print_r($return);
	echo json_encode($return);
	return false;
}else{
	$procedure = mssql_init("PHP_IF_UserLogonTask",$conn); 
		mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
		mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4); 
		mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);

		$resource = mssql_execute($procedure);
		if(!$resource){
			$return['error'] = '1';
			$return['error_msg'] = '执行错误';
			echo json_encode($return);
			return;
		}		
		if ($row=mssql_fetch_assoc($resource)) {  
			$return['data'] = $row;
		}	
		if($ret!=0){
			$error_msg = iconv('gb2312', 'utf-8', $error_msg);
			$return['error'] = $ret;
			$return['error_msg'] = $error_msg;
			echo json_encode($return);
			return;
		}					
		$return['error'] = 0;
		$return['error_msg'] = '';
		echo json_encode($return);
}




