//	常量定义
var CMD_MD5_KEY = "~~663dskojfasjfk44..~~";

//内核命令
var MDM_KN_COMMAND				=	0							//内核命令
var SUB_KN_DETECT_SOCKET		=	1							//检测命令
var SUB_KN_VALIDATE_SOCKET		=	2							//验证命令
var MDM_KN_COMMAND_LAJI			=	65534						//内核命令
var MDM_KN_COMMAND_LAJI2		=	65533						//内核命令
var MDM_KN_COMMAND_LAJI3		=	65532

var SOCKET_TCP_BUFFER			=	16384						//网络缓冲
var ID_CREATE_EXE				=	2060

//发送映射
var g_SendByteMap=
[
0x70,0x2F,0x40,0x5F,0x44,0x8E,0x6E,0x45,0x7E,0xAB,0x2C,0x1F,0xB4,0xAC,0x9D,0x91,
0x0D,0x36,0x9B,0x0B,0xD4,0xC4,0x39,0x74,0xBF,0x23,0x16,0x14,0x06,0xEB,0x04,0x3E,
0x12,0x5C,0x8B,0xBC,0x61,0x63,0xF6,0xA5,0xE1,0x65,0xD8,0xF5,0x5A,0x07,0xF0,0x13,
0xF2,0x20,0x6B,0x4A,0x24,0x59,0x89,0x64,0xD7,0x42,0x6A,0x5E,0x3D,0x0A,0x77,0xE0,
0x80,0x27,0xB8,0xC5,0x8C,0x0E,0xFA,0x8A,0xD5,0x29,0x56,0x57,0x6C,0x53,0x67,0x41,
0xE8,0x00,0x1A,0xCE,0x86,0x83,0xB0,0x22,0x28,0x4D,0x3F,0x26,0x46,0x4F,0x6F,0x2B,
0x72,0x3A,0xF1,0x8D,0x97,0x95,0x49,0x84,0xE5,0xE3,0x79,0x8F,0x51,0x10,0xA8,0x82,
0xC6,0xDD,0xFF,0xFC,0xE4,0xCF,0xB3,0x09,0x5D,0xEA,0x9C,0x34,0xF9,0x17,0x9F,0xDA,
0x87,0xF8,0x15,0x05,0x3C,0xD3,0xA4,0x85,0x2E,0xFB,0xEE,0x47,0x3B,0xEF,0x37,0x7F,
0x93,0xAF,0x69,0x0C,0x71,0x31,0xDE,0x21,0x75,0xA0,0xAA,0xBA,0x7C,0x38,0x02,0xB7,
0x81,0x01,0xFD,0xE7,0x1D,0xCC,0xCD,0xBD,0x1B,0x7A,0x2A,0xAD,0x66,0xBE,0x55,0x33,
0x03,0xDB,0x88,0xB2,0x1E,0x4E,0xB9,0xE6,0xC2,0xF7,0xCB,0x7D,0xC9,0x62,0xC3,0xA6,
0xDC,0xA7,0x50,0xB5,0x4B,0x94,0xC0,0x92,0x4C,0x11,0x5B,0x78,0xD9,0xB1,0xED,0x19,
0xE9,0xA1,0x1C,0xB6,0x32,0x99,0xA3,0x76,0x9E,0x7B,0x6D,0x9A,0x30,0xD6,0xA9,0x25,
0xC7,0xAE,0x96,0x35,0xD0,0xBB,0xD2,0xC8,0xA2,0x08,0xF3,0xD1,0x73,0xF4,0x48,0x2D,
0x90,0xCA,0xE2,0x58,0xC1,0x18,0x52,0xFE,0xDF,0x68,0x98,0x54,0xEC,0x60,0x43,0x0F
];

//接收映射
var g_RecvByteMap=
[
0x51,0xA1,0x9E,0xB0,0x1E,0x83,0x1C,0x2D,0xE9,0x77,0x3D,0x13,0x93,0x10,0x45,0xFF,
0x6D,0xC9,0x20,0x2F,0x1B,0x82,0x1A,0x7D,0xF5,0xCF,0x52,0xA8,0xD2,0xA4,0xB4,0x0B,
0x31,0x97,0x57,0x19,0x34,0xDF,0x5B,0x41,0x58,0x49,0xAA,0x5F,0x0A,0xEF,0x88,0x01,
0xDC,0x95,0xD4,0xAF,0x7B,0xE3,0x11,0x8E,0x9D,0x16,0x61,0x8C,0x84,0x3C,0x1F,0x5A,
0x02,0x4F,0x39,0xFE,0x04,0x07,0x5C,0x8B,0xEE,0x66,0x33,0xC4,0xC8,0x59,0xB5,0x5D,
0xC2,0x6C,0xF6,0x4D,0xFB,0xAE,0x4A,0x4B,0xF3,0x35,0x2C,0xCA,0x21,0x78,0x3B,0x03,
0xFD,0x24,0xBD,0x25,0x37,0x29,0xAC,0x4E,0xF9,0x92,0x3A,0x32,0x4C,0xDA,0x06,0x5E,
0x00,0x94,0x60,0xEC,0x17,0x98,0xD7,0x3E,0xCB,0x6A,0xA9,0xD9,0x9C,0xBB,0x08,0x8F,
0x40,0xA0,0x6F,0x55,0x67,0x87,0x54,0x80,0xB2,0x36,0x47,0x22,0x44,0x63,0x05,0x6B,
0xF0,0x0F,0xC7,0x90,0xC5,0x65,0xE2,0x64,0xFA,0xD5,0xDB,0x12,0x7A,0x0E,0xD8,0x7E,
0x99,0xD1,0xE8,0xD6,0x86,0x27,0xBF,0xC1,0x6E,0xDE,0x9A,0x09,0x0D,0xAB,0xE1,0x91,
0x56,0xCD,0xB3,0x76,0x0C,0xC3,0xD3,0x9F,0x42,0xB6,0x9B,0xE5,0x23,0xA7,0xAD,0x18,
0xC6,0xF4,0xB8,0xBE,0x15,0x43,0x70,0xE0,0xE7,0xBC,0xF1,0xBA,0xA5,0xA6,0x53,0x75,
0xE4,0xEB,0xE6,0x85,0x14,0x48,0xDD,0x38,0x2A,0xCC,0x7F,0xB1,0xC0,0x71,0x96,0xF8,
0x3F,0x28,0xF2,0x69,0x74,0x68,0xB7,0xA3,0x50,0xD0,0x79,0x1D,0xFC,0xCE,0x8A,0x8D,
0x2E,0x62,0x30,0xEA,0xED,0x2B,0x26,0xB9,0x81,0x7C,0x46,0x89,0x73,0xA2,0xF7,0x72
];

//数据类型
var DK_MAPPED			=	0X01;//映射类型
var DK_ENCRYPT			=	0X02;//加密类型
var DK_COMPRESS			=	0X04;//压缩类型

//机器标识
var LEN_MACHINE_ID		=	33						//序列长度
var LEN_NETWORK_ID		=	13						//网卡长度

//资料数据
var LEN_MD5				=	33						//加密密码
var LEN_ACCOUNTS		=	32						//备注长度
var LEN_PASS_PORT_ID    =	19                      //证件号码长度
var LEN_NICENAME		=	32						//帐号长度	
var LEN_NICKNAME		=	32						//昵称长度
var LEN_PASSWORD		=	33						//密码长度	
var LEN_GROUP_NAME		=	32						//社团名字	
var LEN_UNDER_WRITE		=	32						//个性签名

//数据长度
var LEN_QQ				=	16						//q q号码
var LEN_EMAIL			=	33						//电子邮件
var LEN_USER_NOTE		=	256						//用户备注
var LEN_SEAT_PHONE		=	33						//固定电话
var LEN_MOBILE_PHONE	=	12						//移动电话
var Len_PASS_PORT_ID	=	19						//证件号码
var LEN_COMPELLATION	=	16						//真实名字
var LEN_DWELLING_PLACE	=	128						//联系地址

var LEN_QUESTION        =	256
var LEN_ANSWER          =	30
var LEN_LUCKY_RESULT    =	10

//机器标识
var LEN_MACHINE_ID		=	33						//序列长度
var LEN_NETWORK_ID		=	13						//网卡长度

//列表数据
var LEN_TYPE			=	32						//种类长度
var LEN_KIND			=	32						//类型长度	
var LEN_NODE			=	32						//节点长度
var LEN_PAGE			=	32						//定制长度
var LEN_SERVER			=	32						//房间长度
var LEN_PROCESS			=	32						//进程长度

//游戏状态
var	GAME_STATUS_FREE	=	0						//空闲状态
var	GAME_STATUS_PLAY	=	100						//游戏状态
var GAME_STATUS_WAIT	=	200						//等待状态
var GAME_STATUS_ENDED   =	255                     //结束状态

//系统参数
var LEN_USER_CHAT		=	128						//聊天长度
var	TIME_USER_CHAT		=	1						//聊天间隔
var TRUMPET_MAX_CHAR    =	128                     //喇叭长度

//验证码取数位置
var yueding1			=	7
var yueding2			=	53
var yueding3			=	88
var yueding4			=	122

//携带信息

//其他信息
var DTP_GR_TABLE_PASSWORD	=	1					//桌子密码

//用户属性
var DTP_GR_NICK_NAME	=	10						//用户昵称
var DTP_GR_GROUP_NAME	=	11						//社团名字
var DTP_GR_UNDER_WRITE	=	12						//个性签名
var DTP_GR_USER_QQ		=	13

var	US_NULL				=	0						//没有状态
var US_FREE				=	1						//站立状态
var US_SIT				=	2						//坐下状态
var US_READY			=	3						//同意状态
var US_LOOKON			=	4						//旁观状态
var US_PLAYING			=	5						//游戏状态
var US_OFFLINE			=	6						//断线状态

//参数定义
var	INVALID_CHAIR		=	65535					//无效椅子
var	INVALID_TABLE		=	65535					//无效桌子
var INVALID_USERID		=	0						//无效用户

//变化原因
var SCORE_REASON_WRITE			=	0           	//写分变化
var SCORE_REASON_INSURE			=	1          		//银行变化
var SCORE_REASON_PROPERTY		=	2           	//道具变化
var SCORE_REASON_MATCH_FEE		=	3           	//比赛报名
var SCORE_REASON_MATCH_QUIT		=	4           	//比赛退赛

//答题消息
var MDM_MAIN_LOGON_QUESTION     =	10

var SUB_LOGON_QUESTION          =	9
var SUB_QUESTION_ANSWER         =	8
var SUB_REWARDS_COUNT           =	7  				//获得奖励用户
var SUB_REWARDS_RESULT          =	6  				//写奖励

var MDM_MISSION_QUESTION        =	20
var SUB_MISSION_C_QUESTION      =	19
var SUB_MISSION_SUCCESS         =	18 
var SUB_MISSION_COUNT           =	17
var SUB_MISSION_C_REWARDS       =	16  			//随机奖励数量
var SUB_MISSION_C_LUCK_RESULT   =	15  			//转盘是否开始

var PROPERTY_ID_TRUMPET			=   19				//喇叭道具
var PROPERTY_ID_TYPHON		    =	20				//喇叭道具
function Map() {
	this.elements = new Array();
	
	//获取MAP元素个数
	this.size = function() {
		return this.elements.length;
	}
	
	//判断MAP是否为空
	this.isEmpty = function() {
		return (this.elements.length < 1);
	}
	
	//删除MAP所有元素
	this.clear = function() {
		this.elements = new Array();
	}
	
	//向MAP中增加元素（key, value) 
	this.put = function(_key, _value) {
		this.remove(_key);//清除已有的key
		this.elements.push( {
			key : _key,
			value : _value
		
		});
	}
	
	//删除指定KEY的元素，成功返回True，失败返回False
	this.remove = function(_key) {
		var bln = false;
		try {
			for (i = 0;i < this.elements.length;i++) {
				if (this.elements[i].key == _key) {
					this.elements.splice(i, 1);
					return true;
				}
			}
		}
		catch (e) {
			bln = false;
		}
		return bln;
	}
	
	//获取指定KEY的元素值VALUE，失败返回NULL
	this.get = function(_key) {
		try {
			for (i = 0;i < this.elements.length;i++) {
				if (this.elements[i].key == _key) {
					return this.elements[i].value;
				}
			}
		}
		catch (e) {
			return null;
		}
	}
	
	//获取指定索引的元素（使用element.key，element.value获取KEY和VALUE），失败返回NULL
	this.element = function(_index) {
		if (_index < 0 || _index >= this.elements.length) {
			return null;
		}
		return this.elements[_index];
	}
	
	//判断MAP中是否含有指定KEY的元素
	this.containsKey = function(_key) {
		var bln = false;
		try {
			for (i = 0;i < this.elements.length;i++) {
				if (this.elements[i].key == _key) {
					bln = true;
				}
			}
		}
		catch (e) {
			bln = false;
		}
		return bln;
	}
	
	//判断MAP中是否含有指定VALUE的元素
	this.containsValue = function(_value) {
		var bln = false;
		try {
			for (i = 0;i < this.elements.length;i++) {
				if (this.elements[i].value == _value) {
					bln = true;
				}
			}
		}
		catch (e) {
			bln = false;
		}
		return bln;
	}
	
	//获取MAP中所有VALUE的数组（ARRAY）
	this.values = function() {
		var arr = new Array();
		for (i = 0;i < this.elements.length;i++) {
			arr.push(this.elements[i].value);
		}
		return arr;
	}
	
	//获取MAP中所有KEY的数组（ARRAY）
	this.keys = function() {
		var arr = new Array();
		for (i = 0;i < this.elements.length;i++) {
			arr.push(this.elements[i].key);
		}
		return arr;
	}
}
var hex_chr = "0123456789abcdef";
function rhex(num) {
	str = "";
	for(j = 0;j <= 3;j++) 
	str += hex_chr.charAt((num >> (j * 8 + 4)) & 0x0F) + 
	hex_chr.charAt((num >> (j * 8)) & 0x0F);
	return str;
}
function str2blks_MD5(str) {
	nblk = ((str.length + 8) >> 6) + 1;
	blks = new Array(nblk * 16);
	for(i = 0;i < nblk * 16;i++) blks[i] = 0;
	for(i = 0;i < str.length;i++) 
	blks[i >> 2] |= str.charCodeAt(i) << ((i % 4) * 8);
	blks[i >> 2] |= 0x80 << ((i % 4) * 8);
	blks[nblk * 16 - 2] = str.length * 8;
	return blks;
}
function add(x, y) {
	var lsw = (x & 0xFFFF) + (y & 0xFFFF);
	var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
	return (msw << 16) | (lsw & 0xFFFF);
}
function rol(num, cnt) {
	return (num << cnt) | (num >>> (32 - cnt));
}
function cmn(q, a, b, x, s, t) {
	return add(rol(add(add(a, q), add(x, t)), s), b);
}
function ff(a, b, c, d, x, s, t) {
	return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function gg(a, b, c, d, x, s, t) {
	return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function hh(a, b, c, d, x, s, t) {
	return cmn(b ^ c ^ d, a, b, x, s, t);
}
function ii(a, b, c, d, x, s, t) {
	return cmn(c ^ (b | (~d)), a, b, x, s, t);
}
function MD5(str) {
	x = str2blks_MD5(str);
	var a = 1732584193;
	var b = -271733879;
	var c = -1732584194;
	var d = 271733878;
	for(i = 0;i < x.length;i += 16) {
		var olda = a;
		var oldb = b;
		var oldc = c;
		var oldd = d;
		a = ff(a, b, c, d, x[i+ 0], 7 , -680876936);
		d = ff(d, a, b, c, x[i+ 1], 12, -389564586);
		c = ff(c, d, a, b, x[i+ 2], 17, 606105819);
		b = ff(b, c, d, a, x[i+ 3], 22, -1044525330);
		a = ff(a, b, c, d, x[i+ 4], 7 , -176418897);
		d = ff(d, a, b, c, x[i+ 5], 12, 1200080426);
		c = ff(c, d, a, b, x[i+ 6], 17, -1473231341);
		b = ff(b, c, d, a, x[i+ 7], 22, -45705983);
		a = ff(a, b, c, d, x[i+ 8], 7 , 1770035416);
		d = ff(d, a, b, c, x[i+ 9], 12, -1958414417);
		c = ff(c, d, a, b, x[i+10], 17, -42063);
		b = ff(b, c, d, a, x[i+11], 22, -1990404162);
		a = ff(a, b, c, d, x[i+12], 7 , 1804603682);
		d = ff(d, a, b, c, x[i+13], 12, -40341101);
		c = ff(c, d, a, b, x[i+14], 17, -1502002290);
		b = ff(b, c, d, a, x[i+15], 22, 1236535329);
		a = gg(a, b, c, d, x[i+ 1], 5 , -165796510);
		d = gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
		c = gg(c, d, a, b, x[i+11], 14, 643717713);
		b = gg(b, c, d, a, x[i+ 0], 20, -373897302);
		a = gg(a, b, c, d, x[i+ 5], 5 , -701558691);
		d = gg(d, a, b, c, x[i+10], 9 , 38016083);
		c = gg(c, d, a, b, x[i+15], 14, -660478335);
		b = gg(b, c, d, a, x[i+ 4], 20, -405537848);
		a = gg(a, b, c, d, x[i+ 9], 5 , 568446438);
		d = gg(d, a, b, c, x[i+14], 9 , -1019803690);
		c = gg(c, d, a, b, x[i+ 3], 14, -187363961);
		b = gg(b, c, d, a, x[i+ 8], 20, 1163531501);
		a = gg(a, b, c, d, x[i+13], 5 , -1444681467);
		d = gg(d, a, b, c, x[i+ 2], 9 , -51403784);
		c = gg(c, d, a, b, x[i+ 7], 14, 1735328473);
		b = gg(b, c, d, a, x[i+12], 20, -1926607734);
		a = hh(a, b, c, d, x[i+ 5], 4 , -378558);
		d = hh(d, a, b, c, x[i+ 8], 11, -2022574463);
		c = hh(c, d, a, b, x[i+11], 16, 1839030562);
		b = hh(b, c, d, a, x[i+14], 23, -35309556);
		a = hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
		d = hh(d, a, b, c, x[i+ 4], 11, 1272893353);
		c = hh(c, d, a, b, x[i+ 7], 16, -155497632);
		b = hh(b, c, d, a, x[i+10], 23, -1094730640);
		a = hh(a, b, c, d, x[i+13], 4 , 681279174);
		d = hh(d, a, b, c, x[i+ 0], 11, -358537222);
		c = hh(c, d, a, b, x[i+ 3], 16, -722521979);
		b = hh(b, c, d, a, x[i+ 6], 23, 76029189);
		a = hh(a, b, c, d, x[i+ 9], 4 , -640364487);
		d = hh(d, a, b, c, x[i+12], 11, -421815835);
		c = hh(c, d, a, b, x[i+15], 16, 530742520);
		b = hh(b, c, d, a, x[i+ 2], 23, -995338651);
		a = ii(a, b, c, d, x[i+ 0], 6 , -198630844);
		d = ii(d, a, b, c, x[i+ 7], 10, 1126891415);
		c = ii(c, d, a, b, x[i+14], 15, -1416354905);
		b = ii(b, c, d, a, x[i+ 5], 21, -57434055);
		a = ii(a, b, c, d, x[i+12], 6 , 1700485571);
		d = ii(d, a, b, c, x[i+ 3], 10, -1894986606);
		c = ii(c, d, a, b, x[i+10], 15, -1051523);
		b = ii(b, c, d, a, x[i+ 1], 21, -2054922799);
		a = ii(a, b, c, d, x[i+ 8], 6 , 1873313359);
		d = ii(d, a, b, c, x[i+15], 10, -30611744);
		c = ii(c, d, a, b, x[i+ 6], 15, -1560198380);
		b = ii(b, c, d, a, x[i+13], 21, 1309151649);
		a = ii(a, b, c, d, x[i+ 4], 6 , -145523070);
		d = ii(d, a, b, c, x[i+11], 10, -1120210379);
		c = ii(c, d, a, b, x[i+ 2], 15, 718787259);
		b = ii(b, c, d, a, x[i+ 9], 21, -343485551);
		a = add(a, olda);
		b = add(b, oldb);
		c = add(c, oldc);
		d = add(d, oldd);
	}
	return rhex(a) + rhex(b) + rhex(c) + rhex(d);
}//	通信协议常量定义
var MB_VALIDATE_FLAGS           =	0x01                                //效验密保
var LOW_VER_VALIDATE_FLAGS      =	0x02                                //效验低版本

var SUB_GP_SNED_EFFICACY     =	6   //发送验证码
var SUB_GP_LOCK_MOBILE       =	7   //验证码

//TODO:登陆命令
var MDM_GP_LOGON				=	1				//广场登陆

//登陆模式
var SUB_MB_LOGON_GAMEID			=	1				//I D登陆
var SUB_GP_LOGON_ACCOUNTS		=	2				//帐号登陆
var SUB_MB_REGISITER_ACCOUNTS	=	3				//注册帐号
var SUB_GP_REGISTER_ACCOUNTS	=	3				//注册帐号
var SUB_GP_GET_PASSPORT		    =	16				//获取验证码
var SUB_MB_ANONYMOUS_LOGON      =	4				//手机快速注册登录
var SUB_MB_ANONYMOUS_LOGON_NEO  =	8				//手机快速注册登录
var SUB_MB_SEND_IDENTIFYING		=	5				//完善资料验证码
var SUB_MB_PERFECT_INFO			=	6				//完善资料
var SUB_MB_LOGON_ACCOUNTS_NEO	=	9				//帐号登陆(带手机验证码)
var SUB_GP_CHECK_UPDATE         =	40				//检查后台更新
var SUB_GP_QUERYLABA			=	60				//查询喇叭
var SUB_GP_QUERY_MESSAGE		=	70				//请求大厅喇叭

//登陆结果
var SUB_GP_GET_PASSPORT_SUCCESS	=	110				//获取注册验证码成功
var SUB_GP_LOGON_SUCCESS		=	100				//登录成功
var SUB_GP_LOGON_FAILURE		=	101				//登录失败
var SUB_GP_LOGON_FINISH			=	102				//登录完成
var SUB_GP_UPDATE_RETRUN        =	115
var SUB_GP_NEXT_UPDATE          =	116				//没更新 下一次检查时间

var SUB_MB_PERFECT_SUCCESS		=	102             //手机完善资料成功
var SUB_MB_PERFECT_FAILURE		=	103				//手机完善资料失败
var SUB_MB_SEND_FINISH			=	104             //手机验证码发送完成
var SUB_MB_VERIFYFAILURE		=	105             //验证码验证失败
var SUB_GP_CONSTRAINT			=	130				//强制更新新版本下载
var SUB_GP_GET_PLAZA_MESSAGECONTS=	150				//大厅喇叭同步数量
var SUB_GP_GET_SPEAKERINFO		=	160				//喇叭内容
var SUB_GP_SPEAKER_FINISH		=	170				//喇叭发送完成

//升级提示
var SUB_GP_UPDATE_NOTIFY		=	200									//升级提示

var MDM_GP_SERVER_LIST			=	2									//列表信息

var SUB_GP_LIST_TYPE			=	100									//类型列表
var SUB_GP_LIST_KIND			=	101									//种类列表
var SUB_GP_LIST_SERVER          =	104                                 //房间列表
var SUB_GP_GET_SYSTEM_MESSAGE   =	108                                 //获取公告
var SUB_GP_GET_NEWSUM           =	109                                 //获取公告数量
var SUB_GP_LIST_FINISH			=	200									//发送完成
//升级提示
var SUB_MB_UPDATE_NOTIFY		=	200				//升级提示

//appCheck
var MDM_MB_LOGON                =	100
var SUB_MB_IOS_CHECK_VER        =	10           //请求是否更新，是否全显示
var SUB_GP_IOS_CHECKVER         =	113           //成功

//TODO:服务命令
var MDM_GP_USER_SERVICE         =	3                                   //用户服务

//帐号服务
var SUB_GP_MODIFY_MACHINE       =	100                                 //修改机器
var SUB_GP_MODIFY_LOGON_PASS    =	101                                 //修改登录密码
var SUB_GP_MODIFY_INSURE_PASS   =	102                                 //修改保险箱密码
var SUB_GP_MODIFY_UNDER_WRITE   =	103                                 //修改签名

var SUB_GP_USER_FACE_INFO		=	200									//头像信息
var SUB_GP_SYSTEM_FACE_INFO		=	201									//系统头像

var SUB_GP_USER_INDIVIDUAL		=	301									//个人资料
var	SUB_GP_QUERY_INDIVIDUAL		=	302									//查询信息
var SUB_GP_MODIFY_INDIVIDUAL	=	303									//修改资料

//银行服务
var SUB_GP_USER_SAVE_SCORE		=	400									//存款操作
var SUB_GP_USER_TAKE_SCORE		=	401									//取款操作
var SUB_GP_USER_TRANSFER_SCORE	=	402									//转账操作
var SUB_GP_QUERY_INSURE_INFO	=	404									//查询银行
var SUB_GP_USER_INSURE_INFO		=	403									//银行资料
var SUB_GP_USER_INSURE_SUCCESS	=	405									//银行成功
var SUB_GP_USER_INSURE_FAILURE	=	406									//银行失败
var SUB_GP_QUERY_USER_INFO_REQUEST	=	407								//查询用户
var SUB_GP_QUERY_USER_INFO_RESULT	=	408								//用户信息
var SUB_GP_USER_LOGONBANK		=	409						    		//登录银行
var  SUB_GP_LOGONBANK_SUCCESS	=	410						    		//登录银行成功
var  SUB_GP_LOGONBANK_FAILURE	=	411						    		//登录银行失败
var SUB_GP_QUERY_BANK_DETAIL	=	412									//转账明细查询
var SUB_GP_BANK_DETAIL_RESULT	=	413									//转账明细结果
var SUB_GR_QUERY_RETURN         =	419
var SUB_GR_GETUSER_SCORE        =	420
var SUB_GR_QUERY_RETURN_SCORE   =	430
var SUB_CHANGE_RETURN_INFO      =	431
//操作结果
var SUB_GP_OPERATE_SUCCESS      =	900									//操作成功
var SUB_GP_OPERATE_FAILURE      =	901                                 //操作失败


var DTP_GP_UI_NICKNAME			=	1									//用户昵称
var DTP_GP_UI_USER_NOTE			=	2									//用户说明
var DTP_GP_UI_UNDER_WRITE		=	3									//个性签名
var DTP_GP_UI_QQ				=	4									//Q Q 号码
var DTP_GP_UI_EMAIL				=	5									//电子邮件
var DTP_GP_UI_SEAT_PHONE		=	6									//固定电话
var DTP_GP_UI_MOBILE_PHONE		=	7									//移动电话
var DTP_GP_UI_COMPELLATION		=	8									//真实名字
var DTP_GP_UI_DWELLING_PLACE	=	9									//联系地址


/////////////////房间登录//////////////////////////////////////////////////////////
//登录命令
var MDM_GR_LOGON				=	1									//登录信息


var SUB_GR_LOGON_USERID			=	1									//id 登录

var SUB_GR_LOGON_SUCCESS		=	100									//登录成功
var SUB_GR_LOGON_FAILURE		=	101									//登录失败
var SUB_GR_LOGON_FINISH			=	102									//登录完成


var SUB_GR_UPDATE_NOTIFY		=	200									//升级提示


/////////////////////房间配置/////////////////////////////////////////////////////
var MDM_GR_CONFIG				=	2									//配置信息

var SUB_GR_CONFIG_COLUMN		=	100									//列表配置
var SUB_GR_CONFIG_SERVER		=	101									//房间配置
var SUB_GR_CONFIG_PROPERTY		=	102									//道具配置
var SUB_GR_CONFIG_FINISH		=	103									//配置完成
var SUB_GR_CONFIG_USER_RIGHT	=	104									//玩家权限

/////////////////////////////////////////////////////////////////////////////////
var MDM_GR_USER					=	3									//用户信息

//用户动作
var SUB_GR_USER_RULE			=	1									//用户规则
var SUB_GR_USER_LOOKON			=	2									//旁观请求
var SUB_GR_USER_SITDOWN			=	3									//坐下请求
var SUB_GR_USER_STANDUP			=	4									//起立请求
var SUB_GR_USER_INVITE			=	5									//用户邀请
var SUB_GR_USER_INVITE_REQ		=	6									//邀请请求
var SUB_GR_USER_REPULSE_SIT  	=	7									//拒绝玩家坐下
var SUB_GR_USER_KICK_USER       =	8                                   //踢出用户
var SUB_GR_USER_INFO_REQ        =	9                                   //请求用户信息
var SUB_GR_USER_CHAIR_REQ       =	10                                  //请求更换位置
var SUB_GR_USER_CHAIR_INFO_REQ  =	11                                  //请求椅子用户信息
var SUB_GR_USER_WAIT_DISTRIBUTE =	12									//等待分配
var SUB_GR_USER_CONTROL			=	13
var SUB_GR_USER_DISTRIBUTION	=	14									//分配请求
var SUB_GR_REQUEST_PROPERTY_COST=	60                                  //
var SUB_GR_QUEST_PROPERTY_SUCCESS=	70                               	//发送道具价格成功

//-------------------//控制命令
var SUB_GR_USER_CONTROL_XM		=	15                               //用户控制命令，点击控制按钮         
var SUB_GR_USER_LOGON_MASTER	=	16                               //用户控制登录


//用户状态
var SUB_GR_USER_ENTER			=	100									//用户进入
var SUB_GR_USER_SCORE			=	101									//用户分数
var SUB_GR_USER_STATUS			=	102									//用户状态
var SUB_GR_REQUEST_FAILURE		=	103									//请求失败
var SUB_GR_REQUEST_SUCCESS		=	104									//请求成功
var SUB_GR_MASTERLOGON_FAILURE	=	105									//请求成功
var SUB_GR_IPHONE_SUCCESS       =	106                                   //手机检测成功

//----------发送命令-ID输赢控制
var SUB_GR_USER_CONTROL_XMS		=	115                               //发送信息 弹出控制框
var SUB_GR_USER_CONTROL_XMS_ONE	=	116                               //发送被控人数，服务器—》客户端


var SUB_GR_USER_CONTROL_XMS_PM	=	117                               //发送被控pc和mob，客户端 —》服务器
var SUB_GR_USER_CONTROL_XMS_CON	=	118                               //发送被控人，客户端 —》服务器
var SUB_GR_USER_CONTROL_XMS_ROM	=	119                               //发送删除的控制者，客户端 —》服务器

var SUB_GR_USER_CONTROL_XMS_UPONE	=	120                               //发送被控人数，服务器—》客户端
var SUB_GR_USER_CONTROL_XMS_UPTAB	=	121                               //发送被控人数，服务器—》客户端
var SUB_GR_USER_CONTROL_XMS_FINSH	=	122                               //发送被控人数，服务器—》客户端
var SUB_GR_USER_CONTROL_XMS_DELONE	=	123                               //发送被控人数，服务器—》客户端
//---------发送命令-Table输赢控制

var SUB_GR_USER_CONTROL_TAB		    =	130                              //发送信息 弹出控制框  客户端 —》服务器
var SUB_GR_USER_CONTROL_TAB_ONE		=	131                              //发送信息 读出文件  服务器—》客户端

var SUB_GR_USER_CONTROL_TAB_CHANG   =	132                             //发送信息 确定操作
//var SUB_GR_USER_CONTROL_TAB_ROM          123                             //发送信息 删除操作
/////////////////////////////////////////////////////////////////////////////////

//聊天命令
var SUB_GR_USER_CHAT			=	/*201*/211									//聊天消息
var SUB_GR_USER_EXPRESSION		=	/*202*/212									//表情消息
var SUB_GR_WISPER_CHAT			=	/*203*/213									//私聊消息
var SUB_GR_WISPER_EXPRESSION	=	/*204*/214									//私聊表情
var SUB_GR_COLLOQUY_CHAT		=	/*205*/215									//会话消息
var SUB_GR_COLLOQUY_EXPRESSION	=	/*206*/216									//会话表情
//包裹命令
var SUB_GR_USER_PACKAGE			=	250									//包裹消息
var SUB_GR_UPDATE_PACKAGE		=	251									//更新包裹
//道具命令
var SUB_GR_PROPERTY_BUY			=	300									//购买道具
var SUB_GR_PROPERTY_SUCCESS		=	301									//道具成功
var SUB_GR_PROPERTY_FAILURE		=	302									//道具失败
var SUB_GR_PROPERTY_MESSAGE     =	303                                 //道具消息
var SUB_GR_PROPERTY_EFFECT      =	304                                 //道具效应
var SUB_GR_PROPERTY_TRUMPET		=	305                                 //喇叭消息
var SUB_GR_PROPERTY_BUY_IN		=	306									//买入道具
var SUB_GR_PROPERTY_USE			=	307									//使用道具
var SUB_GR_PROPERTY_TRUMPET_NEW =	308                                 //新的喇叭消息

/////////////////////////////////////////////////////////////////////////////////
var MDM_GR_STATUS				=	4									//状态信息

var SUB_GR_TABLE_INFO			=	100									//桌子信息
var SUB_GR_TABLE_STATUS			=	101									//桌子状态



//银行命令

var MDM_GR_INSURE				=	5									//用户信息

//银行命令
var SUB_GR_QUERY_INSURE_INFO	=	1									//查询银行
var SUB_GR_SAVE_SCORE_REQUEST	=	2									//存款操作
var SUB_GR_TAKE_SCORE_REQUEST	=	3									//取款操作
var SUB_GR_TRANSFER_SCORE_REQUEST	=	4								//转账操作
var SUB_GR_QUERY_USER_INFO_REQUEST	=	5								//查询用户
var SUB_GR_QUERY_BANK_DETAIL        =	9                               //查询明细

var SUB_GR_ANDROID_SAVE_SCORE_REQUEST	=	6							//机器人存款
var SUB_GR_ANDROID_TAKE_SCORE_REQUEST	=	7							//机器人取款
var SUB_GR_ANDROID_ZERO_TAKE_SCORE_REQUEST	=	8							//机器人补款


var SUB_GR_USER_INSURE_INFO		=	100									//银行资料
var SUB_GR_USER_INSURE_SUCCESS	=	101									//银行成功
var SUB_GR_USER_INSURE_FAILURE	=	102									//银行失败
var SUB_GR_USER_TRANSFER_USER_INFO	=	103								//用户资料
var SUB_GR_USER_PASSWORD_RESULT	=	104									//查询密码
var SUB_GR_USER_CHANGE_RESULT	=	105									//修改结果
var SUB_GR_BANK_DETAIL_RESULT	=	106									//银行记录

//管理消息
var MDM_GR_MANAGE				=	6									//管理命令

var SUB_GR_SEND_WARNING			=	1									//发送警告
var SUB_GR_SEND_MESSAGE			=	2									//发送消息
var SUB_GR_LOOK_USER_IP			=	3									//查看地址
var SUB_GR_KILL_USER			=	4									//踢出用户
var SUB_GR_LIMIT_ACCOUNS		=	5									//禁用帐户
var SUB_GR_SET_USER_RIGHT		=	6									//权限设置

//房间设置
var SUB_GR_QUERY_OPTION			=	7									//查询设置
var SUB_GR_OPTION_SERVER		=	8									//房间设置
var SUB_GR_OPTION_CURRENT		=	9									//当前设置

var SUB_GR_LIMIT_USER_CHAT		=	10									//限制聊天

var SUB_GR_KICK_ALL_USER		=	11									//踢出用户
var SUB_GR_DISMISSGAME		    =	12									//解散游戏
var SUB_GR_ADDANDIRO		    =	13									//解散游戏
var SUB_GR_DELANDIRO		    =	14									//解散游戏

var MDM_CM_SYSTEM				=	1000								//系统命令

var SUB_CM_SYSTEM_MESSAGE		=	1									//系统消息
var SUB_CM_ACTION_MESSAGE		=	2									//动作消息
var SUB_CM_DOWN_LOAD_MODULE		=	3									//下载消息



//类型掩码
var SMT_CHAT					=	0x0001								//聊天消息
var SMT_EJECT					=	0x0002								//弹出消息
var SMT_GLOBAL					=	0x0004								//全局消息
var SMT_PROMPT					=	0x0008								//提示消息
var SMT_TABLE_ROLL				=	0x0010								//滚动消息

//控制掩码
var SMT_CLOSE_ROOM				=	0x0100								//关闭房间
var SMT_CLOSE_GAME				=	0x0200								//关闭游戏
var SMT_CLOSE_LINK				=	0x0400								//中断连接

//动作类型
var ACT_BROWSE					=	1									//浏览动作
var ACT_DOWN_LOAD				=	2									//下载动作

//浏览类型
var BRT_IE						=	0x01								//I E 浏览
var BRT_PLAZA					=	0x02								//大厅浏览
var BRT_WINDOWS					=	0x04								//窗口浏览

//下载类型
var DLT_IE						=	1									//I E 下载
var DLT_MODULE					=	2									//下载模块


//游戏命令
var MDM_GF_GAME					=	200									//游戏命令
//框架命令
var MDM_GF_FRAME				=	100									//框架命令

//用户命令
var SUB_GF_GAME_OPTION			=	1									//游戏配置
var SUB_GF_USER_READY			=	2									//用户准备
var SUB_GF_LOOKON_CONFIG		=	3									//旁观配置

//聊天命令
var SUB_GF_USER_CHAT			=	10									//用户聊天
var SUB_GF_USER_EXPRESSION		=	11									//用户表情

//游戏信息
var SUB_GF_GAME_STATUS			=	100									//游戏状态
var SUB_GF_GAME_SCENE			=	101									//游戏场景
var SUB_GF_LOOKON_STATUS		=	102									//旁观状态

//系统消息
var SUB_GF_SYSTEM_MESSAGE		=	200									//系统消息
var SUB_GF_ACTION_MESSAGE		=	201									//动作消息


//答题消息
var MDM_MAIN_LOGON_QUESTION     =	10

var SUB_LOGON_QUESTION          =	9
var SUB_QUESTION_ANSWER         =	8
var SUB_REWARDS_COUNT           =	7  //获得奖励用户
var SUB_REWARDS_RESULT          =	6  //写奖励

var MDM_MISSION_QUESTION        =	20
var SUB_MISSION_C_QUESTION      =	19
var SUB_MISSION_SUCCESS         =	18 
var SUB_MISSION_COUNT           =	17
var SUB_MISSION_C_REWARDS       =	16  //随机奖励数量
var SUB_MISSION_C_LUCK_RESULT   =	15  //转盘是否开始

var IPC_CMD_GF_USER_INFO		=	4									//用户消息

var IPC_SUB_GF_USER_ENTER		=	100									//用户进入
var IPC_SUB_GF_USER_SCORE		=	101									//用户分数
var IPC_SUB_GF_USER_STATUS		=	102									//用户状态
var IPC_SUB_GF_USER_ATTRIB		=	103									//用户属性
var IPC_SUB_GF_CUSTOM_FACE		=	104									//自定头像
var IPC_SUB_GF_KICK_USER       	=	105                                 //用户踢出
var IPC_SUB_GF_QUICK_TRANSPOS  	=	106                                 //用户换位
var IPC_SUB_GAME_START			=	107									//游戏开始
var IPC_SUB_GAME_FINISH			=	108									//游戏结束

var MDM_GP_HORN_LOGON           =   11
var	SUB_GP_HORN_BIG             =   1                                     //大喇叭
var SUB_GP_GetUSERPROP          =   2
var SUB_GR_HORN_BIG			    =   101
var SUB_GR_PROP_COST            =   102
var SUB_GR_SEND_SUCCESS         =   103
var SUB_GR_SEND_Failure         =   104

//管理服务器
//主命令：
var MDM_GP_USER_SERVICE			=	3									//用户服务
//从命令：
var SUB_GP_USER_RELATION_WIN	=	111								//PHP后台获取数据
//消息包：
var DBR_GP_QueryRelationWin ={
	sum_len		:	68,
	dwType		:	'int',				//	2
	szName		:	'tchar&'+32			//	778804

};

//从命令：
var SUB_GP_RELATION_WIN_RESULT	=	432								//PHP后台获取数据
//消息包：
var CMD_GP_RelationWinResult	={
	sum_len		:	81,
	cbState		:	'byte',
	dwUserID	:	'int',
	dwGameID	:	'int',
	szNickName	:	'tchar&'+32,
	llScore		:	'longlong'

};

var GlobalDwClientPort = '111111111111111111111111111111111111111111111111111111111111111111111111111111111111';
var GlobalDwClientPortZero = '000000000000000000000000000000000000000000000000000000000000000000000000000000000000';
var GlobalDwClientPortSync = '222222222222222222222222222222222222222222222222222222222222222222222222222222222222';

var ConnectIPList = ['14.17.70.38'];
var ConIPList = ConnectIPList;//	多连接ip地址列表
var ConCount = 5;//	至少连接数量
var HallPort = 6001;//	大厅端口
var RoomPort = -5000;//	房间端口改变值
var AdminPort = 8199;//	管理服务器

var HALLFLAG = 1;//	连接大厅socket类型
var ROOMFLAG = 2;//	连接房间socket类型
var TASKFLAG = 3;//	连接任务socket类型
var HORNFLAG = 4;//	连接喇叭socket类型
var ADMINFLAG = 5;

var RoomTestWait = null;//	房间断线重连定时器

var HallULCmdNo = 0;//	大厅发消息的次数，每次累加1
var RoomULCmdNo = 0;//	房间发消息的次数，每次累加1
var TaskULCmdNo = 0;//	任务发消息的次数，每次累加1
var HornULCmdNo = 0;//	喇叭发消息的次数，每次累加1
var AdminULCmdNo = 0;

var HallMessageNo = 0;//	大厅接收消息序列号
var RoomMessageNo = 0;//	房间接收消息序列号
var TaskMessageNo = 0;//	任务接收消息序列号
var HornMessageNo = 0;//	喇叭接收消息序列号
var AdminMessageNo = 0;

var HallDwClient = null;//	大厅发消息的包序列
var RoomDwClient = null;//	房间发消息的包序列
var TaskDwClient = null;//	任务发消息的包序列
var HornDwClient = null;//	喇叭发消息的包序列
var AdminDwClient = null;

var IsHallActionClose = null;//	大厅是否主动执行关闭socket
var IsRoomActionClose = null;//	房间是否主动执行关闭socket
var IsTaskActionClose = null;//	任务是否主动执行关闭socket
var IsHornActionClose = null;//	喇叭是否主动执行关闭socket
var IsAdminActionClose = null;

var HallNetList = [];//	大厅接收数据list
var RoomNetList = [];//	房间接收数据list
var TaskNetList = [];//	任务接收数据list
var HornNetList = [];//	喇叭接收数据list
var AdminNetList = [];

var RoomNetList0 = new Array();
var RoomNetList1 = new Array();
var RoomNetList2 = new Array();
var RoomNetList3 = new Array();
var RoomNetList4 = new Array();
var RoomNetList5 = new Array();
var RoomNetList6 = new Array();
var RoomNetList7 = new Array();
var RoomNetList8 = new Array();
var RoomNetList9 = new Array();

//var HallConIpList = [];				//	大厅需要连接的ip地址列表
//var RoomConIpList = [];				//	房间需要连接的ip地址列表
//var TaskConIpList = [];				//	任务需要连接的ip地址列表
//var HornConIpList = [];				//	喇叭需要连接的ip地址列表
//
//var HallAllSocketMap = new Map();	//	大厅所有尝试去连接的socket
//var RoomAllSocketMap = new Map();	//	房间所有尝试去连接的socket
//var TaskAllSocketMap = new Map();	//	任务所有尝试去连接的socket
//var HornAllSocketMap = new Map();	//	喇叭所有尝试去连接的socket
//
//var HallConSocketMap = new Map();	//	大厅已连接成功socket的map
//var RoomConSocketMap = new Map();	//	房间已连接成功socket的map
//var TaskConSocketMap = new Map();	//	任务已连接成功socket的map
//var HornConSocketMap = new Map();	//	喇叭已连接成功socket的map
//
//var HallCloseing = false;			//	是否正处于关闭状态中
//var RoomCloseing = false;			//	是否正处于关闭状态中
//var TaskCloseing = false;			//	是否正处于关闭状态中
//var HornCloseing = false;			//	是否正处于关闭状态中
//
//var HallIsCon = false;              //	大厅多连接是否已有成功
//var RoomIsCon = false;              //	房间多连接是否已有成功
//var TaskIsCon = false;              //	任务多连接是否已有成功
//var HornIsCon = false;              //	喇叭多连接是否已有成功
//
//var HallWaitCon = null;				//	等待关闭定时器
//var RoomWaitCon = null;				//	等待关闭定时器
//var TaskWaitCon = null;				//	等待关闭定时器
//var HornWaitCon = null;				//	等待关闭定时器
//
//var RoomTestCon = null;				//	检测断线重连定时器
//var HornTestCon = null;				//	检测断线重连定时器

var HallSocketManager = null;
var RoomSocketManager = null;
var TaskSocketManager = null;
var HornSocketManager = null;
var AdminSocketManager = null;

var Manager = {
	cmdNo : 0,						//	manager的唯一标识号
	conIpList : [],					//	需要连接的ip list
	allSocketMap : null,			//	所有的socket map
	conSocketMap : null,			//	连接上的socket map
	isCon : false,					//	是否已有连接
	testCon : null,					//	重连(未使用)
	conPortList : [],				//	room连接专用	需要连接的端口列表
	allCmdNoMap : null,				//	room连接专用	发送的序列
	allDwClientMap : null,			//	room连接专用	发送的包序列

}
var SocketCmdNo = 0;//int		4	int32	有符号整形int			//dword		4	int32	有符号整形int(同int类型)
//uint		4	uint32	无符号整形int
//tchar		2	uint16	无符号短整形short		//word		2	uint16	无符号短整形short(同tchar类型)
//char		1	int8	字符型char
//byte		1	uint8	无符号字符型char		//bool		1	uint8	无符号bool型	0/1(同byte类型)
//longlong	8	int64	有符号long long
//double	8	float64	有符号双精度型double
//float		4	float32	有符号单精度型float


var HeadLength		=	175;//	包头长度		内网测试95,外网175
var TcpInfoLength	=	171;//	tcpinfo长度	内网测试91,外网171
var DataKindLength	=	167;//	数据类型位置	内网测试87,外网167
var CheckCodeLength	=	168;//	校验字段位置	内网测试88,外网168

var BEGINFLAG		=	0x55555555;
var ENDFLAG			=	0x66666666;


// json格式，第一个字段为总长度，统一为'sum_len',其它字段的值为'int','word','dword','char','tchar','byte','longlong','bool','double','float') 
// 如果是'char'或'tchar'等数组   则紧接着下个元素为'&'+它的长度

//消息头
var TCP_Head = {
	sum_len				:	175,						//内网测试95,外网175
	//		sum_len				:	95,							//内网测试95,外网175
	wEnPacketSize		:	'tchar',					//整个包长度-2
	//		dwClientPort		:	'int',						//随机数，例如时间戳，每个玩家不同(内网测试)
	dwClientPort		:	'char&'+84,					//随机数，例如时间戳，每个玩家不同(外网)
	ulCmdNo1			:	'longlong',					//1开始，每次发包增加1
	
	uMessageBeginFlag	:	'int',						//包头标志 = BEGINFLAG
	dwCmdFlag			:	'int',						//命令标识 = 1/2
	dwClientAddr		:	'int',						//连接地址 = userid(没有时为零)
	mRandCnt			:	'int',						//随机种子 = 1到100000+(1开始，每次发包增加1)
	extend				:	'int',						//扩展字段 = 1到100000
	md5key				:	'char&' + LEN_MD5,			//md5key
	dwPort				:	'int',						//连接端口  =(随机数，例如时间戳，每个玩家不同)
	dwPacketSize		:	'tchar',					//数据大小 = 整个包的长度
	dwEncodeSize		:	'tchar',					//数据大小 = 0
	uMessageEndFlag		:	'int',						//包尾标志 = ENDFLAG
	ulCmdNo2			:	'longlong',					//
	
	cbDataKind			:	'byte',						//数据类型 =0
	cbCheckCode			:	'byte',						//效验字段 =0
	wPacketSize			:	'tchar',					//数据大小 = 整个包的长度
	
	wMainCmdID			:	'tchar',					//主命令码 
	wSubCmdID			:	'tchar'						//子命令码 

};

// 登录
var CMD_GP_LogonAccounts = {
	sum_len				:	31 + LEN_MACHINE_ID*2 + 4*LEN_MD5 + 2*LEN_ACCOUNTS,
	//系统信息
	dwPlazaVersion		:	'int',						//广场版本
	szMachineID			:	'tchar&' + LEN_MACHINE_ID,	//机器序列
	dwClientIP			:	'int',						//玩家IP
	//登录信息
	szPassword			:	'tchar&' + LEN_MD5,			//登录密码
	szAccounts			:	'tchar&' + LEN_ACCOUNTS,	//登录帐号
	cbValidateFlags		:	'byte',						//校验标识
	szPhonePassword		:	'tchar&' + 9,
	dwLogonType			:	'int',						//登录类型(pc:3,ios:1,android:2)
	szCdkey				:	'tchar&' + LEN_MD5

}

// 登录成功
var DBO_GP_LogonSuccess = {
	//属性资料
	wFaceID				:	'tchar',					//头像标识
	dwUserID			:	'int',						//用户标识
	dwGameID			:	'int',						//游戏标识
	dwGroupID			:	'int',						//社团标识
	dwCustomID			:	'int',						//自定索引
	dwUserMedal			:	'int',						//用户奖牌
	dwExperience		:	'int',						//经验数值
	dwLoveLiness		:	'int',						//用户魅力
	lUserScore			:	'longlong',					//用户游戏币
	lUserInsure			:	'longlong',					//用户银行
	//用户信息
	cbGender			:	'byte',						//用户性别
	cbMoorMachine		:	'byte',						//锁定机器
	cbMaxStart			:	'byte',						//工作线路
	szAccounts			:	'tchar&' + LEN_ACCOUNTS,	//登录帐号
	szNickName			:	'tchar&' + LEN_ACCOUNTS,	//用户昵称
	szGroupName			:	'tchar&' + LEN_GROUP_NAME,	//社团名字
	//附加信息
	IsLockMobile		:	'byte',						//手机绑定
	cbMemberOrder		:	'byte',						//会员等级
	RegisterFrom		:	'int',						//从哪里登陆过来 0华商 >0 其它地方
	IsChangePWD			:	'int',						//修改过密码   0没改，1修改过
	GameLogonTimes		:	'int',						//是否是第一次登陆 0第一次
	//
	iError				:	'int',
	strPassPortID		:	'tchar&' + Len_PASS_PORT_ID,
	strRegisterMobile	:	'tchar&' + LEN_MOBILE_PHONE,
	//配置信息
	cbShowServerStatus	:	'byte',						//显示服务器状态
	byServerLinkCount	:	'byte',						//显示服务器状态
	byDownLoadLinkCount	:	'byte',						//显示服务器状态
	szDownServerLinkUrl	:	'tchar&' + 50 + '&' + 32,	//登录帐号
	szDownLoadUrl		:	'tchar&' + 20 + '&' + 64	//登录帐号

};

//登录失败
var CMD_GP_LogonFailure = {
	lErrorCode			:	'int',						//错误代码
	szDescribeString	:	'tchar&' + 128				//错误代码

};

//查询信息
var CMD_GP_QueryIndividual = {
	sum_len				:	8 + 2 * LEN_PASSWORD,
	dwPlazaVersion		:	'int',
	dwUserID			:	'int',						//用户 I D
	szPassword			:	'tchar&'+LEN_PASSWORD		//用户密码

};

//修改密码
var CMD_GP_ModifyInsurePass = {
	sum_len				:	4 + 4 * LEN_PASSWORD,
	dwUserID			:	'int',						//用户 I D
	szDesPassword		:	'tchar&' + LEN_PASSWORD,	//用户新密码
	szScrPassword		:	'tchar&' + LEN_PASSWORD		//用户原密码

};

//修改资料
var CMD_GP_ModifyIndividual = {
	//验证资料
	sum_len				:	5 + 2*LEN_PASSWORD,
	cbGender			:	'byte',						//用户性别
	dwUserID			:	'int',						//用户 I D
	szPassword			:	'tchar&'+LEN_PASSWORD		//用户密码

};

//个人资料
var CMD_GP_UserIndividual = {
	sum_len				:	5,
	dwUserID			:	'int',						//用户ID
	cbGender			:	'byte'						//用户性别

};

//扩展资料
var tagIndividualUserData = {
	//用户信息
	//	int							dwUserID;								//用户 I D
	//	tchar							szUserNote[LEN_USER_NOTE];			//用户说明
	//	tchar                           szUserWrite[LEN_USER_NOTE];
	//	tchar							szCompellation[LEN_COMPELLATION];	//真实名字
	//
	//	//电话号码
	//	tchar							szSeatPhone[LEN_SEAT_PHONE];		//固定电话
	//	tchar							szMobilePhone[LEN_MOBILE_PHONE];	//移动电话
	//
	//	//联系资料
	//	tchar							szQQ[LEN_QQ];						//Q Q 号码
	//	tchar							szEMail[LEN_EMAIL];					//电子邮件
	//	tchar							szDwellingPlace[LEN_DWELLING_PLACE];//联系地址

};

//登录银行
var CMD_GP_UserLogonBank = {
	sum_len				:	8 + 2*LEN_MD5,
	dwUserID			:	'int',						//用户 I D
	szPassword			:	'tchar&'+LEN_MD5,			//银行密码
	dwCdkey				:	'int'

};

//查询银行
var CMD_GP_QueryInsureInfo = {
	sum_len				:	4 + 2*LEN_MD5,
	dwUserID			:	'int',						//用户 I D
	szPassword			:	'tchar&'+LEN_MD5			//银行密码

};

//存入金币
var CMD_GP_UserSaveScore = {
	sum_len				:	20 + 2 * LEN_MACHINE_ID,
	dwPlazaVersion		:	'int',						//广场版本
	dwUserID			:	'int',						//用户 I D
	dwIP				:	'int',
	lSaveScore			:	'longlong',					//用户游戏币
	szMachineID			:	'tchar&' + LEN_MACHINE_ID	//机器序列

};

//提取金币
var CMD_GP_UserTakeScore = {
	sum_len				:	20 + 2*LEN_MD5 + 2*LEN_MACHINE_ID,
	dwPlazaVersion		:	'int',						//广场版本
	dwUserID			:	'int',						//用户 I D
	dwIP				:	'int',
	lTakeScore			:	'longlong',					//用户游戏币
	szPassword			:	'tchar&' + LEN_MD5,			//银行密码
	szMachineID			:	'tchar&' + LEN_MACHINE_ID	//机器序列

};

//银行资料
var CMD_GP_UserInsureInfo = {
	wRevenueTake		:	'tchar',					//税收比例
	wRevenueTransfer	:	'tchar',					//税收比例
	wServerID			:	'tchar',					//房间标识
	lUserScore			:	'longlong',					//用户游戏币
	lUserInsure			:	'longlong',					//用户银行
	lTransferPrerequisite:	'longlong',					//转账条件
	szLastLoginTime		:	'tchar&' + 64,
	cbAccountsProtect	:	'byte'

};

//银行成功
var CMD_GP_UserInsureSuccess = {
	dwUserID			:	'int',						//用户 I D
	lUserScore			:	'longlong',					//用户游戏币
	lUserInsure			:	'longlong',					//用户银行
	szDescribeString	:	'tchar&' + 128				//描述消息

};

//银行失败
var CMD_GP_UserInsureFailure = {
	lResultCode			:	'int',						//错误代码
	szDescribeString	:	'tchar&' + 128				//描述消息

};

//查询用户
var CMD_GP_QueryUserInfoRequest = {
	sum_len				:	1 + 2 * LEN_NICKNAME,
	cbByNickName		:	'byte',						//昵称赠送
	szNickName			:	'tchar&' + LEN_NICKNAME		//目标用户

};

//用户信息
var CMD_GP_UserTransferUserInfo = {
	dwTargetGameID		:	'int',						//目标用户
	szNickName			:	'tchar&' + LEN_NICKNAME		//目标用户

};

//转账金币
var CMD_GP_UserTransferScore = {
	sum_len				:	24 + 4*LEN_MD5 + 2*LEN_NICKNAME + 2*LEN_MACHINE_ID,
	dwPlazaVersion		:	'int',
	dwUserID			:	'int',						//用户 I D
	dwIP				:	'int',
	dwGameID			:	'int',
	lTransferScore		:	'longlong',					//转账金币
	szPassword			:	'tchar&' + LEN_MD5,			//银行密码
	szNickName			:	'tchar&' + LEN_NICKNAME,	//目标用户
	szMachineID			:	'tchar&' + LEN_MACHINE_ID,	//机器序列
	szCdkey				:	'tchar&' + LEN_MD5

};

//查询明细
var CMD_GP_QueryBankDetail = {
	sum_len				:	9,
	dwPlazaVersion		:	'int',						//广场版本
	dwUserID			:	'int',						//用户 I D
	cbTransferIn		:	'byte'						//转账类型 转入:1、转出:0

};

//明细结果
var CMD_GP_BankDetailResult = {
	sum_len				:	14 + 2*LEN_NICKNAME + 2*64,
	cbState				:	'byte',
	cbTransferIn		:	'byte',
	szNickName			:	'tchar&' + LEN_NICKNAME,
	dwGameID			:	'int',
	lSwapScore			:	'longlong',
	szDateTime			:	'tchar&' + 64

};

//游戏类型
var tagGameType = {
	sum_len				:	6 + 2*LEN_TYPE,
	wJoinID				:	'tchar',					//挂接索引
	wSortID				:	'tchar',					//排序索引
	wTypeID				:	'tchar',					//类型索引
	szTypeName			:	'tchar&' + 	LEN_TYPE		//种类名字

};

//游戏种类
var tagGameKind = {
	sum_len				:	22 + 2*LEN_KIND + 2*LEN_PROCESS + 10*LEN_DWELLING_PLACE + 2*LEN_MD5,
	wTypeID				:	'tchar',					//类型索引
	wJoinID				:	'tchar',					//挂接索引
	wSortID				:	'tchar',					//排序索引
	wKindID				:	'tchar',					//类型索引
	wGameID				:	'tchar',					//模块索引
	wPlazaType			:	'tchar',
	wDiff				:	'tchar',					//安卓更新方式
	dwOnLineCount		:	'int',						//在线人数
	dwFullCount			:	'int',						//满员人数
	szKindName			:	'tchar&' + LEN_KIND,		//游戏名字
	szProcessName		:	'tchar&' + LEN_PROCESS,		//进程名字
	
	szMBDownloadUrl		:	'tchar&' + LEN_DWELLING_PLACE,		//下载地址LEN_DWELLING_PLACE
	szAppStoreUrl		:	'tchar&' + LEN_DWELLING_PLACE,		//App Store
	szOpenUrl			:	'tchar&' + LEN_DWELLING_PLACE,		//打开地址
	szGameVerison		:	'tchar&' + LEN_MD5,					//版本验证
	
	szUpdatgeUrl		:	'tchar&' + LEN_DWELLING_PLACE,		//打开地址
	szCheckCode			:	'tchar&' + LEN_DWELLING_PLACE		//打开地址

};

//游戏房间
var tagGameServer = {
	sum_len				:	34 + 2*32 +2*LEN_SERVER,
	wKindID				:	'tchar',					//名称索引
	wNodeID				:	'tchar',					//节点索引
	wSortID				:	'tchar',					//排序索引
	wServerID			:	'tchar',					//房间索引
	wServerPort			:	'tchar',					//房间端口
	dwOnLineCount		:	'int',						//在线人数
	dwFullCount			:	'int',						//满员人数
	szServerAddr		:	'tchar&' + 32,				//房间名称
	szServerName		:	'tchar&' + LEN_SERVER,		//房间名称
	lMaxEnterScore		:	'longlong',					//最大进入分数
	lMinEnterScore		:	'longlong'					//最小进入分数

};

var CMD_GP_GameNewNum = {
	mNewSum				:	'tchar'

};

var CMD_GP_SysemMessage = {
	sum_len				:	8 + 4*LEN_USER_CHAT,
	szSystemMessage		:	'tchar&' + LEN_USER_CHAT,	//系统消息
	szMessageUrl		:	'tchar&' + LEN_USER_CHAT,	//系统消息
	tConcludeTime		:	'longlong'					//结束时间

};

//注册码
var CMD_GP_GetValidateCode = {
	dwValidateId		:	'int',
	szValidateCode		:	'tchar&' + 128

};

//注册帐号
var CMD_GP_RegisterAccounts = {
	sum_len				:	30 + 2*LEN_MACHINE_ID + 6*LEN_MD5 + 4*LEN_ACCOUNTS + 2*LEN_NICKNAME + 2*LEN_PASS_PORT_ID + 2*LEN_COMPELLATION,
	//系统信息
	dwPlazaVersion		:	'int',						//广场版本
	szMachineID			:	'tchar&' + LEN_MACHINE_ID,	//机器序列
	dwClientIP			:	'int',						//玩家IP
	//密码变量
	szLogonPass			:	'tchar&' + LEN_MD5,			//登录密码
	szInsurePass		:	'tchar&' + LEN_MD5,			//银行密码
	//注册信息
	wFaceID				:	'tchar',					//头像标识
	cbGender			:	'byte',						//用户性别
	szAccounts			:	'tchar&' + LEN_ACCOUNTS,	//登录帐号
	szNickName			:	'tchar&' + LEN_NICKNAME,	//用户昵称
	szSpreader			:	'tchar&' + LEN_ACCOUNTS,	//推荐帐号
	szPassPortID		:	'tchar&' + LEN_PASS_PORT_ID,//证件号码
	szCompellation		:	'tchar&' + LEN_COMPELLATION,//真实名字
	cbValidateFlags		:	'byte',						//校验标识
	
	dwValidateId		:	'int',
	szValidateCode		:	'tchar&' + 5,
	cbRegisterType		:	'int',
	szCdkey				:	'tchar&' + LEN_MD5

};

////////////////////////////房间结构//////////////////////////////////////////////
//I D 登录
var CMD_GR_LogonUserID = {
	sum_len				:	22 + 2*LEN_MD5 + 2*LEN_MACHINE_ID,
	//版本信息
	dwPlazaVersion		:	'int',						//广场版本
	dwFrameVersion		:	'int',						//框架版本
	dwProcessVersion	:	'int',						//进程版本
	//登录信息
	dwUserID			:	'int',						//用户 I D
	szPassword			:	'tchar&' + LEN_MD5,			//登录密码
	szMachineID			:	'tchar&' + LEN_MACHINE_ID,	//机器序列
	wKindID				:	'tchar',					//类型索引
	dwClientIP			:	'int'						//玩家IP

};

//登录失败
var CMD_GR_LogonFailure = {
	wLockServerid		:	'tchar',
	lErrorCode			:	'int',						//错误代码
	szDescribeString	:	'tchar&' + 128				//描述消息

};

//房间配置
var CMD_GR_PcConfigServer = {
	sum_len				:	26,
	//房间属性
	wTableCount			:	'tchar',					//桌子数目
	wChairCount			:	'tchar',					//椅子数目
	//房间配置
	wServerType			:	'tchar',					//房间类型
	dwServerRule		:	'int',						//房间规则
	lGoldLeast			:	'longlong',
	lGoldMost			:	'longlong'

};

//用户信息
var tagUserInfo = {
	//基本属性
	dwUserID			:	'int',						//用户 I D
	dwGameID			:	'int',						//游戏 I D
	dwGroupID			:	'int',						//社团 I D
	szNickName			:	'tchar&' + LEN_NICKNAME,	//用户昵称
	szGroupName			:	'tchar&' + LEN_GROUP_NAME,	//社团名字
	szUnderWrite		:	'tchar&' + LEN_UNDER_WRITE,	//个性签名
	szUserQQ			:	'tchar&' + LEN_QQ,
	//头像信息
	wFaceID				:	'tchar',					//头像索引
	dwCustomID			:	'int',						//自定标识
	//用户资料
	cbGender			:	'byte',						//用户性别
	cbMemberOrder		:	'byte',						//用户vip >0则是vip
	cbMasterOrder		:	'byte',						//管理等级
	//用户状态
	wTableID			:	'tchar',					//桌子索引
	wChairID			:	'tchar',					//椅子索引
	cbUserStatus		:	'byte',						//用户状态
	//积分信息
	lScore				:	'longlong',					//用户分数
	lGrade				:	'longlong',					//用户成绩
	lInsure				:	'longlong',					//用户银行
	//游戏信息
	dwWinCount			:	'int',						//胜利盘数
	dwLostCount			:	'int',						//失败盘数
	dwDrawCount			:	'int',						//和局盘数
	dwFleeCount			:	'int',						//逃跑盘数
	dwUserMedal			:	'int',						//用户奖牌
	dwExperience		:	'int',						//用户经验
	lLoveLiness			:	'int',						//用户魅力
	//时间信息
	dwEnterTableTimer	:	'int',						//进出桌子时间
	dwLeaveTableTimer	:	'int',						//离开桌子时间
	dwStartGameTimer	:	'int',						//开始游戏时间
	dwEndGameTimer		:	'int',						//离开游戏时间
	//比赛信息
	cbEnlistStatus		:	'byte',						//报名状态
	//扩展标识
	lExpand				:	'int',						//登录来源 1:iphone,2:android,3:pc
	dwExpand			:	'int',
	
	bIsAndroidUser		:	'byte',
	bIsMobileUser		:	'byte'

};

var tagUserInfoHead = {
	sum_len				:	82,
	//用户属性
	dwGameID			:	'int',						//游戏 I D
	dwUserID			:	'int',						//游戏 I D
	dwGroupID			:	'int',						//社团 I D
	//头像信息
	wFaceID				:	'tchar',					//头像索引
	dwCustomID			:	'int',						//自定标识
	//用户属性
	cbGender			:	'byte',						//用户性别
	cbMemberOrder		:	'byte',						//会员等级
	cbMasterOrder		:	'byte',						//管理等级
	//用户状态
	wTableID			:	'tchar',					//桌子索引
	wChairID			:	'tchar',					//桌子索引
	cbUserStatus		:	'byte',						//用户状态
	//积分信息
	lScore				:	'longlong',					//用户分数
	lGrade				:	'longlong',					//用户成绩
	lInsure				:	'longlong',					//用户银行
	//游戏信息
	dwWinCount			:	'int',						//胜利盘数
	dwLostCount			:	'int',						//失败盘数
	dwDrawCount			:	'int',						//和局盘数
	dwFleeCount			:	'int',						//逃跑盘数
	dwUserMedal			:	'int',						//用户奖牌
	dwExperience		:	'int',						//用户经验
	lLoveLiness			:	'int',						//用户魅力
	
	bIsAndroidUser		:	'byte',						//是否机器人
	bIsMobileUser		:	'byte',					
	
	dwLogForm			:	'tchar'						//平台类型

};

//系统消息
var CMD_CM_SystemMessage = {
	wType				:	'tchar',					//消息类型
	wLength				:	'tchar',					//消息长度
	szString			:	'tchar&'+1024				//消息内容

};

//用户分数
var CMD_GR_UserScore = {
	sum_len				:	57,
	dwUserID			:	'int',						//用户标识
	cbReason			:	'byte',						//改变类型
	//积分信息
	lScore				:	'longlong',					//用户分数
	lGrade				:	'longlong',					//用户成绩
	lInsure				:	'longlong',					//用户银行
	//输赢信息
	dwWinCount			:	'int',						//胜利盘数
	dwLostCount			:	'int',						//失败盘数
	dwDrawCount			:	'int',						//和局盘数
	dwFleeCount			:	'int',						//逃跑盘数
	
	dwUserMedal			:	'int',						//用户奖牌
	dwExperience		:	'int',						//用户经验
	lLoveLiness			:	'int'						//用户魅力

};

//用户状态
var CMD_GR_UserStatus = {
	dwUserID			:	'int',						//用户标识
	wTableID			:	'tchar',					//桌子索引
	wChairID			:	'tchar',					//椅子位置
	cbUserStatus		:	'byte',						//用户状态
	lScore				:	'longlong',					
	lInsure				:	'longlong'

};

//桌子状态
var tagTableStatus = {
	sum_len				:	2,
	cbTableLock			:	'byte',						//锁定标志
	cbPlayStatus		:	'byte'						//游戏标志

};

//桌子信息
var CMD_GR_TableInfo = {
	sum_len				:	2,
	wTableCount			:	'tchar'						//桌子数目

};

//桌子状态
var CMD_GR_TableStatus = {
	wTableID			:	'tchar',					//桌子号码
	cbTableLock			:	'byte',						//锁定标志
	cbPlayStatus		:	'byte'						//游戏标志

};

//坐下请求
var CMD_GR_UserSitDown = {
	sum_len				:	5 + 2*LEN_PASSWORD,
	wTableID			:	'tchar',					//桌子位置
	wChairID			:	'tchar',					//椅子位置
	cbIphoneSit			:	'byte',						//手机端坐下
	szPassword			:	'tchar&' + LEN_PASSWORD		//桌子密码

};

//请求失败
var CMD_GR_RequestFailure = {
	lErrorCode			:	'int',						//错误代码
	szDescribeString	:	'tchar&'+256				//描述信息

};

//起立请求
var CMD_GR_UserStandUp ={
	sum_len				:   5,
	wTableID			: 	'tchar',					//桌子位置
	wChairID			: 	'tchar',					//椅子位置
	cbForceLeave		:   'byte'   					//强行离开				

};

//游戏环境
var CMD_GF_GameStatus = {
	cbGameStatus		:	'byte',						//游戏状态
	cbAllowLookon		:	'byte'						//旁观标志

};

//游戏配置
var CMD_GF_GameOption = {
	sum_len				:	9,
	cbAllowLookon		:	'byte',						//旁观标志
	dwFrameVersion		:	'int',						//框架版本
	dwClientVersion		:	'int'						//游戏版本

};

//用户规则
var CMD_GR_UserRule = {
	sum_len				:	13,
	cbRuleMask			:	'byte',						//规则掩码
	wMinWinRate			:	'tchar',					//最低胜率
	wMaxFleeRate		:	'tchar',					//最高逃率
	lMaxGameScore		:	'int',						//最高分数
	lMinGameScore		:	'int'						//最低分数

};

///////////////////房间银行消息///////////////////////////////////////////////////////

//查询银行
var CMD_GR_C_QueryInsureInfoRequest = {
	sum_len				:	1 + 2 * LEN_PASSWORD,
	cbActivityGame		:	'byte',						//游戏动作
	szInsurePass		:	'tchar&' + LEN_PASSWORD		//银行密码

};

//存款请求
var CMD_GR_C_SaveScoreRequest = {
	sum_len				:	9,
	cbActivityGame		:	'byte',						//游戏动作
	lSaveScore			:	'longlong'					//存款数目

};

//取款请求
var CMD_GR_C_TakeScoreRequest = {
	sum_len				:	9 + 2 * LEN_PASSWORD,
	cbActivityGame		:	'byte',						//游戏动作
	lTakeScore			:	'longlong',					//取款数目
	szInsurePass		:	'tchar&'+LEN_PASSWORD		//银行密码

};

//查询明细
var CMD_GR_QueryBankDetail = {
	sum_len				:	5,
	dwUserID			:	'int',						//用户 I D
	cbTransferIn		:	'byte'

};


//查询用户
var CMD_GR_C_QueryUserInfoRequest = {
	sum_len				:	2 + 2 * LEN_NICKNAME,
	cbActivityGame		:	'byte',						//游戏动作
	cbByNickName		:	'byte',						//昵称赠送
	szNickName			:	'tchar&'+LEN_NICKNAME		//目标用户

};

//银行资料
var CMD_GR_S_UserInsureInfo = {
	cbActivityGame		:	'byte',						//游戏动作
	wRevenueTake		:	'tchar',					//税收比例
	wRevenueTransfer	:	'tchar',					//税收比例
	wServerID			:	'tchar',					//房间标识
	lUserScore			:	'longlong',					//用户金币
	lUserInsure			:	'longlong',					//银行金币
	lTransferPrerequisite:	'longlong'					//转账条件

};

//银行成功
var CMD_GR_S_UserInsureSuccess = {
	cbActivityGame		:	'byte',						//游戏动作
	lUserScore			:	'longlong',					//身上金币
	lUserInsure			:	'longlong',					//银行金币
	szDescribeString	:	'tchar&'+128				//描述消息

};

//银行失败
var CMD_GR_S_UserInsureFailure = {
	cbActivityGame		:	'byte',						//游戏动作
	lErrorCode			:	'int',						//错误代码
	szDescribeString	:	'tchar&'+128				//描述消息

};

//用户信息
var CMD_GR_S_UserTransferUserInfo = {
	cbActivityGame		:	'byte',						//游戏动作
	dwTargetGameID		:	'int',						//目标用户
	szNickName			:	'tchar&'+LEN_NICKNAME		//目标用户

};

//发送抽奖结果
var CMD_GR_LuckyResult = {
	sum_len				:	4+2*LEN_LUCKY_RESULT,
	wUserid				:	'int',
	szRewards			:	'tchar&'+LEN_LUCKY_RESULT

};

var CMD_GR_ResultReturn = {
	szDescribeString	:	'tchar&'+128,				//描述消息
	lReturn				:	'int'

};

var CMD_GP_Rewards = {
	sum_len				:	2*LEN_QUESTION,
	szRewards			:	'tchar&'+LEN_QUESTION

};

var CMD_GP_RecoidCnts ={
	m_RecoidCounts : 'int'

};

var CMD_GP_Speaker_Info  ={
	mMessagId : 'tchar',
	szMessageInfo : 'tchar&' + 255,
	szNickName : 'tchar&' + LEN_ACCOUNTS

}

var CMD_GR_GetUserProp ={
	sum_len : 4,
	mUserID : 'int'

}

//发送喇叭
var CMD_GR_S_SendTrumpet ={
	wPropertyIndex : 'tchar',                      //道具索引
	dwSendUserID : 'int',                        //用户 I D
	TrumpetColor : 'int',                        //喇叭颜色
	szSendNickName : 'tchar&' + 32,				    //玩家昵称
	szSendUnderWrite : 'tchar&' + 32,			//发送用户签名
	szTrumpetContent : 'tchar&' + TRUMPET_MAX_CHAR  //喇叭内容

}

//发送喇叭
var CMD_GR_Send_SendTrumpet ={
	sum_len : 2 + 4 + 4 + 4 + 2 * 32 + 2 * 32 + 2 * 128,
	wPropertyIndex : 'tchar',                         //道具索引
	dwSendUserID : 'int',                          //用户 I D
	dwClientIP : 'int',							//玩家IP
	TrumpetColor : 'int',                          //喇叭颜色
	szSendNickName : 'tchar&' + 32,				    //玩家昵称
	szSendUnderWrite : 'tchar&' + 32,			    //发送用户签名
	szTrumpetContent : 'tchar&' + TRUMPET_MAX_CHAR   //喇叭内容

}

var CMD_GetLaBaCostOrNum ={
	mScore_xlb : 'int',
	mScore_dlb : 'int',
	mxlb_Number : 'int',
	mdlb_Number : 'int'

}

//银行失败
CMD_GP_UserHronFailure ={
	szDescribeString : 'tchar&' + 128				//描述消息

}// 全局变量定义
var EditboxList = new Array();//	编辑框数组

var mainBackground = "res/Skin/Bg/bg5.png";


var winWidth;
var winHeight;
var realWidth	=	1024;//	实际宽(分辨率宽度)
var realHeight	=	728;//	实际高(分辨率高度)

var OS_IOS = 1;
var OS_ANDROID = 2;
var OS_WIN32 = 3;

var HallTag		=	1;//	大厅主图层tag
var RoomTag		=	2;//	房间图层tag
var GameTag		=	3;//	游戏gamebaselayer的tag
var RegisterTag	=	4;//	注册tag
var BaoxianPassTag	=	5;//	保险箱密码
var BaoxianTag	=	6;//	保险箱
var UserTag		=	7;//	用户信息
var LuckTag		=	8;//	抽奖
var TopinfoTag	=	9;//	喇叭滚动条
var HornTag		=	10;//	喇叭
var LoginTag		=	11;//	登录

var Is_Web;
var Is_INinternet = false;//	内网环境true 外网环境false
var LogLevel = 1;//	日志输出等级
var PlatForm;//	平台
var SysFontSize = 15;//	系统常用字体大小
var PcPhoneFontSize;//	区别电脑和手机的字体大小
var LoginAccount;//	登录账号	
var LoginPassword;//	登录密码
var IsSavePassword;//	是否记住密码
var JustLoginPassword;//	即将修改的登录密码
var JustInsurePassword;//	即将修改的保险柜密码
var IsBankLogin;//	银行是否已登录过
var HideOrShow;//	浏览器是否最前(false:隐藏 true:显示)
var IsLoadTable = false;//	房间通用资源是否已经全部加载
var IsLoadAnimation = false;//	动画资源是否已经全部加载
var IsLoadBank = false;//	保险箱资源是否已经全部加载
var IsLoadHorn = false;//	喇叭资源是否全部加载
var SceneRotation = null;//	场景旋转角度
var Direction = null;//	第一次加载场景时，水平还是垂直，水平true，垂直false
var NowBankData = null;//	银行信息
var GameUserListMap = new Map();//	游戏房间中
var GlobaldwValidateId = null;//	注册验证码标识
var IsLoginHall = false;//	是否登录大厅

//--------------场景、图层---------------
var WaitingLoad;//	当前等待加载layer
var HornAddWait = null;//	连接喇叭延迟定时器

var NowUserListLayer;//	当前房间玩家列表layer
var RoomChatLayer;//	房间聊天界面
var NowLandscapeLayer = null;//	横竖屏提示图层

var GameTypeList;//	游戏类型数组tagGameType
var GameKindList;//	游戏种类数组tagGameKind
var GameServerList;//	游戏房间数组tagGameServer
var SystemMessageList;//	系统消息数组CMD_GP_SysemMessage

var PcTableSizeMap = new Map();//	pc桌子大小
PcTableSizeMap.put(2, {
	w:220,h:240
});
PcTableSizeMap.put(4, {
	w:220,h:240
});
PcTableSizeMap.put(3, {
	w:220,h:240
});
PcTableSizeMap.put(6, {
	w:300,h:300
});
PcTableSizeMap.put(16, {
	w:350,h:410
});

var PhoneTableSizeMap = new Map();//	手机桌子大小
PhoneTableSizeMap.put(2, {
	w:300,h:360
});
PhoneTableSizeMap.put(4, {
	w:300,h:360
});
PhoneTableSizeMap.put(3, {
	w:300,h:360
});
PhoneTableSizeMap.put(6, {
	w:390,h:400
});
PhoneTableSizeMap.put(16, {
	w:460,h:550
});

//房间===================
var RoomLoginSuccess;//  房间登录是否成功
var AllUserMap = new Map();//	所有用户(元素对应结构tagUserInfo)
var MySelfUser;//	自己的用户信息(对应结构tagUserInfo)
var NowGameKind;//	当前游戏(对应结构tagGameKind)
var NowRoomConfig;//	当前游戏房间配置(对应结构CMD_GR_PcConfigServer)
var NowGameRoom;//	当前游戏房间信息(对应结构tagGameServer)
var NowGameStatus;//	当前游戏状态
var NowAllowLookon;//	当前游戏是否允许旁观
var ReqTableID = INVALID_TABLE;//	当前请求桌子id
var ReqChairID = INVALID_CHAIR;//	当前请求椅子id
var LevelScore = [0,99999,499999,999999,1499999,1999999,2999999,3999999,6999999,10999999,29999999,99999999];//积分等级

var MIN_ZORDER = 99 ;//最小深度
var MID_ZORDER = 999 ;//中间深度
var MAX_ZORDER = 9999 ;//最大深度

var NowGameMessage;//	当前哪个游戏消息处理
var GameMessageMap = new Map();//	游戏消息处理map

//用户信息结构
var tagGlobalUserData = {
	//基本资料
	dwUserID		:	0,			//dword		用户 I D
	dwGameID		:	0,			//dword		游戏I D
	dwExperience	:	0,			//dword		用户经验
	dwLoveLiness	:	0,			//dword		用户魅力
	szAccounts		:	'',			//tchar		登录账号	LEN_ACCOUNTS
	szNickName		:	'',			//tchar		用户昵称	LEN_NICKNAME
	szPassword		:	'',			//tchar		登录密码	LEN_PASSWORD
	szBankPassWord	:	'',			//tchar		银行密码	LEN_PASSWORD
	//用户成绩
	lUserScore		:	0,			//longlong	用户游戏币
	lUserInsure		:	0,			//longlong	用户银行
	dwUserMedal		:	0,			//dword		用户奖牌
	//扩展资料
	cbGender		:	0,			//byte		用户性别
	cbMoorMachine	:	0,			//byte		锁定机器
	cbMaxStart		:	0,			//byte
	//社团资料
	dwGroupID		:	0,			//byte		社团索引
	szGroupName		:	'',			//tchar		社团名字
	//会员资料
	cbMemberOrder	:	0,			//btye		会员等级
	//头像信息
	wFaceID			:	0,			//word		头像索引
	dwCustomID		:	0,			//dword		自定标识
	//是否绑定手机
	IsLockMB		:	true,		//bool
	iError			:	0,			//int
	strRegisterMobile:	'',			//tchar		LEN_MOBILE_PHONE
	
	RegisterFrom	:	0,			//int		从哪里登陆过来 0华商 >0 其它地方
	IsChangePWD		:	0,			//int		修改过密码   0没改，1修改过
	GameLogonTimes	:	0,			//int		是否是第一次登陆 0第一次
	
	dwCdkey			:	0			//dword		

}
//用户信息
var GlobalUserInfo = {};

//房间信息
var IPC_GF_ServerInfo = {
	//用户信息
	wTableID		:	0,			//word		桌子号码
	wChairID		:	0,			//word		椅子号码
	dwUserID		:	0,			//dword		用户 I D
	//用户权限
	dwUserRight		:	0,			//dword		用户权限
	dwMasterRight	:	0,			//dword		管理权限
	
	wKindID			:	0,			//word		类型标识
	wServerID		:	0,			//word		房间标识
	wServerType		:	0,			//word		房间类型
	dwServerRule	:	0,			//dword		房间规则
	szServerName	:	'',			//tchar		房间名称
	
	wAVServerPort	:	0,			//word		服务端口
	dwAVServerAddr	:	0,			//dword		服务地址
	
	wChairCount		:	0,			//word		椅子数目
	dwClientVersion	:	0,			//dword		游戏版本
	szGameName		:	''			//tchar		游戏名字

};
//房间信息
var GlobalRoomInfo = {};

//用户属性
var tagUserAttribute = {
	//用户属性
	dwUserID		:	0,			//dword		用户标识
	wTableID		:	0,			//word		桌子号码
	wChairID		:	0,			//word		椅子号码
	dwUserRight		:	0,			//dword		用户权限
	dwMasterRight	:	0			//dword		管理权限

};
var m_UserAttribute = {};

//游戏属性
var tagGameAttribute = {
	wKindID			:	0,			//word		类型标识
	wChairCount		:	0,			//word		椅子数目
	dwClientVersion	:	0,			//dword		游戏版本
	szGameName		:	''			//tchar		LEN_KIND	游戏名字

};
var m_GameAttribute = {};

//房间属性
var tagServerAttribute = {
	wKindID			:	0,			//word		类型标识
	wServerID		:	0,			//word		房间标识
	wServerType		:	0,			//word		游戏类型
	dwServerRule	:	0,			//dword		房间规则
	szServerName	:	0,			//tchar		LEN_SERVER	房间名称
	wAVServerPort	:	0,			//word		视频端口
	dwAVServerAddr	:	0			//dword		视频地址

};
var m_ServerAttribute = {};