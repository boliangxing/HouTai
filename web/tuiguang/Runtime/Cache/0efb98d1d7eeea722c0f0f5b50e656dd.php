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
				<span style='padding-left:100px;line-height:50px;'>ID:<?php echo ($QdID); ?>&nbsp;&nbsp;&nbsp;&nbsp;分成金额:<?php echo ($row["charge_num"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;次日留存:<?php echo ($row["lc_num"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;七日留存:<?php echo ($row["lc7_num"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;总活跃用户:<?php echo ($row["huoyue_num"]); ?></span>
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>分成金额</th>
                            <th>次日留存</th>
                            <th>七日留存</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["InsertDate"]); ?></td>
							<td><?php echo ($vo["ChargeNum"]); ?></td>
                            <td><?php echo ($vo["Lc1"]); ?></td>
							<td><?php echo ($vo["Lc7"]); ?></td>
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