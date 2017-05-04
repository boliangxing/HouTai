<?php
return array(
		'APP_DEBUG' => true,
		'DB_TYPE'   => 'mssql', // 数据库类型
		'DB_HOST'   => '192.168.33.10,11433', // 服务器地址
    	'DB_NAME'   => 'QPAccountsDB', // 数据库名
    	'DB_USER'   => 'jshHJKGf1234_ua', // 用户名
    	'DB_PWD'    => 'nahsx_a7dyt', // 密码
    	'DB_PORT'   => '', // 端口
    	'DB_PREFIX' => '', // 数据库表前缀 
		'DB_CONNECT_TYPE' => 'sqlsrv_connect',
		'DATA_CACHE_TYPE' => 'Memcache', //默认是file方式进行缓存的，修改为memcache
		'MEMCACHE_HOST'   =>  'tcp://127.0.0.1:11211',//memcache服务器地址和端口
		'DATA_CACHE_TIME' => '10',//过期的秒数
		'SESSION_EXPIRE'=>'10',
		'SESSION_OPTIONS'=>array(
		'expire'=>43200
		)
	//'DB_CONFIG2' => array(
		/*'DB_TYPE'                => 'pdo',
    	'DB_DSN'                 => 'sqlite:./Db/hs.db',
    	'DB_PREFIX'              => '',        // 数据库表前缀
    	'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    	'DB_FIELDS_CACHE'       => false       // 启用字段缓存*/
	//)
);

/*
'DB_HOST'   => '192.168.10.160,5433', // 服务器地址
    	'DB_NAME'   => 'QPAccountsDB', // 数据库名
    	'DB_USER'   => 'webgame', // 用户名
    	'DB_PWD'    => 'webgame5678#@!', // 密码
    	*/
?>