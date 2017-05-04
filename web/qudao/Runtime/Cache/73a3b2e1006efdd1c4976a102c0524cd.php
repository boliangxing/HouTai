<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>详细记录<span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/Index/control?type=1"><span style="color:#2996cc;">全局控制</span></a></span><span style="margin-left:30px;font-size:14px;"><a href="<?php echo WEB_ROOT?>index.php/Index/control?type=3"><span style="color:#2996cc;">用户控制</span></a></span></h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/Index/record_search" method="GET">
					<span>请输入游戏ID：</span>
					<input type="text" class="user_search_input" style="width:150px" name="GameID">
					<input class="user_search_submit" type="submit" value="查询">					
				</form>           
                
            </article>          

        </section>
    </div>
    <footer>
               
    </footer>
<script type="text/javascript">


	
</script>
</div>  
</body>
</html>