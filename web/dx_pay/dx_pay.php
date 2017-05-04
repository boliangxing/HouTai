<?php
require_once("dxpay_config.php");

    //echo decryptStrin('28ee1fb779a38f8537db39be4605cb8211a342bbfda34cc808d8e1d7f34c48abe585cdea714e5ebdc078968a22ed3d8a752cbc95e613a602e8b002a28c1b216f84496f4b37b05ea5fa38d492d4d0e43e93df74a0cc399908e28064d3f93e58f8');
    	
    $OrderID = $_GET['order_id'];
    $status = $_GET['status'];
    $PayAmount = $_GET['pay_amount'];
    $sign = $_GET['sign'];
    $order_idz = $_GET['order_idz'];
    //$add_time = $_GET['add_time'];
    if($status == 0){
    	echo 'fail';
    	return;
    }
    
  	$str_ec = 'status='.$status.'&order_id='.$OrderID.'&pay_amount='.$PayAmount.'&order_idz='.$order_idz.'&sign='.$sign;
    //echo $str_ec;
  	
    $str_de = decryptStrin($sign);

    $add_time = substr($str_de, strrpos($str_de, '&add_time='));
    
    $str_pin = 'status='.$status.'&order_id='.$OrderID.'&pay_amount='.$PayAmount.'&order_idz='.$order_idz.$add_time;
    
    //$date =date('Y-m-d H:i:s',substr($str_de, strrpos($str_de, '&add_time=')+10,-4));

    
    if($str_pin != $str_de){
    	echo 'fail';
    	return;
    }else{

    	$procedure = mssql_init("php_dx_pay",$conn); 
		mssql_bind($procedure,"RETVAL",$ret,SQLINT4,true);
		mssql_bind($procedure,"@strOrdersID", $OrderID, SQLVARCHAR); 
		mssql_bind($procedure,"@strOrderAmount", $PayAmount, SQLFLT8); 
		//mssql_bind($procedure,"@strdate", $date, SQLVARCHAR);
		
		$resource = mssql_execute($procedure);
		if(!$resource){
			echo 'fail';
			return;
		}
		//------------执行成功返回success-------------//
		if($ret == 0){
			echo 'success';
		}else{
			//获取存储过程返回错误信息
			// mssql_next_result($resource);
			// $errorMessage = iconv('gb2312', 'utf-8', $errorMessage);

			echo 'fail';
		}
		mssql_free_statement($procedure); 
		mssql_close($conn);
    }

    
	
	//解密
	function decryptStrin($str, $keys="AetEbd286IWVsb38", $cipher_alg=MCRYPT_RIJNDAEL_128){
		$decrypted_string = mcrypt_decrypt($cipher_alg, $keys, pack("H*",$str),MCRYPT_MODE_ecb);
		return $decrypted_string;
	}
