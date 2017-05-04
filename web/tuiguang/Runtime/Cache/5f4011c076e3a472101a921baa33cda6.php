<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">    
                <header>
                    <h2>vip游戏</h2>
                </header> 
                <div class="expand_query">         
                    <form action="<?php echo WEB_ROOT?>index.php/User/vipRecord" method="GET"  style="padding-left:270px;padding-right:0">
                        <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>--<input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>
                        <input class="querybutton" type="submit" id="date_submit" value="查询">                  
                    </form>
                </div>             
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
							<th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>游戏局数</th>
                            <th>输赢</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr class="youxirow">
							<td><?php echo ($vo["no"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo['UserID']); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php echo ($vo["GameCount"]); ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/vipRecord?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo="+no;
})
	
</script>
</body>
</html>