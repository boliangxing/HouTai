<?php
error_reporting(0);
//if (!class_exists('db_sqlite')){     require_once(ROOT_PATH . '/Db/pdo/sqlite.class.php'); }
require_once('sqlite.class.php');
$sqlite = new db_sqlite();
$sqlite->sqlite('test.db');

    $Mac='ffeec0821b6ed6def6c34b799ff9d83a7f891116';
    $date_now=date('Y-m-d');
    $sql = "select ID,Mac,Count,InsertDate from pay where Mac='{$Mac}' and InsertDate='{$date_now}'";
    $rs=$sqlite->query($sql)->fetchAll();
    if($rs[0]['ID']>0){
      if($rs[0]['Count']>=3){
        $arr_out_pay= array('GameID' => 778804,'OrderID'=>'qqqqq11111','Price'=>6,'InsertDate'=>date('Y-m-d H:i:s'));
        $sqlite->insert('out_pay', $arr_out_pay);
        //writeslog('f8'.json_encode($arr_out_pay).'/n');
        //header('HTTP/1.1 403 Forbidden');
        echo "fail1";
        return;
      }else{
        $count=$rs[0]['Count']+1;
        $condition = array('ID'=>$rs[0]['ID']);
        $arr_update = array('Count'=>$count);
        $sqlite->update('pay', $arr_update, $condition);
        echo "fail2";
        return;
      }
    }else{
      $arr_insert = array('Mac' => $Mac,'Count'=>1,'InsertDate'=>$date_now);
    	$sqlite->insert('pay', $arr_insert);
      echo "fail3";
      return;
    }