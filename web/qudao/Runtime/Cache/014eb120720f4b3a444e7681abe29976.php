<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="cx_form">	
				<header>
                    <h2>每分钟人数</h2>
                </header>		
				<form action="<?php echo WEB_ROOT?>index.php/User/online_minute" method="GET">
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
							<th width="13%">时间</th>
							<th width="4%">总</th>
							<th width="7%">付费用户</th>
							<th width="7%">免费用户</th>
							<th width="4%">vip</th>
							<th width="4%">IOS</th>
							<th width="7%">Android</th>
							<th width="4%">PC</th>
							<th width="6%">付费(ios)</th>
							<th width="6%">付费(android)</th>
							<th width="6%">付费(pc)</th>
							<th width="5%">免费(ios)</th>
							<th width="8%">免费(android)</th>
							<th width="7%">免费(pc)</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["InsertDate"]); ?></td>
							<td><?php echo ($vo["zong"]); ?></td>
							<td><?php echo ($vo["Fufei"]); ?></td>
							<td><?php echo ($vo["Mianfei"]); ?></td>
							<td><?php echo ($vo["VIP"]); ?></td>
							<td><?php echo ($vo["IOS"]); ?></td>
							<td><?php echo ($vo["Android"]); ?></td>
							<td><?php echo ($vo["PC"]); ?></td>
							<td><?php echo ($vo["FF_IOS"]); ?></td>
							<td><?php echo ($vo["FF_and"]); ?></td>
							<td><?php echo ($vo["FF_pc"]); ?></td>
							<td><?php echo ($vo["MF_IOS"]); ?></td>
							<td><?php echo ($vo["MF_and"]); ?></td>
							<td><?php echo ($vo["MF_pc"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					
				</table>
				</div>
			</article>			
		</section>
	</div>
</div>	
</body>
<script type="text/javascript">
var IsShow=0;
window.onscroll = function () { 
	var h=$(document).scrollTop();
	if(IsShow==0 && h>300){
		$('#show').html('<tr style="width: 900px;"><th width="13%">时间</th><th width="4%">总</th><th width="7%">付费用户</th><th width="7%">免费用户</th><th width="4%">vip</th><th width="4%">IOS</th><th width="7%">Android</th><th width="4%">PC</th><th width="6%">付费(ios)</th><th width="6%">付费(android)</th><th width="6%">付费(pc)</th><th width="5%">免费(ios)</th><th width="8%">免费(android)</th><th width="7%">免费(pc)</th></tr><tr style="position: fixed; width: 900px;top:0;background:#EAEAEA;"><th width="13%">时间</th><th width="4%">总</th><th width="7%">付费用户</th><th width="7%">免费用户</th><th width="4%">vip</th><th width="4%">IOS</th><th width="7%">Android</th><th width="4%">PC</th><th width="6%">付费(ios)</th><th width="6%">付费(android)</th><th width="6%">付费(pc)</th><th width="5%">免费(ios)</th><th width="8%">免费(android)</th><th width="7%">免费(pc)</th></tr>');
		IsShow=1;
	}
	if(IsShow==1 && h<300){
		$('#show').html('<tr style="width: 900px;"><th width="13%">时间</th><th width="4%">总</th><th width="7%">付费用户</th><th width="7%">免费用户</th><th width="4%">vip</th><th width="4%">IOS</th><th width="7%">Android</th><th width="4%">PC</th><th width="6%">付费(ios)</th><th width="6%">付费(android)</th><th width="6%">付费(pc)</th><th width="5%">免费(ios)</th><th width="8%">免费(android)</th><th width="7%">免费(pc)</th></tr>');
		IsShow=0;
	} 
}

	
</script>
</html>