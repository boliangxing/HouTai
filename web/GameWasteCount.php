<?php
	$GLOBALS['DB_ACCOUNTS'] = array(
	'DB_HOST'=>'203.19.33.11,11433',
	'DB_USER'=>'ady_63gydu_9',
	'DB_PWD'=>'GYTg65_adg',
	'DB_NAME'=>'QPTreasureDB'
);
$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date("Y-m-d",strtotime("-1 day"));
	//$InsertDate = '2014-12-23';
	$start_date = $InsertDate.' 00:00:00';
	$end_date = $InsertDate.' 23:59:59';
	mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']); 
	$rs = array();
	$procedure = mssql_init("PHP_GameWasteCount",$conn); 
	mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
	mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);		
	$resource = mssql_execute($procedure);
	if($row = mssql_fetch_assoc($resource)){
			//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
		$G10 = $row['G10'];
		$G19 = $row['G19'];
		$G27 = $row['G27'];
		$G28 = $row['G28'];
		$G102 = $row['G102'];
		$G104 = $row['G104'];
		$G106 = $row['G106'];
		$G108 = $row['G108'];
		$G110 = $row['G110'];
		$G114 = $row['G114'];
		$G122 = $row['G122'];
		$G140 = $row['G140'];
		$G200 = $row['G200'];
		$G210 = $row['G210'];
		$G233 = $row['G233'];
		$G308 = $row['G308'];
		$G401 = $row['G401'];
		$G404 = $row['G404'];
		$G2055 = $row['G2055'];
	}	
	mssql_free_statement($procedure);
	//$total=$G10+$G19+$G27+$G28+$G102+$G104+$G106+$G108+$G110+$G114+$G122+$G140+$G200+$G210+$G233+$G308+$G401+$G404+$G2055;
	//echo $total;
	//exit;
	//$sql4 = 'select sum(Score) as total from QPFishDB.dbo.RecordDayWaste where InsertTime="'.$InsertDate.'"';
	//$rs4 = mssql_query($sql4,$conn);
	//$result4=mssql_fetch_assoc($rs4);
	//$G2055 = $result4['total']*(-1);
	$sql3 = 'Insert into QPWebBackDB.dbo.GameWasteCount (G10,G19,G27,G28,G102,G104,G106,G108,G110,G114,G122,G140,G200,G210,G233,G308,G404,G2055,InsertDate) 
	values('.$G10.','.$G19.','.$G27.','.$G28.','.$G102.','.$G104.','.$G106.','.$G108.','.$G110.','.$G114.','.$G122.','.$G140.','.$G200.','.$G210.','.$G233.','.$G308.','.$G404.','.$G2055.',"'.$InsertDate.'")';
	echo $sql3;
	exit;
	mssql_query($sql3,$conn);
	print_r($row);
