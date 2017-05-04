<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>相同绑定手机号</h2>
                </header>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>会员等级</th>
                            <th>身上金币</th>
                            <th>银行</th>
                            <th>封号状况</th>
                            <th>屏蔽状况</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php if($vo["MemberOrder"] == 0): ?>普通<?php else: ?>vip<?php endif; ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php if($vo["Nullity"] == 0): ?>正常<?php else: ?><span style="red">封号中</span><?php endif; ?></td>
                            <td><?php if($vo["CustomFaceVer"] == 0): ?>正常<?php else: ?><span style="red">屏蔽中</span><?php endif; ?></td>
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