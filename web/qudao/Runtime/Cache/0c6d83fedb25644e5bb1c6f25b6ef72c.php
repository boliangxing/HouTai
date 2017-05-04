<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_info">
				<header>
					<h2>转账查询</h2>
				</header>			
				<form method="GET" action="<?php echo WEB_ROOT?>index.php/Vip/vip_ytj_s" style='padding-top:10px;padding-left:150px;' >
					<span>起止日期：&nbsp;&nbsp;</span>
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="end_date" value=<?php echo ($end_date); ?>>
					&nbsp;&nbsp;&nbsp;&nbsp;GameID：<input class="user_search_input" type="text" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">									
				</form>
			</article>

		</section>
	</div>
</div>	
</body>
</html>