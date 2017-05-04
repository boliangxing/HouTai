<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
<style>
.box{
  width:300px;
  margin: 5px;
}
.box span{
  width: 98px;
  display: inline-block;
  height: 23px;
  border: 1px solid #d2d2d2;
  font-size: 14px;
  text-align: center;
  line-height: 23px;
  background: #fff;
}
label{
width:110px;
display:inline-block;
}
input{
  width:100px !important;
}
</style>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>修改渠道信息</h2>
                </header>

                <form action="<?php echo WEB_ROOT?>index.php/User/Edit_do" method="GET">
					<input type="hidden" name="UserID" value="<?php echo ($rs["UserID"]); ?>">
                  <div class="box"><label>账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号:</label><span><?php echo ($rs["Username"]); ?></span></div>
                  <div class="box"><label>渠&nbsp;&nbsp;&nbsp;&nbsp;道ID:</label><input type="text" name="TypeID" value="<?php echo ($rs["TypeID"]); ?>"/></div>
				  <div class="box"><label>渠道名称:</label><input type="text" name="QdName" value="<?php echo ($rs["QdName"]); ?>"/></div>
				  <div class="box"><label>比&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;例:</label><input type="text" name="Bili" value="<?php echo ($rs["Bili"]); ?>"/></div>
                  <div class="box"><label>类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型:</label>
                    <select name="QdType" value="<?php echo ($rs["QdType"]); ?>">
                      <option value="0" <?php if($rs["QdType"] == 0): ?>selected="selected"<?php endif; ?>>CPA</option>
                      <option value="1" <?php if($rs["QdType"] == 1): ?>selected="selected"<?php endif; ?>>CPS</option>

                    </select>
					
                  </div>
                  <div class="box"><label>单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价:</label><input type="text" name="Price" value="<?php echo ($rs["Price"]); ?>"/></div>
				  <div class="box"><label>是否启用比例:</label>
                    <select name="IsUsed" value="<?php echo ($rs["IsUsed"]); ?>">
                      <option value="0" <?php if($rs["IsUsed"] == 0): ?>selected="selected"<?php endif; ?>>未启用</option>
                      <option value="1" <?php if($rs["IsUsed"] == 1): ?>selected="selected"<?php endif; ?>>启用</option>
                    </select>
                  </div>
                  <div class="box"><input type="submit" value="修改" style="margin-left:40px; margin-top:10px;"/></div>
                </form>

            </article>

        </section>

    </div>
</div>
</body>
</html>