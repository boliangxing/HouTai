<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="addM">
				<header>
					<h2>添加关注用户</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/addGz" method="GET" style="padding-left:200px;">
					<span>添加条件：</span>
					<select name="type" id="select">
							<option value ="1">游戏ID</option>					
					</select><input type="text" name="GameID">
					<input class="add_submit" type="submit" value="添加">				
				</form>
			</article>

			<article class="addM">
				<header>
					<h2>删除关注用户</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/DelGz" method="GET" style="padding-left:200px;">
					<span>GameID：</span>
					<input type="text" name="GameID">
					<input class="add_submit" type="submit" value="删除">				
				</form>
				
			</article>
			<article class="giveinfo">
				<header>
					<h2>关注用户列表</h2>
				</header>
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>序号</th>
							<th>GameID</th>
							
							<th>昵称</th>
							<th>IP</th>
							<th>最后登录时间</th>
							<th>金币</th>
							<th>银行</th>
							<th>游戏房间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
							<td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							
							<td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["LastLogonIP"]); ?></br>(<?php echo ($vo["Re_city"]["country"]); ?>--<?php echo ($vo["Re_city"]["area"]); ?>)</td>
							<td><?php echo ($vo["LastLogonDate"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><?php if($vo["r"] == 1 ): ?><span style="color:red"><?php echo ($vo["game"]); ?></span>
                                <?php else: echo ($vo["game"]); endif; ?></td>
							<td><a class="delTs" href="<?php echo WEB_ROOT?>index.php/User/delGz?GameID=<?php echo ($vo["GameID"]); ?>">删除</a>
								</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					
				</table>
				</div>
			</article>			

		</section>
	</div>
	<footer>
					
	</footer>
</div>	
</body>
</html>