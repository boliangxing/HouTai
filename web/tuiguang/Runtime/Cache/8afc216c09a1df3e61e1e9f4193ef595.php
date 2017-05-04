<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>损耗统计</h2>
                </header>           
                <div id="table_w1">
                <table id="num">
                    <thead>
                        <tr>
                            <th>日期</th>
							<th>总</th>
							<th>3D捕鱼</th>
                            <th>国际麻将</th>
                            <th>欢乐五张</th>
                            <th>欢乐斗牛</th>
                            <th>通比牛牛</th>
                            <th>二人斗牛</th>
							<th>百人角斗场</th>
                            <th>16人两张</th>
                            <th>豪车漂移</th>
                            <th>16人小九</th>
                            <th>冠军赛马</th>
							<th>欢乐30秒</th>
                            <th>火拼双扣</th>
                            <th>温州二人麻将</th>
							<th>神兽转盘</th>
							
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["InsertDate"]); ?></td>
							<td><?php echo ($vo["sum"]); ?></td>
							<td><?php echo ($vo["G2055"]); ?></td>
                            <td><?php echo ($vo["G10"]); ?></td>
                            <td><?php echo ($vo["G19"]); ?></td>
                            <td><?php echo ($vo["G27"]); ?></td>
                            <td><?php echo ($vo["G28"]); ?></td>
                            <td><?php echo ($vo["G102"]); ?></td>
							<td><?php echo ($vo["G104"]); ?></td>
                            <td><?php echo ($vo["G106"]); ?></td>
                            <td><?php echo ($vo["G108"]); ?></td>
                            <td><?php echo ($vo["G110"]); ?></td>
                            <td><?php echo ($vo["G114"]); ?></td>
							<td><?php echo ($vo["G122"]); ?></td>
                            <td><?php echo ($vo["G233"]); ?></td>
                            <td><?php echo ($vo["G308"]); ?></td>
							<td><?php echo ($vo["G404"]); ?></td>
							
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            
            <li><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/wasteList?pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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