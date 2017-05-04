<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {

	public function _initialize(){
		  session_start();
    // 	if($_cookie['zs78_admin2']=NULL){
    // 		_href(WEB_ROOT."index.php/user");
   // 		}

		// if($_cookie['zs78_admin2']['role']==4){
   // 			_location($_cookie['zs78_admin2']['role'],WEB_ROOT.'index.php/User');
   // 		}

   	}

    public function index(){
    	//phpinfo();


    	$this->display('user_search');

    }

    //详细信息
    public function userInfo(){

    	$type = $_GET['type'];
    	$val = iconv("UTF-8","GBK",$_GET['info']);
    	$info = D('AccountsInfo');
    	if($type == 1){
    		$condition['GameID'] = $val;
    	}
    	if($type == 2){
    		$condition['Accounts'] = $val;
    	}
		if($type == 3){
    		$NickName = iconv("UTF-8","GBK",$_GET['info']);
			$mssql = M();
			$sql = 'select top 100 t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as Total from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID where t1.NickName like "%'.$NickName.'%" order by Total desc';
			//echo $sql;
			//exit;
			$rs_list = $mssql->query($sql);
			for($i=0;$i<count($rs_list);$i++){
				$rs_list[$i]['NickName'] = iconv("GBK","UTF-8",$rs_list[$i]['NickName']);
				$rs_list[$i]['Score'] = number_format($rs_list[$i]['Score']);
				$rs_list[$i]['InsureScore'] = number_format($rs_list[$i]['InsureScore']);
				$rs_list[$i]['Total'] = number_format($rs_list[$i]['Total']);
			}
			$this->assign('rs',$rs_list);
			$this->display('user_list');
			return;

    	}
		if($type == 4){
    		$condition['UserID'] = $val;
    	}
    	if($_GET['UserID']){
    		$condition['UserID'] = $_GET['UserID'];
    	}
    	$rs_user = $info->where($condition)->select();

		if($rs_user == null){
			_location("无此用户",WEB_ROOT."index.php/User");
			return false;
		}
		if($rs_user[0]['RegisterMobile']==' '){
			$rs_user[0]['IsLockMobile']=0;
		}else{
			$rs_user[0]['IsLockMobile']=1;
		}
		$rs_user[0]['NickName'] = iconv("GBK","UTF-8",$rs_user[0]['NickName']);
		$rs_user[0]['Accounts'] = iconv("GBK","UTF-8",$rs_user[0]['Accounts']);
    	$UserID = $rs_user[0]['UserID'];
    	if($rs_user[0]['IsAndroid']>0){
    		$this->assign('rs_user',$rs_user[0]);
			$this->assign('rs_gold',$rs_gold);
    		$this->display('user_info');
    		return;
    	}

    	$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$rs_gold = array();

		$procedure = mssql_init("php_user_info3",$conn);
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		$resource = mssql_execute($procedure);
		if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$rs_gold = $row;
		}
		$conn2=mssql_connect($GLOBALS['DB_RECORD_11']['DB_HOST'],$GLOBALS['DB_RECORD_11']['DB_USER'],$GLOBALS['DB_RECORD_11']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_RECORD_11']['DB_NAME']);
		$rs_gold2 = array();

		$procedure2 = mssql_init("PHP_user_gold",$conn2);
		mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
		$resource2 = mssql_execute($procedure2);
		if($row2 = mssql_fetch_assoc($resource2)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$rs_gold2 = $row2;
		}
		mssql_free_statement($procedure);
		mssql_free_statement($procedure2);
		mssql_close($conn);
		mssql_close($conn2);
		//var_dump($rs_gold);
		$rs_gold2['game_sum']=number_format($rs_gold2['game_sum']);
		$rs_gold['Sum'] = $rs_gold['Score']+$rs_gold['InsureScore'];

		$day_sum = $this->getDaySum($UserID);

		if($rs_user[0]['MemberOrder']==0){
			$rs_gold['zr_sum'] = floor($rs_gold['zr_sum']*0.98);
			$day_sum['zr_vip'] = floor($day_sum['zr_vip']*0.98);
			//echo  intval($rs_gold['zr_sum']*0.98);
			//echo  intval($day_sum['zr_vip']*0.98);
		}

		$rs_gold['gold_jy_sum']=$rs_gold['wzq_sum']+$rs_gold['zr_sum']-$rs_gold['zc_sum'];
		$day_sum['zr_pt'] = $rs_gold['zr_sum']-$day_sum['zr_vip'];
		$day_sum['zc_pt'] = $rs_gold['zc_sum']-$day_sum['zc_vip'];
		$day_sum['zr_pt'] = number_format($day_sum['zr_pt']);
		$day_sum['zr_vip'] = number_format($day_sum['zr_vip']);
		$day_sum['zc_pt'] = number_format($day_sum['zc_pt']);
		$day_sum['zc_vip'] = number_format($day_sum['zc_vip']);
		foreach ($rs_gold as $key=>$value){
			$rs_gold[$key] = number_format($rs_gold[$key]);
		}
		//var_dump($rs_user[0]['RegisterDate']);
		if(strlen($rs_user[0]['RegisterDate'])==17){
			$rs_user[0]['RegisterDate'] = substr($rs_user[0]['RegisterDate'], 5,4).'-'.substr($rs_user[0]['RegisterDate'], 0,2).'-'.substr($rs_user[0]['RegisterDate'], 3,1).'&nbsp;&nbsp;'.substr($rs_user[0]['RegisterDate'], 11);
		}
    	if(strlen($rs_user[0]['RegisterDate'])==18){
			$rs_user[0]['RegisterDate'] = substr($rs_user[0]['RegisterDate'], 6,4).'-'.substr($rs_user[0]['RegisterDate'], 0,2).'-'.substr($rs_user[0]['RegisterDate'], 3,2).'&nbsp;&nbsp;'.substr($rs_user[0]['RegisterDate'], 11);
		}
    	if(strlen($rs_user[0]['LastLogonDate'])==17){
			$rs_user[0]['LastLogonDate'] = substr($rs_user[0]['LastLogonDate'], 5,4).'-'.substr($rs_user[0]['LastLogonDate'], 0,2).'-'.substr($rs_user[0]['LastLogonDate'], 3,1).'&nbsp;&nbsp;'.substr($rs_user[0]['LastLogonDate'], 11);
		}
    	if(strlen($rs_user[0]['LastLogonDate'])==18){
			$rs_user[0]['LastLogonDate'] = substr($rs_user[0]['LastLogonDate'], 6,4).'-'.substr($rs_user[0]['LastLogonDate'], 0,2).'-'.substr($rs_user[0]['LastLogonDate'], 3,2).'&nbsp;&nbsp;'.substr($rs_user[0]['LastLogonDate'], 11);
		}

		//$Zc_gold_info = $this->user_zc_info($UserID);

		/*$UserLogin = $this->getUserLogin($UserID);
		if($UserLogin==1){
			$UserLoginInfo='在线';
		}else{
			$UserLoginInfo='不在线';
		}*/
		//exit;
		//print_r($day_sum);
		$game_room = $this->game_room($UserID);
		$search_rs = $this->getResults($rs_user);
		$rs_user[0]['Re_city'] = $this->getIpPlace($rs_user[0]['RegisterIP']);
		$rs_user[0]['Logon_city'] = $this->getIpPlace($rs_user[0]['LastLogonIP']);
		//$this->assign('Zc_gold_info',$Zc_gold_info);
		$this->assign('UserLoginInfo',$UserLoginInfo);
		$this->assign('search_rs',$search_rs);
		$this->assign('day_sum',$day_sum);
		$this->assign('NewMac',$NewMac);
		$this->assign('gold_type',$gold_type);
		$this->assign('game_room',$game_room);
		$this->assign('rs_user',$rs_user[0]);
		$this->assign('rs_gold',$rs_gold);
		$this->assign('rs_gold2',$rs_gold2);
    	$this->display('user_info');

    }

	//详细信息
    public function userInfo2(){
  	   	$UserID=$_GET['UserID'];

    	$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$rs_gold = array();

		$procedure = mssql_init("php_user_info_s",$conn);
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		$resource = mssql_execute($procedure);
		if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$rs_gold = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
		$rs_gold['NickName'] = iconv("GBK","UTF-8",$rs_gold['NickName']);
		$rs_gold['Accounts'] = iconv("GBK","UTF-8",$rs_gold['Accounts']);
		$rs_gold['ServerName'] = iconv("GBK","UTF-8",$rs_gold['ServerName']);
		$rs_gold['Sum'] = $rs_gold['Score']+$rs_gold['InsureScore'];
		$rs_gold['Score'] = number_format($rs_gold['Score']);
		$rs_gold['InsureScore'] = number_format($rs_gold['InsureScore']);
		$rs_gold['Sum'] = number_format($rs_gold['Sum']);
		$rs_gold['wzq_sum'] = number_format($rs_gold['wzq_sum']);
		$rs_gold['zr_sum'] = number_format($rs_gold['zr_sum']);
		$rs_gold['zc_sum'] = number_format($rs_gold['zc_sum']);
		$rs_gold['zr_pt'] = number_format($rs_gold['zr_pt']);
		$rs_gold['zr_vip'] = number_format($rs_gold['zr_vip']);
		$rs_gold['zc_pt'] = number_format($rs_gold['zc_pt']);
		$rs_gold['zc_vip'] = number_format($rs_gold['zc_vip']);
		$rs_gold['la_mac_s'] = number_format($rs_gold['la_mac_s']);
		$rs_gold['wzq_pt'] = number_format($rs_gold['wzq_pt']);
		$rs_gold['wzq_vip'] = number_format($rs_gold['wzq_vip']);
		$rs_gold['Logon_city'] = $this->getIpPlace($rs_gold['LastLogonIP']);
		//$this->assign('Zc_gold_info',$Zc_gold_info);
		$this->assign('rs_gold',$rs_gold);
    	$this->display('user_info_2');

    }

	//新机器码
    public function getNewMac($UserID){
        $mssql = M();
        $result = array();
        $sql = 'SELECT NewMac from QPAccountsDB.dbo.UserNewMac where UserID='.$UserID;
        $rs = $mssql->query($sql);
        $result['NewMac'] = $rs[0]['NewMac'];
        $sql2 = 'select count(UserID) as num from QPAccountsDB.dbo.UserNewMac(nolock) where NewMac = "'.$result['NewMac'].'"';
        $rs2 = $mssql->query($sql2);
        $result['Mac_count'] = $rs2[0]['num'];
        return $result;
    }

    //每个游戏分类金币
    public function getGoldType($UserID){
    	$mssql = M();
    	$sql = 'select GameInsureScore,GameName from QPTreasureDB.dbo.GameTypeScoreInfo where UserID ='.$UserID;
    	$rs = $mssql->query($sql);
    	for ($i=0; $i < count($rs); $i++) {
    		$rs[$i]['GameName'] = iconv("GBK","UTF-8",$rs[$i]['GameName']);
    		$rs[0]['total'] = $rs[0]['total']+$rs[$i]['GameInsureScore'];
    		$rs[$i]['GameInsureScore'] = number_format($rs[$i]['GameInsureScore']);
    	}
    	return $rs;
    }

    //相同身份证列表
    public function sfzList(){
    	$mssql = M();
    	$sfz = $_GET['sfz'];
    	$sql = 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.CustomFaceVer,t1.MemberOrder,t1.Nullity,t2.Score,t2.InsureScore FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID=t2.UserID WHERE t1.PassPortID="'.$sfz.'"';
    	$rs = $mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
		}
		$this->assign('rs',$rs);
		$this->display('sfzList');

    }

    //用户大厅登陆状态
    public function getUserLogin($UserID){
    	$mssql = M();
    	$sql = 'SELECT UserID from QPAccountsDB.dbo.UserLogonLock WHERE UserID='.$UserID;
    	$rs = $mssql->query($sql);
    	if(!$rs){
    		return 0;
    	}else{
    		return 1;
    	}
    }

    //清楚用户大厅锁定
    public function userUnlock(){
    	$UserID = $_GET['UserID'];
    	$mssql = M();
    	$sql = 'DELETE QPAccountsDB.dbo.UserLogonLock WHERE UserID='.$UserID;
    	if(!$mssql->query($sql)){
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}

    }

    public function online_user(){

		if($_GET['type']){
			$type = $_GET['type'];
		}else{
			$type = 1;
		}
		if($_GET['order']){
			$order = $_GET['order'];
		}else{
			$order = 1;
		}
		$user_ff = 0;
		$ids='';
		$user_login['ios']=0;
		$user_login['android']=0;
		$user_login['pc']=0;
		$dx=0;
		$lt=0;
		$yd=0;
		$bl=0;
		$cc=0;
		$qt=0;
		$gjf = array(75,76,77,78,85,86,87,88,95,96,97,98,105,106,107,108,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258);
		$mssql = M();
		//$sql = 'select count(UserID) as num from QPTreasureDB.dbo.GameScoreLocker(nolock)';
		//$rs = $mssql->query($sql);
		//$count_online=$rs[0]['num'];

		$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_OnlineUserInfo2",$conn);
		mssql_bind($procedure,"@type", $type, SQLINT4);
		mssql_bind($procedure,"@order", $order, SQLINT4);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			if($rs[$i]['KindID']==2060 || $rs[$i]['KindID']==2070 || $rs[$i]['KindID']==2075 || $rs[$i]['KindID']==2080){
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			}else{
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			}
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			if(in_array($rs[$i]['ServerID'],$gjf)){
				$rs[$i]['is_gjf']=1;
			}else{
				$rs[$i]['is_gjf']=0;
			}
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
				if($rs[$i]['LockMobileKindID']==1){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==2){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==3){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==4){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==9){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==102){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==21){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==22){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==23){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==31){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==32){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==33){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==41){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==42){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==43){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==51){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==52){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==53){
					$user_login['pc'] = $user_login['pc']+1;
				}else{
					$user_login['ios'] = $user_login['ios']+1;
				}

            }else{
            	if($rs[$i]['LockMobileKindID']==1){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==2){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==3){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==4){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==9){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==102){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==21){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==22){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==23){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==31){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==32){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==33){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==41){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==42){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==43){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==51){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==52){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==53){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}else{
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}
            }
			$rs[$i]['Logon_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
			$area=$rs[$i]['Logon_city']['area'];
			if($area=='电信'){
				$dx=$dx+1;
			}elseif($area=='联通'){
				$lt=$lt+1;
			}elseif($area=='移动'){
				$yd=$yd+1;
			}elseif($area=='保留地址'){
				$bl=$bl+1;
			}elseif($area=='鹏博士长城宽带'){
				$cc=$cc+1;
			}else{
				$qt=$qt+1;
			}
			if($rs[$i]['SpreaderID']==1){
                $ts[]=$rs[$i];
            }
			if($rs[$i]['LoveLiness']>0){
                $ts2[]=$rs[$i];
            }

		}
		$score_sum = number_format($score_sum);
        //print_r($rs);
		if(count($ts)>0 || count($ts2)>0){
			$show=1;
		}else{
			$show=0;
		}
		$count_online=count($rs);
		$user_mf = count($rs)-$user_ff;
		$this->assign('yd',$yd);
		$this->assign('lt',$lt);
		$this->assign('dx',$dx);
		$this->assign('cc',$cc);
		$this->assign('bl',$bl);
		$this->assign('qt',$qt);
    	$this->assign('result',$rs);
		$this->assign('count_online',$count_online);
		$this->assign('user_login',$user_login);
		$this->assign('user_login_mf',$user_login_mf);
		$this->assign('score_sum',$score_sum);
		$this->assign('user_ff',$user_ff);
		$this->assign('user_mf',$user_mf);
    	$this->assign('show',$show);
    	$this->assign('ts',$ts);
		$this->assign('ts2',$ts2);
    	if($type==1){
    		$this->display('online_test2');
    	}else{
    		$this->display('online2');
    	}


    }

    //玩家转出详细  (*****)
    public function user_zc_info($UserID){
    	$return=array();
    	$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);

		$procedure = mssql_init("PHP_UserZcDetailInfo",$conn);
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		$resource = mssql_execute($procedure,false);
		if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$return['zc_pt'] = number_format($row['zc_pt']);
			$return['zc_vip'] = number_format($row['zc_vip']);
			$return['wzq_pt'] = number_format($row['wzq_pt']);
			$return['wzq_vip'] = number_format($row['wzq_vip']);
		}
		mssql_free_statement($procedure);
		mssql_close($conn);

		return $return;

    }

    //修改密码
    public function ChangePWD(){
	if($_SESSION['zs78_admin2']['id']!=16 && $_SESSION['zs78_admin2']['id']!=18 && $_SESSION['zs78_admin2']['id']!=17){
		_location("无此权限",WEB_ROOT.'index.php/User');
	}
    	$UserID = $_GET['UserID'];
    	$this->assign('UserID',$UserID);
    	$this->display('changepwd');
    }

	//修改密码
    public function ChangePWD_do(){
	if($_SESSION['zs78_admin2']['id']!=16 && $_SESSION['zs78_admin2']['id']!=18 && $_SESSION['zs78_admin2']['id']!=17){
		_location("无此权限",WEB_ROOT.'index.php/User');
	}
    	$UserID = $_POST['UserID'];
    	$OperMasterID = $_SESSION['zs78_admin2']['id'];
    	$Type = $_POST['Type'];
    	$LogonPass = $_POST['LogonPass'];
    	$LogonAgain = $_POST['LogonAgain'];
    	$InsurePass = $_POST['InsurePass'];
    	$InsureAgain = $_POST['InsureAgain'];
    	$mssql = M();

    	$date_now = date('Y-m-d H:i:s');
    	$IP = GetIP();
    	if($Type==1){
    		if($LogonPass=='' || $LogonAgain=='' || $LogonPass!=$LogonAgain){
    			_location("输入错误",WEB_ROOT.'index.php/User/ChangePWD?UserID='.$UserID);
				return false;
    		}
    		$sql = 'update QPAccountsDB.dbo.AccountsInfo set LogonPass="'.strtolower(md5($LogonPass)).'" where UserID='.$UserID;
    	}
    	if($Type==2){
    		if($InsurePass=='' || $InsureAgain=='' || $InsurePass!=$InsureAgain){
    			_location("输入错误",WEB_ROOT.'index.php/User/ChangePWD?UserID='.$UserID);
				return false;
    		}
    		$sql = 'update QPAccountsDB.dbo.AccountsInfo set InsurePass="'.strtolower(md5($InsurePass)).'" where UserID='.$UserID;
    	}
    	if($Type==3){
    		if($LogonPass=='' || $LogonAgain=='' || $LogonPass!=$LogonAgain || $LogonPass=='' || $LogonAgain=='' || $LogonPass!=$LogonAgain){
    			_location("输入错误",WEB_ROOT.'index.php/User/ChangePWD?UserID='.$UserID);
				return false;
    		}
    		$sql = 'update QPAccountsDB.dbo.AccountsInfo set LogonPass="'.strtolower(md5($LogonPass)).'",InsurePass="'.strtolower(md5($InsurePass)).'" where UserID='.$UserID;
    	}

		if(!$mssql->query($sql)){
			if($LogonPass==''){
				$LogonPass = ' ';
			}else{
				$LogonPass = strtolower(md5($LogonPass));
			}
			if($InsurePass==''){
				$InsurePass = ' ';
			}else{
				$InsurePass = strtolower(md5($InsurePass));
			}
			$sql2 = 'INSERT INTO QPRecordDB.dbo.RecordPasswdExpend (OperMasterID,UserID,ReLogonPasswd,ReInsurePasswd,ClientIP,CollectDate) VALUES('.$OperMasterID.','.$UserID.',"'.$LogonPass.'","'.$InsurePass.'","'.$IP.'","'.$date_now.'")';
			$mssql->query($sql2);
			_location("修改成功",WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
			return;
		}else{
			_location("修改失败",WEB_ROOT.'index.php/User/ChangePWD?UserID='.$UserID);
		}
    }

    //当日赢的得分总 (*****)
    public function getDaySum($UserID){
    	$start_date = date('Y-m-d').' 00:00:00';
    	//$start_date = '2013-12-01 00:00:00';
    	$end_date = date('Y-m-d H:i:s');

    	$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);

		$procedure = mssql_init("PHP_UserWinGoldSum2",$conn);
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		$resource = mssql_execute($procedure);
		if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			//$rs['win_sum'] = number_format($row['win_sum']);
			//$rs['zc_pt'] = number_format($row['zc_pt']);
			$rs['zc_vip'] = $row['zc_vip'];
			$rs['zr_vip'] = $row['zr_vip'];
			$rs['wzq_pt'] = number_format($row['wzq_pt']);
			$rs['wzq_vip'] = number_format($row['wzq_vip']);
		}
		mssql_free_statement($procedure);
		mssql_close($conn);

		return $rs;
    }

	//daytotal
	public function GetDayTotal(){
		$UserID = $_GET['UserID'];
		$start_date = date('Y-m-d').' 00:00:00';
    	//$start_date = '2013-12-01 00:00:00';
    	$end_date = date('Y-m-d H:i:s');

    	$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);

		$procedure = mssql_init("PHP_UserDayTotal",$conn);
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
		if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			//$rs['win_sum'] = number_format($row['win_sum']);
			$rs['WinTotal'] = number_format($row['WinTotal']);
		}
		mssql_free_statement($procedure);
		mssql_close($conn);

		_location($rs['WinTotal'],WEB_ROOT."index.php/User/userInfo?UserID=".$UserID);
	}

	public function GetInout(){
		$UserID = $_GET['UserID'];
		$mssql=M();
		$sql='select sum(Score) as s FROM [QPTreasureDB].[dbo].[RecordUserInout](nolock) where UserID='.$UserID;
		$rs=$mssql->query($sql);

		_location($rs[0]['s'],WEB_ROOT."index.php/User/userInfo?UserID=".$UserID);
	}

    //正在游戏的房间
   public function game_room($UserID){
    	$mssql = M();
		$sql = 'select t2.ServerName,t3.KindName,t1.ServerID from QPTreasureDB.dbo.GameScoreLocker(NOLOCK) t1,QPPlatformDB.dbo.GameRoomInfo(NOLOCK) t2,QPPlatformDB.dbo.GameKindItem(NOLOCK) t3 where t1.ServerID=t2.ServerID and t1.KindID=t3.KindID and t1.UserID ='.$UserID;
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['GameName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
		}
		return $rs;
    }

    public function getResults($rs_user){
    	$rs = array();
    	$RegisterIP = $rs_user[0]['RegisterIP'];
    	$RegisterMachine = $rs_user[0]['RegisterMachine'];
    	$LastLogonIP = $rs_user[0]['LastLogonIP'];
    	$LastLogonMachine = $rs_user[0]['LastLogonMachine'];

    	$mssql = M();

		if($RegisterIP=='0.0.0.0'){
			$rs1[0]['num']=0;
			$rs1[0]['gold_sum']=0;
		}else{
			$sql1 = 'select count(t1.UserID) as num,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.RegisterIP =\''.$RegisterIP.'\'';
			$rs1 = $mssql->query($sql1);
		}

		$sql2 = 'select count(t1.UserID) as num,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.RegisterMachine =\''.$RegisterMachine.'\'';
		$rs2 = $mssql->query($sql2);

		if($LastLogonIP=='0.0.0.0'){
			$rs3[0]['num']=0;
			$rs3[0]['gold_sum']=0;
		}else{
			$sql3 = 'select count(t1.UserID) as num,sum(t2.Score+t2.InsureScore) as gold_sum from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.LastLogonIP =\''.$LastLogonIP.'\'';
			$rs3 = $mssql->query($sql3);
		}



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

    //转账记录  (*****)
    public function zz(){
    	$mssql = M();
    	$UserID = $_GET['UserID'];
    	if($_GET['Type']){
    		$Type=$_GET['Type'];
    	}else{
    		$Type=1;
    	}
    	if($_GET['Order']){
    		$Order=$_GET['Order'];
    	}else{
    		$Order=1;
    	}
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
    		$end_date = date('Y-m-d').' 23:59:59';
			$start_date = date("Y-m-d",strtotime("-1 day")).' 00:00:00';
    		//$start_date = date('Y-m-d').' 00:00:00';
    		$this->assign('start_date',$start_date);
			$this->assign('end_date',$end_date);
    		//$start_date = '2013-01-01 00:00:00';
    	}
  		$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();

		$procedure = mssql_init("PHP_ZzRecordCount",$conn);

		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@Type", $Type, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
    	if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$count = $row['zz_count'];
			//echo $count;
		}
		mssql_free_statement($procedure);


		$procedure2 = mssql_init("PHP_UserZzList2",$conn);

		mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure2,"@Type",$Type,SQLINT4);
		mssql_bind($procedure2,"@Order", $Order, SQLINT4);
		mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
		mssql_bind($procedure2,"@pageNo", $pageNo, SQLINT4);
		mssql_bind($procedure2,"@pageSize", $pageSize, SQLINT4);

		$resource2 = mssql_execute($procedure2);
			while($row2 = mssql_fetch_assoc($resource2)){
				$rs[] = $row2;
			}
		mssql_free_statement($procedure2);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);

			if($rs[$i]['SourceUserID']==$UserID){
				$rs[$i]['Gold']=$rs[$i]['SourceGold'];
				$rs[$i]['Bank']=$rs[$i]['SourceBank']-$rs[$i]['SwapScore'];
			}else{
				$rs[$i]['Gold']=$rs[$i]['TargetGold'];
				$rs[$i]['Bank']=$rs[$i]['TargetBank']+$rs[$i]['SwapScore']-$rs[$i]['Revenue'];
			}
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
			$rs[$i]['Gold'] = number_format($rs[$i]['Gold']);
			$rs[$i]['Bank'] = number_format($rs[$i]['Bank']);
			if($this->checkCancel($rs[$i]['RecordID'])==1){
                $rs[$i]['isCancel']=1;
            }else{
				$rs[$i]['isCancel']=0;
			}

		}
		//print_r($rs);
		$pageNum = ceil($count/$pageSize);
		$this->assign('Type',$Type);
		$this->assign('Order',$Order);
    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);
    	$this->display('user_zz');
    }

	//撤销转账
    public function cancelInsure(){
        if($_SESSION['zs78_admin2']['id']!=16&&$_SESSION['zs78_admin2']['id']!=18&&$_SESSION['zs78_admin2']['id']!=19){
            _location('无此权限',WEB_ROOT.'index.php/User');
            return;
        }
		$UserID = $_GET['UserID'];
        if(isset($_GET['RecordID'])){
            $RecordID = $_GET['RecordID'];
        }else{
            _location('id不能为空',WEB_ROOT.'index.php/User');
            return;
        }
        if(isset($_GET['reason'])){
            $reason = iconv("UTF-8","GBK",$_GET['reason']);
        }else{
             _location('备注不能为空',WEB_ROOT.'index.php/User');
            return;
        }
        $mssql = M();
        $manage = $_SESSION['zs78_admin2']['username'];
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);

        $procedure = mssql_init("PHP_UserCancelInsure",$conn);
        mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
        mssql_bind($procedure,"@RecordID",$RecordID,SQLINT4);
        //var_dump(mssql_execute($procedure));
        //exit;
        $resource = mssql_execute($procedure);
        if(!$resource){
            _location('条件错误',WEB_ROOT.'index.php/User/zz?UserID='.$UserID);
            return;
        }
        if($ret == 0){
            $sql = 'update QPTreasureDB.dbo.CancelInsure set CollectNote="'.$reason.'",Manager="'.$manage.'" where RecordID='.$RecordID;
            $mssql->query($sql);
            _location('撤销成功',WEB_ROOT.'index.php/User/zz?UserID='.$UserID);
            return;
        }else{
            _location('当前正在游戏房间中',WEB_ROOT.'index.php/User/zz?UserID='.$UserID);
            return;
        }
        mssql_free_statement($procedure);
        mssql_close($conn);
    }

	//存取记录  (*****)
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
    		$start_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d'))-3600*24);
    		$this->assign('start_date',date('Y-m-d'));
			$this->assign('end_date',date('Y-m-d'));
    		//$start_date='2013-12-01 00:00:00';
    	}
  		$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();

		$procedure = mssql_init("PHP_CqRecordCount",$conn);

		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
    	if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$count = $row['cq_count'];
		}
		mssql_free_statement($procedure);

		$procedure2 = mssql_init("PHP_UserCqList",$conn);
		mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
		mssql_bind($procedure2,"@pageNo", $pageNo, SQLINT4);
		mssql_bind($procedure2,"@pageSize", $pageSize, SQLINT4);

		$resource2 = mssql_execute($procedure2);
		while($row2 = mssql_fetch_assoc($resource2)){
			$rs[] = $row2;
		}
		mssql_free_statement($procedure2);
		mssql_close($conn);

    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['GameName'] = iconv("GBK","UTF-8",$rs[$i]['GameName']);
			if($rs[$i]['GameName'] == ''){$rs[$i]['GameName']='大厅';};
			$rs[$i]['sum'] = $rs[$i]['SourceGold']+$rs[$i]['SourceBank'];
			$rs[$i]['sum'] = number_format($rs[$i]['sum']);
			$rs[$i]['SourceGold'] = number_format($rs[$i]['SourceGold']);
			$rs[$i]['SourceBank'] = number_format($rs[$i]['SourceBank']);
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
		}
		$pageNum = ceil($count/$pageSize);

    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);
    	$this->display('user_cq');
    }

	//进出记录
    public function inout(){
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
            $end_date = date('Y-m-d').' 23:59:59';
            $start_date = date('Y-m-d').' 00:00:00';
            $this->assign('start_date',date('Y-m-d'));
            $this->assign('end_date',date('Y-m-d'));
            //$start_date='2013-12-01 00:00:00';
        }
        $rs=array();
        $conn2=_open(2);
        $rs2 = array();

        $procedure2 = mssql_init("PHP_UserInoutList",$conn2);

        mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
        $resource2 = mssql_execute($procedure2);
        while($row2 = mssql_fetch_assoc($resource2)){
        	$row2['type']=2;
            $rs2[] = $row2;
        }
        mssql_free_statement($procedure2);

        $conn3=_open(3);
        $rs3 = array();

        $procedure3 = mssql_init("PHP_UserInoutList",$conn3);

        mssql_bind($procedure3,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure3,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure3,"@end_date", $end_date, SQLVARCHAR);
        $resource3 = mssql_execute($procedure3);
        while($row3 = mssql_fetch_assoc($resource3)){
        	$row3['type']=3;
            $rs3[] = $row3;
        }
        mssql_free_statement($procedure3);

        $conn4=_open(4);
        $rs4 = array();

        $procedure4 = mssql_init("PHP_UserInoutList",$conn4);

        mssql_bind($procedure4,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure4,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure4,"@end_date", $end_date, SQLVARCHAR);
        $resource4 = mssql_execute($procedure4);
        while($row4 = mssql_fetch_assoc($resource4)){
        	$row4['type']=4;
            $rs4[] = $row4;
        }
        mssql_free_statement($procedure4);

		$conn5=_open(5);
        $rs5 = array();

        $procedure5 = mssql_init("PHP_UserInoutList",$conn5);

        mssql_bind($procedure5,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure5,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure5,"@end_date", $end_date, SQLVARCHAR);
        $resource5 = mssql_execute($procedure5);
        while($row5= mssql_fetch_assoc($resource5)){
        	$row5['type']=5;
            $rs5[] = $row5;
        }
        mssql_free_statement($procedure5);

		$conn6=_open(6);
        $rs6 = array();
        //var_dump($conn6);
        $procedure6 = mssql_init("PHP_UserInoutList",$conn6);

        mssql_bind($procedure6,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure6,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure6,"@end_date", $end_date, SQLVARCHAR);
        $resource6 = mssql_execute($procedure6);
        while($row6= mssql_fetch_assoc($resource6)){
        	$row6['type']=6;
            $rs6[] = $row6;
        }
		//var_dump($rs6);
        mssql_free_statement($procedure6);

		$conn7=_open(7);

        $rs7 = array();

        $procedure7 = mssql_init("PHP_UserInoutList",$conn7);

        mssql_bind($procedure7,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure7,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure7,"@end_date", $end_date, SQLVARCHAR);
        $resource7 = mssql_execute($procedure7);
        while($row7= mssql_fetch_assoc($resource7)){
        	$row7['type']=7;
            $rs7[] = $row7;
        }
        mssql_free_statement($procedure7);

        mssql_close($conn2);
        mssql_close($conn3);
        mssql_close($conn4);
		mssql_close($conn5);
		mssql_close($conn6);
		mssql_close($conn7);
        $rs=array_merge_recursive($rs2,$rs3,$rs4,$rs5,$rs6,$rs7);
        foreach ($rs as $key => $row) {
			$volume[$key] = $row['RecordID'];
		}
 		array_multisort($volume,SORT_DESC,SORT_NUMERIC,$rs);
        //print_r($rs);
        //print_r($rs3);
        //print_r($rs4);
        //exit;

        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
            $rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
            $rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
            $rs[$i]['EnterScore'] = number_format($rs[$i]['EnterScore']);
			$rs[$i]['EnterInsure'] = number_format($rs[$i]['EnterInsure']);
            $rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['Insure'] = number_format($rs[$i]['Insure']);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('UserID',$UserID);
        $this->assign('result',$rs);
        $this->display('user_inout');
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
		$start_date=date('Y-m-d').' 00:00:00';
		$end_date = date('Y-m-d H:i:s');
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();

		$procedure = mssql_init("PHP_CzRecordCount",$conn);

		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
    	if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$count = $row['cz_count'];
		}
		mssql_free_statement($procedure);

		$procedure2 = mssql_init("PHP_UserCzList",$conn);
		mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);

		$resource2 = mssql_execute($procedure2);
		while($row2 = mssql_fetch_assoc($resource2)){
			$rs[] = $row2;
		}
		mssql_free_statement($procedure2);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['BeforeGold'] = number_format($rs[$i]['BeforeGold']);
			$rs[$i]['BeforeGold'] = number_format($rs[$i]['BeforeGold']);
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
		}
		$pageNum = ceil($count/$pageSize);
		$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);
    	$this->display('user_recharge');
    }

    //游戏记录
    public function yx(){
		header('Content-type: text/html; charset=utf8');
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
  		$pageSize = 50;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		/*
		$procedure3 = mssql_init("PHP_UpdateGameInfo",$conn);
		mssql_execute($procedure3);
		mssql_free_statement($procedure);
		*/
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
			//$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);
		}
		$pageNum = ceil($count/$pageSize);

    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);
    	$this->display('user_yx');
    }

    //游戏记录
    public function UserGameInfo(){
    	$RecordID = $_GET['RecordID'];
    	$type=$_GET['type'];
    	$conn=_open(intval($type));
    	//$conn=mssql_connect($GLOBALS['DB_RECORD_9']['DB_HOST'],$GLOBALS['DB_RECORD_9']['DB_USER'],$GLOBALS['DB_RECORD_9']['DB_PWD']);
		//mssql_select_db($GLOBALS['DB_RECORD_9']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_UserGameInfo",$conn);
		mssql_bind($procedure,"@RecordID", $RecordID, SQLVARCHAR);
		$resource = mssql_execute($procedure);
		//var_dump($resource);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
		//var_dump($conn);
		$zong=0;
    	for($i=0;$i<count($rs);$i++){
			$zong+=$rs[$i]['Score'];
    		$rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
    		$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['TableID'] = $rs[$i]['TableID']+1;
			if($rs[$i]['UserCount']>1){
				$result[$i]['UserID']=explode('/',substr($rs[$i]['UserIDInfo'],0,-1));
    			$result[$i]['NickName']=explode('/',substr(iconv("GBK","UTF-8",$rs[$i]['NickInfo']),0,-1)) ;
    			$result[$i]['Score']=explode('/',substr($rs[$i]['ScoreInfo'],0,-1));
    			for($j=0;$j<$rs[$i]['UserCount'];$j++){
    				$rs[$i]['users'][$j]['UserID']=$result[$i]['UserID'][$j];
    				$rs[$i]['users'][$j]['NickName']=$result[$i]['NickName'][$j];
    				$rs[$i]['users'][$j]['Score']=$result[$i]['Score'][$j];
    			}
			}
			//$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);
		}
		$zong = number_format($zong);
		//print_r($rs);
		$this->assign('zong',$zong);
		$this->assign('result',$rs);
    	$this->display('user_game');
    }

	//游戏记录
    public function yx_old(){
		header('Content-type: text/html; charset=utf8');
    	$UserID = $_GET['UserID'];
    	if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
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
    		$this->assign('start_date',date('Y-m-d'));
			$this->assign('end_date',date('Y-m-d'));
    	}
  		$pageSize = 50;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

		$conn=mssql_connect($GLOBALS['DB_YX']['DB_HOST'],$GLOBALS['DB_YX']['DB_USER'],$GLOBALS['DB_YX']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_YX']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_YxRecordCount",$conn);

		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
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
			//$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);
		}
		$pageNum = ceil($count/$pageSize);

    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);
    	$this->display('user_yx_old');
    }

	//详细游戏记录
    public function yx2(){
		header('Content-type: text/html; charset=utf8');
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
  		$pageSize = 50;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		/*
		$procedure3 = mssql_init("PHP_UpdateGameInfo",$conn);
		mssql_execute($procedure3);
		mssql_free_statement($procedure);
		*/
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
    	$this->display('user_yx2');
    }

    //五子棋游戏记录 (*****)
    public function yx_wzq(){
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
    		//$start_date='2012-12-01 00:00:00';
    	}
  		$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();

		$procedure = mssql_init("PHP_WzqRecordCount",$conn);

		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
    	if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$count = $row['wzq_count'];
		}
		mssql_free_statement($procedure);

		$procedure2 = mssql_init("PHP_UserWzqList",$conn);
		mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
		mssql_bind($procedure2,"@pageNo", $pageNo, SQLINT4);
		mssql_bind($procedure2,"@pageSize", $pageSize, SQLINT4);

		$resource2 = mssql_execute($procedure2);
		while($row2 = mssql_fetch_assoc($resource2)){
			$rs[] = $row2;
		}
		mssql_free_statement($procedure2);
		mssql_close($conn);

    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['game'] = '五子棋';
    		//$rs[$i]['room'] = $result[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);
		}
		$pageNum = ceil($count/$pageSize);

    	$this->assign('pageNum',$pageNum);
		$this->assign('UserID',$UserID);
		$this->assign('result',$rs);
    	$this->display('yx_wzq');
    }

	//真人对战游戏记录 (*****)
    public function yx_dz(){
    	$UserID = $_GET['UserID'];
    	if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
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
    		//$start_date='2012-12-01 00:00:00';
    	}
  		$pageSize = 50;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();

		$procedure = mssql_init("PHP_DzRecordCount",$conn);

		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
    	if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$count = $row['yx_count'];
		}
		mssql_free_statement($procedure);

		$procedure2 = mssql_init("PHP_UserDzList",$conn);
		mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
		mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
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
    	$this->display('yx_dz');
    }

    //详细游戏记录  (*****)
    public function getGameList($DrawID){
    	$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_UserYxInfo",$conn);
		mssql_bind($procedure,"@DrawID", $DrawID, SQLINT4);
    	$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
    	mssql_close($conn);

    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
		}
    	return $rs;

    }

	//详细游戏记录  (*****)
    public function getGameList2(){
		header('Content-type: text/html; charset=utf8');
		$DrawID = intval($_GET['DrawID']);
    	$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_UserYxInfo",$conn);
		mssql_bind($procedure,"@DrawID", $DrawID, SQLINT4);
    	$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
    	mssql_close($conn);

    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
		}
    	echo json_encode($rs);

    }

	public function test33(){
	$date = date('Y-m-d H:i:s');
	$days = 6666;
		echo date('Y-m-d H:i:s',strtotime($date . '+'.$days.' day'));
	}

    //解锁用户
    public function  clearUserByGameId() {
    	$GameID=$_GET['GameID'];

    	$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
		var_dump($conn);
		//$UserID='824154';
		$procedure = mssql_init("PHP_IF_UnLockUserLogon",$conn);  //存储过程名字
		mssql_bind($procedure,"@dbGameID", $GameID, SQLINT4);
		var_dump($procedure);
		$resource = mssql_execute($procedure,false);
		var_dump($resource);
//		$resource = mssql_execute($procedure);
//		mssql_free_statement($procedure);
//		mssql_close($conn);
//		return $rs;
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

    	if($_GET['num']){
    		$num = $_GET['num'];
    	}else{
    		$num = 100;
    	}
    	$mssql = M();
    	$sql = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where IsAndroid=0';
		$rs = $mssql->query($sql);
		$count = $num>=$rs[0]['num'] ? $rs[0]['num']:$num;
		$pageNum = ceil($num/$pageSize)>=ceil($rs[0]['num']/$pageSize) ? ceil($rs[0]['num']/$pageSize) : ceil($num/$pageSize);
    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    		$sum = $count;
    	}else{
    		$num=$pageSize;
			$sum=$pageNo*$pageSize;
    	}
    	//exit;
    	if($type==1){
    		$sql3 = 'SELECT UserID,Score,InsureScore,gold_sum,GameID,Accounts,NickName,MemberOrder FROM (SELECT TOP ('.$num.') UserID,Score,InsureScore,gold_sum,GameID,Accounts,NickName,MemberOrder ';
    		$sql3.= 'FROM (SELECT TOP ('.$sum.') t1.UserID,t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum,t2.GameID,t2.Accounts,t2.NickName,t2.MemberOrder FROM QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID=t2.UserID ';
    		$sql3.= 'where t2.IsAndroid = 0 and t2.SpreaderID=0 order by Score desc) t4 order by  Score  asc) t5 order by Score desc';
    	}elseif ($type==2) {
    		$sql3 = 'SELECT UserID,Score,InsureScore,gold_sum,GameID,Accounts,NickName,MemberOrder FROM (SELECT TOP ('.$num.') UserID,Score,InsureScore,gold_sum,GameID,Accounts,NickName,MemberOrder ';
    		$sql3.= 'FROM (SELECT TOP ('.$sum.') t1.UserID,t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum,t2.GameID,t2.Accounts,t2.NickName,t2.MemberOrder FROM QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID=t2.UserID ';
    		$sql3.= 'where t2.IsAndroid = 0 and t2.SpreaderID=0 order by InsureScore desc) t4 order by  InsureScore  asc) t5 order by InsureScore desc';
    	}elseif ($type==3) {
    		$sql3 = 'SELECT UserID,Score,InsureScore,gold_sum,GameID,Accounts,NickName,MemberOrder FROM (SELECT TOP ('.$num.') UserID,Score,InsureScore,gold_sum,GameID,Accounts,NickName,MemberOrder ';
    		$sql3.= 'FROM (SELECT TOP ('.$sum.') t1.UserID,t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum,t2.GameID,t2.Accounts,t2.NickName,t2.MemberOrder FROM QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID=t2.UserID ';
    		$sql3.= 'where t2.IsAndroid = 0 and t2.SpreaderID=0 order by gold_sum desc) t4 order by  gold_sum  asc) t5 order by gold_sum desc';
    	}
		$result = $mssql->query($sql3);

    	for($i=0;$i<count($result);$i++){
			$result[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$goldSum['Score'] = $goldSum['Score']+$result[$i]['Score'];
			$goldSum['InsureScore'] = $goldSum['InsureScore']+$result[$i]['InsureScore'];
			$result[$i]['Score'] = number_format($result[$i]['Score']);
			$result[$i]['InsureScore'] = number_format($result[$i]['InsureScore']);
			$result[$i]['gold_sum'] = number_format($result[$i]['gold_sum']);
			$result[$i]['Accounts'] = iconv("GBK","UTF-8",$result[$i]['Accounts']);
			$result[$i]['NickName'] = iconv("GBK","UTF-8",$result[$i]['NickName']);
		}
		$goldSum['gold_sum'] = $goldSum['Score']+$goldSum['InsureScore'];
		$goldSum['Score'] = number_format($goldSum['Score']);
		$goldSum['InsureScore'] = number_format($goldSum['InsureScore']);
		$goldSum['gold_sum'] = number_format($goldSum['gold_sum']);
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
    	}elseif ($type == 2) {
    		$sql = 'select SUM(Score) as Score,SUM(InsureScore) as InsureScore,SUM(gold_sum) as gold_sum from (select top ('.$num.') t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.IsAndroid = 0 order by InsureScore desc) t3';
    	}elseif ($type == 3) {
    		$sql = 'select SUM(Score) as Score,SUM(InsureScore) as InsureScore,SUM(gold_sum) as gold_sum from (select top ('.$num.') t1.Score,t1.InsureScore,t1.Score+t1.InsureScore as gold_sum from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.IsAndroid = 0 order by gold_sum desc) t3';
    	}
		$result = $mssql->query($sql);
		$result[0]['Score'] = number_format($result[0]['Score']);
		$result[0]['InsureScore'] = number_format($result[0]['InsureScore']);
		$result[0]['gold_sum'] = number_format($result[0]['gold_sum']);
		return $result[0];
    }

    //获取游戏名称
    public function getGameName($ServerID){

    	$mssql = M();
    	$sql = 'SELECT t1.ServerName,t2.KindName from QPPlatformDB.dbo.GameRoomInfo(NOLOCK) t1 left join QPPlatformDB.dbo.GameKindItem(NOLOCK) t2 on t1.GameID = t2.GameID WHERE t1.ServerID = '.$ServerID;
    	$rs = $mssql->query($sql);
    	$ServerName = iconv("GBK","UTF-8",$rs[0]['ServerName']);
    	$rs[0]['game'] = iconv("GBK","UTF-8",$rs[0]['KindName']).'--'.substr($ServerName,0,strpos($ServerName,'-'));
		return $rs[0]['game'];
    }

    //ip查询
    public function ip(){
    	$this->display('ip_search');
    }

	//ip搜索
    public function ip_search(){

		$UserID = $_GET['UserID'];
		$user = D('AccountsInfo');
		$user_info = $user->where('UserID ='.$UserID)->find();
		$this->assign('user_info',$user_info);

    	$type = $_GET['type'];
    	$con = $_GET['con'];
    	$mssql = M();
    	if($type == 1){

			$sql= 'SELECT top 200 t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.CustomFaceVer,t1.Nullity,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.RegisterIP =\''.$con.'\' order by LastLogonDate desc';
    	}
    	if($type == 2){
			$sql= 'SELECT top 200 t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.CustomFaceVer,t1.Nullity,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.RegisterMachine =\''.$con.'\' order by LastLogonDate desc';
    	}
    	if($type == 3){
			$sql= 'SELECT top 200 t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.CustomFaceVer,t1.Nullity,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.LastLogonIP =\''.$con.'\' order by LastLogonDate desc';
    	}
    	if($type == 4){
			$sql= 'SELECT top 200 t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.CustomFaceVer,t1.Nullity,t2.Score,t2.InsureScore,t2.Score+t2.InsureScore as gold_sum,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
			$sql.= 'from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql.= 'where t1.LastLogonMachine =\''.$con.'\' order by LastLogonDate desc';
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
			$result[$i]['Accounts'] = iconv("GBK","UTF-8",$result[$i]['Accounts']);
			$result[$i]['NickName'] = iconv("GBK","UTF-8",$result[$i]['NickName']);
		}

		$this->assign('con',$con);
		$this->assign('type',$type);
    	$this->assign('rs',$rs);
    	$this->assign('result',$result);
    	$this->display('ip_result');
    }

	//指导费查询 (*****)
	public function wzq(){
		$mssql = M();
		if($_GET['start_date']&&$_GET['end_date']){
    		$date1 = $_GET['start_date'];
			$date2 = $_GET['end_date'];
			$date3 = strtotime($date1);
			$date4 = strtotime($date2);
			if($date3>=$date4){
				$start_date = $date2.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
				$this->assign('start',$date2);
				$this->assign('end',$date1);
			}else{
				$start_date = $date1.' 00:00:00';
				$end_date = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
				$this->assign('start',$date1);
				$this->assign('end',$date2);
			}
    	}else{
    		$end = date('Y-m-d');
    		//$start = date('Y-m-d',strtotime($end)-3600*24);
    		$end_date = $end.' 23:59:59';
    		$start_date = $end.' 00:00:00';
    		$this->assign('start',$end);
			$this->assign('end',$end);
    	}
    	if($_GET['type_zz']){
			$type_zz = $_GET['type_zz'];
		}else{
			$type_zz = 1;
		}

		if($_GET['type_id']){
			$type_id = $_GET['type_id'];
		}else{
			$type_id = 1;
		}
		$conn=_open(4);
    	if($type_id ==1){
    		//$sql1 = 'select count(DrawID) as num,SUM(Score) as gold_sum from QPTreasureDB.dbo.RecordDrawScore(NOLOCK) where DrawID in (select DrawID from QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID = 401) and InsertTime between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) and Score>0';
			//$rs = $mssql->query($sql1);
			//$count = $rs[0]['num'];

    		$procedure = mssql_init("php_wzq_record_list",$conn);
			mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
			mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
			$resource = mssql_execute($procedure);
    		$result = array();
			if ( mssql_num_rows($resource) != 0 ) {
				while($row=mssql_fetch_assoc($resource)){
					$result[] = $row;
				}
			}
			mssql_free_statement($procedure);
			mssql_close($conn);
    		for($i=0;$i<count($result);$i++){
    			$result[$i]['no'] = $i+1;
    			$gold_sum=$gold_sum+$result[$i]['Score']*(-1);
    			$result[$i]['Score'] = number_format($result[$i]['Score']*(-1));
    			$result[$i]['UserID']=explode('/',substr($result[$i]['UserIDInfo'],0,-1));
    			$result[$i]['NickName']=explode('/',substr(iconv("GBK","UTF-8",$result[$i]['NickInfo']),0,-1)) ;
    			$result[$i]['SourceUserID']=$result[$i]['UserID'][0];
    			$result[$i]['TargetUserID']=$result[$i]['UserID'][1];
    			$result[$i]['SourceNick']=$result[$i]['NickName'][0];
    			$result[$i]['TargetNick']=$result[$i]['NickName'][1];

    		}
			//print_r($result);
    	}elseif ($type_id ==2){
    		if($_GET['GameID'] == null || $_GET['GameID'] == ''){
    			_location('请输入GameID',WEB_ROOT.'index.php/Index/wzq');
				return false;
    		}
    		$GameID = $_GET['GameID'];
    		$this->assign('GameID',$GameID);
    		$result2 = $this->getInfoByGameID($GameID);
    		$UserID = $result2['UserID'];

			$procedure2 = mssql_init("php_wzq_user_list",$conn);
			mssql_bind($procedure2,"@type", $type_zz, SQLINT4);
			mssql_bind($procedure2,"@UserID", $UserID, SQLINT4);
			mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
			mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);

			$resource2 = mssql_execute($procedure2);
			while($row2 = mssql_fetch_assoc($resource2)){
				$result[] = $row2;
			}
			mssql_free_statement($procedure2);
			mssql_close($conn);
    		for($i=0;$i<count($result);$i++){
    			$result[$i]['no'] = $i+1;
    			$gold_sum=$gold_sum+abs($result[$i]['Score']);
    			$result[$i]['Score'] = number_format(abs($result[$i]['Score']));
    			$result[$i]['UserID']=explode('/',substr($result[$i]['UserIDInfo'],0,-1));
    			$result[$i]['NickName']=explode('/',substr(iconv("GBK","UTF-8",$result[$i]['NickInfo']),0,-1)) ;
    			$result[$i]['SourceUserID']=$result[$i]['UserID'][0];
    			$result[$i]['TargetUserID']=$result[$i]['UserID'][1];
    			$result[$i]['SourceNick']=$result[$i]['NickName'][0];
    			$result[$i]['TargetNick']=$result[$i]['NickName'][1];

    		}
    	}
    	$gold_sum = number_format($gold_sum);

    	$pageNum = ceil($rs[0]['num']/$pageSize);
    	$this->assign('type_zz',$type_zz);
    	$this->assign('type_id',$type_id);
    	$this->assign('pageNum',$pageNum);
		$this->assign('gold_sum',$gold_sum);
    	$this->assign('result',$result);
		$this->display('wzq');
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

	//获取用户信息
    public function getInfoByGameID($GameID){
    	$mssql = M();
    	$sql = 'select UserID,GameID,Accounts,NickName from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID = '.$GameID;
    	$result = $mssql->query($sql);
    	$result[0]['Accounts'] = iconv("GBK","UTF-8",$result[0]['Accounts']);
		$result[0]['NickName'] = iconv("GBK","UTF-8",$result[0]['NickName']);
    	return $result[0];
    }

    //检查是否是银商
    public function check_vip($GameID){
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$sql2 = 'select count(UserID) as num from vip_member(NOLOCK) where GameID = '.$GameID;
    	$rs2 = $sqlite->query($sql2)->fetchAll();
    	if($rs2[0]['num'] == 1){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    //手机新注册列表
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

		$sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where LastLogonMobile !="" AND RegisterDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100)';
		$rs1 = $mssql->query($sql1);
		$count = $rs1[0]['num'];
    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}


    	$sql2 = 'SELECT UserID,GameID,Accounts,NickName,LastLogonMobile,RegisterMobile,RegisterDate FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,LastLogonMobile,RegisterMobile,RegisterDate FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') UserID,GameID,Accounts,NickName,LastLogonMobile,RegisterMobile,CONVERT(varchar,RegisterDate,120) as RegisterDate ';
    	$sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) WHERE LastLogonMobile !="" AND RegisterDate between CONVERT(varchar,"'.$start_date.'",100) and CONVERT(varchar,"'.$end_date.'",100) order by RegisterDate desc) t1 order by RegisterDate asc) t2 order by RegisterDate desc';
		$rs2 = $mssql->query($sql2);


    	for($i=0;$i<count($rs2);$i++){
    		$rs2[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
    		$rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
    		$rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
    		$rs2[$i]['num'] = $this->getTelRe($rs2[$i]['LastLogonMobile']);

		}
		$pageNum = ceil($count/$pageSize);
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs2);
    	$this->display('tel_re');

    }

	//手机注册账号的注册数
	public function getTelRe($RegisterMobile){
		$mssql = M();
		$sql = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where RegisterMobile ="'.$RegisterMobile.'"';
		$rs = $mssql->query($sql);
		return $rs[0]['num'];
	}

	//获取该用户输赢金币数  (*****)
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
    	$RegisterMobile = $_GET['RegisterMobile'];
    	$mssql = M();
		$sql = 'select UserID,GameID,Accounts,NickName,LastLogonMobile,CONVERT(varchar,RegisterDate,120) as RegisterDate from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where RegisterMobile ="'.$RegisterMobile.'" order by RegisterDate desc';
		$rs = $mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
    		$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
    		$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
    		//$rs[$i]['wl'] = $this->getUserScore($rs[$i]['UserID']);
		}

		$this->assign('result',$rs);
		$this->display('tel_re_info');

    }

    //当天转账记录  (*****)
    public function zz_list(){
    	$mssql = M();
    	if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		//$start_date = date("Y-m-d",strtotime("-1 day")).' 00:00:00';

    	//$start_date='2013-01-01';
    	//$end_date = '2014-05-01';
    	$pageSize = 50;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

    	if($_GET['type']){
			$type = $_GET['type'];
		}else{
			$type = 1;
		}
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();

		$procedure = mssql_init("PHP_UserZzDayCount",$conn);

		mssql_bind($procedure,"@type", $type, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
    	if($row = mssql_fetch_assoc($resource)){
				//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$count = $row['zz_count'];
		}
		mssql_free_statement($procedure);

		$procedure2 = mssql_init("PHP_UserZzDayList",$conn);
		mssql_bind($procedure2,"@type", $type, SQLINT4);
		mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
		mssql_bind($procedure2,"@pageNo", $pageNo, SQLINT4);
		mssql_bind($procedure2,"@pageSize", $pageSize, SQLINT4);

		$resource2 = mssql_execute($procedure2);
		while($row2 = mssql_fetch_assoc($resource2)){
			$rs[] = $row2;
		}
		mssql_free_statement($procedure2);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
			if($rs[$i]['SwapScore']>=100000000){
				$rs[$i]['color']=3;
			}elseif($rs[$i]['SwapScore']>=10000000){
				$rs[$i]['color']=2;
			}else{
				$rs[$i]['color']=1;
			}
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
		}

		$pageNum = ceil($count/$pageSize);
		//$gold_sum = $this->getUserGold();
		//$this->assign('gold_sum',$gold_sum);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('type',$type);
    	$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs);
    	$this->display('zz_list');

    }

	//最近100条转账
	public function zz_list2(){

		if($_GET['type']){
			$type = $_GET['type'];
		}else{
			$type = 1;
		}

		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_UserTopZzList",$conn);
		mssql_bind($procedure,"@type", $type, SQLINT4);

		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}

		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
			if($rs[$i]['SwapScore']>=100000000){
				$rs[$i]['color']=3;
			}elseif($rs[$i]['SwapScore']>=10000000){
				$rs[$i]['color']=2;
			}else{
				$rs[$i]['color']=1;
			}
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);

			$rs[$i]['Place1'] = $this->getIpPlace($rs[$i]['LastLogonIP1']);
			$rs[$i]['Place2'] = $this->getIpPlace($rs[$i]['LastLogonIP2']);
		}
		//$gold_sum = $this->getUserGold();
		//$this->assign('gold_sum',$gold_sum);
		$this->assign('type',$type);
		$this->assign('result',$rs);
    	$this->display('zz_list2');

    }

	//最近100条转账
	public function zz_list33(){

		if($_GET['type']){
			$type = $_GET['type'];
		}else{
			$type = 1;
		}
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_UserTopZzList",$conn);
		mssql_bind($procedure,"@type", $type, SQLINT4);
		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
			if($rs[$i]['SwapScore']>=100000000){
				$rs[$i]['color']=3;
			}elseif($rs[$i]['SwapScore']>=10000000){
				$rs[$i]['color']=2;
			}else{
				$rs[$i]['color']=1;
			}
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
		}
		//$gold_sum = $this->getUserGold();
		//$this->assign('gold_sum',$gold_sum);
		$this->assign('type',$type);
		$this->assign('result',$rs);
    	$this->display('zz_list33');

    }

	//vip UserID拼接字符串 加上过滤的
    public function getVipIds2(){
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	//vip账号UserID
		$sql = 'select UserID from vip_member group by UserID';
    	$rs = $sqlite->query($sql)->fetchAll();
    	$ids = $rs[0]['UserID'];
		for($i=1;$i<count($rs);$i++){
			if($rs[$i]['UserID'] != $rs[$i-1]['UserID']){
				$ids = $ids.','.$rs[$i]['UserID'];
			}
    	}
    	$sql2 = 'select UserID from filter_user where Type=3';
    	$rs2 = $sqlite->query($sql2)->fetchAll();
    	$ids2 = $rs2[0]['UserID'];
		for($j=1;$j<count($rs2);$j++){
			if($rs2[$j]['UserID'] != $rs2[$j-1]['UserID']){
				$ids2 = $ids2.','.$rs2[$j]['UserID'];
			}
    	}
    	return $ids.','.$ids2;
    }

	//过滤所有非真实账户
    public function getVipIds3(){
    	$ids1 = $this->getVipIds2();
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
		$sql = 'select UserID from filter_user where Type=2';
    	$rs = $sqlite->query($sql)->fetchAll();
    	$ids2 = $rs[0]['UserID'];
		for($i=1;$i<count($rs);$i++){
			if($rs[$i]['UserID'] != $rs[$i-1]['UserID']){
				$ids2 = $ids2.','.$rs[$i]['UserID'];
			}
    	}
    	return $ids1.','.$ids2;
    }


   //封号记录
   public function fh_list(){
   		$mssql = M();
    	$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

    	$sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) WHERE  Nullity = 1';
		$rs1 = $mssql->query($sql1);
		$count = $rs1[0]['num'];

    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}

    	$sql2 = 'SELECT UserID,GameID,Accounts,NickName,LastLogonDate,Score,InsureScore FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,LastLogonDate,Score,InsureScore FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Score,t2.InsureScore,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
    	$sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
    	$sql2.= 'WHERE t1.Nullity = 1 order by LastLogonDate desc) t4 order by LastLogonDate asc) t5 order by LastLogonDate desc';
		$rs2 = $mssql->query($sql2);

    	for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
			$rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
			$rs2[$i]['gold_sum'] = $rs2[$i]['Score']+$rs2[$i]['InsureScore'];
			$rs2[$i]['Score'] = number_format($rs2[$i]['Score']);
			$rs2[$i]['InsureScore'] = number_format($rs2[$i]['InsureScore']);
			$rs2[$i]['gold_sum'] = number_format($rs2[$i]['gold_sum']);
		}
		$pageNum = ceil($count/$pageSize);

    	$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs2);
    	$this->display('fh_list');
   }

	//清除卡线 type=5
   public function kaxian(){
   		$UserID = $_GET['UserID'];
   		$ServerID = $_GET['ServerID'];
   		$InsertTime = date('Y-m-d H:i:s');
   		$mssql = M();
   		$sql = 'delete QPTreasureDB.dbo.GameScoreLocker where ServerID = '.$ServerID.' and UserID ='.$UserID;
   		//$sql2 = 'delete QPTreasureDB.dbo.GameLockByDong where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',5,"'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }

   //封号 type=1
   public function fenghao(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
   		$reason = iconv("UTF-8","GBK",$_GET['reason']);

   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set Nullity=1 where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,Reason,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',1,"'.$reason.'","'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }

	//解封  type=2
   public function jiefeng(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set Nullity=0 where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',2,"'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }

	//锁定机器  type=3
   public function suoding(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set MoorMachine=1 where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',3,"'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }

	//解除机器锁定 type=4
   public function jiesuo(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set MoorMachine=0 where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',4,"'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }
   //解除手机绑定 type=7
   public function jiebang(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set RegisterMobile="" where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',7,"'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }
   //大厅登录屏蔽 type=8
   public function pingbi(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
		$reason = iconv("UTF-8","GBK",$_GET['reason']);
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set CustomFaceVer=1 where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,Reason,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',8,"'.$reason.'","'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }
   //注册页面登录屏蔽 type=10
   public function zcpb(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
		$reason = '新注册用户页面屏蔽';
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set CustomFaceVer=1 where UserID ='.$UserID;
   		$mssql->query($sql);
   }
   //大厅登录屏蔽 type=9
   public function jiechu(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set CustomFaceVer=0 where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',9,"'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }
   //解除手机令牌 type=8
   public function jiechulp(){
   		if($_SESSION['zs78_admin2']['role']>2){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
   		$InsertTime = date('Y-m-d H:i:s');
   		$UserID = $_GET['UserID'];
   		$mssql = M();
   		$sql = 'update QPAccountsDB.dbo.AccountsInfo set IsLockToken=0,IsOpenTokenLock=0,SerialNumber="" where UserID ='.$UserID;
   		if(!$mssql->query($sql)){
   			$sql2='insert into QPWebBackDB.dbo.ManagerRecord (ManagerID,UserID,Type,InsertTime) values('.$_SESSION['zs78_admin2']['id'].','.$UserID.',10,"'.$InsertTime.'")';
   			$mssql->query($sql2);
   			_location('操作成功',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}else{
   			_location('操作出错',WEB_ROOT.'index.php/User/userInfo?UserID='.$UserID);
   		}
   }
    //管理员操作记录
    public function change_record(){
    	$mssql = M();
    	$pageSize = PAGE_SIZE_2;
    	if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

    	$sql1 = 'select count(RecordID) as num from QPWebBackDB.dbo.ManagerRecord(NOLOCK)';
		$rs1 = $mssql->query($sql1);
		$count = $rs1[0]['num'];

    	if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}

    	$sql2 = 'SELECT UserID,GameID,Accounts,NickName,Username,Type,Reason,InsertTime FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Username,Type,Reason,InsertTime FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Username,t3.Type,t3.Reason,CONVERT(varchar,t3.InsertTime,120) as InsertTime ';
    	$sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1,QPPlatformManagerDB.dbo.Base_Users(NOLOCK) t2,QPWebBackDB.dbo.ManagerRecord(NOLOCK) t3 ';
    	$sql2.= 'WHERE t1.UserID=t3.UserID and t2.UserID=t3.ManagerID order by InsertTime desc) t4 order by InsertTime asc) t5 order by InsertTime desc';
		$rs2 = $mssql->query($sql2);
    	for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
			$rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
			$rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
			$rs2[$i]['Reason'] = iconv("GBK","UTF-8",$rs2[$i]['Reason']);
		}
		//print_r($rs2);
		$pageNum = ceil($count/$pageSize);
    	$this->assign('pageNum',$pageNum);
    	$this->assign('result',$rs2);
    	$this->display('change_record');
   	}

	//管理员操作记录 查询
    public function change_search(){
		$GameID=$_GET['GameID'];
		$mssql = M();

    	$sql= 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.Username,t3.Type,t3.Reason,CONVERT(varchar,t3.InsertTime,120) as InsertTime ';
    	$sql.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1,QPPlatformManagerDB.dbo.Base_Users(NOLOCK) t2,QPWebBackDB.dbo.ManagerRecord(NOLOCK) t3 ';
    	$sql.= 'WHERE t1.UserID=t3.UserID and t2.UserID=t3.ManagerID and t1.GameID='.$GameID.' order by InsertTime desc';
		$rs = $mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Reason'] = iconv("GBK","UTF-8",$rs[$i]['Reason']);
		}
    	//$rs['type_array'] = explode(',', $rs['type']);
    	$this->assign('result',$rs);
    	$this->assign('GameID',$GameID);
    	$this->display('change_search');
   	}

    //查询ip地址
	function getIpPlace($ip){
    	require_once(ROOT_PATH.'/Db/IP/IpLocation.php');//加载类文件IpLocation.php
    	$ipfile = ROOT_PATH.'/Db/IP/qqwry.dat';      //获取ip对应地区的信息文件
    	$iplocation = new IpLocation($ipfile);  //new IpLocation($ipfile) $ipfile ip对应地区信息文件
    	$ipresult = $iplocation->getlocation($ip); //根据ip地址获得地区 getlocation("ip地区")
    	return $ipresult;
	}


	//excel导出
    public function excel_rank(){
		$num = $_GET['num'];
		$date = date('Y-m-d H:i:s');
		$rs = array();
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$procedure = mssql_init("php_gold_rank_excel",$conn);
		mssql_bind($procedure,"@num", $num, SQLINT4);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);

    	for($i=0;$i<count($rs);$i++){
			$rs2[$i]['UserID'] = $i+1;
			$rs2[$i]['GameID'] = $rs[$i]['GameID'];
			$rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs2[$i]['Score'] = $rs[$i]['Score'];
			$rs2[$i]['InsureScore'] = $rs[$i]['InsureScore'];
			$rs2[$i]['gold_sum'] = $rs[$i]['gold_sum'];
		}
    	$title = array('名次','游戏ID','用户账号','用户昵称','身上金币','银行金币','总金币');
		$filename = $date.'金币排行统计';
		$this->exportexcel($rs2,$title,$filename);
    }

    function order(){
    	$this->display('order');
    }

	function order_search(){
		$mssql = M();
		$Type=$_GET['type'];
		if($Type==1){
			$GameID=$_GET['OrderID'];
			$sql='SELECT top 100 GameID,Accounts,OrderID,CardGold,PayAmount,OrderStatus,CONVERT(varchar,ApplyDate,120) AS ApplyDate FROM QPTreasureDB.dbo.OnLineOrder(NOLOCK) where GameID='.$GameID.' order by ApplyDate desc';
			if($rs=$mssql->query($sql)){
				for($i=0;$i<count($rs);$i++){
					$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
					$sql2='SELECT BeforeGold FROM QPTreasureDB.dbo.ShareDetailInfo where OrderID="'.$rs[$i]['OrderID'].'"';
					if($rs[$i]['OrderStatus']==2){
						if($rs2=$mssql->query($sql2)){
							$rs[$i]['BeforeGold']=$rs2[0]['BeforeGold'];
						}else{
							$rs[$i]['OrderStatus']=1;
						}
					}
				}
			}
		}
		if($Type==2){
			$OrderID=$_GET['OrderID'];
			$sql='SELECT GameID,Accounts,OrderID,CardGold,PayAmount,OrderStatus,CONVERT(varchar,ApplyDate,120) AS ApplyDate FROM QPTreasureDB.dbo.OnLineOrder(NOLOCK) where OrderID="'.$OrderID.'"';
			if($rs=$mssql->query($sql)){
				$rs[0]['Accounts']=iconv("GBK","UTF-8",$rs[0]['Accounts']);
			}
			$sql2='SELECT BeforeGold FROM QPTreasureDB.dbo.ShareDetailInfo where OrderID="'.$OrderID.'"';
				if($rs[$i]['OrderStatus']==2){
					if($rs2=$mssql->query($sql2)){
							$rs[$i]['BeforeGold']=$rs2[0]['BeforeGold'];
					}else{
						$rs[$i]['OrderStatus']=1;
					}
				}
		}

		$this->assign('rs',$rs);
    	$this->display('order_result');
    }

    //道具使用
    public function prop(){
    	$mssql = M();
    	$pageSize = PAGE_SIZE_2;
    	if(isset($_GET['pageNo'])){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$sql = 'select count(*) as num from QPRecordDB.dbo.RecordSendPresent(NOLOCK)';
		$rs = $mssql->query($sql);
		$count = $rs[0]['num'];
		if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}

    	$sql3 = 'SELECT PresentID,PresentCount,SendUserID,SendGameID,SendNickName,RcvUserID,RcvGameID,RcvNickName,SendTime,PropName FROM (SELECT TOP ('.$num.') PresentID,PresentCount,SendUserID,SendGameID,SendNickName,RcvUserID,RcvGameID,RcvNickName,SendTime,PropName FROM ';
    	$sql3.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.PresentID,t1.PresentCount,t1.SendUserID,t1.RcvUserID,CONVERT(varchar,t1.SendTime,120) AS SendTime,t2.Name as PropName,t3.GameID as SendGameID,t3.NickName as SendNickName,t4.GameID as RcvGameID,t4.NickName as RcvNickName ';
    	$sql3.= 'FROM QPRecordDB.dbo.RecordSendPresent(NOLOCK) t1,QPTreasureDB.dbo.GameProperty(NOLOCK) t2, QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3,QPAccountsDB.dbo.AccountsInfo(NOLOCK) t4 ';
    	$sql3.= 'WHERE t1.SendUserID =t3.UserID AND t1.RcvUserID=t4.UserID AND t1.PresentID = t2.ID order by SendTime desc) t5 order by SendTime asc) t6 order by SendTime desc';
		$rs3 = $mssql->query($sql3);

    	for($i=0;$i<count($rs3);$i++){
			$rs3[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$rs3[$i]['PropName'] = iconv("GBK","UTF-8",$rs3[$i]['PropName']);
			$rs3[$i]['SendNickName'] = iconv("GBK","UTF-8",$rs3[$i]['SendNickName']);
			$rs3[$i]['RcvNickName'] = iconv("GBK","UTF-8",$rs3[$i]['RcvNickName']);
			if($rs3[$i]['PresentID']==12){
				$gold=8000;
			}elseif($rs3[$i]['PresentID']==13){
				$gold=10000;
			}else{
				$gold=0;
			}
			$rs3[$i]['Gold'] = $rs3[$i]['PresentCount']*$gold;
			$rs3[$i]['Gold'] = number_format($rs3[$i]['Gold']);
		}
		$pageNum = ceil($count/$pageSize);
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs3);
		$this->display('prop');
    }

    //道具使用查询
    public function prop_search(){
    	$mssql = M();
    	$GameID = $_GET['GameID'];
    	$sql = 'SELECT UserID FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) WHERE GameID='.$GameID;
    	$rs = $mssql->query($sql);
    	$UserID = $rs[0]['UserID'];
    	$gold=0;
    	$sql3='SELECT  t1.PresentID,t1.PresentCount,t1.SendUserID,t1.RcvUserID,CONVERT(varchar,t1.SendTime,120) AS SendTime,t2.Name as PropName,t3.GameID as SendGameID,t3.NickName as SendNickName,t4.GameID as RcvGameID,t4.NickName as RcvNickName ';
    	$sql3.='FROM QPRecordDB.dbo.RecordSendPresent(NOLOCK) t1,QPTreasureDB.dbo.GameProperty(NOLOCK) t2, QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3,QPAccountsDB.dbo.AccountsInfo(NOLOCK) t4 ';
    	$sql3.= 'WHERE t1.SendUserID =t3.UserID AND t1.RcvUserID=t4.UserID AND t1.PresentID = t2.ID AND (t1.SendUserID='.$UserID.' or t1.RcvUserID='.$UserID.') order by SendTime desc';
		$rs3 = $mssql->query($sql3);

    	for($i=0;$i<count($rs3);$i++){
			$rs3[$i]['no'] = $i+1;
			$rs3[$i]['PropName'] = iconv("GBK","UTF-8",$rs3[$i]['PropName']);
			$rs3[$i]['SendNickName'] = iconv("GBK","UTF-8",$rs3[$i]['SendNickName']);
			$rs3[$i]['RcvNickName'] = iconv("GBK","UTF-8",$rs3[$i]['RcvNickName']);
			if($rs3[$i]['PresentID']==12){
				$gold=8000;
			}elseif($rs3[$i]['PresentID']==13){
				$gold=10000;
			}else{
				$gold=0;
			}
			$rs3[$i]['Gold'] = $rs3[$i]['PresentCount']*$gold;
			$rs3[$i]['Gold'] = number_format($rs3[$i]['Gold']);
		}
		$this->assign('result',$rs3);
		$this->display('prop_search');
    }

    //金币总
    public function gold_sum(){
    	$result = array();
   		$mssql = M();
   		$vip_ids = $this->getVipIds2();
   		$filter_ids = $this->getVipIds3();
   		//vip
   		$sql = 'select SUM(t1.Score) as Score,SUM(t1.InsureScore) as InsureScore from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.MemberOrder > 0';
   		$rs = $mssql->query($sql);
   		//用户
   		$sql1 = 'select SUM(t1.Score) as Score,SUM(t1.InsureScore) as InsureScore from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.IsAndroid = 0 and t1.UserID not in ('.$filter_ids.')';
   		$rs1 = $mssql->query($sql1);

   		$result['vip_sum'] = number_format($rs[0]['Score']+$rs[0]['InsureScore']);
   		$result['user_sum'] = number_format($rs1[0]['Score']+$rs1[0]['InsureScore']);
   		$this->assign('result',$result);
   		$this->display('gold_sum');
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

	public function vip(){
		$this->display('vip');
	}

	//中奖查询
	public function award(){
		if(!$_GET['GameID']){
			$this->display('award');
			return;
		}else{
			$GameID=$_GET['GameID'];
		}
		$mssql=M();
		$sql='select CONVERT(varchar,A.InsertTime,120) AS InsertTime,A.UserID,B.NickName,C.Describe FROM QPAccountsDB.dbo.UserAwardList(NOLOCK) A,QPAccountsDB.dbo.AccountsInfo(NOLOCK) B,QPAccountsDB.dbo.AwardList(NOLOCK) C where A.UserID=B.UserID and B.GameID='.$GameID.' and A.AwardID=C.ID order by InsertTime desc';
		if($rs=$mssql->query($sql)){
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no']=$i+1;
				$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
				$rs[$i]['Describe']=iconv("GBK","UTF-8",$rs[$i]['Describe']);
			}
		}
		$this->assign('GameID',$GameID);
		$this->assign('result',$rs);
		$this->display('awardList');
	}

	//在线玩家
	public function online_user_old(){
		if($_GET['type']){
			$type = $_GET['type'];
		}else{
			$type = 1;
		}
		if($_GET['order']){
			$order = $_GET['order'];
		}else{
			$order = 1;
		}
		$user_ff = 0;
		$ids='';
		$user_login['ios']=0;
		$user_login['android']=0;
		$user_login['pc']=0;
		$gjf = array(75,76,77,78,85,86,87,88,95,96,97,98,105,106,107,108);
		$mssql = M();
		$sql = 'select count(UserID) as num from QPTreasureDB.dbo.GameScoreLocker(nolock)';
		$rs = $mssql->query($sql);
		$count_online=$rs[0]['num'];

		$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_OnlineUserInfo2",$conn);
		mssql_bind($procedure,"@type", $type, SQLINT4);
		mssql_bind($procedure,"@order", $order, SQLINT4);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			if($rs[$i]['KindID']==2060 || $rs[$i]['KindID']==2070 || $rs[$i]['KindID']==2075 || $rs[$i]['KindID']==2080){
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			}else{
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			}
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			if(in_array($rs[$i]['ServerID'],$gjf)){
				$rs[$i]['is_gjf']=1;
			}else{
				$rs[$i]['is_gjf']=0;
			}
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
				if($rs[$i]['LockMobileKindID']==1){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==2){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==3){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==4){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==9){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==102){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==21){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==22){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==23){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==31){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==32){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==33){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==41){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==42){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==43){
					$user_login['pc'] = $user_login['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==51){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==52){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==53){
					$user_login['pc'] = $user_login['pc']+1;
				}else{
					$user_login['ios'] = $user_login['ios']+1;
				}

            }else{
            	if($rs[$i]['LockMobileKindID']==1){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==2){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==3){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==4){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==9){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==102){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==21){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==22){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==23){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==31){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==32){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==33){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==41){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==42){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==43){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}elseif($rs[$i]['LockMobileKindID']==51){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==52){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==53){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}else{
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}
            }

			if($rs[$i]['SpreaderID']==1){
                $ts[]=$rs[$i];
            }
			if($rs[$i]['LoveLiness']>0){
                $ts2[]=$rs[$i];
            }

		}
		$score_sum = number_format($score_sum);
        //print_r($rs);
		if(count($ts)>0 || count($ts2)>0){
			$show=1;
		}else{
			$show=0;
		}
		$user_mf = count($rs)-$user_ff;
    	$this->assign('result',$rs);
		$this->assign('count_online',$count_online);
		$this->assign('user_login',$user_login);
		$this->assign('user_login_mf',$user_login_mf);
		$this->assign('score_sum',$score_sum);
		$this->assign('user_ff',$user_ff);
		$this->assign('user_mf',$user_mf);
    	$this->assign('show',$show);
    	$this->assign('ts',$ts);
		$this->assign('ts2',$ts2);
    	if($type==1){
    		$this->display('online');
    	}else{
    		$this->display('online2');
    	}
	}

	//检测转账金币是否为0
    public function checkZz($UserID){
        $mssql = M();
        $sql = 'select sum(t1.SwapScore) as zz_sum from QPTreasureDB.dbo.RecordInsure(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.SourceUserID=t2.UserID where t1.TargetUserID='.$UserID.' and t2.MemberOrder>0 and t1.TradeType=3';
        $rs = $mssql->query($sql);
        if($rs[0]['zz_sum']>0){
            return 1;
        }else{
            return 0;
        }

    }

	//检测转账金币是否为0(存储过程)
    public function checkZz2($UserID){
        $mssql = M();
        $sql = 'select sum(t1.SwapScore) as zz_sum from QPTreasureDB.dbo.RecordInsure(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.SourceUserID=t2.UserID where t1.TargetUserID='.$UserID.' and t2.MemberOrder>0 and t1.TradeType=3';
        if($rs = $mssql->query($sql)){
			if($rs[0]['zz_sum']>0){
            return 1;
        }else{
            return 0;
        }
		}else{
			return 0;
		}
    }

	//检测转账是否已撤销
    public function checkCancel($RecordID){
        $mssql = M();
        $sql = 'select ID from QPTreasureDB.dbo.CancelInsure(NOLOCK) where RecordID='.$RecordID;
        $rs = $mssql->query($sql);
        if($rs[0]['ID']){
            return 1;
        }else{
            return 0;
        }

    }

	function TsUserList(){
		$mssql = M();
		$sql = 'select top 200 t1.UserID,t2.GameID,t2.Accounts,t2.NickName,t3.Score,t3.InsureScore from QPAccountsDB.dbo.TsUser(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID=t2.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID order by t3.InsureScore desc';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
		}
		$this->assign('result',$rs);
		$this->display('ts_user');
	}

	//添加提示用户
	function addTs(){
		$type = $_GET['type'];
		$GameID = $_GET['GameID'];
		$mssql=M();
        if($type == 1){
            $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo(nolock) where GameID='.$GameID;
        }elseif($type==2){
            $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo(nolock) where RegisterIP="'.$GameID.'"';
        }elseif($type==3){
            $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo(nolock) where LastLogonIP="'.$GameID.'"';
        }elseif($type==4){
            $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo(nolock) where RegisterMachine="'.$GameID.'"';
        }elseif($type==5){
            $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo(nolock) where LastLogonMachine="'.$GameID.'"';
        }

		if(!$rs = $mssql->query($sql)){
			_location("该条件用户不存在",WEB_ROOT."index.php/User/TsUserList");
		}else{
            for($i=0;$i<count($rs);$i++){
                $sql2 = 'select UserID from QPAccountsDB.dbo.TsUser(nolock) where UserID='.$rs[$i]['UserID'];
                if(!$rs2=$mssql->query($sql2)){
                    $sql3='INSERT INTO QPAccountsDB.dbo.TsUser (UserID,GameID) VALUES('.$rs[$i]['UserID'].','.$rs[$i]['GameID'].')';
					$sql4='UPDATE QPAccountsDB.dbo.AccountsInfo set SpreaderID=1 where GameID='.$rs[$i]['GameID'];
                    $mssql->query($sql3);
					$mssql->query($sql4);
                }
            }
			_location("添加成功",WEB_ROOT."index.php/User/TsUserList");

		}
	}

	//删除提示用户 GameID
	function DelTsByGameID(){
		if(isset($_GET['GameID']) && $_GET['GameID']!=''){
			$GameID = $_GET['GameID'];
		}else{
			$this->TsUserList();
		}
		$mssql=M();
		$sql3 = 'select UserID from QPAccountsDB.dbo.AccountsInfo(nolock) where GameID='.$GameID;
		$rs3=$mssql->query($sql3);
		$UserID=$rs3[0]['UserID'];
		if(!$UserID){
			_location("GameID不存在",WEB_ROOT."index.php/User/TsUserList");
			return;
		}
		$sql = 'delete QPAccountsDB.dbo.TsUser where UserID='.$UserID;
		$sql2='update QPAccountsDB.dbo.AccountsInfo set SpreaderID=0 where UserID='.$UserID;
		$mssql->query($sql2);
		if(!$mssql->query($sql)){

			_location("删除成功",WEB_ROOT."index.php/User/TsUserList");
		}else{
			_location("删除失败",WEB_ROOT."index.php/User/TsUserList");
		}
	}

	//删除提示用户
	function delTs(){
		if(isset($_GET['UserID']) && $_GET['UserID']!=''){
			$UserID = $_GET['UserID'];
		}else{
			$this->TsUserList();
		}
		$mssql=M();
		$sql = 'delete QPAccountsDB.dbo.TsUser where UserID='.$UserID;
		$sql2='update QPAccountsDB.dbo.AccountsInfo set SpreaderID=0 where UserID='.$UserID;
		$mssql->query($sql2);
		if(!$mssql->query($sql)){

			_location("删除成功",WEB_ROOT."index.php/User/TsUserList");
		}else{
			_location("删除失败",WEB_ROOT."index.php/User/TsUserList");
		}
	}

	function CheckTsUser($UserID){
		$mssql=M();
		$sql = 'select UserID from QPAccountsDB.dbo.TsUser(NOLOCK) where UserID='.$UserID;
		if(!$rs = $mssql->query($sql)){
			return 0;
		}else{
			return 1;
		}
	}

	//密码修改记录
	public function pwd_record(){
		$mssql=M();
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$pageSize = PAGE_SIZE_2;
		$sql = 'select count(*) as num from QPRecordDB.dbo.RecordPasswdExpend(NOLOCK)';
		$rs = $mssql->query($sql);
		$count = $rs[0]['num'];
		if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}

		$sql2 = 'SELECT OperMasterID,UserID,ReLogonPasswd,ReInsurePasswd,ClientIP,CollectDate,GameID,Accounts,NickName FROM (SELECT TOP ('.$num.') OperMasterID,UserID,ReLogonPasswd,ReInsurePasswd,ClientIP,CollectDate,GameID,Accounts,NickName FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.OperMasterID,t1.UserID,t1.ReLogonPasswd,t1.ReInsurePasswd,t1.ClientIP,CONVERT(varchar,t1.CollectDate,120) AS CollectDate,t2.GameID,t2.Accounts,t2.NickName ';
    	$sql2.= 'FROM QPRecordDB.dbo.RecordPasswdExpend(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID =t2.UserID';
    	$sql2.= ' order by CollectDate desc) t3 order by CollectDate asc) t4 order by CollectDate desc';
		$rs2 = $mssql->query($sql2);
		for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no']=$i+1+($pageNo-1)*$pageSize;
			$rs2[$i]['Accounts']=iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
			$rs2[$i]['NickName']=iconv("GBK","UTF-8",$rs2[$i]['NickName']);
			if($rs2[$i]['ReLogonPasswd']!=' '){
				$rs2[$i]['ReLogonPasswd']='修改';
			}else{
				$rs2[$i]['ReLogonPasswd']='未修改';
			}
			if($rs2[$i]['ReInsurePasswd']!=' '){
				$rs2[$i]['ReInsurePasswd']='修改';
			}else{
				$rs2[$i]['ReInsurePasswd']='未修改';
			}
			$rs2[$i]['OperMasterID']=$this->getMaster($rs2[$i]['OperMasterID']);
		}
    	$pageNum = ceil($count/$pageSize);
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs2);
		$this->display('pwd_record');
	}

	//获取管理员
	public function getMaster($id){
		if($id==0){
			return '本人修改';
		}else{
			$mssql = M();
			$sql = 'SELECT UserName FROM QPPlatformManagerDB.dbo.Base_Users(nolock) WHERE UserID='.$id;
			$rs = $mssql->query($sql);
			return $rs[0]['UserName'];
		}
	}

	//密码修改查询
	public function pwd_search(){
		$GameID=$_GET['GameID'];
    	$mssql = M();
    	$sql = 'SELECT t1.OperMasterID,t1.UserID,t1.ReLogonPasswd,t1.ReInsurePasswd,t1.ClientIP,CONVERT(varchar,t1.CollectDate,120) AS CollectDate,t2.GameID,t2.Accounts,t2.NickName FROM QPRecordDB.dbo.RecordPasswdExpend(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID =t2.UserID WHERE t2.GameID='.$GameID.' order by CollectDate desc';
    	$rs = $mssql->query($sql);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no']=$i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			if($rs[$i]['ReLogonPasswd']!=' '){
				$rs[$i]['ReLogonPasswd']='修改';
			}else{
				$rs[$i]['ReLogonPasswd']='未修改';
			}
			if($rs[$i]['ReInsurePasswd']!=' '){
				$rs[$i]['ReInsurePasswd']='修改';
			}else{
				$rs[$i]['ReInsurePasswd']='未修改';
			}
			$rs[$i]['OperMasterID']=$this->getMaster($rs[$i]['OperMasterID']);
		}
    	$this->assign('result',$rs);
    	$this->display('pwd_search');
	}

	//自助客服
	public function custom(){
		$mssql=M();
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$pageSize = PAGE_SIZE_2;
		$sql = 'select count(*) as num from QPWebBackDB.dbo.CustomSsRecord(NOLOCK)';
		$rs = $mssql->query($sql);
		$count = $rs[0]['num'];
		if($pageNo*$pageSize>$count){
    		$num = $count-(($pageNo-1)*$pageSize);
    	}else{
    		$num = $pageSize;
    	}

		$sql2 = 'SELECT UserID,SsDate,Score,Type,SSID,Status,InsertTime,GameID,Accounts,NickName FROM (SELECT TOP ('.$num.') UserID,SsDate,Score,Type,SSID,Status,InsertTime,GameID,Accounts,NickName FROM ';
    	$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.SsDate,t1.Score,t1.Type,t1.SSID,t1.Status,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.GameID,t2.Accounts,t2.NickName ';
    	$sql2.= 'FROM QPWebBackDB.dbo.CustomSsRecord t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID =t2.UserID';
    	$sql2.= ' order by InsertTime desc) t3 order by InsertTime asc) t4 order by InsertTime desc';
		$rs2 = $mssql->query($sql2);

		for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no']=$i+1+($pageNo-1)*$pageSize;
			$rs2[$i]['Accounts']=iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
			$rs2[$i]['NickName']=iconv("GBK","UTF-8",$rs2[$i]['NickName']);
		}
    	$pageNum = ceil($count/$pageSize);
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs2);
		$this->display('custom');
	}

	public function custom_rs(){
		$mssql = M();
		$GameID = $_GET['GameID'];
		if(strlen($GameID)>7){
			$sql = 'select t1.UserID,t1.SsDate,t1.Score,t1.Type,t1.SSID,t1.Status,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.GameID,t2.Accounts,t2.NickName FROM QPWebBackDB.dbo.CustomSsRecord t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID =t2.UserID where t1.SSID="'.$GameID.'"';
		}else{
			$sql = 'select t1.UserID,t1.SsDate,t1.Score,t1.Type,t1.SSID,t1.Status,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.GameID,t2.Accounts,t2.NickName FROM QPWebBackDB.dbo.CustomSsRecord t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID =t2.UserID where t2.GameID='.$GameID;
		}
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no']=$i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
		}
		$this->assign('GameID',$GameID);
		$this->assign('result',$rs);
		$this->display('custom_rs');
	}

	public function custom_info(){
		$SSID = $_GET['SSID'];
		$mssql = M();
		$sql = 'select t1.UserID,t1.SsDate,t1.Sshour,t1.Score,t1.OrderID,t1.TreaGameID,t1.QQ,t1.sfz_photo,t1.other_photo1,t1.other_photo2,t1.other_photo3,t1.Info,t1.SSID,t1.Type,t1.Status,t1.UpdateUser,t1.IP,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.GameID,t2.Accounts,t2.NickName FROM QPWebBackDB.dbo.CustomSsRecord t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID =t2.UserID where t1.SSID="'.$SSID.'"';
		$rs = $mssql->query($sql);
		$rs[0]['Accounts']=iconv("GBK","UTF-8",$rs[0]['Accounts']);
		$rs[0]['NickName']=iconv("GBK","UTF-8",$rs[0]['NickName']);
		$IP[0]['city'] = $this->getIpPlace($rs[0]['IP']);
		$this->assign('rs',$rs[0]);
		$this->assign('IP',$IP[0]['city']);
		$this->display('custom_info');
	}

	public function custom_do(){
		print_r($_SESSION['zs78_admin2']);
		exit;
		$SSID = $_GET['SSID'];
		$result = $_GET['result'];
		$addGold = $_GET['addGold'];
		$date_now = date('Y-m-d H:i:s');
		$mssql = M();
		$sql = 'update QPWebBackDB.dbo.CustomSsRecord set Status='.$result.',Addgold='.$addGold.',UpdateUser="'.$_SESSION['zs78_admin2']['username'].'"';

	}

	public function sendNum(){
		$this->display('sendNum');
	}

	public function sendNum_do(){
		$GameID = $_GET['GameID'];
		$sendNum = $_GET['sendNum'];
		$date = date('Y-m-d H:i:s');
		$mssql = M();
		$sql = 'select UserID from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID ='.$GameID;
		$rs = $mssql->query($sql);
		if(!$rs[0]['UserID']){
			_location("此游戏ID的帐号不存在",WEB_ROOT."index.php/User/sendNum");
		}
		$sql2 = 'select UserID from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID ='.$sendNum;
		$rs2 = $mssql->query($sql2);
		if($rs2[0]['UserID']){
			_location("此靓号已经有帐号使用",WEB_ROOT."index.php/User/sendNum");
		}
		$sql3 = 'select UserID from QPAccountsDB.dbo.ChangeGameIDRecord(NOLOCK) where GameID ='.$sendNum;
		$rs3 = $mssql->query($sql3);
		if($rs3[0]['UserID']){
			_location("此靓号已经被使用过",WEB_ROOT."index.php/User/sendNum");
		}
		$sql4 = 'select UserID from QPAccountsDB.dbo.GameIdentifier(NOLOCK) where GameID ='.$sendNum;
		$rs4 = $mssql->query($sql4);
		if($rs4[0]['UserID']){
			$sql5 = 'delete QPAccountsDB.dbo.GameIdentifier where GameID='.$sendNum;
			$mssql->query($sql5);
		}
			$sql6 = 'update QPAccountsDB.dbo.AccountsInfo set GameID='.$sendNum.' where UserID='.$rs[0]['UserID'];
			$sql7 = 'insert into QPAccountsDB.dbo.ChangeGameIDRecord (GameID,UserID,InsertTime,MasterID) values('.$GameID.','.$rs[0]['UserID'].',"'.$date.'",'.$_SESSION['zs78_admin2']['id'].')';
			$mssql->query($sql7);
			if(!$mssql->query($sql6)){
				_location("赠送成功",WEB_ROOT."index.php/User/sendNum");
			}else{
				_location("赠送失败",WEB_ROOT."index.php/User/sendNum");
			}
	}

	public function sendVip(){
		$this->display('sendVip');
	}

	public function sendVip_do(){
		$GameID = $_GET['GameID'];
		$days = $_GET['days'];
		$reason = iconv("UTF-8","GBK",$_GET['reason']);
		$date = date('Y-m-d H:i:s');
		$date2 = date('Y-m-d H:i:s',strtotime($date . '+'.$days.' day'));
		$IP=GetIP();
		$mssql = M();
		$sql = 'select UserID from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID ='.$GameID;
		$rs = $mssql->query($sql);
		if(!$rs[0]['UserID']){
			_location("此游戏ID的帐号不存在",WEB_ROOT."index.php/User/sendVip");
		}
		$sql2 = 'update QPAccountsDB.dbo.AccountsInfo set MemberOrder=2,MemberOverDate="'.$date2.'",MemberSwitchDate="'.$date2.'" where UserID ='.$rs[0]['UserID'];
		if(!$mssql->query($sql2)){
			$sql3 = 'insert into QPRecordDB.dbo.RecordGrantMember (MasterID,ClientIP,CollectDate,UserID,GrantCardType,Reason,MemberDays) values('.$_SESSION['zs78_admin2']['id'].',"'.$IP.'","'.$date.'",'.$rs[0]['UserID'].',2,"'.$reason.'",'.$days.')';
			$mssql->query($sql3);
			_location("赠送成功",WEB_ROOT."index.php/User/sendVip");
		}else{
			_location("赠送失败",WEB_ROOT."index.php/User/sendVip");
		}
	}

	//赠送喇叭
	public function sendLb(){
		$this->display('sendLb');
	}

	public function sendLb_do(){
		$GameID = $_GET['GameID'];
		$num = $_GET['num'];
		if($num>25){
			_location("",WEB_ROOT."index.php/User/sendLb");
		}
		$reason = iconv("UTF-8","GBK",$_GET['reason']);
		$type = $_GET['type'];
		$mssql = M();
		$sql = 'select UserID from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID ='.$GameID;
		$rs = $mssql->query($sql);
		if(!$rs[0]['UserID']){
			_location("赠送上限为25",WEB_ROOT."index.php/User/sendLb");
		}
		$sql2='select top 1 DetailID,PropCount from QPAccountsDB.dbo.UserProperty(nolock) where UserID='.$rs[0]['UserID'].' and PropID='.$type;
		$rs2 = $mssql->query($sql2);
		//var_dump($rs2[0]['DetailID']);
		//print_r($rs2);
		//exit;
		if(!$rs2[0]['DetailID']){
			$mssql->query('Insert into QPAccountsDB.dbo.UserProperty (UserID,PropID,PropCount) values('.$rs[0]['UserID'].','.$type.','.$num.')');
		}else{
			$mssql->query('update QPAccountsDB.dbo.UserProperty set PropCount=PropCount+'.$num.' where DetailID='.$rs2[0]['DetailID']);
		}
		$sql3='Insert into QPRecordDB.dbo.RecordSendLb (MasterID,UserID,PropID,PropCount,Reason) values('.$_SESSION['zs78_admin2']['id'].','.$rs[0]['UserID'].','.$type.','.$num.',"'.$reason.'")';

		if(!$mssql->query($sql3)){
			_location("赠送成功",WEB_ROOT."index.php/User/sendLb");
		}else{
			_location("赠送失败",WEB_ROOT."index.php/User/sendLb");
		}
	}

	//喇叭查询
	public function Lb_search(){
		$mssql = M();
		if(isset($_GET['GameID'])){
			$GameID=$_GET['GameID'];
			$sql = 'select UserID from QPAccountsDB.dbo.AccountsInfo(nolock) where GameID='.$GameID;
			$rs = $mssql->query($sql);
			if(!$rs[0]['UserID']){
				_location("该GameID不存在",WEB_ROOT."index.php/User/Lb_search");
				return;
			}else{

				$sql2='select t1.UserID,t1.PropID,t1.Info,t1.InsertTime,t2.GameID,t2.NickName,t2.Accounts from (select top 50 PropID,UserID,Info,CONVERT(varchar,InsertTime,120) AS InsertTime from [QPRecordDB].[dbo].[RecordUserProp](nolock) where UserID='.$rs[0]['UserID'].' order by RecordID desc)t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID';

				$sql3 = 'select top 1 PropCount from QPAccountsDB.dbo.UserProperty where PropID=20 and UserID='.$rs[0]['UserID'];
				$rs3 = $mssql->query($sql3);
				$dlb=$rs3[0]['PropCount'];
				$xlb=0;
				$sql4='select top 50 t1.[MasterID],t1.[PropCount],t1.[Reason],t2.GameID,t2.NickName,CONVERT(varchar,t1.InsertTime,120) as InsertTime
  FROM [QPRecordDB].[dbo].[RecordSendLb](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID where t2.GameID='.$GameID.' order by t1.DetailID desc';
				$this->assign('dlb',$dlb);
				$this->assign('xlb',$xlb);
				$this->assign('GameID',$GameID);
				$this->assign('rs2',$rs2);
			}
		}else{
			$sql2='select t1.UserID,t1.PropID,t1.Info,t1.InsertTime,t2.GameID,t2.NickName,t2.Accounts from (select top 50 PropID,UserID,Info,CONVERT(varchar,InsertTime,120) AS InsertTime from [QPRecordDB].[dbo].[RecordUserProp](nolock) order by RecordID desc)t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID';
$sql4='select top 50 t1.[MasterID],t1.[PropCount],t1.[Reason],t2.GameID,t2.NickName,CONVERT(varchar,t1.InsertTime,120) as InsertTime
  FROM [QPRecordDB].[dbo].[RecordSendLb](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID order by t1.DetailID desc';

		}
		//echo $sql2;
		$rs2 = $mssql->query($sql2);
		//print_r($rs2);
		for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no'] = $i+1;
			$rs2[$i]['Info']=iconv("GBK","UTF-8",$rs2[$i]['Info']);
			$rs2[$i]['Accounts']=iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
			$rs2[$i]['NickName']=iconv("GBK","UTF-8",$rs2[$i]['NickName']);
		}
		$rs4 = $mssql->query($sql4);
				for($i=0;$i<count($rs4);$i++){
					$rs4[$i]['no'] = $i+1;
					$rs4[$i]['NickName']=iconv("GBK","UTF-8",$rs4[$i]['NickName']);
				}

		//print_r($rs3);
		$this->assign('rs4',$rs4);
		$this->assign('rs2',$rs2);
		//$this->assign('rs3',$rs3);
		$this->display('lb_search');

	}

	//喇叭数量
	public function Lb_num(){
		$mssql = M();
		$sql='select t1.UserID,t1.PropCount,t2.GameID,t2.NickName from [QPAccountsDB].[dbo].[UserProperty](nolock)t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID order by t2.GameID';
		//echo $sql2;
		$rs = $mssql->query($sql);
		//print_r($rs2);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
		}
		$this->assign('rs',$rs);
		$this->display('lb_num');

	}

	//删除会员
	public function DelVip(){
		$UserID = $_GET['UserID'];
		$IP=GetIP();
		$date = date('Y-m-d H:i:s');
		$mssql = M();
		$sql = 'update QPAccountsDB.dbo.AccountsInfo set MemberOrder=0 where UserID='.$UserID;
		if(!$mssql->query($sql)){
			$sql3 = 'insert into QPRecordDB.dbo.RecordDelMember (MasterID,ClientIP,CollectDate,UserID) values('.$_SESSION['zs78_admin2']['id'].',"'.$IP.'","'.$date.'",'.$UserID.')';
			$mssql->query($sql3);
			_location("删除成功",WEB_ROOT."index.php/User/userInfo?UserID=".$UserID);
		}else{
			_location("删除失败",WEB_ROOT."index.php/User/userInfo?UserID=".$UserID);
		}
	}

	public function newUser(){
		$mssql = M();
		$sql = 'select top 100 UserID,GameID,Accounts,NickName,PassPortID,RegisterFrom,MemberOrder,CustomFaceVer,RegisterIP,RegisterMachine,RegisterMobile,LastLogonIP,LastLogonMachine,CONVERT(varchar,RegisterDate,120) AS RegisterDate from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where isandroid=0 order by RegisterDate desc';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
		}
		$this->assign('rs',$rs);
		$this->display('new_user');

	}

	//手机绑定列表
    public function bindPhone(){
        $mssql=M();
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        $pageSize = PAGE_SIZE_2;
        $sql = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where RegisterMobile <> ""';
        $rs = $mssql->query($sql);
        $count = $rs[0]['num'];
        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT UserID,GameID,Accounts,NickName,PassPortID,RegisterMobile,RegisterDate FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,PassPortID,RegisterMobile,RegisterDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') UserID,GameID,Accounts,NickName,PassPortID,RegisterMobile,CONVERT(varchar,RegisterDate,120) AS RegisterDate ';
        $sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) where RegisterMobile <> "" order by RegisterDate desc) t3 order by RegisterDate asc) t4 order by RegisterDate desc';
        $rs2 = $mssql->query($sql2);

        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no']=$i+1+($pageNo-1)*$pageSize;
            $rs2[$i]['Accounts']=iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName']=iconv("GBK","UTF-8",$rs2[$i]['NickName']);
        }
        $pageNum = ceil($count/$pageSize);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('bind_phone');
    }

	//屏蔽列表
    public function pb_list(){
        $mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo(NOLOCK) WHERE CustomFaceVer = 1';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT UserID,GameID,Accounts,NickName,PassPortID,LastLogonDate,Score,InsureScore FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,PassPortID,LastLogonDate,Score,InsureScore FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.PassPortID,t2.Score,t2.InsureScore,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate ';
        $sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
        $sql2.= 'WHERE t1.CustomFaceVer = 1 order by LastLogonDate desc) t4 order by LastLogonDate asc) t5 order by LastLogonDate desc';
        $rs2 = $mssql->query($sql2);

        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
            $rs2[$i]['gold_sum'] = $rs2[$i]['Score']+$rs2[$i]['InsureScore'];
            $rs2[$i]['Score'] = number_format($rs2[$i]['Score']);
            $rs2[$i]['InsureScore'] = number_format($rs2[$i]['InsureScore']);
            $rs2[$i]['gold_sum'] = number_format($rs2[$i]['gold_sum']);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('pb_list');
    }

	//在线人数
    public function userOnline(){
        $mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.UserOnlineCount';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM (SELECT TOP ('.$num.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,CONVERT(varchar,InsertDate,120) as InsertDate ';
        $sql2.= 'FROM QPWebBackDB.dbo.UserOnlineCount';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('user_online');
    }

	//有效转出
    public function userZz(){
        $mssql = M();
        $InsertDate = date('Y-m-d');
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.UserZzCount';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM (SELECT TOP ('.$num.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,CONVERT(varchar,InsertDate,120) as InsertDate ';
        $sql2.= 'FROM QPWebBackDB.dbo.UserZzCount';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
        }
        $sql3 = 'select count(t1.RecordID) as num from QPTreasureDB.dbo.RecordInsure t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.SourceUserID=t2.UserID left join QPAccountsDB.dbo.AccountsInfo t3 on t1.TargetUserID=t3.UserID where t1.CollectDate>"'.$InsertDate.'" and t1.TradeType=3 and t2.MemberOrder>0 and t3.MemberOrder=0';
        $rs3 = $mssql->query($sql3);
        $zz_count = $rs3[0]['num'];

        $pageNum = ceil($count/$pageSize);

        $this->assign('zz_count',$zz_count);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('user_zzcount');
    }

	//相同绑定手机号列表
    public function PhoneList(){
        $mssql = M();
        $p = $_GET['p'];
        $sql = 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.CustomFaceVer,t1.MemberOrder,t1.Nullity,t3.Score,t2.InsureScore FROM QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t2 on t1.UserID=t2.UserID left join (select UserID,sum(GameInsureScore) as Score from QPTreasureDB.dbo.GameTypeScoreInfo(NOLOCK) group by UserID)t3 on t1.UserID=t3.UserID WHERE t1.RegisterMobile="'.$p.'"';
        $rs = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
            $rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            $rs[$i]['Score'] = number_format($rs[$i]['Score']);
            $rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
        }
        $this->assign('rs',$rs);
        $this->display('phoneList');

    }

	//添加手机
    public function addPhone(){
        $this->display('addPhone');
    }

    public function addPhone_do(){
        $GameID = $_GET['GameID'];
        $p = $_GET['p'];
        $mssql = M();
        $sql = 'select UserID from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID ='.$GameID;
        $rs = $mssql->query($sql);
        if(!$rs[0]['UserID']){
            _location("此游戏ID的帐号不存在",WEB_ROOT."index.php/User/addPhone");
        }
        $sql2 = 'update QPAccountsDB.dbo.AccountsInfo set RegisterMobile="'.$p.'" where GameID ='.$GameID;
        if(!$mssql->query($sql2)){
            _location("添加成功",WEB_ROOT."index.php/User/addPhone");
        }else{
            _location("添加失败",WEB_ROOT."index.php/User/addPhone");
        }
    }

	//损耗统计
    public function wasteList(){
        //$mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

		$conn=_open(3);
        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.GameWasteCount(nolock)';
        $rs = mssql_query($sql1,$conn);
		$result = mssql_fetch_assoc($rs);
		$count = $result['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT G10,G19,G27,G28,G102,G104,G106,G108,G110,G114,G122,G140,G200,G210,G233,G308,G404,G2055,InsertDate,G2070,G2075,G2080,G350 FROM (SELECT TOP ('.$num.') G10,G19,G27,G28,G102,G104,G106,G108,G110,G114,G122,G140,G200,G210,G233,G308,G404,G2055,InsertDate,G2070,G2075,G2080,G350 FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') G10,G19,G27,G28,G102,G104,G106,G108,G110,G114,G122,G140,G200,G210,G233,G308,G404,G2055,CONVERT(varchar,InsertDate,120) as InsertDate,G2070,G2075,G2080,G350 ';
        $sql2.= 'FROM QPWebBackDB.dbo.GameWasteCount(nolock)';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
		$res2 = mssql_query($sql2,$conn);
		while ($row2 = mssql_fetch_assoc($res2)){
			$rs2[]=$row2;
		}
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
			$rs2[$i]['sum'] = $rs2[$i]['G10']+$rs2[$i]['G19']+$rs2[$i]['G27']+$rs2[$i]['G28']+$rs2[$i]['G102']+$rs2[$i]['G104']+$rs2[$i]['G106']+$rs2[$i]['G108']+$rs2[$i]['G110']+$rs2[$i]['G114']+$rs2[$i]['G122']+$rs2[$i]['G140']+$rs2[$i]['G200']+$rs2[$i]['G210']+$rs2[$i]['G233']+$rs2[$i]['G308']+$rs2[$i]['G350']+$rs2[$i]['G401']+$rs2[$i]['G404']+$rs2[$i]['G2055']+$rs2[$i]['G2070']+$rs2[$i]['G2075']+$rs2[$i]['G2080'];
            $rs2[$i]['G10'] = number_format($rs2[$i]['G10']);
            $rs2[$i]['G19'] = number_format($rs2[$i]['G19']);
            $rs2[$i]['G27'] = number_format($rs2[$i]['G27']);
            $rs2[$i]['G28'] = number_format($rs2[$i]['G28']);
            $rs2[$i]['G102'] = number_format($rs2[$i]['G102']);
            $rs2[$i]['G104'] = number_format($rs2[$i]['G104']);
            $rs2[$i]['G106'] = number_format($rs2[$i]['G106']);
            $rs2[$i]['G108'] = number_format($rs2[$i]['G108']);
            $rs2[$i]['G110'] = number_format($rs2[$i]['G110']);
            $rs2[$i]['G114'] = number_format($rs2[$i]['G114']);
            $rs2[$i]['G122'] = number_format($rs2[$i]['G122']);
            $rs2[$i]['G140'] = number_format($rs2[$i]['G140']);
            $rs2[$i]['G200'] = number_format($rs2[$i]['G200']);
            $rs2[$i]['G210'] = number_format($rs2[$i]['G210']);
            $rs2[$i]['G233'] = number_format($rs2[$i]['G233']);
			$rs2[$i]['G308'] = number_format($rs2[$i]['G308']);
			$rs2[$i]['G350'] = number_format($rs2[$i]['G350']);
			$rs2[$i]['G404'] = number_format($rs2[$i]['G404']);
			$rs2[$i]['G2055'] = number_format($rs2[$i]['G2055']);
			$rs2[$i]['G2070'] = number_format($rs2[$i]['G2070']);
			$rs2[$i]['G2075'] = number_format($rs2[$i]['G2075']);
			$rs2[$i]['G2080'] = number_format($rs2[$i]['G2080']);
			$rs2[$i]['sum'] = number_format($rs2[$i]['sum']);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('waste_count');
    }

    //当前损耗
    public function wasteNow(){
		$this->wasteNow2();
		return;
        $InsertDate = date("Y-m-d");
        $start_date = $InsertDate.' 00:00:00';
        $end_date = $InsertDate.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
        $result = array();
        $procedure = mssql_init("PHP_GameWasteCount",$conn);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        if($row = mssql_fetch_assoc($resource)){
                //$rs['game'] = $this->getGameName($rs[$i]['KindID']);
			$result['sum'] = $row['G10']+$row['G19']+$row['G27']+$row['G28']+$row['G102']+$row['G104']+$row['G106']+$row['G108']+$row['G110']+$row['G114']+$row['G122']+$row['G140']+$row['G200']+$row['G210']+$row['G233']+$row['G308']+$row['G404']+$row['G2055'];
            $result['G10'] = number_format($row['G10']);
            $result['G19'] = number_format($row['G19']);
            $result['G27'] = number_format($row['G27']);
            $result['G28'] = number_format($row['G28']);
            $result['G102'] = number_format($row['G102']);
            $result['G104'] = number_format($row['G104']);
            $result['G106'] = number_format($row['G106']);
            $result['G108'] = number_format($row['G108']);
            $result['G110'] = number_format($row['G110']);
            $result['G114'] = number_format($row['G114']);
            $result['G122'] = number_format($row['G122']);
            $result['G140'] = number_format($row['G140']);
            $result['G200'] = number_format($row['G200']);
            $result['G210'] = number_format($row['G210']);
            $result['G233'] = number_format($row['G233']);
			$result['G308'] = number_format($row['G308']);
			$result['G404'] = number_format($row['G404']);
			$result['G2055'] = number_format($row['G2055']);

        }
        mssql_free_statement($procedure);
		$mssql = M();
		$sql = 'select count(UserID) as Num FROM [QPAccountsDB].[dbo].[AccountsInfo](NOLOCK) where isandroid=0 and RegisterDate between "'.$start_date.'" and  "'.$end_date.'"';
		$rs2 = $mssql->query($sql);
        $count = $rs2[0]['Num'];
		$score = $count*5000;

		$result['sum'] = number_format($result['sum']);
        $result['date'] = date('Y-m-d H:i:s');
        $this->assign('result',$result);
		$this->assign('score',$score);
		$this->assign('count',$count);
        $this->display('waste_now');

    }

	//当前损耗
    public function wasteNow2(){
        $InsertDate = date("Y-m-d");
				$A="'".$InsertDate."'";
		$mssql = M();
		$conn=_open(3);
		//print_r($conn);
		$sql = 'select KindID,ServerID,WasteSum from QPTreasureDB.dbo.RecordDayWaste where InsertTime='.$A.'';
		$res = mssql_query($sql,$conn);
		while ($row = mssql_fetch_assoc($res)){
			$rs[]=$row;
		}
		//print_r($rs);
		foreach($rs as $k=>$v){
			$result['sum'] = $result['sum']+$rs[$k]['WasteSum'];
			$result['G'.$rs[$k]['KindID']] = $result['G'.$rs[$k]['KindID']]+$rs[$k]['WasteSum'];
		}
		//$result['G2055'] = 	$rs3[0]['total']*(-1);
		//$result['sum'] = $result['sum']+$result['G2060'];
		foreach($result as $k=>$v){
			$result[$k] = number_format($result[$k]);
		}
		//print_r($result);
		$sql2 = 'select count(UserID) as Num FROM [QPAccountsDB].[dbo].[AccountsInfo](NOLOCK) where isandroid=0 and RegisterDate > "'.$InsertDate.'"';
		$rs2 = $mssql->query($sql2);
        $count = $rs2[0]['Num'];
		$score = $count*5000;

		$sql3 = 'select sum(CardGold) as cz_num FROM [QPTreasureDB].[dbo].[ShareDetailInfo](NOLOCK) where ApplyDate > "'.$InsertDate.'"';
		$rs3 = $mssql->query($sql3);
        $cz_num = $rs3[0]['cz_num'];
		$score = number_format($score);
		$cz_num = number_format($cz_num);
        $result['date'] = date('Y-m-d H:i:s');
        $this->assign('result',$result);
		$this->assign('score',$score);
		$this->assign('count',$count);
		$this->assign('cz_num',$cz_num);
        $this->display('waste_now');

    }

	//损耗记录
	public function waste_record(){
		//$mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        $conn=_open(3);
		$InsertDate = date("Y-m-d");
		//print_r($conn);
		$sql3 = 'select sum(WasteSum) as zong from QPTreasureDB.dbo.RecordDayWaste where InsertTime="'.$InsertDate.'"';
		$res = mssql_query($sql3,$conn);
		$row = mssql_fetch_assoc($res);

        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.WasterCount2(NOLOCK)';
		$rs = mssql_query($sql1,$conn);
		$result = mssql_fetch_assoc($rs);
		$count = $result['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM (SELECT TOP ('.$num.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,CONVERT(varchar,InsertDate,120) as InsertDate ';
        $sql2.= 'FROM QPWebBackDB.dbo.WasterCount2(NOLOCK)';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $res2 = mssql_query($sql2,$conn);
		while ($row2 = mssql_fetch_assoc($res2)){
			$rs2[]=$row2;
		}
        for($i=0;$i<count($rs2);$i++){
        	$rs2[$i]['t0']=number_format($rs2[$i]['t0']);
        	$rs2[$i]['t1']=number_format($rs2[$i]['t1']);
        	$rs2[$i]['t2']=number_format($rs2[$i]['t2']);
        	$rs2[$i]['t3']=number_format($rs2[$i]['t3']);
        	$rs2[$i]['t4']=number_format($rs2[$i]['t4']);
        	$rs2[$i]['t5']=number_format($rs2[$i]['t5']);
        	$rs2[$i]['t6']=number_format($rs2[$i]['t6']);
        	$rs2[$i]['t7']=number_format($rs2[$i]['t7']);
        	$rs2[$i]['t8']=number_format($rs2[$i]['t8']);
        	$rs2[$i]['t9']=number_format($rs2[$i]['t9']);
        	$rs2[$i]['t10']=number_format($rs2[$i]['t10']);
        	$rs2[$i]['t11']=number_format($rs2[$i]['t11']);
        	$rs2[$i]['t12']=number_format($rs2[$i]['t12']);
        	$rs2[$i]['t13']=number_format($rs2[$i]['t13']);
        	$rs2[$i]['t14']=number_format($rs2[$i]['t14']);
        	$rs2[$i]['t15']=number_format($rs2[$i]['t15']);
        	$rs2[$i]['t16']=number_format($rs2[$i]['t16']);
        	$rs2[$i]['t17']=number_format($rs2[$i]['t17']);
        	$rs2[$i]['t18']=number_format($rs2[$i]['t18']);
        	$rs2[$i]['t19']=number_format($rs2[$i]['t19']);
        	$rs2[$i]['t20']=number_format($rs2[$i]['t20']);
        	$rs2[$i]['t21']=number_format($rs2[$i]['t21']);
        	$rs2[$i]['t22']=number_format($rs2[$i]['t22']);
        	$rs2[$i]['t23']=number_format($rs2[$i]['t23']);
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
		$this->assign('zong',$row['zong']);
        $this->assign('result',$rs2);
        $this->display('waste_record');



	}

	//最近游戏
    public function game_newly(){
        $conn=mssql_connect($GLOBALS['DB_RECORD_12']['DB_HOST'],$GLOBALS['DB_RECORD_12']['DB_USER'],$GLOBALS['DB_RECORD_12']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_RECORD_12']['DB_NAME']);
        $rs = array();
        $procedure = mssql_init("PHP_UserGameNewly",$conn);

        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
        mssql_close($conn);

        for($i=0;$i<count($rs);$i++){
    		$rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
    		$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['TableID'] = $rs[$i]['TableID']+1;
			if($rs[$i]['UserCount']>1){
				$result[$i]['UserID']=explode('/',substr($rs[$i]['UserIDInfo'],0,-1));
    			$result[$i]['NickName']=explode('/',substr(iconv("GBK","UTF-8",$rs[$i]['NickInfo']),0,-1)) ;
    			$result[$i]['Score']=explode('/',substr($rs[$i]['ScoreInfo'],0,-1));
    			for($j=0;$j<$rs[$i]['UserCount'];$j++){
    				$rs[$i]['users'][$j]['UserID']=$result[$i]['UserID'][$j];
    				$rs[$i]['users'][$j]['NickName']=$result[$i]['NickName'][$j];
    				$rs[$i]['users'][$j]['Score']=$result[$i]['Score'][$j];
    			}
			}
			//$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);
		}
        $this->assign('rs',$rs);
        $this->display('game_newly');
    }

	//登录日志
    public function login_record(){
        $GameID = $_GET['GameID'];
        if(!$GameID){
            $this->display('login_record');
        }else{
            $mssql = M();
            $type=$_GET['type'];
            if($type==1){
            	$sql = 'select top 200 t1.UserID,t1.IP,t1.Machine,t1.Area,t1.Version,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t2.GameID,t2.NickName from QPAccountsDB.dbo.UserLoginRecord3(nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID where t2.GameID='.$GameID.' and t1.Area=0 order by InsertTime desc';
            }elseif($type==2){
            	$sql = 'select top 200 t1.UserID,t1.IP,t1.Machine,t1.Area,t1.Version,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t2.GameID,t2.NickName from QPAccountsDB.dbo.UserLoginRecord3(nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID where t2.GameID='.$GameID.' and t1.Area>0 order by InsertTime desc';
            }elseif($type==3){
            	$sql = 'select top 200 t1.UserID,t1.IP,t1.Machine,t1.Area,t1.Version,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t2.GameID,t2.NickName from QPAccountsDB.dbo.UserLoginRecord3(nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID where t2.GameID='.$GameID.' order by InsertTime desc';
            }
            $rs = $mssql->query($sql);
            for($i=0;$i<count($rs);$i++){
                $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
                $rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['IP']);
            }

            $this->assign('result',$rs);
            $this->display('login_record');
        }
    }


	//328之前登录日志
    public function login_record_old(){
        $GameID = $_GET['GameID'];
        if(!$GameID){
            $this->display('login_record_old');
        }else{
            $mssql = M();
            $sql = 'select top 200 t1.UserID,t1.IP,t1.Machine,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t2.GameID,t2.NickName from QPAccountsDB.dbo.UserLoginRecord2(nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID where t2.GameID='.$GameID.' order by InsertTime desc';
            $rs = $mssql->query($sql);
            for($i=0;$i<count($rs);$i++){
                $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
                $rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['IP']);
            }

            $this->assign('result',$rs);
            $this->display('login_record_old');
        }
    }

	//在线详细分类
    public function online_list(){
        $mssql = M();
        $sql = 'select KindID,KindName from QPPlatformDB.dbo.GameKindItem(nolock) where Nullity=0 order by KindID';
        $rs = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
            $rs[$i]['count'] = $this->getOnlineCountByKindID($rs[$i]['KindID']);
			$rs[$i]['count_ff'] = $this->getOnlineFFCountByKindID($rs[$i]['KindID']);
        }
        $this->assign('result',$rs);
        $this->display('online_list');
    }

    //查询各游戏在线人数
    public function getOnlineCountByKindID($KindID){
        $mssql = M();
        $sql = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID=t2.UserID where t1.KindID='.$KindID.' and t2.MemberOrder=0 and t2.MasterRight=0';
        $rs = $mssql->query($sql);
        if($rs){
            return $rs[0]['num'];
        }else{
            return 0;
        }

    }

	//查询各游戏在线付费人数
    public function getOnlineFFCountByKindID($KindID){
        $mssql = M();
        $sql = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID=t2.UserID where t1.KindID='.$KindID.' and t2.MemberOrder=0 and t2.MasterRight=0 and (LockMobileFrom>0 or CustomID>0)';
        $rs = $mssql->query($sql);
        if($rs){
            return $rs[0]['num'];
        }else{
            return 0;
        }

    }

    //游戏在线人数详细信息
    public function online_KindID(){
        $KindID = $_GET['KindID'];
        $conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
        $rs = array();
		$score_total=0;
		$insure_total=0;
		$total=0;
        $procedure = mssql_init("PHP_OnlineUserInfo3",$conn);
        mssql_bind($procedure,"@KindID", $KindID, SQLINT4);
        $resource = mssql_execute($procedure);
            while($row = mssql_fetch_assoc($resource)){
                $rs[] = $row;
            }
        mssql_free_statement($procedure);
        mssql_close($conn);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1;
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            $rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$score_total=$score_total+$rs[$i]['Score'];
			$insure_total=$insure_total+$rs[$i]['InsureScore'];
            $rs[$i]['Total'] = number_format($rs[$i]['sum']);
            $rs[$i]['Score'] = number_format($rs[$i]['Score']);
            $rs[$i]['Score_sum'] = number_format($rs[$i]['Score_sum']);
            $rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
        }
		$total=$score_total+$insure_total;
		$score_total = number_format($score_total);
		$insure_total = number_format($insure_total);
		$total = number_format($total);
        $this->assign('result',$rs);
		$this->assign('score_total',$score_total);
		$this->assign('insure_total',$insure_total);
		$this->assign('total',$total);
        $this->display('online_KindID');

    }

	//游戏输赢
    public function game_win(){
        $KindID = $_GET['KindID'];
		if(isset($_GET['type'])){
        	$Type=$_GET['type'];
        }else{
			$Type=1;
        }
        $mssql = M();
        $sql = 'select GameName from QPPlatformDB.dbo.GameGameItem(NOLOCK) where GameID='.$KindID;
        $rs_name = $mssql->query($sql);
        if($KindID>0 && $KindID<2060){
        	$conn=_open(4);
        }
        $rs = array();
        $procedure = mssql_init("PHP_GameWin",$conn);
        mssql_bind($procedure,"@KindID", $KindID, SQLINT4);
		mssql_bind($procedure,"@Type", $Type, SQLINT4);
        $resource = mssql_execute($procedure);
            while($row = mssql_fetch_assoc($resource)){
                $rs[] = $row;
            }
        mssql_free_statement($procedure);
        mssql_close($conn);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1;
            $rs[$i]['User']=$this->getInfoByUserID($rs[$i]['UserID']);
            $rs[$i]['win'] = number_format($rs[$i]['win']);
        }
        $this->assign('result',$rs);
		$this->assign('KindID',$KindID);
        $this->assign('name',iconv("GBK","UTF-8",$rs_name[0]['GameName']));
        $this->display('game_win');

    }

	public function un_game(){
		if($_GET['date']){
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
		if($_GET['GameID']){
			$GameID=$_GET['GameID'];
        //$date = '2014-09-17';$A="'".$id."'";
        $start_date = $date.' 00:00:00';
        $end_date = $date.' 23:59:59';

				//echo $start_date;die;
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
		$rs2 = array();
        $procedure = mssql_init("PHP_DayUnGame3",$conn);
		mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);

		$procedure2 = mssql_init("PHP_DayUnGame4",$conn);
		mssql_bind($procedure2,"@GameID", $GameID, SQLINT4);
        mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
        $resource2 = mssql_execute($procedure2);
        while($row2 = mssql_fetch_assoc($resource2)){
            $rs2[] = $row2;
        }
        mssql_free_statement($procedure2);

        mssql_close($conn);
        for($i=0;$i<count($rs);$i++){
            //$rs[$i]['no'] = $i+1;
            //$rs[$i]['User'] = $this->getInfoByUserID($rs[$i]['UserID']);
            $rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
        }

		for($i=0;$i<count($rs2);$i++){
            //$rs[$i]['User'] = $this->getInfoByUserID($rs[$i]['UserID']);
            $rs2[$i]['SwapScore'] = number_format($rs2[$i]['SwapScore']);
			$rs2[$i]['NickName1'] = iconv("GBK","UTF-8",$rs2[$i]['NickName1']);
			$rs2[$i]['NickName2'] = iconv("GBK","UTF-8",$rs2[$i]['NickName2']);
        }
		$this->assign('GameID',$GameID);
        $this->assign('result',$rs);
		$this->assign('result2',$rs2);
		}

		$this->assign('date',$date);
        $this->display('un_game');
    }
	public function un_game2(){
		if($_GET['date']){
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
		$UserD=$_GET['UserID'];
        //$date = '2014-09-17';
        $start_date = $date.' 00:00:00';
        $end_date = $date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
        $procedure = mssql_init("PHP_DayUnGame2",$conn);
		mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
        mssql_close($conn);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1;
            //$rs[$i]['User'] = $this->getInfoByUserID($rs[$i]['UserID']);
            $rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
        }
        $this->assign('result',$rs);
		$this->assign('date',$date);
        $this->display('un_game2');
    }

	//每日充值统计
    public function charge_count(){
        $mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.ChargeCount(nolock)';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT zfb,app,yb,wx,total,o3,InsertDate FROM (SELECT TOP ('.$num.') zfb,app,yb,wx,total,o3,InsertDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') zfb,app,yb,wx,(zfb+app+wx+yb) as total,o3,CONVERT(varchar,InsertDate,120) as InsertDate ';
        $sql2.= 'FROM QPWebBackDB.dbo.ChargeCount(nolock)';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
            //$rs2[$i]['zfb'] = number_format($rs2[$i]['zfb']);
			$rs2[$i]['o3'] = number_format($rs2[$i]['o3']);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('charge_count');
    }

	//库存统计
    public function userCc(){
        $mssql = M();
        $InsertDate = date('Y-m-d');
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.UserGoldSum(nolock)';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM (SELECT TOP ('.$num.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,CONVERT(varchar,InsertDate,120) as InsertDate ';
        $sql2.= 'FROM QPWebBackDB.dbo.UserGoldSum(nolock)';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
        }
        $sql3 = 'SELECT sum(Score)+sum(InsureScore) as gold_sum FROM QPTreasureDB.dbo.GameScoreInfo(NOLOCK) where UserID in (5596626,3839304)';
        $rs3 = $mssql->query($sql3);
        $cc_count = $rs3[0]['gold_sum'];
        $cc_count = sprintf("%.2f", $cc_count/100000000);

        $pageNum = ceil($count/$pageSize);

        $this->assign('cc_count',$cc_count);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('user_cccount');
    }

	//查询个人游戏所得
    public function getGameSum(){
        $mssql = M();
        $UserID = $_GET['UserID'];
        $sql = 'select sum(Score) as total from QPTreasureDB.dbo.RecordDrawScore(NOLOCK) where UserID='.$UserID;
        $rs = $mssql->query($sql);
        $total = $rs[0]['total'];
        _location($rs[0]['total'],$_SERVER["HTTP_REFERER"]);
    }

	//VIP游戏记录
    public function vipRecord(){
	//echo 11;
	//exit;
        if($_GET['start_date']&&$_GET['end_date']){
            $date1 = $_GET['start_date'];
            $date2 = $_GET['end_date'];
            $date3 = strtotime($date1);
            $date4 = strtotime($date2);
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
            $this->assign('start_date',date('Y-m-d'));
            $this->assign('end_date',date('Y-m-d'));
        }

		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);

        $rs = array();
        $procedure2 = mssql_init("PHP_VipGameNewly",$conn);
        mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
        $resource2 = mssql_execute($procedure2);
        while($row = mssql_fetch_assoc($resource2)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure2);
        mssql_close($conn);
		//print_r($rs);

        for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            $rs[$i]['Score'] = number_format($rs[$i]['Score']);
        }
		//print_r($rs);

		//echo $pageNum;
    	$this->assign('pageNum',$pageNum);
        $this->assign('rs',$rs);
        $this->display('vip_newly');
    }

	//充值记录
   public function cz_list(){
        $mssql = M();
        $pageSize = 50;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(UserID) as num from QPTreasureDB.dbo.ShareDetailInfo(NOLOCK)';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT DetailID,UserID,GameID,Accounts,NickName,LockMobileFrom,RegisterFrom,Present,OrderID,BeforeGold,PayAmount,ApplyDate FROM (SELECT TOP ('.$num.') DetailID,UserID,GameID,Accounts,NickName,LockMobileFrom,RegisterFrom,Present,OrderID,BeforeGold,PayAmount,ApplyDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.DetailID,t1.GameID,t1.Accounts,t2.Present,t2.NickName,t2.LockMobileFrom,t2.RegisterFrom,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate ';
        $sql2.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
        $sql2.= 'order by t1.DetailID desc) t4 order by DetailID asc) t5 order by DetailID desc';

        $rs2 = $mssql->query($sql2);

        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
            $rs2[$i]['BeforeGold'] = number_format($rs2[$i]['BeforeGold']);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('cz_list');
   }

   //充值记录
   public function cz_search(){
        $mssql = M();
		$GameID = $_GET['GameID'];
        $sql.= 'SELECT t1.UserID,t1.GameID,t1.Accounts,t2.NickName,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate ';
        $sql.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.GameID='.$GameID;
        $sql.= ' order by ApplyDate desc';

        $rs = $mssql->query($sql);

        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1;
            $rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            $rs[$i]['BeforeGold'] = number_format($rs[$i]['BeforeGold']);
		}
        $this->assign('result',$rs);
        $this->display('cz_search');
   }

	//在线IP
   public function onlineIP(){
        $mssql = M();
        $sql = 'select UserID,GameID,Accounts,NickName,PassPortID,RegisterMobile,RegisterIP,RegisterMachine,LastLogonIP,LastLogonMachine from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where UserID in (select UserID from [QPTreasureDB].[dbo].[GameScoreLocker](NOLOCK) group by UserID)';
        $rs = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
	    $rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
        }
        $this->assign('rs',$rs);
        $this->display('online_ip');

    }
	//输赢查询
    public function winsearch(){
        $this->assign('start_date',date('Y-m-d',time()-86400*7));
        $this->assign('end_date',date('Y-m-d',time()));
        $this->display('winsearch');
    }
	//输赢查询结果
    public function winresult(){
        $type = $_GET['type'];
        $GameID = $_GET['GameID'];
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $mssql=M();
        if($type == 1){
            $sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.win from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join
(select UserID,sum(Score) as win from QPTreasureDB.dbo.RecordUserDaySum(NOLOCK) where InsertTime
between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" group by UserID) t2 on t1.UserID=t2.UserID where t2.win<>0 and t1.GameID='.$GameID;
        }elseif($type==2){
            $sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.win from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join
(select UserID,sum(Score) as win from QPTreasureDB.dbo.RecordUserDaySum(NOLOCK) where InsertTime
between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" group by UserID) t2 on t1.UserID=t2.UserID where t2.win<>0 and RegisterIP="'.$GameID.'"';
        }elseif($type==3){
            $sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.win from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join
(select UserID,sum(Score) as win from QPTreasureDB.dbo.RecordUserDaySum(NOLOCK) where InsertTime
between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" group by UserID) t2 on t1.UserID=t2.UserID where t2.win<>0 and LastLogonIP="'.$GameID.'"';
        }elseif($type==4){
            $sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.win from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join
(select UserID,sum(Score) as win from QPTreasureDB.dbo.RecordUserDaySum(NOLOCK) where InsertTime
between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" group by UserID) t2 on t1.UserID=t2.UserID where t2.win<>0 and RegisterMachine="'.$GameID.'"';
        }elseif($type==5){
            $sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.win from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join
(select UserID,sum(Score) as win from QPTreasureDB.dbo.RecordUserDaySum(NOLOCK) where InsertTime
between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" group by UserID) t2 on t1.UserID=t2.UserID where t2.win<>0 and LastLogonMachine="'.$GameID.'"';
        }elseif($type==6){
            $sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.win from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join
(select UserID,sum(Score) as win from QPTreasureDB.dbo.RecordUserDaySum(NOLOCK) where InsertTime
between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" group by UserID) t2 on t1.UserID=t2.UserID where t2.win<>0 and PassPortID="'.$GameID.'"';
        }
        if($rs = $mssql->query($sql)){
            for($i=0;$i<count($rs);$i++){
                $rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
                $rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
                $total = $total+$rs[$i]['win'];
                $rs[$i]['win'] = number_format($rs[$i]['win']);
            }
            $total = number_format($total);
            $this->assign('result',$rs);
            $this->assign('total',$total);
        }
        $this->assign('start_date',$start_date);
        $this->assign('end_date',$end_date);
        $this->display('winsearch');

    }

	public function LoginBy(){
		$mssql = M();
		if($_GET['date']){
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
		$this->assign('date',$date);
		$date = $date.' 00:00:00';
        $sql = 'select IOS,Android,PC,Hour,Fufei,FF_IOS,FF_and,FF_pc from QPWebBackDB.dbo.LoginByCount where InsertDate="'.$date.'" order by Hour';
        $rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['Hour'] = $rs[$i]['Hour']+1;
			$rs[$i]['zong'] = $rs[$i]['zong']+$rs[$i]['IOS']+$rs[$i]['PC']+$rs[$i]['Android'];
            $total['IOS'] = $total['IOS']+$rs[$i]['IOS'];
			$total['Android'] = $total['Android']+$rs[$i]['Android'];
			$total['PC'] = $total['PC']+$rs[$i]['PC'];
			$total['zong'] = $total['zong']+$rs[$i]['zong'];
			$total['Fufei'] = $total['Fufei']+$rs[$i]['Fufei'];
		}
        $this->assign('rs',$rs);
		$this->assign('total',$total);
        $this->display('login_by');
	}

	//撤销记录
    public function cancelList(){
        $mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        $sql1 = 'select count(ID) as num from QPTreasureDB.dbo.CancelInsure';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }
        $sql2 = 'SELECT SourceUserID,TargetUserID,SwapScore,CollectNote,Manager,GameID1,NickName1,GameID2,NickName2,InsertDate,CollectDate FROM (SELECT TOP ('.$num.') SourceUserID,TargetUserID,SwapScore,CollectNote,Manager,GameID1,NickName1,GameID2,NickName2,InsertDate,CollectDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.')  t1.SourceUserID,t1.TargetUserID,t1.SwapScore,t1.CollectNote,t1.Manager,CONVERT(varchar,t1.CollectDate,120) as CollectDate,CONVERT(varchar,t1.InsertDate,120) as InsertDate,t2.GameID as GameID1,t2.NickName as NickName1,t3.GameID as GameID2,t3.NickName as NickName2 ';
        $sql2.= 'FROM QPTreasureDB.dbo.CancelInsure(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.SourceUserID = t2.UserID left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3 on t1.TargetUserID=t3.UserID ';
        $sql2.= 'order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
            $rs2[$i]['NickName1'] = iconv("GBK","UTF-8",$rs2[$i]['NickName1']);
            $rs2[$i]['NickName2'] = iconv("GBK","UTF-8",$rs2[$i]['NickName2']);
			$rs2[$i]['CollectNote'] = iconv("GBK","UTF-8",$rs2[$i]['CollectNote']);
            $rs2[$i]['SwapScore'] = number_format($rs2[$i]['SwapScore']);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('cancel_list');
    }

	//掉线记录
	public function dxList(){
		if($_GET['type']){
			$type = $_GET['type'];
		}else{
			$type=1;
		}
		$mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        if($type==1){
			$sql1 = 'select count(id) as num from QPAccountsDB.dbo.UserDxRecord2(NOLOCK)';
		}else{
			$sql1 = 'select count(id) as num from QPAccountsDB.dbo.UserDxRecord2(NOLOCK) where Score+InsureScore>300000';
		}


        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];
		if($count>300){
			$count=300;
		}

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }
		if($type==1){
			$sql2 = 'SELECT id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM (SELECT TOP ('.$num.') id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM ';
			$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.id,t1.UserID,t1.ip,t1.Machine,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t1.Score,t1.InsureScore,t1.ServerName,t2.GameID,t2.NickName ';
			$sql2.= 'FROM QPAccountsDB.dbo.UserDxRecord2(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql2.= 'order by id desc) t4 order by id asc) t5 order by id desc';
		}else{
			$sql2 = 'SELECT id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM (SELECT TOP ('.$num.') id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM ';
			$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.id,t1.UserID,t1.ip,t1.Machine,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t1.Score,t1.InsureScore,t1.ServerName,t2.GameID,t2.NickName ';
			$sql2.= 'FROM QPAccountsDB.dbo.UserDxRecord2(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.Score+t1.InsureScore>300000 ';
			$sql2.= 'order by id desc) t4 order by id asc) t5 order by id desc';
		}

		if(isset($_GET['GameID'])){
			$sql2 = 'SELECT id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM (SELECT TOP ('.$num.') id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM ';
			$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.id,t1.UserID,t1.ip,t1.Machine,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t1.Score,t1.InsureScore,t1.ServerName,t2.GameID,t2.NickName ';
			$sql2.= 'FROM QPAccountsDB.dbo.UserDxRecord2(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.GameID='.$_GET['GameID'];
			$sql2.= ' order by id desc) t4 order by id asc) t5 order by id desc';
		}


        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
			$rs2[$i]['ServerName'] = iconv("GBK","UTF-8",$rs2[$i]['ServerName']);
			$rs2[$i]['Re_city'] = $this->getIpPlace($rs2[$i]['ip']);
			$rs2[$i]['Total'] = $rs2[$i]['Score']+$rs2[$i]['InsureScore'];
			$rs2[$i]['Score'] = number_format($rs2[$i]['Score']);
			$rs2[$i]['InsureScore'] = number_format($rs2[$i]['InsureScore']);
			$rs2[$i]['Total'] = number_format($rs2[$i]['Total']);
        }
        $pageNum = ceil($count/$pageSize);
        $this->assign('type',$type);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('dx_list');
	}

	//掉线记录
	public function dxList2(){
		if($_GET['type']){
			$type = $_GET['type'];
		}else{
			$type=1;
		}
		$mssql = M();
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        if($type==1){
			$sql1 = 'select count(id) as num from QPAccountsDB.dbo.UserDxRecord(NOLOCK)';
		}else{
			$sql1 = 'select count(id) as num from QPAccountsDB.dbo.UserDxRecord(NOLOCK) where Score+InsureScore>300000';
		}


        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];
		if($count>300){
			$count=300;
		}

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }
		if($type==1){
			$sql2 = 'SELECT id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM (SELECT TOP ('.$num.') id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM ';
			$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.id,t1.UserID,t1.ip,t1.Machine,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t1.Score,t1.InsureScore,t1.ServerName,t2.GameID,t2.NickName ';
			$sql2.= 'FROM QPAccountsDB.dbo.UserDxRecord(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID ';
			$sql2.= 'order by id desc) t4 order by id asc) t5 order by id desc';
		}else{
			$sql2 = 'SELECT id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM (SELECT TOP ('.$num.') id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM ';
			$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.id,t1.UserID,t1.ip,t1.Machine,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t1.Score,t1.InsureScore,t1.ServerName,t2.GameID,t2.NickName ';
			$sql2.= 'FROM QPAccountsDB.dbo.UserDxRecord(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.Score+t1.InsureScore>300000 ';
			$sql2.= 'order by id desc) t4 order by id asc) t5 order by id desc';
		}

		if(isset($_GET['GameID'])){
			$sql2 = 'SELECT id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM (SELECT TOP ('.$num.') id,UserID,GameID,ip,NickName,Machine,InsertTime,loginFrom,Score,InsureScore,ServerName FROM ';
			$sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.id,t1.UserID,t1.ip,t1.Machine,CONVERT(varchar,t1.time,120) as InsertTime,t1.loginFrom,t1.Score,t1.InsureScore,t1.ServerName,t2.GameID,t2.NickName ';
			$sql2.= 'FROM QPAccountsDB.dbo.UserDxRecord(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.GameID='.$_GET['GameID'];
			$sql2.= ' order by id desc) t4 order by id asc) t5 order by id desc';
		}


        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
			$rs2[$i]['ServerName'] = iconv("GBK","UTF-8",$rs2[$i]['ServerName']);
			$rs2[$i]['Re_city'] = $this->getIpPlace($rs2[$i]['ip']);
			$rs2[$i]['Total'] = $rs2[$i]['Score']+$rs2[$i]['InsureScore'];
			$rs2[$i]['Score'] = number_format($rs2[$i]['Score']);
			$rs2[$i]['InsureScore'] = number_format($rs2[$i]['InsureScore']);
			$rs2[$i]['Total'] = number_format($rs2[$i]['Total']);
        }
        $pageNum = ceil($count/$pageSize);
        $this->assign('type',$type);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('dx_list2');
	}

	//测试账号列表
	public function userTest(){
		$mssql = M();
		$sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t2.ServerID,t3.Score,t3.InsureScore from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreLocker(NOLOCK) t2 on t1.UserID=t2.UserID ';
		$sql.= 'left join QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t3 on t1.UserID=t3.UserID where t1.ProtectID=1';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
            $rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Total'] = $rs[$i]['Score']+$rs[$i]['InsureScore'];
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Total'] = number_format($rs[$i]['Total']);
			if($rs[$i]['ServerID']==null){
				$rs[$i]['game'] = '不在线';
			}else{
				$room = $this->game_room($rs[$i]['UserID']);
				$rs[$i]['game'] = $room[0]['GameName'].'--'.$room[0]['ServerName'];
			}
        }
		$this->assign('result',$rs);
		$this->display('user_test');

	}

	public function suoyou(){
        $mssql = M();
        $InsertDate = date('Y-m-d');
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.UserGoldSum2';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM (SELECT TOP ('.$num.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,CONVERT(varchar,InsertDate,120) as InsertDate ';
        $sql2.= 'FROM QPWebBackDB.dbo.UserGoldSum2';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
        }
        $sql3 = 'SELECT t1.Score,t1.InsureScore FROM QPTreasureDB.dbo.GameScoreInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID where t1.UserID not in (1849507,1146876,1831539,1171077,1311882,1489904,1332829,2765997,3839304,3972171,4873691,5596626) and t2.memberorder>0 ';
        $rs3 = $mssql->query($sql3);
		//print_r($rs3);
		for($i=1;$i<count($rs3);$i++){
			$cc_count = $cc_count+$rs3[$i]['Score']+$rs3[$i]['InsureScore'];
		}
		//echo array_sum($rs3);
        $cc_count = sprintf("%.2f", $cc_count/100000000);

        $pageNum = ceil($count/$pageSize);

        $this->assign('cc_count',$cc_count);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('user_suoyou');
    }

	public function all(){
        $mssql = M();
        $InsertDate = date('Y-m-d');
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }

        $sql1 = 'select count(ID) as num from QPWebBackDB.dbo.UserGoldSum3';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];

        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM (SELECT TOP ('.$num.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,InsertDate FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t0,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,CONVERT(varchar,InsertDate,120) as InsertDate ';
        $sql2.= 'FROM QPWebBackDB.dbo.UserGoldSum3';
        $sql2.= ' order by InsertDate desc) t4 order by InsertDate asc) t5 order by InsertDate desc';
        $rs2 = $mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['InsertDate'] = substr($rs2[$i]['InsertDate'],0,10);
        }
        $sql3 = 'SELECT (sum(Score)+sum(InsureScore)) as gold_sum FROM QPTreasureDB.dbo.GameScoreInfo(NOLOCK)';
        $rs3 = $mssql->query($sql3);
        $cc_count = $rs3[0]['gold_sum'];
        $cc_count = sprintf("%.2f", $cc_count/100000000);

        $pageNum = ceil($count/$pageSize);

        $this->assign('cc_count',$cc_count);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('user_all');
    }

	//返利查询
	function fl(){
    	$this->display('fl');
    }

	function fl_search(){
		$mssql = M();
		$GameID=$_GET['GameID'];
		$sql = 'select t2.NowScore,t1.UserID,t1.NickName from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.UserRefereeScoreInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t1.GameID='.$GameID;
		if($rs=$mssql->query($sql)){
			$NowScore=number_format($rs[0]['NowScore']);
			$UserID = $rs[0]['UserID'];
			$NickName = iconv("GBK","UTF-8",$rs[0]['NickName']);
		}else{
			_location("无此ID记录",WEB_ROOT."index.php/User/fl");
			return;
		}

		$sql2='SELECT top 100 ChangeScore,CONVERT(varchar,ChangeDateTime,120) AS ChangeDateTime FROM QPTreasureDB.dbo.ChangeRecordInfo(NOLOCK) where UserID='.$UserID.' order by ChangeDateTime desc';
		$rs2=$mssql->query($sql2);
		for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['ChangeScore'] = number_format($rs2[$i]['ChangeScore']);
        }

		$this->assign('NowScore',$NowScore);
		$this->assign('NickName',$NickName);
		$this->assign('rs2',$rs2);
    	$this->display('fl_result');
    }

	//进出查询
	function jc(){
		$this->assign('start_date',date('Y-m-d'));
		$this->assign('end_date',date('Y-m-d'));
    	$this->display('jc');
    }

	function jc_search(){
		$mssql = M();
		$GameID=$_GET['GameID'];
		$GameID2=$_GET['GameID2'];
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];

		$sql = 'select UserID,NickName from QPAccountsDB.dbo.AccountsInfo where GameID ='.$GameID;
		if($rs=$mssql->query($sql)){
			$NickName = iconv("GBK","UTF-8",$rs[0]['NickName']);
			$UserID = $rs[0]['UserID'];
		}else{
			_location("无此ID记录",WEB_ROOT."index.php/User/jc");
			return;
		}
		$sql5 = 'select UserID,NickName from QPAccountsDB.dbo.AccountsInfo where GameID ='.$GameID2;
		if($rs5=$mssql->query($sql5)){
			$NickName2 = iconv("GBK","UTF-8",$rs5[0]['NickName']);
			$UserID2 = $rs5[0]['UserID'];
		}else{
			_location("无此ID记录",WEB_ROOT."index.php/User/jc");
			return;
		}
		//echo $UserID;
		//echo $UserID2;

		$sql2='SELECT SourceUserID,TargetUserID,SwapScore,CONVERT(varchar,CollectDate,120) AS CollectDate FROM QPTreasureDB.dbo.RecordInsure ';
		$sql2.='where SourceUserID='.$UserID.' and TargetUserID='.$UserID2.' and CollectDate between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" order by CollectDate desc';
		$rs2=$mssql->query($sql2);
		//echo $sql2.'</br>';
		//print_r($rs2);
		for($i=0;$i<count($rs2);$i++){
			$sum1 = $sum1+$rs2[$i]['SwapScore'];
			$rs2[$i]['no'] = $i+1;
			$rs2[$i]['SwapScore'] = number_format($rs2[$i]['SwapScore']);
			$rs2[$i]['NickName1']= $NickName;
			$rs2[$i]['NickName2']= $NickName2;
        }
		$sql3='SELECT SourceUserID,TargetUserID,SwapScore,CONVERT(varchar,CollectDate,120) AS CollectDate FROM QPTreasureDB.dbo.RecordInsure ';
		$sql3.='where SourceUserID='.$UserID2.' and TargetUserID='.$UserID.' and CollectDate between "'.$start_date.' 00:00:00" and "'.$end_date.' 23:59:59" order by CollectDate desc';
		$rs3=$mssql->query($sql3);
		for($j=0;$j<count($rs3);$j++){
			$sum2 = $sum2+$rs3[$j]['SwapScore'];
			$rs3[$j]['no'] = $j+1;
			$rs3[$j]['SwapScore'] = number_format($rs3[$j]['SwapScore']);
			$rs3[$j]['NickName1']= $NickName2;
			$rs3[$j]['NickName2']= $NickName;
        }
		$sum1 = number_format($sum1);
		$sum2 = number_format($sum2);

		$this->assign('GameID',$GameID);
		$this->assign('GameID2',$GameID2);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('sum1',$sum1);
		$this->assign('sum2',$sum2);
		$this->assign('NickName',$NickName);
		$this->assign('NickName2',$NickName2);
		$this->assign('rs2',$rs2);
		$this->assign('rs3',$rs3);

    	$this->display('jc_result');
    }

	//最近200条离开记录
	public function new_lk(){

        $rs=array();
        $conn2=_open(2);
        $rs2 = array();

        $procedure2 = mssql_init("ADMIN_LastLeave",$conn2);

        $resource2 = mssql_execute($procedure2);
        while($row2 = mssql_fetch_assoc($resource2)){
            $rs2[] = $row2;
        }
        mssql_free_statement($procedure2);

        $conn3=_open(3);
        $rs3 = array();

        $procedure3 = mssql_init("ADMIN_LastLeave",$conn3);

        $resource3 = mssql_execute($procedure3);
        while($row3 = mssql_fetch_assoc($resource3)){
            $rs3[] = $row3;
        }
        mssql_free_statement($procedure3);

        $conn4=_open(4);
        $rs4 = array();

        $procedure4 = mssql_init("ADMIN_LastLeave",$conn4);

        $resource4 = mssql_execute($procedure4);
        while($row4 = mssql_fetch_assoc($resource4)){
            $rs4[] = $row4;
        }
        mssql_free_statement($procedure4);

		$conn5=_open(5);
        $rs5 = array();

        $procedure5 = mssql_init("ADMIN_LastLeave",$conn5);

        $resource5 = mssql_execute($procedure5);
        while($row5= mssql_fetch_assoc($resource5)){
            $rs5[] = $row5;
        }
        mssql_free_statement($procedure5);

		$conn6=_open(6);
        $rs6 = array();

        $procedure6 = mssql_init("ADMIN_LastLeave",$conn6);

        $resource6 = mssql_execute($procedure6);
        while($row6= mssql_fetch_assoc($resource6)){
            $rs6[] = $row6;
        }
        mssql_free_statement($procedure6);


        mssql_close($conn2);
        mssql_close($conn3);
        mssql_close($conn4);
		mssql_close($conn5);
		mssql_close($conn6);
        $rs=array_merge_recursive($rs2,$rs3,$rs4,$rs5,$rs6);
        foreach ($rs as $key => $row) {
			$volume[$key] = $row['LeaveTime'];
		}
 		array_multisort($volume,SORT_DESC,SORT_STRING,$rs);
        //print_r($rs);
        //print_r($rs3);
        //print_r($rs4);
        //exit;

        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
            $rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
            $rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
        }

        $this->assign('rs',$rs);
        $this->display('new_lk');


	}

	//在线充值用户
	public function online_cz(){
		$start_date = date("Y-m-d",strtotime('-3 day'));
		$end_date = date('Y-m-d H:i:s');
		$mssql = M();
		$sql = 'select t6.UserID,t6.GameID,t6.NickName,t6.Score,t6.InsureScore,t6.KindName,t6.ServerName,t7.num,t7.Score_num from (select t1.UserID,t2.GameID,t2.NickName,t3.Score,t3.InsureScore,t4.KindName,t5.ServerName ';
		$sql.= 'from QPTreasureDB.dbo.GameScoreLocker(nolock) t1,QPAccountsDB.dbo.AccountsInfo(nolock) t2,QPTreasureDB.dbo.GameScoreInfo(nolock) t3,QPPlatformDB.dbo.GameKindItem(nolock) t4,';
		$sql.= 'QPPlatformDB.dbo.GameRoomInfo(nolock) t5 where t1.UserID = t2.UserID and t1.UserID=t3.UserID and t1.ServerID = t5.ServerID and t1.KindID = t4.KindID)t6 left join ';
		$sql.= '(select UserID,SUM(PayAmount) as num,SUM(CardGold) as Score_num from QPTreasureDB.dbo.ShareDetailInfo(nolock) where ApplyDate between "'.$start_date.'" and "'.$end_date.'"group by UserID) t7 on t6.UserID=t7.UserID where t7.num>0';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = $rs[$i]['Score']+$rs[$i]['InsureScore'];
			$rs[$i]['Total'] = number_format($rs[$i]['Total']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Score_num'] = number_format($rs[$i]['Score_num']);
		}
		$this->assign('result',$rs);
		$this->display('online_cz');
	}

	//批量屏蔽
	public function plpb(){
		$this->display('plpb');
	}

	public function pb_se(){
		//_back('暂时关闭');
		$mac = $_GET['mac'];
		$mssql = M();
		$sql = 'select count(t3.UserID) as num,sum(t3.Score+t3.InsureScore) as sum from(select t1.UserID,t2.Score,t2.InsureScore from QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t2 on t1.UserID=t2.UserID where t1.IsAndroid=0 and t1.LastLogonMachine="'.$mac.'")t3';
		$rs = $mssql->query($sql);
		$sql2 = 'select count(t3.UserID) as num,sum(t3.Score+t3.InsureScore) as sum from(select t1.UserID,t2.Score,t2.InsureScore from QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t2 on t1.UserID=t2.UserID where t1.CustomID=1 and t1.IsAndroid=0 and t1.LastLogonMachine="'.$mac.'")t3';
		$rs2 = $mssql->query($sql2);
		$rs[0]['sum'] = number_format($rs[0]['sum']);
		$rs2[0]['sum'] = number_format($rs2[0]['sum']);
		$this->assign('rs',$rs[0]);
		$this->assign('rs2',$rs2[0]);
		$this->assign('mac',$mac);
		$this->display('pb_se');
	}

	public function pb_do(){
		$type=$_GET['type'];
		$mac = $_GET['mac'];
		$mssql = M();
		if($type==1){
		_back('暂时关闭');
		exit;
			$sql = 'update QPAccountsDB.dbo.AccountsInfo set CustomFaceVer=1 where isandroid=0 and LastLogonMachine="'.$mac.'"';
		}else{
			$sql = 'update QPAccountsDB.dbo.AccountsInfo set CustomFaceVer=1 where CustomID=0 and memberorder=0 and isandroid=0 and LastLogonMachine="'.$mac.'"';
		}
		$mssql->query($sql);
		_back('屏蔽成功');

	}

	public function pb_one(){
		$id1 = $_GET['id1'];
		$id2 = $_GET['id2'];
		$mssql = M();
		$sql = 'update QPAccountsDB.dbo.AccountsInfo set CustomFaceVer=1 where memberorder=0 and UserID in ('.$id1.','.$id2.')';
		$mssql->query($sql);
		_back('屏蔽成功');
	}

	public function ky_dq(){
		$area = array('茂名','盐城','海南','衡阳','丽水','重庆','广西桂林市阳朔县','广西桂林市叠彩区');
		$ip = array('218.76.168.103','121.26.135.228','117.87.26.57');
		$user_ff = 0;
		$ids='';
		$rs2 = array();
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_KYUser",$conn);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Logon_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);

			//print_r($rs[$i]['Logon_city']);
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
            }
			if(!_checkword($area,$rs[$i]['LastLogonIP'])){
				$rs2[] = $rs[$i];
			}elseif(!_checkword($area,$rs[$i]['Logon_city']['country'])){
				$rs2[] = $rs[$i];
			}
		}
		$score_sum = number_format($score_sum);
    	$this->assign('result',$rs2);
		$this->assign('score_sum',$score_sum);
    	$this->display('online3');
    }

	public function ky_dq2(){
		$area = array('衡阳','鹏博士长城宽带','盐城','北京');
		$user_ff = 0;
		$ids='';
		$rs2 = array();
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_KYUser",$conn);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Logon_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);

			//print_r($rs[$i]['Logon_city']);
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
            }
			if(!_checkword($area,$rs[$i]['LastLogonIP'])){
				$rs2[] = $rs[$i];
			}elseif(!_checkword($area,$rs[$i]['Logon_city']['country'])){
				$rs2[] = $rs[$i];
			}
		}
		$score_sum = number_format($score_sum);
    	$this->assign('result',$rs2);
		$this->assign('score_sum',$score_sum);
    	$this->display('online4');
    }

public function ky_dq3(){
		$area = array('江西','海南');
		$user_ff = 0;
		$ids='';
		$rs2 = array();
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_KYUser",$conn);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Logon_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);

			//print_r($rs[$i]['Logon_city']);
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
            }
			if(!_checkword($area,$rs[$i]['LastLogonIP'])){
				$rs2[] = $rs[$i];
			}elseif(!_checkword($area,$rs[$i]['Logon_city']['country'])){
				$rs2[] = $rs[$i];
			}
		}
		$score_sum = number_format($score_sum);
    	$this->assign('result',$rs2);
		$this->assign('score_sum',$score_sum);
    	$this->display('online5');
    }

	public function ky_dq4(){
		$area = array('四川','重庆');
		$user_ff = 0;
		$ids='';
		$rs2 = array();
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_KYUser",$conn);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Logon_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);

			//print_r($rs[$i]['Logon_city']);
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
            }
			if(!_checkword($area,$rs[$i]['LastLogonIP'])){
				$rs2[] = $rs[$i];
			}elseif(!_checkword($area,$rs[$i]['Logon_city']['country'])){
				$rs2[] = $rs[$i];
			}
		}
		$score_sum = number_format($score_sum);
    	$this->assign('result',$rs2);
		$this->assign('score_sum',$score_sum);
    	$this->display('online6');
    }

	public function ky_ip(){
		$area = array('110.17.170.96');
		$user_ff = 0;
		$ids='';
		$rs2 = array();
		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_KYUser",$conn);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Logon_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);

			//print_r($rs[$i]['Logon_city']);
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
            }
			if(in_array($rs[$i]['RegisterIP'],$area) || in_array($rs[$i]['LastLogonIP'],$area)){
				$rs2[] = $rs[$i];
			}
		}
		$score_sum = number_format($score_sum);
    	$this->assign('result',$rs2);
		$this->assign('score_sum',$score_sum);
    	$this->display('online7');
    }

	//捕鱼数据
	//当日所有玩家数据
	public function by_user(){
		$mssql = M();
		if(isset($_GET['type'])){
			$type=$_GET['type'];
		}else{
			$type=1;
		}
		$InsertTime = date('Y-m-d');
		$start = $InsertTime.' 00:00:00';
		$end = $InsertTime.' 23:59:59';
		if($type==1){
			$sql = 'SELECT t1.UserID,t1.Score,t2.GameID,t2.Accounts,t2.NickName FROM (SELECT top 100 UserID,Score from QPTreasureDB.dbo.RecordUserDaySum where KindID=2060 and InsertTime="'.$InsertTime.'" order by Score desc) t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID';
		}else{
			$sql = 'SELECT t1.UserID,t1.Score,t2.GameID,t2.Accounts,t2.NickName FROM (SELECT top 100 UserID,sum(Score) as Score from QPTreasureDB.dbo.RecordUserDaySum where KindID=2060 and InsertTime="'.$InsertTime.'" group by UserID order by Score asc) t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID';
		}
		/****** Script for SelectTopNRows command from SSMS  ******/
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
		}
		$this->assign('result',$rs);
    	$this->display('by_user');

	}

	//个人捕鱼详细查询
	public function by_user_info(){
		$mssql = M();
		$GameID = $_GET['GameID'];
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d');
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d');
		}
		$start = $start_date.' 00:00:00';
		$end = $end_date.' 23:59:59';
		if($GameID != ''){
			$sql = 'select UserID,NickName from QPAccountsDB.dbo.AccountsInfo where GameID ='.$GameID;
			if($rs=$mssql->query($sql)){
				$NickName = iconv("GBK","UTF-8",$rs[0]['NickName']);
				$UserID = $rs[0]['UserID'];
			}else{
				_location("无此ID记录",WEB_ROOT."index.php/User/by_user_info");
				return;
			}
			$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
			$rs = array();

			$procedure = mssql_init("PHP_UserByYxList",$conn);

			mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
			mssql_bind($procedure,"@start_date", $start, SQLVARCHAR);
			mssql_bind($procedure,"@end_date", $end, SQLVARCHAR);
			$resource = mssql_execute($procedure);
			while($row2 = mssql_fetch_assoc($resource)){
				$rs2[] = $row2;
			}
			mssql_free_statement($procedure);
			mssql_close($conn);

			for($i=0;$i<count($rs2);$i++){
				$rs2[$i]['KindName'] = iconv("GBK","UTF-8",$rs2[$i]['KindName']);
				$rs2[$i]['ServerName'] = iconv("GBK","UTF-8",$rs2[$i]['ServerName']);
				$rs2[$i]['no'] = $i+1;
				$rs2[$i]['Score'] = number_format($rs2[$i]['Score']);
				$rs2[$i]['TableID'] = $rs2[$i]['TableID']+1;
			}
		}
		//print_r($rs2);
		$this->assign('GameID',$GameID);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('rs',$rs2);
    	$this->display('by_user_info');

	}

	//当日房间
	public function by_room(){
		$mssql = M();
		if(isset($_GET['date'])){
			$InsertTime = $_GET['date'];
		}else{
			$InsertTime = date('Y-m-d');
		}
		$sql2 = 'select sum(WasteSum) as total from QPTreasureDB.dbo.RecordDayWaste where KindID=2060';
		$rs2 = $mssql->query($sql2);
		$total_all = number_format($rs2[0]['total']);
		$sql = 'SELECT t1.WasteSum as Score,t2.ServerName FROM QPTreasureDB.dbo.RecordDayWaste t1 left join QPPlatformDB.dbo.GameRoomInfo t2 on t1.ServerID=t2.ServerID where t1.KindID=2060 and t1.InsertTime="'.$InsertTime.'" order by Score asc';
		//echo $sql;
		//exit;
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$total = $total+$rs[$i]['Score'];
			$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
		}
		//$total = $total*(-1);
		$total = number_format($total);
		$this->assign('result',$rs);
		$this->assign('date',$InsertTime);
		$this->assign('total',$total);
		$this->assign('total_all',$total_all);
    	$this->display('by_room');

	}


	//
	public function tj(){
		$mssql = M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['date'])){
			$InsertTime = $_GET['date'];
		}else{
			$InsertTime = date('Y-m-d');
		}
		$str = array('%baidu%','%sogou%','%haosou%','%gamezs78%','%izs78%','%zsqp78%','%gmzs78%','%sjzs78%','%zs-78%','%8657play%');
		$start = $InsertTime.' 00:00:00';
		$end = $InsertTime.' 23:59:59';
		if($type==0){
		$sql = 'SELECT t1.[UserID],t1.[IsBd],t1.[InputT],t1.[IP],t1.[Area],t1.FromYm,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.dl_num,t3.reg_num,t4.ff_num,t5.cz_num FROM [QPRecordDB].[dbo].[Recordtj] t1 left join  ';
		$sql.= '(select UserID,count(UserID) as dl_num from QPRecordDB.dbo.Recorddl group by UserID) t2 on t1.UserID=t2.UserID left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as reg_num from [QPAccountsDB].[dbo].[AccountsInfo] where RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t3 on t1.IP=t3.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as ff_num from [QPAccountsDB].[dbo].[AccountsInfo] where CustomID=1 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t4 on t1.IP=t4.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as cz_num from [QPAccountsDB].[dbo].[AccountsInfo] where LockMobileFrom>0 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t5 on t1.IP=t5.RegisterIP ';
		$sql.= 'where t1.InsertTime between "'.$start.'" and "'.$end.'" order by InsertTime desc';
		}else{
			$con = $str[$type-1];
			//echo $con;
		$sql = 'SELECT t1.[UserID],t1.[IsBd],t1.[InputT],t1.[IP],t1.[Area],t1.FromYm,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.dl_num,t3.reg_num,t4.ff_num,t5.cz_num FROM [QPRecordDB].[dbo].[Recordtj] t1 left join  ';
		$sql.= '(select UserID,count(UserID) as dl_num from QPRecordDB.dbo.Recorddl group by UserID) t2 on t1.UserID=t2.UserID left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as reg_num from [QPAccountsDB].[dbo].[AccountsInfo] where RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t3 on t1.IP=t3.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as ff_num from [QPAccountsDB].[dbo].[AccountsInfo] where CustomID=1 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t4 on t1.IP=t4.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as cz_num from [QPAccountsDB].[dbo].[AccountsInfo] where LockMobileFrom>0 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t5 on t1.IP=t5.RegisterIP left join ';
		$sql.= 'where t1.FromYm like "'.$con.'" and t1.InsertTime between "'.$start.'" and "'.$end.'" order by InsertTime desc';
		}
		//echo $sql;
		$dl=0;
		$re=0;
		$ff=0;
		$cz=0;
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			if($rs[$i]['dl_num']==null){
				$rs[$i]['dl_num']=0;
			}
			if($rs[$i]['reg_num']==null){
				$rs[$i]['reg_num']=0;
			}
			if($rs[$i]['ff_num']==null){
				$rs[$i]['ff_num']=0;
			}
			if($rs[$i]['cz_num']==null){
				$rs[$i]['cz_num']=0;
			}
			if($rs[$i]['FromYm']=='myself'){
				$rs[$i]['FromYm']='';
			}
			$rs[$i]['Area'] = iconv("GBK","UTF-8",$rs[$i]['Area']);
			$dl=$dl+$rs[$i]['dl_num'];
			$re=$re+$rs[$i]['reg_num'];
			$ff=$ff+$rs[$i]['ff_num'];
			$cz=$cz+$rs[$i]['cz_num'];
		}
		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('type',$type);
		$this->assign('re',$re);
		$this->assign('dl',$dl);
		$this->assign('ff',$ff);
		$this->assign('cz',$cz);
		$this->assign('date',$InsertTime);
    	$this->display('tj');
	}

	public function tj2(){
		$mssql = M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['date'])){
			$InsertTime = $_GET['date'];
		}else{
			$InsertTime = date('Y-m-d');
		}
		$str = array('%0535zufang%','%zs-78%','%gmzs78%','%izs78%','%sed2s%','%gamezs78%');
		$start = $InsertTime.' 00:00:00';
		$end = $InsertTime.' 23:59:59';
		if($type==0){
		$sql = 'SELECT t1.[UserID],t1.[IsBd],t1.[InputT],t1.[IP],t1.[Area],t1.FromYm,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.dl_num,t3.reg_num,t4.ff_num,t5.cz_num FROM [QPRecordDB].[dbo].[Recordtj2] t1 left join  ';
		$sql.= '(select UserID,count(UserID) as dl_num from QPRecordDB.dbo.Recorddl2 group by UserID) t2 on t1.UserID=t2.UserID left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as reg_num from [QPAccountsDB].[dbo].[AccountsInfo] where RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t3 on t1.IP=t3.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as ff_num from [QPAccountsDB].[dbo].[AccountsInfo] where CustomID=1 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t4 on t1.IP=t4.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as cz_num from [QPAccountsDB].[dbo].[AccountsInfo] where LockMobileFrom>0 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t5 on t1.IP=t5.RegisterIP ';
		$sql.= 'where t1.InsertTime between "'.$start.'" and "'.$end.'" order by cz_num desc,ff_num desc,reg_num desc';
		}else{
			$con = $str[$type-1];
			//echo $con;
		$sql = 'SELECT t1.[UserID],t1.[IsBd],t1.[InputT],t1.[IP],t1.[Area],t1.FromYm,CONVERT(varchar,t1.InsertTime,120) AS InsertTime,t2.dl_num,t3.reg_num,t4.ff_num,t5.cz_num FROM [QPRecordDB].[dbo].[Recordtj2] t1 left join  ';
		$sql.= '(select UserID,count(UserID) as dl_num from QPRecordDB.dbo.Recorddl2 group by UserID) t2 on t1.UserID=t2.UserID left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as reg_num from [QPAccountsDB].[dbo].[AccountsInfo] where RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t3 on t1.IP=t3.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as ff_num from [QPAccountsDB].[dbo].[AccountsInfo] where CustomID=1 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t4 on t1.IP=t4.RegisterIP left join ';
		$sql.= '(select RegisterIP,COUNT(RegisterIP) as cz_num from [QPAccountsDB].[dbo].[AccountsInfo] where LockMobileFrom>0 and RegisterDate between "'.$start.'" and "'.$end.'" group by RegisterIP) t5 on t1.IP=t5.RegisterIP ';
		$sql.= 'where t1.FromYm like "'.$con.'" and t1.InsertTime between "'.$start.'" and "'.$end.'" order by cz_num desc,ff_num desc,reg_num desc';
		}
		//echo $sql;
		$dl=0;
		$re=0;
		$ff=0;
		$cz=0;
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			if($rs[$i]['dl_num']==null){
				$rs[$i]['dl_num']=0;
			}
			if($rs[$i]['reg_num']==null){
				$rs[$i]['reg_num']=0;
			}
			if($rs[$i]['ff_num']==null){
				$rs[$i]['ff_num']=0;
			}
			if($rs[$i]['cz_num']==null){
				$rs[$i]['cz_num']=0;
			}
			if($rs[$i]['FromYm']=='myself'){
				$rs[$i]['FromYm']='';
			}

			$rs[$i]['Area'] = iconv("GBK","UTF-8",$rs[$i]['Area']);
			$dl=$dl+$rs[$i]['dl_num'];
			$re=$re+$rs[$i]['reg_num'];
			$ff=$ff+$rs[$i]['ff_num'];
			$cz=$cz+$rs[$i]['cz_num'];
		}
		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('type',$type);
		$this->assign('re',$re);
		$this->assign('dl',$dl);
		$this->assign('ff',$ff);
		$this->assign('cz',$cz);
		$this->assign('date',$InsertTime);
    	$this->display('tj2');
	}

	//统计查询
	public function tjs(){
		$mssql = M();
		if(isset($_GET['from'])){
			$from = $_GET['from'];
		}else{
			$from  = 1;
		}
		if(isset($_GET['date'])){
			$InsertTime = $_GET['date'];
		}else{
			$InsertTime = date('Y-m-d');
		}
		$start_date = $InsertTime.' 00:00:00';
		$end_date = $InsertTime.' 23:59:59';
		if($from==1){
			$table = 'Recordtj';
		}else{
			$table = 'Recordtj2';
		}
		$ff=0;
		$cz=0;
		$sql = 'select t1.UserID,t1.GameID,t1.NickName,t1.LockMobileFrom,t1.CustomID,CONVERT(varchar,t1.RegisterDate,120) AS RegisterDate,t2.Score,t2.InsureScore from QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t2 on t1.UserID=t2.UserID where t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" and t1.RegisterIP in (select IP from QPRecordDB.dbo.'.$table.' where InsertTime between "'.$start_date.'" and "'.$end_date.'") and (t1.LockMobileFrom>0 or t1.CustomID>0) order by t1.RegisterDate desc';
		//echo $sql;
		$rs = $mssql->query($sql);
		//echo $sql;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			if($rs[$i]['LockMobileFrom']>0){
				$cz=$cz+1;
			}
			if($rs[$i]['CustomID']==1){
				$ff=$ff+1;
			}
			$rs[$i]['Total']=$rs[$i]['Score']+$rs[$i]['InsureScore'];
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Total'] = number_format($rs[$i]['Total']);
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
		}
		//print_r($rs);
		$this->assign('from',$from);
		$this->assign('cz',$cz);
		$this->assign('ff',$ff);
		$this->assign('rs',$rs);
		$this->assign('date',$InsertTime);
		$this->display('tjs');
	}

	//精确输赢查询
	public function jqcx(){
		if(isset($_GET['start_date']) && isset($_GET['start_date'])){
			$mssql=M();
			$GameID=$_GET['GameID'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];

		$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
		$rs = array();

		$procedure = mssql_init("PHP_UserYxListInfo",$conn);
		mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);

		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);

    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['KindName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']);
    		$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
    		$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
			$total = $total+$rs[$i]['Score'];
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['TableID'] = $rs[$i]['TableID']+1;
			//$rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID']);
		}
		$total = number_format($total);
		//echo $start_date;
		$this->assign('GameID',$GameID);
		$this->assign('total',$total);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('result',$rs);
    	$this->display('jqcx');


		}else{
			$this->display('jqcx');
		}


	}

	//捕鱼控制查询、
	public function by_kz(){
		$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);
		if($_GET['GameID']){
			$GameID=$_GET['GameID'];
			$procedure = mssql_init("PHP_GetByKz",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			$resource = mssql_execute($procedure,false);
		}else{
			$procedure = mssql_init("PHP_GetNewlyByKz",$conn);
			$resource = mssql_execute($procedure,false);

		}
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
			mssql_free_statement($procedure);
			mssql_close($conn);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1;
				if($rs[$i]['StartTime']==0){
					$rs[$i]['StartTime']='000000';
				}
				if($rs[$i]['EndTime']==0){
					$rs[$i]['EndTime']='000000';
				}
				if(strlen($rs[$i]['StartTime'])==5){
					$rs[$i]['StartTime']='0'.$rs[$i]['StartTime'];
					//echo $rs[$i]['StartTime'].'</br>';
				}
				if(strlen($rs[$i]['StartTime'])==4){
					$rs[$i]['StartTime']='00'.$rs[$i]['StartTime'];
					//echo $rs[$i]['StartTime'].'</br>';
				}
				$rs[$i]['StartDate']=date('Y-m-d H:i:s',strtotime($rs[$i]['StartDate'].$rs[$i]['StartTime']));
				if(strlen($rs[$i]['EndTime'])==5){
					$rs[$i]['EndTime']='0'.$rs[$i]['EndTime'];
				}
				if(strlen($rs[$i]['EndTime'])==4){
					$rs[$i]['EndTime']='00'.$rs[$i]['EndTime'];
				}
				$rs[$i]['EndDate']=date('Y-m-d H:i:s',strtotime($rs[$i]['EndDate'].$rs[$i]['EndTime']));

			}
			$this->assign('rs',$rs);
			$this->assign('GameID',$GameID);
		//print_r($rs);
		$this->display('by_kz');
	}


	//捕鱼操作id控制查询、
	public function by_kz_s(){
		if(isset($_GET['date'])){
			$date = $_GET['date'];
		}else{
			$date = date('Y-m-d',strtotime('-1 day'));
		}
		$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
		mssql_select_db('QPControlDB');
		if($_GET['GameID']){
			$GameID=$_GET['GameID'];
			$procedure = mssql_init("PHP_GetMasterByKz",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			mssql_bind($procedure,"@Date", $date, SQLVARCHAR);
			$resource = mssql_execute($procedure,false);
		}else{
			$this->assign('date',$date);
			$this->display('by_kz_s');
			return;
		}
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
			mssql_free_statement($procedure);
			mssql_close($conn);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1;
				if($rs[$i]['StartTime']==0){
					$rs[$i]['StartTime']='000000';
				}
				if($rs[$i]['EndTime']==0){
					$rs[$i]['EndTime']='000000';
				}
				if(strlen($rs[$i]['StartTime'])==5){
					$rs[$i]['StartTime']='0'.$rs[$i]['StartTime'];
					//echo $rs[$i]['StartTime'].'</br>';
				}
				if(strlen($rs[$i]['StartTime'])==4){
					$rs[$i]['StartTime']='00'.$rs[$i]['StartTime'];
					//echo $rs[$i]['StartTime'].'</br>';
				}
				$rs[$i]['StartDate']=date('Y-m-d H:i:s',strtotime($rs[$i]['StartDate'].$rs[$i]['StartTime']));
				if(strlen($rs[$i]['EndTime'])==5){
					$rs[$i]['EndTime']='0'.$rs[$i]['EndTime'];
				}
				if(strlen($rs[$i]['EndTime'])==4){
					$rs[$i]['EndTime']='00'.$rs[$i]['EndTime'];
				}
				$rs[$i]['EndDate']=date('Y-m-d H:i:s',strtotime($rs[$i]['EndDate'].$rs[$i]['EndTime']));

			}
			$this->assign('rs',$rs);
			$this->assign('GameID',$GameID);
			$this->assign('date',$date);
		//print_r($rs);
		$this->display('by_kz_s');
	}

	//今日新注册充值用户
	public function new_cz(){
		$mssql = M();
		if(isset($_GET['date'])){
			$InsertTime = $_GET['date'];
		}else{
			$InsertTime = date('Y-m-d');
		}
		$start_date = $InsertTime.' 00:00:00';
		$end_date=$InsertTime.' 23:59:59';

		$sql = 'SELECT t1.UserID,t1.RegisterIP,t1.Rechange,t1.IsFF,t1.IP_C,t1.MAC_C,CONVERT(varchar,t1.InsertDate,120) AS InsertDate,t2.GameID,t2.Accounts,t2.NickName,t2.LastLogonMachine,t2.UserMedal,t2.LockMobileFrom,t2.CustomID,t3.Score,t3.InsureScore,t4.zr,t5.zc FROM [QPRecordDB].[dbo].[RecordRegUser](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID left join (select UserID,SUM(Score) as zr from QPRecordDB.dbo.RecordUserZz(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Inout=1 group by UserID) t4 on t1.UserID=t4.UserID left join  (select UserID,SUM(Score) as zc from QPRecordDB.dbo.RecordUserZz(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Inout=2 group by UserID) t5 on t1.UserID=t5.userID where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t1.Rechange>0 order by t1.RecordID desc';
		//echo $sql;
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			//$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
			if($rs[$i]['IP_C']==1 && $rs[$i]['MAC_C']==1){
				$rs[$i]['new']=1;
			}

		}
		$this->assign('date',$InsertTime);
		$this->assign('rs',$rs);
		$this->display('new_cz');
	}

	//今日新注册充值用户
	public function new_cz2(){
		$mssql = M();
		if(isset($_GET['date'])){
			$InsertTime = $_GET['date'];
		}else{
			$InsertTime = date('Y-m-d');
		}
		$start_date = $InsertTime.' 00:00:00';
		$end_date=$InsertTime.' 23:59:59';
		$sql = 'select UserID,GameID,Accounts,NickName,CustomID,UserMedal,LockMobileFrom,IsOpenTokenLock,Present,PassPortID,MemberOrder,LastLogonIP,LastLogonMachine,CONVERT(varchar,RegisterDate,120) AS RegisterDate from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where RegisterDate between "'.$start_date.'" and "'.$end_date.'" and CustomID>0 order by RegisterDate desc';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			//$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
		}
		$this->assign('date',$InsertTime);
		$this->assign('rs',$rs);
		$this->display('new_cz2');
	}

	public function tj_test(){
		$mssql = M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
			$A="'".$start_date."'";

		}else{
			$start_date = date('Y-m-d').' 00:00:00';
			$A="'".$start_date."'";
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
			$B="'".$end_date."'";
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
			$B="'".$end_date."'";
		}
		$d=_diffDays ($start_date, $end_date);
		if($d>7){
			_location('查询日期不能超过7天',WEB_ROOT.'index.php/User/tj_test');
		}
		/*
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		*/
		$c=0;
		$xz=0;
		$zc=0;
		$yx=0;

		if($type==0){
			$sql='select t10.GjcID,t10.c,t10.dl_c,t10.Info,t6.zc_c,t6.yx_c  from
(select t7.GjcID,t7.c,t8.dl_c,t9.Info from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord(nolock)
where InsertDate between '.$A.' and '.$B.' and (GjcID>99000000 or GjcID<80000000) group by GjcID) t7 left join
(select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord(nolock) where InsertDate between '.$A.' and '.$B.' group by GjcID) t8 on t7.GjcID=t8.GjcID left join [QPRecordDB].[dbo].[GjcInfo](nolock) t9 on t7.GjcID=t9.ID
where t7.c>0)t10 left join
(select t5.GjcID,SUM(t5.zc_c) as zc_c,SUM(t5.yx_c) as yx_c from
(select t4.GjcID,t3.zc_c,t3.yx_c from (select GjcID,IP from QPRecordDB.dbo.GjcRecord(nolock) where InsertDate between '.$A.' and '.$B.'  group by GjcID,IP) t4 left join
(select t1.RegisterIP,t1.zc_c,t2.yx_c from
(select RegisterIP,COUNT(RegisterIP) as zc_c from QPRecordDB.dbo.RecordRegUser(nolock) where InsertDate
between '.$A.' and '.$B.' group by RegisterIP) t1 left join
(select RegisterIP,COUNT(RegisterIP) as yx_c from QPRecordDB.dbo.RecordRegUser(nolock) where (Rechange>0 or IsFF>0) and InsertDate
between '.$A.' and '.$B.' group by RegisterIP) t2 on t1.RegisterIP=t2.RegisterIP)t3 on t4.IP=t3.RegisterIP
where zc_c>0 )t5 group by t5.GjcID) t6 on t10.GjcID=t6.GjcID order by t10.c desc';
}else{
$num = $type*100000;
$num2 = $num+100000*$type2;
//echo $num2;
$sql='select t10.GjcID,t10.c,t10.dl_c,t10.Info,t6.zc_c,t6.yx_c   from
(select t7.GjcID,t7.c,t8.dl_c,t9.Info from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord(nolock)
where GjcID between '.$num.' and '.$num2.' and InsertDate between '.$A.' and '.$B.' group by GjcID) t7 left join
(select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord(nolock) where InsertDate between '.$A.' and '.$B.' group by GjcID) t8 on t7.GjcID=t8.GjcID left join [QPRecordDB].[dbo].[GjcInfo](nolock) t9 on t7.GjcID=t9.ID
where t7.c>0)t10 left join
(select t5.GjcID,SUM(t5.zc_c) as zc_c,SUM(t5.yx_c) as yx_c from
(select t4.GjcID,t3.zc_c,t3.yx_c from (select GjcID,IP from QPRecordDB.dbo.GjcRecord(nolock) where InsertDate between '.$A.' and '.$B.'  group by GjcID,IP) t4 left join
(select t1.RegisterIP,t1.zc_c,t2.yx_c from
(select RegisterIP,COUNT(RegisterIP) as zc_c from QPRecordDB.dbo.RecordRegUser(nolock) where InsertDate
between '.$A.' and '.$B.' group by RegisterIP) t1 left join
(select RegisterIP,COUNT(RegisterIP) as yx_c from QPRecordDB.dbo.RecordRegUser(nolock) where (Rechange>0 or IsFF>0) and InsertDate
between '.$A.' and '.$B.' group by RegisterIP) t2 on t1.RegisterIP=t2.RegisterIP)t3 on t4.IP=t3.RegisterIP
where zc_c>0 )t5 group by t5.GjcID) t6 on t10.GjcID=t6.GjcID order by t10.c desc';
}
		//$sql = 'select top 1000 t1.GjcID,t1.c,t2.dl_c,t3.Info,t3.Pt from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t1 left join (select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t2 on t1.GjcID=t2.GjcID left join [QPWebBackDB].[dbo].[GjcInfo] t3 on t1.GjcID=t3.ID where t1.c>0 order by t1.c desc';
		// echo $sql;
		// exit;
		$rs = $mssql->query($sql);
		$cc=count($rs);
		for($i=0;$i<$cc;$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
			$c=$c+$rs[$i]['c'];
			$xz=$xz+$rs[$i]['dl_c'];
			$zc=$zc+$rs[$i]['zc_c'];
			$yx=$yx+$rs[$i]['yx_c'];

		}

		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('xz',$xz);
		$this->assign('c',$c);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('zc',$zc);
		$this->assign('yx',$yx);

		$this->assign('date',$InsertTime);
    	$this->display('tj_test');

	}

	//实际推广用户
	public function tj_user(){
		$mssql=M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		//$start_date = $_GET['start_date'];
		//$end_date = $_GET['end_date'];
		if($type==0){
			$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName,CONVERT(varchar,t6.LastLogonDate,120) as LastLogonDate from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser](nolock) t1 left join QPRecordDB.dbo.GjcRecord(nolock) t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and (t2.GjcID<80000000 or t2.GjcID>99000001) group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser](nolock) t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID where (t4.IsFF=1 or t4.Rechange>0) order by InsertDate desc';
		}else{
			$num = $type*100000;
			$num2 = $num+100000*$type2;
			$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser](nolock) t1 left join QPRecordDB.dbo.GjcRecord(nolock) t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.GjcID between '.$num.' and '.$num2.' group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser](nolock) t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID where (t4.IsFF=1 or t4.Rechange>0) order by InsertDate desc';
		}
		$rs = $mssql->query($sql);
		$ff_num=0;
		$cz_num=0;
		$cz_count=0;
		$yx=0;
		$hy=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			if($rs[$i]['IsFF']>0){
				$ff_num=$ff_num+1;
			}
			if($rs[$i]['Rechange']>0){
				$cz_num=$cz_num+$rs[$i]['Rechange'];
				$cz_count=$cz_count+1;
			}
			if($rs[$i]['Rechange']>0 || $rs[$i]['IsFF']>0){
				$yx=$yx+1;
			}
			if($rs[$i]['Score']+$rs[$i]['InsureScore']!=5000){
				$hy=$hy+1;
			}
		}
		$this->assign('cz_count',$cz_count);
		$this->assign('cz_num',$cz_num);
		$this->assign('ff_num',$ff_num);
		$this->assign('yx',$yx);
		$this->assign('hy',$hy);
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_user');


	}

	//推广注册帐号
	public function tj_reguser(){
		$mssql=M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		//$start_date = $_GET['start_date'];
		//$end_date = $_GET['end_date'];
		if($type==0){
			$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName,CONVERT(varchar,t6.LastlogonDate,120) as LastlogonDate from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and (t2.GjcID<80000000 or t2.GjcID>99000001) group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser] t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID order by InsertDate desc';
		}else{
			$num = $type*100000;
			$num2 = $num+100000*$type2;
			$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName,CONVERT(varchar,t6.LastlogonDate,120) as LastlogonDate from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.GjcID between '.$num.' and '.$num2.' group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser] t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID order by InsertDate desc';
		}
		$rs = $mssql->query($sql);
		$ff_num=0;
		$cz_num=0;
		$cz_count=0;
		$yx=0;
		$hy=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			if($rs[$i]['IsFF']>0){
				$ff_num=$ff_num+1;
			}
			if($rs[$i]['Rechange']>0){
				$cz_num=$cz_num+$rs[$i]['Rechange'];
				$cz_count=$cz_count+1;
			}
			if($rs[$i]['Rechange']>0 || $rs[$i]['IsFF']>0){
				$yx=$yx+1;
			}
			if($rs[$i]['Score']+$rs[$i]['InsureScore']!=5000){
				$hy=$hy+1;
			}
		}
		$this->assign('cz_count',$cz_count);
		$this->assign('cz_num',$cz_num);
		$this->assign('ff_num',$ff_num);
		$this->assign('yx',$yx);
		$this->assign('hy',$hy);
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_reguser');

	}

	public function jiechi(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
			$A="'".$start_date."'";

		}else{
			$start_date = date('Y-m-d').' 00:00:00';
			$A="'".$start_date."'";
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
			$B="'".$end_date."'";
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
			$B="'".$end_date."'";
		}

		$xz=0;
		$zc=0;
		$yx=0;

		$sql='select t10.GjcID,t10.c,t10.dl_c,t10.Info,t6.zc_c,t6.yx_c  from
(select t7.GjcID,t7.c,t8.dl_c,t9.Info from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord(nolock)
where GjcID between 80000000 and 98100000 and InsertDate between '.$A.' and '.$B.' group by GjcID) t7 left join
(select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord(nolock) where InsertDate between '.$A.' and '.$B.' group by GjcID) t8 on t7.GjcID=t8.GjcID left join [QPRecordDB].[dbo].[GjcInfo](nolock) t9 on t7.GjcID=t9.ID
where t7.c>0)t10 left join
(select t5.GjcID,SUM(t5.zc_c) as zc_c,SUM(t5.yx_c) as yx_c from
(select t4.GjcID,t3.zc_c,t3.yx_c from (select GjcID,IP from QPRecordDB.dbo.GjcRecord(nolock) where InsertDate between '.$A.' and '.$B.'  group by GjcID,IP) t4 left join
(select t1.RegisterIP,t1.zc_c,t2.yx_c from
(select RegisterIP,COUNT(RegisterIP) as zc_c from QPRecordDB.dbo.RecordRegUser(nolock) where InsertDate
between '.$A.' and '.$B.' group by RegisterIP) t1 left join
(select RegisterIP,COUNT(RegisterIP) as yx_c from QPRecordDB.dbo.RecordRegUser(nolock) where (Rechange>0 or IsFF>0) and InsertDate
between '.$A.' and '.$B.' group by RegisterIP) t2 on t1.RegisterIP=t2.RegisterIP)t3 on t4.IP=t3.RegisterIP
where zc_c>0 )t5 group by t5.GjcID) t6 on t10.GjcID=t6.GjcID order by t10.c desc';
		$rs = $mssql->query($sql);
		$cc=count($rs);
		for($i=0;$i<$cc;$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
			$xz=$xz+$rs[$i]['dl_c'];
			$zc=$zc+$rs[$i]['zc_c'];
			$yx=$yx+$rs[$i]['yx_c'];

		}
		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('xz',$xz);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('zc',$zc);
		$this->assign('yx',$yx);

		$this->assign('date',$InsertTime);
    	$this->display('jiechi');

	}

	//实际劫持用户
	public function jiechi_user(){
		$mssql=M();

		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		//$start_date = $_GET['start_date'];
		//$end_date = $_GET['end_date'];
		$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser](nolock) t1 left join QPRecordDB.dbo.GjcRecord(nolock) t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.GjcID between 80000000 and 98100000 group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser](nolock) t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID where (t4.IsFF=1 or t4.Rechange>0) order by InsertDate desc';
		$rs = $mssql->query($sql);
		$ff_num=0;
		$cz_num=0;
		$cz_count=0;
		$yx=0;
		$hy=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			if($rs[$i]['IsFF']>0){
				$ff_num=$ff_num+1;
			}
			if($rs[$i]['Rechange']>0){
				$cz_num=$cz_num+$rs[$i]['Rechange'];
				$cz_count=$cz_count+1;
			}
			if($rs[$i]['Rechange']>0 || $rs[$i]['IsFF']>0){
				$yx=$yx+1;
			}
			if($rs[$i]['Score']+$rs[$i]['InsureScore']!=5000){
				$hy=$hy+1;
			}
		}
		$this->assign('cz_count',$cz_count);
		$this->assign('cz_num',$cz_num);
		$this->assign('ff_num',$ff_num);
		$this->assign('yx',$yx);
		$this->assign('hy',$hy);
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('jiechi_user');


	}

	public function tj_test2(){
		$mssql = M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		/*
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		*/
		$xz=0;
		$zc=0;
		$yx=0;

		$sql = 'select top 1500 t1.GjcID,t1.c,t2.dl_c,t3.Info,t3.Pt from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t1 left join (select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t2 on t1.GjcID=t2.GjcID left join [QPWebBackDB].[dbo].[GjcInfo](nolock) t3 on t1.GjcID=t3.ID where t1.c>0 order by t1.c desc';
		//echo $sql;
		//exit;
		$rs = $mssql->query($sql);



		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
			/*
			if($i<00){
				$rs[$i]['User']=$this->GetCzUser($rs[$i]['GjcID'],$start_date,$end_date);
			}
			*/
			//$rs[$i]['User']=$this->GetCzUser($rs[$i]['GjcID'],$start_date,$end_date);
			$xz=$xz+$rs[$i]['dl_c'];
			$zc=$zc+$rs[$i]['User']['user_c'];
			$yx=$yx+$rs[$i]['User']['user_c2'];
		}
		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('xz',$xz);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('zc',$zc);
		$this->assign('yx',$yx);

		$this->assign('date',$InsertTime);
    	$this->display('tj_test2');

	}

	public function GjcRecord(){
		$mssql = M();
		$GjcID = $_GET['GjcID'];
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}


		$sql2 = 'select Info from [QPRecordDB].[dbo].[GjcInfo](nolock) where ID='.$GjcID;
		$rs2=$mssql->query($sql2);
		$rs2[0]['Info']=iconv("GBK","UTF-8",$rs2[0]['Info']);

		$sql = 'select IP,Area,CONVERT(varchar,InsertDate,120) as InsertDate from QPRecordDB.dbo.GjcRecord(nolock) where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'" order by ID desc';

		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
		}

		//print_r($rs);
		$this->assign('GjcID',$GjcID);
		$this->assign('Info',$rs2[0]['Info']);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('rs',$rs);
		$this->display('gjc_record');

	}

	public function GjcDlRecord(){
		$mssql = M();
		$GjcID = $_GET['GjcID'];
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}




		$sql = 'select IP,Area,CONVERT(varchar,InsertDate,120) as InsertDate from QPRecordDB.dbo.GjcDlRecord(nolock) where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'" order by ID desc';
		//echo $sql;

		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
		}

		//print_r($rs);
		$this->assign('GjcID',$GjcID);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('rs',$rs);
		$this->display('gjc_dl_record');

	}

	public function GjcDlRecord2(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if($type==0){
			$sql = 'select t1.GjcID,t1.IP,t1.Area,CONVERT(varchar,t1.InsertDate,120) as InsertDate,t2.Info from QPRecordDB.dbo.GjcDlRecord(nolock) t1 left join QPRecordDB.dbo.GjcInfo(nolock) t2 on t1.GjcID=t2.ID where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and (t1.GjcID<80000000 or t1.GjcID>99000001) order by t1.ID desc';
		}else{
			$num = $type*100000;
			$num2 = $num+100000*$type2;
			$sql = 'select t1.GjcID,t1.IP,t1.Area,CONVERT(varchar,t1.InsertDate,120) as InsertDate,t2.Info from QPRecordDB.dbo.GjcDlRecord(nolock) t1 left join QPRecordDB.dbo.GjcInfo(nolock) t2 on t1.GjcID=t2.ID where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t1.GjcID between '.$num.' and '.$num2.' order by t1.ID desc';
		}
		//echo $sql;

		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
		}

		//print_r($rs);
		//$this->assign('GjcID',$GjcID);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('rs',$rs);
		$this->display('gjc_dl_record2');

	}

	public function GetCzUser($GjcID,$start_date,$end_date){
		$mssql = M();
		$sql = 'select count(RecordID) as user_c from QPRecordDB.dbo.RecordRegUser(nolock) where RegisterIP in (select IP from [QPRecordDB].[dbo].[GjcRecord] where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'") and InsertDate between "'.$start_date.'" and "'.$end_date.'"';
		$sql2 = 'select count(RecordID) as user_c2 from QPRecordDB.dbo.RecordRegUser(nolock) where (Rechange>0 or IsFF>0) and RegisterIP in (select IP from [QPRecordDB].[dbo].[GjcRecord] where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'") and InsertDate between "'.$start_date.'" and "'.$end_date.'"';

		$rs=$mssql->query($sql);
		$rs2=$mssql->query($sql2);

		$return['user_c']=number_format($rs[0]['user_c']);
		$return['user_c2']=number_format($rs2[0]['user_c2']);

		return $return;

	}

	public function online_minute(){
		$mssql = M();
		if($_GET['date']){
            $date = $_GET['date'];
						$A="'".$date."'";
        }else{
            $date = date('Y-m-d');
						$A="'".$date."'";
        }
		$this->assign('date',$date);
        $sql = 'select ID,CONVERT(varchar,InsertDate,120) as InsertDate,zong,Fufei,Mianfei,VIP,IOS,Android,PC,FF_IOS,FF_and,FF_pc,MF_IOS,MF_and,MF_pc from QPRecordDB.dbo.RecordOnline(nolock) where InsertDate>'.$A.' 00:00:00" and InsertDate< '.$A.' 23:59:59"order by ID desc';
        $rs = $mssql->query($sql);

        $this->assign('rs',$rs);
		//$this->assign('total',$total);
        $this->display('online_minute');
	}

	public function online_type(){
		$mssql = M();
		if($_GET['date']){
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
		$this->assign('date',$date);
        $sql = 'select ID,CONVERT(varchar,InsertDate,120) as InsertDate,dx,lt,yd,kd,bl,qt from QPWebBackDB.dbo.OnlineType(nolock) where InsertDate>"'.$date.' 00:00:00" and InsertDate< "'.$date.' 23:59:59"order by ID desc';
        $rs = $mssql->query($sql);

        $this->assign('rs',$rs);
		//$this->assign('total',$total);
        $this->display('online_type');
	}

	//流水查询
	public function ls(){
		$mssql=M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$sql = 'select count(SwapScore) as c,SUM(SwapScore) as s from [QPTreasureDB].[dbo].[RecordInsure](nolock) where TradeType=3 and CollectDate between "'.$start_date.'" and "'.$end_date.'"';
		$rs = $mssql->query($sql);
		$s = number_format($rs[0]['s']);
		$c = number_format($rs[0]['c']);
		$this->assign('s',$s);
		$this->assign('c',$c);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('ls');


	}

	//有效用户点击
	public function tj_zc(){
		$mssql=M();
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		$GjcID=$_GET['GjcID'];
		$sql='SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.RegisterIP,t1.RegisterDate,t1.RegisterFrom,t2.Score,t2.InsureScore from [QPAccountsDB].[dbo].[AccountsInfo](nolock) t1 left join [QPTreasureDB].[dbo].[GameScoreInfo](nolock) t2 on t1.UserID=t2.UserID where t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" and t1.RegisterIP in (select IP from QPRecordDB.dbo.GjcRecord where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'") order by RegisterDate desc';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
		}
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_zc');


	}

	//有效用户点击
	public function tj_yx(){
		$mssql=M();
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		$GjcID=$_GET['GjcID'];

		$sql = 'select t3.UserID,t6.GameID,t6.NickName,t3.Rechange,t3.IsFF,t4.GjcID,t4.IP,t4.Area,t5.Info,t4.InsertDate from
(select t1.UserID,t1.RegisterIP,t1.Rechange,t1.IsFF
from [QPRecordDB].[dbo].[RecordRegUser](nolock) t1 left join QPRecordDB.dbo.GjcRecord(nolock) t2 on t1.RegisterIP=t2.IP
where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.GjcID='.$GjcID.' and (t1.IsFF>0 or t1.Rechange>0) group by t1.UserID,t1.RegisterIP,t1.Rechange,t1.IsFF)t3 left join [QPRecordDB].[dbo].[GjcRecord](nolock) t4
on t3.RegisterIP=t4.IP left join [QPRecordDB].[dbo].[GjcInfo](nolock) t5 on t4.GjcID=t5.ID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID where t4.InsertDate between "'.$start_date.'" and "'.$end_date.'"';

		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
		}
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_yx');


	}

	//充值未游戏用户
	public function cz_ungame(){
		$mssql = M();
		//$start_date = date('Y-m-d').' 00:00:00';
		//$end_date=date('Y-m-d').' 23:59:59';

		$sql = 'SELECT top 1000 t1.UserID,t1.RegisterIP,t1.Rechange,t1.IsFF,t1.IP_C,t1.MAC_C,CONVERT(varchar,t1.InsertDate,120) AS InsertDate,t2.GameID,t2.Accounts,t2.NickName,t2.LastLogonMachine,t2.UserMedal,t2.LockMobileFrom,t2.CustomID,t3.Score,t3.InsureScore,t4.zr,t5.zc FROM [QPRecordDB].[dbo].[RecordRegUser](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID left join (select UserID,SUM(Score) as zr from QPRecordDB.dbo.RecordUserZz(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Inout=1 group by UserID) t4 on t1.UserID=t4.UserID left join  (select UserID,SUM(Score) as zc from QPRecordDB.dbo.RecordUserZz(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Inout=2 group by UserID) t5 on t1.UserID=t5.userID where t1.Rechange>0 and t3.WinCount=0 and t3.LostCount=0 and t3.DrawCount=0 order by t1.RecordID desc';
		echo $sql;
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			//$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
			if($rs[$i]['IP_C']==1 && $rs[$i]['MAC_C']==1){
				$rs[$i]['new']=1;
			}

		}
		$this->assign('rs',$rs);
		$this->display('cz_ungame');
	}

	//有政策的新用户
	function ZcUserList(){
		$mssql = M();
		$sql = 'SELECT top 100 t1.UserID,t1.Rechange,CONVERT(varchar,t1.InsertDate,120) AS InsertDate,t2.GameID,t2.Accounts,t2.NickName,t2.LastLogonMachine,t2.UserMedal,t2.LockMobileFrom,t2.CustomID,t3.Score,t3.InsureScore,t4.zr,t5.zc FROM [QPRecordDB].[dbo].[RecordZcUser](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID left join (select UserID,SUM(Score) as zr from QPRecordDB.dbo.RecordUserZz(nolock) where Inout=1 group by UserID) t4 on t1.UserID=t4.UserID left join  (select UserID,SUM(Score) as zc from QPRecordDB.dbo.RecordUserZz(nolock) where Inout=2 group by UserID) t5 on t1.UserID=t5.userID order by t1.RecordID desc';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
		}
		$this->assign('result',$rs);
		$this->display('zc_user');
	}

	//首冲用户列表
	function ScUserList(){
		$mssql = M();
		$sql = 'SELECT top 100 t1.UserID,t1.Rechange,CONVERT(varchar,t1.InsertDate,120) AS InsertDate,t2.GameID,t2.Accounts,t2.NickName,t2.LastLogonMachine,t2.UserMedal,t2.LockMobileFrom,t2.CustomID,t3.Score,t3.InsureScore,t4.zr,t5.zc FROM [QPRecordDB].[dbo].[RecordNewCzUser](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID left join (select UserID,SUM(Score) as zr from QPRecordDB.dbo.RecordUserZz(nolock) where Inout=1 group by UserID) t4 on t1.UserID=t4.UserID left join  (select UserID,SUM(Score) as zc from QPRecordDB.dbo.RecordUserZz(nolock) where Inout=2 group by UserID) t5 on t1.UserID=t5.userID order by t1.RecordID desc';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
		}
		$this->assign('result',$rs);
		$this->display('sc_user');
	}

	//添加首冲用户
	function addSc(){
	if($_SESSION['zs78_admin2']['id']!=15){
		_location("无此权限",WEB_ROOT.'index.php/User/ScUserList');
	}
		$GameID = $_GET['GameID'];
		$mssql=M();
        $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo(nolock) where GameID='.$GameID;

		if(!$rs = $mssql->query($sql)){
			_location("该用户不存在",WEB_ROOT."index.php/User/ScUserList");
		}else{
            $sql2 = 'select UserID from QPRecordDB.dbo.RecordNewCzUser(nolock) where UserID='.$rs[0]['UserID'];
                if(!$rs2=$mssql->query($sql2)){
					$key='lsdkhf$#ug2';
					$a=$_GET['GameID'];
					$b=0;
					$url=sprintf('http://yun01.zs78.com:8080/Payment/aa.php?a=%d&b=%d&c=%s',$a,$b,strtoupper(md5($a.$key.$b)));
					file_get_contents($url);
					$sql3='INSERT INTO QPRecordDB.dbo.RecordNewCzUser (UserID,Rechange,Level,InsertDate) VALUES('.$rs[0]['UserID'].',0,0,GETDATE())';
					$sql4='update QPAccountsDB.dbo.AccountsInfo set LoveLiness=1 where GameID='.$GameID;
                    $mssql->query($sql3);
					$mssql->query($sql4);
                }
			_location("添加成功",WEB_ROOT."index.php/User/ScUserList");

		}
	}

	public function tj_ip(){
		$mssql=M();
		if(isset($_GET['ip'])){
			$ip = $_GET['ip'];
			$sql = 'select top 500 t1.GjcID,t1.IP,t1.Area,CONVERT(varchar,t1.InsertDate,120) as InsertDate,t2.Info from QPRecordDB.dbo.GjcRecord t1 left join QPRecordDB.dbo.GjcInfo t2 on t1.GjcID=t2.ID where t1.IP="'.$ip.'" order by t1.ID desc';
			//echo $sql;
			$rs=$mssql->query($sql);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1;
				$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
				$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
			}
			$this->assign('rs',$rs);
		}
		$this->display('tj_ip');

	}

	//删除首冲提示用户
	function delSc(){
	if($_SESSION['zs78_admin2']['id']==15){
		_location("无此权限",WEB_ROOT.'index.php/User/ScUserList');
	}
		if(isset($_GET['UserID']) && $_GET['UserID']!=''){
			$UserID = $_GET['UserID'];
		}else{
			$this->ScUserList();
		}
		$mssql=M();
		$sql3='select GameID from [QPAccountsDB].[dbo].[AccountsInfo] where UserID='.$UserID;
		$rs3=$mssql->query($sql3);
		$GameID=$rs3[0]['GameID'];
			$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);

			$procedure = mssql_init("GSP_GR_DelUserRecord",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			$resource = mssql_execute($procedure,false);
			mssql_free_statement($procedure);
			mssql_close($conn);
		$sql = 'delete [QPRecordDB].[dbo].[RecordNewCzUser] where UserID='.$UserID;
		$sql2 = 'update [QPAccountsDB].[dbo].[AccountsInfo] set LoveLiness=0 where UserID='.$UserID;
		$mssql->query($sql);
		$mssql->query($sql2);
		_location("删除成功",WEB_ROOT."index.php/User/ScUserList");

	}

	//删除首冲提示用户
	function delSc2(){
	if($_SESSION['zs78_admin2']['id']==15){
		_location("无此权限",WEB_ROOT.'index.php/User/ScUserList');
	}
		if(isset($_GET['GameID']) && $_GET['GameID']!=''){
			$GameID = $_GET['GameID'];
		}else{
			$this->ScUserList();
		}
		$mssql=M();
		$sql3='select UserID from [QPAccountsDB].[dbo].[AccountsInfo] where GameID='.$GameID;
		$rs3=$mssql->query($sql3);
		$UserID=$rs3[0]['UserID'];
			$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);

			$procedure = mssql_init("GSP_GR_DelUserRecord",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			$resource = mssql_execute($procedure,false);
			mssql_free_statement($procedure);
			mssql_close($conn);
		$sql = 'delete [QPRecordDB].[dbo].[RecordNewCzUser] where UserID='.$UserID;
		$sql2 = 'update [QPAccountsDB].[dbo].[AccountsInfo] set LoveLiness=0 where UserID='.$UserID;
		$mssql->query($sql);
		$mssql->query($sql2);
		_location("删除成功",WEB_ROOT."index.php/User/ScUserList");

	}

	//删除首冲提示用户
	function delScTest(){
		if(isset($_GET['UserID']) && $_GET['UserID']!=''){
			$UserID = $_GET['UserID'];
		}else{
			$this->ScUserList();
		}
		$mssql=M();
		$sql3='select GameID from [QPAccountsDB].[dbo].[AccountsInfo] where UserID='.$UserID;
		$rs3=$mssql->query($sql3);
		$GameID=$rs3[0]['GameID'];
			$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);

			$procedure = mssql_init("GSP_GR_DelUserRecord",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			$resource = mssql_execute($procedure,false);
			mssql_free_statement($procedure);
			mssql_close($conn);
		$sql = 'delete [QPRecordDB].[dbo].[RecordNewCzUser] where UserID='.$UserID;
		$sql2 = 'update [QPAccountsDB].[dbo].[AccountsInfo] set LoveLiness=0 where UserID='.$UserID;
		$mssql->query($sql);
		$mssql->query($sql2);
		_location("删除成功",WEB_ROOT."index.php/User/ScUserList");

	}

	//抽奖查询
	public function cj(){
		$mssql=M();
		if(isset($_GET['GameID'])){
			$GameID=$_GET['GameID'];
			$sql = 'select CONVERT(varchar,t1.[Time],120) as InsertDate,t1.cost,t1.win from [QPTaskDB].[dbo].[LogAward](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.userid=t2.UserID where t2.GameID='.$GameID.' order by ID desc';

			$rs = $mssql->query($sql);
			for($i=0;$i<count($rs);$i++){
				$rs[$i]['no'] = $i+1;
			}
			$this->assign('GameID',$GameID);
			$this->assign('rs',$rs);
			$this->display('cj');

		}else{
			$this->display('cj');
		}
	}

	//玩家转出详细  (*****)
    public function aaa(){

		if($_GET['GameID']){
			$GameID=$_GET['GameID'];
			$conn=mssql_connect($GLOBALS['DB_KZ']['DB_HOST'],$GLOBALS['DB_KZ']['DB_USER'],$GLOBALS['DB_KZ']['DB_PWD']);
			mssql_select_db($GLOBALS['DB_KZ']['DB_NAME']);

			$procedure = mssql_init("PHP_GetByKz",$conn);
			mssql_bind($procedure,"@GameID", $GameID, SQLINT4);
			$resource = mssql_execute($procedure,false);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
			mssql_free_statement($procedure);
			mssql_close($conn);
			for($i=0;$i<count($rs);$i++){
				if(strlen($rs[$i]['StartTime'])<6){
					$rs[$i]['StartTime']='0'.$rs[$i]['StartTime'];
					//echo $rs[$i]['StartTime'].'</br>';
				}
				$rs[$i]['StartDate']=date('Y-m-d H:i:s',strtotime($rs[$i]['StartDate'].$rs[$i]['StartTime']));
				if(strlen($rs[$i]['EndTime'])<6){
					$rs[$i]['EndTime']='0'.$rs[$i]['EndTime'];
				}
				$rs[$i]['EndDate']=date('Y-m-d H:i:s',strtotime($rs[$i]['EndDate'].$rs[$i]['EndTime']));

			}
			$this->assign('rs',$rs);
			$this->assign('GameID',$GameID);
		}
		print_r($rs);
		$this->display('by_kz');


    }

	//关联号查询
    public function gl(){
        $this->display('user_gl');

    }

	//关联号查询
    public function new_version(){

		$user_ff = 0;
		$ids='';
		$user_login['ios']=0;
		$user_login['android']=0;
		$user_login['pc']=0;
		$gjf = array(75,76,77,78,85,86,87,88,95,96,97,98,105,106,107,108);
		$mssql = M();
		$sql = 'select count(t1.UserID) as num from QPTreasureDB.dbo.GameScoreLocker t1 left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID=t2.UserID where t2.SerialNumber>888';
		$rs = $mssql->query($sql);
		$count_online=$rs[0]['num'];
		echo $count_online;
		$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
		$rs = array();
		$score_sum = 0;
		$procedure = mssql_init("PHP_new_version",$conn);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_assoc($resource)){
				$rs[] = $row;
			}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			if($rs[$i]['KindID']==2060 || $rs[$i]['KindID']==2070 || $rs[$i]['KindID']==2075 || $rs[$i]['KindID']==2080){
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",$rs[$i]['ServerName']);
			}else{
				$rs[$i]['ServerName'] = iconv("GBK","UTF-8",$rs[$i]['KindName']).'-'.iconv("GBK","UTF-8",substr($rs[$i]['ServerName'],0,strpos($rs[$i]['ServerName'],'-')));
			}
			$score_sum = $score_sum+$rs[$i]['sum'];
			$rs[$i]['Total'] = number_format($rs[$i]['sum']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			if(in_array($rs[$i]['ServerID'],$gjf)){
				$rs[$i]['is_gjf']=1;
			}else{
				$rs[$i]['is_gjf']=0;
			}
			if($rs[$i]['CustomID']==1){
                $rs[$i]['nozz']=1;
				$user_ff =  $user_ff+1;
				if($rs[$i]['LockMobileKindID']==1){
					$user_login['ios'] = $user_login['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==2){
					$user_login['android'] = $user_login['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==3){
					$user_login['pc'] = $user_login['pc']+1;
				}else{
					$user_login['pc'] = $user_login['pc']+1;
				}

            }else{
				$rs[$i]['nozz']=0;
            	if($rs[$i]['LockMobileKindID']==1){
					$user_login_mf['ios'] = $user_login_mf['ios']+1;
				}elseif($rs[$i]['LockMobileKindID']==2){
					$user_login_mf['android'] = $user_login_mf['android']+1;
				}elseif($rs[$i]['LockMobileKindID']==3){
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}else{
					$user_login_mf['pc'] = $user_login_mf['pc']+1;
				}
            }

		}
		$score_sum = number_format($score_sum);
        //print_r($rs);
		$user_mf = count($rs)-$user_ff;
    	$this->assign('result',$rs);
		$this->assign('count_online',$count_online);
		$this->assign('user_login',$user_login);
		$this->assign('user_login_mf',$user_login_mf);
		$this->assign('score_sum',$score_sum);
		$this->assign('user_ff',$user_ff);
		$this->assign('user_mf',$user_mf);

        $this->display('new_version');

    }

	//vip转入转出记录
    public function inout_record(){
        $mssql = M();
        if(isset($_GET['date'])){
        	$InsertDate=$_GET['date'];
        }else{
        	$InsertDate = date('Y-m-d');
        }

        $sql1 = 'SELECT t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,t24,InsertDate FROM QPWebBackDB.dbo.UserZcCount where InsertDate="'.$InsertDate.'"';
        $rs1 = $mssql->query($sql1);

        $sql2 = 'SELECT t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,t17,t18,t19,t20,t21,t22,t23,t24,InsertDate FROM QPWebBackDB.dbo.UserZrCount where InsertDate="'.$InsertDate.'"';
        $rs2 = $mssql->query($sql2);
     	foreach($rs1[0] as $k=>$v){
			$rs1[0][$k]=number_format($rs1[0][$k]);
		}
		foreach($rs2[0] as $k2=>$v2){
			$rs2[0][$k2]=number_format($rs2[0][$k2]);
		}
        $this->assign('zc',$rs1[0]);
        $this->assign('zr',$rs2[0]);
        $this->assign('date',$InsertDate);
        $this->display('inout_count');
    }

	//非活跃vip
    public function unvip(){
        $mssql = M();
        if(isset($_GET['date'])){
        	$InsertDate=$_GET['date'];
        }else{
        	$InsertDate = date('Y-m-d');
        }
        $start_date=$InsertDate.' 00:00:00';
        $end_date=$InsertDate.' 23:59:59';
        //echo $start_date;
        $sql = 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate,t2.Score,t2.InsureScore FROM QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID  where t1.MemberOrder>0 and t1.CustomFaceVer=0 and (t2.Score+t2.InsureScore)>1000000 and t1.UserID not in (1582724,3972171,4465772,3839304,1331162) and t1.UserID not in (select t3.SourceUserID from QPTreasureDB.dbo.RecordInsure(nolock) t3 left join QPAccountsDB.dbo.AccountsInfo(nolock) t4 on t3.SourceUserID=t4.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t5 on t3.TargetUserID=t5.UserID where t4.MemberOrder>0 and t5.MemberOrder=0 and t3.CollectDate between "'.$start_date.'" and "'.$end_date.'" group by t3.SourceUserID) order by t1.LastLogonDate desc';
        $rs = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['zong'] = $rs[$i]['Score']+$rs[$i]['InsureScore'];
			$rs[$i]['zong'] = number_format($rs[$i]['zong']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
		}

        $this->assign('rs',$rs);
        $this->assign('date',$InsertDate);
        $this->display('unvip');
    }


	//5678注册
	public function newUser_5678(){

		$mssql = M();

		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.PassPortID,t1.RegisterFrom,t1.MemberOrder,t1.CustomFaceVer,
		t1.LockMobileFrom,t1.CustomID,t2.Score,t2.InsureScore,t1.RegisterIP,t1.RegisterMachine,t1.RegisterMobile,t1.LastLogonIP,
		t1.LastLogonMachine,CONVERT(varchar,t1.RegisterDate,120) AS RegisterDate,t3.IP_C,t3.MAC_C from
		QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID left join
		QPRecordDB.dbo.RecordRegUser(nolock) t3 on t1.UserID=t3.UserID where t1.isandroid=0 and (t1.RegisterFrom=5 or t1.RegisterFrom=15)
		 and t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" order by t1.RegisterDate desc';
		//ECHO $sql;
		$rs = $mssql->query($sql);
		$sum=0;
		$yx=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$sum=$sum+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
			if($rs[$i]['CustomID']>0 || $rs[$i]['LockMobileFrom']>0){
				$yx=$yx+1;
			}
		}
		$this->assign('rs',$rs);
		$this->assign('sum',$sum);
		$this->assign('yx',$yx);
		$this->display('new_5678user');
	}

	//5678注册数据
	public function userCount_5678(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.PassPortID,t1.RegisterFrom,t1.MemberOrder,t1.CustomFaceVer,
		t1.LockMobileFrom,t1.CustomID,t2.Score,t2.InsureScore,t1.RegisterIP,t1.RegisterMachine,t1.RegisterMobile,t1.LastLogonIP,
		t1.LastLogonMachine,CONVERT(varchar,t1.RegisterDate,120) AS RegisterDate,t3.IP_C,t3.MAC_C from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID left join QPRecordDB.dbo.RecordRegUser(nolock) t3 on t1.UserID=t3.UserID where t1.isandroid=0 and (t1.CustomID>0 or t1.LockMobileFrom>0) and (t1.RegisterFrom=5 or t1.RegisterFrom=15) and t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" order by t1.RegisterDate desc';
		//ECHO $sql;
		$sql2 = 'select count(UserID) as c from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where (RegisterFrom=5 or RegisterFrom=15) and RegisterDate between "'.$start_date.'" and "'.$end_date.'"';
		$rs = $mssql->query($sql);
		$rs2 = $mssql->query($sql2);
		$sum=$rs2[0]['c'];
		$yx=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
			$rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
			$yx=$yx+1;
		}
		$this->assign('rs',$rs);
		$this->assign('sum',$sum);
		$this->assign('yx',$yx);
		$this->display('userCount_5678');
	}

	//5678chongzhi
	public function cz_5678(){
		$mssql = M();
		IF(ISSET($_GET['GameID'])){
			$sql2= 'SELECT t1.UserID,t1.DetailID,t1.GameID,t1.Accounts,t2.Present,t2.NickName,t2.LockMobileFrom,t2.RegisterFrom,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate,CONVERT(varchar,t2.RegisterDate,120) as RegisterDate ';
			$sql2.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.GameID='.$_GET['GameID'].' order by DetailID desc';
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$sum=0;
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
        $sql2= 'SELECT t1.UserID,t1.DetailID,t1.GameID,t1.Accounts,t2.Present,t2.NickName,t2.LockMobileFrom,t2.RegisterFrom,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate,CONVERT(varchar,t2.RegisterDate,120) as RegisterDate ';
        $sql2.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where (t2.RegisterFrom=5 or t2.RegisterFrom=15) and ApplyDate between "'.$start_date.'" and "'.$end_date.'" order by DetailID desc';

        $rs2 = $mssql->query($sql2);

        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
            $rs2[$i]['BeforeGold'] = number_format($rs2[$i]['BeforeGold']);
			$sum=$sum+$rs2[$i]['PayAmount'];
        }
		$this->assign('sum',$sum);
        $this->assign('result',$rs2);
        $this->display('cz_5678');
	}

	//5678zhuanzhang
	public function zz_5678(){
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$sum=0;
		$user=array();
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_5678ZzList",$conn);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
			if($rs[$i]['SwapScore']>=100000000){
				$rs[$i]['color']=3;
			}elseif($rs[$i]['SwapScore']>=10000000){
				$rs[$i]['color']=2;
			}else{
				$rs[$i]['color']=1;
			}
			if($rs[$i]['MemberOrder1']>0 && $rs[$i]['MemberOrder2']==0){
				$sum=$sum+$rs[$i]['SwapScore'];
				if(!in_array($rs[$i]['GameID2'],$user)){
					$user[]=$rs[$i]['GameID2'];
				}
			}
			if($rs[$i]['MemberOrder1']==0 && $rs[$i]['MemberOrder2']>0){
				$sum=$sum-$rs[$i]['SwapScore'];
			}
			if($rs[$i]['MemberOrder1']==0 && $rs[$i]['MemberOrder2']==0){
				$sum=$sum+$rs[$i]['SwapScore'];
			}
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
		}
		$usercount=count($user);
		$sum = number_format($sum);
		//$gold_sum = $this->getUserGold();
		//$this->assign('gold_sum',$gold_sum);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('usercount',$usercount);
		$this->assign('sum',$sum);
		$this->assign('type',$type);
		$this->assign('result',$rs);
    	$this->display('zz_list5678');
	}

	//zzl注册
	public function newUser_zzl(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.PassPortID,t1.RegisterFrom,t1.MemberOrder,t1.CustomFaceVer,t1.LockMobileFrom,t1.CustomID,t2.Score,t2.InsureScore,t1.RegisterIP,t1.RegisterMachine,t1.RegisterMobile,t1.LastLogonIP,t1.LastLogonMachine,CONVERT(varchar,t1.RegisterDate,120) AS RegisterDate,t3.IP_C,t3.MAC_C from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID left join QPRecordDB.dbo.RecordRegUser(nolock) t3 on t1.UserID=t3.UserID where t1.isandroid=0 and (t1.RegisterFrom>20 and t1.RegisterFrom<30) and t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" order by t1.RegisterDate desc';
		//ECHO $sql;
		$rs = $mssql->query($sql);
		$sum=0;
		$yx=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$sum=$sum+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
			if($rs[$i]['CustomID']>0 || $rs[$i]['LockMobileFrom']>0){
				$yx=$yx+1;
			}
		}
		$this->assign('rs',$rs);
		$this->assign('sum',$sum);
		$this->assign('yx',$yx);
		$this->display('new_zzluser');
	}

	//zzl注册数据
	public function userCount_zzl(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.PassPortID,t1.RegisterFrom,t1.MemberOrder,t1.CustomFaceVer,t1.LockMobileFrom,t1.CustomID,t2.Score,t2.InsureScore,t1.RegisterIP,t1.RegisterMachine,t1.RegisterMobile,t1.LastLogonIP,t1.LastLogonMachine,CONVERT(varchar,t1.RegisterDate,120) AS RegisterDate,t3.IP_C,t3.MAC_C from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID left join QPRecordDB.dbo.RecordRegUser(nolock) t3 on t1.UserID=t3.UserID where t1.isandroid=0 and (t1.CustomID>0 or t1.LockMobileFrom>0) and t1.RegisterFrom>20 and t1.RegisterFrom<30 and t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" order by t1.RegisterDate desc';
		//ECHO $sql;
		$sql2 = 'select count(UserID) as c from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where RegisterFrom>20 and RegisterFrom<30 and RegisterDate between "'.$start_date.'" and "'.$end_date.'"';
		$rs = $mssql->query($sql);
		$rs2 = $mssql->query($sql2);
		$sum=$rs2[0]['c'];
		$yx=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
			$rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
			$yx=$yx+1;
		}
		$this->assign('rs',$rs);
		$this->assign('sum',$sum);
		$this->assign('yx',$yx);
		$this->display('userCount_zzl');
	}

	//zzlchongzhi
	public function cz_zzl(){
		$mssql = M();
		IF(ISSET($_GET['GameID'])){
			$sql2= 'SELECT t1.UserID,t1.DetailID,t1.GameID,t1.Accounts,t2.Present,t2.NickName,t2.LockMobileFrom,t2.RegisterFrom,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate,CONVERT(varchar,t2.RegisterDate,120) as RegisterDate ';
			$sql2.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.GameID='.$_GET['GameID'].' order by DetailID desc';
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$sum=0;
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
        $sql2= 'SELECT t1.UserID,t1.DetailID,t1.GameID,t1.Accounts,t2.Present,t2.NickName,t2.LockMobileFrom,t2.RegisterFrom,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate,CONVERT(varchar,t2.RegisterDate,120) as RegisterDate ';
        $sql2.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.RegisterFrom>20 and t2.RegisterFrom<30 and ApplyDate between "'.$start_date.'" and "'.$end_date.'" order by DetailID desc';

        $rs2 = $mssql->query($sql2);

        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
            $rs2[$i]['BeforeGold'] = number_format($rs2[$i]['BeforeGold']);
			$sum=$sum+$rs2[$i]['PayAmount'];
        }
		$this->assign('sum',$sum);
        $this->assign('result',$rs2);
        $this->display('cz_zzl');
	}

	//zzlzhuanzhang
	public function zz_zzl(){
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$sum=0;
		$user=array();
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_zzlZzList",$conn);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
			if($rs[$i]['SwapScore']>=100000000){
				$rs[$i]['color']=3;
			}elseif($rs[$i]['SwapScore']>=10000000){
				$rs[$i]['color']=2;
			}else{
				$rs[$i]['color']=1;
			}
			if($rs[$i]['MemberOrder1']>0 && $rs[$i]['MemberOrder2']==0){
				$sum=$sum+$rs[$i]['SwapScore'];
				if(!in_array($rs[$i]['GameID2'],$user)){
					$user[]=$rs[$i]['GameID2'];
				}
			}
			if($rs[$i]['MemberOrder1']==0 && $rs[$i]['MemberOrder2']>0){
				$sum=$sum-$rs[$i]['SwapScore'];
			}
			if($rs[$i]['MemberOrder1']==0 && $rs[$i]['MemberOrder2']==0){
				$sum=$sum+$rs[$i]['SwapScore'];
			}
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
		}
		$usercount=count($user);
		$sum = number_format($sum);
		//$gold_sum = $this->getUserGold();
		//$this->assign('gold_sum',$gold_sum);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('usercount',$usercount);
		$this->assign('sum',$sum);
		$this->assign('type',$type);
		$this->assign('result',$rs);
    	$this->display('zz_listzzl');
	}


	//uc注册
	public function newUser_uc(){
	$mssql = M();

	if(isset($_GET['start_date'])){
		$start_date = $_GET['start_date'];
	}else{
		$start_date = date('Y-m-d').' 00:00:00';
	}
	if(isset($_GET['end_date'])){
		$end_date = $_GET['end_date'];
	}else{
		$end_date = date('Y-m-d').' 23:59:59';
	}
	$this->assign('start_date',$start_date);
	$this->assign('end_date',$end_date);
	// $sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.PassPortID,t1.RegisterFrom,t1.MemberOrder,t1.CustomFaceVer,
	// t1.LockMobileFrom,t1.CustomID,t2.Score,t2.InsureScore,t1.RegisterIP,t1.RegisterMachine,t1.RegisterMobile,t1.LastLogonIP,
	// t1.LastLogonMachine,CONVERT(varchar,t1.RegisterDate,120) AS RegisterDate,t3.IP_C,t3.MAC_C from
	// QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID left join
	// QPRecordDB.dbo.RecordRegUser(nolock) t3 on t1.UserID=t3.UserID where t1.isandroid=0 and (t1.RegisterFrom=51 or t1.RegisterFrom=52)
	//  and t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" order by t1.RegisterDate desc';
	//  $rs = $mssql->query($sql);

	 $conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
	 mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
	 $rs = array();
	 $procedure = mssql_init("PHP_ucZcList",$conn);
	 mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
	 mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
	 $resource = mssql_execute($procedure);
	 while($row = mssql_fetch_assoc($resource)){
		 $rs[] = $row;
	 }
	 mssql_free_statement($procedure);
	 mssql_close($conn);

	 $sum=0;
	 $yx=0;
	 for($i=0;$i<count($rs);$i++){
		$rs[$i]['no'] = $i+1;
		$sum=$sum+1;
		$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
		$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
		$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
					$rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
		if($rs[$i]['CustomID']>0 || $rs[$i]['LockMobileFrom']>0){
			$yx=$yx+1;
		}
	 }
	 $this->assign('rs',$rs);
	 $this->assign('sum',$sum);
	 $this->assign('yx',$yx);
	 $this->display('new_ucuser');

	}


	function GzUserList(){
		$mssql = M();
		$sql = 'select top 200 t1.UserID,t2.GameID,t2.Accounts,t2.NickName,t2.LastLogonIP,CONVERT(varchar,t2.LastLogonDate,120) AS LastLogonDate,t3.Score,t3.InsureScore,t4.KindID,t4.ServerID from QPRecordDB.dbo.GzUser(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID=t2.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID left join QPTreasureDB.dbo.GameScoreLocker(nolock) t4 on t1.UserID=t4.UserID order by t3.InsureScore desc';
		$rs = $mssql->query($sql);

		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Score'] = number_format($rs[$i]['Score']);
			$rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
			$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
			if($rs[$i]['ServerID']==null){
				$rs[$i]['game'] = '不在线';
				$rs[$i]['r']=0;
			}else{
				$room = $this->game_room($rs[$i]['UserID']);
				$rs[$i]['game'] = $room[0]['GameName'].'--'.$room[0]['ServerName'];
				$rs[$i]['r']=1;
			}
		}
		$this->assign('result',$rs);
		$this->display('gz_user');
	}

	//添加提示用户
	function addGz(){
		$type = $_GET['type'];
		$GameID = $_GET['GameID'];
		$mssql=M();

        $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo(nolock) where GameID='.$GameID;


		if(!$rs = $mssql->query($sql)){
			_location("该条件用户不存在",WEB_ROOT."index.php/User/TsUserList");
		}else{
            for($i=0;$i<count($rs);$i++){
                $sql2 = 'select UserID from QPRecordDB.dbo.GzUser(nolock) where UserID='.$rs[$i]['UserID'];
                if(!$rs2=$mssql->query($sql2)){
                    $sql3='INSERT INTO QPRecordDB.dbo.GzUser (UserID,GameID) VALUES('.$rs[$i]['UserID'].','.$rs[$i]['GameID'].')';
                    $mssql->query($sql3);
                }
            }
			_location("添加成功",WEB_ROOT."index.php/User/GzUserList");

		}
	}

	//删除提示用户 GameID
	function delGz(){
		if(isset($_GET['GameID']) && $_GET['GameID']!=''){
			$GameID = $_GET['GameID'];
		}else{
			$this->GzUserList();
			return;
		}
		$mssql=M();
		$sql3 = 'select UserID from QPAccountsDB.dbo.AccountsInfo(nolock) where GameID='.$GameID;
		$rs3=$mssql->query($sql3);
		$UserID=$rs3[0]['UserID'];
		if(!$UserID){
			_location("GameID不存在",WEB_ROOT."index.php/User/GzUserList");
			return;
		}
		$sql = 'delete QPRecordDB.dbo.GzUser where GameID='.$GameID;
		$mssql->query($sql);

			_location("删除成功",WEB_ROOT."index.php/User/GzUserList");
	}

	public function getkouliang(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$game=$_POST['game'];
		$time=$_POST['time'];

$kouliang=$_POST['kouliang'];
		$mssql = M();

	  $sql = 'insert into  QPStatisticsDB.dbo.kouliang values("'.$kouliang.'","'.$time.'","'.$game.'") ';

		$mssql->query($sql);
		_back('设置成功');}
		else{

    $this->display('getkouliang');
		}

	}


	public function data_rc(){
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$start_date=$_POST['start_date'];
		$end_date=$_POST['end_date'];
		  $typeid=$_POST['typeid'];
		$name='result'.$typeid;
               $re=S($name);
		if(!$re){


    $typeid=$_POST['typeid'];

		$conn=mssql_connect($GLOBALS['DB_STATISTICS']['DB_HOST'],$GLOBALS['DB_STATISTICS']['DB_USER'],$GLOBALS['DB_STATISTICS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_STATISTICS']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_RCdata",$conn);
		// mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		// mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		mssql_bind($procedure,"@typeid", $typeid, SQLVARCHAR);

 		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
		$mssql = M();
		$sql = 'SELECT TOP 1 kouliang from QPStatisticsDB.dbo.kouliang where qdid='.$typeid.' order by time desc';
		$rs2 = $mssql->query($sql);
		if($rs2[0]['kouliang']==''){
$rs2[0]['kouliang']=1;

		}
		   $rs[0]['kczje']=$rs[0]['czje']*$rs2[0]['kouliang'];
			 $rs[0]['kzcje']=$rs[0]['zcje']*$rs2[0]['kouliang'];
		   $rs[0]['kzcylc']= sprintf("%.2f", $rs[0]['zcylc']/$rs[0]['zhuceyh_num']*100);
			 $rs[0]['kffylc']= sprintf("%.2f", $rs[0]['ffylc']/$rs[0]['zhuceyh_num']*100);
			 $rs[0]['kqrlc']= sprintf("%.2f", $rs[0]['qrlc']/$rs[0]['zhuceyh_num']*100);
			 $rs[0]['kylc']=sprintf("%.2f", $rs[0]['ylc']/$rs[0]['zhuceyh_num']*100);
        $name='result'.$typeid;
			 	S($name,$rs,1800);
		   $this->assign('result',$rs);
			    $this->display('data_rc');
				}else{


 $this->assign('result',$re);
		$this->display('data_rc');

				}
		 }
			 else{
				   $this->display('data_rc');
			 }


 	}




	public function kouliang(){
		$mssql=M();
		$sql = 'select *
from QPStatisticsDB.dbo.kouliang   a
where EXISTS
(select 1 FROM
(select qdid,max(time)time from QPStatisticsDB.dbo.kouliang    group by qdid) b where a.qdid=b.qdid and a.time =b.time )';
 		$rs = $mssql->query($sql);
		$this->assign('result',$rs);
		$this->display('kouliang');

	}

	public function newUser_cz(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$RegisterFrom=$_POST['regFrom'];
			$typeid=$_POST['typeid'];
		$start_date=$_POST['start_date'];
		$end_date=$_POST['end_date'];
		$conn=mssql_connect($GLOBALS['DB_STATISTICS']['DB_HOST'],$GLOBALS['DB_STATISTICS']['DB_USER'],$GLOBALS['DB_STATISTICS']['DB_PWD']);
 	 mssql_select_db($GLOBALS['DB_STATISTICS']['DB_NAME']);
 	 $rs = array();
 	 $procedure = mssql_init("PHP_cznewUser",$conn);
 	 mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
 	 mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
	 mssql_bind($procedure,"@typeid", $typeid, SQLVARCHAR);
	 	 mssql_bind($procedure,"@regFrom", $RegisterFrom, SQLVARCHAR);
 	 $resource = mssql_execute($procedure);
 	 while($row = mssql_fetch_assoc($resource)){
 		 $rs[] = $row;
 	 }
 	 mssql_free_statement($procedure);
 	 mssql_close($conn);


  $this->assign('result',$rs);
	 	$this->display('newUser_cz');
	}
		else{

			$this->display('newUser_cz');

		}

	}

public function qdqx(){

			$mssql=M();
			$sql='SELECT name,qudao FROM QPStatisticsDB.dbo.qdshangqx ';


			$sql2='SELECT name,qudao FROM QPStatisticsDB.dbo.tuiguangqx ';
			$rs = $mssql->query($sql);

			$rs2 = $mssql->query($sql2);
			$this->assign('result2',$rs2);
	   $this->assign('result',$rs);
		$this->display('qdshangqx');

}
// public function qdshangqx(){
//
//
// 		$mssql=M();
// 		$sql='SELECT name,qudao FROM QPStatisticsDB.dbo.qdshangqx ';
// 		$rs = $mssql->query($sql);
// 		$this->assign('result',$rs);
//
// 		$sql2='SELECT name,qudao FROM QPStatisticsDB.dbo.tuiguangqx ';
// 		$rs2 = $mssql->query($sql2);
// 		$this->assign('result2',$rs2);
//  		$this->display('qdshangqx');
//
//
//
// }
//
// public function getqdqx(){
// 	if($_SERVER['REQUEST_METHOD'] == 'POST'){
//         $game=$_POST['game'];
// 				    $Username=$_POST['Username'];
// 		     $str="";
//         for ($i = 0;$i<count($game);$i++){
//         if($i<(count($game)-1)){
//         $str .= $game[$i].",";
//         }else{
//         $str .=  $game[$i]."";
//         }
//         }
// 				$A="'".$str."'";
// 				$B="'".$Username."'";
// 				$mssql=M();
// 				$sql='update QPStatisticsDB.dbo.quanxian set qudao='.$A.' where name='.$B.' ';
// 				$rs = $mssql->query($sql);
//         _back('修改成功');
// 	}
// 	$mssql=M();
// 	$sql='SELECT name FROM QPStatisticsDB.dbo.quanxian ';
// 	$rs = $mssql->query($sql);
// 	$this->assign('result',$rs);
// $this->display('getqdqx');
//
// }



// public function regqdnum(){
// 	if($_SERVER['REQUEST_METHOD'] == 'POST'){
//         $game=$_POST['game'];
// 				    $Username=$_POST['username'];
// 						$Password=md5($_POST['Password']);
// 		     $str="";
//         for ($i = 0;$i<count($game);$i++){
//         if($i<(count($game)-1)){
//         $str .= $game[$i].",";
//         }else{
//         $str .=  $game[$i]."";
//         }
//         }
// 				$A="'".$str."'";
// 				$B="'".$Username."'";
// 				$C="'".$Password."'";
// 				$mssql=M();
// 				$sql1='select userName from QPPlatformManagerDB.dbo.Base_Users where userName='.$B.'';
// 				 $rs1 = $mssql->query($sql1);
// 				 if($rs1[0]['userName']!=''){
// 				  _back('添加失败账号已存在');
// 				 }else{
//
//
//         $sql1='insert into QPStatisticsDB.dbo.quanxian(Name,qudao)values('.$B.','.$A.') ';
// 				$sql2='insert into QPPlatformManagerDB.dbo.Base_Users(Username,Password,RoleID)values('.$B.','.$C.',1) ';
//  				$rs1 = $mssql->query($sql1);
// 				$rs2 = $mssql->query($sql2);
//         _back('添加成功');
//
// 			}
// 	}
//
// $this->display('regqdnum');
//
// }
public function  CheckUN(){
$id=$_GET['id'];
$B="'".$id."'";
$mssql=M();
$sql1='select userName from QPPlatformManagerDB.dbo.Base_Users where userName='.$B.'';
 $rs1 = $mssql->query($sql1);
if($rs1[0]['userName']!=''){

	 $data['status']='0';
  echo 0;

}else {
	$data['status']='1';
 echo 1;

}


}
public function userdata_check(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$id=$_POST['id'];
		$A="'".$id."'";
		$mssql=M();
		$sql1='SELECT count(t2.userid) as count from
		QPRecordDB.dbo.RecordAndroidOpen As  t1,
		QPAccountsDB.dbo.AccountsInfo As  t2
		Where t1.typeid='.$A.'
		And t1.machine=t2.RegisterMachine ';


		 $sql2='SELECT a.UserID,C.TargetUserID,c.SwapScore,CONVERT(varchar(100),c.CollectDate,120) as CollectDate,d.PayAmount,CONVERT(varchar(100),d.ApplyDate, 120) as ApplyDate
,f.serverid,f.ConcludeTime-f.StartTime AS gametime
from QPAccountsDB.dbo.AccountsInfo a
LEFT join QPRecordDB.dbo.RecordAndroidOpen b on a.RegisterMachine=b.Machine
left JOIN QPTreasureDB.dbo.RecordInsure c on a.UserID=c.SourceUserID
left join QPTreasureDB.dbo.ShareDetailInfo d on a.UserID=d.UserID
left join QPTreasureDB.dbo.RecordDrawList f ON a.UserID=f.UserID
WHERE b.typeid='.$A.'
ORDER BY a.UserID
';




		$sql='select distinct(typeid) from QPRecordDB.dbo.RecordAndroidOpen';
		$re=S('result');
		if(!$re){
			$rs= $mssql->query($sql);
			S('result',$rs,1800);
			$this->assign('result',$rs);

		}else{
			$re=S('result');
			$this->assign('result',$re);


		}

		$re=S('typeid');

		if($re!=$id){
		$rs= $mssql->query($sql);
		$rs1 = $mssql->query($sql1);
		$rs2 = $mssql->query($sql2);

		S('result1',$rs1,1800);
		S('result2',$rs2,1800);

		S('typeid',$id,1800);

		$this->assign('result1',$rs1);
		$this->assign('result2',$rs2);

		$this->display('userdata_check');
		}else{

		$re1=S('result1');
		$re2=S('result2');



		$this->assign('result1',$re1);
		$this->assign('result2',$re2);

 		$this->display('userdata_check');
		}
}else {
	$mssql=M();
	$sql='select distinct(typeid) from QPRecordDB.dbo.RecordAndroidOpen';
	$re=S('result');
	if(!$re){
		$rs= $mssql->query($sql);
		S('result',$rs,1800);
		$this->assign('result',$rs);
		$this->display('userdata_check');
	}else{
		$re=S('result');
		$this->assign('result',$re);
		$this->display('userdata_check');

	}
}

}


}
