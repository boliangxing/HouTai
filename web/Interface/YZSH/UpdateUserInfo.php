<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['LogonPass'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['NickName']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$UserID=$_POST['UserID'];
$LogonPass=$_POST['LogonPass'];//原密码
$Gender=$_POST['Gender'];//新密码
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$NickName=iconv("UTF-8","GB2312",$_POST['NickName']);
$ChangeNick=$_POST['ChangeNick'];
if($ChangeNick==1){//不修改昵称
	$NickName = '***111****222****sss***11';
}
if(strlen($_POST['NickName'])<2){
	$return['error'] = '1';
	$return['error_msg'] = '昵称不得小于两个字符';
	//print_r($return);
	echo json_encode($return);
	return false;
}

//$NickName=$_POST['NickName'];
$Sign=strtolower($_POST['Sign']);//签名
$strClientIP = 'mobile';
//$MySign = md5(userid+时间戳+随机数+密码+密钥)

$MySign = md5($UserID.$Date.$Random.$LogonPass.$Key);
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
	$procedure = mssql_init("PHP_IF_UpdateUserInfo",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4);
	mssql_bind($procedure,"@strLogonPass", $LogonPass, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@cbGender",$Gender,SQLINT1);
	mssql_bind($procedure,"@strNickName", $NickName, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@strClientIP", $strClientIP, SQLVARCHAR,false,false,15);
	mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);
	
	$resource = mssql_execute($procedure);
	if(!$resource){
		$return['error'] = '1';
		$return['error_msg'] = '执行错误';
		echo json_encode($return);
		return;
	}
	if($ret == 0){
		if ($row=mssql_fetch_assoc($resource)) {  
			$return['data']['NickName'] =  iconv('gb2312', 'utf-8', $row['NickName']);
			$return['data']['FaceID'] = $row['FaceID'];
			$return['data']['Gender'] = $row['Gender'];
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




