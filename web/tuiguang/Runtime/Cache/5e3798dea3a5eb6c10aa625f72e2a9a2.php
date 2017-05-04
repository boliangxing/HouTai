<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <div id="tabs">
                    <ul class="dd">                  
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo ($rs_gold['UserID']); ?>">转账记录</a></div></li>
                    </ul>
                </div>
                <div>
                     <ul class="base_info">
                        <li><span>ID号码（GameID）：</span><?php echo ($rs_gold['GameID']); ?></li>
                        <li><span>账号：</span><?php echo ($rs_gold['Accounts']); ?></li>
                        <li><span>昵称：</span><?php echo ($rs_gold['NickName']); ?></li>
                        <li><span>会员等级：</span><?php if($rs_gold['MemberOrder'] == 0): ?>普通<?php else: ?><span style="color:red">vip</span><?php endif; ?></li>
                        <li><span>是否机器人：</span><?php if($rs_gold['IsAndroid'] == 0): ?>否<?php else: ?>是<?php endif; ?></li>
                        <li><span>游戏金币：</span><?php echo ($rs_gold['Score']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li><span>银行金额：</span><?php echo ($rs_gold['InsureScore']); ?></li>
                        <li><span>总金额：</span><?php echo ($rs_gold['Sum']); ?></li>
                        <li><span>五子棋（总）：</span><?php echo ($rs_gold['wzq_sum']); ?></li>
                        <li><span>转出次数：</span><?php echo ($rs_gold['zc_count']); ?></li>
                        <li><span>转出总额：</span><?php echo ($rs_gold['zc_sum']); ?></li>
                        <li><span>转出到vip：</span><?php echo ($rs_gold['zc_vip']); ?>&nbsp;&nbsp;&nbsp;&nbsp;转出到普通玩家：<?php echo ($rs_gold['zc_pt']); ?></li>
                        <li><span>转入次数：</span><?php echo ($rs_gold['zr_count']); ?></li>
                        <li><span>转入总额：</span><?php echo ($rs_gold['zr_sum']); ?></li>
						<li><span>vip转入：</span><?php echo ($rs_gold['zr_vip']); ?>&nbsp;&nbsp;&nbsp;&nbsp;普通玩家转入：<?php echo ($rs_gold['zr_pt']); ?></li>
                        <li><span>充值所得（总）：</span><?php echo ($rs_gold['pay_sum']); ?></li>  
						<li><span>当前游戏：</span><?php echo ($rs_gold['ServerName']); ?></li>
                        
                        <li><span>固定机器状态：</span><?php if($rs_gold['MoorMachine'] == 1): ?>已锁定<?php else: ?>未锁定<?php endif; ?></li>                          
                        <li><span>当前封号状态：</span><?php if($rs_gold['Nullity'] == 1): ?>封号中<?php else: ?>正常<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
 if($_SESSION['zs78_admin']['role']<3&&$rs_gold['Nullity']==1){ echo '<a onclick="if(confirm(\'确定解封?\')==false)return false;" href='.WEB_ROOT.'index.php/User/jiefeng?UserID='.$rs_gold['UserID'].'>解封</a>'; } if($_SESSION['zs78_admin']['role']<3&&$rs_gold['Nullity']==0){ echo '<a style=\'padding-right:10px;\' id=\'fenghao\' onclick="if(confirm(\'确定封号?\')==false)return false;" >封号</a>原因：<input id=\'reason\' type=\'text\'>'; } ?></li>  
						<li><span>当前屏蔽登录状态：</span><?php if($rs_gold['CustomFaceVer'] == 1): ?>屏蔽中<?php else: ?>正常<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
 if($_SESSION['zs78_admin']['role']<3&& $rs_gold['CustomFaceVer']==1){ echo '<a onclick="if(confirm(\'确定解除屏蔽?\')==false)return false;" href='.WEB_ROOT.'index.php/User/jiechu?UserID='.$rs_gold['UserID'].'>解除屏蔽</a>'; } if($_SESSION['zs78_admin']['role']<3 && $rs_gold['CustomFaceVer']==0){ echo '<a onclick="if(confirm(\'确定添加屏蔽?\')==false)return false;" id=\'pingbi\' >添加屏蔽</a>  原因：<input id=\'reason2\' type=\'text\'>'; } ?></li>
                        <li><span>身份证号：</span><a href="<?php echo WEB_ROOT?>index.php/User/sfzList?sfz=<?php echo ($rs_gold['PassPortID']); ?>"><?php echo ($rs_gold['PassPortID']); ?></a></li>      
						<li><span>最后登陆IP：</span><?php echo ($rs_gold['LastLogonIP']); ?>&nbsp;&nbsp;<?php echo ($rs_gold['Logon_city']['country']); ?>&nbsp;&nbsp;<?php echo ($rs_gold['Logon_city']['area']); ?></li>
                        <li><span>最后登录机器码：</span><?php echo ($rs_gold['LastLogonMachine']); ?>&nbsp;&nbsp;(a：<?php echo ($rs_gold['la_mac_c']); ?>&nbsp;&nbsp;&nbsp;&nbsp;b：<?php echo ($rs_gold['la_mac_s']); ?>)</a></li>
						<li><span></span>注：a表示相关账号数，b表示相关账号总金额</a></li>
                    	<li><span></span><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($rs_gold['UserID']); ?>&type=4&con=<?php echo ($rs_gold['LastLogonMachine']); ?>">查看相关账户信息</a></li>
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
	location.href="<?php echo WEB_ROOT?>index.php/User/fenghao?UserID=<?php echo $rs_gold['UserID']?>&reason="+reason;
})
$('#pingbi').click(function(){ 
	var reason = $('#reason2').val();
	if(reason == null || reason == ''){
		alert('原因不能为空');
		return false;
	} 	
	location.href="<?php echo WEB_ROOT?>index.php/User/pingbi?UserID=<?php echo $rs_gold['UserID']?>&reason="+reason;
})
$('#ck').click(function() {
    $('#xx').show();
});

	
</script>                
    </footer>
</div>  
</body>
</html>