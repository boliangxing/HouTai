<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="user_info">
                <header>
                    <h2>转账查询</h2>
                </header>           
                <form method="GET" action="<?php echo WEB_ROOT?>index.php/Vip/vip_ytj_s" style='padding-top:10px;padding-left:150px;' >
                    <span>起止日期：&nbsp;&nbsp;</span>
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                    <input type="text" style='height:24px;width:100px;' class="datepick" name="end_date" value=<?php echo ($end_date); ?>>
                    &nbsp;&nbsp;&nbsp;&nbsp;GameID：<input class="user_search_input" type="text" name="GameID" value=<?php echo ($result['GameID']); ?>>
                    <input class="user_search_submit" type="submit" value="查询">                                 
                </form>
            </article>
			<article class="cx_form">
                <div style="padding-left:300px;padding-top:30px;">
                    <p>帐号：<?php echo ($result['Accounts']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;昵称：<?php echo ($result['NickName']); ?></p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>次数</th>
                            <th>总数</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>转出</td>
                            <td><?php echo ($rs['zc_count']); ?></td>
                            <td><?php echo ($rs['zc_num']); ?></td>
                        </tr>
                        <tr>
                            <td>转入</td>
                            <td><?php echo ($rs['zr_count']); ?></td>
                            <td><?php echo ($rs['zr_num']); ?></td>
                        </tr>
                        <tr>
                            <td>转出到普通</td>
                            <td><?php echo ($rs['zc_pt_count']); ?></td>
                            <td><?php echo ($rs['zc_pt_num']); ?></td>
                        </tr>
                        <tr>
                            <td>转出到vip</td>
                            <td><?php echo ($rs['zc_vip_count']); ?></td>
                            <td><?php echo ($rs['zc_vip_num']); ?></td>
                        </tr>
                        <tr>
                            <td>vip转入</td>
                            <td><?php echo ($rs['vip_zr_count']); ?></td>
                            <td><?php echo ($rs['vip_zr_num']); ?></td>
                        </tr>
                        <tr>
                            <td>普通转入</td>
                            <td><?php echo ($rs['pt_zr_count']); ?></td>
                            <td><?php echo ($rs['pt_zr_num']); ?></td>
                        </tr>
                        <tr>
                            <td>合计</td>
                            <td><?php echo ($rs['count']); ?></td>
                            <td><?php echo ($rs['num']); ?></td>
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