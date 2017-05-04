<?php
require_once('Db/Db_charge.php'); 
//exit;
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date("Y-m-d",strtotime("-1 day"));
	//$InsertDate = '2016-09-08';
	$start_date = $InsertDate.' 00:00:00';
	$end_date = $InsertDate.' 23:59:59';

	$sql = 'select sum(PayAmount) as num from QPTreasureDB.dbo.ShareDetailInfo where shareID in (13,31,24,52) and ApplyDate between "'.$start_date.'" and "'.$end_date.'"';
	$sql2 = 'select sum(PayAmount) as num from QPTreasureDB.dbo.ShareDetailInfo where shareID in (14,23) and ApplyDate between "'.$start_date.'" and "'.$end_date.'"';
	$sql3 = 'select sum(PayAmount) as num from QPTreasureDB.dbo.ShareDetailInfo where shareID in (22,42,53,54) and ApplyDate between "'.$start_date.'" and "'.$end_date.'"';
	$sql4 = 'select sum(PayAmount) as num from QPTreasureDB.dbo.ShareDetailInfo where shareID=35 and ApplyDate between "'.$start_date.'" and "'.$end_date.'"';
	$sql8 = 'select sum(CardGold) as num from QPTreasureDB.dbo.ShareDetailInfo where ApplyDate between "'.$start_date.'" and "'.$end_date.'"';
	$rs = mssql_query($sql,$conn);
	$result = mssql_fetch_assoc($rs);
	$Num = $result['num'];
	if(!$Num){$Num=0;}
	$rs2 = mssql_query($sql2,$conn);
	$result2 = mssql_fetch_assoc($rs2);
	$Num2 = $result2['num'];
	if(!$Num2){$Num2=0;}
	$rs3 = mssql_query($sql3,$conn);
	$result3 = mssql_fetch_assoc($rs3);
	$Num3 = $result3['num'];
	if(!$Num3){$Num3=0;}
	$rs4 = mssql_query($sql4,$conn);
	$result4 = mssql_fetch_assoc($rs4);
	$Num4 = $result4['num'];
	if(!$Num4){$Num4=0;}
	$rs8 = mssql_query($sql8,$conn);
	$result8 = mssql_fetch_assoc($rs8);
	$Num8 = $result8['num'];
	if(!$Num8){$Num8=0;}
	$sql5 = 'select count(ID) as num from QPWebBackDB.dbo.ChargeCount  where InsertDate="'.$InsertDate.'"';
	$rs5 = mssql_query($sql5,$conn);
	$result5 = mssql_fetch_assoc($rs5);

	if($result5['num']==0){
		$sql6 = 'Insert into QPWebBackDB.dbo.ChargeCount (zfb,yb,app,wx,o3,InsertDate) values('.$Num.','.$Num4.','.$Num2.','.$Num3.','.$Num8.',"'.$InsertDate.'")';	
		mssql_query($sql6,$conn);
	}
	
	
	
