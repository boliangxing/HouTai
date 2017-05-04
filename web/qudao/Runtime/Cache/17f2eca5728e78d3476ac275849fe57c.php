<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <div id="tabs">
                    <ul class="dd">
                        <li class="dd-item"><div class="dd-handle "><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($UserID); ?>">基本信息</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo ($UserID); ?>">转账记录</a></div></li>
                        <li class="dd-item here"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo ($UserID); ?>">存取记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo ($UserID); ?>">游戏记录(快速)</a></div></li>
						<li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx2?UserID=<?php echo ($UserID); ?>">游戏记录(详细)</a></div></li>
                       <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/inout?UserID=<?php echo ($UserID); ?>">进出记录</a></div></li>
                        <li class="dd-item back" ><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User" >返回</a></div></li>
                    </ul>
                </div>
                <div class="expand_query">         
                    <form action="<?php echo WEB_ROOT?>index.php/User/cq" method="GET">
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
                            <th>取钱</th>
                            <th>存钱</th>
                            <th>时间</th>
							<th>游戏</th>
							<th>银行</th>
                            <th>总</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <th><?php echo ($vo["GameName"]); ?></th>
                            <td><?php if($vo["TradeType"] == 1 ): ?>0
                                <?php else: echo ($vo["SwapScore"]); endif; ?>
                            </td>
                            <td><?php if($vo["TradeType"] == 2 ): ?>0
                                <?php else: echo ($vo["SwapScore"]); endif; ?>
                            </td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                            <td><?php echo ($vo["SourceGold"]); ?></td>
							<td><?php echo ($vo["SourceBank"]); ?></td>
							<td><?php echo ($vo["sum"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>        
            </article>
        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                   <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                     <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                     <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo ($UserID); if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo="+no;
})
	
</script>
</body>
</html>