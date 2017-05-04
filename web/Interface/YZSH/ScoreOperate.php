<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Type'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['KindID'] || !$_POST['ServerID'] || !$_POST['Score']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}
// 'sykt2013-09-30'; md5 后10位为秘钥

//$Key = '3bde1c26e7';//秘钥
$UserID=$_POST['UserID'];
$Score=$_POST['Score'];//金币数
$KindID=$_POST['KindID'];//游戏id
$ServerID=$_POST['ServerID'];//房间id
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Type=$_POST['Type'];//1是存入  2是取出 
$Sign=strtolower($_POST['Sign']);//签名
$strClientIP = 'mobile';
$strMachineID = ' ';
if($Type==2){
	if(!$_POST['PassWord']){
		$return['error'] = '1';
		$return['error_msg'] = '参数缺失';
		echo json_encode($return);
		return false;
	}else{
		$PassWord=$_POST['PassWord'];
	}	
}

//$MySign = md5(userid+时间戳+随机数+金币数+密钥)

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
	//存
	if($Type==1){
		$procedure = mssql_init("PHP_IF_UserSaveScore",$conn); 
		mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
		mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4);
		mssql_bind($procedure,"@lSaveScore",$Score,SQLFLT8);
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
			return;
		}	
		$error_msg = iconv('gb2312', 'utf-8', $error_msg);
		if($ret!=0){
			$return['error'] = $ret;
			$return['error_msg'] = $error_msg;
			echo json_encode($return);
			return;
		}			
		if ( mssql_num_rows($resource) != 0 ) {  
			$row=mssql_fetch_assoc($resource);
			$return['data'] = $row;
		}
		mssql_next_result($resource);
		$error_msg = iconv('gb2312', 'utf-8', $error_msg);
		
		$return['error'] = $ret;
		$return['error_msg'] = $error_msg;
		echo json_encode($return);
		mssql_free_statement($procedure); 
		mssql_close($conn);
	}
	//取
	if($Type==2){
		$procedure = mssql_init("PHP_IF_UserTakeScore",$conn); 
		mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
		mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4);
		mssql_bind($procedure,"@lTakeScore",$Score,SQLFLT8);
		mssql_bind($procedure,"@strPassword", $PassWord, SQLCHAR,false,false,32);
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
			return;
		}	
		
		$error_msg = iconv('gb2312', 'utf-8', $error_msg);
		if($ret!=0){
			$return['error'] = $ret;
			$return['error_msg'] = $error_msg;
			echo json_encode($return);
			return;
		}			
		if ( mssql_num_rows($resource) != 0 ) {  
			$row=mssql_fetch_assoc($resource);
			$return['data'] = $row;
		}
		mssql_next_result($resource);
		$error_msg = iconv('gb2312', 'utf-8', $error_msg);
		
		$return['error'] = $ret;
		$return['error_msg'] = $error_msg;
		echo json_encode($return);
		mssql_free_statement($procedure); 
		mssql_close($conn);
	}
	
}




