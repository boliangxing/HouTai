<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>充值未游戏</h2>
                </header>           
                <div id="table">
				<span>账号为红色时，该账号注册时注册ip和注册机器码关联号为1</span>
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>帐号</th>
                            <th>昵称</th>
                            <th>金币</th>
                            <th>银行</th>
                            <th>充值金额</th>
                            <th>转入</th>
                            <th>转出</th>
                            <th>注册IP</th>
                            <th>最后登录机器码</th>
                            <th>注册时间</th>

                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php if($vo["new"] == 1 ): ?><span style="color:red"><?php echo ($vo["Accounts"]); ?></span>
                                <?php else: echo ($vo["Accounts"]); endif; ?></td>
                            <td><?php if($vo["UserMedal"] == 1 ): ?><span style="color:#cc00ff">★</span><?php endif; if($vo["LockMobileFrom"] == 1 ): ?><span style="color:blue">♥</span><?php endif; if($vo["LockMobileFrom"] == 2 ): ?><span style="color:blue">♥♥</span><?php endif; if($vo["IsOpenTokenLock"] == 1 ): ?><span style="color:red">★</span><?php endif; if($vo["CustomID"] == 0 ): ?><span style="color:#7b09d2"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
                            <td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php echo ($vo["Rechange"]); ?></td>
                            <td><?php echo ($vo["zr"]); ?></td>
                            <td><?php echo ($vo["zc"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=1&con=<?php echo ($vo["RegisterIP"]); ?>" target="_blank"><?php echo ($vo["RegisterIP"]); ?></a></br>(<?php echo ($vo['Login_city']['country']); echo ($vo['Login_city']['area']); ?>)</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=4&con=<?php echo ($vo["LastLogonMachine"]); ?>" target="_blank"><?php echo ($vo["LastLogonMachine"]); ?></a></td>
                            <td><?php echo ($vo["InsertDate"]); ?></td>
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