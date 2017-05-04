<?php
class StaAction extends BaseAction {
	//用户统计列表
	public function user(){
		$this->getDayList();
		$this->display('user');
	}
	//用户统计搜索
	public function userCountSearch(){
		$this->getDayListByDate();
		$this->display('user_search');		
	}
	
	//金币统计列表
	public function gold(){
		$this->getDayList();
		$this->display('gold');
	}
	
	//金币统计搜索
	public function goldCountSearch(){
		$this->getDayListByDate();
		$this->display('gold_search');		
	}
	
	//赠送统计列表
	public function give(){
		$this->getDayList();
		$this->display('give');
	}
	
	//赠送统计搜索
	public function giveCountSearch(){
		$this->getDayListByDate();
		$this->display('give_search');		
	}
	
	//税收统计列表
	public function revenue(){
		$this->getDayList();
		$this->display('revenue');
	}
	
	//税收统计搜索
	public function revenueCountSearch(){
		$this->getDayListByDate();
		$this->display('revenue_search');		
	}
	
	//充值统计列表
	public function recharge(){
		$this->getDayList();
		$this->display('recharge');
	}
	
	//充值统计列表
	public function rechargeCountSearch(){
		$this->getDayListByDate();
		$this->display('recharge_search');
	}
	
	//vip统计
	public function vip(){
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$pageSize = PAGE_SIZE;
		$offset = ($pageNo-1)*$pageSize; 
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$sql1 = 'select count(id) as num from vip_count';
    	$rs1 = $sqlite->query($sql1)->fetchAll();
    	$count = $rs1[0]['num'];
    	
    	$sql2 = 'select id,vip_score,vip_yh,vip_sum,insert_date,vip_zr,vip_zc from vip_count order by insert_date desc limit '.$offset.','.$pageSize;
    	$rs2 = $sqlite->query($sql2)->fetchAll();
		for($j=0;$j<count($rs2);$j++){
			$rs2[$j]['cha'] = $rs2[$j]['vip_sum']-$rs2[$j+1]['vip_sum'];
		}
    	
		for($i=0;$i<count($rs2);$i++){
			$rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE;
			$rs2[$i]['vip_score'] = number_format($rs2[$i]['vip_score']); 
			$rs2[$i]['vip_yh'] = number_format($rs2[$i]['vip_yh']); 
			$rs2[$i]['vip_sum'] = number_format($rs2[$i]['vip_sum']); 
			$rs2[$i]['vip_zr'] = number_format($rs2[$i]['vip_zr']); 
			$rs2[$i]['vip_zc'] = number_format($rs2[$i]['vip_zc']); 
			$rs2[$i]['cha'] = number_format($rs2[$i]['cha']);
		}
		
		
		$pageNum = ceil($count/$pageSize);
		$this->assign('pageNum',$pageNum);
    	$this->assign('rs',$rs2);
    	$this->display('vip');
    	
	}
	/*//损耗统计列表
	public function loss(){
		$this->getDayList();
		$this->display('loss');
	}
	
	//损耗统计搜索
	public function lossCountSearch(){
		$this->getDayListByDate();
		$this->display('loss_search');		
	}*/
	
	
	//获取数据 
	public function getDayList(){
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}	
		$result = $this->getCount($pageNo);
		//print_r($result);
		$pageNum = $this->getCountPageNum();
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$result);	
	}
	
	//根据日期获取数据
	public function getDayListByDate(){
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		$date1 = $_GET['start'];
		$date2 = $_GET['end'];
		$date3 = strtotime($date1);
		$date4 = strtotime($date2);
		if($date3>=$date4){
			$start = $date2.' 00:00:00';
			$end = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
		}else{
			$start = $date1.' 00:00:00';
			$end = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
		}	
		$rs = $this->getCountByDate($start,$end,$pageNo);	
		$pageNum = $this->getSearchPageNum($start,$end);
		$this->assign('start',$start);
		$this->assign('end',$end);
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$rs);
	}
	
	
	
	/*public function user_result($result){
		$conn=mssql_connect($GLOBALS['DB_PLATFORM']['DB_HOST'],$GLOBALS['DB_PLATFORM']['DB_USER'],$GLOBALS['DB_PLATFORM']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_PLATFORM']['DB_NAME']); 

		for($i=0;$i<count($result);$i++){
			$year = substr($result[$i]['CollectDate'], 6,4);
    		$month = substr($result[$i]['CollectDate'], 3,2);
    		$day = substr($result[$i]['CollectDate'], 0,2);
			$procedure = mssql_init("user_count",$conn); 
			mssql_bind($procedure,"@year", $year, SQLVARCHAR); 
			mssql_bind($procedure,"@month", $month, SQLVARCHAR); 
			mssql_bind($procedure,"@day", $day, SQLVARCHAR);
			$resource = mssql_execute($procedure);

			while($row = mssql_fetch_array($resource)){
				//var_dump($row);
				//var_dump($row['MaxCount']);
				$result[$i]['MaxCount'] = $row['MaxCount'];
				$result[$i]['AvgCount'] = $row['AvgCount'];
			}

			$result[$i]['CollectDate'] = strtotime(str_replace('/', '-',substr($result[$i]['CollectDate'], 0,10)));			
		}
		mssql_free_statement($procedure); 
		mssql_close($conn);
		return $result;
	}*/
	
	
	//根据页码数获得数据
	public function getCount($pageNo){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$offset = ($pageNo-1)*PAGE_SIZE; 
    	$sql = 'select user_gold,user_bank,android_gold,android_bank,revenue_zz,revenue_game,game_login,game_register,online_max,online_avg,ba_give_count,ba_give_sum,re_give_count,re_give_sum,recharge_count,recharge_sum,insert_date,webAli,sdg,mobileAli,dj,APP,UPMP,ky from day_count order by insert_date desc limit '.$offset.','.PAGE_SIZE;
    	$rs = $sqlite->query($sql)->fetchAll();
    	
    	for($i=(count($rs)-1);$i>=0;$i--){
    		
    		$rs[$i]['no'] = $i+1+PAGE_SIZE*($pageNo-1);
    		$rs[$i]['user_sum'] = $rs[$i]['user_gold']+$rs[$i]['user_bank'];
    		$rs[$i]['android_sum'] = $rs[$i]['android_gold']+$rs[$i]['android_bank'];
    		$rs[$i]['sum'] = $rs[$i]['user_sum']+$rs[$i]['android_sum'];
    	}	
		for($i=0;$i<count($rs);$i++){
			$date = $rs[$i]['insert_date'];
    		$rs[$i]['sum_add'] = $rs[$i]['sum']-$rs[$i+1]['sum'];
			foreach ($rs[$i] as $key=>$value){
				$rs[$i][$key] = number_format($rs[$i][$key]); 			
    		}
    		$rs[$i]['insert_date'] = $date;
    	}	 	
    	return $rs;
	}
	
	//分页的页码数
	public function getCountPageNum(){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select count(insert_date) as num from day_count';
    	$rs = $sqlite->query($sql)->fetch();
    	return ceil($rs['num']/PAGE_SIZE);
	}

	//日期搜索
	public function getCountByDate($start,$end,$pageNo){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$offset = ($pageNo-1)*PAGE_SIZE; 
    	//$sql = 'select user_gold,user_bank,android_gold,android_bank,give_gold,revenue_zz,revenue_game,revenue_room,loss_game,loss_room,game_login,game_register,online_max,online_avg,insert_date from day_count where insert_date >= CONVERT(varchar,"'.$start.'",100) and insert_date <= CONVERT(varchar,"'.$end.'",100) order by insert_date desc limit '.$offset.','.PAGE_SIZE;
    	$sql = 'select user_gold,user_bank,android_gold,android_bank,revenue_zz,revenue_game,game_login,game_register,online_max,online_avg,ba_give_count,ba_give_sum,re_give_count,re_give_sum,recharge_count,recharge_sum,insert_date from day_count where insert_date >= "'.$start.'" and insert_date < "'.$end.'" order by insert_date desc limit '.$offset.','.PAGE_SIZE;
    	
    	$rs = $sqlite->query($sql)->fetchAll();
		for($i=(count($rs)-1);$i>=0;$i--){
    		
    		$rs[$i]['no'] = $i+1+PAGE_SIZE*($pageNo-1);
    		$rs[$i]['user_sum'] = $rs[$i]['user_gold']+$rs[$i]['user_bank'];
    		$rs[$i]['android_sum'] = $rs[$i]['android_gold']+$rs[$i]['android_bank'];
    		$rs[$i]['sum'] = $rs[$i]['user_sum']+$rs[$i]['android_sum'];
    	}	
		for($i=0;$i<count($rs);$i++){
			$date = $rs[$i]['insert_date'];
    		$rs[$i]['sum_add'] = $rs[$i]['sum']-$rs[$i+1]['sum'];
			foreach ($rs[$i] as $key=>$value){
				$rs[$i][$key] = number_format($rs[$i][$key]); 			
    		}
    		$rs[$i]['insert_date'] = $date;
    	}	 	
    	return $rs;
	}
	
	//日期搜索页码数目
	public function getSearchPageNum($start,$end){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db');
    	$sql = 'select count(insert_date) as num from day_count where insert_date >= "'.$start.'" and insert_date <= "'.$end.'"';    	
    	$rs = $sqlite->query($sql)->fetch();
    	return ceil($rs['num']/PAGE_SIZE);
	}
	
	/*----------------------------------实时统计--------------------------------------------------------*/
	
	
	//实时统计-用户金币
	public function user_gold_time(){
		$date = date('Y-m-d H:i:s');
		$date_day = date('Y-m-d');
		$mssql = M();
		$sql = 'select GameLogonSuccess,GameRegisterSuccess,CONVERT(varchar,CollectDate,120) as CollectDate from QPAccountsDB.dbo.SystemStreamInfo where CollectDate> "'.$date_day.'"';
		$rs = $mssql->query($sql);		
		$this->assign('result',$rs[0]);
		$this->display('user_gold_time');
	}

	//实时统计-赠送
	public function give_time(){
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		
		$pageNum = $this->getTimePageNum();
		$result = $this->getGiveList($pageNo);	
		$this->assign('pageNum',$pageNum['give_pagenum']);
		$this->assign('result',$result);
		$this->display('give_time');
	}
	
	
	
	
	

	//实时统计-赠送,充值统计页数
	public function getTimePageNum(){
		$arr = array();
		$conn=mssql_connect($GLOBALS['DB_RECORD']['DB_HOST'],$GLOBALS['DB_RECORD']['DB_USER'],$GLOBALS['DB_RECORD']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_RECORD']['DB_NAME']); 
		$procedure = mssql_init("give_record_count",$conn); 
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				$arr['give_pagenum'] = ceil($row['give_count']/PAGE_SIZE);
				$arr['recharge_pagenum'] = ceil($row['recharge_count']/PAGE_SIZE);			
			}
		mssql_free_statement($procedure); 
		mssql_close($conn);
		return $arr;
	}
	
	//得到实时统计-赠送统计列表
	public function getGiveList($pageNo){
		$conn=mssql_connect($GLOBALS['DB_RECORD']['DB_HOST'],$GLOBALS['DB_RECORD']['DB_USER'],$GLOBALS['DB_RECORD']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_RECORD']['DB_NAME']); 
		$pageSize = 10;
		$rs = array();

		$procedure = mssql_init("give_record_list",$conn); 
		mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4); 
		mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4); 
		$resource = mssql_execute($procedure);

			while($row = mssql_fetch_array($resource)){
				$rs[] = $row;
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE;
			$rs[$i]['Reason'] = iconv("GB2312","UTF-8",$rs[$i]['Reason']);
			$rs[$i]['CurGold'] = number_format($rs[$i]['CurGold']); 
			$rs[$i]['AddGold'] = number_format($rs[$i]['AddGold']); 
		}
		//print_r($rs);
		return $rs;
	} 
	
	//赠送时间搜索
	public function giveTimeSearch(){
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}

		$date1 = $_GET['start'];
		$date2 = $_GET['end'];
		$date3 = strtotime($date1);
		$date4 = strtotime($date2);
		if($date3>=$date4){
			$start = $date2.' 00:00:00';
			$end = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
		}else{
			$start = $date1.' 00:00:00';
			$end = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
		}
		
		
		$pageNum = $this->giveTime_search_count($start, $end);
		
		$conn=mssql_connect($GLOBALS['DB_RECORD']['DB_HOST'],$GLOBALS['DB_RECORD']['DB_USER'],$GLOBALS['DB_RECORD']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_RECORD']['DB_NAME']); 
		$pageSize = 10;
		$rs = array();

		$procedure = mssql_init("give_search_list",$conn); 
		mssql_bind($procedure,"@start", $start, SQLVARCHAR);
		mssql_bind($procedure,"@end", $end, SQLVARCHAR);
		mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4); 
		mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4); 
		$resource = mssql_execute($procedure);

			while($row = mssql_fetch_array($resource)){
				$rs[] = $row;
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE;
			$rs[$i]['Reason'] = iconv("GB2312","UTF-8",$rs[$i]['Reason']);
			$rs[$i]['CurGold'] = number_format($rs[$i]['CurGold']); 
			$rs[$i]['AddGold'] = number_format($rs[$i]['AddGold']); 
		}

		$this->assign('result',$rs);
		$this->assign('pageNum',$pageNum);
		$this->assign('start',substr($start, 0,10));
		$this->assign('end',substr($end, 0,10));
		$this->display('give_time_search');
		
	}
	
	//赠送搜索结果分页数
	public function giveTime_search_count($start,$end){
		$conn=mssql_connect($GLOBALS['DB_RECORD']['DB_HOST'],$GLOBALS['DB_RECORD']['DB_USER'],$GLOBALS['DB_RECORD']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_RECORD']['DB_NAME']); 
		$pageSize = 10;
		$procedure = mssql_init("give_search_count",$conn); 
		mssql_bind($procedure,"@start", $start, SQLVARCHAR);
		mssql_bind($procedure,"@end", $end, SQLVARCHAR);
		$resource = mssql_execute($procedure);
			while($row = mssql_fetch_array($resource)){
				$count = $row['count'];
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn);
		return ceil($count/$pageSize);
	}
	
	//实时统计-充值
	public function recharge_time(){
		if($_GET['pageNo']){
			$pageNo = $_GET['pageNo'];
		}else{
			$pageNo = 1;
		}
		if($_GET['type']){
			$type=$_GET['type'];
		}else{
			$type=1;
		}
		$mssql=M();
		if($type==1){
			$sql='select count(*) as num from QPTreasureDB.dbo.ShareDetailInfo';
		}else{
			$sql='select count(*) as num from QPTreasureDB.dbo.ShareDetailInfo where ShareID in (14,15,17,18)';
		}		
		$rs=$mssql->query($sql);
		$pageSize=PAGE_SIZE;
		$pageNum = ceil($rs[0]['num']/$pageSize);
		$result = $this->getRechargeList($pageNo,$type);	
		$this->assign('pageNum',$pageNum);
		$this->assign('result',$result);
		$this->assign('type',$type);
		$this->display('recharge_time');
	}
	
	//得到实时统计-充值统计列表
	public function getRechargeList($pageNo,$type){		
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
		$pageSize = 10;
		$rs = array();

		$procedure = mssql_init("recharge_record_list",$conn); 
		mssql_bind($procedure,"@type", $type, SQLINT4); 
		mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4); 
		mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4); 
		$resource = mssql_execute($procedure);

			while($row = mssql_fetch_array($resource)){
				$rs[] = $row;
			}		
		mssql_free_statement($procedure); 
		mssql_close($conn);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE;
			$rs[$i]['Accounts'] = iconv("GB2312","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['CardGold'] = number_format($rs[$i]['CardGold']); 
			$rs[$i]['BeforeGold'] = number_format($rs[$i]['BeforeGold']); 
		}
		return $rs;
	}
	
	//数据导出
	public function export(){
		$this->display('export');
	}
	
    //excel导出
    public function excel(){
    	$date1 = $_GET['start'];
		$date2 = $_GET['end'];
		$date3 = strtotime($date1);
		$date4 = strtotime($date2);
		if($date3>=$date4){
			$start = $date2.' 00:00:00';
			$end = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
		}else{
			$start = $date1.' 00:00:00';
			$end = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
		}
		$date = date('Y-m-d');
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select insert_date,user_gold,user_bank,android_gold,android_bank,revenue_zz,revenue_game,game_login,game_register,online_max,online_avg,ba_give_count,ba_give_sum,re_give_count,re_give_sum,recharge_count,recharge_sum from day_count where insert_date >= "'.$start.'" and insert_date < "'.$end.'" order by insert_date asc';
    	$rs = $sqlite->query($sql)->fetchAll();
    	$title = array('时间','用户金币','用户银行','机器人金币','机器人银行','转账税收','游戏税收','游戏登陆人数','游戏注册人数','最大在线人数','平均在线人数','后台赠送次数','后台赠送总额','注册赠送次数','注册赠送总额','充值次数','充值总额');
		$filename = $date.'统计';
		$this->exportexcel($rs,$title,$filename);
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
            	$title[$k]=iconv("UTF-8", "GB2312",$v);
         	}
         	$title= implode("\t", $title);
         	echo "$title\n";
     	}
     	if (!empty($data)){
        	 foreach($data as $key=>$val){
            	 foreach ($val as $ck => $cv) {
                 	$data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
             	}
            	 $data[$key]=implode("\t", $data[$key]);
             
         	}
        	 echo implode("\n",$data);
     	}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}