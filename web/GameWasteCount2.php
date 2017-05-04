<?php
require_once('Db/Db_11.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d');
	$hour = date('H');
	if($hour<10){
		$hour = substr($hour,1);
	}
		$sql = 'select KindID,ServerID,WasteSum from QPTreasureDB.dbo.RecordDayWaste(nolock) where InsertTime="'.$InsertDate.'"';
		$res = mssql_query($sql,$conn);
		while ($row = mssql_fetch_assoc($res)){
			$rs[]=$row;
		}
		foreach($rs as $k=>$v){
			$total = $total+$rs[$k]['WasteSum'];
		}
	$sql2 = 'select count(ID) as count from QPWebBackDB.dbo.WasterCount2 where InsertDate="'.$InsertDate.'"';
	$rs2 = mssql_query($sql2,$conn);
	$result2 = mssql_fetch_assoc($rs2);
	$Num2 = $result2['count'];

	if($Num2==0){
		$sql3 = 'Insert into QPWebBackDB.dbo.WasterCount2 (t'.$hour.',InsertDate) values('.$total.',"'.$InsertDate.'")';
	}else{
		$sql3 = 'Update QPWebBackDB.dbo.WasterCount2 set t'.$hour.'='.$total.' where InsertDate="'.$InsertDate.'"';
	}
	mssql_query($sql3,$conn);