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
                    <h2>渠道充值记录</h2>
                </header>

                <div id="table_w">
				<table id="num">
                    <thead>
                        <tr>
                            <th>appstore</th>
							<th>支付宝</th>
							<th>爱贝</th>
							<th>总</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo ($appstore); ?></td>
							<td><?php echo ($wx); ?></td>
							<td><?php echo ($ab); ?></td>
							<td><?php echo ($zong); ?></td>
                        </tr>
                    </tbody>

                </table>
				
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
							<th>GameID</th>
							<th>帐号</th>
							<th>昵称</th>
							<th>订单号</th>
							<th>金额</th>
							<th>充值时间</th>
							<th>注册时间</th>
							<th>最后登录时间</th>
							<th>注册IP</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr value='<?php echo ($vo["TypeID"]); ?>'>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><?php echo ($vo["GameID"]); ?></td>
							<td><?php echo ($vo["Accounts"]); ?></td>
							<td><?php echo ($vo["NickName"]); ?></td>
							<td><?php echo ($vo["OrderID"]); ?></td>
							<td><?php echo ($vo["PayAmount"]); ?></td>
							<td><?php echo ($vo["ApplyDate"]); ?></td>
							<td><?php echo ($vo["RegisterDate"]); ?></td>
							<td><?php echo ($vo["LastLogonDate"]); ?></td>
							<td><?php echo ($vo["RegisterIP"]); ?></td>
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