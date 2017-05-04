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
			<article class="user_info">
				<span style="padding-left:290px;">昵称：<?php echo ($NickName); ?>&nbsp;&nbsp;&nbsp;&nbsp;当前剩余：<?php echo ($NowScore); ?></span>
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>时间</th>
							<th>金额</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($rs2)): foreach($rs2 as $key=>$vo): ?><tr>
							<td><?php echo ($vo["ChangeDateTime"]); ?></td>
							<td><?php echo ($vo["ChangeScore"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>					
				</table></div>
			</article>			
		</section>
	</div>
	<footer>
		
	</footer>
</div>	
</body>
</html>