<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>进出查询</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/jc_search" method="GET" style="padding-left:160px;">
					<span style="padding-left:100px;">起止日期：&nbsp;&nbsp;</span>
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="end_date" value=<?php echo ($end_date); ?>></br>
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:100px" name="GameID" value=<?php echo ($GameID); ?>>
					<span>请输入游戏ID2：</span>
					<input type="text" class="user_search_input" style="width:100px" name="GameID2" value=<?php echo ($GameID2); ?>>
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