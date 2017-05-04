<?php 
require_once '../../Db/Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['NickName']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$UserID=$_POST['UserID'];
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$NickName=iconv("UTF-8","GB2312",$_POST['NickName']);
//$NickName=$_POST['NickName'];
$RegisterFrom=3;
$Sign=strtolower($_POST['Sign']);//签名
$strClientIP = GetIP();
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
	
	$error_msg = '';
	$procedure = mssql_init("GSP_GP_CooperationRegister",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@dwUserID",$UserID,SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@strCooNickName", $NickName, SQLVARCHAR,false,false,31); 
	mssql_bind($procedure,"@iRegisterFrom",$RegisterFrom,SQLINT4);
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
		if ($row=mssql_fetch_assoc($resource)) {  
			//print_r($row);
			$return['data']['Accounts'] = iconv("GB2312","UTF-8",$row['Accounts']);
			$return['data']['LogonPass'] = $row['LogonPass'];
		}
	}else{
		$error_msg = iconv('gb2312', 'utf-8', $error_msg);
	}	
	//获取存储过程返回错误信息
	//mssql_next_result($resource);
	$return['error'] = $ret;
	$return['error_msg'] = $error_msg;
	echo json_encode($return);
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



