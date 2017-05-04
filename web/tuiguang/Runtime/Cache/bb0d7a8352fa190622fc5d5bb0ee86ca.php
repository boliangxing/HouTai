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
			<article class="user_info">
				<div id="table_w">
				<table id="num">
					<thead>
					
						<tr>
							<th>游戏ID</th>
							<th>账号</th>
							<th>订单号</th>
							<th>金额</th>
							<th>欢乐豆</th>
							<th>购买前</th>
							<th>状态</th>
							<th>时间</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["GameID"]); ?></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php echo ($vo["OrderID"]); ?></td>
							<td><?php echo ($vo["PayAmount"]); ?></td>
							<td><?php echo ($vo["CardGold"]); ?></td>
							<td><?php echo ($vo["BeforeGold"]); ?></td>
							<td><?php if($vo['OrderStatus'] == 2): ?><span style='color:green'>已完成</span><?php endif; if($vo['OrderStatus'] == 1): ?><span style='color:red'>未到账</span><?php endif; if($vo['OrderStatus'] == 0): ?><span style='color:red'>未支付</span><?php endif; ?></td>
							<td><?php echo ($vo["ApplyDate"]); ?></td>
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