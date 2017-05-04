<?php
	require 'Db/Db_charge.php';
	if($_GET['pageNo']){
		$pageNo = $_GET['pageNo'];
	}else{
		$pageNo = 1;
	}
	$pageSize = 20;
	if($_GET['start_date']&&$_GET['end_date']){
    	$date1 = $_GET['start_date'];
		$date2 = $_GET['end_date'];
		$date3 = strtotime($date1);
		$date4 = strtotime($date2);
		if($date3>=$date4){
			$start_date = $date2.' 00:00:00';
			$end_date = date('Y-m-d H:i:s',strtotime($date1)+3600*24-1);
			$this->assign('start_date',$date2);
			$this->assign('end_date',$date1);
		}else{
			$start_date = $date1.' 00:00:00';
			$end_date = date('Y-m-d H:i:s',strtotime($date2)+3600*24-1);
			$this->assign('start_date',$date1);
			$this->assign('end_date',$date2);
		}
    }else{
    	$end_date = date('Y-m-d H:i:s');    	
    	$start_date = date('Y-m-d H:i:s',strtotime(date('Y-m-d'))-3600*24);
    	//$start_date='2013-12-01 00:00:00';
    }
    if($_GET['pageNo']){
		$pageNo = $_GET['pageNo'];
	}else{
		$pageNo = 1;
	} 		
	$rs = array();		
	$procedure = mssql_init("PHP_PhoneChargeCount",$conn); 		
	mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
	mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);		
	$resource = mssql_execute($procedure);
	if($row = mssql_fetch_assoc($resource)){
			//$rs['game'] = $this->getGameName($rs[$i]['KindID']);
		$count = $row['num'];
	}		
	mssql_free_statement($procedure); 		
	
	$procedure2 = mssql_init("PHP_PhoneChargeList",$conn); 		
	mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
	mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
	mssql_bind($procedure2,"@pageNo", $pageNo, SQLINT4); 
	mssql_bind($procedure2,"@pageSize", $pageSize, SQLINT4); 
	
	$resource2 = mssql_execute($procedure2);
	while($row2 = mssql_fetch_assoc($resource2)){
		$rs[] = $row2;
	}		
	mssql_free_statement($procedure2); 
	mssql_close($conn);
	for($i=0;$i<count($rs);$i++){
		$rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
		if($rs[$i]['ShareID']==14){
			$rs[$i]['ShareID']='支付宝';		
		}elseif($rs[$i]['ShareID']==17) {
			$rs[$i]['ShareID']='银联';
		}elseif($rs[$i]['ShareID']==15) {
			$rs[$i]['ShareID']='Apple Store';
		}elseif($rs[$i]['ShareID']==32) {
			$rs[$i]['ShareID']='短信';
		}
	} 

	$pageNum = ceil($count/$pageSize);	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>aa</title>
	<link rel="stylesheet" href="public/styles/charge.css">
	<script src="public/js/jquery-1.9.1.min.js"></script>
	<script src="public/js/jquery-ui.js"></script>
	<script src="public/js/self.js"></script>
</head>
<body>
<div class="warp">
	
	<div class="warpall">	
        <section class="mainwarp">
            <article class="user_info">
                <!-- <div id="tabs">
                    <ul class="dd">
                        <li class="dd-item"><div class="dd-handle "><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID={$UserID}">基本信息</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/zz?UserID={$UserID}">转账记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/cq?UserID={$UserID}">存取记录</a></div></li>
                        <li class="dd-item"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/yx?UserID={$UserID}">游戏记录</a></div></li>
                        <li class="dd-item here"><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User/recharge?UserID={$UserID}">充值记录</a></div></li>
                        <li class="dd-item back" ><div class="dd-handle"><a href="<?php echo WEB_ROOT?>index.php/User" >返回</a></div></li>
                    </ul>
                </div>  -->              
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                           <th>序号</th>
							<th>游戏ID</th>
							<th>充值类型</th>
							<th>订单号</th>
							<th>充值前金币</th>
							<th>实付金额</th>
							<th>IP地址</th>
							<th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        	foreach ($rs as $k => $v) {
                        ?>
                        <tr>
                            <td>{$rs.no}</td>
							<td>{$vo.GameID}</td>
							<td>{$vo.ShareID}</td>
							<td>{$vo.OrderID}</td>
							<td>{$vo.BeforeGold}</td>
							<td>{$vo.PayAmount}</td>
							<td>{$vo.IPAddress}</td>
							<td>{$vo.ApplyDate}</td>
                        </tr>
                        <?php
                        	}
                        ?>
                    </tbody>                    
                </table>
                </div>        
            </article>
        </section>
    </div>
    <footer>
        <ol class="pagination">
            <li><a href="<?php echo WEB_ROOT?>charge.php?pageNo=1" rel="next">首页</a></li>
            <li><a href="<?php echo WEB_ROOT?>charge.php?pageNo=<?php echo $pageNo-1<1?1:$pageNo-1 ?>" rel="prev">上页</a></li>
            <?php 
            	if($pageNum>5){
					if($pageNo<5){
						for($i=1;$i<=5;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>charge.php?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php 	
						} ?>
					<li class='page_no'>......</li>
			<?php               
            		}else if($pageNo>=5 && $pageNo<$pageNum-2){?>
					
					<li class='page_no'>......</li>	
			<?php	
						for($i=$pageNo-2;$i<=$pageNo+2;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>charge.php?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php	
						} ?>
					<li class='page_no'>......</li>
			<?php
					}else{?>
					
					<li class='page_no'>......</li>	
			<?php	
						for($i=$pageNo-3;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>charge.php?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php
						}
					}	
				}else{?>
			<?php
					for($i=1;$i<=$pageNum;$i++){?>
                    
                    <li class='page_no'><a href="<?php echo WEB_ROOT?>charge.php?pageNo=<?php echo $i?>"><?php echo $i?></a></li>
			<?php 	
					}
				}	
            ?>
            <li><a href="<?php echo WEB_ROOT?>charge.php?pageNo=<?php echo $pageNo+1>$pageNum?$pageNum:$pageNo+1 ?>" rel="next">下页</a></li>
            <li><a href="<?php echo WEB_ROOT?>charge.php?pageNo=<?php echo $pageNum?>" rel="next">末页</a></li>
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