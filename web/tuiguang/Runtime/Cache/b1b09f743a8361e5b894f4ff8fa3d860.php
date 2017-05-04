<?php if (!defined('THINK_PATH')) exit();?>﻿<?php  require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>喇叭查询</h2>
                </header>           
                <form action="<?php echo WEB_ROOT?>index.php/User/Lb_search" method="GET">
                    <span>请输入游戏ID：</span>
                    <input type="text" class="user_search_input" style="width:150px" name="GameID" value='<?php echo ($GameID); ?>'>
                    <input class="user_search_submit" type="submit" value="查询">                 
                </form>
                <?php if($GameID > 0): ?><span style='padding-left:20px;'>该ID剩余喇叭数量：大喇叭<?php echo ($dlb); ?>个，小喇叭<?php echo ($xlb); ?>个</span><?php endif; ?>
                 
                <div id="table_w" style='padding-top:10px;'>
                  <span style='padding-left:20px;'>最近50条发送记录</span>  
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>喇叭类型</th>
                            <th>内容</th>
                            <th>时间</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs2)): foreach($rs2 as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/order_search?type=1&OrderID=<?php echo ($vo["GameID"]); ?>" target="_blank"><?php echo ($vo["Accounts"]); ?></a></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php if($vo['PropID'] == 19): ?>小喇叭<?php endif; ?>
                                <?php if($vo['PropID'] == 20): ?>大喇叭<?php endif; ?></td>
                            <td><?php echo ($vo["Info"]); ?></td>
                            <td><?php echo ($vo["InsertTime"]); ?></td>
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