<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>操作记录</h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/change_search" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID" value="<?php echo ($GameID); ?>">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>操作管理员</th>
                            <th>被操作用户ID</th>
                            <th>被操作用户昵称</th>
                            <th>操作行为</th>
                            <th>原因</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["Username"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                           <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["NickName"]); ?></a></td>
							<td><?php if($vo['Type'] == 8): ?>添加屏蔽<?php endif; if($vo['Type'] == 9): ?>解除屏蔽<?php endif; if($vo['Type'] == 7): ?>清除手机绑定<?php endif; if($vo['Type'] == 5): ?>清除卡线<?php endif; if($vo['Type'] == 4): ?>解锁机器<?php endif; if($vo['Type'] == 3): ?>锁定机器<?php endif; if($vo['Type'] == 2): ?>解封<?php endif; if($vo['Type'] == 1): ?>封号<?php endif; ?></td>
                            <td><?php echo ($vo["Reason"]); ?></td>
                            <td><?php echo ($vo["InsertTime"]); ?></td>
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