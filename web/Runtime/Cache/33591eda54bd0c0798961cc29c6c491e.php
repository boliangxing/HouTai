<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>
扣量&nbsp;&nbsp;&nbsp;&nbsp;
<!-- <a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/getkouliang">更改扣量</a> -->


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
                            <th>渠道号</th>

                            <th>当前扣量值</th>



                        </tr>
                    </thead>
                    <tbody id='re'>
                      <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                         <td><?php echo ($vo["qdid"]); ?></td>
                         <td><?php echo ($vo["kouliang"]); ?></td>


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
<script>

var str = $("#re").html();
var str2 = str.replace(/51/g, '5678');
var str3 = str2.replace(/52/g, 'zzl');
var str4 = str3.replace(/53/g, 'uc');
$("#re").html(str4);
</script>