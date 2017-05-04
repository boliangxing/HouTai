<?php
require_once('Db/Db_config.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d');
	$hour = date('H');
	if($hour<10){
		$hour = substr($hour,1);
	}
	$sql = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker(nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID left join 
	QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID where t2.MemberOrder=0 and t3.InsureScore+t3.Score>300000';
	$rs = mssql_query($sql,$conn);
	$result = mssql_fetch_assoc($rs);
	$Num = $result['num'];

	$sql2 = 'select count(ID) as count from QPWebBackDB.dbo.UserOnlineCount(nolock) where InsertDate="'.$InsertDate.'"';
	$rs2 = mssql_query($sql2,$conn);
	$result2 = mssql_fetch_assoc($rs2);
	$Num2 = $result2['count'];

	if($Num2==0){
		$sql3 = 'Insert into QPWebBackDB.dbo.UserOnlineCount (t'.$hour.',InsertDate) values('.$Num.',"'.$InsertDate.'")';
	}else{
		$sql3 = 'Update QPWebBackDB.dbo.UserOnlineCount set t'.$hour.'='.$Num.' where InsertDate="'.$InsertDate.'"';
	}
	echo $sql3;
	//exit;
	mssql_query($sql3,$conn);
