<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info"> 
				<header>
					<h2>已撤销转账列表</h2>
				</header>			
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>转账时间</th>
                            <th>支付人ID</th>
                            <th>支付人</th>
                            <th>接收人ID</th>
                            <th>收款人</th>
                            <th>支付金额</th>
							<th>撤销原因</th>
							<th>操作人</th>
							<th>操作时间</th>
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
							<td><?php echo ($vo["CollectNote"]); ?></td>
							<td><?php echo ($vo["Manager"]); ?></td>
							<td><?php echo ($vo["InsertDate"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>         
            </article>
        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/cancelList?pageNo="+no;
})
$("#zz_type").get(0).selectedIndex=getUrlParam('Type')-1;
	
</script>
</body>
</html>