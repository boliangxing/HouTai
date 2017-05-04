<?php
require_once('Db/Db_config.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d');
	$hour = date('H');
	if($hour<10){
		$hour = substr($hour,1);
	}
	$sql = 'SELECT sum(Score)+sum(InsureScore) as gold_sum FROM QPTreasureDB.dbo.GameScoreInfo(NOLOCK)';
	$rs = mssql_query($sql,$conn);
	$result = mssql_fetch_assoc($rs);
	$Num = $result['gold_sum'];
	$Num = sprintf("%.2f", $Num/100000000); 

	$sql2 = 'select count(ID) as count from QPWebBackDB.dbo.UserGoldSum3 where InsertDate="'.$InsertDate.'"';
	$rs2 = mssql_query($sql2,$conn);
	$result2 = mssql_fetch_assoc($rs2);
	$Num2 = $result2['count'];

	if($Num2==0){
		$sql3 = 'Insert into QPWebBackDB.dbo.UserGoldSum3 (t'.$hour.',InsertDate) values('.$Num.',"'.$InsertDate.'")';
	}else{
		$sql3 = 'Update QPWebBackDB.dbo.UserGoldSum3 set t'.$hour.'='.$Num.' where InsertDate="'.$InsertDate.'"';
	}
	mssql_query($sql3,$conn);
