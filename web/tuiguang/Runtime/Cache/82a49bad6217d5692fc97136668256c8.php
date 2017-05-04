<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_search">
				<header>
					<h2>进出查询</h2>
				</header>			
				<form action="<?php echo WEB_ROOT?>index.php/User/jc_search" method="GET" style="padding-left:160px;">
					<span style="padding-left:100px;">起止日期：&nbsp;&nbsp;</span>
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="end_date" value=<?php echo ($end_date); ?>></br>
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:100px" name="GameID" value=<?php echo ($GameID); ?>>
					<span>请输入游戏ID2：</span>
					<input type="text" class="user_search_input" style="width:100px" name="GameID2" value=<?php echo ($GameID2); ?>>
					<input class="user_search_submit" type="submit" value="查询">					
				</form>
			</article>
			<article class="user_info">
				<span style="padding-left:290px;"><?php echo ($NickName); ?>&nbsp;&nbsp;转出到&nbsp;&nbsp;<?php echo ($NickName2); ?>&nbsp;&nbsp;总额：<?php echo ($sum1); ?></span>
				<div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>转账时间</th>
                            <th>支付人ID</th>
                            <th>支付人</th>
                            <th>接收人ID</th>
                            <th>接收人</th>
                            <th>支付金额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($rs2)): foreach($rs2 as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($GameID); ?></a></td>
                            <td><?php if($vo['MemberOrder1'] > 0): ?><span style="color:red"><?php echo ($vo["NickName1"]); ?></span><?php else: echo ($vo["NickName1"]); endif; ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($GameID2); ?></a></td>
                            <td><?php if($vo['MemberOrder2'] > 0): ?><span style="color:red"><?php echo ($vo["NickName2"]); ?></span><?php else: echo ($vo["NickName2"]); endif; ?></td>
                            <td><?php echo ($vo["SwapScore"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div> 
			</article>	
			<article class="user_info">
				<span style="padding-left:290px;"><?php echo ($NickName2); ?>&nbsp;&nbsp;转出到&nbsp;&nbsp;<?php echo ($NickName); ?>&nbsp;&nbsp;总额：<?php echo ($sum2); ?></span>
				<div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>转账时间</th>
                            <th>支付人ID</th>
                            <th>支付人</th>
                            <th>接收人ID</th>
                            <th>接收人</th>
                            <th>支付金额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($rs3)): foreach($rs3 as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($GameID2); ?></a></td>
                            <td><?php if($vo['MemberOrder1'] > 0): ?><span style="color:red"><?php echo ($vo["NickName2"]); ?></span><?php else: echo ($vo["NickName2"]); endif; ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($GameID); ?></a></td>
                            <td><?php if($vo['MemberOrder2'] > 0): ?><span style="color:red"><?php echo ($vo["NickName1"]); ?></span><?php else: echo ($vo["NickName1"]); endif; ?></td>
                            <td><?php echo ($vo["SwapScore"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div> 
			</article>			
		</section>
	</div>
	<footer>
		
	</footer>
</div>	
</body>
</html>