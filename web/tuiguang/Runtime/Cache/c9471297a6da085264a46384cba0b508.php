<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>捕鱼kz记录</h2>
                </header>    
                <form action="<?php echo WEB_ROOT?>index.php/User/by_kz" method="GET">
                    <span>请输入游戏ID</span>
                    <input type="text" class="user_search_input" style="width:150px" name="GameID" value=<?php echo ($GameID); ?>>
                    <input class="user_search_submit" type="submit" value="查询">                 
                </form>       
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>游戏ID</th>
                            <th>kz类型</th>
                            <th>比例</th>
                            <th>最大值</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>记录类型</th>
                            <th>设置时间</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["GameID"]); ?></td>
							<td><?php if($vo['ManageType'] == -1): ?>收<?php else: ?>放<?php endif; ?></td>
                            <td><?php echo ($vo["ManageRate"]); ?></td>
                            <td><?php echo ($vo["ManageScore"]); ?></td>
							<td><?php echo ($vo["StartDate"]); ?></td>
							<td><?php echo ($vo["EndDate"]); ?></td>
                            <td><?php if($vo['Type'] == 1): ?>添加<?php else: ?>删除<?php endif; ?></td>
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