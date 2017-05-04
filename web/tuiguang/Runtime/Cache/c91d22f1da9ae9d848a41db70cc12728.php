<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>赠送靓号</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/sendNum_do" method="GET">
					<span>玩家游戏ID：</span>
					<input type="text" class="user_search_input" name="GameID">
					<span>靓号：</span>
					<input type="text" class="user_search_input" name="sendNum">
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