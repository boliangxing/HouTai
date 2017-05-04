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

$GLOBALS['ADMIN'] = array(
	'meti518'=>'Meti!!518$$|1',
	'jingjia007'=>'SEMjingjia007|2',
	'lizhuo'=>'123456|3',
	'fanshunan'=>'006572|4',
	'admin'=>'12345|5'
);


$GLOBALS['DB_ACCOUNTS'] = array(
	// 'DB_HOST'=>'192.168.33.10,11433',
	// 'DB_USER'=>'jshHJKGf1234_ua',
	// 'DB_PWD'=>'nahsx_a7dyt',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPAccountsDB'
);
$GLOBALS['DB_TREASURE'] = array(
	// 'DB_HOST'=>'192.168.33.10,11433',
	// 'DB_USER'=>'jshHJKGf1234_ua',
	// 'DB_PWD'=>'nahsx_a7dyt',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
$GLOBALS['DB_NEW'] = array(
	// 'DB_HOST'=>'192.168.33.10,11433',
	// 'DB_USER'=>'jshHJKGf1234_ua',
	// 'DB_PWD'=>'nahsx_a7dyt',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
$GLOBALS['DB_CX'] = array(
	// 'DB_HOST'=>'203.19.33.10,1103',
	// 'DB_USER'=>'aaaaaa',
	// 'DB_PWD'=>'aaaaaa',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
$GLOBALS['DB_KZ'] = array(
	// 'DB_HOST'=>'192.168.33.11,11433',
	// 'DB_USER'=>'ady_63gydu_9',
	// 'DB_PWD'=>'GYTg65_adg',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPControlDB'
);
$GLOBALS['DB_YX'] = array(
	// 'DB_HOST'=>'203.19.33.10,1433',
	// 'DB_USER'=>'aaaaaa',
	// 'DB_PWD'=>'aaaaaa',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
$GLOBALS['DB_RECORD_11'] = array(
	// 'DB_HOST'=>'192.168.33.11,11433',
	// 'DB_USER'=>'ady_63gydu_9',
	// 'DB_PWD'=>'GYTg65_adg',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
$GLOBALS['DB_RECORD_12'] = array(
	// 'DB_HOST'=>'192.168.33.12,11433',
	// 'DB_USER'=>'ady_63gydu_9',
	// 'DB_PWD'=>'GYTg65_adg',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
//3Dbuyu
$GLOBALS['DB_RECORD_9'] = array(
	// 'DB_HOST'=>'192.168.33.9,11433',
	// 'DB_USER'=>'ady_63gydu_9',
	// 'DB_PWD'=>'GYTg65_adg',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
//2Dbuyu
$GLOBALS['DB_RECORD_13'] = array(
	// 'DB_HOST'=>'192.168.33.13,11433',
	// 'DB_USER'=>'ady_63gydu_9',
	// 'DB_PWD'=>'GYTg65_adg',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);
//meirenyu
$GLOBALS['DB_RECORD_16'] = array(
	// 'DB_HOST'=>'192.168.33.16,11433',
	// 'DB_USER'=>'ady_63gydu_9',
	// 'DB_PWD'=>'GYTg65_adg',
	'DB_HOST'=>'localhost',
	'DB_USER'=>'sa',
	'DB_PWD'=>'1994Asd@',
	'DB_NAME'=>'QPTreasureDB'
);


date_default_timezone_set('Asia/Shanghai');

require 'ThinkPHP/ThinkPHP.php';
