<?php
class Test2Model extends Model{
	
    protected $connection = array( 
		'dbms'=>'mssql',
 		'database'=>'QPAccountsDB',
 		'username'=>'sa',
 		'password'=>'Aa123456',
 		'hostname'=>'192.168.1.188,1433',
 		'hostport'=>''
);


	
	protected $tableName = "AccountsInfo";
	
}