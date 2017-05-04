<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="cx_form">	
				<header>
                    <h2>当日排行</h2>
                </header>		
				<form action="<?php echo WEB_ROOT?>index.php/Vip/day_list" method="GET">
                    <span style="margin-left:200px;">查询日期&nbsp;&nbsp;</span>
					<input name="date" type="text" class="datepick" value="<?php echo ($date); ?>">
					<input class="submit" type="submit" value="查询">
					<span style='padding-left:20px;'>奖励总：<?php echo ($sum); ?></span>
                </form>
			</article>
			<article class="cx_form">
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>排行</th>
							<th>GameID</th>
							<th>帐号</th>
							<th>昵称</th>
							<th>金额</th>
							<th>奖励</th>
							<th>查询未游戏</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
							<td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php if($vo["isChange"] == 1 ): ?><span style="color:#7b09d2"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
							<td>金额：<?php echo ($vo["Num"]); ?></td>
							<td>奖励：<?php echo ($vo["give"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/un_game?GameID=<?php echo ($vo["GameID"]); ?>&date=<?php echo ($date); ?>" target="_blank">查询</a></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					
				</table>
				</div>
			</article>			
		</section>
	</div>
</div>	
</body>
</html>