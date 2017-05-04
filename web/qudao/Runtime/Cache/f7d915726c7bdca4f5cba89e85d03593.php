<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>批量屏蔽</h2>
					
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/pb_se" method="GET">
					<span>请输入屏蔽机器码：</span>
					<input type="text" class="user_search_input" name="mac" style='width:200px'>
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