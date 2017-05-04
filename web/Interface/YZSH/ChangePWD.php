<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Type'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['PassWord'] || !$_POST['NewPWD']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}
// 'sykt2013-09-30'; md5 后10位为秘钥

//$Key = '3bde1c26e7';//秘钥
$UserID=$_POST['UserID'];
$PassWord=$_POST['PassWord'];//原密码
$NewPWD=$_POST['NewPWD'];//新密码
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Type=$_POST['Type'];//1是修改登录密码  2是修改保险箱密码 
$Sign=strtolower($_POST['Sign']);

//$MySign = md5(userid+时间戳+随机数+密码+密钥)

$MySign = md5($UserID.$Date.$Random.$PassWord.$Key);
//echo $MySign;
//exit;

if($Sign != $MySign){
	$return['error'] = '1';
	$return['error_msg'] = '验签出错';
	//print_r($return);
	echo json_encode($return);
	return false;
}else{
	
	$error_msg = '';
	$procedure = mssql_init("PHP_IF_ChangePassWord",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4);
	mssql_bind($procedure,"@cbType",$Type,SQLINT4);
	mssql_bind($procedure,"@strPassWord", $PassWord, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@strNewPWD", $NewPWD, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);
	
	$resource = mssql_execute($procedure);
	if(!$resource){
		$return['error'] = '1';
		$return['error_msg'] = '执行错误';
		echo json_encode($return);
		mssql_free_statement($procedure); 
		mssql_close($conn);
		return;
	}
	//------------执行成功返回success-------------//
	$error_msg = iconv('gb2312', 'utf-8', $error_msg);
	//获取存储过程返回错误信息
	//mssql_next_result($resource);
	$return['error'] = $ret;
	$return['error_msg'] = $error_msg;
	echo json_encode($return);
	mssql_free_statement($procedure); 
	mssql_close($conn);
}




