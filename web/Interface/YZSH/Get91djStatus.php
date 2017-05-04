<?php 
require_once '../../Db/Db_config.php';
$return['error']=0;
/*
$sql='SELECT StatusValue from QPAccountsDB.dbo.SystemStatusInfo where StatusName="91open"';
$result = mssql_query($sql,$conn);
	if($rs = mssql_fetch_assoc($result)){
		$return['status'] = $rs['StatusValue']; //1：只显示点金  2：不限制
	}
	*/
$return['status']=1;
echo json_encode($return);

