<?php 
require_once '../../Db/pdo/sqlite.class.php';
require_once '../../Db/Db_config.php';
$return = array();

if(!$_POST['UserID'] || !$_POST['LogonPass'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['InsurePass'] || !$_POST['Accounts'] || !$_POST['NickName'] || !$_POST['Phone'] || !$_POST['CheckCode']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}
// 'sykt2013-09-30'; md5 后10位为秘钥
$CheckCode=$_POST['CheckCode'];
$UserID=$_POST['UserID'];
$LogonPass=$_POST['LogonPass'];//登陆密码
$InsurePass=$_POST['InsurePass'];//银行密码
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Accounts=$_POST['Accounts'];
$NickName=iconv("UTF-8","GB2312",$_POST['NickName']);
$Gender=$_POST['Gender'];//性别 保密为0，男为1，女为2
$Phone = $_POST['Phone'];
$Sign=strtolower($_POST['Sign']);//签名
$strClientIP = 'mobile';
$RegisterType = 128;//ios手机注册类型

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
	$sqlite = new db_sqlite();
    $sqlite->sqlite('../../Db/hs.db');
    $sql3 = 'select code,insertdate,check_num from check_code where type=3 and phone="'.$Phone.'"';
	if(!$rs3 = $sqlite->query($sql3)->fetchAll()){
		$return['error'] = '5';
		$return['error_msg'] = '无验证码信息';
		//print_r($return);
		echo json_encode($return);
		return false;
	}
	if(strtotime(date('Y-m-d H:i:s'))-strtotime($rs3[0]['insertdate'])>30*60){
		$return['error'] = '5';
		$return['error_msg'] = '验证码超时';
		//print_r($return);
		echo json_encode($return);
		return false;	
	}
	if($rs3[0]['code']!=$CheckCode){
		$return['error'] = '5';
		$return['error_msg'] = '验证码错误';	
		
		if(date('Y-m-d')==date('Y-m-d',strtotime($rs3[0]['insertdate']))){
			$arr = array('check_num'=>$rs3[0]['check_num']+1);
			$condition = array('phone'=>$Phone,'type'=>3);
			$sqlite->update('check_code', $arr,$condition);
			if($rs3[0]['check_num']>50){
			$return['error'] = '7';
			$return['error_msg'] = '多次输入验证码错误';
			//print_r($return);
			echo json_encode($return);
			return false;
			}
			
		}else{
			$arr = array('insertdate'=>date('Y-m-d H:i:s'),'check_num'=>1);
			$condition = array('phone'=>$Phone,'type'=>1);
			$sqlite->update('check_code', $arr,$condition);
		}			
		//print_r($return);
		echo json_encode($return);
		return false;
	}	
	
	$error_msg = '';
	$procedure = mssql_init("PHP_IF_CompleteInfo",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4);
	mssql_bind($procedure,"@strLogonPass", $LogonPass, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@strInsurePass", $InsurePass, SQLVARCHAR,false,false,32);
	mssql_bind($procedure,"@cbGender",$Gender,SQLINT1);
	mssql_bind($procedure,"@strAccounts", $Accounts, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@strNickName", $NickName, SQLVARCHAR,false,false,32); 
	mssql_bind($procedure,"@strMobilePhone", $Phone, SQLVARCHAR,false,false,16);
	mssql_bind($procedure,"@strClientIP", $strClientIP, SQLVARCHAR,false,false,15);
	mssql_bind($procedure,"@RegisterType",$RegisterType,SQLINT4);
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




