<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>今日当前损耗</h2>
                </header>           
                <div id="table_w1">
				<span style="padding-top:10px;">今日注册人数:<?php echo ($count); ?>&nbsp;&nbsp;&nbsp;&nbsp;增加金币数:&nbsp;<?php echo ($score); ?>&nbsp;&nbsp;&nbsp;&nbsp;今日充值增加金币:&nbsp;<?php echo ($cz_num); ?></span>
                <table id="num">
                    <thead>
                        <tr>
                            <th>日期</th>
							<th>总</th>
							<th>3D捕鱼</th>
							<th>2D捕鱼</th>
							<th>摇钱树</th>
                            <th>国际麻将</th>
                            <th>欢乐五张</th>
                            <th>欢乐斗牛</th>
                            <th>通比牛牛</th>
                            <th>二人斗牛</th>
							<th>德州扑克</th>
							<th>百人角斗场</th>
                            <th>16人两张</th>
                            <th>豪车漂移</th>
                            <th>16人小九</th>
                            <th>冠军赛马</th>
							<th>欢乐30秒</th>
                            <th>火拼双扣</th>
                            <th>温州二人麻将</th>
							<th>神兽转盘</th>
							
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo ($result["date"]); ?></td>
							<td><?php echo ($result["sum"]); ?></td>
							<td><?php echo ($result["G2060"]); ?></td>
							<td><?php echo ($result["G2070"]); ?></td>
							<td><?php echo ($result["G2075"]); ?></td>
                            <td><?php echo ($result["G10"]); ?></td>
                            <td><?php echo ($result["G19"]); ?></td>
                            <td><?php echo ($result["G27"]); ?></td>
                            <td><?php echo ($result["G28"]); ?></td>
                            <td><?php echo ($result["G102"]); ?></td>
							<td><?php echo ($result["G350"]); ?></td>
							<td><?php echo ($result["G104"]); ?></td>
                            <td><?php echo ($result["G106"]); ?></td>
                            <td><?php echo ($result["G108"]); ?></td>
                            <td><?php echo ($result["G110"]); ?></td>
                            <td><?php echo ($result["G114"]); ?></td>
							<td><?php echo ($result["G122"]); ?></td>
                            <td><?php echo ($result["G233"]); ?></td>
                            <td><?php echo ($result["G308"]); ?></td>
							<td><?php echo ($result["G404"]); ?></td>
							
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