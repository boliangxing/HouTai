<?php if (!defined('THINK_PATH')) exit();?>﻿<?php  require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>充值记录</h2>
                </header>           
				<form action="<?php echo WEB_ROOT?>index.php/User/cz_search" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>订单号</th>
                            <th>金额</th>
                            <th>充值前金币</th>
                            <th>充值时间</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/order_search?type=1&OrderID=<?php echo ($vo["GameID"]); ?>" target="_blank"><?php echo ($vo["Accounts"]); ?></a></td>
							<td><?php if($vo["Present"] == 1 ): ?><span style="color:#9900FF">★</span><?php endif; if($vo["LockMobileFrom"] == 3 ): ?><span style="color:red">♥♥</span><?php endif; echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["OrderID"]); ?></td>
                            <td><?php echo ($vo["PayAmount"]); ?></td>
                            <td><?php echo ($vo["BeforeGold"]); ?></td>
                            <td><?php echo ($vo["ApplyDate"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/cz_list?pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
            <li class="mt_2">共：<span class='page_num'><?php echo $pageNum?></span>页</li>
            <li>
                <input type="text" id="pages">
                <input type="button" value="go" id="go">
                
            </li>           
        </ol>           
    </footer>
</div>  
</body>
</html>