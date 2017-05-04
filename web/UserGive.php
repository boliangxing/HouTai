<?php
require_once('Db/Db_charge.php'); 
	date_default_timezone_set('Asia/Shanghai'); 
	$InsertDate = date("Y-m-d",strtotime("-1 day"));
	//$InsertDate = '2015-08-10';
	$start_date = $InsertDate.' 00:00:00';
	$end_date = $InsertDate.' 23:59:59';
	mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']); 
	$rs = array();
	$procedure = mssql_init("PHP_VipDayList",$conn); 
        
    mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
    mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);      
    $resource = mssql_execute($procedure);
    while($row = mssql_fetch_assoc($resource)){
        $rs[] = $row;
    }       
    mssql_free_statement($procedure); 
    mssql_close($conn);   

    $sql = 'SELECT t3.GameID,SUM(t1.SwapScore) as num FROM [QPTreasureDB].[dbo].[CancelInsure](NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.TargetUserID=t2.UserID left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3 on t1.SourceUserID=t3.UserID ';
    $sql.= 'where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t3.MemberOrder>0 and t2.MemberOrder=0 group by t3.GameID';
	//$result = mssql_fetch_assoc(mssql_query($sql,$conn));
	$res = mssql_query($sql,$conn);
		while ($row2 = mssql_fetch_assoc($res)){
			$result[]=$row2;
		}
	
	//print_r($result);
	//exit;
    for($i=0;$i<count($rs);$i++){
        foreach ($result as $key => $val) {
            if($rs[$i]['GameID']==$val['GameID']){
                $rs[$i]['Num'] = $rs[$i]['Num']-$val['num'];
            }
        }

		
		
		if($rs[$i]['GameID']==922222){
	    	$rs[$i]['Num']=$rs[$i]['Num']-1680000;
	    }
		if($rs[$i]['GameID']==338899){
	    	$rs[$i]['Num']=$rs[$i]['Num']-1584000;
	    }
		if($rs[$i]['GameID']==989898){
	    	$rs[$i]['Num']=$rs[$i]['Num']-20000000;
	    }
		if($rs[$i]['GameID']==789789){
	    	$rs[$i]['Num']=$rs[$i]['Num']-960000;
	    }
		if($rs[$i]['GameID']==888555){
	    	$rs[$i]['Num']=$rs[$i]['Num']-80000;
	    }
		if($rs[$i]['GameID']==6880167){
	    	$rs[$i]['Num']=$rs[$i]['Num']-800000;
	    }
		if($rs[$i]['GameID']==999555){
	    	$rs[$i]['Num']=$rs[$i]['Num']-4800000;
	    }
		if($rs[$i]['GameID']==559988){
	    	$rs[$i]['Num']=$rs[$i]['Num']-16000000;
	    }
		if($rs[$i]['GameID']==668668){
	    	$rs[$i]['Num']=$rs[$i]['Num']-80000;
	    }
		if($rs[$i]['GameID']==969696){
	    	$rs[$i]['Num']=$rs[$i]['Num']-96000;
	    }
		if($rs[$i]['GameID']==277960){
	    	$rs[$i]['Num']=$rs[$i]['Num']-5760000;
	    }
		if($rs[$i]['GameID']==218218){
	    	$rs[$i]['Num']=$rs[$i]['Num']-8000000;
	    }
		if($rs[$i]['GameID']==388588){
	    	$rs[$i]['Num']=0;
	    }
		if($rs[$i]['GameID']==556677){
	    	$rs[$i]['Num']=0;
	    }
		
		
		
		
		
		/*
		if($rs[$i]['GameID']==922222){
	    	$rs[$i]['Num']=$rs[$i]['Num']-4980000;
	    }
		if($rs[$i]['GameID']==181818){
	    	$rs[$i]['Num']=$rs[$i]['Num']-8250000;
	    }
		
		if($rs[$i]['GameID']==922222){
	    	$rs[$i]['Num']=$rs[$i]['Num']-8790000;
	    }
		if($rs[$i]['GameID']==333888){
	    	$rs[$i]['Num']=$rs[$i]['Num']-489000;
	    }
*/
		
		/*
	    if($rs[$i]['Num']>=20000000){
	    	$rs[$i]['no'] = $i+1;
	    }
		*/
	    //$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);  
	    //$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);    
	    if($rs[$i]['Num']>=3000000000){
	        $rs[$i]['give'] = $rs[$i]['Num']*0.1;
	    } 
	    if($rs[$i]['Num']>=1000000000 and $rs[$i]['Num']<3000000000){
	        $rs[$i]['give'] = $rs[$i]['Num']*0.08;
	    } 
	    if($rs[$i]['Num']>=500000000 and $rs[$i]['Num']<1000000000){
	        $rs[$i]['give'] = $rs[$i]['Num']*0.06;
	    }  
	    if($rs[$i]['Num']>=100000000 and $rs[$i]['Num']<500000000){
	        $rs[$i]['give'] = $rs[$i]['Num']*0.04;
	    }  
	    if($rs[$i]['Num']>=60000000 and $rs[$i]['Num']<100000000){
	        $rs[$i]['give'] = $rs[$i]['Num']*0.03;
	    } 
	    if($rs[$i]['Num']>=20000000 and $rs[$i]['Num']<60000000){
	        $rs[$i]['give'] = $rs[$i]['Num']*0.02;
	    } 
		if($rs[$i]['Num']<20000000){
	        $rs[$i]['give'] = 0;
	    }
		$sql3='select count(ID) as c_num from QPWebbackDB.dbo.GiveRecord where UserID='.$rs[$i]['SourceUserID'].' and InsertDate="'.$InsertDate.'"';
		$result3 = mssql_fetch_assoc(mssql_query($sql3,$conn));
		if($result3['c_num']==0){
			$sql2 = 'Insert into QPWebbackDB.dbo.GiveRecord (UserID,GameID,Accounts,NickName,Num,Give,IsSend,InsertDate) values('.$rs[$i]['SourceUserID'].','.$rs[$i]['GameID'].',"'.$rs[$i]['Accounts'].'","'.$rs[$i]['NickName'].'",'.$rs[$i]['Num'].','.$rs[$i]['give'].',0,"'.$InsertDate.'")';
			echo $sql2;
			mssql_query($sql2,$conn);
		}	
	}

