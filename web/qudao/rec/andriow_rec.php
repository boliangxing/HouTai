<?php
if (!class_exists('db_sqlite')){     require_once('../Db/pdo/sqlite.class.php'); }
$sqlite = new db_sqlite();
$sqlite->sqlite('../Db/hs.db'); 

if(!$_GET['E_name']){
	echo 0;
	return;
}
$E_name = $_GET['E_name'];
$sql = "select id,Link,Photo,m_photo,Name,Bag_Name,E_name from andriow_rec where Is_rec = 1 and E_name != '".$E_name."' order by Sort";

$rs = $sqlite->query($sql)->fetchAll();
echo json_encode($rs);