<script src="http://api.wkz8.com/third/im/layui/layui.js" tppabs=""></script>

<script src="http://api.wkz8.com/third/im/kefu.js" tppabs=""></script>

<script>
    layui.use(['jquery'],function(){
         __jq__ = layui.jquery;
          // 添加样式和浮客服动框
            __jq__('body').append('<style>.wm-kf-box{color:#fff;;z-index:29891016;height:99px;text-align:center;border-bottom:1px solid #8dc7ff;cursor:pointer;background-color:#378fe5;width:67px;position:fixed;top: 50%;right:0px;font-size:12px;} .wm-kf-sp{background:url(icon-sprite.png) no-repeat;display: inline-block;zoom: 1;width: 67px;height: 30px;margin-top: 28px;overflow: hidden;background-position: 20px 0px;} </style>');
            __jq__('body').append('<div class="wm-kf-box" onclick="mmmm_kefu.IsPC() ? f() : $(\'#layui-m-layer0\').toggle();"> <i class="wm-kf-sp"></i> <p>在线咨询</p> </div>');


    })
    //$(\'#layui-m-layer0\').toggle()
    function f(){
        layui.use('layim', function(layim){
          layim.config({
             min:true
          })
        })
    }
</script>
