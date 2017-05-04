<?php 
require_once '../Db_config.php';

    $rs = array();
    $sql = 'SELECT CardTypeID,CardName,CardPrice,CardGold,MemberOrder,Describe FROM QPTreasureDB.dbo.M_GlobalLivcard where PayKind = 5';
	$result = mssql_query($sql,$conn);
    while($row = mssql_fetch_assoc($result)){
		$rs[] = $row;		
	}
    for($i=0;$i<count($rs);$i++){
    	$rs[$i]['CardName'] = iconv("GB2312","UTF-8",$rs[$i]['CardName']); 
    	$rs[$i]['Describe'] = iconv("GB2312","UTF-8",$rs[$i]['Describe']);	
    	$rs[$i]['New'] = $rs[$i]['MemberOrder'];			
    }
    echo json_encode($rs);   

