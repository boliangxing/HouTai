<?php
class OnLineStreamInfoModel extends Model{
	protected $connection = array(
		'DB_TYPE'   => 'mssql', // 数据库类型
    	'DB_HOST'   => 'dong-pc', // 服务器地址
    	'DB_NAME'   => 'QPPlatformDB', // 数据库名
    	'DB_USER'   => 'sa', // 用户名
    	'DB_PWD'    => '123456', // 密码
    	'DB_PORT'   => '', // 端口
    	'DB_PREFIX' => '', // 数据库表前缀 
		'DB_CONNECT_TYPE' => 'sqlsrv_connect'	
	);
	
	protected $tableName = "OnLineStreamInfo";
	
	public function bb(){
		return $this->limit(10)->select();
	}
}