<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2 style='font-size:16px'>0328维护后登录记录<span style='padding-left: 50px;'><a href="<?php echo WEB_ROOT?>index.php/User/login_record_old" style='color:#2996cc'>0328维护后前登录记录</a></span></h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/login_record" method="GET" style="padding: 15px 230px">
                    <select name="type">
                        <option value="1">大厅</option>
                        <option value="2">游戏房间</option>
                        <option value="3">所有</option>
                    </select>
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>登录IP</th>
                            <th>登录机器码</th>
                            <th>登录方式</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["NickName"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=3&con=<?php echo ($vo["IP"]); ?>" target="_blank"><?php echo ($vo["IP"]); ?></a></br>(<?php echo ($vo['Re_city']['country']); echo ($vo['Re_city']['area']); ?>)</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=4&con=<?php echo ($vo["Machine"]); ?>" target="_blank"><?php echo ($vo["Machine"]); ?></a></td>
                            <td><?php if($vo['loginFrom'] == 1): ?>IOS<?php endif; if($vo['loginFrom'] == 2): ?>ANDROID<?php endif; if($vo['loginFrom'] == 3): ?>PC<?php endif; ?></td>
                            <td><?php echo ($vo["InsertTime"]); ?></td>
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