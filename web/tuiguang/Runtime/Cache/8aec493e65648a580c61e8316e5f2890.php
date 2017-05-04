<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="addM">
                <header>
                    <h2>记录查询</h2>
                </header>           
                <form action="<?php echo WEB_ROOT?>index.php/User/jqcx" method="GET">
                    <span>GameID：</span>
                    <input type="text" name="GameID" value="<?php echo ($GameID); ?>">
                    <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" style='width:150px;' name="start_date" value="<?php echo ($start_date); ?>">--
                        <input type="text" style='width:150px;' name="end_date" value="<?php echo ($end_date); ?>">
                    <input class="add_submit" type="submit" value="查询">             
                </form>
                
            </article>
            <article class="giveinfo">
                <header>
                    <h2>查询结果</h2>
                </header>
                <div id="table_w">
                    <span style='padding-left:500px;'>总输赢：<?php echo ($total); ?></span>
                    <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏ID</th>
                            <th>昵称</th>
                            <th>游戏</th>
                            <th>桌子编号</th>
                            <th>椅子编号</th>
                            <th>输赢</th>
                            <th>记录时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["GameID"]); ?></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php echo ($vo["KindName"]); ?>-<?php echo ($vo["ServerName"]); ?></td>
                            <td><?php echo ($vo["TableID"]); ?></td>
                            <td><?php echo ($vo["ChairID"]); ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
                            <td><?php echo ($vo["InsertTime"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
    <footer>
                    
    </footer>
</div>  
</body>
</html>