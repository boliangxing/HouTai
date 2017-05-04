<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="iphone_form">
                <header>
                    <h2>修改密码<span class="h2_right_2"><a href="<?php echo WEB_ROOT?>index.php/User/UserInfo?UserID=<?php echo $UserID?>">返回</a></span></h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/ChangePWD_do" method="post"  enctype="multipart/form-data">
                <input type="radio" name="Type" value="1" checked="checked" />只修改登陆&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="Type" value="2" />只修改银行 &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="Type" value="3" />都修改</br>
                <input type="hidden" name="UserID" value="<?php echo $UserID?>">
                	<span class="span_right">登陆密码：</span><input class='update_input' type="text" name="LogonPass"></br>
					<span class="span_right">重复密码：</span><input class='update_input' type="text" name="LogonAgain"></br>
					<span class="span_right">银行密码：</span><input class='update_input' type="text" name="InsurePass"></br>
					<span class="span_right">重复密码：</span><input class='update_input' type="text" name="InsureAgain"></br>
					<input class="submit" type="submit" value="完成">					
				</form>
            </article>
        </section>
    </div>
</div>  
</body>
</html>