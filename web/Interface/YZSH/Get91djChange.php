<?php 
require_once '../../Db/Db_config.php';
session_start();
$return = array();

if(!$_POST['Accounts'] || !$_POST['pwd1'] || !$_POST['pwd2'] || !$_SESSION['hs_user']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$UserID=$_SESSION['hs_user']['gameid'];
$sign=$_SESSION['hs_user']['sign'];
$Accounts=$_POST['Accounts'];
$LogonPass=strtoupper(md5($_POST['pwd1']));
$InsurePass=strtoupper(md5($_POST['pwd2']));

$MySign=md5($UserID.$Key);
$strClientIP = GetIP();

if($MySign==$sign){
	$error_msg = '';
	$procedure = mssql_init("PHP_IF_Complete91User",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4); 
	mssql_bind($procedure,"@strAccounts",$Accounts,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strLogonPass",$LogonPass,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strInsurePass",$InsurePass,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strClientIP", $strClientIP, SQLVARCHAR,false,false,15); 
	mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);
	
	$resource = mssql_execute($procedure);
	if(!$resource){
		$return['error'] = '2';
		$return['error_msg'] = '执行错误';
		echo json_encode($return);
		return;
	}
	if($ret == 0){	
		//获取存储过程返回错误信息
		//mssql_next_result($resource);
		$return['error'] = 0;
		$return['error_msg'] = '';
		echo json_encode($return);
	
	}else{
		$return['error'] = $ret;
		$return['error_msg'] = '验证出错';
		echo json_encode($return);
	}
	mssql_free_statement($procedure); 
	mssql_close($conn);
}else{
	$return['error'] = 9;
	$return['error_msg'] = '验签出错';
	echo json_encode($return);
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



