/**
 * 获取所有人员信息
 */
function GetAllUser(){
	for(var i = 0;i<AllUserMap.size();i++){
		var user = AllUserMap.elements[i].value;
	}
}

/**
 * 玩家进入房间
 */
function UserInRoom(userinfo){
	console.log(userinfo.szNickName);
}

/**
 * 玩家离开房间
 */
function UserOutRoom(userinfo){
	
}

//发送
function AdminSubmit(type, szname){
	$('#gl').html('');
	SUM=0;
	if(IsLoginHall){
		var data = ConstructData(DBR_GP_QueryRelationWin);
		data.dwType	=	type;
		data.szName	=	szname;
		AdminSendData(MDM_GP_USER_SERVICE, SUB_GP_USER_RELATION_WIN, data, DBR_GP_QueryRelationWin);
	}else{
		setTimeout(function(){AdminSubmit(type, szname)},100);
	}
}
var SUM = 0;
//接受
function AdminAction(list){
	//console.log(fmoney(123456789,0));
	//var sum=0;
	var str='';
	for(var i=0;i<list.length;i++){
		//console.log(list[i].llScore +"   "+ SUM);
		SUM+=list[i].llScore;
		//console.log(SUM);
		str+='<tr>';
		str+='<td><a href="userInfo?UserID='+list[i].dwUserID+'" target="_blank">'+list[i].dwGameID+'</a></td>';
		str+='<td>'+list[i].szNickName+'</td>';
		str+='<td>'+fmoney(list[i].llScore,0)+'</td>';
		str+='</tr>';
		
	}
	$('#gl').append(str);
	$('#gl_sum').html(fmoney(SUM,0));
	$('#con').val('');
	//cbState	
	//dwUserID	
	//dwGameID	
	//szNickName	
	//llScore		
}
 

function fmoney(s, n)   
{   
   n = n > 0 && n <= 20 ? n : 2;   
   s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";   
   var l = s.split(".")[0].split("").reverse() ;
   var r = s.split(".")[1];   
   var t = "";   
   for(i = 0; i < l.length; i ++ )   
   {   
	   t += ((i+1)%3 == 1 && i>0 && ((i+1) != l.length || !isNaN(l[i])) ? "," : "") + l[i];
   }   
   return t.split("").reverse().join("");   
}
