<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="addM">
                <header>
                    <h2>关联号输赢总查询</h2>
                </header>
                <form action="#" method="GET">
                    <span style='padding-left: 180px;'>查询条件：</span>
                    <select name="type" id="select">
							<option value ="1">最后登录机器码</option>
                            <option value ="2">游戏ID</option>
                            <option value ="3">注册IP</option>
                            <option value ="4">最后登录IP</option>
                            <option value ="5">注册机器码</option>
							<option value ="6">身份证</option>

                    </select><input type="text" name="GameID" id='con'>
                    <input class="add_submit" type="button" value="查询">
                </form>

            </article>
            <article class="giveinfo">
                <header>
                    <h2>查询结果</h2>
                </header>
                <div id="table_w">
                    <span style='padding-left:500px;'>总：<span id='gl_sum'></span></span>
                    <table id="num">
                    <thead>
                        <tr>
                            <th>GameID</th>
                            <th>昵称</th>
                            <th>输赢情况</th>
                        </tr>
                    </thead>
                    <tbody id='gl'>
                        <!-- <?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/userInfo?UserID=<?php echo ($vo["UserID"]); ?>" target="_blank"><?php echo ($vo["GameID"]); ?></a></td>
                            <td><?php echo ($vo["Accounts"]); ?></td>
                            <td><?php echo ($vo["NickName"]); ?></td>
                            <td><?php echo ($vo["win"]); ?></td>
                        </tr><?php endforeach; endif; ?> -->
                    </tbody>

                </table>
                </div>
            </article>

        </section>
    </div>
    <footer>

    </footer>
</div>
<script src="<?php echo PUBLIC_PATH?>js/main.js"></script>
<script src="<?php echo PUBLIC_PATH?>js/mainConstant.js"></script>
<script src="<?php echo PUBLIC_PATH?>js/mainFunction.js"></script>
<script type="text/javascript">
loginhall("whatisthis","1");
$('.add_submit').click(function(){
    var type=$('#select').val();
    var con=$('#con').val();
    AdminSubmit(type,con);
    return false;
})
AdminSubmit(2,'778804');
</script>
</body>
</html>