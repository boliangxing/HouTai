<?php
class LoginAction extends Action {
	public function index(){
		$this->display('login');
		//echo md5('123456');
	}
	
	//登录验证
    public function userCheck(){
	session_start();
    	if("POST" == $_SERVER['REQUEST_METHOD']){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$code = md5($_POST['code']);
			$code1 = $_SESSION['verify'];
			if($code!=$code1){
				_location('验证码错误',WEB_ROOT.'index.php/Login');
			}
			$date = date('Y-m-d H:i:s');
			foreach($GLOBALS['USERS'] as $k=>$v){
				
				if($k==$username){
					$user = explode('|',$GLOBALS['USERS'][$k]);
					if($password==$user[0]){
						session('admin_a',$user);
						_href(WEB_ROOT."index.php/User");	
					}else{
						_location('帐号名或密码错误',WEB_ROOT.'index.php/Login');
					}			
				}
				
			}	
			_location('帐号名或密码错误',WEB_ROOT.'index.php/Login');
		}else{
			_location('帐号名或密码错误2',WEB_ROOT.'index.php/Login');
		}	
    }
    
    
    public function user_exit(){
    	$_SESSION['admin_a'] = null;
    	_href(WEB_ROOT."index.php/Login");
    }
    
	public function verify(){
    	import("@.ORG.Util.Image");
	ob_end_clean();
    	Image::buildImageVerify();
	}
}