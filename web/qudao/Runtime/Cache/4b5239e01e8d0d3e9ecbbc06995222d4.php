<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <div id="tabs">
                    <ul class="dd">
                       <li class="dd-item"><div class="dd-handle "><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($UserID); ?>">基本信息</a></div></li>
                        <li class="dd-item here"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo ($UserID); ?>">转账记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo ($UserID); ?>">存取记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo ($UserID); ?>">游戏记录(快速)</a></div></li>
						<li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx2?UserID=<?php echo ($UserID); ?>">游戏记录(详细)</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/inout?UserID=<?php echo ($UserID); ?>">进出记录</a></div></li>
                        <li class="dd-item back" ><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User" >返回</a></div></li>
                    </ul>
                </div>
                <div class="expand_query">        
                    <form action="<?php echo WEB_ROOT?>index.php/User/zz" method="GET" style="padding:15px 198px 0">
                        <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="hidden" class="datepick" name="UserID" value="<?php echo ($UserID); ?>">
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                        <input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>&nbsp;&nbsp;
                        <select name="Type" id="zz_type" value="<?php echo ($Type); ?>">
  								<option value ="1">所有</option>
  								<option value ="2">转入</option>
  								<option value ="3">转出</option>
  								<option value ="4">vip转入</option>
  								<option value ="5">普通转入</option>
  								<option value ="6">转出到VIP</option>
  								<option value ="7">转出到普通</option>
						</select>
                        <select name="Order" id="zz_order" value="<?php echo ($Order); ?>">
                                <option value ="1">时间</option>
                                <option value ="2">金额</option>
                        </select>
                        <input class="querybutton" type="submit" id="date_submit" value="查询">                    
                    </form>
                </div>               
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>赠送时间</th>
                            <th>赠送人ID</th>
                            <th>赠送人</th>
                            <th>接收人ID</th>
                            <th>接收人</th>
                            <th>赠送金额</th>
                            <th>赠送后金币</th>
                            <th>赠送后银行</th>
							<?php if($_SESSION['zs78_admin2']['id']==16 || $_SESSION['zs78_admin2']['id']==18 || $_SESSION['zs78_admin2']['id']==19){ echo "<th>操作</th>"; }?> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["CollectDate"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["SourceUserID"]); ?>" target="_blank"><?php echo ($vo["GameID1"]); ?></a></td>
                            <td><?php if($vo['MemberOrder1'] > 0): ?><span style="color:red"><?php echo ($vo["NickName1"]); ?></span><?php else: echo ($vo["NickName1"]); endif; ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["TargetUserID"]); ?>" target="_blank"><?php echo ($vo["GameID2"]); ?></a></td>
                            <td><?php if($vo['MemberOrder2'] > 0): ?><span style="color:red"><?php echo ($vo["NickName2"]); ?></span><?php else: echo ($vo["NickName2"]); endif; ?></td>
                            <td><?php echo ($vo["SwapScore"]); ?></td>
                            <td><?php echo ($vo["Gold"]); ?></td>
                            <td><?php echo ($vo["Bank"]); ?></td>
							<?php if($_SESSION['zs78_admin2']['id']==16 || $_SESSION['zs78_admin2']['id']==18 || $_SESSION['zs78_admin2']['id']==19){ if($vo['isCancel']==0){ echo "<td><span class='cancel' style='color:red;cursor:pointer' name=".$vo['RecordID'].">撤销</span></td>"; }else{ echo "<td><span style='color:green'>已撤销</td>"; } }?> 
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>         
            </article>
        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo $UserID;if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo ($UserID); if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&Type=<?php echo $Type;?>&Order=<?php echo $Order;?>&pageNo="+no;
})
$("#zz_type").get(0).selectedIndex=getUrlParam('Type')-1;
$("#zz_order").get(0).selectedIndex=getUrlParam('Order')-1;
$('.cancel').click(function() {
     var reason=prompt("请输入撤销原因，不能为空","");
 
    if(reason){
        var RecordID = $(this).attr('name');
        location.href = "<?php echo WEB_ROOT?>index.php/User/cancelInsure?RecordID="+RecordID+"&reason="+reason+"&UserID=<?php echo $UserID?>";
    }else{
        alert("原因不能为空");
    }
});	
</script>
</body>
</html>