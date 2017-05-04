<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="cx_form">	
				<header>
                    <h2>每分钟人数分类</h2>
                </header>		
				<form action="<?php echo WEB_ROOT?>index.php/User/online_type" method="GET">
                    <span style="margin-left:200px;">查询日期&nbsp;&nbsp;</span>
					<input name="date" type="text" class="datepick" value="<?php echo ($date); ?>">
					<input class="submit" type="submit" value="查询">
                </form>
			</article>
			<article class="cx_form">
				<div id="table_w">
				<table id="num">
					<thead id="show">
						<tr style="width: 900px;">
							<th>时间</th>
							<th>电信</th>
							<th>联通</th>
							<th>移动</th>
							<th>长城宽带</th>
							<th>0000</th>
							<th>其他</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["InsertDate"]); ?></td>
							<td><?php echo ($vo["dx"]); ?></td>
							<td><?php echo ($vo["lt"]); ?></td>
							<td><?php echo ($vo["yd"]); ?></td>
							<td><?php echo ($vo["kd"]); ?></td>
							<td><?php echo ($vo["bl"]); ?></td>
							<td><?php echo ($vo["qt"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					
				</table>
				</div>
			</article>			
		</section>
	</div>
</div>
<script type="text/javascript">
setTimeout("self.location.reload();",60000);
</script>	
</body>
</html>