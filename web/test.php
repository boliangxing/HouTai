<?php
$GLOBALS['DB_RECORD_16'] = array(
	'DB_HOST'=>'117.25.148.33,11433',
	'DB_USER'=>'iid33siN!',
	'DB_PWD'=>'HiJoKpL!@#qwe',
	'DB_NAME'=>'QPWebBackDB'
);
$conn=mssql_connect($GLOBALS['DB_RECORD_16']['DB_HOST'],$GLOBALS['DB_RECORD_16']['DB_USER'],$GLOBALS['DB_RECORD_16']['DB_PWD'])
or die("Couldn't connect to SQL Server on"); 
 mssql_select_db($GLOBALS['DB_RECORD_16']['DB_NAME']); 
var_dump($conn);
$sql = 'select * from QPWebBackDB.dbo.ChargeCount';
$rs = mssql_query($sql,$conn);
$result = mssql_fetch_assoc($rs);
echo $result['wx'];
exit;
//$a = 'http://www.game528.com';
//$a = '{"version":"1.0.0","charset":"UTF-8","transType":"01","merId":"880000000000433","backEndUrl":"http:\/\/www.game528.com:91\/UPMP\/upmp_pay.php","frontEndUrl":"http:\/\/www.game528.com","orderDescription":"\u4e00\u6b21\u6027\u83b7\u53d6\u6b22\u4e50\u8c4611\u4e07","orderTime":"20130829142916","orderTimeout":"20130830142916","orderNumber":"UPMPOY7MJXRWPIU","orderAmount":800,"orderCurrency":"156","reqReserved":"","merReserved":""}';
//echo md5('blbl0lKFCTKwsPvN5OnDKLiHFK7CoL0w');
//exit;
//echo urlencode($a);
//exit;
//print_r(json_decode($a));
//exit;
//$a = 'backEndUrl=http%3A%2F%2Fwww.game528.com%3A91%2FUPMP%2Fupmp_pay.php&charset=UTF-8&frontEndUrl=http://www.game528.com&merId=880000000000433&orderAmount=800&orderCurrency=156&orderDescription=一次性获取欢乐豆11万&orderNumber=UPMPOY7MJXRWPIU&orderTime=20130829142916&orderTimeout=20130830142916&transType=01&version=1.0.0&fda8166873e6f8e270fa653379215cd8';
//$b = 'charset=UTF-8&merId=880000000000433&orderNumber=UPMPOY7MJXRWPIU&orderTime=20130829142916&transType=01&version=1.0.0&fda8166873e6f8e270fa653379215cd8';
//echo strtolower(md5('313332013-12-08-13-40-0967073bde1c26e7')).'</br>';
//echo strtotime(date('Y-m-d H:i:s'));
//echo strtotime(date('Y-m-d H:i:s'));
//exit;
//echo md5('Error_Code=1a123456789b123456789c123456789d1');
//exit;
//echo strtotime(date('Y-m-d H:i:s'));
//exit;
/*$a = 123;
$b= 234;
echo $a>$b ? $a : $b;
exit;
$GLOBALS['DB_NEW'] = array(
	'DB_HOST'=>'192.168.0.31',
	'DB_USER'=>'sa',
	'DB_PWD'=>'c123456',
	'DB_NAME'=>'QPAccountsDB'
);
$conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']); 
mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']); 
//mssql_query('SET NAMES UTF-8',$conn);
$sql = 'select * from QPAccountsDB.dbo.AccountsInfo where GameID=100158';
$rs = mssql_query($sql,$conn);
$result = mssql_fetch_assoc($rs);
echo $result['NickName'];
setlocale(LC_ALL,'zh_CN.UTF-8'); 
$aa =iconv('GB2312','UTF-8//IGNORE',$result['NickName']);
//$aa = iconv('gb2312', 'utf-8', $result['NickName']);
var_dump($aa);


exit;
$str2 = '123456789abcdefghijklmnopqrstuvwxyz';
$count = strlen($str2);

for($j=0;$j<100000;$j++){
	$str1 = '';
	for($i=0;$i<128;$i++){
		$str = $str2{rand(0, $count-1)};
    	$str1 = $str1.$str;    		
	}
	$ValidateCode = $str1{6}.$str1{52}.$str1{87}.$str1{121};

	$sql = 'INSERT INTO ValidateCode (ValidateCode,ValidateStr) values("'.$ValidateCode.'","'.$str1.'")';
	mssql_query($sql,$conn);
}
	*/
