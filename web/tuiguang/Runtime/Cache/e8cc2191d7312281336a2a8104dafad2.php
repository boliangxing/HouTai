<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>新注册用户</h2>
                </header>           
                <div id="table">
                <table id="num">
                    <thead>
                        <tr>
                            <th>GameID</th>
                            <th>帐号</th>
                            <th>昵称</th>
							<th>手机号</th>
                            <th>身份证</th>
							<th>注册方式</th>
                            <th>注册IP</th>
                            <th>注册机器码</th>
                            <th>最后登录IP</th>
                            <th>最后登录机器码</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/PhoneList?p=<?php echo ($vo["RegisterMobile"]); ?>" target="_blank"><?php echo ($vo["RegisterMobile"]); ?></a></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/sfzList?sfz=<?php echo ($vo["PassPortID"]); ?>" target="_blank"><?php echo ($vo["PassPortID"]); ?></a></td>
							<td><?php if($vo["RegisterFrom"] == 1 ): ?>IOS<?php endif; if($vo["RegisterFrom"] == 2 ): ?>Android<?php endif; if($vo["RegisterFrom"] == 3 ): ?>PC<?php endif; if($vo["RegisterFrom"] == 6 ): ?>游客<?php endif; if($vo["RegisterFrom"] == 7 ): ?>推广<?php endif; if($vo["RegisterFrom"] == 8 ): ?>微信<?php endif; if($vo["RegisterFrom"] > 100 ): ?>IOS<?php endif; ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=1&con=<?php echo ($vo["RegisterIP"]); ?>" target="_blank"><?php echo ($vo["RegisterIP"]); ?></a></br>(<?php echo ($vo['Re_city']['country']); echo ($vo['Re_city']['area']); ?>)</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=2&con=<?php echo ($vo["RegisterMachine"]); ?>" target="_blank"><?php echo ($vo["RegisterMachine"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=3&con=<?php echo ($vo["LastLogonIP"]); ?>" target="_blank"><?php echo ($vo["LastLogonIP"]); ?></a></br>(<?php echo ($vo['Login_city']['country']); echo ($vo['Login_city']['area']); ?>)</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=4&con=<?php echo ($vo["LastLogonMachine"]); ?>" target="_blank"><?php echo ($vo["LastLogonMachine"]); ?></a></td>
                            <td><?php echo ($vo["RegisterDate"]); ?></td>
                            <td><?php if($vo["CustomFaceVer"] == 1 ): ?>已屏蔽<?php endif; if($vo["CustomFaceVer"] == 0 ): ?><span class='pb' name='<?php echo ($vo["UserID"]); ?>' style="color: #2996cc;cursor: pointer;">屏蔽</span><?php endif; ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
</div>  
</body>
<script type="text/javascript">
    $(".pb").click(function(){
        var a=$(this).attr('name');
        alert(a);
        $.get("zcpb?UserID="+a);
        alert(1);
});
</script>
</html>