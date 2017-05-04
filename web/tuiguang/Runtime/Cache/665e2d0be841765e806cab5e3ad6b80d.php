<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>
  日常数据报表&nbsp;&nbsp;&nbsp;&nbsp;

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
        <form action="" method="POST" style="padding:15px 198px 0">
                        <span>请选择渠道:&nbsp;&nbsp;</span>

                        <select data-placeholder="请选择渠道参数" id='typeid' name="typeid">
                          <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1037", $qdid)){ ?>
                          <option value="1037">疯狂捕鱼-打鱼达人最爱的千炮猎鱼电玩城  1037</option>
                          <?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3032", $qdid)){ ?>
                          <option value="3032">万炮捕鱼-打鱼达人天天玩的疯狂捕鱼机   3032</option>
                           <?php } ?>
                             <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3034", $qdid)){ ?>
                          <option value="3034">疯狂捕鱼-超级棋牌玩家最爱的自由交易游戏   3034</option>
                          <?php } ?>
  <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3035", $qdid)){ ?>
                          <option value="3035">捕鱼大富豪-达人最爱的经典电玩城自由上下分    3035</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3033", $qdid)){ ?>
                          <option value="3033">真人炸金花-棋牌土豪天天玩的经典下分诈金花    3033</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3031", $qdid)){ ?>
                          <option value="3031">疯狂炸金花-赢三张金三顺欢乐棋牌天地    3031</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3130", $qdid)){ ?>
                          <option value="3130">疯狂斗牛牛-全民掌上棋牌游戏休闲扑克   3130</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3039", $qdid)){ ?>
                           <option value="3039">火拼牛牛-    3039</option>
<?php } ?>
                             <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3036", $qdid)){ ?>
                          <option value="3036">斗地主 欢乐斗地主 单机版-经典升级游戏免费休闲棋牌     3039</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3037", $qdid)){ ?>
                          <option value="3037">金牌斗地主-   3037</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3037", $qdid)){ ?>
                          <option value="3038">欢乐街机电玩城-牛牛.捕鱼.百家乐.水浒传.连环夺宝火爆澳门赌场下分版自由交易游戏   3038</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("3040", $qdid)){ ?>
                          <option value="3040">超级大富豪电玩城-  3040</option>
<?php } ?>
                            <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1024", $qdid)){ ?>
                   <option value="1024">全民炸金花   1024</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1025", $qdid)){ ?>
                   <option value="1025">欢乐炸金花   1025</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1026", $qdid)){ ?>
                   <option value="1026">天天炸金花   1026</option>
<?php } ?>
  <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1027", $qdid)){ ?>
                   <option value="1027">万人炸金花  1027</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1028", $qdid)){ ?>
                   <option value="1028">火拼牛牛   1028</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1029", $qdid)){ ?>
                   <option value="1029">疯狂斗牛    1029</option>
                   <?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1030", $qdid)){ ?>
                   <option value="1030">开心斗牛    1030</option>
                   <?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1031", $qdid)){ ?>
                    <option value="1031">天天斗牛   1031</option>
                    <?php } ?>
                      <?php $qdid = explode(',',$_SESSION['zs78_admin2']['qudao']); if(in_array("1032", $qdid)){ ?>

                   <option value="1032">欢乐开心斗地主   1032</option>
                   <?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1033", $qdid)){ ?>
                   <option value="1033">斗地主欢乐版    1033</option>
                   <?php } ?>

                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1034", $qdid)){ ?>
                   <option value="1034">开心斗地主    1034</option>
<?php } ?>
  <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1035", $qdid)){ ?>
                   <option value="1035">疯狂斗地主    1035</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1036", $qdid)){ ?>
                   <option value="1036">万炮捕鱼    1036</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1137", $qdid)){ ?>
                   <option value="1137">疯狂捕鱼    1137</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1038", $qdid)){ ?>
                   <option value="1038">欢乐捕鱼    1038</option>
<?php } ?>
                     <?php $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1039", $qdid)){ ?>
                   <option value="1039">全民捕鱼   1039</option>
<?php } ?>
  <?php  $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1040", $qdid)){ ?>
                   <option value="1040">开心电玩城    1040</option>
<?php } ?>
                     <?php  $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1041", $qdid)){ ?>
                   <option value="1041">欢乐电玩城      1041</option>
<?php } ?>
  <?php  $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1042", $qdid)){ ?>
                   <option value="1042">疯狂电玩城    1042</option>
<?php } ?>
                     <?php  $qdid = explode(',',$_SESSION['zs78_admin']['qudao']); if(in_array("1043", $qdid)){ ?>
                   <option value="1043">疯狂欢乐电玩城    1043</option>
<?php } ?>

                        </select>
                        <input class="querybutton" type="submit" id="date_submit"
                         value="查询">


                    </form>
                <div id="table_w">
                 <table id="num">
                    <thead>
                        <tr>
                            <th>激活设备数</th>

                            <th>注册用户数(帐号)</th>
                            <th>注册设备</th>
                            <th>活跃用户(当日登陆设备)</th>
                            <th>当日付费人数</th>
                            <th>当日付费笔数</th>
							              <th>充值金额</th>
                            <th>注册用户充值金额</th>
                            <th>注册用户付费人数</th>
                            <th>次日留存</th>
                            <th>付费用户次日留存</th>
                            <th>七日留存</th>
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
                           <td><?php echo ($vo["zcje"]); ?>(扣量后:<?php echo ($vo["kzcje"]); ?>)</td>
                           <td><?php echo ($vo["czje"]); ?>(扣量后:<?php echo ($vo["kczje"]); ?>)</td>
                           <td><?php echo ($vo["zcff_num"]); ?></td>
                           <td><?php echo ($vo["zcylc"]); ?>%(扣量后:<?php echo ($vo["kzcylc"]); ?>%)</td>
                           <td><?php echo ($vo["ffylc"]); ?>%(扣量后:<?php echo ($vo["kffylc"]); ?>%)</td>
                           <td><?php echo ($vo["qrlc"]); ?>%(扣量后:<?php echo ($vo["kqrlc"]); ?>%)</td>
                           <td><?php echo ($vo["ylc"]); ?>%(扣量后:<?php echo ($vo["kylc"]); ?>%)</td>
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