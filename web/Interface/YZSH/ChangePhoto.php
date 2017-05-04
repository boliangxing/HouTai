<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Type'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['LogonPass']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

//$Key = '3bde1c26e7';//秘钥
$UserID=$_POST['UserID'];
$LogonPass=$_POST['LogonPass'];
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Type=$_POST['Type'];//1是修改系统头像  2是修改自定义头像 
$Sign=$_POST['Sign'];//签名
if($Type==1){
	$FaceID=$_POST['FaceID'];
}
if($Type==2){
	if(!$_FILES['NewPhoto']){
		$return['error'] = '1';
		$return['error_msg'] = '参数缺失';
		echo json_encode($return);
		return false;
	}else{		
		$PSize = filesize($_FILES['NewPhoto']['tmp_name']);
		//echo $PSize;
		$Photo=addslashes(fread(fopen($_FILES['NewPhoto']['tmp_name'], "r"), $PSize));
		$Photo2 = file_get_contents($_FILES['NewPhoto']['tmp_name']);
		//$Photo = iconv("UTF-8","GB2312",$Photo);
	}	
}
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
	//更新系统头像
	if($Type==1){
		$procedure = mssql_init("PHP_IF_ChangeSystemPhoto",$conn); 
		mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
		mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4); 
		mssql_bind($procedure,"@strPassword", $LogonPass, SQLVARCHAR,false,false,32);
		mssql_bind($procedure,"@wFaceID", $FaceID, SQLINT2);
		mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);

		$resource = mssql_execute($procedure);
		if(!$resource){
			$return['error'] = '1';
			$return['error_msg'] = '执行错误';
			echo json_encode($return);
			return;
		}		
		if ($row=mssql_fetch_assoc($resource)) {  
			$return['FaceID'] = $row['FaceID'];
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
		mssql_free_statement($procedure); 
		mssql_close($conn);
	}
	//更换自定义头像
	if($Type==2){
		//mssql_query("BEGIN TRANSACTION ChangePhoto"); 
		
		$sql = 'select UserID from QPAccountsDB.dbo.AccountsInfo where UserID='.$UserID.' and LogonPass="'.$LogonPass.'"';
		$result = mssql_query($sql,$conn);
		if(!$row = mssql_fetch_assoc($result)){
			$return['error'] = '1';
			$return['error_msg'] = '用户不存在或密码错误';
			echo json_encode($return);
			return;
		}
		
		$sql2 = 'INSERT INTO QPAccountsDB.dbo.AccountsFace (UserID, CustomFace, InsertAddr, InsertMachine) VALUES ('.$UserID.', "'.$Photo2.'", "'.$strClientIP.'", "'.$strMachineID.'")';
		
		mssql_query($sql2,$conn);		
	}
	
}




