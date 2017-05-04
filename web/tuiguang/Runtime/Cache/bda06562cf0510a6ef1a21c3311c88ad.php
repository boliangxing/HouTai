<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>点击ip查询</h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/tj_ip" method="GET" style='padding-left:310px;padding-top:20px'>
                    <span>ip：&nbsp;&nbsp;</span>
                        <input type="text" style='width:130px;' name="ip">
                    <input class="submit" type="submit" value="查询"></br></br>
                </form>               
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>关键词</th>
                            <th>编号</th>
                            <th>ip</th>
                            <th>地区</th>
                            <th>点击时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["Info"]); ?></td>
                            <td><?php echo ($vo["GjcID"]); ?></td>
                            <td><?php echo ($vo["IP"]); ?></td>
                            <td><?php echo ($vo["Area"]); ?></td>
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