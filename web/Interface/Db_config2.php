<?php
date_default_timezone_set('Asia/Shanghai');
$Key = '3bde1c26e7';
$GLOBALS['DB_ACCOUNTS'] = array(
	'DB_HOST'=>'183.60.136.219',
	'DB_USER'=>'sa',
	'DB_PWD'=>'sycxwS!Q(72)#',
	'DB_NAME'=>'QPTreasureDB'
);
$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);