<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>赠送会员</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/sendVip_do" method="GET">
					<span>玩家游戏ID：</span>
					<input type="text" class="user_search_input" name="GameID">
					<span>赠送天数：</span>
					<input type="text" class="user_search_input" name="days"></br>
					<span>赠送原因：</span>
					<input type="text" class="user_search_input" name="reason" style="width:254px;">
					<input class="user_search_submit" type="submit" value="赠送">					
				</form>
			</article>
				

		</section>
	</div>
	<footer>
				
	</footer>
</div>	
</body>
</html>