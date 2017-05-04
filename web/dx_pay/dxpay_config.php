<?php
$GLOBALS['DB_TREASURE'] = array(
	'DB_HOST'=>'192.168.0.188',
	'DB_USER'=>'sa',
	'DB_PWD'=>'123456qaz',
	'DB_NAME'=>'QPTreasureDB'
);

$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
?>