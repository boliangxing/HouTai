<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>推广注册帐号</h2>
                </header>
				<form action="<?php echo WEB_ROOT?>index.php/User/tj_reguser" method="GET" style='padding:20px 80px;'>
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
<span style='padding-left20px;'>时间段：<?php echo ($start_date); ?>&nbsp;&nbsp;--&nbsp;&nbsp;<?php echo ($end_date); ?>&nbsp;&nbsp;充值用户数:&nbsp;&nbsp;<?php echo ($cz_count); ?>&nbsp;&nbsp;充值总金额:&nbsp;&nbsp;<?php echo ($cz_num); ?>&nbsp;&nbsp;付费用户数量:&nbsp;&nbsp;<?php echo ($ff_num); ?>&nbsp;&nbsp;有效用户:&nbsp;&nbsp;<?php echo ($yx); ?></br>&nbsp;&nbsp;<span style="color:red">*</span>充值用户为有通过官方充值的用户，付费用户为有从vip玩家转入的用户，有效用户指的是充值或付费的玩家</span>              
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>帐号</th>
                            <th>昵称</th>
                            <th>注册IP</th>
							<th>注册机器码</th>
                            <th>充值金额</th>
                            <th>是否付费</th>
                            <th>身上金币</th>
                            <th>保险箱</th>
                            <th>注册时间</th>    
							<th>最后登录时间</th>  
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["GameID"]); ?></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php if($vo["red"] == 0 ): echo ($vo["NickName"]); ?>
                                <?php else: ?><span style="color:red"><?php echo ($vo["NickName"]); ?></span><?php endif; ?></td>
                            <td><?php echo ($vo["RegisterIP"]); ?>(<span style='color:red'><?php echo ($vo["IP_C"]); ?></span>)</td>
							<td><?php echo ($vo["RegisterMachine"]); ?>(<span style='color:red'><?php echo ($vo["MAC_C"]); ?></span>)</td>
                            <td><?php if($vo["Rechange"] == 0 ): echo ($vo["Rechange"]); ?>
                                <?php else: ?><span style="color:red"><?php echo ($vo["Rechange"]); ?></span><?php endif; ?></td>
                            <td><?php if($vo["IsFF"] == 1 ): ?><span style="color:red">是</span>
                                <?php else: ?>否<?php endif; ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
                            <td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php echo ($vo["InsertDate"]); ?></td>
							<td><?php echo ($vo["LastlogonDate"]); ?></td>
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