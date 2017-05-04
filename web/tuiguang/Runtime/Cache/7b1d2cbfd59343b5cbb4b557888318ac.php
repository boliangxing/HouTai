<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="user_info">  
                <header>
                    <h2>最近100条游戏对战</h2>
                </header>             
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>游戏</th>
                            <th>桌子编号</th>
                            <th>损耗</th>
                            <th>记录时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr class="youxirow">
                            <td><?php echo ($vo["KindName"]); ?>-<?php echo ($vo["ServerName"]); ?></td>
                            <td><?php echo ($vo["TableID"]); ?></td>
                            <td><?php echo ($vo["Waste"]); ?></td>
                            <td><?php echo ($vo["InsertTime"]); ?></td>
                        </tr>
                        <tr class="youxiin">
                           <td  colspan="7" > 
                                <table class="youxi" >
                                    <tr >
                                        <th>用户名</th>
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
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>    
                     
            </article>
        </section>
    </div>
</div>  
<script type="text/javascript">
	
</script>
</body>
</html>