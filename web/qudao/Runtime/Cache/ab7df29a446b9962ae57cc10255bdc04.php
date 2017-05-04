<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">          
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>游戏房间</th>
                            <th>设备</th>
                            <th>当前游戏</th>
                            <th>银行</th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=1&order=1">总</a></th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=1&order=2">时间</a></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php if($vo["UserMedal"] == 1 ): ?><span style="color:#cc00ff">★</span><?php endif; if($vo["LockMobileFrom"] == 1 ): ?><span style="color:blue">♥</span><?php endif; if($vo["LockMobileFrom"] == 2 ): ?><span style="color:blue">♥♥</span><?php endif; if($vo["IsOpenTokenLock"] == 1 ): ?><span style="color:red">★</span><?php endif; if($vo["CustomID"] == 0 ): ?><span style="color:#7b09d2"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
							<td><?php echo ($vo["ServerName"]); ?></td>
                            <td><?php if($vo['LockMobileKindID'] == 1): ?>IOS<?php endif; if($vo['LockMobileKindID'] == 2): ?>ANDROID<?php endif; if($vo['LockMobileKindID'] == 3): ?>PC<?php endif; if($vo['LockMobileKindID'] == 0): ?>PC<?php endif; ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php echo ($vo["Total"]); ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
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