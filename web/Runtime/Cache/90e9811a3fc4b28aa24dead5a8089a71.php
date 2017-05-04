<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>zzl新注册用户&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/cz_zzl">zzl充值</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/zz_zzl">zzl转账</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/userCount_zzl">zzl新注册用户统计</a></h2>
                </header>           
				<form action="<?php echo WEB_ROOT?>index.php/User/newUser_zzl" method="GET" style="padding:15px 198px 0">
                        <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" style='width:140px' name="start_date" value="<?php echo ($start_date); ?>">&nbsp;-
                        <input type="text" style='width:140px' name="end_date" value="<?php echo ($end_date); ?>">&nbsp;&nbsp;
                        <input class="querybutton" type="submit" id="date_submit" value="查询">                    
                    </form>
                <div id="table">
				<span>当前注册总数:<?php echo ($sum); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当前有效用户:<?php echo ($yx); ?>&nbsp;&nbsp;昵称为红色&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;括号内红色数字为该帐号注册时的注册ip和注册机器码的关联号数量</span>
                <table id="num">
                    <thead>
                        <tr>
							<th>序号</th>
                            <th>GameID</th>
                            <th>帐号</th>
                            <th>昵称</th>
							<th>身上</th>
                            <th>保险箱</th>
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
							<td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php if($vo["CustomID"] > 0 or $vo["LockMobileFrom"] > 0): ?><span style='color:red'><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><?php if($vo["RegisterFrom"] == 1 ): ?>IOS<?php endif; if($vo["RegisterFrom"] == 2 ): ?>Android<?php endif; if($vo["RegisterFrom"] == 3 ): ?>PC<?php endif; if($vo["RegisterFrom"] == 5 ): ?>5678捕鱼<?php endif; if($vo["RegisterFrom"] == 6 ): ?>游客<?php endif; if($vo["RegisterFrom"] == 7 ): ?>推广网页<?php endif; if($vo["RegisterFrom"] > 10 and $vo["RegisterFrom"] < 15): ?>微信登录<?php endif; if($vo["RegisterFrom"] == 15): ?>5678微信登录<?php endif; if($vo["RegisterFrom"] == 8 ): ?>微信注册<?php endif; if($vo["RegisterFrom"] > 100 ): ?>IOS<?php endif; if($vo["RegisterFrom"] == 21 ): ?>IOS<?php endif; if($vo["RegisterFrom"] == 22 ): ?>android<?php endif; if($vo["RegisterFrom"] == 23 ): ?>pc<?php endif; ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=1&con=<?php echo ($vo["RegisterIP"]); ?>" target="_blank"><?php echo ($vo["RegisterIP"]); ?></a>&nbsp;&nbsp;<span style='color:red'>(<?php echo ($vo["IP_C"]); ?>)</span></br>(<?php echo ($vo['Re_city']['country']); echo ($vo['Re_city']['area']); ?>)</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=2&con=<?php echo ($vo["RegisterMachine"]); ?>" target="_blank"><?php echo ($vo["RegisterMachine"]); ?></a>&nbsp;&nbsp;<span style='color:red'>(<?php echo ($vo["MAC_C"]); ?>)</span></td>
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
        $.get("zcpb?UserID="+a);
});
</script>
</html>