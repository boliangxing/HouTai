<?php 
require_once 'Db_config.php';
header("Content-type: text/html; charset=utf-8"); 
$return = array();
if(!$_GET['Date'] || !$_GET['Sign'] || !$_GET['Accounts'] || !$_GET['PassWord']){
	$return['result'] = '1';
	$return['reason'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$Random=$_GET['Random'];//随机数
$Date=$_GET['Date'];//时间戳
$Accounts=$_GET['Accounts'];//时间戳
$PassWord=$_GET['PassWord'];
$Sign=strtoupper($_GET['Sign']);//签名
$strClientIP = GetIP();
//$MySign = md5(userid+时间戳+随机数+密码+密钥)
$MySign = strtoupper(md5($Accounts.$Date.$Key));
//echo $MySign;
//exit;
if($Sign != $MySign){
	$return['result'] = '1';
	$return['reason'] = '验签出错';
	//print_r($return);
	echo json_encode($return);
	return false;
}else{
	$error_msg = '';
	$procedure = mssql_init("GSP_GP_ByRegisterAccounts",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);	
	mssql_bind($procedure,"@strAccounts",$Accounts,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strLogonPass",$PassWord, SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strClientIP", $strClientIP, SQLVARCHAR,false,false,15); 
	mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);
	
	//var_dump(mssql_execute($procedure));
	//exit;
	$resource = mssql_execute($procedure);
	if(!$resource){
		$return['result'] = '2';
		$return['reason'] = '执行错误';
		echo json_encode($return);
		return;
	}
	if($ret == 0){
		if ($row=mssql_fetch_assoc($resource)) {  
			//print_r($row);
			$return['result'] = $ret;
			$return['reason'] = $error_msg;
			$return['account'] = $row['Accounts'];
			$return['password'] = $row['LogonPass'];
			echo json_encode($return);
			return;
		}
	}else{
		$error_msg = iconv('gb2312', 'utf-8', $error_msg);
		$return['result'] = $ret;
		$return['reason'] = $error_msg;
		echo json_encode($return);
		return;
	}	
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



