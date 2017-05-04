<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Type'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['TargetUser']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

$UserID=$_POST['UserID'];
$Type=$_POST['Type'];//1是NickName  2是GameID  
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$TargetUser=$_POST['TargetUser'];//目标用户
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
	if($Type==1){
		$sql = 'select t1.UserID as UserID,t1.GameID as GameID,t1.NickName as NickName,t1.FaceID as FaceID,t1.IsLockMobile as IsLockMobile,t1.Gender as Gender,t2.Score as Score,t2.InsureScore as InsureScore from QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t2 on t1.UserID=t2.UserID where t1.NickName="'.$TargetUser.'"';	
	}
	if($Type==2){
		$sql = 'select t1.UserID as UserID,t1.GameID as GameID,t1.NickName as NickName,t1.FaceID as FaceID,t1.IsLockMobile as IsLockMobile,t1.Gender as Gender,t2.Score as Score,t2.InsureScore as InsureScore from QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t2 on t1.UserID=t2.UserID where t1.GameID='.$TargetUser;	
	}
	if($result = mssql_query($sql,$conn)){
		if(!($rs = mssql_fetch_assoc($result))){
			$return['error'] = '2';
			$return['error_msg'] = '用户不存在';
			echo json_encode($return);
			return;
		}else{
			$return['error'] = '0';
			$return['error_msg'] = '';
			$return['GameID'] = $rs['GameID'];
			$return['NickName'] = iconv("GB2312","UTF-8",$rs['NickName']);
			//$return['NickName'] = $rs['NickName'];
			$return['FaceID'] = $rs['FaceID'];
			$return['IsLockMobile'] = $rs['IsLockMobile'];
			$return['Gender'] = $rs['Gender'];
			$return['Score'] = $rs['Score'];
			$return['InsureScore'] = $rs['InsureScore'];
			echo json_encode($return);
			return;
		}		
	}	
}




