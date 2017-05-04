<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>全局控制<span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/Index/control?type=3"><span style="color:#2996cc;">用户控制</span></a></span><span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/Index/control?type=4"><span style="color:#2996cc;">详细记录</span></a></span></h2>
                </header>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏</th>
                            <th>手机</th>
                            <th>概率</th>
                            <th>PC</th>
                            <th>概率</th>
                            <th>操作员账号</th>
                            <th>最后更新时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><?php echo ($vo["ServerName"]); ?></td>
							<td><?php if($vo['MobileType'] == 2): ?>赢<?php endif; if($vo['MobileType'] == 1): ?>输<?php endif; if($vo['MobileType'] == 0): ?>未控制<?php endif; ?></td>
							<td><?php echo ($vo["MobilePercentage"]); ?></td>
							<td><?php if($vo['PCType'] == 2): ?>赢<?php endif; if($vo['PCType'] == 1): ?>输<?php endif; if($vo['PCType'] == 0): ?>未控制<?php endif; ?></td>
                            <td><?php echo ($vo["PCPercentage"]); ?></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php echo ($vo["UpdateTime"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
    <footer>
                 
    </footer>
<script type="text/javascript">

</script>
</div>  
</body>
</html>