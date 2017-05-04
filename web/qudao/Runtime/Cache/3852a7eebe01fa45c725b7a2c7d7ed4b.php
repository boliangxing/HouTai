<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>今日新注册付费 &nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/new_cz">新注册充值</a></h2>
                </header>           
                <div id="table">
                <table id="num">
                    <thead>
                        <tr>
							<th>序号</th>
                            <th>GameID</th>
                            <th>帐号</th>
                            <th>昵称</th>
                            <th>身份证</th>
                            <th>最后登录IP</th>
                            <th>最后登录机器码</th>
                            <th>注册时间</th>

                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php if($vo["UserMedal"] == 1 ): ?><span style="color:#cc00ff">★</span><?php endif; if($vo["LockMobileFrom"] == 1 ): ?><span style="color:blue">♥</span><?php endif; if($vo["LockMobileFrom"] == 2 ): ?><span style="color:blue">♥♥</span><?php endif; if($vo["LockMobileFrom"] == 3 ): ?><span style="color:red">♥♥</span><?php endif; if($vo["IsOpenTokenLock"] == 1 ): ?><span style="color:red">★</span><?php endif; if($vo["CustomID"] == 0 ): ?><span style="color:#7b09d2"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/sfzList?sfz=<?php echo ($vo["PassPortID"]); ?>" target="_blank"><?php echo ($vo["PassPortID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=3&con=<?php echo ($vo["LastLogonIP"]); ?>" target="_blank"><?php echo ($vo["LastLogonIP"]); ?></a></br>(<?php echo ($vo['Login_city']['country']); echo ($vo['Login_city']['area']); ?>)</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=4&con=<?php echo ($vo["LastLogonMachine"]); ?>" target="_blank"><?php echo ($vo["LastLogonMachine"]); ?></a></td>
                            <td><?php echo ($vo["RegisterDate"]); ?></td>
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