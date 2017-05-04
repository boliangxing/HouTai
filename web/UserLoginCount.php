<?php
require_once('Db/Db_config.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d');
	$hour = date('H');
	if($hour<10){
		$hour = substr($hour,1);
	}
	//ios
	$sql = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID 
	where t2.LockMobileKindID=1';
	$rs = mssql_query($sql,$conn);
	$result = mssql_fetch_assoc($rs);
	$Num = $result['num'];
	//android
	$sql2 = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID 
	where t2.LockMobileKindID=2';
	$rs2 = mssql_query($sql2,$conn);
	$result2 = mssql_fetch_assoc($rs2);
	$Num2 = $result2['num'];
	//pc
	$sql3 = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID 
	where t2.LockMobileKindID in (0,3)';
	$rs3 = mssql_query($sql3,$conn);
	$result3 = mssql_fetch_assoc($rs3);
	$Num3 = $result3['num'];

	//fufei
	$sql4 = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID 
	where t2.CustomID=1';
	$rs4 = mssql_query($sql4,$conn);
	$result4 = mssql_fetch_assoc($rs4);
	$Num4 = $result4['num'];
	
	//FF_ios
	$sql5 = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID 
	where t2.LockMobileKindID=1 and t2.CustomID=1';
	$rs5 = mssql_query($sql5,$conn);
	$result5 = mssql_fetch_assoc($rs5);
	$Num5 = $result5['num'];
	//FF_iandroid
	$sql6 = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID 
	where t2.LockMobileKindID=2 and t2.CustomID=1';
	$rs6 = mssql_query($sql6,$conn);
	$result6 = mssql_fetch_assoc($rs6);
	$Num6 = $result6['num'];
	//FF_ipc
	$sql7 = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID 
	where t2.LockMobileKindID in (0,3) and t2.CustomID=1';
	$rs7 = mssql_query($sql7,$conn);
	$result7 = mssql_fetch_assoc($rs7);
	$Num7 = $result7['num'];

	$sql8 = 'Insert into QPWebBackDB.dbo.LoginByCount (IOS,Android,PC,Hour,InsertDate,Fufei,FF_IOS,FF_and,FF_pc) values('.$Num.','.$Num2.','.$Num3.','.$hour.',"'.$InsertDate.'",'.$Num4.','.$Num5.','.$Num6.','.$Num7.')';
	mssql_query($sql8,$conn);
