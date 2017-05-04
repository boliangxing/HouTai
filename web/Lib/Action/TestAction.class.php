<?php
class TestAction extends Action{
	
	function index(){
		$UserID = $_GET['UserID'];
    	if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
			/*
			if($_GET['h1']&&$_GET['h2']){
				$h1 = $_GET['h1'];
				$h2 = $_GET['h2'];
				if($date1==$date2){
					if($h1>$h2){
						$this->assign('h1',$h2);
						$this->assign('h2',$h1);
					}else{
						$this->assign('h1',$h1);
						$this->assign('h2',$h2);
					}
				}else{
					$this->assign('h1',$h1);
					$this->assign('h2',$h2);
				}			
			}else{
				$h1 = '0';
				$h2 ='24';
				$this->assign('h1',$h1);
				$this->assign('h2',$h2);
			}	
			*/
			if($date3>=$date4){
				$start_date = $date2.' 00:00:00';
				$end_date = $date1.' 23:59:59';
				$this->assign('start_date',$date2);
				$this->assign('end_date',$date1);
			}else{
				$start_date = $date1.' 00:00:00';
				$end_date = $date2.' 23:59:59';
				$this->assign('start_date',$date1);
				$this->assign('end_date',$date2);
			}
    	}else{
    		$end_date = date('Y-m-d H:i:s');    	
    		$start_date = date('Y-m-d').' 00:00:00';
			//$h1 = '0';
			//$h2 = '24';
    		$this->assign('start_date',date('Y-m-d'));
			$this->assign('end_date',date('Y-m-d'));
			//$this->assign('h1',$h1);
			//$this->assign('h2',$h2);
    		//$start_date='2012-12-01 00:00:00';
    	}
		//$h3 = strval($h1);
		//$h4 = strval($h2);
  		$pageSize = PAGE_SIZE_5;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		} 

		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']); 
		$rs = array();
		
		$procedure = mssql_init("PHP_YxRecordCount",$conn); 
		
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);		
		//mssql_bind($procedure,"@h1", $h3, SQLVARCHAR);
		//mssql_bind($procedure,"@h2", $h4, SQLVARCHAR);	
		$resource = mssql_execute($procedure);
    	if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
				//var_dump($row);
			$count = $row['yx_count'];
		}
		//echo $count.'</br>';
		mssql_free_statement($procedure); 		
		
		$procedure2 = mssql_init("PHP_UserYxList",$conn); 		
		mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
		//mssql_bind($procedure2,"@h1", $h3, SQLVARCHAR);
		//mssql_bind($procedure2,"@h2", $h4, SQLVARCHAR);	
		mssql_bind($procedure2,"@pageNo", $pageNo, SQLINT4); 
		mssql_bind($procedure2,"@pageSize", $pageSize, SQLINT4); 
		
		$resource2 = mssql_execute($procedure2);
		while($row2 = mssql_fetch_assoc($resource2)){
			$rs[] = $row2;
		}		
		mssql_free_statement($procedure2); 
		mssql_close($conn); 
			
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
    		$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['Score'] = number_format($rs[$i]['Score']); 
			$rs[$i]['TableID'] = $rs[$i]['TableID']+1;
			$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);			
		}
		$pageNum = ceil($count/$pageSize);
		
    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);    	
    	$this->display('user_yx');
		
	}
	
	public function aa(){
		$mssql = M();
		$sql = 'select top 10 t1.LeaveTime,t2.GameID,t2.NickName,t3.ServerName,t4.KindName from QPTreasureDB.dbo.RecordUserInout t1,QPAccountsDB.dbo.AccountsInfo t2,QPPlatformDB.dbo.GameRoomInfo t3,QPPlatformDB.dbo.GameKindItem t4 ';
		$sql.= 'where t1.LeaveTime<>"" and t1.UserID=t2.UserID and t1.KindID=t4.KindID and t1.ServerID=t3.ServerID order by LeaveTime desc';
		$rs = $mssql->query($sql);
		print_r($rs);
		
		for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1;
            $rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
            $rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
        }
		print_r($rs);
	}
	
}