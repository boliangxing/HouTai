<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="cx_form">
                <header>
                    <h2>转账查询</h2>
                </header>                   
                <form action="<?php echo WEB_ROOT?>index.php/Vip/vip_zz" method="GET">
                    <span style="margin-left:100px;">查询日期&nbsp;&nbsp;</span>
					<input name="s_date" type="text" class="datepick" value="<?php echo ($s_date); ?>">
					GameID:&nbsp;&nbsp;
					<input name="GameID" type="text" value="<?php echo $GameID;?>">
					<input class="submit" type="submit" value="查询">
                </form>
            </article>
            <article class="cx_form">
                <header>
                    <h2>vip会员列表<span class="h2_right_2" style="margin-left:50px;"><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=1&<?php if($GameID){echo 'GameID='.$GameID.'&'; }?>s_date=<?php echo $s_date;?>"><span id="f60" class="col1">所有</span></a></span><span class="h2_right_2" style="margin-left:50px;"><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=2&<?php if($GameID){echo 'GameID='.$GameID.'&'; }?>s_date=<?php echo $s_date;?>"><span id="f60" class="col2">VIP</span></a></span><span class="h2_right_2" style="margin-left:50px;"><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=3&<?php if($GameID){echo 'GameID='.$GameID.'&'; }?>s_date=<?php echo $s_date;?>"><span id="f60" class="col3">普通</span></a></span><span class="h2_right_2" style="margin-left:50px;"><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=4&<?php if($GameID){echo 'GameID='.$GameID.'&'; }?>s_date=<?php echo $s_date;?>"><span id="f60" class="col4">指导费</span></a></span><span class="h2_right_2" style="margin-left:50px;"><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_export2?s_date=<?php echo $s_date;?>">导出</a></span></h2>          
                </header>
                <p class="tj">转入(总)：<?php echo ($sum["zr_sum"]); ?>&nbsp;&nbsp;转出(总)：<?php echo ($sum["zc_sum"]); ?>&nbsp;&nbsp;差额(总)：<?php echo ($sum["zz_sum"]); ?></p>
                <div id="table_w">
                <table id="num" name="<?php echo ($rs['con']); ?>">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>群组</th>
                            <th>转入次数</th>
                            <th>转入金额</th>
                            <th>转出次数</th>
                            <th>转出金额</th>
                            <th>差额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_info?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["Accounts"]); ?></a></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php echo ($vo["GroupNum"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_all_record?UserID=<?php echo ($vo["UserID"]); ?>&s_date=<?php echo $s_date ?>&zz_type=<?php echo $type ?>&user_type=1" target="_blank"><?php echo ($vo["zz"]["zr_count"]); ?></a></td>
                            <td><?php echo ($vo["zz"]["zr_sum"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_all_record?UserID=<?php echo ($vo["UserID"]); ?>&s_date=<?php echo $s_date ?>&zz_type=<?php echo $type ?>&user_type=2" target="_blank"><?php echo ($vo["zz"]["zc_count"]); ?></a></td>
                            <td><?php echo ($vo["zz"]["zc_sum"]); ?></td>
                            <td><?php echo ($vo["zz"]["zz_sum"]); ?></td>
                         </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                </div>
            </article>
        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                     <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>           
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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

    location.href="<?php echo WEB_ROOT?>index.php/Vip/vip_zz?type=<?php echo $type;?>&s_date=<?php echo $s_date;?>&pageNo="+no;
})
var type=getUrlParam('type');
if(type==null){
    type='1';
}
$('span #col').removeClass('f60');
switch(type)
{
case '1':
$('span .col1').addClass('f60');
break;
case '2':
$('span .col2').addClass('f60');  
break;
case '3':
$('span .col3').addClass('f60');  
break;
case '4':
$('span .col4').addClass('f60');  
break;
}
</script>
</body>
</html>