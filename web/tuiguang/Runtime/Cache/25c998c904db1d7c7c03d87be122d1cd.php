<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>操作记录</h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/change_search" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>           
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>操作管理员</th>
                            <th>被操作用户ID</th>
                            <th>被操作用户昵称</th>
                            <th>操作行为</th>
                            <th>原因</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["Username"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["NickName"]); ?></a></td>
							<td><?php if($vo['Type'] == 8): ?>添加屏蔽<?php endif; if($vo['Type'] == 9): ?>解除屏蔽<?php endif; if($vo['Type'] == 7): ?>清除手机绑定<?php endif; if($vo['Type'] == 5): ?>清除卡线<?php endif; if($vo['Type'] == 4): ?>解锁机器<?php endif; if($vo['Type'] == 3): ?>锁定机器<?php endif; if($vo['Type'] == 2): ?>解封<?php endif; if($vo['Type'] == 1): ?>封号<?php endif; ?></td>
                            <td><?php echo ($vo["Reason"]); ?></td>
                            <td><?php echo ($vo["InsertTime"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            
            <li><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
            <li class="mt_2">共：<span class='page_num'><?php echo $pageNum?></span>页</li>
            <li>
                <input type="text" id="pages">
                <input type="button" value="go" id="go_2">
                
            </li>           
        </ol>           
    </footer>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/change_record?pageNo="+no;
})
	
</script>
</div>  
</body>
</html>