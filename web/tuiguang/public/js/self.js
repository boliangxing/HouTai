$(document).ready(function(){
	//日历
    $('#nestable').nestable({
        group: 1
    })
    $(function(){
		$('.datepick').datepicker({dateFormat : 'yy-mm-dd',
			yearRange: '2015:2017',
			dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
            dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
            dayNamesMin: ['日','一','二','三','四','五','六'],
			monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
	});
    
    //页码样式添加
    var pageNo = getUrlParam('pageNo');
    //alert($('.page_no a').html());
    if(pageNo==null || pageNo == 1){
    	$('.page_no').removeClass('selected');
    	$('.page_no').eq(0).addClass('selected');
    }else if(pageNo>1){
    	$('.page_no').removeClass('selected');
    	$('.page_no a').each(function(){
    		if($(this).html() == pageNo){
    			$(this).parents('.page_no').addClass('selected');
    		}
    	})
    	
    }
    
    //页码数跳转
    $('#go').click(function(){   	
    	var no = parseInt($('#pages').val());
    	var page_num = $('.page_num').html();
    	if(no == null || no == ''){
    		alert('页数不能为空');
    		return false;
    	}
    	if(isNaN(no)){
    		alert('请输入数字');
    		return false;
    	}
    	if(no > page_num || no < 1){
    		alert('页数不能大于总页数，也不能小于1');
    		return false;
    	}    	
    	var pageNo = getUrlParam('pageNo');

    	if(pageNo == null){
    		var url = document.location.href;
    		new_url = url+'?pageNo='+no;
    		window.location.href = new_url;
    	}else{
    		var url = document.location.href;
    		var end = url.indexOf('?pageNo=');
    		new_url = url.substring(0,end+8)+no;
    		window.location.href = new_url;
    	}    	
    })
    
    
    //删除按钮提示
    $('.del').click(function(){
    	var r=confirm("确认删除该管理员吗？")
    	  if (r==false){
    		  return false;
    	  }   	
    });

    //删除按钮提示
    $('.delTs').click(function(){
        var r=confirm("确认删除吗？")
          if (r==false){
              return false;
          }     
    });
    
    //添加按钮点击验证
    $('.add_submit').click(function(){
    	var reg = /^[0-9a-zA-Z_]{6,20}$/;
    	var username = $('.add_user').val();
    	var password = $('.add_pwd').val();
    	if(!reg.test(username) || !reg.test(password)){
    		alert('用户名和密码为6-20位数字，字母，下划线组成');
    		return false;
    	} 	
    })
    
    //上传按钮点击验证
    $('.update_submit').click(function(){
    	var version = $('.update_input').val();
    	if(version == '' || version == null){
    		alert('版本号不能为空！');
    		return false;
    	}
    })
    
    //修改密码div显示
    $('.change_pwd').click(function(){
    	var show = $('.change_div').css('display');
    	if(show == 'none'){
    		$('.change_div').show();
    	}else{
    		$('.change_div').hide();
    	}
    })
    
    //修改密码确认
    $('#pwd_do').click(function(){
    	var pwd = $('#change_pwd').val();
    	var pwd2 = $('#re_pwd').val();
    	if(pwd.length < 6){
    		alert('密码长度应大于6位数');
    		return false;
    	}
    	if(pwd != pwd2){
    		alert('两次密码输入不一致');
    		return false;
    	}
    })
    
    //查看员权限隐藏
    var aa = $(".warp").attr('name');
    if(aa == 3){
    	$("#nestable[name='man']").hide();
    }
    if(aa != 3){
    	$("#nestable[name='aa']").hide();
    }
    
    //金币排行提交
    $("#gold_rank input:submit").click(function(){
    	if($("#s_num").val() == '' || $("#s_num").val() == null){
    		alert('请输入名次');
    		return false;
    	}    	
    	if(this.value == "身上查询"){
    		$("#s_type").val('1');    		
    	}
    	if(this.value == "银行查询"){
    		$("#s_type").val('2');    		
    	}
    	if(this.value == "总金币查询"){
    		$("#s_type").val('3');    		
    	}
    	$("#gold_rank").submit();
    })
    
    //列表图标显示
    $(".dd-item.c_off > button[data-action='collapse']").hide();
    $(".dd-item.c_off > button[data-action='expand']").show();
    
    
});

function changeinput(){
	var inputselect = document.getElementById("select_td");
	var inputquery = document.getElementById("query_td");
	if(inputquery.style.display==="none"){
		inputquery.style.display="inline-block";
		inputselect.style.display="none";
	}else{
		inputquery.style.display="none";
		inputselect.style.display="inline-block";
	}			
}

//获取url参数值
function getUrlParam(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	var r = window.location.search.substr(1).match(reg);  //匹配目标参数
	if (r!=null) return unescape(r[2]); return null; //返回参数值
}