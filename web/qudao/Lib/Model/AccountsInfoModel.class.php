<?php
class AccountsInfoModel extends Model{
	
	protected $tableName = "AccountsInfo";
	
	public function getSqlite($pageNo){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$offset = ($pageNo-1)*PAGE_SIZE;  	
    	$sql = 'select id,username,area,num,type,start_num,end_num,start_id,end_id,update_time from user limit '.$offset.','.PAGE_SIZE;
    	return $sqlite->query($sql)->fetchAll();

	}
	
	public function getSqliteByID($id){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select id,username,area,num,type,start_num,end_num,start_id,end_id,update_time from user where id ='.$id;
    	return $sqlite->query($sql)->fetchAll();
	}
	
	public function getIndexList($pageNo){
    	$rs = $this->getSqlite($pageNo);		
    	for($i=0;$i<count($rs);$i++){
    		$start = $rs[$i]['start_id'];
    		$end = $rs[$i]['end_id'];
    		$count = $this->query('select count(UserID) as num from AccountsInfo where GameLogonTimes > 0 and UserID >= '.$start.' and UserID < '.$end);
    		$rs[$i]['count'] = $count[0]['num'];
    		$rs[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE;
    	}	
    	return $rs;

	}
	
	public function getUserList($id){	
    	$rs = $this->getSqliteByID($id);
    	$start = $rs[0]['start_id'];
    	$end = $rs[0]['end_id'];
    	$result = $this->query('select UserID,GameID,NickName,Accounts,Gender,Experience,LastLogonDate,LastLogonIP,GameLogonTimes,OnLineTimeCount,PlayTimeCount from AccountsInfo where UserID >='.$start.' and UserID <='.$end);
    	//$result = $this->query('select a.UserID,a.GameID,a.NickName,a.Accounts,a.Gender,a.Experience,a.LastLogonDate,a.LastLogonIP,a.GameLogonTimes,a.OnLineTimeCount,a.PlayTimeCount,b.Score from AccountsInfo as a left join QPTreasureDB.GameScoreInfo as b on a.UserID = b.UserID where UserID >='.$start.' and UserID <='.$end);
    	return $result;
	}
	
	public function getUserIDs($id){
		$rs = $this->getSqliteByID($id);
		$result[0] = $rs[0]['start_id'];
		$result[1] = $rs[0]['end_id'];
		return $result;
	}
	
	public function getUserByName($name){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select id,username,area,num,type,start_num,end_num,start_id,end_id,update_time from user where username = "'.$name.'"';
    	$rs = $sqlite->query($sql)->fetchAll();
    	if(count($rs) == 0){
    		$rs['con'] = 'kong';
    	}else{
    		$start = $rs[0]['start_id'];
    		$end = $rs[0]['end_id'];
    		$count = $this->query('select count(UserID) as num from AccountsInfo where GameLogonTimes > 1 and UserID >= '.$start.' and UserID <= '.$end);
    		$rs[0]['count'] = $count[0]['num'];
    	}  	
    	return $rs;
	}
	
	public function getUserByNum($start_num,$end_num){
		$start = (int)substr($start_num, 2)+10000; 
    	$end = (int)substr($end_num, 2)+10000;
    	if($start >= $end){
    		$start_id = $end;
    		$end_id = $start;
    	}else{
    		$start_id = $start;
    		$end_id = $end;
    	}
    	$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select id,username,area,num,type,start_num,end_num,start_id,end_id,update_time from user where (start_id >= '.$start_id.' and start_id <= '.$end_id.') or (end_id >= '.$start_id.' and end_id <= '.$end_id.')';
    	//$sql = 'select id,username,area,num,type,start_num,end_num,start_id,end_id,update_time from user where (start_id >= 10000 and start_id <= 12000) or (end_id >= 10000 and end_id <= 12000)';
    	$rs = $sqlite->query($sql)->fetchAll();
    	if(count($rs) == 0){
    		$rs['con'] = 'kong';
    	}else{
    		for($i=0;$i<count($rs);$i++){
    			$start = $rs[$i]['start_id'];
    			$end = $rs[$i]['end_id'];
    			$count = $this->query('select count(UserID) as num from AccountsInfo where GameLogonTimes > 1 and UserID >= '.$start.' and UserID <= '.$end);
    			$rs[$i]['count'] = $count[0]['num'];
    		}
    	}  	
    	return $rs;
	}
	
	public function getUserPageNum(){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select count(id) as num from user';
    	$rs = $sqlite->query($sql)->fetch();
    	$pageNum = ceil($rs['num']/PAGE_SIZE);
		return $pageNum;
	}
	/*public function checkUser($username,$password){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select count(id) as num where username = '.$name.' and password = '.$password;
    	$rs = $sqlite->query($sql)->fetch();
    	return $rs['num'];
	}*/
	
	
}






