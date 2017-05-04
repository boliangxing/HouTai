<?php
date_default_timezone_set('Asia/Shanghai');
$Key = 'By#Rg@KEY123';
$GLOBALS['DB_ACCOUNTS'] = array(
	'DB_HOST'=>'183.60.136.219',
	'DB_USER'=>'sa',
	'DB_PWD'=>'sycxwS!Q2(72)#',
	'DB_NAME'=>'QPAccountsDB'
);
$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);