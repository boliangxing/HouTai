<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>捕鱼当日房间损耗</h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/by_room" method="GET">
                    <span style="margin-left:60px;">查询日期&nbsp;&nbsp;</span>
                    <input name="date" type="text" class="datepick" value="<?php echo ($date); ?>">
                    <input class="submit" type="submit" value="查询"></br></br>
                    <span style='padding-left:40px;'>当日总：<?php echo ($total); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;所有总：<?php echo ($total_all); ?></span>
                </form>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>房间名</th>
                            <th>损耗</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["ServerName"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
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