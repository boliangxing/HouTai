<?php
if (!class_exists('db_sqlite')){     require_once(ROOT_PATH . '/Db/pdo/sqlite.class.php'); }
class CountAction extends Action {
	public function index(){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite(ROOT_PATH.'/Db/hs.db'); 
    	$sql = 'select UserID from vip_member';
    	$rs = $sqlite->query($sql)->fetchAll();
    	$ids = $rs[0]['UserID'];
		$count = count($rs);
		for($i=1;$i<$count;$i++){
    		$ids = $ids.','.$rs[$i]['UserID'];
    	}
    	$mssql = M();
		$sql2 = 'select SUM(Score) as Score,SUM(InsureScore) as InsureScore,SUM(Score+InsureScore) as gold_sum from QPTreasureDB.dbo.GameScoreInfo(NOLOCK) where UserID in ('.$ids.') ';
		$result = $mssql->query($sql2);
		$arr = array('vip_score' => $result[0]['Score'],'vip_yh' => $result[0]['InsureScore'],'vip_sum' => $result[0]['gold_sum']);
    	$sqlite->insert('vip_count', $arr);
	}
}