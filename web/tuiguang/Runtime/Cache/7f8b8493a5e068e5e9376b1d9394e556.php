<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_info">
                <header>
                    <h2>各游戏人数</h2>
                </header>           
            </article>
			<article class="cx_form">

                <table>
                    <thead>
                        <tr>
                            <th>游戏名</th>
                            <th>人数</th>
                            <th>付费（包含充值）</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/game_win?KindID=<?php echo ($vo['KindID']); ?>" target="_blank"><?php echo ($vo["KindName"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/Online_KindID?KindID=<?php echo ($vo['KindID']); ?>" target="_blank"><?php echo ($vo["count"]); ?></a></td>
                            <td><?php echo ($vo["count_ff"]); ?></td>
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