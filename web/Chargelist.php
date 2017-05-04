<?php
require_once('Db/Db_charge.php'); 
//exit;
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date("Y-m-d",strtotime("-1 day"));
	//$InsertDate = '2016-09-08';
	$start_date = $InsertDate.' 00:00:00';
	$end_date = $InsertDate.' 23:59:59';
	$webali=0;
	$webwx=0;
	$mbali=0;
	$mbwx=0;
	$app=0;
	$app5678=0;
	$appzzl=0;
	$webzzlali=0;
	$webzzlwx=0;
	$mbzzlali=0;
	$mbzzlwx=0;
	$mb5678ali=0;
	$mb5678wx=0;
	
	$sql = 'select shareID,sum(PayAmount) as num from QPTreasureDB.dbo.ShareDetailInfo(nolock) where ApplyDate between "'.$start_date.'" and "'.$end_date.'" group by shareID';
	$res = mssql_query($sql,$conn);
	while ($row = mssql_fetch_assoc($res)){
		$rs[]=$row;
	}
	foreach($rs as $k=>$v){
		if($rs[$k]['shareID']==31){
			$mbali=$rs[$k]['num'];
		}
		
	}
echo $mbali;
exit;
	if($result5['num']==0){
		$sql6 = 'Insert into QPWebBackDB.dbo.ChargeCount (zfb,yb,app,wx,o3,InsertDate) values('.$Num.','.$Num4.','.$Num2.','.$Num3.','.$Num8.',"'.$InsertDate.'")';	
		mssql_query($sql6,$conn);
	}

	
	
