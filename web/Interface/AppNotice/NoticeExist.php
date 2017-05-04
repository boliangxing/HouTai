<?php 
session_start();
require_once '../Db_config.php';
date_default_timezone_set('Asia/Shanghai');
$return = array();
$data = array();

if(!$_POST['UserID'] || !$_POST['Type'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['LogonPass']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}
// 'sykt2013-09-30'; md5 后10位为秘钥

$Key = '3bde1c26e7';//秘钥
$UserID=$_POST['UserID'];
$LogonPass=$_POST['LogonPass'];
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Type=$_POST['Type'];//1是活动  2是公告
$Sign=strtolower($_POST['Sign']);//签名



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
	$sql1 = 'select UserID from QPAccountsDB.dbo.AccountsInfo where UserID = '.$UserID.' and LogonPass="'.$LogonPass.'"';
	$result1 = mssql_query($sql1,$conn);
	if($rs1 = mssql_fetch_assoc($result1)){
		$UserID = $rs1['UserID'];
	}else{
		$return['error'] = '2';
		$return['error_msg'] = '用户不存在';
		//print_r($return);
		echo json_encode($return);
		return false;
	}
	
	$sql9='SELECT StatusValue from QPAccountsDB.dbo.SystemStatusInfo where StatusName="91open"';
	$result9 = mssql_query($sql9,$conn);
	if($rs9 = mssql_fetch_assoc($result9)){
		$Status = $rs9['StatusValue']; //1：只显示点金  2：不限制
	}
	if($Status==1){
		$Type=$Type+2;
	}

	$sql = 'select DetailID,Route,IsGet from QPAccountsDB.dbo.AppNotice where IsGet=1 and Type = '.$Type;

	$result = mssql_query($sql,$conn);
	if($rs = mssql_fetch_assoc($result)){
		$return['Route'] = $rs['Route'];
		$return['IsGet'] = $rs['IsGet'];
		/*
		if($rs['IsGet']==3){
			$sql3 = 'update QPAccountsDB.dbo.AppNotice set IsGet=1 where DetailID='.$rs['DetailID'];
			mssql_query($sql3,$conn);
		}
		*/
	}else{
		$sql2='select Route from QPAccountsDB.dbo.AppNotice where IsGet=3 and Type = '.$Type;
		$result2 = mssql_query($sql2,$conn);
		if($rs2 = mssql_fetch_assoc($result2)){
			$url = $rs2['Route'];
		}
		$return['error'] = '2';
		$return['error_msg'] = '列表为空';
		$return['Route'] = $url;
		//print_r($return);
		echo json_encode($return);
		return false;
	}
	if($Type==1 || $Type==3){
		$sql3='SELECT Num FROM QPAccountsDB.dbo.UserLotteryCount where UserID='.$UserID;
		$result3 = mssql_query($sql3,$conn);
		if($rs3 = mssql_fetch_assoc($result3)){
			$Num = $rs3['Num'];
		}else{
			$Num=0;
		}
		$sql4 = 'SELECT IsGet FROM QPAccountsDB.dbo.UserTaskInfo where UserID='.$UserID.' and TaskID=60';
		$result4 = mssql_query($sql4,$conn);
		if($rs4 = mssql_fetch_assoc($result4)){
			$first = $rs4['IsGet'];
		}else{
			$first=0;
		}
		$sql5= 'SELECT count(DetailID) as Count FROM QPAccountsDB.dbo.UserTaskInfo where UserID='.$UserID.' and IsGet=0 and TaskID between 61 and 65';
		$result5 = mssql_query($sql5,$conn);
		if($rs5 = mssql_fetch_assoc($result5)){
			$status = $rs5['Count'];
		}else{
			$status=0;
		}
		$sql6= 'SELECT count(DetailID) as Count FROM QPAccountsDB.dbo.UserTaskInfo where UserID='.$UserID.' and IsGet=2 and TaskID between 61 and 65';
		$result6 = mssql_query($sql6,$conn);
		if($rs6 = mssql_fetch_assoc($result6)){
			$thank = $rs6['Count'];
		}else{
			$thank=0;
		}
		$sign=md5($UserID.$Key);
		$user = array('gameid'=>$UserID,'sign'=>$sign);
		$_SESSION['hs_user']=$user;

		$sql7='select IsChangePWD from QPAccountsDB.dbo.DJUser where UserID='.$UserID;
		$result7 = mssql_query($sql7,$conn);
		if($rs7 = mssql_fetch_assoc($result7)){
			$IsComplete = $rs7['IsChangePWD'];
		}else{
			$IsComplete=4;
		}
		$return['Route'] = $return['Route'].'?UserID='.$UserID.'&Random='.$Random.'&Date='.$Date.'&Sign='.$Sign.'&Num='.$Num.'&first='.$first.'&status='.$status.'&thank='.$thank.'&IsComplete='.$IsComplete;
	}

		$return['error'] = '0';
		$return['error_msg'] = '';
		//print_r($return);
		echo json_encode($return);
}




