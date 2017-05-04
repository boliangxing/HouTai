<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>当前游戏（普通）<span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=2"><span style="color:#2996cc;">当前游戏（vip）</span></a></span><span style='padding-left:310px;'>在线金币总:<?php echo ($score_sum); ?> <br>付费用户:<?php echo ($user_ff); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;免费用户:<?php echo ($user_mf); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总在线人数:<?php echo ($count_online); ?></br>付费(ios:<?php echo ($user_login['ios']); ?>&nbsp;&nbsp;android:<?php echo ($user_login['android']); ?>&nbsp;&nbsp;pc:<?php echo ($user_login['pc']); ?>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;免费(ios:<?php echo ($user_login_mf['ios']); ?>&nbsp;&nbsp;android:<?php echo ($user_login_mf['android']); ?>&nbsp;&nbsp;pc:<?php echo ($user_login_mf['pc']); ?>&nbsp;&nbsp;)</br>电信：<?php echo ($dx); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;移动：<?php echo ($yd); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联通：<?php echo ($lt); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;长城宽带：<?php echo ($cc); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0000：<?php echo ($bl); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;其他：<?php echo ($qt); ?></span></h2>
                </header>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>游戏房间</th>
							<th><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=1&order=1">总</a></th>
                            <th>游戏</th>
                            <th>银行</th>
							<th>登录方式</th>
							<th><a href="<?php echo WEB_ROOT?>index.php/User/new_version">版本号</a></th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/User/online_user?type=1&order=2">时间</a></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php if($vo["ProtectID"] == 1 ): ?><span style="color:red"><?php echo ($vo["no"]); ?></span>
                                <?php else: echo ($vo["no"]); endif; ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php if($vo["UserMedal"] == 1 ): ?><span style="color:#cc00ff">★</span><?php endif; if($vo["LockMobileFrom"] == 1 ): ?><span style="color:blue">♥</span><?php endif; if($vo["LockMobileFrom"] == 2 ): ?><span style="color:blue">♥♥</span><?php endif; if($vo["LockMobileFrom"] == 3 ): ?><span style="color:red">♥♥</span><?php endif; if($vo["IsOpenTokenLock"] == 1 ): ?><span style="color:red">★</span><?php endif; if($vo["nozz"] == 0 ): ?><span style="color:#7b09d2"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?></td>
							<td><?php if($vo["is_gjf"] == 1 ): ?><span style="color:red"><?php echo ($vo["ServerName"]); ?></span>
                                <?php else: echo ($vo["ServerName"]); endif; ?></td>
							<td><?php echo ($vo["Total"]); ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><?php if($vo['LockMobileKindID'] == 1): ?>IOS<?php endif; if($vo['LockMobileKindID'] == 2): ?>ANDROID<?php endif; if($vo['LockMobileKindID'] == 3): ?>PC<?php endif; if($vo['LockMobileKindID'] == 4): ?>PC-XP<?php endif; if($vo['LockMobileKindID'] == 9): ?>老版本<?php endif; if($vo['LockMobileKindID'] == 5): ?>5678<?php endif; ?>
							<?php if($vo['LockMobileKindID'] == 21): ?>zzlIOS<?php endif; if($vo['LockMobileKindID'] == 22): ?>zzlAndroid<?php endif; if($vo['LockMobileKindID'] == 23): ?>zzlPC<?php endif; if($vo['LockMobileKindID'] == 51): ?>掌上捕鱼IOS<?php endif; if($vo['LockMobileKindID'] == 52): ?>掌上捕鱼Android<?php endif; if($vo['LockMobileKindID'] == 53): ?>掌上捕鱼PC<?php endif; ?></td>
                            <td><?php echo ($vo["SerialNumber"]); ?></td>
							<td><?php echo ($vo["CollectDate"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
				<div>注：红色<span style="color:red">★</span>代表该号关联号超过10个，紫色<span style="color:#cc00ff">★</span>代表该号最后登录机器码关联号只有一个，蓝色<span style="color:blue">♥</span>代表该号有过官方充值记录，两个蓝色<span style="color:blue">♥</span>代表该号充值单笔超过100,两个红色<span style="color:red">♥</span>代表该号属于appstore充值用户</div>
            </article>          

        </section>
    </div>
   <div id='tc2' class=<?php echo ($show); ?> style="background-color: #FFCC66;
border: 1px solid #f00;
text-align: center;
display:none;
line-height: 30px;
font-size: 12px;
font-weight: bold;
z-index:999;
bottom:0;
left:0;
margin-left:10px!important;/*FF IE7 该值为本身宽的一半 */
margin-top:-60px!important;/*FF IE7 该值为本身高的一半*/
margin-top:0px;
position:fixed!important;/* FF IE7*/
position:absolute;/*IE6*/
_top:       expression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - this.clientHeight)/2);">
<?php if(is_array($ts2)): foreach($ts2 as $key=>$vo): ?><span><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a>&nbsp;&nbsp;<?php if($vo["LoveLiness"] == 2): ?><span style="color:red"><?php echo ($vo["NickName"]); ?></span>
                                <?php else: echo ($vo["NickName"]); endif; ?>&nbsp;&nbsp;<?php echo ($vo["ServerName"]); ?></span></br><?php endforeach; endif; ?>
<span style="padding:10px;width:300px;">上线了！<a href="javascript:closeDiv()">关闭窗口</a></span>
    </div>
    <div id='tc' class=<?php echo ($show); ?> style="background-color: #FFCC66;
border: 1px solid #f00;
text-align: center;
display:none;
line-height: 30px;
font-size: 12px;
font-weight: bold;
z-index:999;
bottom:0;
right:0;
margin-left:-150px!important;/*FF IE7 该值为本身宽的一半 */
margin-top:-60px!important;/*FF IE7 该值为本身高的一半*/
margin-top:0px;
position:fixed!important;/* FF IE7*/
position:absolute;/*IE6*/
_top:       expression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - this.clientHeight)/2);">
<?php if(is_array($ts)): foreach($ts as $key=>$vo): ?><span><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a>&nbsp;&nbsp;<?php echo ($vo["NickName"]); ?>&nbsp;&nbsp;<?php echo ($vo["ServerName"]); ?></span></br><?php endforeach; endif; ?>
<span style="padding:10px;width:300px;">上线了！<a href="javascript:closeDiv()">关闭窗口</a></span>
    </div>
<script type="text/javascript">

function showDiv(){
    var show = $('#tc').attr('class');
    if(show==1){
        document.getElementById('tc').style.display='block';
    }
}
function showDiv2(){
    var show = $('#tc2').attr('class');
    if(show==1){
        document.getElementById('tc2').style.display='block';
    }
}
function closeDiv(){
document.getElementById('tc').style.display='none';
document.getElementById('tc2').style.display='none';
}
showDiv();
showDiv2();
setTimeout("self.location.reload();",60000);
</script>
</div>  
</body>
</html>