<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>
当前渠道总人数&nbsp;&nbsp;&nbsp;&nbsp;
<?php if(is_array($result1)): foreach($result1 as $key=>$vo): ?><span><?php echo ($vo["count"]); ?></span><?php endforeach; endif; ?>



</h2>
                </header>
				<form style='width:700px;padding:10px 100px;' action="" method="POST">
					<span>请输入渠道号：</span>
           <select name='id'>
             <?php if(is_array($result)): foreach($result as $key=>$vo): ?><<option value="<?php echo ($vo["typeid"]); ?>"><?php echo ($vo["typeid"]); ?></option><?php endforeach; endif; ?>
           </select>
					<input class="user_search_submit" type="submit" value="查询">
				</form>
                <div id="table_w">



                 <table id="num" style="float:left;margin-left:20px">
                    <thead>
                        <tr>
                            <th>USERID</th>
                            <th>转账号码</th>
                            <th>转账金额</th>
                            <th>充值金额</th>
                            <th>游戏房间ID</th>
                            <th>游戏时间</th>
                        </tr>
                    </thead>
                    <tbody   >
                      <?php if(is_array($result2)): foreach($result2 as $key=>$vo): ?><tr>
                         <td><?php echo ($vo["UserID"]); ?></td>
                         <td><?php echo ($vo["TargetUserID"]); ?></td>
                         <td><?php echo ($vo["SwapScore"]); ?></td>
                         <td><?php echo ($vo["PayAmount"]); ?></td>
                         <td><?php echo ($vo["serverid"]); ?></td>
                         <td><?php echo ($vo["gametime"]); ?></td>
                       </tr><?php endforeach; endif; ?>
                    </tbody>

                </table>


                </div>
            </article>

        </section>
    </div>
</div>
</body>
</html>