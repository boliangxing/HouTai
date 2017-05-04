<?php if (!defined('THINK_PATH')) exit();?>﻿<?php  require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <div id="tabs">
                    <ul class="dd">
                        <li class="dd-item here"><div class="dd-handle "><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($rs_user['UserID']); ?>">基本信息</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo ($rs_user['UserID']); ?>">转账记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo ($rs_user['UserID']); ?>">存取记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo ($rs_user['UserID']); ?>">游戏记录(快速)</a></div></li>
						<li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx_old?UserID=<?php echo ($rs_user['UserID']); ?>">游戏记录(旧)</a></div></li>
						<li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx2?UserID=<?php echo ($rs_user['UserID']); ?>">游戏记录(详细)</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/inout?UserID=<?php echo ($rs_user['UserID']); ?>">进出记录</a></div></li>
                        <li class="dd-item back" ><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User" >返回</a></div></li>
                    </ul>
                </div>
                <div>
                     <ul class="base_info">
                        <li><span>ID号码（GameID）：</span><?php echo ($rs_user['GameID']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
 if($_SESSION['zs78_admin2']['role']==1){ echo '<a  href='.WEB_ROOT.'index.php/User/ChangePWD?UserID='.$rs_user['UserID'].'>修改密码</a>'; } ?></li>
                        <li><span>账号：</span><?php echo ($rs_user['Accounts']); ?></li>
                        <li><span>昵称：</span><?php echo ($rs_user['NickName']); ?></li>
						<?php
 if($_SESSION['zs78_admin2']['id']==18 || $_SESSION['zs78_admin2']['id']==25){ echo '<li><span>UserID：</span>'.$rs_user['UserID'].'</li>'; } ?>
                        <li><span>会员等级：</span><?php if($rs_user['MemberOrder'] == 0): ?>普通<?php else: ?><span style="color:red">vip</span><?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
 if($_SESSION['zs78_admin2']['role']<3 && $rs_user['MemberOrder']>0){ echo '<a onclick="if(confirm(\'确定删除会员?\')==false)return false;" href='.WEB_ROOT.'index.php/User/DelVip?UserID='.$rs_user['UserID'].'>删除会员</a>'; } ?></li>
                        
                        <li><span>游戏金币：</span><?php echo ($rs_gold['Score']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li><span>银行金额：</span><?php echo ($rs_gold['InsureScore']); ?></li>
                        <li><span>总金额：</span><?php echo ($rs_gold['Sum']); ?></li>
                        <li><span>当日游戏最高分：</span><a href="<?php echo WEB_ROOT?>index.php/User/GetDayTotal?UserID=<?php echo ($rs_user['UserID']); ?>">点击查看</a></li>
                        <li><span>游戏所得（总）：</span><?php echo ($rs_gold2['game_sum']); ?></li>
						<li><span>进出房间（总）：</span><a href="<?php echo WEB_ROOT?>index.php/User/GetInout?UserID=<?php echo ($rs_user['UserID']); ?>">点击查看 新玩家准确度高，游戏内存取会导致不准</a></li>
                        <li><span>五子棋+转入-转出：</span><?php echo ($rs_gold['gold_jy_sum']); ?></li>
                        <li><span>五子棋（总）：</span><?php echo ($rs_gold2['wzq_sum']); ?></li>
						<!--
                        <li><span>五子棋到vip：</span><?php echo ($day_sum['wzq_vip']); ?>&nbsp;&nbsp;&nbsp;&nbsp;五子棋到普通玩家：<?php echo ($day_sum['wzq_pt']); ?></li>
						-->
                        <li><span>转出次数：</span><?php echo ($rs_gold['zc_count']); ?></li>
                        <li><span>转出总额：</span><?php echo ($rs_gold['zc_sum']); ?></li>
                        <li><span>转出到vip：</span><?php echo ($day_sum['zc_vip']); ?>&nbsp;&nbsp;&nbsp;&nbsp;转出到普通玩家：<?php echo ($day_sum['zc_pt']); ?></li>
                        <li><span>转入次数：</span><?php echo ($rs_gold['zr_count']); ?></li>
                        <li><span>转入总额：</span><?php echo ($rs_gold['zr_sum']); ?></li>
						<li><span>vip转入：</span><?php echo ($day_sum['zr_vip']); ?>&nbsp;&nbsp;&nbsp;&nbsp;普通玩家转入：<?php echo ($day_sum['zr_pt']); ?></li>
                        <li><span>充值所得（总）：</span><?php echo ($rs_gold['pay_sum']); ?></li> 
                        <?php if(is_array($game_room)): foreach($game_room as $key=>$vo): ?><li><span>当前游戏：</span><?php echo ($vo['GameName']); ?></li>     
                            <li><span>当前房间：</span><?php echo ($vo['ServerName']); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php
 if($vo['ServerName']!=' '){ echo '<a href='.WEB_ROOT.'index.php/User/kaxian?UserID='.$rs_user['UserID'].'&ServerID='.$vo['ServerID'].'>清除卡线</a>'; } ?></li><?php endforeach; endif; ?> 
						 
                        
                        
                        <li><span>固定机器状态：</span><?php if($rs_user['MoorMachine'] == 1): ?>已锁定<?php else: ?>未锁定<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
 if($_SESSION['zs78_admin2']['role']<3&&$rs_user['MoorMachine']==1){ echo '<a onclick="if(confirm(\'确定解除锁定?\')==false)return false;" href='.WEB_ROOT.'index.php/User/jiesuo?UserID='.$rs_user['UserID'].'>解除锁定</a>'; } if($_SESSION['zs78_admin2']['role']<3&&$rs_user['MoorMachine']==0){ echo '<a onclick="if(confirm(\'确定锁定机器?\')==false)return false;" href='.WEB_ROOT.'index.php/User/suoding?UserID='.$rs_user['UserID'].'>锁定机器</a>'; } ?></li>                          
                        <li><span>当前封号状态：</span><?php if($rs_user['Nullity'] == 1): ?>封号中<?php else: ?>正常<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
 if($_SESSION['zs78_admin2']['role']<3&&$rs_user['Nullity']==1){ echo '<a onclick="if(confirm(\'确定解封?\')==false)return false;" href='.WEB_ROOT.'index.php/User/jiefeng?UserID='.$rs_user['UserID'].'>解封</a>'; } if($_SESSION['zs78_admin2']['role']<3&&$rs_user['Nullity']==0){ echo '<a style=\'padding-right:10px;\' id=\'fenghao\' onclick="if(confirm(\'确定封号?\')==false)return false;" >封号</a>原因：<input id=\'reason\' type=\'text\'>'; } ?></li>  
						<li><span>当前屏蔽登录状态：</span><?php if($rs_user['CustomFaceVer'] == 1): ?>屏蔽中<?php else: ?>正常<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<!--
                        <?php
 if($_SESSION['zs78_admin2']['role']<3&& $rs_user['CustomFaceVer']==1){ echo '<a onclick="if(confirm(\'确定解除屏蔽?\')==false)return false;" href='.WEB_ROOT.'index.php/User/jiechu?UserID='.$rs_user['UserID'].'>解除屏蔽</a>'; } if($_SESSION['zs78_admin2']['role']<3 && $rs_user['CustomFaceVer']==0){ echo '<a onclick="if(confirm(\'确定添加屏蔽?\')==false)return false;" id=\'pingbi\' >添加屏蔽</a>  原因：<input id=\'reason2\' type=\'text\'>'; } ?>
						-->
						</li>
                        <li><span>身份证号：</span><a href="<?php echo WEB_ROOT?>index.php/User/sfzList?sfz=<?php echo ($rs_user['PassPortID']); ?>"><?php echo ($rs_user['PassPortID']); ?></a></li>  
						<li><span>绑定手机：</span><?php if($rs_user['IsLockMobile'] == 1): ?>已绑定，号码为<a href="<?php echo WEB_ROOT?>index.php/User/PhoneList?p=<?php echo ($rs_user['RegisterMobile']); ?>"><?php echo $rs_user['RegisterMobile'];?></a><?php else: ?>未绑定<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
 if($_SESSION['zs78_admin2']['role']<3&&$rs_user['IsLockMobile']==1){ echo '<a onclick="if(confirm(\'确定解除手机绑定?\')==false)return false;" href='.WEB_ROOT.'index.php/User/jiebang?UserID='.$rs_user['UserID'].'>解除绑定</a>'; } ?></li> 
                        <li><span>登陆次数：</span><?php echo ($rs_user['GameLogonTimes']); ?>（大厅）&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($rs_user['WebLogonTimes']); ?>（网站）</li> 
                        <li><span>最后登陆时间：</span><?php echo ($rs_user['LastLogonDate']); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/login_record?GameID=<?php echo ($rs_user['GameID']); ?>&type=1">登录日志</a></li>
                        <li><span>注册时间：</span><?php echo ($rs_user['RegisterDate']); ?></li> 
                        <li><span>注册IP：</span><?php echo ($rs_user['RegisterIP']); ?>&nbsp;&nbsp;<?php echo ($rs_user['Re_city']['country']); ?>&nbsp;&nbsp;<?php echo ($rs_user['Re_city']['area']); ?>&nbsp;&nbsp;(a：<?php echo ($search_rs['RegisterIP_count']); ?>&nbsp;&nbsp;&nbsp;&nbsp;b：<?php echo ($search_rs['RegisterIP_sum']); ?>)</li>
                        <li><span>注册机器码：</span><?php echo ($rs_user['RegisterMachine']); ?>&nbsp;&nbsp;(a：<?php echo ($search_rs['RegisterMachine_count']); ?>&nbsp;&nbsp;&nbsp;&nbsp;b：<?php echo ($search_rs['RegisterMachine_sum']); ?>)</li>
                        <li><span>最后登陆IP：</span><?php echo ($rs_user['LastLogonIP']); ?>&nbsp;&nbsp;<?php echo ($rs_user['Logon_city']['country']); ?>&nbsp;&nbsp;<?php echo ($rs_user['Logon_city']['area']); ?>&nbsp;&nbsp;(a：<?php echo ($search_rs['LastLogonIP_count']); ?>&nbsp;&nbsp;&nbsp;&nbsp;b：<?php echo ($search_rs['LastLogonIP_sum']); ?>)</li>
                        <li><span>最后登录机器码：</span><?php echo ($rs_user['LastLogonMachine']); ?>&nbsp;&nbsp;(a：<?php echo ($search_rs['LastLogonMachine_count']); ?>&nbsp;&nbsp;&nbsp;&nbsp;b：<?php echo ($search_rs['LastLogonMachine_sum']); ?>)</a></li>
						<li><span></span>注：a表示相关账号数，b表示相关账号总金额</a></li>
                    	<li><span></span><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($rs_user['UserID']); ?>&type=1&con=<?php echo ($rs_user['RegisterIP']); ?>">查看相关账户信息</a></li>
                    </ul>
                </div>          
            </article>
        </section>
    </div>
    <footer>
<script type="text/javascript">

$('#fenghao').click(function(){ 
	var reason = $('#reason').val();
	if(reason == null || reason == ''){
		alert('原因不能为空');
		return false;
	} 	
	location.href="<?php echo WEB_ROOT?>index.php/User/fenghao?UserID=<?php echo $rs_user['UserID']?>&reason="+reason;
})
$('#pingbi').click(function(){ 
	var reason = $('#reason2').val();
	if(reason == null || reason == ''){
		alert('原因不能为空');
		return false;
	} 	
	location.href="<?php echo WEB_ROOT?>index.php/User/pingbi?UserID=<?php echo $rs_user['UserID']?>&reason="+reason;
})
$('#ck').click(function() {
    $('#xx').show();
});

	
</script>                
    </footer>
</div>  
</body>
</html>