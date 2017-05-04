<?php
define('APP_DEBUG',true);

define('DEBUG',true);
//项目入口地址
define ( 'ROOT_PATH', dirname(__FILE__));

ini_set('memory_limit','32M');

//分页大小 
define ( 'PAGE_SIZE', 10 );
define ( 'PAGE_SIZE_2', 15 );
define ( 'PAGE_SIZE_3', 20 );
define ( 'PAGE_SIZE_5', 50 );

define ( 'KEY', 'asd123' );

$tmp = explode("index.php", $_SERVER['REQUEST_URI']);
define ( 'WEB_ROOT', $tmp[0]);
define ( 'PUBLIC_PATH', WEB_ROOT.'public/' );
define ( 'UPLOAD_PATH', WEB_ROOT.'public/uploads/' );
define ( 'IMAGE_PATH', '/Customsystem/');

//上传路径
define("UPDATE_PATH", 'D:\web\www\trunk\public\uploads\\');
//读取文件路径
define("FILE_PATH", 'D:\web\www\trunk\aaa.txt');

$GLOBALS['DB_ACCOUNTS'] = array(
	'DB_HOST'=>'192.168.33.10,11433',
	'DB_USER'=>'jshHJKGf1234_ua',
	'DB_PWD'=>'nahsx_a7dyt',
	'DB_NAME'=>'QPAccountsDB'
);

$GLOBALS['USERS'] = array(
	'zzlqpbu'=>'Zwzzlby518|1',
	'hlqpbulhj'=>'Zzlqplhj518|2002'
);


date_default_timezone_set('Asia/Shanghai');

require 'ThinkPHP/ThinkPHP.php';
