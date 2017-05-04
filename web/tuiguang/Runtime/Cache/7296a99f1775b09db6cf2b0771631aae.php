<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">	
			<article class="usersinfo">
				<header>
					<h2>用户统计</h2>
				</header>
				
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>时间</th>
							<th>登陆游戏总数</th>
							<th>注册总人数</th>
						</tr>
					</thead>
					<tbody>
						<tr>					
							<td><?php echo ($result["CollectDate"]); ?></td>
							<td><?php echo ($result["GameLogonSuccess"]); ?></td>
							<td><?php echo ($result["GameRegisterSuccess"]); ?></td>
						</tr>																											
					</tbody>
					
				</table></div>
			</article>		
		</section>
	</div>
</div>	
</body>
</html>