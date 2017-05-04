<?php
require_once('Db/Db_11.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date("Y-m-d",strtotime("-1 day"));
	//$InsertDate = '2016-01-14';
	/*
	$sql3 = 'Insert into QPWebBackDB.dbo.GameWasteCount (G10,G19,G27,G28,G102,G104,G106,G108,G110,G114,G122,G140,G200,G210,G233,G308,G404,G2055,InsertDate) 
	values('.$G10.','.$G19.','.$G27.','.$G28.','.$G102.','.$G104.','.$G106.','.$G108.','.$G110.','.$G114.','.$G122.','.$G140.','.$G200.','.$G210.','.$G233.','.$G308.','.$G404.','.$G2055.',"'.$InsertDate.'")';
	mssql_query($sql3,$conn);
	print_r($row);
	*/
	//$InsertDate = date("Y-m-d");
	$result['G10']=0;
	$result['G19']=0;
	$result['G27']=0;
	$result['G28']=0;
	$result['G102']=0;
	$result['G104']=0;
	$result['G106']=0;
	$result['G108']=0;
	$result['G110']=0;
	$result['G114']=0;
	$result['G122']=0;
	$result['G140']=0;
	$result['G200']=0;
	$result['G210']=0;
	$result['G233']=0;
	$result['G308']=0;
	$result['G350']=0;
	$result['G404']=0;
	$result['G2060']=0;
	$result['G2070']=0;
	$result['G2075']=0;
	$result['G2080']=0;
		$sql = 'select KindID,sum(WasteSum) as WasteSum from QPTreasureDB.dbo.RecordDayWaste(nolock) where InsertTime="'.$InsertDate.'" group by KindID';
		$res = mssql_query($sql,$conn);
		while ($row = mssql_fetch_assoc($res)){
			$rs[]=$row;
		}
		foreach($rs as $k=>$v){
			$result['sum'] = $result['sum']+$rs[$k]['WasteSum'];
			$result['G'.$rs[$k]['KindID']] = $result['G'.$rs[$k]['KindID']]+$rs[$k]['WasteSum'];
		}
	//$total=$result['G10']+$result['G19']+$result['G27']+$result['G28']+$result['G102']+$result['G104']+$result['G106']+$result['G108']+$result['G110']+$result['G114']+$result['G122']+$result['G140']+$result['G200']+$result['G210']+$result['G233']+$result['G308']+$result['G404']+$result['G2060'];
	//echo $total;
	//exit;
		//print_r($result);
	$sql5 = 'select count(ID) as num from QPWebBackDB.dbo.GameWasteCount(nolock)  where InsertDate="'.$InsertDate.'"';
	$rs5 = mssql_query($sql5,$conn);
	$result5 = mssql_fetch_assoc($rs5);

	if($result5['num']==0){
		$sql3 = 'Insert into QPWebBackDB.dbo.GameWasteCount (G10,G19,G27,G28,G102,G104,G106,G108,G110,G114,G122,G140,G200,G210,G233,G308,G350,G404,G2055,InsertDate,G2070,G2075,G2080) 
	values('.$result['G10'].','.$result['G19'].','.$result['G27'].','.$result['G28'].','.$result['G102'].','.$result['G104'].','.$result['G106'].','.$result['G108'].','.$result['G110'].','.$result['G114'].','.$result['G122'].','.$result['G140'].','.$result['G200'].','.$result['G210'].','.$result['G233'].','.$result['G308'].','.$result['G350'].','.$result['G404'].','.$result['G2060'].',"'.$InsertDate.'",'.$result['G2070'].','.$result['G2075'].','.$result['G2080'].')';
	mssql_query($sql3,$conn);
	}
		
		
	
	
	
	
