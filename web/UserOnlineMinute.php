<?php
require_once('Db/Db_config.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date('Y-m-d H:i:s');
	$sql='select t1.UserID,t2.CustomID,t2.LockMobileKindID,t2.MemberOrder from QPTreasureDB.dbo.GameScoreLocker(nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID';
	$rs = mssql_query($sql,$conn);
	//$result = mssql_fetch_assoc($rs);
	while($row = mssql_fetch_assoc($rs)){
		$result[] = $row;
	}
	$fufei=0;
	$mianfei=0;
	$VIP=0;
	$IOS=0;
	$Android=0;
	$PC=0;
	$FF_IOS=0;
	$FF_and=0;
	$FF_pc=0;
	$MF_IOS=0;
	$MF_and=0;
	$MF_pc=0;

	for($i=0;$i<count($result);$i++){
	if($result[$i]['MemberOrder']==0){
		if($result[$i]['CustomID']>0){
			$fufei=$fufei+1;
		}
		if($result[$i]['CustomID']==0){
			$mianfei=$mianfei+1;
		}
		if($result[$i]['LockMobileKindID']==1){
			$IOS=$IOS+1;
		}
		if($result[$i]['LockMobileKindID']==2){
			$Android=$Android+1;
		}
		if($result[$i]['LockMobileKindID']==0 || $result[$i]['LockMobileKindID']==3){
			$PC=$PC+1;
		}
		if($result[$i]['CustomID']>0 && $result[$i]['LockMobileKindID']==1){
			$FF_IOS=$FF_IOS+1;
		}
		if($result[$i]['CustomID']>0 && $result[$i]['LockMobileKindID']==2){
			$FF_and=$FF_and+1;
		}
		if($result[$i]['CustomID']>0 && ($result[$i]['LockMobileKindID']==0 || $result[$i]['LockMobileKindID']==3 || $result[$i]['LockMobileKindID']=='')){
			$FF_pc=$FF_pc+1;
		}
	}else{
		$VIP=$VIP+1;
	}	
		
	}
	$zong=count($result);
	$MF_IOS=$IOS-$FF_IOS;
	$MF_and=$Android-$FF_and;
	$MF_pc=$PC-$FF_pc;

	$sql2 = 'Insert into QPRecordDB.dbo.RecordOnline(InsertDate,zong,Fufei,Mianfei,VIP,IOS,Android,PC,FF_IOS,FF_and,FF_pc,MF_IOS,MF_and,MF_pc) values("'.$InsertDate.'",'.$zong.','.$fufei.','.$mianfei.','.$VIP.','.$IOS.','.$Android.','.$PC.','.$FF_IOS.','.$FF_and.','.$FF_pc.','.$MF_IOS.','.$MF_and.','.$MF_pc.')';
echo $sql2;	
mssql_query($sql2,$conn);
