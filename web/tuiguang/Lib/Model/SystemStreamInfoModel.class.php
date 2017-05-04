<?php
class SystemStreamInfoModel extends Model{
	
	protected $tableName = "SystemStreamInfo";
	
	public function getUserCountList(){
		$rs = $this->limit(10)->select();
		return $rs;
		
	}

	public function getUserNum(){
		$rs = $this->limit(10)->select();
		var_dump($rs);
		exit;
		
	}
	
	public function getUserCountListByDate($start,$end){
		return $this->where('CollectDate between CONVERT(varchar,"'.$start.'",100) and CONVERT(varchar,"'.$end.'",100)')->limit(10)->select();
		
	}
	public function aa(){
		
		$sql = 'select * from QPTreasureDB.AndroidManager';

		$a = $this->query($sql);
		var_dump($a);
	}
}