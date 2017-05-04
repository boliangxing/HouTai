<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign'] || !$_POST['Type']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}
$Type=$_POST['Type'];//1是每日 2是新手 3是游客
$UserID=$_POST['UserID'];
$Random=$_POST['Random'];//随机数
$Date=$_POST['Date'];//时间戳
$Sign=strtolower($_POST['Sign']);//签名

//$MySign = md5(userid+时间戳+随机数+密码+密钥)

$MySign = md5($UserID.$Date.$Random.$Key);
//echo $MySign;
//exit;
if($Sign != $MySign){
	$return['error'] = '1';
	$return['error_msg'] = '验签出错';
	//print_r($return);
	echo json_encode($return);
	return false;
}else{
	$Status=2;
	
	$procedure = mssql_init("PHP_IF_GetUserTaskList",$conn); 	
	mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4); 
	mssql_bind($procedure,"@TaskType",$Type,SQLINT4);
	mssql_bind($procedure,"@Status",$Status,SQLINT4);
	mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);
	$resource = mssql_execute($procedure);
	while ($row=mssql_fetch_assoc($resource)) {  
		//print_r($row);
		$return['data'][] = $row;
		//$return['data'][]['TaskName'] = iconv("GB2312","UTF-8",$row['TaskName']);
		//$return['data'][]['img']='http://hsimg.b0.upaiyun.com/images/task'.$row['Type'].'.png';
	}
	if($return['data']){
		$num=0;
		foreach($return['data'] as $key => $val){
			if($return['data'][$key]['TaskID']==10){
				$GameTimes = $return['data'][$key]['Times'];
			}  
			if($return['data'][$key]['TaskID']==20){
				$WinTimes = $return['data'][$key]['Times'];
			}
		} 
		for($i=0;$i<count($return['data']);$i++){
			$return['data'][$i]['TaskName'] = iconv("GB2312","UTF-8",$return['data'][$i]['TaskName']);
			$return['data'][$i]['img']='http://hsimg.b0.upaiyun.com/images/task'.$return['data'][$i]['Type'].'.png';		
			if($return['data'][$i]['TaskID']>10 && $return['data'][$i]['TaskID']<20){
				$return['data'][$i]['Times'] = $GameTimes;
			}			
			if($return['data'][$i]['TaskID']>20 && $return['data'][$i]['TaskID']<30){
				$return['data'][$i]['Times'] = $WinTimes;
			}
			if($return['data'][$i]['IsGet']==2){
				$num++;
			}
		}
	}
	$return['error'] = 0;
	$return['error_msg'] = '';
	$return['num'] = $num;
	echo json_encode($return);
	mssql_free_statement($procedure); 
	mssql_close($conn);	
}




