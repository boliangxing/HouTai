<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="addM">
                <header>
                    <h2>输赢查询</h2>
                </header>           
                <form action="<?php echo WEB_ROOT?>index.php/User/winresult" method="GET">
                    <span>查询条件：</span>
                    <select name="type" id="select">
							<option value ="5">最后登录机器码</option> 
                            <option value ="1">游戏ID</option>
                            <option value ="2">注册IP</option> 
                            <option value ="3">最后登录IP</option>  
                            <option value ="4">注册机器码</option> 
							<option value ="6">身份证号</option> 
                                                    
                    </select><input type="text" name="GameID">
                    <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" style='width:88px;' class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                        <input type="text" style='width:88px;' class="datepick" name="end_date" value=<?php echo ($end_date); ?>>
                    <input class="add_submit" type="submit" value="查询">             
                </form>
                
            </article>
            <article class="giveinfo">
                <header>
                    <h2>查询结果</h2>
                </header>
                <div id="table_w">
                    <span style='padding-left:500px;'>总：<?php echo ($total); ?></span>
                    <table id="num">
                    <thead>
                        <tr>
                            <th>GameID</th>
                            <th>帐号</th>
                            <th>昵称</th>
                            <th>输赢情况</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php echo ($vo["win"]); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
    <footer>
                    
    </footer>
</div>  
</body>
</html>