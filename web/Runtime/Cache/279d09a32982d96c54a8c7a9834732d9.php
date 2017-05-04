<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>
  uc报表&nbsp;&nbsp;&nbsp;&nbsp;
<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/data_zzl">zzl数据报表</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/data_5678">5678数据报表</a>
</h2>
                </header>
				<!-- <form style='width:700px;padding:10px 100px;' action="<?php echo WEB_ROOT?>index.php/User/cz_5678" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                        <input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>&nbsp;&nbsp;
					<input class="user_search_submit" type="submit" value="查询">
				</form> -->
                <div id="table_w">
                 <table id="num">
                    <thead>
                        <tr>
                            <th>激活设备数</th>
                            <th>注册用户数(帐号)</th>
                            <th>注册设备数</th>

                            <th>活跃用户(当日登陆设备)</th>
                            <th>当日付费人数</th>
                            <th>当日付费笔数</th>
							              <th>充值金额</th>
                            <th>注册用户充值金额</th>
                            <th>注册用户付费人数</th>
                            <th>激活用户次日留存</th>
                            <th>付费用户次日留存</th>
                            <th>激活用户七日留存</th>
                            <th>月留存</th>

                        </tr>
                    </thead>
                    <tbody>
                      <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>

                           <td><?php echo ($vo["jihuosb_num"]); ?></td>
                           <td><?php echo ($vo["zhuceyh_num"]); ?></td>
                           <td><?php echo ($vo["zhucesb_num"]); ?></td>
                           <td><?php echo ($vo["huoyueyh_num"]); ?></td>
                            <td><?php echo ($vo["todayfu_user"]); ?></td>
                           <td><?php echo ($vo["todayfu_num"]); ?></td>
                           <td><?php echo ($vo["czje"]); ?></td>
                           <td><?php echo ($vo["zcje"]); ?></td>
                           <td><?php echo ($vo["zcff_num"]); ?></td>
                           <td><?php echo ($vo["zcylc"]); ?>%</td>
                           <td><?php echo ($vo["ffylc"]); ?>%</td>
                           <td><?php echo ($vo["qrlc"]); ?>%</td>
                           <td><?php echo ($vo["ylc"]); ?>%</td>
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