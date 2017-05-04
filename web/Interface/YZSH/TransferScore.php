<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Type'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['KindID'] || !$_POST['ServerID'] || !$_POST['PassWord'] || !$_POST['TargetUser']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$UserID=$_POST['UserID'];
$Type=$_POST['Type'];//1是NickName  2是GameID  
$Score=$_POST['Score'];//金币数
$PassWord=$_POST['PassWord'];//密码
$TargetUser=$_POST['TargetUser'];//目标用户
$KindID=$_POST['KindID'];//游戏id
$ServerID=$_POST['ServerID'];//房间id
$strClientIP = 'mobile';
$strMachineID = ' ';
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Sign=strtolower($_POST['Sign']);//签名

//$MySign = md5(userid+时间戳+随机数+密码+密钥)

$MySign = md5($UserID.$PassWord.$Date.$Random.$Key);
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
	$procedure = mssql_init("PHP_IF_UserTransferScore",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4);
	mssql_bind($procedure,"@cbByNickName",$Type,SQLINT4);
	mssql_bind($procedure,"@lTransferScore",$Score,SQLFLT8);
	mssql_bind($procedure,"@strPassword", $PassWord, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@strNickName", $TargetUser, SQLVARCHAR,false,false,31); 
	mssql_bind($procedure,"@wKindID", $KindID, SQLINT2); 
	mssql_bind($procedure,"@wServerID", $ServerID, SQLINT2);
	mssql_bind($procedure,"@strClientIP", $strClientIP, SQLVARCHAR,false,false,15); 
	mssql_bind($procedure,"@strMachineID", $strMachineID, SQLVARCHAR,false,false,32);
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




