<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="query">
				<header>
					<h2>推广查询</h2>
					<a href=""></a>
				</header>					
				<form action="<?php echo WEB_ROOT?>index.php/Index/userSearch" method="GET">
					<div class="select">
						<select  onchange="changeinput();" name="type"> 
							<option value ="1" selected="selected">推广员姓名</option>
						  	<option value ="2" >新手卡序号</option>
						</select>
					</div>								
					<div id="select_td" style="display:inline-block">
						<input type="text" name="username">
					</div>
					<div id="query_td" style="display:none;">
						<input type="text" name="start_num">&nbsp;-
						<input type="text" name="end_num">
					</div>
					<div  class="querybutton">
						<input type="submit" value="查询">
					</div>
				</form>
			</article>
			<article class="extend_list">
				<header>
					<h2>推广员列表</h2>
					<a href="<?php echo WEB_ROOT?>index.php/Index/addUserInfo">添加</a>
				</header>
				<div id="table_w">
				<table id="num" name="<?php echo ($rs['con']); ?>">
					<thead>
						<tr>
							<th>序列号</th>
							<th>推广员姓名</th>
							<th>推广地区</th>
							<th>推广类型</th>
							<th>新手卡序号</th>
							<th>激活数量</th>
							<th>在线人数</th>
							<th>充值人数</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/Index/set?id=<?php echo ($vo["id"]); ?>"><?php echo ($vo["username"]); ?></a></td>
							<td><?php echo ($vo["area"]); ?></td>
							<td><?php echo ($vo["type"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/Index/userList?id=<?php echo ($vo["id"]); ?>&count=<?php echo ($vo["count"]); ?>"><?php echo ($vo["start_num"]); ?>-<?php echo ($vo["end_num"]); ?></a></td>
							<td><?php echo ($vo["count"]); ?></td>
							<td>--</td>
							<td>--</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				</div>
			</article>
		</section>
	</div>
	<footer>
		<ol class="pagination">
			<li><a href="<?php echo WEB_ROOT?>index.php?pageNo=1" rel="next">首页</a></li>
			<li><a href="<?php echo WEB_ROOT?>index.php?pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
			<?php  for($i=1;$i<=$pageNum;$i++){?>
					
					<li class='page_no'><a href="<?php echo WEB_ROOT?>index.php?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
				
			<?php } ?>
			<li><a href="<?php echo WEB_ROOT?>index.php?pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
			<li><a href="<?php echo WEB_ROOT?>index.php?pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
			<li class="mt_2">共：<?php echo $pageNum?>页</li>
			<li>
				<input type="text" id="pages">
				<input type="button" value="go" id="go">
				
			</li>			
		</ol>	
	</footer>

</div>	
<script type="text/javascript">
$(document).ready(function(){
	var d = $('#num').attr('name');
	if(d == 'kong'){
		$('#num').html('');
		alert('查询无结果');
		location.href = "javascript:history.go(-1)";
	}
	$('#search').click(function(){
		//alert('as');
		$("#search_form").submit();
	})
	
	
})
</script>
</body>
</html>