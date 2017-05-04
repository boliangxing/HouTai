<?php
require_once("dxpay_config.php");

    //echo decryptStrin('28ee1fb779a38f8537db39be4605cb8211a342bbfda34cc808d8e1d7f34c48abe585cdea714e5ebdc078968a22ed3d8a752cbc95e613a602e8b002a28c1b216f84496f4b37b05ea5fa38d492d4d0e43e93df74a0cc399908e28064d3f93e58f8');

	$businessId="13675852139";
	$key="83WXAqUG57bQcPq8Ev45mhv18392g6qE";
	$returnCode = $_GET["returnCode"];//返回码
	$rechargeId = $_GET["rechargeId"];//充值的订单号
	$rechargeMoney = $_GET["rechargeMoney"];//充值金额
	$rechargeType = $_GET["rechargeType"];//充值类型
	$userId = $_GET["userId"];//用户ID
	$orderStatus = $_GET["orderStatus"];//支付成功标志
	$payId = $_GET["payId"];//支付点ID
	$payMoney = $_GET["payMoney"];//对应的游戏货币数量
	$time = $_GET["time"];//时间
	$payKey = $_GET["payKey"];//MD5校验串
	$versionId = $_GET["versionId"];//版本号
	
	$GameID = $_GET["sy_game_id"];//GameID
	$IPAddress = $_GET['IPAddress'];	
	$ApplyDate = date('Y-m-d H:i:s');
	$PayAmount = number_format($rechargeMoney/100,2);
	
		
	
	$sql1 = 'select UserID,GameID,Accounts from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID = '.$GameID;
   	$result1 = mssql_query($sql1,$conn);
   	if($row1 = mssql_fetch_assoc($result1)){
		$rs1 = $row1;		
	}else{
		$rs1 =0;
	}	
	if($rs1==0){
		echo "FAIL";
    	return;
    }else{
    	$UserID = $rs1['UserID'];
    	$GameID = $rs1['GameID'];
   		$Accounts = $rs1['Accounts'];
    }
		
	$md5str = "businessId=".$businessId."&returnCode=".$returnCode
				 . "&rechargeId=".$rechargeId."&rechargeMoney=".$rechargeMoney
				 . "&rechargeType=".$rechargeType."&userId=".$userId
				 . "&orderStatus=".$orderStatus."&payId=".$payId
				 . "&payMoney=".$payMoney."&time=".$time
				 . "&versionId=".$versionId."&".$key;
	$myKey = Md5($md5str);
	
	$OrderID = 'Tom'.$rechargeId;    
	$sql2 = 'select count(OnLineID) as num from OnLineOrder where OrderID="'.$OrderID.'"';
	$result2 = mssql_query($sql2,$conn);
	if($row2 = mssql_fetch_assoc($result2)){
		$rs2 = $row2;		
	}

	if($rs2['num']==0){
		$sql = 'insert into OnLineOrder (OperUserID,ShareID,UserID,GameID,Accounts,OrderID,CardTypeID,CardPrice,CardGold,CardTotal,OrderAmount,DiscountScale,PayAmount,OrderStatus,IPAddress,ApplyDate) values(0,19,'.$UserID.','.$GameID.',"'.$Accounts.'","'.$OrderID.'",0,'.$PayAmount.','.$payMoney.',1,'.$PayAmount.',0,'.$PayAmount.',0,"'.$IPAddress.'","'.$ApplyDate.'")';
   		//$sql.= 'values(1,13,'.$UserID.','.$GameID.',"'.$Accounts.'","'.$OrderID.'",'.$CardTypeID.','.$PayAmount.','.$CardGold.',1,'.$PayAmount.',0,'.$PayAmount.',0,"'.$IPAddress.'","'.$ApplyDate.'")';
    	mssql_query($sql,$conn);
	}
	
	if( $myKey == $payKey ){
				
		if($orderStatus==1){
			$procedure = mssql_init("php_tom_pay",$conn); 
			mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
			mssql_bind($procedure,"@strOrdersID", $OrderID, SQLVARCHAR); 
			mssql_bind($procedure,"@strOrderAmount", $PayAmount, SQLFLT8); 
			//mssql_bind($procedure,"@strdate", $date, SQLVARCHAR);
		
			$resource = mssql_execute($procedure);
			if(!$resource){
				echo "FAIL";
				return;
			}
			//------------执行成功返回success-------------//
			if($ret == 0){
				echo 'SUCC';
			}else{
				//获取存储过程返回错误信息
				// mssql_next_result($resource);
				// $errorMessage = iconv('gb2312', 'utf-8', $errorMessage);
				echo 'FAIL';
			}
			mssql_free_statement($procedure); 
			mssql_close($conn);
		}else{
			echo 'FAIL';
		}
		
	}else{
		echo 'FAIL';
	}

