<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_PATH?>styles/plugins/chosen/chosen.css">

        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>
添加渠道帐号&nbsp;&nbsp;&nbsp;&nbsp;
<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/qdqx">查看渠道权限</a>


<a style='color:#2996cc' href="<?php echo WEB_ROOT?>index.php/User/getqdqx">更改渠道权限</a>

</h2>
                </header>
				<form style='width:700px;padding:10px 100px;' action="" method="POST">
					<span>请输入帐号：</span>
          <input type="text" value="" name='username'  id="username">
          <span id="idrepeat" style="display:none">已存在</span>
        <br>
        <span>请输入密码：</span>
        <input type="text" value="" name='Password'  id="Password">
           <span>请输入渠道号：</span>
           <select data-placeholder="请选择渠道参数" class="chosen-select" multiple style="width:350px;" tabindex="4" id='game[]' name="game[]">


               <option value="1037">疯狂捕鱼-打鱼达人最爱的千炮猎鱼电玩城</option>
               <option value="3032">万炮捕鱼-打鱼达人天天玩的疯狂捕鱼机</option>
               <option value="3034">疯狂捕鱼-超级棋牌玩家最爱的自由交易游戏</option>

               <option value="3035">捕鱼大富豪-达人最爱的经典电玩城自由上下分
                 </option>
               <option value="3033">真人炸金花-棋牌土豪天天玩的经典下分诈金花</option>
               <option value="3031">疯狂炸金花-赢三张金三顺欢乐棋牌天地</option>
               <option value="3130">疯狂斗牛牛-全民掌上棋牌游戏休闲扑克</option>
                <option value="3039">火拼牛牛-</option>
               <option value="3036">斗地主 欢乐斗地主 单机版-经典升级游戏免费休闲棋牌</option>
               <option value="3037">金牌斗地主-</option>
               <option value="3037">欢乐街机电玩城-牛牛.捕鱼.百家乐.水浒传.连环夺宝火爆澳门赌场下分版自由交易游戏</option>
               <option value="3040">超级大富豪电玩城-</option>
        <option value="1024">全民炸金花</option>
        <option value="1025">欢乐炸金花</option>
        <option value="1026">天天炸金花</option>

        <option value="1027">万人炸金花</option>
        <option value="1028">火拼牛牛</option>
        <option value="1029">疯狂斗牛</option>
        <option value="1030">开心斗牛</option>
         <option value="1031">天天斗牛</option>
        <option value="1032">欢乐开心斗地主</option>
        <option value="1033">斗地主欢乐版</option>
        <option value="1034">开心斗地主</option>
        <option value="1035">疯狂斗地主</option>
        <option value="1036">万炮捕鱼</option>
        <option value="1137">疯狂捕鱼</option>
        <option value="1038">欢乐捕鱼</option>
        <option value="1039">全民捕鱼</option>

        <option value="1040">开心电玩城</option>
        <option value="1041">欢乐电玩城</option>

        <option value="1042">疯狂电玩城</option>
        <option value="1043">疯狂欢乐电玩城</option>
          <option value="20090">test</option>

           </select>
					<!-- <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" class="datepick" name="start_date" value=<?php echo ($start_date); ?>>&nbsp;-
                        <input type="text" class="datepick" name="end_date" value=<?php echo ($end_date); ?>>&nbsp;&nbsp; -->
                        <br>
					<input class="user_search_submit" type="submit" value="添加" id='tijiao'>
				</form>
                <div id="table_w">

                </div>
            </article>

        </section>
    </div>
</div>
</body>
<script src="<?php echo PUBLIC_PATH?>js/chosen.jquery.js"></script>
<script>

var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
    }
for (var selector in config) {
    $(selector).chosen(config[selector]);
}


</script>
<script>

 $("[name='username']").blur(function(){
     idval = $(this).val();
     $.ajax({
         type: "GET",
         url:  "<?php echo WEB_ROOT?>index.php/User/CheckUN",
         data: {id:idval},
         dataType: "script",
         success: function(data){
             if(data==0){
                 //返回焦点
                 $("[name='username']").focus();
                 $("#idrepeat").css('display','block')
             console.log(status);
             }else if(data==1){
                 $("#idrepeat").css('display',"none")
                 console.log(status);
             }
         }
     })
 });
</script>
</html>