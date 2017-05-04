<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="cx_form">
			<form action="<?php echo WEB_ROOT?>index.php/User/un_game" method="GET">
					<span style="margin-left:100px;">GameID&nbsp;&nbsp;</span>
					<input name="GameID" type="text" value="<?php echo ($GameID); ?>">
                    <span style="margin-left:20px;">查询日期&nbsp;&nbsp;</span>
					<input name="date" type="text" class="datepick" value="<?php echo ($date); ?>">
					<input class="submit" type="submit" value="查询">
                </form>
                <header>
                    <h2>当日vip转入游戏局数小于20</h2>
                </header>           
            </article>
            <article class="expand_query">          
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>vip帐号</th>
                            <th>玩家昵称</th>
                            <th>金额</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><span style='color:red'><?php echo ($vo["NickName1"]); ?></span></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["NickName2"]); ?></a></td>
                            <td><?php echo ($vo["SwapScore"]); ?></td>
							<td><?php echo ($vo["CollectDate"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          
			<h2>当日无游戏记录</h2>
			<article class="expand_query">          
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>vip帐号</th>
                            <th>玩家昵称</th>
                            <th>金额</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result2)): foreach($result2 as $key=>$vo): ?><tr>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><span style='color:red'><?php echo ($vo["NickName1"]); ?></span></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["NickName2"]); ?></a></td>
                            <td><?php echo ($vo["SwapScore"]); ?></td>
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