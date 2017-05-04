<?php
require_once('Db/Db_config2.php'); 
date_default_timezone_set('Asia/Shanghai'); 
$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
	$InsertDate = date('Y-m-d');
	$Yesterday = date("Y-m-d",strtotime("-1 day"));
	$sql = 'select Username,TypeID,QdType,Bili,IsUsed from [QPAdminDB].[dbo].[QD_Users] where Fenghao=0';
	$res = mssql_query($sql,$conn);
	while ($row = mssql_fetch_assoc($res)){
		$rs[]=$row;
	}
	for($i=0;$i<count($rs);$i++){
		
		$procedure = mssql_init("TJ_QDCount",$conn); 
		mssql_bind($procedure,"@Date", $Yesterday, SQLVARCHAR);
		mssql_bind($procedure,"@QdType", $rs[$i]['QdType'], SQLINT4);
		mssql_bind($procedure,"@QdID", $rs[$i]['TypeID'], SQLINT4);		
		$resource = mssql_execute($procedure);
		
		echo $rs[0]['Username'];
	}
	mssql_free_statement($procedure);

	



	