<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp" style="width:1200px;margin:10 auto;">
            <article class="expand_query" style="width:1200px;margin:10 auto;">
                <header>
                    <h2>数据统计</h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/index" method="GET">
					<span>日期：&nbsp;&nbsp;</span>
                        <input type="text" class="datepick" name="date" value=<?php echo ($date); ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 	
					<input class="user_search_submit" type="submit" value="查询">					
				</form>           
                <div id="table_w">
					<table id="num">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>下载</th>
                            <th>注册</th>
							<th>充值用户数</th>
                            <th>充值</th>
                            <th>留存</th>
                            <th>ARPU值</th>
                            <th>当日活跃用户</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo ($date); ?></td>
							<td><?php echo ($rs["open_num"]); ?></td>
                            <td><?php echo ($rs["reg_num"]); ?></td>
							<td><?php echo ($rs["charge_user"]); ?></td>
							<td><?php echo ($rs["charge_num"]); ?></td>
                            <td><?php echo ($rs["lc_num"]); ?></td>
                            <td><?php echo ($rs["ARPU"]); ?></td>
                            <td><?php echo ($rs["huoyue_num"]); ?></td>
                        </tr>
                    </tbody>
                    
                </table>
                
                </div>
            </article>          

        </section>
    </div>
</div>  
</body>
</html>