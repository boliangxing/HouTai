<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>今日点击<span style='padding-left: 50px;'><a href="<?php echo WEB_ROOT?>index.php/User/tj_ip" target='_blank' style='color:#2996cc'>ip查询</a></span></h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/tj_test" method="GET" style='padding:20px 80px;'>
                    <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" style='width:130px;' name="start_date" value="<?php echo ($start_date); ?>">&nbsp;-
                        <input type="text" style='width:130px;' name="end_date" value="<?php echo ($end_date); ?>">
						<span>&nbsp;&nbsp;查看数量：&nbsp;&nbsp;</span>
                        <select name="type2">
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        </select>
                        <span>&nbsp;&nbsp;平台标识：&nbsp;&nbsp;</span>
                        <select name="type">
                        <option value='0'>0</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
                        <option value='7'>7</option>
                        <option value='8'>8</option>
						<option value='9'>9</option>
						<option value='11'>11</option>
						<option value='12'>12</option>
						<option value='13'>13</option>
						<option value='14'>14</option>
						<option value='15'>15</option>
						<option value='16'>16</option>
						<option value='17'>17</option>
						<option value='18'>18</option>
						<option value='19'>19</option>
						<option value='20'>20</option>
						<option value='21'>21</option>
						<option value='22'>22</option>
						<option value='25'>25</option>
						<option value='26'>26</option>
						<option value='27'>27</option>
						<option value='28'>28</option>
						<option value='29'>29</option>
                        </select>
                    <input class="submit" type="submit" value="查询"></br></br>
                </form>     
<span style='padding-left20px;'>时间段：<?php echo ($start_date); ?>&nbsp;&nbsp;--&nbsp;&nbsp;<?php echo ($end_date); ?>&nbsp;&nbsp;&nbsp;&nbsp;点击次数:&nbsp;&nbsp;<?php echo ($c); ?>&nbsp;&nbsp;&nbsp;&nbsp;下载次数:&nbsp;&nbsp;<a href='<?php echo WEB_ROOT?>index.php/User/GjcDlRecord2?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>'><?php echo ($xz); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;注册帐号:&nbsp;&nbsp;<a href='<?php echo WEB_ROOT?>index.php/User/tj_reguser?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>'><?php echo ($zc); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;有效用户数量:&nbsp;&nbsp;<?php echo ($yx); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo WEB_ROOT?>index.php/User/tj_user?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>'>实际用户</a></span>             
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>关键词</th>
                            <th>编号</th>
                            <th>点击数</th>
                            <th>下载数</th>
                            <th>注册用户</th>
                            <th>有效用户</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><?php if($vo["yx_c"] == 0 ): echo ($vo["Info"]); ?>
                                <?php else: ?><span style="color:red"><?php echo ($vo["Info"]); ?></span><?php endif; ?></td>
                            <td><?php echo ($vo["GjcID"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/GjcRecord?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["c"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/GjcDlRecord?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["dl_c"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/tj_zc?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["zc_c"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/tj_yx?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["yx_c"]); ?></a></td>
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