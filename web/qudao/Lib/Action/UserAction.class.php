<?php
// 本类由系统自动生成，仅供测试用途
if (!class_exists('db_sqlite')){     require_once(ROOT_PATH . '/Db/sqlite.class.php'); }
class UserAction extends Action {
	
	public function _initialize(){		
    	if(!isset($_SESSION['admin_a'])){
    		_href(WEB_ROOT."index.php/Login");
   		}
   		/*
		if($_SESSION['zs78_admin2']['role']==4){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   		}
   		*/
   	}
	
    public function index(){
		
		if(isset($_SESSION['admin_a'])){
			$type = $_SESSION['admin_a'][1];
		}else{
			//$type = 1111;
			_location('帐号名或密码错误',WEB_ROOT.'index.php/Login');
		}
		$sqlite = new db_sqlite();
		$sqlite->sqlite(ROOT_PATH . '/Db/record.db');
		$time_now=time();
		$sort='Insert_date DESC';
		
		$condition=array('NAME'=>$_SESSION['admin_a'][0],'TYPE'=>$type);
		$rs=$sqlite->fetch('record','Insert_date',$condition,$sort);
		if($time_now-$rs['Insert_date']<10){
			_location('访问过于频繁',WEB_ROOT.'index.php/Login');
			return;
		}	
		if(isset($_GET['date'])){
			$date = $_GET['date'];
		}else{
			$date = date('Y-m-d');
		}
		$start_date = $date.' 00:00:00';
		$end_date = $date.' 23:59:59';
    	$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']); 
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_UserQdInfo",$conn); 		
		mssql_bind($procedure,"@type", $type, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);		
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);	
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn); 
	
		if($rs[0]['charge_num']==0){
			$rs[0]['ARPU']=0;
		}else{
			$rs[0]['ARPU']=sprintf("%.2f",$rs[0]['charge_num']/$rs[0]['charge_user']);
		}

		$rs[0]['reg_num'] = number_format($rs[0]['reg_num']); 	
		$rs[0]['open_num'] = number_format($rs[0]['open_num']);
		$rs[0]['charge_num'] = number_format($rs[0]['charge_num']); 
		$rs[0]['charge_user'] = number_format($rs[0]['charge_user']); 
		$rs[0]['huoyue_num'] = number_format($rs[0]['huoyue_num']); 
		$rs[0]['lc_num'] = number_format($rs[0]['lc_num']); 

		$insert = array('NAME' => $_SESSION['admin_a'][0],'TYPE'=>$type,'Insert_date'=>$time_now);
    	$sqlite->insert('record', $insert);
		$this->assign('rs',$rs[0]);
		$this->assign('date',$date);
    	$this->display('index');
    }

	






	//查询ip地址
	function getIpPlace($ip){  		
    	require_once(ROOT_PATH.'/Db/IP/IpLocation.php');//加载类文件IpLocation.php  
    	$ipfile = ROOT_PATH.'/Db/IP/qqwry.dat';      //获取ip对应地区的信息文件  
    	$iplocation = new IpLocation($ipfile);  //new IpLocation($ipfile) $ipfile ip对应地区信息文件  
    	$ipresult = $iplocation->getlocation($ip); //根据ip地址获得地区 getlocation("ip地区")  
    	return $ipresult;  
	} 
	
	
}













