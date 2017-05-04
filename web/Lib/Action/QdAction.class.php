<?php
class QdAction extends Action {
	// public function _initialize(){
  //   	if(!isset($_SESSION['zs78_admin2'])){
  //   	_href(WEB_ROOT."index.php/Login");
  //   	return false;
  //  		}
  //  	}
public function qdid(){

 $this->display('qdid');

}
public function qdidAdd(){

	$username=$_GET['username'];
	$qdid=$_GET['qdid'];
	$mssql = M();

	$sql = 'updateQPPlatformManagerDB.dbo.Base_Users set qudao="'.$qdid.'" where username="'.$username.'"';

	$mssql->query($sql);
	_back('添加成功');
}
}
