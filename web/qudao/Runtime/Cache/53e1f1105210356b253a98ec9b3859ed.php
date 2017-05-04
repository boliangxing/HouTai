<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="addM">
				<header>
					<h2>添加首冲用户</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/addSc" method="GET" style="padding-left:200px;">
					<span>游戏ID:</span>
					<input type="text" name="GameID">
					<input class="add_submit" type="submit" value="添加">				
				</form>
				
			</article>
			<article class="addM">
				<header>
					<h2>删除首冲用户</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/delSc2" method="GET" style="padding-left:200px;">
					<span>游戏ID:</span>
					<input type="text" name="GameID">
					<input class="add_submit" type="submit" value="删除">				
				</form>
				
			</article>
			<article class="giveinfo">
				<header>
					<h2>首冲用户列表</h2>
				</header>
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>序号</th>
							<th>GameID</th>
							<th>账号</th>
							<th>昵称</th>
							<th>充值金额</th>
							<th>金币</th>
							<th>银行</th>
							<th>转入</th>
                            <th>转出</th>
							<th>时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>				
							<td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php if($vo["UserMedal"] == 1 ): ?><span style="color:#cc00ff">★</span><?php endif; if($vo["LockMobileFrom"] == 1 ): ?><span style="color:blue">♥</span><?php endif; if($vo["LockMobileFrom"] == 2 ): ?><span style="color:blue">♥♥</span><?php endif; if($vo["IsOpenTokenLock"] == 1 ): ?><span style="color:red">★</span><?php endif; if($vo["CustomID"] == 0 ): ?><span style="color:#7b09d2"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
							<td><?php echo ($vo["Rechange"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><?php echo ($vo["zr"]); ?></td>
                            <td><?php echo ($vo["zc"]); ?></td>
							<td><?php echo ($vo["InsertDate"]); ?>
								</td>
							<td><a class="delTs" href="<?php echo WEB_ROOT?>index.php/User/delSc?UserID=<?php echo ($vo["UserID"]); ?>">删除</a>
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