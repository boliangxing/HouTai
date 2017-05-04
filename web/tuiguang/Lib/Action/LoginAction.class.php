<?php
class LoginAction extends Action {
	public function index(){
		$this->display('login');
		//echo md5('123456');
	}

	//登录验证
    public function userCheck(){

    	if("POST" == $_SERVER['REQUEST_METHOD']){
			$username = $_POST['username'];
			$password = strtoupper($_POST['password']);
			//$code = md5($_POST['code']);
			//$code1 = $_SESSION['verify'];
			$A="'".$username."'";
			$B="'".$password."'";

				$mssql = M();
				$sql = ' SELECT *FROM QPStatisticsDB.dbo.tuiguangqx  where name = '.$A.' and Password = '.$B.' ';
				$rs = $mssql->query($sql);
				if($rs[0]['Name']==''){
					  // _location("用户名或密码错误,请重新输入",WEB_ROOT."index.php/Login");
             echo $rs[0]['Name'];

				}else{
					$sqls = 'select * from QPStatisticsDB.dbo.tuiguangqx where name = '.$A.' ';
					$rss = $mssql->query($sqls);

				 $user = array('username'=>$rss[0]['Name'],'id'=>$rss[0]['id'],'qudao'=>$rss[0]['qudao']);
         //session_register('zs78_admin2');
					$_SESSION['zs78_admin']=$user;



					session('zs78_admin',$user);


 					 //_location("登陆成功",WEB_ROOT."index.php");
					// $this->display('ecx');
					   _href(WEB_ROOT."index.php/User");

				}

		}
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
