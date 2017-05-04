<?php
require_once("dxpay_config.php");
	$res = array();
    $GameID = $_GET['GameID'];
    $CardTypeID = $_GET['CardTypeID'];
    $IPAddress = $_GET['IPAddress'];
	$ApplyDate = date('Y-m-d H:i:s');
    $OrderID = generateTradeNO($conn);
    $sql1 = 'select UserID,GameID,Accounts from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID = '.$GameID;
   	$result1 = mssql_query($sql1,$conn);
   	if($row1 = mssql_fetch_assoc($result1)){
		$rs1 = $row1;		
	}else{
		$rs1 =0;
	}	
	if($rs1==0){
    	return;
    }else{
    	$UserID = $rs1['UserID'];
    	$GameID = $rs1['GameID'];
   		$Accounts = $rs1['Accounts'];
    }
   	$sql2 = 'select CardPrice,CardGold from QPTreasureDB.dbo.M_GlobalLivcard(NOLOCK) where CardTypeID = '.$CardTypeID;
   	$result2 = mssql_query($sql2,$conn);
   	if($row2 = mssql_fetch_assoc($result2)){
		$rs2 = $row2;		
	}else{
		$rs2 = 0;
	}	
	if($rs2==0){
    	return;
    }else{
    	$CardGold = $rs2['CardGold'];
   		$PayAmount = $rs2['CardPrice'];
    }        
    //exit;
    $sql = 'insert into OnLineOrder (OperUserID,ShareID,UserID,GameID,Accounts,OrderID,CardTypeID,CardPrice,CardGold,CardTotal,OrderAmount,DiscountScale,PayAmount,OrderStatus,IPAddress,ApplyDate) values(0,15,'.$UserID.','.$GameID.',"'.$Accounts.'","'.$OrderID.'",'.$CardTypeID.','.$PayAmount.','.$CardGold.',1,'.$PayAmount.',0,'.$PayAmount.',0,"'.$IPAddress.'","'.$ApplyDate.'")';
    //$sql.= 'values(1,13,'.$UserID.','.$GameID.',"'.$Accounts.'","'.$OrderID.'",'.$CardTypeID.','.$PayAmount.','.$CardGold.',1,'.$PayAmount.',0,'.$PayAmount.',0,"'.$IPAddress.'","'.$ApplyDate.'")';
    mssql_query($sql,$conn);  

    echo $OrderID;
    
    
    function generateTradeNO($conn){
    	$str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$count = strlen($str);
    	$OrderID = '';
    	$str1 = '';
    	$rs = '';
    	for($i=0;$i<13;$i++){
    		$str1 = $str{rand(0, $count-1)};
    		$OrderID = $OrderID.$str1;
    	}
    	$sql = 'select count(OnLineID) as num from QPTreasureDB.dbo.OnLineOrder(NOLOCK) where OrderID ="'.$OrderID.'"';
		$result = mssql_query($sql,$conn);
    	while($row = mssql_fetch_assoc($result)){
			$rs = $row['num'];		
		}
		if($rs==1){
			generateTradeNO($conn);
		}else{
			return 'DX'.$OrderID;
		}	
    }  
	//SQLFLT8
