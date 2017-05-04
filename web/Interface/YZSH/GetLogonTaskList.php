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
	$procedure = mssql_init("PHP_IF_UserLogonTaskList",$conn); 	
	$resource = mssql_execute($procedure);
	while ($row=mssql_fetch_assoc($resource)) {  
		$return['data'][] = $row;
	}
	$return['error'] = 0;
	$return['error_msg'] = '';
	echo json_encode($return);
	mssql_free_statement($procedure); 
	mssql_close($conn);	
}




