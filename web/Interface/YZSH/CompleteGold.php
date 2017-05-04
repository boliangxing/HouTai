<?php 
require_once '../../Db/Db_config.php';
$rs = array();
    $sql = 'SELECT AddGold from QPAccountsDB.dbo.TaskList(NOLOCK) where Type = 8';
	$result = mssql_query($sql,$conn);
    if($row = mssql_fetch_assoc($result)){
		$rs['data']['Gold'] = $row['AddGold'];		
	}
	$rs['error']='0';
	$rs['error_msg']='';
    echo json_encode($rs);  


