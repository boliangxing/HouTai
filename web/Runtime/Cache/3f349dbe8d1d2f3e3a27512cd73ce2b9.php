<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_info">
			<div id="tabs">
                    <ul class="dd">
                        <li class="dd-item here"><div class="dd-handle "><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($user_info['UserID']); ?>&type=1&con=<?php echo ($user_info['RegisterIP']); ?>">相同注册ip</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($user_info['UserID']); ?>&type=2&con=<?php echo ($user_info['RegisterMachine']); ?>">相同注册机器码</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($user_info['UserID']); ?>&type=3&con=<?php echo ($user_info['LastLogonIP']); ?>">相同最后登陆ip</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($user_info['UserID']); ?>&type=4&con=<?php echo ($user_info['LastLogonMachine']); ?>">相同最后登陆机器码</a></div></li>
                        <li class="dd-item back" ><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($user_info['UserID']); ?>" >返回</a></div></li>
                    </ul>
               </div>
				<div id="table_w">
				<table id="num">
					<thead>
					
						<tr>
							<th>序号</th>
							<th>游戏ID</th>
							<th>账号</th>
							<th>昵称</th>
							<th>金币</th>
							<th>银行</th>
							<th>总额</th>
							<th>屏蔽状态</th>
							<th>封号状态</th>
							<th>注册时间</th>
							<th>最后登陆时间</th>
							<th>游戏所得</th>
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
							<td><?php echo ($vo["gold_sum"]); ?></td>
							<td><?php if($vo["CustomFaceVer"] == 0): ?>正常<?php else: ?><span style="color:red">屏蔽中</span><?php endif; ?></td>
							<td><?php if($vo["Nullity"] == 0): ?>正常<?php else: ?><span style="color:red">封号中</span><?php endif; ?></td>
							<td><?php echo ($vo["RegisterDate"]); ?></td>
							<td><?php echo ($vo["LastLogonDate"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/getGameSum?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank">点击查看</a></td>
						</tr><?php endforeach; endif; ?>
					</tbody>					
				</table></div>
			</article>			
		</section>
	</div>
	<footer>
		
	</footer>
</div>	
<script type="text/javascript">


var type = getUrlParam('type');

$('#tabs li').removeClass('here');

$('#tabs li').eq(type-1).addClass('here');


//获取url参数值
function getUrlParam(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	var r = window.location.search.substr(1).match(reg);  //匹配目标参数
	if (r!=null) return unescape(r[2]); return null; //返回参数值
}
	
</script>
</body>
</html>