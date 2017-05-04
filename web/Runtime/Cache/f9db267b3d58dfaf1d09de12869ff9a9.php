<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
				<header>
                    <h2>zzl转账&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/cz_zzl">zzl充值</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/newUser_zzl">zzl新注册</a></h2>
                </header>    
					<form action="<?php echo WEB_ROOT?>index.php/User/zz_zzl" method="GET" style="padding:15px 198px 0">
                        <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" class="datepick" name="start_date" value="<?php echo ($start_date); ?>">&nbsp;-
                        <input type="text" class="datepick" name="end_date" value="<?php echo ($end_date); ?>">&nbsp;&nbsp;
                        <input class="querybutton" type="submit" id="date_submit" value="查询">                    
                    </form>				
                <div id="table_w">
				<span style='padding-left:20px;line-height:40px;'>转账总：<?php echo ($sum); ?> &nbsp;&nbsp;&nbsp;&nbsp;  转账人数：<?php echo ($usercount); ?></span>
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>转账时间</th>
                            <th>支付人ID</th>
                            <th>支付人</th>
							<th>支付人注册时间</th>
                            <th>接收人ID</th>
                            <th>接收人</th>
							<th>接收人注册时间</th>
                            <th>支付金额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["GameID1"]); ?></a></td>
                            <td><?php if($vo['RegisterFrom1'] == 5 or $vo['RegisterFrom1'] == 15): ?><span style='color:red'>⑤</span><?php endif; if($vo['MemberOrder1'] > 0): ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><span style="color:red"><?php echo ($vo["NickName1"]); ?></span></a></span><?php else: ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["NickName1"]); ?></a><?php endif; ?></td>
							<td><?php echo ($vo["RegisterDate1"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["GameID2"]); ?></a></td>
                            <td><?php if($vo['RegisterFrom2'] == 5 or $vo['RegisterFrom2'] == 15): ?><span style='color:red'>⑤</span><?php endif; if($vo['MemberOrder2'] > 0): ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><span style="color:red"><?php echo ($vo["NickName2"]); ?></span></a><?php else: ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["NickName2"]); ?></a><?php endif; ?></td>
							<td><?php echo ($vo["RegisterDate2"]); ?></td>
                            <td><?php if($vo['color'] == 1): echo ($vo["SwapScore"]); endif; if($vo['color'] == 2): ?><span style='color:#9900cc'><?php echo ($vo["SwapScore"]); ?></span><?php endif; if($vo['color'] == 3): ?><span style='color:#3300ff'><?php echo ($vo["SwapScore"]); ?></span><?php endif; ?></td>
							<?php if($type==3){echo '<td><a href=\"'.WEB_ROOT.'index.php/User/pb_one?id1='.$vo['TargetUserID'].'&id2='.$vo['SourceUserID'].'>点击屏蔽</a></td>';}?>
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