<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>当前游戏（vip）<span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=1"><span style="color:#2996cc;">当前游戏（普通）</span></a></span></h2>
                </header>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>游戏房间</th>
                            <th>身上金币</th>
                            <th>银行</th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=2&order=1">总</a></th>
							<th>登录方式</th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=2&order=2">时间</a></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["ServerName"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php echo ($vo["Total"]); ?></td>
							<td><?php if($vo['LockMobileKindID'] == 1): ?>IOS<?php endif; if($vo['LockMobileKindID'] == 2): ?>ANDROID<?php endif; if($vo['LockMobileKindID'] == 3): ?>PC<?php endif; if($vo['LockMobileKindID'] == 0): ?>PC<?php endif; ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
   
<script type="text/javascript">

setTimeout("self.location.reload();",60000);
	
</script>
</div>  
</body>
</html>