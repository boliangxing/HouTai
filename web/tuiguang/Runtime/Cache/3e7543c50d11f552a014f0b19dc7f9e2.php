<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>管理系统-登录</title>
	<link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_PATH?>styles/main.css">
</head>
<body>
	<div class="login">
		<header>
			<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理系统</h1>
		</header>
		<form action="<?php echo WEB_ROOT?>index.php/Login/userCheck" class="login-form-wrap"  method="POST">
			<div class="name">
				<label for="name">用户名</label>
				<div>
					<input id="name" type="text" name="username">
				</div>
			</div>
			<div class="password" >
				<label for="password">密&nbsp;&nbsp;&nbsp;码</label>
				<div>
					<input id="password" type="password" name="password">
				</div>
			</div>
			<div class="name" id="code">
				<label for="name">验证码</label>
				<div>
					<input id="code" type="text" name="code">
					<input id="aa" type="hidden" name="aa" value=''>
				</div>
				<img src="<?php echo WEB_ROOT?>index.php/Login/verify" width="75" height="35" onclick="this.src = '<?php echo WEB_ROOT?>index.php/Login/verify?t='+new Date().getTime();"   title="看不清，点击换下一张" />
			</div>
			<div class="button">
				<input type="submit" value="登录">
			</div>	

		</form>	
	</div>
</body>
<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>  
<script type="text/javascript">  
//var aa=returnCitySN["cip"]+','+returnCitySN["cname"];  
document.getElementById("aa").value=returnCitySN["cip"]+','+returnCitySN["cname"];
</script>
</html>