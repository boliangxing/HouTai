<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>订单查询</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/order_search" method="GET">
					<span>请输入游戏ID/订单号：</span>
					<select name="type" id="select">
							<option value ="1">游戏ID</option>
  							<option value ="2">订单号</option> 						
					</select>
					<input type="text" class="user_search_input" style="width:150px" name="OrderID">
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