<?php
date_default_timezone_set('Asia/Shanghai');
$GLOBALS['DB_ACCOUNTS'] = array(
	'DB_HOST'=>'192.168.33.10,11433',
	'DB_USER'=>'jshHJKGf1234_ua',
	'DB_PWD'=>'nahsx_a7dyt',
	'DB_NAME'=>'QPTreasureDB'
);
$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);