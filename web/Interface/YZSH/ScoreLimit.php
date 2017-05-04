<?php 
require_once '../Db_config.php';
$return = array();

if(!$_POST['UserID'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}
$UserID = $_POST['UserID'];
//$LogonPass = $_POST['LogonPass'];
$Random = $_POST['Random'];
$Date = $_POST['Date'];
$Sign=strtolower($_POST['Sign']);

//$MySign = md5(userid+时间戳+随机数+密钥)

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
	$sql3 = 'select UserID from QPAccountsDB.dbo.AccountsInfo where UserID='.$UserID;
	$result3 = mssql_query($sql3,$conn);
	if(!mssql_fetch_assoc($result3)){
		$return['error'] = '1';
		$return['error_msg'] = '用户不存在或密码错误';
		echo json_encode($return);
		return;
	}
	$return['error'] = '0';
	$return['error_msg'] = '';
	
	$sql = 'select StatusName,StatusValue from QPAccountsDB.dbo.SystemStatusInfo';
	$result = mssql_query($sql,$conn);
	while ($row = mssql_fetch_assoc($result)){
		$rs[] = $row;
	}
	foreach ($rs as $k=>$v){
		if($rs[$k]['StatusName']=='BankPrerequisite'){
			$return['data']['BankPrerequisite'] = $rs[$k]['StatusValue'];
		}
		if($rs[$k]['StatusName']=='TransferPrerequisite'){
			$return['data']['TransferPrerequisite'] = $rs[$k]['StatusValue'];
		}
		if($rs[$k]['StatusName']=='TransferRetention'){
			$return['data']['TransferRetention'] = $rs[$k]['StatusValue'];
		}
	}
	$sql2 = 'select Score,InsureScore from QPTreasureDB.dbo.GameScoreInfo where UserID='.$UserID;
	$result2 = mssql_query($sql2,$conn);
	if($row = mssql_fetch_assoc($result2)){
		$return['data']['Score'] = $row['Score'];
		$return['data']['InsureScore'] = $row['InsureScore'];
	}else{
		$return['error'] = '1';
		$return['error_msg'] = '用户不存在';
		echo json_encode($return);
		return;
	}
	
	echo json_encode($return);
}





