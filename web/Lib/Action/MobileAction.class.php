<?php
// 本类由系统自动生成，仅供测试用途
class MobileAction extends Action {

	public function _initialize(){		
    	if(!isset($_SESSION['5678_admin'])){
    	header("Location: ".WEB_ROOT."index.php/Login");
    	return false;
   		}
   		if($_SESSION['5678_admin']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   		}
   	}
//手机新注册列表
//16 安卓  不是16就是iphone
    public function tel_re(){
    	if($_SESSION['5678_admin']['role'] != 1){
   	 	 _location("没有权限",WEB_ROOT.'index.php');	
   		}
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
		
		//$encodeYK = iconv('utf-8','gb2312','游客');	
    	
		//$sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where (RegisterMobile != "" OR (NickName LIKE "'.$encodeYK.'%" and Accounts LIKE "v%")) AND IsLockMobile = 0 AND RegisterDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.RegisterByMobilePhone(NOLOCK) where RegisterDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$rs1 = $mssql->query($sql1);		
		$count = $rs1[0]['num'];
    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}
    	
    	$sql2 = 'SELECT UserID,GameID,Accounts,NickName,RegisterMobile,UserType,RegisterDate,RegisterType,RegisterMachine FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,RegisterMobile,UserType,RegisterDate,RegisterType,RegisterMachine FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.RegisterMobile,t2.UserType,t2.RegisterMachine,t2.RegisterType,CONVERT(varchar,t2.RegisterDate,120) as RegisterDate ';
    	$sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPAccountsDB.dbo.RegisterByMobilePhone(NOLOCK) t2 on t1.UserID = t2.UserID WHERE t2.RegisterDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) order by RegisterDate desc) t1 order by RegisterDate asc) t2 order by RegisterDate desc';
		$rs2 = $mssql->query($sql2);
		
    	for($i=0;$i<count($rs2);$i++){
    		$rs2[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
    		$rs2[$i]['Accounts'] = iconv("GB2312","UTF-8",$rs2[$i]['Accounts']);
    		$rs2[$i]['NickName'] = iconv("GB2312","UTF-8",$rs2[$i]['NickName']);
    		$rs2[$i]['num'] = $this->getTelRe($rs2[$i]['RegisterMachine']);

		}
		$pageNum = ceil($count/$pageSize);
		$this->assign('count',$count);
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs2);    	
    	$this->display('tel_re');   	
    	
    }
    
	//手机注册账号的注册数
	public function getTelRe($RegisterMachine){
		$mssql = M();
		$sql = 'select count(UserID) as num from QPAccountsDB.dbo.RegisterByMobilePhone where RegisterMachine ="'.$RegisterMachine.'"';
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
		$sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.RegisterMobile,t2.UserType,t2.RegisterMachine,t2.RegisterType,CONVERT(varchar,t2.RegisterDate,120) as RegisterDate from QPAccountsDB.dbo.AccountsInfo t1 left join QPAccountsDB.dbo.RegisterByMobilePhone t2 on t1.UserID = t2.UserID where t2.RegisterMachine ="'.$RegisterMachine.'" order by RegisterDate desc';
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
	
	//手机绑定
	public function tel_bd(){
		$mssql = M();
		if($_GET['type'] && $_GET['info']){
			$type = $_GET['type'];
			$info = $_GET['info'];
			if($type==1){
				$sql3 = 'SELECT UserID,GameID,Accounts,NickName,RegisterMobile FROM QPAccountsDB.dbo.AccountsInfo WHERE GameID ='.$info;
			}elseif($type==2){
				$sql3 = 'SELECT UserID,GameID,Accounts,NickName,RegisterMobile FROM QPAccountsDB.dbo.AccountsInfo WHERE RegisterMobile ="'.$info.'"';
			}
			$rs2 = $mssql->query($sql3);
			$rs2[0]['Accounts'] = iconv("GB2312","UTF-8",$rs2[0]['Accounts']);
    		$rs2[0]['NickName'] = iconv("GB2312","UTF-8",$rs2[0]['NickName']);
		}
		else{
			$pageSize = PAGE_SIZE_2;
    		if($_GET['pageNo']){
				$pageNo = $_GET['pageNo'];
			}else{
				$pageNo = 1;
			}
    	
			$sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where IsLockMobile =1';
			$rs1 = $mssql->query($sql1);		
			$count = $rs1[0]['num'];
    		if($pageNo*$pageSize>$count){
    			$num = $count-(($pageNo-1)*$pageSize);
    		}else{
    			$num = $pageSize;
    		}
   	
    	
    		$sql2 = 'SELECT UserID,GameID,Accounts,NickName,RegisterMobile FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,RegisterMobile FROM ';
    		$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') UserID,GameID,Accounts,NickName,RegisterMobile ';
    		$sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) WHERE IsLockMobile =1 order by GameID desc) t1 order by GameID asc) t2 order by GameID desc';
			$rs2 = $mssql->query($sql2);
		

    		for($i=0;$i<count($rs2);$i++){
    			$rs2[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
    			$rs2[$i]['Accounts'] = iconv("GB2312","UTF-8",$rs2[$i]['Accounts']);
    			$rs2[$i]['NickName'] = iconv("GB2312","UTF-8",$rs2[$i]['NickName']);
			}
			$pageNum = ceil($count/$pageSize);
			$this->assign('pageNum',$pageNum);
		}
		
		$this->assign('result',$rs2);    	

		$this->display('tel_bd');
			
	}
	
	//解绑操作
	public function tel_jiebang(){
		$mssql = M();
		$UserID = $_GET['UserID'];
		$sql = 'UPDATE QPAccountsDB.dbo.AccountsInfo SET IsLockMobile = 0,RegisterMobile = \'\' WHERE UserID = '.$UserID;
		$mssql->query($sql);
		header("Location: ".WEB_ROOT."index.php/Mobile/tel_bd"); 	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}













