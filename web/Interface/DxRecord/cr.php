<?php
error_reporting(0);
if(!isset($_GET['id']) || !isset($_GET['sign']) || !isset($_GET['port'])){
echo 1;
exit;
}

$UserID = intval($_GET['id']);
$Port = intval($_GET['port']);
$Type = intval($_GET['type']);
$key = 'j#dial!*hd';
$md5_str = strtoupper(md5($UserID.$Port.$key));
file_put_contents('aa.txt',$UserID.'---'.$Port.'---'.$Type);
if($md5_str!=strtoupper($_GET['sign'])){
echo 2;
exit;
}
$GLOBALS['DB_TREASURE'] = array(
	'DB_HOST'=>'192.168.10.100,11433',
	'DB_USER'=>'zs78zs321',
	'DB_PWD'=>'g!a@m#e$Z%S^78',
	'DB_NAME'=>'QPAccountsDB'
);

$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);  //php 5.2.17
mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
$procedure = mssql_init("PHP_InsertDxRecord",$conn);      
mssql_bind($procedure,"@UserID",$UserID,SQLINT4);
mssql_bind($procedure,"@Port",$Port,SQLINT4);
mssql_bind($procedure,"@Type",$Type,SQLINT4);
$resource = mssql_execute($procedure);   
mssql_free_statement($procedure); 
mssql_close($conn);
?>