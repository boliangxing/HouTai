<?php
function _location($msg,$url){
   	echo "<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />";
   	echo "<script>alert('{$msg}');location.href='{$url}'</script>";
   	exit;
}
function _href($url){
   	echo "<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />";
   	echo "<script>location.href='{$url}'</script>";
   	exit;
}
function _back($msg){
   	echo "<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />";
   	echo "<script>alert('{$msg}');history.go(-1)</script>";
   	exit;
}
function _diffDays ($day1, $day2)
{
  $second1 = strtotime($day1);
  $second2 = strtotime($day2);
    
  if ($second1 < $second2) {
    $tmp = $second2;
    $second2 = $second1;
    $second1 = $tmp;
  }
  return ceil(($second1 - $second2) / 86400);
}

function _open($db){
  switch ($db) {
    case 1:
      $conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']); 
    mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']); 
      break;
    case 2:
      $conn=mssql_connect($GLOBALS['DB_RECORD_9']['DB_HOST'],$GLOBALS['DB_RECORD_9']['DB_USER'],$GLOBALS['DB_RECORD_9']['DB_PWD']); 
    mssql_select_db($GLOBALS['DB_RECORD_9']['DB_NAME']); 
      break;
    case 3:
      $conn=mssql_connect($GLOBALS['DB_RECORD_11']['DB_HOST'],$GLOBALS['DB_RECORD_11']['DB_USER'],$GLOBALS['DB_RECORD_11']['DB_PWD']); 
    mssql_select_db($GLOBALS['DB_RECORD_11']['DB_NAME']); 
      break;
    case 4:
      $conn=mssql_connect($GLOBALS['DB_RECORD_12']['DB_HOST'],$GLOBALS['DB_RECORD_12']['DB_USER'],$GLOBALS['DB_RECORD_12']['DB_PWD']); 
    mssql_select_db($GLOBALS['DB_RECORD_12']['DB_NAME']); 
      break;
	  case 5:
      $conn=mssql_connect($GLOBALS['DB_RECORD_13']['DB_HOST'],$GLOBALS['DB_RECORD_13']['DB_USER'],$GLOBALS['DB_RECORD_13']['DB_PWD']); 
    mssql_select_db($GLOBALS['DB_RECORD_13']['DB_NAME']); 
      break;
	  case 6:
      $conn=mssql_connect($GLOBALS['DB_RECORD_16']['DB_HOST'],$GLOBALS['DB_RECORD_16']['DB_USER'],$GLOBALS['DB_RECORD_16']['DB_PWD']); 
    mssql_select_db($GLOBALS['DB_RECORD_16']['DB_NAME']); 
      break;
  }
  return $conn;

}

function _checkword($arr,$str){
	foreach ($arr as $value){
		$check=strstr($str, $value); //搜索一个字符串在另一个字符串中的第一次出现
		if($check==true || !empty($check)){
			return false;
		}
	}
	return $str;
}
function writeslog($log){ 
    $log_path = 'rz/'.date('Y-m-d',time()).'-sql_log.txt';  
    $ts = fopen($log_path,"a+");  
    fputs($ts,date('Y-m-d H:i:s',time()).'  '.$log."\r\n");  
    fclose($ts);  
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
	
	function GetIP(){
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  			$cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
  			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif(!empty($_SERVER["REMOTE_ADDR"])){
  			$cip = $_SERVER["REMOTE_ADDR"];
		}
		else{
  			$cip = "无法获取！";
		}
		return $cip;
	}