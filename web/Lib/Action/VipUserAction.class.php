<?php
// 本类由系统自动生成，仅供测试用途
if (!class_exists('db_sqlite')){     require_once(ROOT_PATH . '/Db/pdo/sqlite.class.php'); }
class VipUserAction extends Action {
	
	public function _initialize(){		
    	if(!isset($_SESSION['hs_admin'])){
    		header("Location: ".WEB_ROOT."index.php/Login");
   		}
   	}
	
    public function index(){
    	$this->display('index');
    }
    
    //详细信息
    public function userInfo(){
  	   	
    	$type = $_GET['type'];
    	$val = $_GET['info'];
    	$info = D('AccountsInfo');
    	if($type == 1){
    		$condition['GameID'] = $val;
    	}
    	if($type == 2){
    		$condition['NickName'] = $val;
    	}
    	if($_GET['UserID']){
    		$condition['UserID'] = $_GET['UserID'];
    	}
    	$rs_user = $info->where($condition)->select(); 
    	
    	//print_r($rs_user);
    	
		if($rs_user == null){
			_location("无此用户",WEB_ROOT."index.php/VipUser");
			return false;
		}
		$rs_user[0]['NickName'] = iconv("GB2312","UTF-8",$rs_user[0]['NickName']);
		
    	$UserID = $rs_user[0]['UserID'];
    	
    	$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
		$rs_gold = array();

		$procedure = mssql_init("php_user_info",$conn); 
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		$resource = mssql_execute($procedure);
		if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$rs_gold = $row;				
		}		
		mssql_free_statement($procedure); 
		mssql_close($conn); 
		
		$rs_gold['Sum'] = $rs_gold['Score']+$rs_gold['InsureScore'];	
		foreach ($rs_gold as $key=>$value){
			$rs_gold[$key] = number_format($rs_gold[$key]);
		}    	    
		
		$game_room = $this->game_room($UserID);
		$search_rs = $this->getResults($rs_user);
		

		$this->assign('search_rs',$search_rs);
		$this->assign('game_room',$game_room);
		$this->assign('rs_user',$rs_user[0]);
		$this->assign('rs_gold',$rs_gold);
    	$this->display('user_info');   	
    	
    }
    
    //正在游戏的房间
    public function game_room($UserID){
    	$mssql = M();		
		$sql = 'select t1.KindID,t2.ServerName from QPTreasureDB.dbo.GameScoreLocker(NOLOCK) t1 left join QPPlatformDB.dbo.GameRoomInfo(NOLOCK) t2 on t1.ServerID=t2.ServerID where t1.UserID ='.$UserID;
		$rs = $mssql->query($sql);
		$rs[0]['ServerName'] = iconv("GB2312","UTF-8",$rs[0]['ServerName']);
		$rs[0]['GameName'] = $this->getGameName($rs[0]['KindID']);
		return $rs[0];
    }
    
    //根据ip和机器码获得结果数及所有金币数
    public function getResults($rs_user){
    	$rs = array();
    	$RegisterIP = $rs_user[0]['RegisterIP'];
    	$RegisterMachine = $rs_user[0]['RegisterMachine'];
    	$LastLogonIP = $rs_user[0]['LastLogonIP'];
    	$LastLogonMachine = $rs_user[0]['LastLogonMachine'];
    	
    	$mssql = M();
    	$sql1 = 'select count(t1.UserID) as num,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.RegisterIP =\''.$RegisterIP.'\'';
		$rs1 = $mssql->query($sql1);
		
		$sql2 = 'select count(t1.UserID) as num,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.RegisterMachine =\''.$RegisterMachine.'\'';
		$rs2 = $mssql->query($sql2);
		
		$sql3 = 'select count(t1.UserID) as num,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.LastLogonIP =\''.$LastLogonIP.'\'';
		$rs3 = $mssql->query($sql3);
		
		$sql4 = 'select count(t1.UserID) as num,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.LastLogonMachine =\''.$LastLogonMachine.'\'';
		$rs4 = $mssql->query($sql4);

		$rs_gold[$key] = number_format($rs_gold[$key]);
		
		$rs['RegisterIP_count'] = $rs1[0]['num'];
		$rs['RegisterIP_sum'] = number_format($rs1[0]['gold_sum']);
		$rs['RegisterMachine_count'] = $rs2[0]['num'];
		$rs['RegisterMachine_sum'] = number_format($rs2[0]['gold_sum']);
		$rs['LastLogonIP_count'] = $rs3[0]['num'];
		$rs['LastLogonIP_sum'] = number_format($rs3[0]['gold_sum']);
		$rs['LastLogonMachine_count'] = $rs4[0]['num'];
		$rs['LastLogonMachine_sum'] = number_format($rs4[0]['gold_sum']);
		
		return $rs;
    	
    }
    
    //转账记录
    public function zz(){   	
    	$mssql = M();
    	$UserID = $_GET['UserID'];
    	if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
			if($date3>=$date4){
				$start_date = $date2.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
				$this->assign('start_date',$date2);
				$this->assign('end_date',$date1);
			}else{
				$start_date = $date1.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
				$this->assign('start_date',$date1);
				$this->assign('end_date',$date2);
			}
    	}else{
    		$end_date = date('Y-m-d H:i:s');    	
    		$start_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d'))-7*3600*24);
    	}   	   	
  		$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		} 
		
    	$sql1 = 'select count(RecordID) as num from QPTreasureDB.dbo.RecordInsure(NOLOCK) WHERE (SourceUserID ='.$UserID.' or TargetUserID ='.$UserID.') AND TradeType = 3 AND CollectDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$rs1 = $mssql->query($sql1);		
		$count = $rs1[0]['num'];
		
    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}
    	
    	$sql2 = 'SELECT RecordID,SourceUserID,SourceGold,SourceBank,TargetUserID,SwapScore,TradeType,CollectDate,NickName1,NickName2,GameID1,GameID2 FROM (SELECT TOP ('.$num.') RecordID,SourceUserID,SourceGold,SourceBank,TargetUserID,SwapScore,TradeType,CollectDate,NickName1,NickName2,GameID1,GameID2 FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.RecordID,t1.SourceUserID,t1.SourceGold,t1.SourceBank,t1.TargetUserID,t1.SwapScore,t1.TradeType,t2.GameID as GameID1,t3.GameID as GameID2,t2.NickName as NickName1,t3.NickName as NickName2,CONVERT(varchar,t1.CollectDate,120) as CollectDate ';
    	$sql2.= 'FROM QPTreasureDB.dbo.RecordInsure(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.SourceUserID = t2.UserID left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3 on t1.TargetUserID = t3.UserID ';
    	$sql2.= 'WHERE (t1.SourceUserID ='.$UserID.' or t1.TargetUserID ='.$UserID.') AND t1.TradeType = 3 AND t1.CollectDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) order by CollectDate desc) t4 order by CollectDate asc) t5 order by CollectDate desc';
		$rs2 = $mssql->query($sql2);

    	for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$rs2[$i]['NickName1'] = iconv("GB2312","UTF-8",$rs2[$i]['NickName1']);
			$rs2[$i]['NickName2'] = iconv("GB2312","UTF-8",$rs2[$i]['NickName2']);
			$rs2[$i]['SwapScore'] = number_format($rs2[$i]['SwapScore']); 
		}
		$pageNum = ceil($count/$pageSize);
		
    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs2);
    	$this->display('user_zz');
    }
    
	//存取记录
    public function cq(){
    	$mssql = M();
    	$UserID = $_GET['UserID'];
    	if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
			if($date3>=$date4){
				$start_date = $date2.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
				$this->assign('start_date',$date2);
				$this->assign('end_date',$date1);
			}else{
				$start_date = $date1.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
				$this->assign('start_date',$date1);
				$this->assign('end_date',$date2);
			}
    	}else{
    		$end_date = date('Y-m-d H:i:s');    	
    		$start_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d'))-7*3600*24);
    	}	
  		$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		} 
		
		$sql1 = 'select count(RecordID) as num from QPTreasureDB.dbo.RecordInsure(NOLOCK) WHERE SourceUserID ='.$UserID.' AND TradeType != 3 AND CollectDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$rs1 = $mssql->query($sql1);		
		$count = $rs1[0]['num'];
    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}
    	
    	$sql2 = 'SELECT RecordID,SourceUserID,SourceGold,SourceBank,SwapScore,TradeType,CollectDate FROM (SELECT TOP ('.$num.') RecordID,SourceUserID,SourceGold,SourceBank,SwapScore,TradeType,CollectDate FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') RecordID,SourceUserID,SourceGold,SourceBank,SwapScore,TradeType,CONVERT(varchar,CollectDate,120) as CollectDate ';
    	$sql2.= 'FROM QPTreasureDB.dbo.RecordInsure(NOLOCK) WHERE SourceUserID ='.$UserID.' AND TradeType != 3 AND CollectDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) order by CollectDate desc) t1 order by CollectDate asc) t2 order by CollectDate desc';
		$rs2 = $mssql->query($sql2);

    	for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$rs2[$i]['sum'] = $rs[$i]['SourceGold']+$rs2[$i]['SourceBank'];
			$rs2[$i]['sum'] = number_format($rs2[$i]['sum']); 
			$rs2[$i]['SwapScore'] = number_format($rs2[$i]['SwapScore']); 
		}
		$pageNum = ceil($count/$pageSize);

		
		
		/*$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
		$rs = array();

		$procedure = mssql_init("cq_record_list",$conn); 
		mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4); 
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4); 
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				$rs[] = $row;
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn); 	
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$rs[$i]['sum'] = $rs[$i]['SourceGold']+$rs[$i]['SourceBank'];
			$rs[$i]['sum'] = number_format($rs[$i]['sum']); 
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']); 
		}

		$pageNum = ceil($count['cq_count']/$pageSize);*/
		
    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs2);
    	$this->display('user_cq');
    }
    
    //充值记录
    public function recharge(){
    	$UserID = $_GET['UserID'];
    	$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		} 
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
		$rs = array();

		$procedure = mssql_init("php_user_recharge_list",$conn); 
		mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4); 
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4); 
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				$rs[] = $row;
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);
    	$this->display('user_recharge');
    }
    
    //转账存取游戏记录条数
    public function zz_record_count($UserID,$start_date,$end_date){
    	$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
		$procedure = mssql_init("zz_record_count",$conn); 
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				$result['zz_count'] = $row['zz_count'];
				$result['cq_count'] = $row['cq_count'];
				$result['yx_count'] = $row['yx_count'];
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn); 
		
		return $result;
    }
    
    //游戏记录
    public function yx(){
    	$UserID = $_GET['UserID'];
    	if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
			if($date3>=$date4){
				$start_date = $date2.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
				$this->assign('start_date',$date2);
				$this->assign('end_date',$date1);
			}else{
				$start_date = $date1.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
				$this->assign('start_date',$date1);
				$this->assign('end_date',$date2);
			}
    	}else{
    		$end_date = date('Y-m-d H:i:s');    	
    		$start_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d'))-7*3600*24);
    	}	
  		$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		} 
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
		$rs = array();

		$procedure = mssql_init("php_game_record_list",$conn); 
		mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4); 
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4); 
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
				$rs[] = $row;
				
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn); 
			
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['game'] = $this->getGameName($rs[$i]['KindID']);
    		//$rs[$i]['room'] = $result[$i]['Accounts'] = iconv("GB2312","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$rs[$i]['Score'] = number_format($rs[$i]['Score']); 
			$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);			
		}
		$count = $this->zz_record_count($UserID, $start_date, $end_date);
		$pageNum = ceil($count['yx_count']/$pageSize);
		
    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);    	
    	$this->display('user_yx');
    }
    
    //详细游戏记录
    public function getGameList($DrawID){
    	$mssql = M();
    	$sql = 'SELECT t1.DrawID,t1.UserID,t1.Score,t1.PlayTimeCount,t1.Revenue,t1.InsertTime,t2.NickName FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.DrawID ='.$DrawID;
    	$result = $mssql->query($sql);
    	for($i=0;$i<count($result);$i++){
    		$result[$i]['NickName'] = iconv("GB2312","UTF-8",$result[$i]['NickName']);		
		}
    	return $result;
    	
    	
    }
    
    //用户金币排行
    public function gold_rank(){
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		} 
    	$pageSize = PAGE_SIZE_2;
    	
    	if($_GET['s_type']){
    		$type = $_GET['s_type'];
    	}else{
    		$type = 3;
    	}
    	
    	if($_GET['s_type']){
    		$num = $_GET['num'];
    	}else{
    		$num = 15;
    	}
    	    	
		$user = D('AccountsInfo');
		$sql = 'select count(UserID) as num from AccountsInfo where IsAndroid != 1';
		$rs = $user->query($sql);
		$count = $num>=$rs[0]['num'] ? $rs[0]['num']:$num;
		$pageNum = ceil($num/$pageSize)>=ceil($rs[0]['num']/$pageSize) ? ceil($rs[0]['num']/$pageSize) : ceil($num/$pageSize);

		$result = array();
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
		$procedure = mssql_init("php_user_gold_rank",$conn); 
		mssql_bind($procedure,"@type", $type, SQLINT4);
		mssql_bind($procedure,"@count", $count, SQLINT4);
		mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4);
		mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				$result[] = $row;
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn); 
		//print_r($result);
    	for($i=0;$i<count($result);$i++){
			$result[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$result[$i]['Score'] = number_format($result[$i]['Score']); 
			$result[$i]['InsureScore'] = number_format($result[$i]['InsureScore']);
			$result[$i]['gold_sum'] = number_format($result[$i]['gold_sum']);
			$result[$i]['Accounts'] = iconv("GB2312","UTF-8",$result[$i]['Accounts']);
			$result[$i]['NickName'] = iconv("GB2312","UTF-8",$result[$i]['NickName']);
			if($this->check_vip($result[$i]['GameID'])==1){				
				$result[$i]['NickName'] = 'vip-'.$result[$i]['NickName'];
			}
		}
		$goldSum = $this->getGoldSum($num,$type);
		$this->assign('type',$type);
		$this->assign('count',$count);
		$this->assign('goldSum',$goldSum);
		$this->assign('result',$result);
		$this->assign('pageNum',$pageNum);
    	
    	$this->display('gold_rank');
    }
    
    //金币排行金币总额
    public function getGoldSum($num,$type){
    	$mssql = M();
    	if($type == 1){
    		$sql = 'select SUM(Score) as Score,SUM(InsureScore) as InsureScore,SUM(gold_sum) as gold_sum from (select top ('.$num.') t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.IsAndroid = 0 order by Score desc) t3';
    	}
    	if($type == 2){
    		$sql = 'select SUM(Score) as Score,SUM(InsureScore) as InsureScore,SUM(gold_sum) as gold_sum from (select top ('.$num.') t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.IsAndroid = 0 order by InsureScore desc) t3';
    	}
    	if($type == 3){
    		$sql = 'select SUM(Score) as Score,SUM(InsureScore) as InsureScore,SUM(gold_sum) as gold_sum from (select top ('.$num.') t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.IsAndroid = 0 order by gold_sum desc) t3';
    	}    	
		//$sql = 'select SUM(Score) as Score,SUM(InsureScore) as InsureScore,SUM(gold_sum) as gold_sum from (select top ('.$num.') t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.IsAndroid = 0 order by gold_sum desc) t3';
		$result = $mssql->query($sql);
		$result[0]['Score'] = number_format($result[0]['Score']);
		$result[0]['InsureScore'] = number_format($result[0]['InsureScore']);
		$result[0]['gold_sum'] = number_format($result[0]['gold_sum']);
		return $result[0];
    }
    
    //获取游戏名称
    public function getGameName($KindID){
    	
    	$mssql = M();
    	$sql = 'SELECT t1.GameName as game,t1.GameID,t2.KindID from QPPlatformDB.dbo.GameGameItem(NOLOCK) t1 left join QPPlatformDB.dbo.GameKindItem(NOLOCK) t2 on t1.GameID = t2.GameID WHERE t2.KindID = '.$KindID;
    	$rs = $mssql->query($sql);
    	$rs[0]['game'] = iconv("GB2312","UTF-8",$rs[0]['game']);
		return $rs[0]['game'];
    }
    
    //ip查询
    public function ip(){
    	$this->display('ip_search');
    }
    
	//ip搜索
    public function ip_search(){
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		} 
		$UserID = $_GET['UserID'];
		$user = D('AccountsInfo');
		$user_info = $user->where('UserID ='.$UserID)->find();
		$this->assign('user_info',$user_info);
		
				
    	$pageSize = PAGE_SIZE_2;
    	$type = $_GET['type'];
    	$con = $_GET['con'];
    	$mssql = M();
    	if($type == 1){  
			$sql1 = 'select count(t1.UserID) as num,sum(t2.Score) as Score,sum(t2.InsureScore) as InsureScore,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.RegisterIP =\''.$con.'\'';
			$rs = $mssql->query($sql1);
			
			$count = $rs[0]['num'];
			//print_r($rs);
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}    		
			$sql = 'select UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate from (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.RegisterIP =\''.$con.'\' order by RegisterDate desc) t4 order by  RegisterDate  asc) t5 order by  RegisterDate desc ';			
    	}
    	if($type == 2){
    		$sql1 = 'select count(t1.UserID) as num,sum(t2.Score) as Score,sum(t2.InsureScore) as InsureScore,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.RegisterMachine =\''.$con.'\'';
			$rs = $mssql->query($sql1);
			$count = $rs[0]['num'];
			//print_r($rs);
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}    		
			$sql = 'select UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate from (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.RegisterMachine =\''.$con.'\' order by RegisterDate desc) t4 order by  RegisterDate  asc) t5 order by  RegisterDate desc ';
    	}
    	if($type == 3){
    		$sql1 = 'select count(t1.UserID) as num,sum(t2.Score) as Score,sum(t2.InsureScore) as InsureScore,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.LastLogonIP =\''.$con.'\'';
			$rs = $mssql->query($sql1);
			$count = $rs[0]['num'];
			//print_r($rs);
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}    		
			$sql = 'select UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate from (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.LastLogonIP =\''.$con.'\' order by RegisterDate desc) t4 order by  RegisterDate  asc) t5 order by  RegisterDate desc ';
    	}
    	if($type == 4){
    		$sql1 = 'select count(t1.UserID) as num,sum(t2.Score) as Score,sum(t2.InsureScore) as InsureScore,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.LastLogonMachine =\''.$con.'\'';
			$rs = $mssql->query($sql1);
			$count = $rs[0]['num'];
			//print_r($rs);
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}    		
			$sql = 'select UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate from (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,RegisterDate,LastLogonDate ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.LastLogonMachine =\''.$con.'\' order by RegisterDate desc) t4 order by  RegisterDate  asc) t5 order by  RegisterDate desc ';
    	}
    	
   	 	$result = $mssql->query($sql);
   	 	$rs[0]['Score'] = number_format($rs[0]['Score']);
		$rs[0]['InsureScore'] = number_format($rs[0]['InsureScore']);
		$rs[0]['gold_sum'] = number_format($rs[0]['gold_sum']);
		for($i=0;$i<count($result);$i++){
			$result[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$result[$i]['Score'] = number_format($result[$i]['Score']); 
			$result[$i]['InsureScore'] = number_format($result[$i]['InsureScore']);
			$result[$i]['gold_sum'] = number_format($result[$i]['gold_sum']);
			$result[$i]['Accounts'] = iconv("GB2312","UTF-8",$result[$i]['Accounts']);
			$result[$i]['NickName'] = iconv("GB2312","UTF-8",$result[$i]['NickName']);
		}
		$pageNum = ceil($count/$pageSize);
		
		$this->assign('con',$con);
		$this->assign('type',$type);
    	$this->assign('pageNum',$pageNum);
    	$this->assign('rs',$rs);
    	$this->assign('result',$result);
    	$this->display('ip_result');
    }
    
	
	
    //获取用户信息
    public function getInfoByUserID($UserID){
    	$mssql = M();
    	$sql = 'select UserID,GameID,Accounts,NickName from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where UserID = '.$UserID;
    	$result = $mssql->query($sql);
    	
    	$result[0]['Accounts'] = iconv("GB2312","UTF-8",$result[0]['Accounts']);
		$result[0]['NickName'] = iconv("GB2312","UTF-8",$result[0]['NickName']);
    	   	
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql2 = 'select count(UserID) as num from vip_member where UserID = '.$UserID;
    	$rs2 = $sqlite->query($sql2)->fetchAll();
    	if($rs2[0]['num']!=0){
    		$result[0]['NickName'] = 'vip-'.$result[0]['NickName'];
    	}    	
    	return $result[0];
    }
    
	//获取用户信息
    public function getInfoByGameID($GameID){
    	$mssql = M();
    	$sql = 'select UserID,GameID,Accounts,NickName from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID = '.$GameID;
    	$result = $mssql->query($sql);
    	$result[0]['Accounts'] = iconv("GB2312","UTF-8",$result[0]['Accounts']);
		$result[0]['NickName'] = iconv("GB2312","UTF-8",$result[0]['NickName']);
    	return $result[0];
    }   
    
	public function tel_re(){
    	$mssql = M();
    	
    	//$UserID = $_GET['UserID'];
    	if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
			if($date3>=$date4){
				$start_date = $date2.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
				$this->assign('start_date',$date2);
				$this->assign('end_date',$date1);
			}else{
				$start_date = $date1.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
				$this->assign('start_date',$date1);
				$this->assign('end_date',$date2);
			}
    	}else{
    		$end_date = date('Y-m-d H:i:s');    	
    		$start_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d'))-7*3600*24);
    	}	
  		$pageSize = PAGE_SIZE;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		
		$encodeYK = iconv('utf-8','gb2312','游客');

		
    	
		$sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where (RegisterMobile != "" OR (NickName LIKE "'.$encodeYK.'%" and Accounts LIKE "v%")) AND IsLockMobile = 0 AND RegisterDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$rs1 = $mssql->query($sql1);		
		$count = $rs1[0]['num'];
    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}
    	
    	$sql2 = 'SELECT UserID,GameID,Accounts,NickName,LastLogonMobile,RegisterMobile,RegisterDate,RegisterMachine FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,LastLogonMobile,RegisterMobile,RegisterDate,RegisterMachine FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') UserID,GameID,Accounts,NickName,LastLogonMobile,RegisterMobile,CONVERT(varchar,RegisterDate,120) as RegisterDate,RegisterMachine ';
    	$sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) WHERE (RegisterMobile != "" OR (NickName LIKE "'.$encodeYK.'%" and Accounts LIKE "v%")) AND IsLockMobile = 0 AND RegisterDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) order by RegisterDate desc) t1 order by RegisterDate asc) t2 order by RegisterDate desc';
		$rs2 = $mssql->query($sql2);
		

    	for($i=0;$i<count($rs2);$i++){
    		$rs2[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
    		$rs2[$i]['Accounts'] = iconv("GB2312","UTF-8",$rs2[$i]['Accounts']);
    		$rs2[$i]['NickName'] = iconv("GB2312","UTF-8",$rs2[$i]['NickName']);
    		$rs2[$i]['num'] = $this->getTelRe($rs2[$i]['RegisterMachine']);

		}
		$pageNum = ceil($count/$pageSize);
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs2);    	
    	$this->display('tel_re');   	
    	
    }
    
	//手机注册账号的注册数
	public function getTelRe($RegisterMachine){
		$mssql = M();
		$sql = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo where IsLockMobile = 0 AND RegisterMachine ="'.$RegisterMachine.'"';
		$rs = $mssql->query($sql);		
		return $rs[0]['num'];	
	}
	
	//获取该用户输赢金币数
	public function getUserScore($UserID){
		$return = array();
		$mssql = M();		
		$sql2 = 'select sum(Score) as win from QPTreasureDB.dbo.RecordDrawScore(NOLOCK) where UserID ='.$UserID.' AND Score>0';
		$rs2 = $mssql->query($sql2);
		$return['win'] = $rs2[0]['win'];
		
		$sql3 = 'select sum(Score) as lose from QPTreasureDB.dbo.RecordDrawScore(NOLOCK) where UserID ='.$UserID.' AND Score<0';
		$rs3 = $mssql->query($sql3);
		$return['lose'] = $rs3[0]['lose'];
		
		$return['zong'] = $return['win']+$return['lose'];
		return $return;
	}
    
    
    //手机注册用户详细信息
    public function tel_re_info(){
    	$RegisterMachine = $_GET['RegisterMachine'];
    	$mssql = M();
		$sql = 'select UserID,GameID,Accounts,NickName,RegisterMobile,LastLogonMobile,CONVERT(varchar,RegisterDate,120) as RegisterDate,RegisterMachine from QPAccountsDB.dbo.AccountsInfo where RegisterMachine ="'.$RegisterMachine.'" order by RegisterDate desc';
		$rs = $mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
    		$rs[$i]['Accounts'] = iconv("GB2312","UTF-8",$rs[$i]['Accounts']);
    		$rs[$i]['NickName'] = iconv("GB2312","UTF-8",$rs[$i]['NickName']);  		
    		$rs[$i]['wl'] = $this->getUserScore($rs[$i]['UserID']);
		}		
		$this->assign('result',$rs);
		$this->display('tel_re_info');
    	
    }

}













