<?php
/*
	source参数
		1	,非越狱机器, 返回Download不为空的记录
		2	,越狱机器,  返回 Yueyu 不为空的记录
	version参数
		传这个参数代表是新版本 version = 2
		不传默认为老版本 version = 1
*/
$source = $_GET['source'];
$version = 1;
if($_GET['version']){
	$version = $_GET['version'];
}
if(!$source)
{
	header('HTTP/1.1 403 Forbidden');
	die('参数错误');
}
/*
	当前app的链接标识
	如果传了这个参数,那么不返回该记录
*/

$currentAppLink = $_GET['applink'];

if (!class_exists('db_sqlite')){     require_once('../Db/pdo/sqlite.class.php'); }
$sqlite = new db_sqlite();
$sqlite->sqlite('../Db/hs.db'); 

$sql = '';
if($source == 1){
	$sql = "select id,Link,Download as download,Photo,m_photo,Yueyu,Name,Icon,m_Icon from iphone_rec where Version = ".$version." and Is_rec = 1 and Download <> '' ";
}elseif ($source == 2) {
	$sql = "select id,Link,Yueyu as download, Photo,m_photo,Name,Icon,m_Icon from iphone_rec where Version = ".$version." and Is_rec = 1 and Yueyu <> '' ";
	
}else{
	header('HTTP/1.1 403 Forbidden');
	die('参数错误');
}

if ($currentAppLink) {
	$sql .= " and Link<>'".$currentAppLink."'";
}

$sql .= ' order by Sort';

$rs = $sqlite->query($sql)->fetchAll();
echo json_encode($rs);