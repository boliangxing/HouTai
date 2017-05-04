<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>打开记录</h2>
                </header>           

                <div id="table">
				
                <table id="num">
                    <thead>
                        <tr>
							<th>序号</th>
                            <th>IP</th>
                            <th>机器码</th>
                            <th>版本号</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["no"]); ?></td>
							<td><?php echo ($vo["IP"]); ?></br>(<?php echo ($vo['Re_city']['country']); echo ($vo['Re_city']['area']); ?>)</td>
                            <td><?php echo ($vo["Machine"]); ?></td>
							<td><?php echo ($vo["Version"]); ?></td>
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