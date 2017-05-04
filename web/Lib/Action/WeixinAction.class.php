<?php
//if (!class_exists('db_sqlite')){     require_once(ROOT_PATH . '/Db/pdo/sqlite.class.php'); }
class WeixinAction extends Action {
	public function index(){
		$GameID=$_GET['gameid'];
		$this->assign('GameID',$GameID);
		$this->display('index');
		//echo md5('123456');
	}
	
	public function GetCode(){
		$mssql = M();
		$date_now = date('Y-m-d H:i:s');
		$GameID=$_GET['zh'];		
		$return = array();	
		$sql='SELECT UserID FROM QPAccountsDB.dbo.AccountsInfo WHERE GameID='.$GameID;
		if(!$mssql->query($sql)){
			$return['err']='1';
			echo json_encode($return);
			return;
		}		
		$str = '123456789';
    	$count = strlen($str);
    	$num = '';
    	$str1 = '';
    	for($i=0;$i<4;$i++){
    		$str1 = $str{rand(0, $count-1)};
    		$num = $num.$str1;
		}
		$sql2='SELECT WeixinID,CONVERT(varchar,InsertTime,100) as InsertTime FROM QPAccountsDB.dbo.WxBindUser WHERE GameID='.$GameID;
		if($rs2=$mssql->query($sql2)){
			if((strtotime($date_now)-strtotime($rs2[0]['InsertTime']))<60){
				//获取时间少于一分钟
				$return['err']='3';
				echo json_encode($return);
				return;
			}
			if($rs2[0]['WeixinID']==''){
				$sql3='UPDATE QPAccountsDB.dbo.WxBindUser SET CheckCode='.$num.',InsertTime="'.$date_now.'" where GameID='.$GameID;
				if(!$mssql->query($sql3)){					
					$return['err']='0';
					$return['num']=$num;
					echo json_encode($return);
					return;
				}else{
					$return['err']='4';
					echo json_encode($return);
					return;
				}
			}else{
				//已绑定
				$return['err']='2';
				echo json_encode($return);
				return;
			}
		}else{
			$sql4='INSERT INTO QPAccountsDB.dbo.WxBindUser (GameID,CheckCode,InsertTime) values('.$GameID.','.$num.',"'.$date_now.'")';
			if(!$mssql->query($sql4)){					
				$return['err']='0';
				$return['num']=$num;
				echo json_encode($return);
				return;
			}else{
				//异常错误
				$return['err']='4';
				echo json_encode($return);
				return;
			}
		}   	
	}
	
	public function WeixinBack(){
		error_reporting(E_ALL & ~E_NOTICE);
		date_default_timezone_set("Asia/Shanghai");
		require_once 'weixin.class.php';
		define('TOKEN', 'GAME188ISGOOD');	//微信公众平台自定义接口处设置的 Token
		define('DEBUG', false);			//是否调试模式 true/false (开启调试将会把收发的信息写入文件)
		define('LOGPATH', './');		//日志目录
		$rs = array();
		$mssql=M();
		/*
		$Content= '4@1177721@2222';
		$WeixinID = $weixin->msg['FromUserName'];
		var_dump(eregi('^[0-9]@[0-9]{6,7}@[0-9]{4}$',$Content,$rs));
		echo $rs[0];
		var_dump($rs);
*/
//eregi(‘^[_a-z0-9-]+(/.[_a-z0-9-]+)*@[a-z0-9-]+(/.[a-z0-9-]+)*$ ’,$eamil) 


		//exit;

		$weixin = new weixin(TOKEN,DEBUG,LOGPATH);
		$weixin->valid();
		$weixin->getMsg();	
		$type = $weixin->msgtype;
		$domain = 'http://'.$_SERVER['HTTP_HOST'];
		$filename = (string)end(explode('/',$_SERVER['SCRIPT_NAME']));
		$strURL = $domain . str_replace($filename,'',$_SERVER['SCRIPT_NAME']);
		//关注时候的消息

		if ($type==='event') {

			if ($weixin->msg['Event']=='subscribe') {

		# 用户关注消息

				$note = '欢迎来到《盛大微网游·华商游戏》官方微信服务平台！只需回复“1@您的游戏ID@绑定校验码”即可将您的帐号绑定微信。绑定校验码可在游戏内微信服务界面内获得。--------------------------绑定微信后，即可体验一系列自助功能，回复“0”或“帮助”可查看所有功能！';

				$reply = $weixin->makeText($note);
			}
		}



		if ($type==='text') {
			$Content = $weixin->msg['Content'];
			$WeixinID = $weixin->msg['FromUserName'];
			/*
			$Content= $weixin->msg['Content'];
			
			var_dump(eregi('^[0-9]@[0-9]{6,7}@[0-9]{4}$',$Content,$rs));
			echo $rs[0];
			var_dump($rs);
			*/

			if ($weixin->msg['Content']=='1' || $weixin->msg['Content']=="1@") {

				$note = '亲，您是要将游戏帐号绑定微信号吗？指令格式应该是“1@您的游戏ID@4位绑定校验码”，绑定校验码可在游戏内微信服务界面内获得。';

				$reply = $weixin->makeText($note);

			}
			if ($weixin->msg['Content']=='2' || $weixin->msg['Content']=="2@") {

				$note = '亲，您是要开通微信密保吗？指令格式应该是“2@您的游戏ID”，别搞错哦!';

				$reply = $weixin->makeText($note);

			}
			if ($weixin->msg['Content']=='3' || $weixin->msg['Content']=="3@") {

				$note = '亲，您是要解绑主机吗？指令格式应该是“3@您的游戏ID”，别搞错哦!';

				$reply = $weixin->makeText($note);

			}
			if($weixin->msg['Content']=='0' || $weixin->msg['Content']=="帮助") {

				$note = '★回复“0”或“帮助”可查看所有指令，让你更方便的体验微信服务！

★回复“1@您的游戏ID@绑定校验码”可完成游戏帐号与微信号的绑定，只有绑定微信后才可进行其它操作哦，绑定校验码可在游戏内微信服务界面内获得。

★回复“2@您的游戏ID”开通微信密保。微信密保可有效防止您的帐号被盗！

★回复“3@您的游戏ID”自助解绑主机。让您不再因为短信延时而苦苦等待！';

				$reply = $weixin->makeText($note);	# 开始判断1绑定游戏账号和微信账号

			}
			if (eregi('^[0-9]@[0-9]{6,7}@[0-9]{4}$',$Content,$rs)) {
				
				$Operating_type = substr($Content, 0,1);
				$GameID = substr($Content, 2,-5);
				$CheckCode=substr($Content, -4);
				//file_put_contents('asasas.txt', $Operating_type);
				if($Operating_type==1){
					$CheckRs = $this->CheckUser($GameID,$CheckCode); 
					if($CheckRs==0){
						$sql='UPDATE QPAccountsDB.dbo.WxBindUser SET WeixinID="'.$WeixinID.'" WHERE GameID='.$GameID;
						if(!$mssql->query($sql)){
							$note = '绑定成功';
						}else{
							$note = '异常错误';
						}

					}elseif ($CheckRs==1) {
						//无账号
						$note = '无账号';
					}elseif ($CheckRs==2) {
						//无验证码信息
						$note = '无验证码信息';
					}elseif ($CheckRs==3) {
						//验证码超时
						$note = '验证码超时';
					}elseif ($CheckRs==4) {
						//用户已绑定
						$note = '用户已绑定';
					}elseif ($CheckRs==5) {
						//验证码不正确
						$note = '验证码不正确';
					}
				}else{
					$note = '亲，您是要将游戏帐号绑定微信号吗？指令格式应该是“1@您的游戏ID@4位绑定校验码”，绑定校验码可在游戏内微信服务界面内获得。';
				}
				//$note = '亲，您是要解绑主机吗？指令格式应该是“3@您的游戏ID”，别搞错哦!';

				$reply = $weixin->makeText($note);

			}if (eregi('^[0-9]@[0-9]{6,7}$',$Content,$rs)) {
				
				$Operating_type = substr($Content, 0,1);
				$GameID = substr($Content, 2);
				if($Operating_type==3){
					$UnBindRs = $this->CheckUser3($GameID,$WeixinID); 
					if($UnBindRs==0){
						$sql='UPDATE QPAccountsDB.dbo.AccountsInfo SET MoorMachine=0 WHERE GameID='.$GameID;
						if(!$mssql->query($sql)){
							$note = '解锁机器成功';
						}else{
							$note = '异常错误';
						}

					}elseif ($UnBindRs==1) {
						//未固定机器
						$note = '未固定机器';
					}elseif ($UnBindRs==2) {
						//无账号
						$note = '无账号';
					}elseif ($UnBindRs==3) {
						//绑定微信号有误
						$note = '绑定微信号有误';
					}elseif ($UnBindRs==4) {
						//该用户未绑定微信
						$note = '该用户未绑定微信';
					}
				}else{
					$note = '亲，您是要解绑主机吗？指令格式应该是“3@您的游戏ID”，别搞错哦!';
				}
				//

				$reply = $weixin->makeText($note);

			}else {

				$note = '★回复“0”或“帮助”可查看所有指令，让你更方便的体验微信服务！

★回复“1@您的游戏ID@绑定校验码”可完成游戏帐号与微信号的绑定，只有绑定微信后才可进行其它操作哦，绑定校验码可在游戏内微信服务界面内获得。

★回复“2@您的游戏ID”开通微信密保。微信密保可有效防止您的帐号被盗！

★回复“3@您的游戏ID”自助解绑主机。让您不再因为短信延时而苦苦等待！';

				$reply = $weixin->makeText($note);

			}

		}
		$weixin->reply($reply);
	}

	public function CheckUser($GameID,$CheckCode){
		$mssql=M();
		//$date_now = date('Y-m-d H:i:s');
		$sql = 'SELECT UserID FROM QPAccountsDB.dbo.AccountsInfo WHERE GameID='.$GameID;
		if(!$mssql->query($sql)){
			//无账号
			return 1;
		}
		$sql2 = 'SELECT WeixinID,CheckCode,CONVERT(varchar,InsertTime,100) as InsertTime FROM QPAccountsDB.dbo.WxBindUser WHERE GameID='.$GameID;
		if($rs2=$mssql->query($sql2)){
			if((strtotime(date('Y-m-d H:i:s'))-strtotime($rs2[0]['InsertTime']))>1800){
				//验证码超时
				return 3;
			}
			if($rs2[0]['WeixinID']!=''){
				//用户已绑定
				return 4;
			}
			if($rs2[0]['CheckCode']!=$CheckCode){
				//验证码有误
				return 5;
			}else{
				return 0;
			}

		}else{
			//无验证码信息
			return 2;
		}
	}

	public function CheckUser3($GameID,$WeixinID){
		$mssql=M();
		//$date_now = date('Y-m-d H:i:s');
		$sql = 'SELECT UserID,MoorMachine FROM QPAccountsDB.dbo.AccountsInfo WHERE GameID='.$GameID;
		if($rs=$mssql->query($sql)){
			if($rs[0]['MoorMachine']==0){
				//未固定机器
				return 1;
			}
		}else{
			//无账号
			return 2;
		}
		$sql2 = 'SELECT WeixinID FROM QPAccountsDB.dbo.WxBindUser WHERE GameID='.$GameID;
		if($rs2=$mssql->query($sql2)){
			if($rs2[0]['WeixinID']!=$WeixinID){
				//绑定微信号有误
				return 3;
			}else{
				return 0;
			}
		}else{
			//该用户未绑定微信
			return 4;
		}
	}
	
	
}