<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>用户查询</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/userInfo" method="GET">
					<span>请输入用户游戏ID/帐号：</span>
					<select name="type" id="select">
							<option value ="1">游戏ID</option>
  							<option value ="2">帐号</option> 
							<option value ="3">昵称</option> 
							<option value ="4">UserID</option> 
					</select>
					<input type="text" class="user_search_input" name="info">
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