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
	$rs=array();
	$sql='SELECT A.ItemID, A.ItemCount, A.ItemValue,B.Name FROM QPTreasureDB.dbo.GamePackage(NOLOCK) A,QPTreasureDB.dbo.GameProperty B WHERE A.ItemID=B.ID and A.UserID='.$UserID.' AND A.Nullity=0 and A.ItemID in (28,29,30)'; 
	$result = mssql_query($sql,$conn);
    while($row = mssql_fetch_assoc($result)){
		$rs[] = $row;		
	}
	if($rs==null){
    	$rs=array();
    }else{
    	for($i=0;$i<count($rs);$i++){
    		$rs[$i]['Name'] = iconv("GB2312","UTF-8",$rs[$i]['Name']); 	
    		$rs[$i]['Image']='http://hsimg.b0.upaiyun.com/images/Property'.$rs[$i]['ItemID'].'.png';
    	}
    }
    $return['error'] = '0';
	$return['error_msg'] = '';
	$return['data'] = $rs;
    echo json_encode($return);   
}




