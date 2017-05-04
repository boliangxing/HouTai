<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>有效用户点击</h2>
                </header>      
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
							<th>昵称</th>
                            <th>充值金额</th>
                            <th>是否付费</th>
                            <th>关键词</th>
                            <th>注册IP</th>
                            <th>地区</th>
                            <th>访问时间</th>      
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["GameID"]); ?></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php if($vo["Rechange"] == 0 ): echo ($vo["Rechange"]); ?>
                                <?php else: ?><span style="color:red"><?php echo ($vo["Rechange"]); ?></span><?php endif; ?></td>
                            <td><?php if($vo["IsFF"] == 1 ): ?><span style="color:red">是</span>
                                <?php else: ?>否<?php endif; ?></td>
                            <td><?php echo ($vo["Info"]); ?></td>
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