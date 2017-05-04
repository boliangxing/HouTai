<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>最近200条离开记录</h2>
                </header>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>游戏房间</th>
							<th>登录方式</th>
                            <th>离开时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["ServerName"]); ?></td>
							<td><?php if($vo['LockMobileKindID'] == 1): ?>IOS<?php endif; if($vo['LockMobileKindID'] == 2): ?>ANDROID<?php endif; if($vo['LockMobileKindID'] == 3): ?>PC<?php endif; if($vo['LockMobileKindID'] == 0): ?>PC<?php endif; ?></td>
                            <td><?php echo ($vo["LeaveTime"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
<script type="text/javascript">
</script>
</div>  
</body>
</html>