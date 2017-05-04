<?php
class LoginAction extends Action {

	public function _initialize(){
		session_start();

		}

	public function index(){
		$this->display('login');
		//echo md5('123456');
	}

	//登录验证
    public function userCheck(){

    	if("POST" == $_SERVER['REQUEST_METHOD']){
			$username = $_POST['username'];
			$password = strtoupper(md5($_POST['password']));
			//$code = md5($_POST['code']);
			//$code1 = $_SESSION['verify'];
			$A="'".$username."'";
			$B="'".$password."'";
			$code=1;
			$code1=1;
			$date = date('Y-m-d H:i:s');
			$IP=$_POST['aa'];
			$a='IP:'.$IP.'--账号:'.$username.'--密码：'.$_POST['password'];
			writeslog($a);

				$mssql = M();
				$sql = 'select * from QPPlatformManagerDB.dbo.Base_Users where Username = '.$A.' and Password = '.$B.' and Nullity=0';
				$rs = $mssql->query($sql);
				if($rs[0]['UserID']==''){
					  // _location("用户名或密码错误,请重新输入",WEB_ROOT."index.php/Login");
             echo $sql;

				}else{
					$sqls = 'select * from QPStatisticsDB.dbo.quanxian where name = '.$A.' ';
					$rss = $mssql->query($sqls);

				 $user = array('username'=>$rs[0]['Username'],'role'=>$rs[0]['RoleID'],'id'=>$rs[0]['UserID'],'qudao'=>$rss[0]['qudao']);
         //session_register('zs78_admin2');
					$_SESSION['zs78_admin2']=$user;



					session('zs78_admin2',$user);

					$a='IP:'.$IP.'--账号:'.$username.'--密码：'.$_POST['password'].'--成功';
					writeslog($a);
					$sql2 = 'update QPPlatformManagerDB.dbo.Base_Users set PreLogintime="'.$rs[0]['LastLogintime'].'",PreLoginIP="'.$rs[0]['LastLoginIP'].'",LastLogintime="'.$date.'",LastLoginIP="'.$IP.'",LoginTimes=LoginTimes+1 where UserID = '.$rs[0]['UserID'];
					$rs2 = $mssql->query($sql2);
 					 //_location("登陆成功",WEB_ROOT."index.php");
					// $this->display('ecx');
					   _href(WEB_ROOT."index.php/User");

				}

		}else{
			_location('登录错误',WEB_ROOT.'index.php/Login');
		}
    }

		public function ecx(){

			$a=70000;
			$b=$a/10000;
			$c=$b.'.00'.'万';
			echo $c;


		}
    public function user_exit(){
    	$_SESSION['zs78_admin'] = null;
    	_href(WEB_ROOT."index.php/Login");
    }

	public function verify(){
    	import("@.ORG.Util.Image");
	ob_end_clean();
    	Image::buildImageVerify();
	}
}
