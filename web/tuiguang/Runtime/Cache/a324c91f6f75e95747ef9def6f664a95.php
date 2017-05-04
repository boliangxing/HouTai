<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
					<?php  if($type==1){ echo '<h2>全部掉线记录&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.WEB_ROOT.'index.php/User/dxList?type=2"><span style="color:#2996cc">总金币大于30W</span></a></h2>'; }else{ echo '<h2><a href="'.WEB_ROOT.'index.php/User/dxList?type=1"><span style="color:#2996cc">全部掉线记录</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总金币大于30W</h2>'; } ?>
                </header>   
				<form action="<?php echo WEB_ROOT?>index.php/User/dxList" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>				
                <div id="table">
                <table id="num" style="width:1200px;">
                    <thead>
                        <tr>
							<th>序号</th>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>登录IP</th>
                            <th>登录机器码</th>
							<th>登录方式</th>
							<th>身上金币</th>
							<th>银行金币</th>
							<th>总金币</th>
							<th>房间</th>
							<th>掉线时间</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
							<td><?php echo ($vo["no"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["NickName"]); ?></a></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=3&con=<?php echo ($vo["ip"]); ?>" target="_blank"><?php echo ($vo["ip"]); ?></a></br>(<?php echo ($vo['Re_city']['country']); echo ($vo['Re_city']['area']); ?>)</td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/ip_search?UserID=<?php echo ($vo["UserID"]); ?>&type=4&con=<?php echo ($vo["Machine"]); ?>" target="_blank"><?php echo ($vo["Machine"]); ?></a></td>
                            <td><?php if($vo['loginFrom'] == 1): ?>IOS<?php endif; if($vo['loginFrom'] == 2): ?>ANDROID<?php endif; if($vo['loginFrom'] == 3): ?>PC<?php endif; ?></td>
							<td><?php echo ($vo["Score"]); ?></td>
							<td><?php echo ($vo["InsureScore"]); ?></td>
							<td><?php echo ($vo["Total"]); ?></td>
							<td><?php echo ($vo["ServerName"]); ?></td>
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
            <li><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            
            <li><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/dxList?type=<?php echo $type?>&pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
            <li class="mt_2">共：<span class='page_num'><?php echo $pageNum?></span>页</li>
            <li>
                <input type="text" id="pages">
                <input type="button" value="go" id="go">
                
            </li>           
        </ol>           
    </footer>
<script type="text/javascript">
	
</script>
</div>  
</body>
</html>