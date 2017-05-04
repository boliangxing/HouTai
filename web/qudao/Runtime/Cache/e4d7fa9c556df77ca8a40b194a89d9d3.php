<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>下载记录</h2>
                </header>
            </br>
                <span style='padding-left20px;'>ID:<?php echo ($GjcID); ?>&nbsp;&nbsp;&nbsp;&nbsp;时间段：<?php echo ($start_date); ?>&nbsp;&nbsp;--&nbsp;&nbsp;<?php echo ($end_date); ?></span>            
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>IP</th>
                            <th>地区</th>
                            <th>时间</th>                          
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
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