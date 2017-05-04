<?php 
require_once '../Db_config.php';
date_default_timezone_set('Asia/Shanghai');

if(!$_GET['Type']){
	return false;
}
$Type=$_GET['Type'];
$sql = 'select count(DetailID) as num from QPAccountsDB.dbo.AppNotice where Type = '.$Type;
$result = mssql_query($sql,$conn);
if($rs = mssql_fetch_assoc($result)){
	if($rs['num'] == 0){
		echo 0;
	}else{
		echo 1;
	}
}
