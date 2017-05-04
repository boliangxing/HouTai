<?php 
require_once '../Db_config.php';

$return = array();

if(!$_POST['UserID'] || !$_POST['Random'] || !$_POST['Date'] || !$_POST['Sign']){
	$return['error'] = '1';
	$return['error_msg'] = '参数缺失';
	//print_r($return);
	echo json_encode($return);
	return false;
}

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

	$return['error'] = '0';
	$return['error_msg'] = '';
	
	$rs=array();
	$sql='select ID,Name,AddGold,Describe,Probability from QPAccountsDB.dbo.AwardList where Type=1';
	$result = mssql_query($sql,$conn);
		while($row=mssql_fetch_assoc($result)){
			$rs[]=$row;
		}
	for($i=0;$i<count($rs);$i++){
		$rs[$i]['Name'] = iconv("GB2312","UTF-8",$rs[$i]['Name']);
		$rs[$i]['Describe'] = iconv("GB2312","UTF-8",$rs[$i]['Describe']);
		if($rs[$i]['ID']>5 && $rs[$i]['ID']<9){
			$rs[$i]['Notice']='恭喜你在幸运大转盘中获得'.$rs[$i]['Name'].',奖品为'.$rs[$i]['Describe'];
		}
		elseif($rs[$i]['ID']>3 && $rs[$i]['ID']<6){
			$rs[$i]['Notice']='恭喜你在幸运大转盘中获得'.$rs[$i]['Name'].',奖品为'.$rs[$i]['Describe'].',请与客服联系领取奖品。客服QQ：2191544985';
		}
		else{
			$rs[$i]['Notice']='';
		}
	}
	//game188
	//game188.COM88
	
	$prize_arr = array( 
    '0' => array('id'=>$rs[0]['ID'],'min'=>140,'max'=>175,'prize'=>$rs[0]['Notice'],'v'=>$rs[0]['Probability']), 
	'1' => array('id'=>$rs[1]['ID'],'min'=>5,'max'=>40,'prize'=>$rs[1]['Notice'],'v'=>$rs[1]['Probability']),
	'2' => array('id'=>$rs[2]['ID'],'min'=>230,'max'=>265,'prize'=>$rs[2]['Notice'],'v'=>$rs[2]['Probability']),
	'3' => array('id'=>$rs[3]['ID'],'min'=>320,'max'=>355,'prize'=>$rs[3]['Notice'],'v'=>$rs[3]['Probability']),
	'4' => array('id'=>$rs[4]['ID'],'min'=>95,'max'=>130,'prize'=>$rs[4]['Notice'],'v'=>$rs[4]['Probability']),
	'5' => array('id'=>$rs[5]['ID'],'min'=>50,'max'=>85,'prize'=>$rs[5]['Notice'],'v'=>$rs[5]['Probability']),
	'6' => array('id'=>$rs[6]['ID'],'min'=>275,'max'=>310,'prize'=>$rs[6]['Notice'],'v'=>$rs[6]['Probability']),
	'7' => array('id'=>$rs[7]['ID'],'min'=>185,'max'=>220,'prize'=>$rs[7]['Notice'],'v'=>$rs[7]['Probability'])
	); 	
	/*
	$prize_arr = array( 
    '0' => array('id'=>$rs[0]['ID'],'min'=>182,'max'=>223,'prize'=>$rs[0]['Notice'],'v'=>$rs[0]['Probability']), 
	'1' => array('id'=>$rs[1]['ID'],'min'=>317,'max'=>358,'prize'=>$rs[1]['Notice'],'v'=>$rs[1]['Probability']),
	'2' => array('id'=>$rs[2]['ID'],'min'=>92,'max'=>133,'prize'=>$rs[2]['Notice'],'v'=>$rs[2]['Probability']),
	'3' => array('id'=>$rs[3]['ID'],'min'=>2,'max'=>43,'prize'=>$rs[3]['Notice'],'v'=>$rs[3]['Probability']),
	'4' => array('id'=>$rs[4]['ID'],'min'=>227,'max'=>268,'prize'=>$rs[4]['Notice'],'v'=>$rs[4]['Probability']),
	'5' => array('id'=>$rs[5]['ID'],'min'=>272,'max'=>313,'prize'=>$rs[5]['Notice'],'v'=>$rs[5]['Probability']),
	'6' => array('id'=>$rs[6]['ID'],'min'=>47,'max'=>88,'prize'=>$rs[6]['Notice'],'v'=>$rs[6]['Probability']),
	'7' => array('id'=>$rs[7]['ID'],'min'=>137,'max'=>178,'prize'=>$rs[7]['Notice'],'v'=>$rs[7]['Probability'])
	); 	
	*/
	
	foreach ($prize_arr as $key => $val) { 
    	$arr[$val['id']] = $val['v']; 
	} 
	$rid = getRand($arr); //根据概率获取奖项id 
 
	$res = $prize_arr[$rid-1]; //中奖项 
	$AwardID = $res['id'];
	$min = $res['min']; 
	$max = $res['max']; 
    $return['angle'] = mt_rand($min,$max); //随机生成一个角度 
	$return['prize'] = $res['prize']; 
	$procedure = mssql_init("PHP_IF_InsertUserAwardInfo",$conn); 
	mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
	mssql_bind($procedure,"@dwUserID",$UserID,SQLINT4); 
	mssql_bind($procedure,"@iAwardID",$AwardID,SQLINT4);
	mssql_bind($procedure,"@strErrorDescribe",$error_msg,SQLVARCHAR,true);

	$resource = mssql_execute($procedure);
	if(!$resource){
		$return['error'] = '3';
		$return['error_msg'] = '执行错误';
		echo json_encode($return);
		mssql_free_statement($procedure); 
		mssql_close($conn);
		return;
	}
	//------------执行成功返回success-------------//
	$error_msg = iconv('gb2312', 'utf-8', $error_msg);
	//获取存储过程返回错误信息
	//mssql_next_result($resource);
	$return['error'] = $ret;
	$return['error_msg'] = $error_msg;
	echo json_encode($return);
	mssql_free_statement($procedure); 
	mssql_close($conn);

}

function getRand($proArr) { 
    $result = ''; 
 
    //概率数组的总概率精度 
    $proSum = array_sum($proArr); 
 
    //概率数组循环 
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 
    } 
    unset ($proArr); 
 
    return $result; 
} 


