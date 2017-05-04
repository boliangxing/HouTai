<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>安卓5678推广</h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/tj_test" method="GET" style='padding:20px 80px;'>
                    <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" style='width:130px;' name="start_date" value="<?php echo ($start_date); ?>">&nbsp;-
                        <input type="text" style='width:130px;' name="end_date" value="<?php echo ($end_date); ?>">
                    <input class="submit" type="submit" value="查询"></br></br>
                </form>                 
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>版本号</th>
                            <th>打开应用数</th>
                            <th>注册用户</th>
                            <th>有效用户</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
							<td>567801</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/OpenRecord?start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($Open_c); ?></td>
                            <td><?php echo ($Reg_c); ?></td>
                            <td><?php echo ($Yx_c); ?></td>
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