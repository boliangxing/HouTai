<?php 
require_once 'Db_config.php';
header("Content-type: text/html; charset=utf-8"); 
$return = array();

if(!$_GET['Accounts'] || !$_GET['PassWord'] || !$_GET['Date'] || !$_GET['Money'] || !$_GET['Sign']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$Accounts=$_GET['Accounts'];
$PassWord=$_GET['PassWord'];
$Date=$_GET['Date'];
$Score=$_GET['Money'];
$OrderID = $Accounts.time();
$Sign=strtolower($_GET['Sign']);//签名
$strClientIP = GetIP();
//$MySign = md5(userid+时间戳+随机数+密码+密钥)

$MySign = md5($Accounts.$Date.$Key);
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
	$procedure = mssql_init("GSP_GP_ByAddMoney",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@strAccounts",$Accounts,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strLogonPass",$PassWord,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strOrderID",$OrderID,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@Score",$Score,SQLFLT8);
	mssql_bind($procedure,"@strClientIP", $strClientIP, SQLVARCHAR,false,false,15); 
	mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);
	
	$resource = mssql_execute($procedure);
	if(!$resource){
		$return['result'] = '2';
		$return['reason'] = '执行错误';
		echo json_encode($return);
		return;
	}
	$error_msg = iconv('gb2312', 'utf-8', $error_msg);
	$return['result'] = $ret;
	$return['reason'] = $error_msg;
	echo json_encode($return);
	return;
		
	//获取存储过程返回错误信息
	//mssql_next_result($resource);
	mssql_free_statement($procedure); 
	mssql_close($conn);
}

function GetIP(){
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  $cip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
elseif(!empty($_SERVER["REMOTE_ADDR"])){
  $cip = $_SERVER["REMOTE_ADDR"];
}
else{
  $cip = "无法获取！";
}
return $cip;
}



