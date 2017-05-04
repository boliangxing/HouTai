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
				<p style="padding-left:20px;">该机器码共有关联用户<?php echo ($rs['num']); ?>名，金币总额<?php echo ($rs['sum']); ?>，其中付费用户<?php echo ($rs2['num']); ?>名，金币总额<?php echo ($rs2['sum']); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/pb_do?type=1&mac=<?php echo ($mac); ?>">屏蔽全部</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/pb_do?type=2&mac=<?php echo ($mac); ?>">只屏蔽免费用户</a></p>
			</article>
				

		</section>
	</div>
	<footer>
				
	</footer>
</div>	
</body>
</html>