<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
				<header>
                    <h2>最近100条转账</h2>
                </header>
                <div class="expand_query">    
                <p style="padding-left:50px;"><a href="<?php echo WEB_ROOT?>index.php/User/zz_list2?type=1">所有</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list2?type=2">vip转出</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list2?type=3">普通玩家转出</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list2?type=4">VIP转出到VIP</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list2?type=5">普通转出到VIP</a></p>      

                </div>               
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>转账时间</th>
                            <th>支付人ID</th>
                            <th>支付人</th>
							<th>IP</th>
                            <th>接收人ID</th>
                            <th>接收人</th>
							<th>IP</th>
                            <th>支付金额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["GameID1"]); ?></a></td>
                            <td><?php if($vo['MemberOrder1'] > 0): ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><span style="color:red"><?php echo ($vo["NickName1"]); ?></span></a></span><?php else: ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["NickName1"]); ?></a><?php endif; ?></td>
                            <td><?php if($vo['MemberOrder1'] == 0): echo ($vo["LastLogonIP1"]); ?></br>(<?php echo ($vo["Place1"]["country"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["Place1"]["area"]); ?>)<?php else: endif; ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["GameID2"]); ?></a></td>
                            <td><?php if($vo['MemberOrder2'] > 0): ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><span style="color:red"><?php echo ($vo["NickName2"]); ?></span></a><?php else: ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["NickName2"]); ?></a><?php endif; ?></td>
							<td><?php if($vo['MemberOrder2'] == 0): echo ($vo["LastLogonIP2"]); ?></br>(<?php echo ($vo["Place2"]["country"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["Place2"]["area"]); ?>)<?php else: endif; ?></td>
                            <td><?php if($vo['color'] == 1): echo ($vo["SwapScore"]); endif; if($vo['color'] == 2): ?><span style='color:#9900cc'><?php echo ($vo["SwapScore"]); ?></span><?php endif; if($vo['color'] == 3): ?><span style='color:#3300ff'><?php echo ($vo["SwapScore"]); ?></span><?php endif; ?></td>
							<?php if($type==3){echo '<td><a href='.WEB_ROOT.'index.php/User/pb_one?id1='.$vo['TargetUserID'].'&id2='.$vo['SourceUserID'].'>点击屏蔽</a></td>';}?>
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