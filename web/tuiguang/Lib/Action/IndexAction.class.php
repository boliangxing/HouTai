<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends BaseAction {
    public function index(){
    	header("Location: ".WEB_ROOT."index.php/User/jiechi");

    }

	//管理员操作
	public function manage(){
		if($_SESSION['5678_admin']['role'] != 1){
   	 	 _location("没有权限",WEB_ROOT.'index.php');
   		}
		$mssql = M();
        $sql = 'select UserID,Username,RoleID,Nullity from QPPlatformManagerDB.dbo.Base_Users';
        $rs = $mssql->query($sql);
        $this->assign('result',$rs);

		$this->display('manage');
	}

    //管理员添加
    public function addManage(){
    	$username = $_GET['username'];
    	$password = md5($_GET['password']);
    	$role = $_GET['role'];
    	if(strlen($username)<6 || strlen($_GET['password'])<6){
    		_location('请输入6位以上的用户名和密码',WEB_ROOT.'index.php/Index/manage');
    		return false;
    	}
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$arr = array('username' => $username,'password'=>$password,'role'=>$role);
    	//print_r($arr);
    	$sqlite->insert('admin', $arr);
    	header("Location: ".WEB_ROOT."index.php/Index/manage");
    }

    //管理员删除
    public function delManage(){
    	$id = $_GET['id'];
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$condition = array('id'=>$id);
    	$sqlite->delete('admin', $condition);
    	header("Location: ".WEB_ROOT."index.php/Index/manage");
    }

    //管理员修改登录密码
    public function change_pwd(){
    	$user = $_SESSION['5678_admin']['username'];
    	$pwd = md5($_POST['pwd']);
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$condition = array('username'=>$user);
    	$arr = array('password'=>$pwd);
    	$sqlite->update('admin', $arr, $condition);
    	_location('修改成功',WEB_ROOT.'index.php/Index/manage');
    }


	//excel导出方法
	function exportexcel($data=array(),$title=array(),$filename='report'){
     	header("Content-type:application/octet-stream");
     	header("Accept-Ranges:bytes");
     	header("Content-type:application/vnd.ms-excel");
     	header("Content-Disposition:attachment;filename=".$filename.".xls");
     	header("Pragma: no-cache");
    	header("Expires: 0");
     	//导出xls 开始
     	if (!empty($title)){
         	foreach ($title as $k => $v) {
            	$title[$k]=iconv("UTF-8", "GBK",$v);
         	}
         	$title= implode("\t", $title);
         	echo "$title\n";
     	}
     	if (!empty($data)){
        	 foreach($data as $key=>$val){
            	 foreach ($val as $ck => $cv) {
                 	$data[$key][$ck]=iconv("UTF-8", "GBK", $cv);
             	}
            	 $data[$key]=implode("\t", $data[$key]);

         	}
        	 echo implode("\n",$data);
     	}
	}


	//获取用户信息
    public function getInfoByUserID($UserID){
    	$mssql = M();
    	$sql = 'select UserID,GameID,Accounts,NickName from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where UserID = '.$UserID;
    	$result = $mssql->query($sql);
    	$result[0]['Accounts'] = iconv("GBK","UTF-8",$result[0]['Accounts']);
		$result[0]['NickName'] = iconv("GBK","UTF-8",$result[0]['NickName']);
    	return $result[0];
    }

    //vip五子棋记录
    public function vip_wzq_record(){
    	if($_SESSION['5678_admin']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$UserID = $_GET['UserID'];
		$s_date = $_GET['s_date'];
		$start_date = $s_date.' 00:00:00';
		$end_date = date('Y-m-d H:i:s',strtotime($start_date)+3600*24-1);
		//$start_date = '2013-01-01 00:00:00';
		//$end_date = '2014-01-01 00:00:00';
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$pageSize = PAGE_SIZE_2;

		$mssql = M();

		$ids = $this->getVipIds2();

    	$sql2 = 'SELECT count(DrawID_1) as zr_count from (SELECT t1.DrawID as DrawID_1,t2.DrawID as DrawID_2,t1.UserID as UserID_1,t2.UserID as UserID_2,t1.Score as Score,CONVERT(varchar,t1.InsertTime,120) as InsertTime ';
		$sql2.= 'from QPTreasureDB.dbo.RecordDrawScore t1 left join QPTreasureDB.dbo.RecordDrawScore t2 on t1.DrawID = t2.DrawID where t1.UserID <> t2.UserID and t1.UserID='.$UserID.' and t2.UserID not in ('.$ids.') and t1.Score <> 0) t3 ';
		$sql2.= 'left join QPTreasureDB.dbo.RecordDrawInfo t4 on t3.DrawID_1 = t4.DrawID where t4.KindID = 401 and t3.InsertTime between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$rs2 = $mssql->query($sql2);
		$count = $rs2[0]['zr_count'];


    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}

		$sql = 'select UserID_1,UserID_2,Score,InsertTime_1 from (SELECT TOP ('.$num.') UserID_1,UserID_2,Score,InsertTime_1 ';
		$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') UserID_1,UserID_2,Score,InsertTime_1 ';
		$sql.= 'from (SELECT t1.DrawID as DrawID_1,t2.DrawID as DrawID_2,t1.UserID as UserID_1,t2.UserID as UserID_2,t1.Score as Score,CONVERT(varchar,t1.InsertTime,120) as InsertTime_1 ';
		$sql.= 'from QPTreasureDB.dbo.RecordDrawScore t1 left join QPTreasureDB.dbo.RecordDrawScore t2 on t1.DrawID = t2.DrawID where t1.UserID != t2.UserID and t1.UserID='.$UserID.' and t2.UserID not in ('.$ids.') and t1.Score <> 0) t3 ';
		$sql.= 'left join QPTreasureDB.dbo.RecordDrawInfo t4 on t3.DrawID_1 = t4.DrawID where t4.KindID = 401 and t3.InsertTime_1 between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) order by InsertTime_1 desc) t5 order by InsertTime_1  asc) t6 order by InsertTime_1 desc';
		$rs = $mssql->query($sql);


		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			if($rs[$i]['Score']>0){
				$rs[$i]['user_zr'] = $this->getInfoByUserID($rs[$i]['UserID_1']);
    			$rs[$i]['user_zc'] = $this->getInfoByUserID($rs[$i]['UserID_2']);
			}else{
				$rs[$i]['user_zc'] = $this->getInfoByUserID($rs[$i]['UserID_1']);
    			$rs[$i]['user_zr'] = $this->getInfoByUserID($rs[$i]['UserID_2']);
			}
    	}
    	$pageNum = ceil($count/$pageSize);

    	$this->assign('UserID',$UserID);
    	$this->assign('s_date',$s_date);
    	$this->assign('pageNum',$pageNum);
    	$this->assign('result',$rs);
    	$this->display('vip_wzq_record');
    }

	//vip转账详细记录
    public function vip_zz_record(){
    	if($_SESSION['5678_admin']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$UserID = $_GET['UserID'];
		$s_date = $_GET['s_date'];
		$start_date = $s_date.' 00:00:00';
		$end_date = date('Y-m-d H:i:s',strtotime($start_date)+3600*24-1);
		//echo $start_date;
		//echo $end_date;
		//$start_date = '2013-01-01 00:00:00';
		//$end_date = '2014-01-01 00:00:00';
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$pageSize = PAGE_SIZE_2;
		$mssql = M();

		$ids = $this->getVipIds2();
		//echo $ids.'</br>';
		$sql2 = 'select count(RecordID) as num FROM QPTreasureDB.dbo.RecordInsure(NOLOCK) WHERE SourceUserID = '.$UserID.' AND TargetUserID not in ('.$ids.') AND TradeType = 3 and CollectDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$rs2 = $mssql->query($sql2);
		$count = $rs2[0]['num'];
    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}
    	//echo $count;

		//转出
		$sql = 'select SourceUserID,TargetUserID,SwapScore,Revenue,CollectDate from (SELECT TOP ('.$num.') SourceUserID,TargetUserID,SwapScore,Revenue,CollectDate ';
		$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') SourceUserID,TargetUserID,SwapScore,Revenue,CONVERT(varchar,CollectDate,120) as CollectDate ';
		$sql.= 'from QPTreasureDB.dbo.RecordInsure(NOLOCK) WHERE SourceUserID = '.$UserID.' AND TargetUserID not in ('.$ids.') AND TradeType = 3 and CollectDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) order by CollectDate desc) t5 order by CollectDate  asc) t6 order by CollectDate desc';
		$rs = $mssql->query($sql);

		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
    		$rs[$i]['user_zc'] = $this->getInfoByUserID($rs[$i]['SourceUserID']);
    		$rs[$i]['user_zr'] = $this->getInfoByUserID($rs[$i]['TargetUserID']);
    	}
   	 	//print_r($rs2);
    	$pageNum = ceil($count/$pageSize);
    	if(!$_GET['GameID']){
    		$goldSum = $this->getVipGold();
    		$this->assign('goldSum',$goldSum);
    	}
    	$this->assign('UserID',$UserID);
    	$this->assign('s_date',$s_date);
    	$this->assign('pageNum',$pageNum);
    	$this->assign('result',$rs);
    	$this->display('vip_zz_record');
    }

	//过滤vip小号
	public function vip_filter(){
		if($_SESSION['5678_admin']['role']!=1){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$sql = 'select id,UserID,GameID,Accounts,NickName,Is_show,Type from filter_user where Type=3';
    	$rs = $sqlite->query($sql)->fetchAll();
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
		}
		$this->assign('result',$rs);
		$this->display('vip_filter');
	}

	//新增GameID
	public function add_vip_filter(){
		if($_SESSION['5678_admin']['role']!=1){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
		$GameID = $_GET['GameID'];
		$mssql = M();
		$sql = 'select UserID,Accounts,NickName from QPAccountsDB.dbo.AccountsInfo where GameID='.$GameID;
		$rs = $mssql->query($sql);
		if(!$rs){
			_location("该GameID不存在",WEB_ROOT."index.php/Index/vip_filter");
		}else{
			$sqlite = new db_sqlite();
    		$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    		$sql1 = 'select count(id) as num from filter_user where Type=3 and GameID ='.$GameID;
    		$rs1 = $sqlite->query($sql1)->fetchAll();
    		if($rs1[0]['num']>0){
    			_location("该GameID已过滤",WEB_ROOT."index.php/Index/vip_filter");
    		}
			$arr = array('UserID'=>$rs[0]['UserID'],'GameID'=>$GameID,'Accounts'=>$rs[0]['Accounts'],'NickName'=>iconv("GBK","UTF-8",$rs[0]['NickName']),'Type'=>3);
			$sqlite->insert('filter_user', $arr);
			header("Location: ".WEB_ROOT."index.php/Index/vip_filter");
		}

	}

	//过滤用户删除
	public function vip_filter_del(){
		$UserID = $_GET['UserID'];
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$condition = array('UserID'=>$UserID);
    	$sqlite->delete('filter_user', $condition);
    	header("Location: ".WEB_ROOT."index.php/Index/vip_filter");
	}

    public function con_search(){
    	$GameID=$_GET['GameID'];
    	$mssql=M();
		$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);

			$procedure = mssql_init("PHP_GetUserControl",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			$resource = mssql_execute($procedure,false);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
			mssql_free_statement($procedure);
			mssql_close($conn);
		//print_r($rs);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'--'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['ConMax'] = number_format($rs[$i]['ConMax']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
		}
		//$this->assign('type',$Type);
    	//$this->assign('pageNum',$pageNum);
    	$this->assign('result',$rs);
    	$this->display('con3');
    }

	public function record_search(){
    	$GameID=$_GET['GameID'];
    	$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);

			$procedure = mssql_init("PHP_GetUserDetailed",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			$resource = mssql_execute($procedure,false);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
			mssql_free_statement($procedure);
			mssql_close($conn);
		//print_r($rs);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'--'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['ConMax'] = number_format($rs[$i]['ConMax']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
		}
		//$this->assign('type',$Type);
    	//$this->assign('pageNum',$pageNum);
    	$this->assign('result',$rs);
    	$this->display('con5');
    }

    public function control(){
    	if($_SESSION['zs78_admin2']['role'] >2){
   	 	 _location("没有权限",WEB_ROOT.'index.php');
   		}
    	//0不控制  1输  2赢
    	$mssql=M();
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$pageSize = PAGE_SIZE_2;
    	if($_GET['type']){
			$Type=$_GET['type'];
		}else{
			$Type=1;
		}
    	if($Type==1){
    		$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);

			$procedure = mssql_init("PHP_GetControlAll",$conn);
			$resource = mssql_execute($procedure,false);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
			mssql_free_statement($procedure);
			mssql_close($conn);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
				$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'--'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			}
       		//$pageNum = ceil($count/$pageSize);
    		$this->assign('type',$Type);
    		//$this->assign('pageNum',$pageNum);
    		$this->assign('result',$rs);
    		$this->display('con1');

    	}
    	if($Type==2){
    		//$sql2 = 'select count(A.RecordID) as num FROM QPTreasureDB.dbo.ControlAllRecord(NOLOCK) A,QPAccountsDB.dbo.ControlUserInfo B,QPPlatformDB.dbo.GameRoomInfo C WHERE A.ConID=B.ControlID AND A.ServerID=C.ServerID';
			//$rs2 = $mssql->query($sql2);
			$count = 150;
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}

    		//$sql='SELECT C.ServerName,A.MobileType,A.MobilePercentage,A.PCType,A.PCPercentage,B.Accounts,CONVERT(varchar,A.UpdateTime,120) as UpdateTime FROM QPTreasureDB.dbo.ControlAllRecord A,QPAccountsDB.dbo.ControlUserInfo B,QPPlatformDB.dbo.GameRoomInfo C ';
    		//$sql.='WHERE A.ConID=B.ControlID AND A.ServerID=C.ServerID ';


    		$sql = 'select KindName,ServerName,MobileType,MobilePercentage,PCType,PCPercentage,Accounts,UpdateTime from (SELECT TOP ('.$num.') KindName,ServerName,MobileType,MobilePercentage,PCType,PCPercentage,Accounts,UpdateTime ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') D.KindName,C.ServerName,A.MobileType,A.MobilePercentage,A.PCType,A.PCPercentage,B.Accounts,CONVERT(varchar,A.UpdateTime,120) as UpdateTime ';
			$sql.= 'from QPTreasureDB.dbo.ControlAllRecord A,QPAccountsDB.dbo.ControlUserInfo B,QPPlatformDB.dbo.GameRoomInfo C,QPPlatformDB.dbo.GameKindItem D WHERE A.ConID=B.ControlID AND A.ServerID=C.ServerID AND C.GameID=D.KindID order by UpdateTime desc) t5 order by UpdateTime  asc) t6 order by UpdateTime desc';
			$rs=$mssql->query($sql);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
				$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			}
    		//print_r($rs);
    		$pageNum = ceil($count/$pageSize);
    		$this->assign('type',$Type);
    		$this->assign('pageNum',$pageNum);
    		$this->assign('result',$rs);
    		$this->display('con1');

    	}
    	if($Type==3){
		/*
			$count = 150;
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}
    		$sql = 'select KindName,WinPercentage,ConGameID,ConType,ConMax,Score,WinLv,LostLv,Accounts,UserID,UpdateTime from (SELECT TOP ('.$num.') KindName,WinPercentage,ConGameID,ConType,ConMax,Score,WinLv,LostLv,Accounts,UserID,UpdateTime ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') E.KindName,A.WinPercentage,A.ConGameID,A.ConType,A.ConMax,A.Score,A.WinLv,A.LostLv,B.Accounts,D.UserID,CONVERT(varchar,A.UpdateTime,120) as UpdateTime ';
			$sql.= 'from QPTreasureDB.dbo.ControlUserRecord2 A,QPAccountsDB.dbo.ControlUserInfo B,QPAccountsDB.dbo.AccountsInfo D,QPPlatformDB.dbo.GameKindItem E WHERE A.ControlID=B.ControlID AND A.ConGameID=D.GameID AND A.KindID=E.KindID order by UpdateTime desc) t5 order by UpdateTime  asc) t6 order by UpdateTime desc';
			$rs=$mssql->query($sql);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
				$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
				$rs[$i]['ConMax'] = number_format($rs[$i]['ConMax']);
				$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			}
    		//print_r($rs);
    		$pageNum = ceil($count/$pageSize);
    		$this->assign('type',$Type);
    		$this->assign('pageNum',$pageNum);
    		$this->assign('result',$rs);
			*/
    		$this->display('con3');

    	}
    	if($Type==4){
    		//$sql2 = 'select count(RecordID) as num FROM QPTreasureDB.dbo.ControlUserDetailed2';
			//$rs2 = $mssql->query($sql2);
			//$count = 80;
			//echo $count;
    		//if($pageNo*$pageSize>$count){
    		//	$num = $count-(($pageNo-1)*$pageSize);
    		//}else{
    		//	$num = $pageSize;
    		//}

    		//$sql='SELECT C.ServerName,A.MobileType,A.MobilePercentage,A.PCType,A.PCPercentage,B.Accounts,CONVERT(varchar,A.UpdateTime,120) as UpdateTime FROM QPTreasureDB.dbo.ControlAllRecord A,QPAccountsDB.dbo.ControlUserInfo B,QPPlatformDB.dbo.GameRoomInfo C ';
    		//$sql.='WHERE A.ConID=B.ControlID AND A.ServerID=C.ServerID ';
    		//SELECT WinPercentage,RecordID,ControlID,ServerID,ConGameID,ConType,ConMax,Score,ConMachine,ConMachine,UpdateTime FROM ControlUserRecord
    		//$sql = 'select ServerName,KindName,WinPercentage,ConGameID,ConType,ConMax,Score,WinLv,LostLv,Accounts,UserID,UpdateTime from (SELECT TOP ('.$num.') ServerName,KindName,WinPercentage,ConGameID,ConType,ConMax,Score,WinLv,LostLv,Accounts,UserID,UpdateTime ';
			//$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') C.ServerName,E.KindName,A.WinPercentage,A.ConGameID,A.ConType,A.ConMax,A.Score,A.WinLv,A.LostLv,B.Accounts,D.UserID,CONVERT(varchar,A.UpdateTime,120) as UpdateTime ';
			//$sql.= 'from QPTreasureDB.dbo.ControlUserDetailed2 A,QPAccountsDB.dbo.ControlUserInfo B,QPPlatformDB.dbo.GameRoomInfo C,QPAccountsDB.dbo.AccountsInfo D,QPPlatformDB.dbo.GameKindItem E WHERE A.ControlID=B.ControlID AND A.ServerID=C.ServerID AND A.ConGameID=D.GameID AND C.GameID=E.GameID order by UpdateTime desc) t5 order by UpdateTime  asc) t6 order by UpdateTime desc';
			//$rs=$mssql->query($sql);
			//echo $sql;
			//print_r($rs);
			//for($i=0;$i<count($rs);$i++){
			//	$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			//	$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			//	$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			//	$rs[$i]['ConMax'] = number_format($rs[$i]['ConMax']);
			//	$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			//}
    		//print_r($rs);
    		//$pageNum = ceil($count/$pageSize);
    		//$this->assign('type',$Type);
    		//$this->assign('pageNum',$pageNum);
    		//$this->assign('result',$rs);
    		$this->display('con4');

    	}
    	//$this->display('control');
    }
    public function online(){
    	if($_SESSION['5678_admin']['role'] >2){
   	 	 _location("没有权限",WEB_ROOT.'index.php');
   		}
    	$mssql=M();
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$pageSize = PAGE_SIZE_2;
    	if($_GET['type']){
			$Type=$_GET['type'];
		}else{
			$Type=1;
		}
		if($Type==1){


			$sql2 = 'select count(*) as num from QPTreasureDB.dbo.GameScoreLocker A,QPAccountsDB.dbo.AccountsInfo B,QPTreasureDB.dbo.ControlUserRecord2 C WHERE A.UserID=B.UserID AND B.GameID=C.ConGameID AND A.KindID=C.KindID';
			$rs2 = $mssql->query($sql2);
			$count = $rs2[0]['num'];
				//echo $count;
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}
			$sql = 'select UserID,Score_win,KindName,ServerName,GameID,NickName,Score,InsureScore,CollectDate from (SELECT TOP ('.$num.') UserID,Score_win,KindName,ServerName,GameID,NickName,Score,InsureScore,CollectDate ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') A.UserID,E.Score as Score_win,D.KindName,C.ServerName,B.GameID,B.NickName,F.Score,F.InsureScore,CONVERT(varchar,A.CollectDate,120) as CollectDate ';
			$sql.= 'from QPTreasureDB.dbo.GameScoreLocker A,QPAccountsDB.dbo.AccountsInfo B,QPPlatformDB.dbo.GameRoomInfo C,QPPlatformDB.dbo.GameKindItem D,QPTreasureDB.dbo.ControlUserRecord2 E,QPTreasureDB.dbo.GameScoreInfo F WHERE C.ServerID=E.ServerID AND A.UserID=B.UserID AND B.GameID=E.ConGameID AND E.KindID=D.KindID AND A.UserID=F.UserID order by CollectDate desc) t5 order by CollectDate  asc) t6 order by CollectDate desc';
			//echo $sql;
			$rs=$mssql->query($sql);
			//echo $sql;
			//print_r($rs);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
				$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
				$rs[$i]['Total']=$rs[$i]['InsureScore']+$rs[$i]['Score'];
				$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
				$rs[$i]['Score'] = number_format($rs[$i]['Score']);
				$rs[$i]['Total'] = number_format($rs[$i]['Total']);
				$rs[$i]['Score_win'] = number_format($rs[$i]['Score_win']);
			}
    		//print_r($rs);
    		$pageNum = ceil($count/$pageSize);
    		$this->assign('type',$Type);
    		$this->assign('pageNum',$pageNum);
    		$this->assign('result',$rs);
    		$this->display('online');
		}
    if($Type==2){
			$sql2 = 'select count(*) as num from QPTreasureDB.dbo.GameScoreLocker A,QPAccountsDB.dbo.AccountsInfo B WHERE A.UserID=B.UserID AND B.GameID not in (select ConGameID from QPTreasureDB.dbo.ControlUserRecord2)';
			$rs2 = $mssql->query($sql2);
			$count = $rs2[0]['num'];
				//echo $count;
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}
			$sql = 'select UserID,KindName,ServerName,GameID,NickName,Score,InsureScore,CollectDate from (SELECT TOP ('.$num.') UserID,KindName,ServerName,GameID,NickName,Score,InsureScore,CollectDate ';
			$sql.= 'from (SELECT TOP ('.$pageNo*$pageSize.') A.UserID,D.KindName,C.ServerName,B.GameID,B.NickName,F.Score,F.InsureScore,CONVERT(varchar,A.CollectDate,120) as CollectDate ';
			$sql.= 'from QPTreasureDB.dbo.GameScoreLocker A,QPAccountsDB.dbo.AccountsInfo B,QPPlatformDB.dbo.GameRoomInfo C,QPPlatformDB.dbo.GameKindItem D,QPTreasureDB.dbo.GameScoreInfo F WHERE A.UserID=B.UserID AND B.GameID not in (select ConGameID from QPTreasureDB.dbo.ControlUserRecord2) AND A.ServerID=C.ServerID AND A.KindID=D.KindID AND A.UserID=F.UserID order by CollectDate desc) t5 order by CollectDate  asc) t6 order by CollectDate desc';
			$rs=$mssql->query($sql);
			//echo $sql;
			//print_r($rs);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
				$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
				$rs[$i]['Total']=$rs[$i]['InsureScore']+$rs[$i]['Score'];
				$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
				$rs[$i]['Score'] = number_format($rs[$i]['Score']);
				$rs[$i]['Total'] = number_format($rs[$i]['Total']);
				$rs[$i]['Score_win'] = number_format($rs[$i]['Score_win']);
			}
    		//print_r($rs);
    		$pageNum = ceil($count/$pageSize);
    		$this->assign('type',$Type);
    		$this->assign('pageNum',$pageNum);
    		$this->assign('result',$rs);
    		$this->display('online2');
		}

    }

    //更新库存
    public function updateStock(){
    	$mssql=M();
    	$sql = 'SELECT GameID,KindName FROM QPPlatformDB.dbo.GameKindItem WHERE Nullity=0';
    	$rs = $mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['GameName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
    	}
    	//print_r($rs);
    	$this->assign('rs',$rs);
    	$this->display('choose');
    }

	//获取房间
    public function getRoom(){
    	$GameID=$_GET['GameID'];
    	$mssql=M();
    	$sql = 'SELECT ServerID,ServerName FROM QPPlatformDB.dbo.GameRoomInfo WHERE KindID='.$GameID;
    	$rs = $mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
    		//$rs[$i]['ServerName'] = substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-'));
    		$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
    	}
    	//print_r($rs);
    	echo json_encode($rs);
    }

    //库存信息
    public function stockList(){
    	$ServerID=$_GET['room'];
    	$mssql=M();
    	$sql='SELECT ServerID,ServerName,Lv1,Lv2,Lv3,Lv4,Lv5 FROM QPTreasureDB.dbo.ControlStock where ServerID='.$ServerID;
    	$rs = $mssql->query($sql);
    	$rs[0]['ServerName'] = iconv("GBK","UTF-8",$rs[0]['ServerName']);
    	//print_r($rs);
    	$this->assign('rs',$rs[0]);
    	$this->display('stockList');
    }

    //更改库存值
    public function changeStock(){
    	$mssql = M();
    	$Operator = $_SESSION['5678_admin']['username'];
    	$InsertTime = date('Y-m-d H:i:s');
    	$num = $_GET['num'];
    	$ServerID=$_GET['room'];
    	$do = $_GET['do'];
    	//print_r($_GET);
    	if($do==2){
    		$num = $num*(-1);
    	}
    	$kc = $_GET['kc'];
    	if($kc==1){
    		$sql = 'UPDATE QPTreasureDB.dbo.ControlStock SET Lv1=Lv1+'.$num.' WHERE ServerID='.$ServerID;
    	}elseif ($kc==2){
    		$sql = 'UPDATE QPTreasureDB.dbo.ControlStock SET Lv2=Lv2+'.$num.' WHERE ServerID='.$ServerID;
    	}elseif ($kc==3){
    		$sql = 'UPDATE QPTreasureDB.dbo.ControlStock SET Lv3=Lv3+'.$num.' WHERE ServerID='.$ServerID;
    	}elseif ($kc==4){
    		$sql = 'UPDATE QPTreasureDB.dbo.ControlStock SET Lv4=Lv4+'.$num.' WHERE ServerID='.$ServerID;
    	}elseif ($kc==5){
    		$sql = 'UPDATE QPTreasureDB.dbo.ControlStock SET Lv5=Lv5+'.$num.' WHERE ServerID='.$ServerID;
    	}
    	$mssql->query($sql);

    	$sql2 = 'INSERT INTO QPTreasureDB.dbo.ChangeStockRecord(ServerID,Operator,StockType,Num,InsertTime) values('.$ServerID.',"'.$Operator.'",'.$kc.','.$num.',"'.$InsertTime.'")';
    	$mssql->query($sql2);

    	$sql3='SELECT ServerID,ServerName,Lv1,Lv2,Lv3,Lv4,Lv5 FROM QPTreasureDB.dbo.ControlStock where ServerID='.$ServerID;
    	$rs = $mssql->query($sql3);
    	$rs[0]['ServerName'] = iconv("GBK","UTF-8",$rs[0]['ServerName']);
    	//print_r($rs);
    	$this->assign('rs',$rs[0]);
    	$this->assign('num',$num);
    	$this->assign('do',$do);
    	$this->display('stockList');

    }

	//库存信息
    public function stockInfo(){
    	$mssql = M();
    	$sql = 'SELECT ServerID,ServerName,TotalStock,Lv1,Lv2,Lv3,Lv4,Lv5 FROM QPTreasureDB.dbo.ControlStock where Lv1!=0 order by ServerID';
    	$rs=$mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
    	}
    	$this->assign('rs',$rs);
    	$this->display('stockInfo');


    }

	//开启库存
    public function startStock(){
    	$ServerID = $_GET['ServerID'];
    	$mssql = M();
    	$sql = 'UPDATE QPTreasureDB.dbo.ControlStock SET TotalStock=1 where ServerID='.$ServerID;
    	if(!$mssql->query($sql)){
   			_location('操作成功',WEB_ROOT.'index.php/Index/stockInfo');
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/Index/stockInfo');
   		}

    }

	//关闭库存
    public function endStock(){
    	$ServerID = $_GET['ServerID'];
    	$mssql = M();
    	$sql = 'UPDATE QPTreasureDB.dbo.ControlStock SET TotalStock=0 where ServerID='.$ServerID;
    	if(!$mssql->query($sql)){
   			_location('操作成功',WEB_ROOT.'index.php/Index/stockInfo');
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/Index/stockInfo');
   		}
    }
}
