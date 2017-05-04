<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <div id="tabs">
                    <ul class="dd">
                        <li class="dd-item"><div class="dd-handle "><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($UserID); ?>">基本信息</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo ($UserID); ?>">转账记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo ($UserID); ?>">存取记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo ($UserID); ?>">游戏记录(快速)</a></div></li>
						<li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx2?UserID=<?php echo ($UserID); ?>">游戏记录(详细)</a></div></li>
                       <li class="dd-item here"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/inout?UserID=<?php echo ($UserID); ?>">进出记录</a></div></li>
                        <li class="dd-item back" ><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User" >返回</a></div></li>
                    </ul>
                </div>
                <div class="expand_query">         
                    <form action="<?php echo WEB_ROOT?>index.php/User/inout" method="GET">
                        <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="hidden" class="datepick" name="UserID" value="<?php echo ($UserID); ?>">
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                        <input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>
                        <input class="querybutton" type="submit" id="date_submit" value="查询">                    
                    </form>
                </div>                
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏名</th>
                            <th>房间名</th>
                            <th>进入时间</th>
                            <th>进入金币</th>
                            <th>进入IP</th>
                            <th>离开时间</th>
                            <th>离开IP</th>
                            <th>离开原因</th>
                            <th>分数变更</th>
                            <th>保险箱变更</th>
                            <th>游戏时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["KindName"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/UserGameInfo?RecordID=<?php echo ($vo['RecordID']); ?>&type=<?php echo ($vo['type']); ?>" target="_blank"><?php echo ($vo["ServerName"]); ?></a></td>
                            <td><?php echo ($vo["EnterTime"]); ?></td>
                            <td><?php echo ($vo["EnterScore"]); ?></td>
                            <td><?php echo ($vo["EnterClientIP"]); ?></td>
                            <td><?php echo ($vo["LeaveTime"]); ?></td>
                            <td><?php echo ($vo["LeaveClientIP"]); ?></td>
                            <td><?php if($vo['LeaveReason'] == 5): ?>条件限制<?php endif; if($vo['LeaveReason'] == 4): ?>人满为患<?php endif; if($vo['LeaveReason'] == 3): ?>用户冲突<?php endif; if($vo['LeaveReason'] == 2): ?>网络原因<?php endif; if($vo['LeaveReason'] == 1): ?>系统原因<?php endif; if($vo['LeaveReason'] == 0): ?>常规离开<?php endif; ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
                            <td><?php echo ($vo["Insure"]); ?></td>
                            <td><?php echo ($vo["PlayTimeCount"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>        
            </article>
        </section>
    </div>
    
</div>  
<script type="text/javascript">

$('#go_2').click(function(){ 
	var no = parseInt($('#pages').val());
	var page_num = $('.page_num').html();
	if(no == null || no == ''){
		alert('页数不能为空');
		return false;
	}
	if(isNaN(no)){
		alert('请输入数字');
		return false;
	}
	if(no > page_num || no < 1){
		alert('页数不能大于总页数，也不能小于1');
		return false;
	}    	

	location.href="<?php echo WEB_ROOT?>index.php/User/inout?UserID=<?php echo ($UserID); if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo="+no;
})
	
</script>
</body>
</html>