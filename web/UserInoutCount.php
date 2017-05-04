<?php
require_once('Db/Db_config.php'); 
date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d');
	$Yesterday = date("Y-m-d",strtotime("-1 day"));
	$hour = date('H');
	if($hour<10){
		$hour = substr($hour,1);
	}
	$before = $hour-1;
	//sprintf("%02d", 2)
/*	echo $hour;
	echo $before;
	exit;*/
	//$hour=0;
	if($hour==0){
		$start_date=$Yesterday.' 23:00:00';
		$end_date = $InsertDate.' 00:00:00';
	}else{
		$before=sprintf("%02d", $before);
		$start_date=$InsertDate.' '.$before.':00:00';
		$end_date = $InsertDate.' '.$hour.':00:00';
	}

	//$start_date=;
	$sql='SELECT sum(t1.SwapScore) as zc
  FROM [QPTreasureDB].[dbo].[RecordInsure](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.SourceUserID=t2.UserID left join 
  QPAccountsDB.dbo.AccountsInfo(nolock) t3 on t1.TargetUserID = t3.UserID where t1.CollectDate between "'.$start_date.'" and  "'.$end_date.'" 
  and t2.MemberOrder>0 and t3.MemberOrder=0';
  	$rs = mssql_query($sql,$conn);
	$result = mssql_fetch_assoc($rs);
	$zc = $result['zc'];
	
	$sql2='SELECT sum(t1.SwapScore) as zr
  FROM [QPTreasureDB].[dbo].[RecordInsure](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.SourceUserID=t2.UserID left join 
  QPAccountsDB.dbo.AccountsInfo(nolock) t3 on t1.TargetUserID = t3.UserID where t1.CollectDate between "'.$start_date.'" and  "'.$end_date.'" 
  and t2.MemberOrder=0 and t3.MemberOrder>0';
	$rs2 = mssql_query($sql2,$conn);
	$result2 = mssql_fetch_assoc($rs2);
	$zr = $result2['zr'];

	if($hour==0){
		$sql3 = 'Update QPWebBackDB.dbo.UserZcCount set t24='.$zc.' where InsertDate="'.$Yesterday.'"';
		$sql4 = 'Update QPWebBackDB.dbo.UserZrCount set t24='.$zr.' where InsertDate="'.$Yesterday.'"';
	}elseif($hour==1){	
		$sql3 = 'Insert into QPWebBackDB.dbo.UserZcCount (t1,InsertDate) values('.$zc.',"'.$InsertDate.'")';
		$sql4 = 'Insert into QPWebBackDB.dbo.UserZrCount (t1,InsertDate) values('.$zr.',"'.$InsertDate.'")';
	}else{
		$sql3 = 'Update QPWebBackDB.dbo.UserZcCount set t'.$hour.'='.$zc.' where InsertDate="'.$InsertDate.'"';
		$sql4 = 'Update QPWebBackDB.dbo.UserZrCount set t'.$hour.'='.$zr.' where InsertDate="'.$InsertDate.'"';
	}
	mssql_query($sql3,$conn);
	mssql_query($sql4,$conn);
