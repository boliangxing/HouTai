<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="cx_form">	
				<header>
                    <h2>不活跃VIP</h2>
                </header>		
				<form action="<?php echo WEB_ROOT?>index.php/User/unvip" method="GET">
                    <span style="margin-left:200px;">查询日期&nbsp;&nbsp;</span>
					<input name="date" type="text" class="datepick" value="<?php echo ($date); ?>">
					<input class="submit" type="submit" value="查询">
                </form>
			</article>
			<article class="cx_form">
				<div id="table_w">
				<span>当前规则：选中日期内无转出到普通，身上加保险箱总额大于500W</span>
				<table id="num">
					<thead>
						<tr>
							<th>GameID</th>
							<th>帐号</th>
							<th>昵称</th>
							<th>身上金额</th>
							<th>保险箱</th>
							<th>总</th>
							<th>最后登录时间</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><?php echo ($vo["zong"]); ?></td>
							<td><?php echo ($vo["LastLogonDate"]); ?></td>
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