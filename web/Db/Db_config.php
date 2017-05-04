<?php
date_default_timezone_set('Asia/Shanghai');
$Key = '3bde1c26e7';
$GLOBALS['DB_ACCOUNTS'] = array(
	'DB_HOST'=>'117.25.148.33,11433',
	'DB_USER'=>'iid33siN!',
	'DB_PWD'=>'HiJoKpL!@#qwe',
	'DB_NAME'=>'QPTreasureDB'
);
$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);