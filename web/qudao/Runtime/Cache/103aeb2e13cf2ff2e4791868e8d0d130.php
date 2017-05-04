<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>返利查询</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/fl_search" method="GET" style="padding-left:290px;">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
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