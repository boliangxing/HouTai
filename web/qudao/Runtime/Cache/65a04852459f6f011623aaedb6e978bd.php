<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>登陆地址查询</h2>
					
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/ip_search" method="GET">
					<span>请输入查询内容：</span>
					<select name="type" id="select">
							<option value ="1">注册ip</option>
  							<option value ="2">注册机器码</option> 	
  							<option value ="3">最后登陆ip</option> 
  							<option value ="4">最后登陆机器码</option> 						
					</select>
					<input type="text" class="user_search_input" name="con">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>
			</article>
				

		</section>
	</div>
	<footer>
				
	</footer>
</div>	
</body>
</html>