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

                <form action="<?php echo WEB_ROOT?>index.php/User/AddQd" method="GET">
                  <div class="box"><label>账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号:</label><input type="text" name="Username" maxlength="18" value=""/></div>
                  <div class="box"><label>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:</label><input type="text" name="Password" maxlength="18" value=""/></div>
                  <div class="box"><label>渠道&nbsp;&nbsp;&nbsp;&nbsp;ID:</label><input type="text" name="TypeID" value=""/></div>
				  <div class="box"><label>渠道名称:</label><input type="text" name="QdName" maxlength="18" value=""/></div>
				  <div class="box"><label>比&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;例:</label><input type="text" name="Bili" value=""/></div>
                  <div class="box"><label>类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型:</label>
                    <select name="QdType">
                      <option value="0">CPA</option>
                      <option value="1">CPS</option>
                    </select>
                  </div>
                  <div class="box"><label>单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价:</label><input type="text" name="Price" value=""/></div>
				  <div class="box"><label>是否启用比例:</label>
                    <select name="IsUsed">
                      <option value="0">未启用</option>
                      <option value="1">启用</option>
                    </select>
                  </div>
                  <div class="box"><input type="submit" value="添加"/></div>
                </form>

            </article>

        </section>

    </div>
</div>
</body>
</html>