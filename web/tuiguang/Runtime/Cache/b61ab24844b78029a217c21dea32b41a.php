<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="addM">
				<header>
					<h2>添加提示用户</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/addTs" method="GET" style="padding-left:200px;">
					<span>添加条件：</span>
					<select name="type" id="select">
							<option value ="1">游戏ID</option>
  							<option value ="2">注册IP</option> 
  							<option value ="3">最后登录IP</option> 	
  							<option value ="4">注册机器码</option> 
  							<option value ="5">最后登录机器码</option> 						
					</select><input type="text" name="GameID">
					<input class="add_submit" type="submit" value="添加">				
				</form>
			</article>

			<article class="addM">
				<header>
					<h2>删除提示用户</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/DelTsByGameID" method="GET" style="padding-left:200px;">
					<span>GameID：</span>
					<input type="text" name="GameID">
					<input class="add_submit" type="submit" value="删除">				
				</form>
				
			</article>
			<article class="giveinfo">
				<header>
					<h2>提示用户列表</h2>
				</header>
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>序号</th>
							<th>GameID</th>
							<th>账号</th>
							<th>昵称</th>
							<th>金币</th>
							<th>银行</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
							<td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><a class="delTs" href="<?php echo WEB_ROOT?>index.php/User/delTs?UserID=<?php echo ($vo["UserID"]); ?>">删除</a>
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