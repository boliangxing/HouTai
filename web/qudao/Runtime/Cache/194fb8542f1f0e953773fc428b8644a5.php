<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>用户控制<span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/Index/control?type=1"><span style="color:#2996cc;">全局控制</span></a></span><span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/Index/control?type=4"><span style="color:#2996cc;">详细记录</span></a></span></h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/Index/con_search" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>           
                <div id="table_w">
				
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏名</th>
                            <th>用户ID</th>
                            <th>输赢</th>
                            <th>概率</th>
							<th>赢等级</th>
							<th>输等级</th>
                            <th>最大值</th>
                            <th>当前</th>
                            <th>操作员</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["ServerName"]); ?></td>
							<td><?php echo ($vo["ConGameID"]); ?></td>
							<td><?php if($vo['ConType'] == 2): ?>赢<?php endif; if($vo['ConType'] == 1): ?>输<?php endif; if($vo['ConType'] == 0): ?>未控制<?php endif; ?></td>
							<td><?php echo ($vo["WinPercentage"]); ?></td>
							<td><?php echo ($vo["WinLv"]); ?></td>
							<td><?php echo ($vo["LostLv"]); ?></td>
							<td><?php echo ($vo["ConMax"]); ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php echo ($vo["UpdateTime"]); ?></td>
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