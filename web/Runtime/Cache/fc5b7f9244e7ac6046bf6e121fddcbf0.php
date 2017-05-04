<?php if (!defined('THINK_PATH')) exit();?>﻿<?php  require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>zzl充值&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/newUser_zzl">zzl新注册用户</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/zz_zzl">zzl转账</a></h2>
                </header>           
				<form style='width:700px;padding:10px 100px;' action="<?php echo WEB_ROOT?>index.php/User/cz_zzl" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                        <input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>&nbsp;&nbsp;
					<input class="user_search_submit" type="submit" value="查询">					
				</form>
                <div id="table_w">
				<span style='padding-left:20px;'>总金额：<?php echo ($sum); ?></span>
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>订单号</th>
                            <th>金额</th>
                            <th>充值前金币</th>
							<th>注册时间</th>
                            <th>充值时间</th>
			
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/order_search?type=1&OrderID=<?php echo ($vo["GameID"]); ?>" target="_blank"><?php echo ($vo["Accounts"]); ?></a></td>
							<td><?php if($vo["Present"] == 1 ): ?><span style="color:#9900FF">★</span><?php endif; if($vo["RegisterFrom"] == 5 or $vo["RegisterFrom"] == 15): ?><span style="color:#9900FF">⑤</span><?php endif; if($vo["LockMobileFrom"] == 3 ): ?><span style="color:red">♥♥</span><?php endif; echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["OrderID"]); ?></td>
                            <td><?php echo ($vo["PayAmount"]); ?></td>
                            <td><?php echo ($vo["BeforeGold"]); ?></td>
							<td><?php echo ($vo["RegisterDate"]); ?></td>
                            <td><?php echo ($vo["ApplyDate"]); ?></td>
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