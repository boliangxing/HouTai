<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <div class="expand_query">    
                <p style="padding-left:50px;"><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date.'&';}?>type=1">所有</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date.'&';}?>type=2">vip转出</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date.'&';}?>type=3">普通玩家转出</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date.'&';}?>type=4">VIP转出到VIP</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date.'&';}?>type=5">普通转出到VIP</a></p>      
                    <form action="<?php echo WEB_ROOT?>index.php/User/zz_list" method="GET">
                        <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                        <input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>
                        <input type="hidden" class="datepick" name="type" value=<?php echo ($type); ?>>
                        <input class="querybutton" type="submit" id="date_submit" value="查询">                    
                    </form>
                </div>               
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>转账时间</th>
                            <th>支付人ID</th>
                            <th>支付人</th>
                            <th>接收人ID</th>
                            <th>接收人</th>
                            <th>支付金额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["GameID1"]); ?></a></td>
                            <td><?php if($vo['MemberOrder1'] > 0): ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><span style="color:red"><?php echo ($vo["NickName1"]); ?></span></a></span><?php else: ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["NickName1"]); ?></a><?php endif; ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["GameID2"]); ?></a></td>
                            <td><?php if($vo['MemberOrder2'] > 0): ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><span style="color:red"><?php echo ($vo["NickName2"]); ?></span></a><?php else: ?><a href="<?php echo WEB_ROOT?>index.php/User/userInfo2?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["NickName2"]); ?></a><?php endif; ?></td>
                            <td><?php if($vo['color'] == 1): echo ($vo["SwapScore"]); endif; if($vo['color'] == 2): ?><span style='color:#9900cc'><?php echo ($vo["SwapScore"]); ?></span><?php endif; if($vo['color'] == 3): ?><span style='color:#3300ff'><?php echo ($vo["SwapScore"]); ?></span><?php endif; ?></td>
							<?php if($type==3){echo '<td><a href=\"'.WEB_ROOT.'index.php/User/pb_one?id1='.$vo['TargetUserID'].'&id2='.$vo['SourceUserID'].'>点击屏蔽</a></td>';}?>
						</tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>         
            </article>
        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
            <li class="mt_2">共：<span class='page_num'><?php echo $pageNum?></span>页</li>
            <li>
                <input type="text" id="pages">
                <input type="button" value="go" id="go_2">
                
            </li>           
        </ol>           
    </footer>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/zz_list?<?php if($start_date){ echo 'start_date='.$start_date.'&end_date='.$end_date;}?>&type=<?php echo $type;?>&pageNo="+no;
})
	
</script>
</body>
</html>