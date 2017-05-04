<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>金币排行</h2>
                </header>           
                <form id="gold_rank" action="<?php echo WEB_ROOT?>index.php/User/gold_rank" method="GET" style="padding-bottom:0;position:relative">
                    <span>前：</span>
                    <input type="text" name="num" id="s_num" style="width:50px;" value="<?php echo ($count); ?>">
                    <span>名&nbsp;</span>
                    <input type="hidden" name="s_type" id="s_type">
                    <input class="querybutton" type="submit" value="身上查询" style="width:65px;">
                    <input class="querybutton" type="submit" value="银行查询" style="width:65px;"> 
                    <input class="querybutton" type="submit" value="总金币查询" style="width:70px;">
                    <input class="querybutton" type="button" id="excel_rank" value="导出" style="width:45px;position:absolute;margin-left:140px">                     
                </form>
                <p class="tj">金币(总)：<?php echo ($goldSum['Score']); ?>&nbsp;&nbsp;银行(总)：<?php echo ($goldSum['InsureScore']); ?>&nbsp;&nbsp;总额(总)：<?php echo ($goldSum['gold_sum']); ?></p>
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>金币</th>
                            <th>银行</th>
                            <th>总金币</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php if($vo['MemberOrder'] > 0): ?><span style="color:red"><?php echo ($vo["NickName"]); ?></span><?php else: echo ($vo["NickName"]); endif; ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
                            <td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php echo ($vo["gold_sum"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo ($count); ?>&s_type=<?php echo ($type); ?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo ($count); ?>&s_type=<?php echo ($type); ?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo $count?>&s_type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo $count?>&s_type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo $count?>&s_type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo $count?>&s_type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            
            <li><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo ($count); ?>&s_type=<?php echo ($type); ?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo ($count); ?>&s_type=<?php echo ($type); ?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/gold_rank?num=<?php echo ($count); ?>&s_type=<?php echo ($type); ?>&pageNo="+no;
})
//金币排行导出
$("#excel_rank").click(function(){
    var num = $("#s_num").val();
    if(num == '' || num == null || num == 0){
    	alert('请输入名次');
    	return false;
    }
    location.href="<?php echo WEB_ROOT?>index.php/User/excel_rank?num="+num;
})

	
</script>
</body>
</html>