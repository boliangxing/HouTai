<?php
require_once('Db/Db_config.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d');
	$hour = date('H');
	if($hour<10){
		$hour = substr($hour,1);
	}
	$sql = 'select count(t1.RecordID) as num from QPTreasureDB.dbo.RecordInsure t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.SourceUserID=t2.UserID left join QPAccountsDB.dbo.AccountsInfo t3 on t1.TargetUserID=t3.UserID  where t1.CollectDate>"'.$InsertDate.'" and t1.TradeType=3 and t2.MemberOrder>0 and t3.MemberOrder=0';
	$rs = mssql_query($sql,$conn);
	$result = mssql_fetch_assoc($rs);
	$Num = $result['num'];
	$sql2 = 'select count(ID) as count from QPWebBackDB.dbo.UserZzCount where InsertDate="'.$InsertDate.'"';
	$rs2 = mssql_query($sql2,$conn);
	$result2 = mssql_fetch_assoc($rs2);
	$Num2 = $result2['count'];
	if($Num2==0){
		$sql3 = 'Insert into QPWebBackDB.dbo.UserZzCount (t'.$hour.',InsertDate) values('.$Num.',"'.$InsertDate.'")';
	}else{
		$sql3 = 'Update QPWebBackDB.dbo.UserZzCount set t'.$hour.'='.$Num.' where InsertDate="'.$InsertDate.'"';
	}
	mssql_query($sql3,$conn);
