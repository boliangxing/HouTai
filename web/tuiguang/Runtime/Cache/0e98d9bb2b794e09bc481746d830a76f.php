<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>下载记录</h2>
                </header>
<form action="<?php echo WEB_ROOT?>index.php/User/GjcDlRecord2" method="GET" style='padding:20px 80px;'>
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
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
							<th>ID</th>
							<th>关键词</th>
                            <th>IP</th>
                            <th>地区</th>
                            <th>时间</th>                          
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><?php echo ($vo["GjcID"]); ?></td>
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