<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>当前游戏（所有）<span style='padding-left:310px;'>在线金币总:<?php echo ($score_sum); ?> <br>付费用户:<?php echo ($user_ff); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;免费用户:<?php echo ($user_mf); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总在线人数:<?php echo ($count_online); ?></br>付费(ios:<?php echo ($user_login['ios']); ?>&nbsp;&nbsp;android:<?php echo ($user_login['android']); ?>&nbsp;&nbsp;pc:<?php echo ($user_login['pc']); ?>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;免费(ios:<?php echo ($user_login_mf['ios']); ?>&nbsp;&nbsp;android:<?php echo ($user_login_mf['android']); ?>&nbsp;&nbsp;pc:<?php echo ($user_login_mf['pc']); ?>&nbsp;&nbsp;)</span></h2>
                </header>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>游戏房间</th>
							<th>总</th>
                            <th>游戏</th>
                            <th>银行</th>
							<th>登录方式</th>
							<th>版本号</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php if($vo["ProtectID"] == 1 ): ?><span style="color:red"><?php echo ($vo["no"]); ?></span>
                                <?php else: echo ($vo["no"]); endif; ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php if($vo["UserMedal"] == 1 ): ?><span style="color:#cc00ff">★</span><?php endif; if($vo["LockMobileFrom"] == 1 ): ?><span style="color:blue">♥</span><?php endif; if($vo["LockMobileFrom"] == 2 ): ?><span style="color:blue">♥♥</span><?php endif; if($vo["LockMobileFrom"] == 3 ): ?><span style="color:red">♥♥</span><?php endif; if($vo["IsOpenTokenLock"] == 1 ): ?><span style="color:red">★</span><?php endif; if($vo["nozz"] == 0 ): ?><span style="color:#7b09d2"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
							<td><?php if($vo["is_gjf"] == 1 ): ?><span style="color:red"><?php echo ($vo["ServerName"]); ?></span>
                                <?php else: echo ($vo["ServerName"]); endif; ?></td>
							<td><?php echo ($vo["Total"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><?php if($vo['LockMobileKindID'] == 1): ?>IOS<?php endif; if($vo['LockMobileKindID'] == 2): ?>ANDROID<?php endif; if($vo['LockMobileKindID'] == 3): ?>PC<?php endif; if($vo['LockMobileKindID'] == 0): ?>PC<?php endif; ?></td>
                            <td><?php echo ($vo["SerialNumber"]); ?></td>
							<td><?php echo ($vo["CollectDate"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
				<div>注：红色<span style="color:red">★</span>代表该号关联号超过10个，紫色<span style="color:#cc00ff">★</span>代表该号最后登录机器码关联号只有一个，蓝色<span style="color:blue">♥</span>代表该号有过官方充值记录，两个蓝色<span style="color:blue">♥</span>代表该号充值单笔超过100,两个红色<span style="color:red">♥</span>代表该号属于appstore充值用户</div>
            </article>          

        </section>
    </div>
<script type="text/javascript">

</script>
</div>  
</body>
</html>