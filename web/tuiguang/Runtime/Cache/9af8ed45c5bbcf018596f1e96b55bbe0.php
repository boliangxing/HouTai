<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>所有人金币总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/userCc"><span style="color:#2996cc">库存统计<span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/suoyou"><span style="color:#2996cc">所有YS总<span></a></h2>
                </header>           
                <div id="table_w">
                    <span>当前：<?php echo ($cc_count); ?></span>
                <table id="num">
                    <thead>
                        <tr>
                            <th>日期</th>
                            
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th>15</th>
                            <th>16</th>
                            <th>17</th>
                            <th>18</th>
                            <th>19</th>
                            <th>20</th>
                            <th>21</th>
                            <th>22</th>
                            <th>23</th>
							<th>24</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["InsertDate"]); ?></td>
                            <td><?php echo ($vo["t0"]); ?></td>
                            <td><?php echo ($vo["t1"]); ?></td>
                            <td><?php echo ($vo["t2"]); ?></td>
                            <td><?php echo ($vo["t3"]); ?></td>
                            <td><?php echo ($vo["t4"]); ?></td>
                            <td><?php echo ($vo["t5"]); ?></td>
                            <td><?php echo ($vo["t6"]); ?></td>
                            <td><?php echo ($vo["t7"]); ?></td>
                            <td><?php echo ($vo["t8"]); ?></td>
                            <td><?php echo ($vo["t9"]); ?></td>
                            <td><?php echo ($vo["t10"]); ?></td>
                            <td><?php echo ($vo["t11"]); ?></td>
                            <td><?php echo ($vo["t12"]); ?></td>
                            <td><?php echo ($vo["t13"]); ?></td>
                            <td><?php echo ($vo["t14"]); ?></td>
                            <td><?php echo ($vo["t15"]); ?></td>
                            <td><?php echo ($vo["t16"]); ?></td>
                            <td><?php echo ($vo["t17"]); ?></td>
                            <td><?php echo ($vo["t18"]); ?></td>
                            <td><?php echo ($vo["t19"]); ?></td>
                            <td><?php echo ($vo["t20"]); ?></td>
                            <td><?php echo ($vo["t21"]); ?></td>
                            <td><?php echo ($vo["t22"]); ?></td>
                            <td><?php echo ($vo["t23"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>

                </div>
            </article>          

        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php  if($pageNum>5){ if($pageNo<5){ for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } ?>
					<li class='page_no'>......</li>
			<?php  }else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	 } ?>
					<li class='page_no'>......</li>
			<?php
 }else{?>
					
					<li class='page_no'>......</li>	
			<?php	 for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
 } } }else{?>
			<?php
 for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php  } } ?>
            
            <li><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>index.php/User/all?pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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