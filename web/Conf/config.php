<?php
return array(
		// 'APP_DEBUG' => true,
		// 'DB_TYPE'   => 'mssql', // 数据库类型
		// 'DB_HOST'=>'117.25.148.33,11433',
		// 'DB_USER'=>'iid33siN!',
		// 'DB_PWD'=>'HiJoKpL!@#qwe',
    // 	'DB_NAME'   => 'QPAccountsDB', // 数据库名
    // 	'DB_PORT'   => '', // 端口
    // 	'DB_PREFIX' => '', // 数据库表前缀
		// 'DB_CONNECT_TYPE' => 'sqlsrv_connect',
		// 'DATA_CACHE_TYPE' => 'Memcache', //默认是file方式进行缓存的，修改为memcache
		// 'MEMCACHE_HOST'   =>  'tcp://127.0.0.1:11211',//memcache服务器地址和端口
		// 'DATA_CACHE_TIME' => '10',//过期的秒数
		// 'SESSION_EXPIRE'=>'10',
		// 'SESSION_OPTIONS'=>array(
		// 'expire'=>43200
		// )

		'APP_DEBUG' => true,
		'DB_TYPE'   => 'mssql', // 数据库类型
		// 'DB_HOST'=>'119.147.144.149,11433',
		// 'DB_USER'=>'aaaaaa',
		// 'DB_PWD'=>'aaaaaa',
		'DB_HOST'=>'localhost',
		'DB_USER'=>'sa',
		'DB_PWD'=>'1994Asd@',
    	'DB_NAME'   => 'QPAccountsDB', // 数据库名
    	'DB_PORT'   => '', // 端口
    	'DB_PREFIX' => '', // 数据库表前缀
		'DB_CONNECT_TYPE' => 'sqlsrv_connect',

	'DATA_CACHE_TYPE' => 'file',
	'SESSION_AUTO_START'    => true,    // 是否自动开启Session


    //  'SHOW_PAGE_TRACE'=>true,
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
