<?php 
require_once '../../Db/Db_config.php';
$return['error']=1;
$return['url_one']='http://www.baidu.com';
$return['url_two']='http://www.qq.com';
echo json_encode($return);


