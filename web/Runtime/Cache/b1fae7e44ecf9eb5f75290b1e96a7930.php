<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <div id="tabs">
                    <ul class="dd">
                       <li class="dd-item"><div class="dd-handle "><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($UserID); ?>">基本信息</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID=<?php echo ($UserID); ?>">转账记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID=<?php echo ($UserID); ?>">存取记录</a></div></li>
                        <li class="dd-item here"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo ($UserID); ?>">游戏记录(快速)</a></div></li>
						<li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx2?UserID=<?php echo ($UserID); ?>">游戏记录(详细)</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/inout?UserID=<?php echo ($UserID); ?>">进出记录</a></div></li>
                        <li class="dd-item back" ><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User" >返回</a></div></li>
                    </ul>
                </div>
                <div class="expand_query">         
                    <form action="<?php echo WEB_ROOT?>index.php/User/yx" method="GET"  style="padding-left:200px;padding-right:0">
                        <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="hidden" class="datepick" name="UserID" value="<?php echo ($UserID); ?>">
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>-
                        <input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>
                        <input class="querybutton" type="submit" id="date_submit" value="查询"> <a style="padding-left:20px" href="<?php echo WEB_ROOT?>index.php/User/yx_dz?UserID=<?php echo ($UserID); ?>">只看真人对战</a>  <a style="padding-left:30px" href="<?php echo WEB_ROOT?>index.php/User/yx_wzq?UserID=<?php echo ($UserID); ?>">只看五子棋</a>  
						<!--<span style="padding-left:20px" id='zk'>一键展开</span>-->
                    </form>
                </div>                
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏</th>
                            <th>桌子编号</th>
                            <th>椅子编号</th>
                            <th>输赢</th>
                            <th>记录时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr class="youxirow" name='<?php echo ($vo["DrawID"]); ?>'>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><?php echo ($vo["KindName"]); ?>-<?php echo ($vo["ServerName"]); ?></td>
                            <td><?php echo ($vo["TableID"]); ?></td>
                            <td><?php echo ($vo["ChairID"]); ?></td>
                            <td><?php echo ($vo["Score"]); ?></td>
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
            <li><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo="+no;
})
$(document).ready(function(){
    $(".youxiin").css("display","none");

    $(".youxirow").click(function(){
		
		var DrawID = $(this).attr('name');
		var index = $(".youxirow").index(this);
		
		if($(".youxi[name="+index+"]").length > 0){
			return;
		}
	
		$.ajax({ 
			type: 'GET', 
			url: '<?php echo WEB_ROOT?>index.php/User/getGameList2?DrawID='+DrawID, 
			dataType: 'html', 
			cache: false,        
			error: function(XMLHttpRequest, textStatus, errorThrown){ 
			alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
            //alert("网络连接出错！");
			}, 
			success:function(json){ 
				json = strToJson(json);
				$(".youxirow").eq(index).after("<tr class='youxiin'><td  colspan='7'><table class='youxi' name='"+index+"'><tr ><th>用户名</th><th>输赢积分</th><th>税收/服务费</th><th>游戏时长</th></tr>");
				for(i=0;i<json.length;i++){
					$(".youxi[name="+index+"]").append("<tr><td><a href='<?php echo WEB_ROOT?>index.php/User/userInfo?UserID="+json[i].UserID+"' target='_blank'>"+json[i].NickName+"</a></td><td>"+json[i].Score+"</td><td>"+json[i].Revenue+"</td><td>"+json[i].PlayTimeCount+"</td></tr>");    		
				}
				//alert(json);
        	
			} 
		});
	
		function strToJson(str){ 
		var json = eval('(' + str + ')'); 
		return json; 
		} 
    });
	
	$("#zk").click(function(){
		if($(".youxiin").css("display")!="none"){
            $(".youxiin").css("display","none");
        }else{
            $(".youxiin").css("display","");
        }
        //$(".youxiin").css("display","");
    });

    
});
$("#h1").val(<?php echo $h1;?>);
$("#h2").val(<?php echo $h2;?>);
	
</script>
</body>
</html>