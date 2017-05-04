<?php
header("Content-type:text/html;charset=utf-8");
require_once('Db/Db_config.php'); 
require_once('Db/IP/IpLocation.php');//加载类文件IpLocation.php  
$ipfile = 'D:/phpStudy/WWW/Db/IP/qqwry.dat';      //获取ip对应地区的信息文件 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d H:i:s');
	$sql='select EnterIP as LastLogonIP from QPTreasureDB.dbo.GameScoreLocker(nolock)';
	$rs = mssql_query($sql,$conn);
	//$result = mssql_fetch_assoc($rs);
	while($row = mssql_fetch_assoc($rs)){
		$result[] = $row;
	}
	$dx=0;
	$lt=0;
	$yd=0;
	$kd=0;
	$bl=0;
	$qt=0;

	for($i=0;$i<count($result);$i++){
		$result[$i]['Logon_city'] = getIpPlace($result[$i]['LastLogonIP'],$ipfile);
			$area=$result[$i]['Logon_city']['area'];
			if($area=='电信'){
				$dx=$dx+1;
			}elseif($area=='联通'){
				$lt=$lt+1;
			}elseif($area=='移动'){
				$yd=$yd+1;
			}elseif($area=='保留地址'){
				$bl=$bl+1;
			}elseif($area=='鹏博士长城宽带'){
				$kd=$kd+1;
			}else{
//echo $area.'</br>';
				$qt=$qt+1;
			}
	}

	$sql2 = 'Insert into QPWebBackDB.dbo.OnlineType(dx,lt,yd,kd,bl,qt,InsertDate) values('.$dx.','.$lt.','.$yd.','.$kd.','.$bl.','.$qt.',"'.$InsertDate.'")';
echo $sql2;	
mssql_query($sql2,$conn);


function getIpPlace($ip,$ipfile){  		 	 
    $iplocation = new IpLocation($ipfile);  //new IpLocation($ipfile) $ipfile ip对应地区信息文件  
    $ipresult = $iplocation->getlocation($ip); //根据ip地址获得地区 getlocation("ip地区")  
    return $ipresult;  
} 
