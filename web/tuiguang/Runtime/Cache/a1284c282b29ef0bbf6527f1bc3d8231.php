<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
<style>
.box{
  width:300px;
  margin: 5px;
}

input{
	width:188px !important;
	float:right;
	margin-right:35px !important;
}
select{float:right;margin-right:120px;}
</style>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>添加渠道</h2>
                </header>

                <form action="<?php echo WEB_ROOT?>index.php/User/AddAndroidQd" method="GET">
                  <div class="box"><label>渠道&nbsp;&nbsp;&nbsp;&nbsp;ID:</label><input type="text" name="TypeID" value=""/></div>
				  <div class="box"><label>渠道名称:</label><input type="text" name="QdName" maxlength="18" value=""/></div>
                  <div class="box"><input type="submit" value="添加"/></div>
                </form>

            </article>

        </section>

    </div>
</div>
</body>
</html>