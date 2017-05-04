<?php
if (!class_exists('db_sqlite')){     require_once(ROOT_PATH . '/Db/pdo/sqlite.class.php'); }
class ClientAction extends Action {
	public function index(){
		$this->display('unlockPC');
		//echo md5('123456');
	}
	
	public function SendCode(){
		$mssql = M();
		$Accounts=$_GET['zh'];
		$Phone = $_GET['phone'];
		$Type=$_GET['type'];
		$Yzm = md5($_GET['yzm']);
		$code=$_SESSION['verify'];
		if($Type==0){
			if($Yzm != $code){
				$return['res']='1';
				echo json_encode($return);
				return;
			}
			$sql='SELECT MoorMachine,RegisterMobile,IsLockMobile FROM QPAccountsDB.dbo.AccountsInfo WHERE Accounts="'.$Accounts.'"';
			if($rs=$mssql->query($sql)){
			//file_put_contents('aaaa.txt', json_encode($rs[0]));
				if($rs[0]['MoorMachine']==0){
					$return['res']='2';
					echo json_encode($return);
					return;
				}
				if($rs[0]['IsLockMobile']==0){
					$return['res']='3';
					echo json_encode($return);
					return;
				}
				if($rs[0]['RegisterMobile']!=$Phone){
					$return['res']='4';
					echo json_encode($return);
					return;
				}
				$CheckCode=$this->getCode($Phone);
				if($CheckCode==1){
					$return['res']='6';
					echo json_encode($return);
					return;
				}	
				if($CheckCode==2){
					$return['res']='7';
					echo json_encode($return);
					return;
				}	
				file_put_contents('aaaa.txt', json_encode($rs[0]));
				$target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
				$post_data = "account=cf_sulifu&password=a123456&mobile=".$Phone."&content=".rawurlencode("您申请的手机认证服务验证码为：".$CheckCode.",30分钟内有效,如非本人操作,请联系客服！");
				$this->Post($post_data, $target);

				$return['res']='0';
				echo json_encode($return);
				return;									
			}else{
				$return['res']='5';
				echo json_encode($return);
				return;
			}		
			echo json_encode($return);
		}
		if($Type==1){
			$xym=$_GET['xym'];
			$sql2='SELECT MoorMachine,RegisterMobile,IsLockMobile FROM QPAccountsDB.dbo.AccountsInfo WHERE Accounts="'.$Accounts.'"';
			if($rs2=$mssql->query($sql2)){
			//file_put_contents('aaaa.txt', json_encode($rs[0]));
				if($rs2[0]['MoorMachine']==0){
					$return['res']='2';
					echo json_encode($return);
					return;
				}
				if($rs2[0]['IsLockMobile']==0){
					$return['res']='3';
					echo json_encode($return);
					return;
				}
				if($rs2[0]['RegisterMobile']!=$Phone){
					$return['res']='4';
					echo json_encode($return);
					return;
				}	
			}
			$VerifyCode = $this->CheckCode($Phone, $xym);
			if($VerifyCode==1){
				$return['res']='8';
				echo json_encode($return);
				return;
			}	
			if($VerifyCode==2){
				$return['res']='9';
				echo json_encode($return);
				return;
			}
			$sql3='UPDATE QPAccountsDB.dbo.AccountsInfo SET MoorMachine=0 WHERE Accounts="'.$Accounts.'"';
			if(!$mssql->query($sql3)){
				$return['res']='11';
				echo json_encode($return);
				return;
			}else{
				$return['res']='10';
				echo json_encode($return);
				return;
			}		
			
		}	
	}
	
	public function CheckCode($Phone,$xym){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite('Db/hs.db');
    	$sql = 'select phone,code,send_num,insertdate from check_code where type=5 and phone="'.$Phone.'"';
		if($rs = $sqlite->query($sql)->fetchAll()){		
			if(strtotime(date('Y-m-d H:i:s'))-strtotime($rs[0]['insertdate'])>1800){
				return 2;
			}
			if($rs[0]['send_num']>50){
				return 1;
			}	
			if($rs[0]['code']!=$xym){
				return 1;
			}
		}else{
			return 1;
		}
	}
	
	public function getCode($Phone){
		$sqlite = new db_sqlite();
    	$sqlite->sqlite('Db/hs.db');
    	$str = '123456789';
   		$count = strlen($str);
    	$check_code = '';
    	$str1 = '';
    	$rs = array();
    	for($i=0;$i<4;$i++){
    		$str1 = $str{rand(0, $count-1)};
    		$check_code = $check_code.$str1;
    	}

    	$sql = 'select phone,code,send_num,insertdate from check_code where type=5 and phone="'.$Phone.'"';
		if(!$rs = $sqlite->query($sql)->fetchAll()){			
			$arr = array('phone'=>$Phone,'code'=>$check_code,'insertdate'=>date('Y-m-d H:i:s'),'type'=>5);
			$sqlite->insert('check_code', $arr);
			return $check_code;
		}
		if($rs[0]['code']==$check_code){
			getCode($Phone);
		}if(strtotime(date('Y-m-d H:i:s'))-strtotime($rs[0]['insertdate'])<60){
				return 2;
		}else{
			if(date('Y-m-d')==date('Y-m-d',strtotime($rs[0]['insertdate']))){
				$arr = array('code'=>$check_code,'insertdate'=>date('Y-m-d H:i:s'),'send_num'=>$rs[0]['send_num']+1);
				$condition = array('phone'=>$Phone,'type'=>5);
				$sqlite->update('check_code', $arr,$condition);
				if($rs['0']['send_num']>50){
					return 1;
				}
			}else{
				$arr = array('code'=>$check_code,'insertdate'=>date('Y-m-d H:i:s'),'send_num'=>1);
				$condition = array('phone'=>$Phone,'type'=>3);
				$sqlite->update('check_code', $arr,$condition);
			}
			return $check_code;
		}				
	
	}
	
	public function Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
	}
	public function verify(){
    	import("@.ORG.Util.Image");
    	Image::buildImageVerify();
	}
	
}