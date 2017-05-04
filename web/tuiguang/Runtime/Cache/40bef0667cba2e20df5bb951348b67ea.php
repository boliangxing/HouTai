<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
<style>
.btn{
  display: inline-block;
float: right;
border: 1px solid #d2d2d2;
border-radius: 3px;
color: #fff;
font-size: 16px;
font-weight: normal;
padding: 3px 10px;
background: #333336;
}
.refresh{    display: inline-block;
    cursor: pointer;
    padding: 3px 5px;
    background: #CCCCCC;
    border-radius: 5px;}
.refresh:active{background: #C4C4C4;}
</style>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>渠道列表<a href="<?php echo WEB_ROOT?>index.php/User/AddQd" class="btn">添加渠道</a></h2>
                </header>
                <script>

                </script>
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>账号</th>
                            <th>渠道ID</th>
							<th>渠道名称</th>
                            <th>比例</th>
                            <th>类型</th>
                            <th>单价</th>
							<th>当日激活量</th>
							<th>当日充值</th>
							<th>总激活量</th>
							<th>总充值</th>
                            <th>启用比例</th>
                            <th>操作</th>
                            <th>使用状态</th>
							<th>刷新</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr value='<?php echo ($vo["TypeID"]); ?>'>
                            <td><?php echo ($vo["Username"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/QdInfo?QdType=<?php echo ($vo["QdType"]); ?>&QdID=<?php echo ($vo["TypeID"]); ?>"><?php echo ($vo["TypeID"]); ?></a></td>
							<td><?php echo ($vo["QdName"]); ?></td>
                            <td><?php echo ($vo["Bili"]); ?></td>
                            <td>
                              <!-- 0表示cpa 1表示cps -->
                            <?php if($vo["QdType"] == 0): ?>CPA
                            <?php else: ?> CPS<?php endif; ?>
                            </td>
                            <td><?php echo ($vo["Price"]); ?></td>
							<td class='open_num'></td>
							<td class='charge_num'></td>
							<td class='open_sum'></td>
							<td class='charge_sum'></td>
                            <td><?php if($vo["IsUsed"] == 0): ?>未启用
                            <?php else: ?> 启用<?php endif; ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/DelQd?UserID=<?php echo ($vo["UserID"]); ?>">删除</a>&nbsp;&nbsp;<a href="<?php echo WEB_ROOT?>index.php/User/EditQd?UserID=<?php echo ($vo["UserID"]); ?>">编辑</a></td>
                            <td><?php if($vo["Fenghao"] == 0): ?>使用中
                            <?php else: ?> 禁用<?php endif; ?></td>
							<td><span class='refresh' id='<?php echo ($vo["TypeID"]); ?>'>刷新</span></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>

                </table>
                </div>
            </article>

        </section>
    </div>


</div>
<script type="text/javascript">

$('.refresh').click(function(){
	var QdID=$(this).attr('id');
	var td=$(this).parent("td");
	td.siblings(".open_num").text('');
	td.siblings(".charge_num").text('');
	td.siblings(".open_sum").text('');
	td.siblings(".charge_sum").text('');
	$.ajax({
        type: 'GET',
        url: '<?php echo WEB_ROOT?>index.php/User/getQdInfo?QdID='+QdID,
        dataType: 'json',
        cache: false,
        error: function(){
            alert("网络连接出错！");
        },
        success:function(json){	
			td.siblings(".open_num").text(json.open_num);
			td.siblings(".charge_num").text(json.charge_num);
			td.siblings(".open_sum").text(json.open_sum);
			td.siblings(".charge_sum").text(json.charge_sum);
        	//tr.find("td[name='charge_num']").html(json.charge_num);
        	//alert(tr);

        }
    });

})



</script>
</body>
</html>