<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
<style>
.btn{
  display: inline-block;
float: right;
border: 1px solid #d2d2d2;
border-radius: 3px;
color: #fff;
font-size: 16px;
font-weight: normal;
padding: 3px 10px;
background: #333336;
}
</style>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>渠道数据</h2>
                </header>
				<div style='padding-left:40px;margin-top:20px;line-height:30px;'>渠道帐号:<?php echo ($rs2["Username"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;ID:<?php echo ($rs2["TypeID"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;产品名称:<?php echo ($rs2["QdName"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;合作方式:<?php if($rs2["QdType"] == 0): ?>CPA<?php endif; if($rs2["QdType"] == 1): ?>CPS<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;分成比例:<?php echo ($rs2["Bili"]); ?>%&nbsp;&nbsp;&nbsp;&nbsp;单价:<?php echo ($rs2["Price"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;总金额:<a href="<?php echo WEB_ROOT?>index.php/User/QdChangeList?TypeID=<?php echo ($rs2["TypeID"]); ?>"><?php echo ($row["charge_num"]); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;渠道总分层金额:<?php echo ($fc); ?>&nbsp;&nbsp;&nbsp;&nbsp;平均次日留存:<?php echo ($lc_avg); ?>&nbsp;&nbsp;&nbsp;&nbsp;平均七日留存:<?php echo ($lc7_avg); ?>&nbsp;&nbsp;&nbsp;&nbsp;总活跃用户:<?php echo ($row["huoyue_num"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/QdRegList?TypeID=<?php echo ($rs2["TypeID"]); ?>">注册数据</a></div>
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>真注册量</th>
                            <th>排重注册量</th>
							<th>新增注册量</th>
                            <th>显示激活量</th>
							<th>真激活量</th>
							<th>单价</th>
							<th>充值用户量</th>
							<th>实际充值</th>

							<th>分层比例</th>
							<th>渠道分层金额</th>
							<th>次日留存</th>
							<th>7日留存</th>
							<th>活跃用户</th>
                        </tr>
                    </thead>
                    <tbody>
						<tr>
                            <td><?php echo ($row2["Date"]); ?></td>
							<td><?php echo ($row2["reg_num"]); ?></td>
                            <td><?php echo ($row2["reg_realnum"]); ?></td>
							<td><?php echo ($row2["new_user"]); ?></td>
							<td><?php echo ($row2["show_open"]); ?></td>
							<td><?php echo ($row2["open_num"]); ?></td>
							<td><?php echo ($rs2["Price"]); ?></td>
							<td><?php echo ($row2["charge_user"]); ?></td>
							<td><?php echo ($row2["charge_num"]); ?></td>

							<td><?php echo ($rs2["Bili"]); ?>%</td>
							<td><?php echo ($row2["show_charge"]); ?></td>
							<td><?php echo ($row2["lc_num"]); ?></td>
							<td><?php echo ($row2["lc7_num"]); ?></td>
							<td><?php echo ($row2["huoyue"]); ?></td>
                        </tr>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["InsertDate"]); ?></td>
							<td><?php echo ($vo["RegNum"]); ?></td>
                            <td><?php echo ($vo["RegRealNum"]); ?></td>
							<td><?php echo ($vo["NewUser"]); ?></td>
							<td><?php echo ($vo["OpenNum"]); ?></td>
							<td><?php echo ($vo["RealOpenNum"]); ?></td>
							<td><?php echo ($rs2["Price"]); ?></td>
							<td><?php echo ($vo["ChargeUser"]); ?></td>
							<td><?php echo ($vo["RealChargeNum"]); ?></td>

							<td><?php echo ($rs2["Bili"]); ?>%</td>
							<td><?php echo ($vo["ChargeNum"]); ?></td>
							<td><?php echo ($vo["Lc1"]); ?></td>
							<td><?php echo ($vo["Lc7"]); ?></td>
							<td><?php echo ($vo["Huoyue"]); ?></td>
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