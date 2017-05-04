<?php
require_once("dxpay_config.php");	
    $rs = array();
    $sql = 'SELECT CardTypeID,CardName,CardPrice,CardGold,Describe FROM M_GlobalLivcard where PayKind=2';
	$result = mssql_query($sql,$conn);
    while($row = mssql_fetch_assoc($result)){
		$rs[] = $row;		
	}
    for($i=0;$i<count($rs);$i++){
    	$rs[$i]['CardName'] = iconv("GB2312","UTF-8",$rs[$i]['CardName']); 
    	$rs[$i]['Describe'] = iconv("GB2312","UTF-8",$rs[$i]['Describe']);				
    }
    echo json_encode($rs);   