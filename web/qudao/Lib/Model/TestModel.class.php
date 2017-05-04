<?php
class TestModel extends Model{
	
	//protected $connection = 'DB_CONFIG1';
	
	
	protected $tableName = "AccountsInfo";
	
	public function aa(){
		$sql = 'call proc_get_student()';
		$rs = $this->query($sql);
		var_dump($rs);
		return $rs;
	}
}