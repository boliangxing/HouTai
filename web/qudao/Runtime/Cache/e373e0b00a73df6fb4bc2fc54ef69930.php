<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">
                <header>
                    <h2>游戏记录</h2>
                </header> 
                
                <div id="table_w">
				<span style='padding-left:120px;'>总：<?php echo ($zong); ?><span>
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
                        </tr>
                        <?php
 if($vo['UserCount']>1){ ?>
						<tr class="youxiin">
                           <td  colspan="7" > 
                                <table class="youxi" >
                                    <tr >
                                        <th>昵称</th>
                                        <th>输赢积分</th>
                                    </tr>
                        <?php
 for($i=0;$i<count($vo['users']);$i++){ ?>
                                    <tr >
                                        <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo['users'][$i]['UserID']); ?>" target="_blank"><?php echo ($vo['users'][$i]['NickName']); ?></a></td>
                                        <td><?php echo ($vo['users'][$i]['Score']); ?></td>
                                    </tr>
                        <?php
 } ?>       
                                </table>
                            </td>
                        </tr>

						<?php
 } endforeach; endif; ?>
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

	location.href="<?php echo WEB_ROOT?>index.php/User/yx?UserID=<?php echo $UserID; if($start_date){ echo '&start_date='.$start_date.'&end_date='.$end_date;}?>&pageNo="+no;
})
/*$(document).ready(function(){
    $(".youxiin").css("display","none");

    $(".youxirow").click(function(){
        if( $(event.target).parent().next().css("display")!="none"){
            $(event.target).parent().next().css("display","none");
        }else{
            $(event.target).parent().next().css("display","");
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
$("#h2").val(<?php echo $h2;?>);*/
/*$(document).ready(function(){
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
				$(".youxirow").eq(index).after("<tr class='youxiin'><td  colspan='7'><table class='youxi' name='"+index+"'><tr ><th>用户名</th><th>输赢积分</th></tr>");
				for(i=0;i<json.length;i++){
					$(".youxi[name="+index+"]").append("<tr><td><a href='<?php echo WEB_ROOT?>index.php/User/userInfo?UserID="+json[i].UserID+"' target='_blank'>"+json[i].NickName+"</a></td><td>"+json[i].Score+"</td></tr>");    		
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

    
});*/
$("#h1").val(<?php echo $h1;?>);
$("#h2").val(<?php echo $h2;?>);
	
</script>
</body>
</html>