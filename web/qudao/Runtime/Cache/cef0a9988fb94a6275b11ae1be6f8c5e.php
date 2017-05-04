<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="cx_form">	
				<header>
                    <h2>不同设备登陆人数</h2>
                </header>		
				<form action="<?php echo WEB_ROOT?>index.php/User/LoginBy" method="GET">
                    <span style="margin-left:200px;">查询日期&nbsp;&nbsp;</span>
					<input name="date" type="text" class="datepick" value="<?php echo ($date); ?>">
					<input class="submit" type="submit" value="查询">
                </form>
			</article>
			<article class="cx_form">
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>时间</th>
							<th>IOS</th>
							<th>Android</th>
							<th>PC</th>
							<th>总</th>
							<th>付费用户</th>
							<th>付费(ios)</th>
							<th>付费(android)</th>
							<th>付费(pc)</th>
							
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["Hour"]); ?></td>
							<td><?php echo ($vo["IOS"]); ?></td>
							<td><?php echo ($vo["Android"]); ?></td>
							<td><?php echo ($vo["PC"]); ?></td>
							<td><?php echo ($vo["zong"]); ?></td>
							<td><?php echo ($vo["Fufei"]); ?></td>
							<td><?php echo ($vo["FF_IOS"]); ?></td>
							<td><?php echo ($vo["FF_and"]); ?></td>
							<td><?php echo ($vo["FF_pc"]); ?></td>
						</tr><?php endforeach; endif; ?>
						<tr>
							<td>总</td>
							<td><?php echo ($total["IOS"]); ?></td>
							<td><?php echo ($total["Android"]); ?></td>
							<td><?php echo ($total["PC"]); ?></td>
							<td><?php echo ($total["zong"]); ?></td>
							
						</tr>
					</tbody>
					
				</table>
				</div>
			</article>			
		</section>
	</div>
</div>	
</body>
</html>