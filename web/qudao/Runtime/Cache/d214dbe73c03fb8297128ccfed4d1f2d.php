<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>当前在线3日内充值用户</h2>
                </header>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>游戏房间</th>
                            <th>游戏</th>
                            <th>银行</th>
                            <th>总</th>
							<th>充值金额总</th>
							<th>充值金币总</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php if($vo["ProtectID"] == 1 ): ?><span style="color:red"><?php echo ($vo["no"]); ?></span>
                                <?php else: echo ($vo["no"]); endif; ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["ServerName"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php echo ($vo["Total"]); ?></td>
							<td><?php echo ($vo["num"]); ?></td>
							<td><?php echo ($vo["Score_num"]); ?></td>
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