<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>抽奖记录查询</h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/cj" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID" value="<?php echo ($GameID); ?>">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>扣除</th>
                            <th>得到</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><?php echo ($vo["cost"]); ?></td>
							<td><?php echo ($vo["win"]); ?></td>
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