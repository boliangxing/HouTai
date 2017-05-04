<?php
if (!class_exists('db_sqlite')){     require_once('../Db/pdo/sqlite.class.php'); }
$sqlite = new db_sqlite();
$sqlite->sqlite('../Db/hs.db'); 
if(!$_GET['Sort_id'] || !$_GET['Platform_id']){
	echo 0;
	return;
}
$Sort_id = $_GET['Sort_id'];
$Platform_id = $_GET['Platform_id'];

$sql = 'select id,Sort_name,Sort_id,Version_name,Version_no,Platform_name,Platform_id,Download,Describe from andriow_pla where Sort_id="'.$Sort_id.'" and Platform_id="'.$Platform_id.'"';

$rs = $sqlite->query($sql)->fetchAll();
if(count($rs)>0){
	echo json_encode($rs[0]);
}else{
	echo 0;
}