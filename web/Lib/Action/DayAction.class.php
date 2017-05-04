<?php
if (!class_exists('db_sqlite')){     require_once(ROOT_PATH . '/Db/pdo/sqlite.class.php'); }
// 本类由系统自动生成，仅供测试用途
class DayAction extends Action {

	public function _initialize(){		
    	if(!isset($_SESSION['hs_admin'])){
    	header("Location: ".WEB_ROOT."index.php/Login");
    	return false;
   		}
   		if($_SESSION['hs_admin']['role']!=1&&$_SESSION['hs_admin']['role']!=5){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   		}
   	}

    public function waste(){   	  
		if($_GET['pageNo']){
    		$pageNo = $_GET['pageNo'];
    	}else{
    		$pageNo = 1;
    	}	
    	$pageSize = PAGE_SIZE_2;
    	$offset = $pageSize*($pageNo-1);   	
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select id,insert_date,G_108,G_114,G_27,G_102,G_28,G_19,G_7,G_104,G_122,G_109,G_105 from game_waste order by insert_date desc limit '.$offset.','.$pageSize;
    	$rs = $sqlite->query($sql)->fetchAll();
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['no'] = $i+1+$pageSize*($pageNo-1);    		
    		$rs[$i]['sum'] = $rs[$i]['G_108']+$rs[$i]['G_114']+$rs[$i]['G_27']+$rs[$i]['G_102']+$rs[$i]['G_28']+$rs[$i]['G_19']+$rs[$i]['G_7']+$rs[$i]['G_104']+$rs[$i]['G_122']+$rs[$i]['G_109']+$rs[$i]['G_105'];
    		$rs[$i]['G_108'] = number_format($rs[$i]['G_108']);
    		$rs[$i]['G_114'] = number_format($rs[$i]['G_114']);
    		$rs[$i]['G_27'] = number_format($rs[$i]['G_27']);
    		$rs[$i]['G_102'] = number_format($rs[$i]['G_102']);
    		$rs[$i]['G_28'] = number_format($rs[$i]['G_28']);
    		$rs[$i]['G_19'] = number_format($rs[$i]['G_19']);
    		$rs[$i]['G_7'] = number_format($rs[$i]['G_7']);
    		$rs[$i]['G_104'] = number_format($rs[$i]['G_104']);
    		$rs[$i]['G_122'] = number_format($rs[$i]['G_122']);
    		$rs[$i]['G_109'] = number_format($rs[$i]['G_109']);
    		$rs[$i]['G_105'] = number_format($rs[$i]['G_105']);
    		$rs[$i]['sum'] = number_format($rs[$i]['sum']);
    	}
    	$sql2 = 'select count(id) as num from game_waste';
    	$rs2 = $sqlite->query($sql2)->fetchAll();
    	$pageNum = ceil($rs2[0]['num']/$pageSize);
    	$this->assign('pageNum',$pageNum);
    	$this->assign('result',$rs);
    	$this->display('waste');
    }
    
    //当前损耗
	public function waste_now(){   	  
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');  
    	
		$date_before = date('Y-m-d').' 00:00:00';
		$insert_date=date('Y-m-d').' 23:59:59'; 

		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
    	$procedure = mssql_init("php_game_waste_count",$conn); 
		mssql_bind($procedure,"@day_before", $date_before, SQLVARCHAR); 
		mssql_bind($procedure,"@insert_date", $insert_date, SQLVARCHAR); 	
		$resource = mssql_execute($procedure);
		if ( mssql_num_rows($resource) != 0 ) {  
			$row=mssql_fetch_assoc($resource);						
			$G_108_num = $row['G_108_num'];				//豪车漂移
			$G_114_num = $row['G_114_num'];				//冠军跑马（百人跑马）
			$G_27_num = $row['G_27_num'];				//欢乐斗牛（华商斗牛）
			$G_102_num = $row['G_102_num'];				//二人斗牛（华商二人斗牛）
			$G_28_num = $row['G_28_num'];				//通比牛牛
			$G_19_num = $row['G_19_num'];				//欢乐五张（二人梭哈）
			$G_7_num = $row['G_7_num'];					//十三张
			$G_104_num = $row['G_104_num'];				//百人角斗场（百人牛牛）
			$G_122_num = $row['G_122_num'];				//欢乐30秒（快乐30秒）
			$G_109_num = $row['G_109_num'];				//欢乐小九
			$G_105_num = $row['G_105_num'];				//欢乐两张（温州两张）
		}
	mssql_free_statement($procedure); 
	mssql_close($conn);
	
	$sql = 'select UserID from filter_user where Type=2';
	$rs = $sqlite->query($sql)->fetchAll();
	if($rs){	
		$ids = $rs[0]['UserID'];
		for($i=1;$i<count($rs);$i++){
    		$ids = $ids.','.$rs[$i]['UserID'];
    	}
    	
    	//豪车漂移
		$sql1 = 'SELECT SUM(Score) as G_108_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=108 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs1 = mssql_query($sql1,$conn);
		$result1 = mssql_fetch_assoc($rs1);
		$G_108_vip = $result1['G_108_vip'];
		
		//冠军跑马（百人跑马）
		$sql2 = 'SELECT SUM(Score) as G_114_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=114 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs2 = mssql_query($sql2,$conn);
		$result2 = mssql_fetch_assoc($rs2);
		$G_114_vip = $result2['G_114_vip'];
		
		//欢乐斗牛（华商斗牛）
		$sql3 = 'SELECT SUM(Score) as G_27_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=27 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs3 = mssql_query($sql3,$conn);
		$result3 = mssql_fetch_assoc($rs3);
		$G_27_vip = $result3['G_27_vip'];
		
		//二人斗牛（华商二人斗牛）
		$sql4 = 'SELECT SUM(Score) as G_102_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=102 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs4 = mssql_query($sql4,$conn);
		$result4 = mssql_fetch_assoc($rs4);
		$G_102_vip = $result4['G_102_vip'];
		
		//通比牛牛
		$sql5 = 'SELECT SUM(Score) as G_28_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=28 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs5 = mssql_query($sql5,$conn);
		$result5 = mssql_fetch_assoc($rs5);
		$G_28_vip = $result5['G_28_vip'];
		
		//欢乐五张（二人梭哈）
		$sql6 = 'SELECT SUM(Score) as G_19_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=19 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs6 = mssql_query($sql6,$conn);
		$result6 = mssql_fetch_assoc($rs6);
		$G_19_vip = $result6['G_19_vip'];
		
		//十三张
		$sql7 = 'SELECT SUM(Score) as G_7_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=7 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs7 = mssql_query($sql7,$conn);
		$result7 = mssql_fetch_assoc($rs7);
		$G_7_vip = $result7['G_7_vip'];
		
		//百人角斗场（百人牛牛）
		$sql8 = 'SELECT SUM(Score) as G_104_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=104 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs8 = mssql_query($sql8,$conn);
		$result8 = mssql_fetch_assoc($rs8);
		$G_104_vip = $result8['G_104_vip'];
		
		//欢乐30秒（快乐30秒）
		$sql9 = 'SELECT SUM(Score) as G_122_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=122 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs9 = mssql_query($sql9,$conn);
		$result9 = mssql_fetch_assoc($rs9);
		$G_122_vip = $result9['G_122_vip'];
		
		//欢乐小九
		$sql10 = 'SELECT SUM(Score) as G_109_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=109 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs10 = mssql_query($sql10,$conn);
		$result10 = mssql_fetch_assoc($rs10);
		$G_109_vip = $result10['G_109_vip'];
		
		//欢乐两张（温州两张）
		$sql11 = 'SELECT SUM(Score) as G_105_vip FROM QPTreasureDB.dbo.RecordDrawScore(NOLOCK) WHERE UserID in ('.$ids.') and DrawID in (select DrawID FROM QPTreasureDB.dbo.RecordDrawInfo(NOLOCK) where KindID=105 and InsertTime between CONVERT(varchar,"'.$date_before.'",100) and CONVERT(varchar,"'.$insert_date.'",100))';
		$rs11 = mssql_query($sql11,$conn);
		$result11 = mssql_fetch_assoc($rs11);
		$G_105_vip = $result11['G_105_vip'];
	}else{
		$G_108_vip=0;
		$G_114_vip=0;
		$G_27_vip=0;
		$G_102_vip=0;
		$G_28_vip=0;
		$G_19_vip=0;
		$G_7_vip=0;
		$G_104_vip=0;
		$G_122_vip=0;
		$G_109_vip=0;
		$G_105_vip=0;
	}
	
	$arr = array(	
		'date'=>date('Y-m-d H:i:s'),
		'sum'=>	number_format($G_108_num+$G_108_vip+$G_114_num+$G_114_vip+$G_27_num+$G_27_vip+$G_102_num+$G_102_vip+$G_28_num+$G_28_vip+$G_19_num+$G_19_vip+$G_7_num+$G_7_vip+$G_104_num+$G_104_vip+$G_122_num+$G_122_vip+$G_109_num+$G_109_vip+$G_105_num+$G_105_vip),
		'G_108'=>number_format($G_108_num+$G_108_vip),
		'G_114'=>number_format($G_114_num+$G_114_vip),
		'G_27'=>number_format($G_27_num+$G_27_vip),
		'G_102'=>number_format($G_102_num+$G_102_vip),
		'G_28'=>number_format($G_28_num+$G_28_vip),
		'G_19'=>number_format($G_19_num+$G_19_vip),
		'G_7'=>number_format($G_7_num+$G_7_vip),
		'G_104'=>number_format($G_104_num+$G_104_vip),
		'G_122'=>number_format($G_122_num+$G_122_vip),
		'G_109'=>number_format($G_109_num+$G_109_vip),
		'G_105'=>number_format($G_105_num+$G_105_vip)		
	);    	
		
    	$this->assign('result',$arr);
    	$this->display('waste_now');
    }
	
	//过滤GameID
	public function filter(){
		if($_SESSION['hs_admin']['role']!=1){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$sql = 'select id,UserID,GameID,Accounts,NickName,Is_show,Type from filter_user where Type=2';
    	$rs = $sqlite->query($sql)->fetchAll();
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
		}
		$this->assign('result',$rs);
		$this->display('filter');
	}
	
	//新增GameID
	public function add_filter(){
		if($_SESSION['hs_admin']['role']!=1){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
		$GameID = $_GET['GameID'];		
		$mssql = M();
		$sql = 'select UserID,Accounts,NickName from QPAccountsDB.dbo.AccountsInfo where GameID='.$GameID;
		$rs = $mssql->query($sql);
		if(!$rs){
			_location("该GameID不存在",WEB_ROOT."index.php/Day/filter");
		}else{
			$sqlite = new db_sqlite();
    		$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    		$sql1 = 'select count(id) as num from filter_user where Type=2 and GameID ='.$GameID;
    		$rs1 = $sqlite->query($sql1)->fetchAll();
    		if($rs1[0]['num']>0){
    			_location("该GameID已过滤",WEB_ROOT."index.php/Day/filter");
    		}    		
			$arr = array('UserID'=>$rs[0]['UserID'],'GameID'=>$GameID,'Accounts'=>$rs[0]['Accounts'],'NickName'=>iconv("GB2312","UTF-8",$rs[0]['NickName']),'Type'=>2);
			$sqlite->insert('filter_user', $arr);
			header("Location: ".WEB_ROOT."index.php/Day/filter"); 
		}		
		
	}
	
	//过滤用户删除
	public function filter_del(){
	    if($_SESSION['hs_admin']['role']!=1){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   			return;
   		}
		$UserID = $_GET['UserID'];
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$condition = array('UserID'=>$UserID);
    	$sqlite->delete('filter_user', $condition);  
    	header("Location: ".WEB_ROOT."index.php/Day/filter"); 
	}
	
	//游戏记录导出
	public function game_record(){
		$KindID = $_GET['KindID'];
		$mssql = M();
		$Game = $this->getGameName($KindID);
		$start_date = date('Y-m-d').' 00:00:00';
		$end_date = date('Y-m-d H:i:s');
		$ids = $this->getFilterIds();
		
		//$start_date = '2012-11-11 00:00:00';
		//$end_date = '2014-11-11 00:00:00';
		$sql = 'select t1.DrawID,t2.GameID,t2.NickName,t1.Score,CONVERT(varchar,t1.InsertTime,120) as InsertTime from QPTreasureDB.dbo.RecordDrawScore t1 ';
		$sql.= 'left join QPAccountsDB.dbo.AccountsInfo t2 on t1.UserID = t2.UserID where t1.UserID not in ('.$ids.') and t2.IsAndroid=0 and DrawID in ';
		$sql.= '(select DrawID from QPTreasureDB.dbo.RecordDrawInfo where KindID = '.$KindID.' and InsertTime between "'.$start_date.'" and "'.$end_date.'")';

		$rs = $mssql->query($sql);
		
		for($i=0;$i<count($rs);$i++){
    		$rs[$i]['NickName'] = iconv("GB2312","UTF-8",$rs[$i]['NickName']);			
		}
		$title = array('记录ID','游戏ID','用户昵称','得分','记录时间');
		$filename = $end_date.$Game.'游戏记录';
		exportexcel($rs,$title,$filename);
		
	}
	
	//获取游戏名称
    public function getGameName($KindID){
    	
    	$mssql = M();
    	$sql = 'SELECT t1.GameName as game,t1.GameID,t2.KindID from QPPlatformDB.dbo.GameGameItem(NOLOCK) t1 left join QPPlatformDB.dbo.GameKindItem(NOLOCK) t2 on t1.GameID = t2.GameID WHERE t2.KindID = '.$KindID;
    	$rs = $mssql->query($sql);
    	$rs[0]['game'] = iconv("GB2312","UTF-8",$rs[0]['game']);
		return $rs[0]['game'];
    }
	
    //获取过滤ids
    public function getFilterIds(){
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	//vip账号UserID
		$sql3 = 'select UserID from filter_user where Type=2';
    	$rs3 = $sqlite->query($sql3)->fetchAll();
    	$ids = $rs3[0]['UserID'];
		for($i=1;$i<count($rs3);$i++){
			if($rs3[$i]['UserID'] != $rs3[$i-1]['UserID']){
				$ids = $ids.','.$rs3[$i]['UserID'];
			}    		
    	}
    	return $ids;
    } 
	
	
	
	
	
	
	
}