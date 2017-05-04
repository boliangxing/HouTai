<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="query">
                <header>
                    <h2>vip会员查询</h2>
                </header>                   
                <form action="<?php echo WEB_ROOT?>index.php/Vip/vip_search" method="GET">
                    <div class="select">
                        <select name='type' onchange="changeinput();"> 
                            <option value ="1" selected="selected">游戏ID</option>
                            <option value ="2" >群组</option>
                        </select>
                    </div>                              
                    <div id="select_td" style="display:inline-block;">
                        <input type="text" name="GameID" id="GameID" style="width:100px;">
                    </div>
                    <div  class="querybutton">
                        <input type="submit" id="vip_s" value="查询">
                    </div>
                </form>
            </article>
            <article class="extend_list">
                <header>
                    <h2>vip会员列表</h2>
                    <input class="querybutton" type="button" id="excel_vip" value="导出" style="width:45px;height:30px;position:absolute;margin-left:700px">
                </header>
                <p class="tj">金币(总)：<?php echo ($sum['Score_sum']); ?>&nbsp;&nbsp;银行(总)：<?php echo ($sum['InsureScore_sum']); ?>&nbsp;&nbsp;总额(总)：<?php echo ($sum['sum']); ?></p>
                <div id="table_w">
                <table id="num" name="<?php echo ($rs['con']); ?>">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=3">群组</a></th>
                            <th>金币</th>
                            <th>银行</th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=2">总金币</a></th>
                            <th><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=1">到期时间</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_info?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["Accounts"]); ?></a></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php echo ($vo["GroupNum"]); ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
                            <td><?php echo ($vo["InsureScore"]); ?></td>
                            <td><?php echo ($vo["gold_sum"]); ?></td>
                            <td><?php echo ($vo["MemberOverDate"]); ?></td>
                         </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                </div>
            </article>
        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
            <li class="mt_2">共：<span class='page_num'><?php echo $pageNum?></span>页</li>
            <li>
                <input type="text" id="pages">
                <input type="button" value="go" id="go_2">
                
            </li>           
        </ol>  
    </footer>

</div>  
<script type="text/javascript">
//金币排行导出
$("#excel_vip").click(function(){
    location.href="<?php echo WEB_ROOT?>index.php/Vip/vip_export";
})
$("#vip_s").click(function(){
	var aa = $("#GameID").val();
	if(aa == '' || aa == null){
		location.href="<?php echo WEB_ROOT?>index.php/Index/vip_mem";
		return false;
	}
    
})
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

	location.href="<?php echo WEB_ROOT?>index.php/Vip/mem_list?type=<?php echo $type;?>&pageNo="+no;
})
	
</script>
</body>
</html>