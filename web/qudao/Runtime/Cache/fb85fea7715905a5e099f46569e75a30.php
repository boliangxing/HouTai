<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <header>
                    <h2><?php echo ($name); ?>当日输赢排行<span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/User/game_win?type=1&KindID=<?php echo ($KindID); ?>"><span style="color:#2996cc;">赢</span></a></span><span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/User/game_win?type=2&KindID=<?php echo ($KindID); ?>"><span style="color:#2996cc;">输</span></a></span></h2>
                </header>           
            </article>
            <article class="expand_query">          
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>输赢</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["User"]["GameID"]); ?></a></td>
                            <td><?php echo ($vo["User"]["NickName"]); ?></td>
							<td><?php echo ($vo["win"]); ?></td>
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