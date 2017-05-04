<?php if (!defined('THINK_PATH')) exit();?>﻿<?php  require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>充值记录</h2>
                </header>           
				<form action="<?php echo WEB_ROOT?>index.php/User/cz_search" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>
                <div id="table_w">
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
                            <th>充值时间</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/order_search?type=1&OrderID=<?php echo ($vo["GameID"]); ?>" target="_blank"><?php echo ($vo["Accounts"]); ?></a></td>
							<td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["OrderID"]); ?></td>
                            <td><?php echo ($vo["PayAmount"]); ?></td>
                            <td><?php echo ($vo["BeforeGold"]); ?></td>
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