<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {

	public function _initialize(){
    	if(!isset($_SESSION['zs78_admin'])){
    		_href(WEB_ROOT."index.php/Login");
   		}
   		/*
		if($_SESSION['zs78_admin2']['role']==4){
   			_location('无此权限',WEB_ROOT.'index.php/User');
   		}
   		*/
   	}

    public function index(){
    	//phpinfo();
    	$this->display('jiechi');
    }

	public function tj_test(){
		$mssql = M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$d=_diffDays ($start_date, $end_date);
		if($d>7){
			_location('查询日期不能超过7天',WEB_ROOT.'index.php/User/tj_test');
		}

		/*
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		*/
		$xz=0;
		$zc=0;
		$yx=0;

		if($type==0){
			$sql='select t10.GjcID,t10.c,t10.dl_c,t10.Info,t6.zc_c,t6.yx_c  from
(select t7.GjcID,t7.c,t8.dl_c,t9.Info from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord
where InsertDate between "'.$start_date.'" and "'.$end_date.'" and (GjcID>99000000 or GjcID<80000000) group by GjcID) t7 left join
(select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t8 on t7.GjcID=t8.GjcID left join [QPRecordDB].[dbo].[GjcInfo] t9 on t7.GjcID=t9.ID
where t7.c>0)t10 left join
(select t5.GjcID,SUM(t5.zc_c) as zc_c,SUM(t5.yx_c) as yx_c from
(select t4.GjcID,t3.zc_c,t3.yx_c from (select GjcID,IP from QPRecordDB.dbo.GjcRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'"  group by GjcID,IP) t4 left join
(select t1.RegisterIP,t1.zc_c,t2.yx_c from
(select RegisterIP,COUNT(RegisterIP) as zc_c from QPRecordDB.dbo.RecordRegUser where InsertDate
between "'.$start_date.'" and "'.$end_date.'" group by RegisterIP) t1 left join
(select RegisterIP,COUNT(RegisterIP) as yx_c from QPRecordDB.dbo.RecordRegUser where (Rechange>0 or IsFF>0) and InsertDate
between "'.$start_date.'" and "'.$end_date.'" group by RegisterIP) t2 on t1.RegisterIP=t2.RegisterIP)t3 on t4.IP=t3.RegisterIP
where zc_c>0 )t5 group by t5.GjcID) t6 on t10.GjcID=t6.GjcID order by t10.c desc';
		}else{
			$num = $type*100000;
			$num2 = $num+100000*$type2;
			//echo $num2;
			$sql='select t10.GjcID,t10.c,t10.dl_c,t10.Info,t6.zc_c,t6.yx_c  from
(select t7.GjcID,t7.c,t8.dl_c,t9.Info from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord
where GjcID between '.$num.' and '.$num2.' and InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t7 left join
(select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t8 on t7.GjcID=t8.GjcID left join [QPRecordDB].[dbo].[GjcInfo] t9 on t7.GjcID=t9.ID
where t7.c>0)t10 left join
(select t5.GjcID,SUM(t5.zc_c) as zc_c,SUM(t5.yx_c) as yx_c from
(select t4.GjcID,t3.zc_c,t3.yx_c from (select GjcID,IP from QPRecordDB.dbo.GjcRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'"  group by GjcID,IP) t4 left join
(select t1.RegisterIP,t1.zc_c,t2.yx_c from
(select RegisterIP,COUNT(RegisterIP) as zc_c from QPRecordDB.dbo.RecordRegUser where InsertDate
between "'.$start_date.'" and "'.$end_date.'" group by RegisterIP) t1 left join
(select RegisterIP,COUNT(RegisterIP) as yx_c from QPRecordDB.dbo.RecordRegUser where (Rechange>0 or IsFF>0) and InsertDate
between "'.$start_date.'" and "'.$end_date.'" group by RegisterIP) t2 on t1.RegisterIP=t2.RegisterIP)t3 on t4.IP=t3.RegisterIP
where zc_c>0 )t5 group by t5.GjcID) t6 on t10.GjcID=t6.GjcID order by t10.c desc';
		}
		//$sql = 'select top 1000 t1.GjcID,t1.c,t2.dl_c,t3.Info,t3.Pt from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t1 left join (select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t2 on t1.GjcID=t2.GjcID left join [QPWebBackDB].[dbo].[GjcInfo] t3 on t1.GjcID=t3.ID where t1.c>0 order by t1.c desc';
		//echo $sql;
		//exit;
		$rs = $mssql->query($sql);
		$cc=count($rs);
		for($i=0;$i<$cc;$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
			$xz=$xz+$rs[$i]['dl_c'];
			$zc=$zc+$rs[$i]['zc_c'];
			$yx=$yx+$rs[$i]['yx_c'];

		}

		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('xz',$xz);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('zc',$zc);
		$this->assign('yx',$yx);

		$this->assign('date',$InsertTime);
    	$this->display('tj_test');

	}

	//实际推广用户
	public function tj_user(){
		$mssql=M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		//$start_date = $_GET['start_date'];
		//$end_date = $_GET['end_date'];
		if($type==0){
			$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName,CONVERT(varchar,t6.LastlogonDate,120) as LastlogonDate from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and (t2.GjcID<80000000 or t2.GjcID>99000001) group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser] t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID where (t4.IsFF=1 or t4.Rechange>0) order by InsertDate desc';
		}else{
			$num = $type*100000;
			$num2 = $num+100000*$type2;
			$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName,CONVERT(varchar,t6.LastlogonDate,120) as LastlogonDate from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.GjcID between '.$num.' and '.$num2.' group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser] t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID where (t4.IsFF=1 or t4.Rechange>0) order by InsertDate desc';
		}
		$rs = $mssql->query($sql);
		$ff_num=0;
		$cz_num=0;
		$cz_count=0;
		$yx=0;
		$hy=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			if($rs[$i]['IsFF']>0){
				$ff_num=$ff_num+1;
			}
			if($rs[$i]['Rechange']>0){
				$cz_num=$cz_num+$rs[$i]['Rechange'];
				$cz_count=$cz_count+1;
			}
			if($rs[$i]['Rechange']>0 || $rs[$i]['IsFF']>0){
				$yx=$yx+1;
			}
			if($rs[$i]['Score']+$rs[$i]['InsureScore']!=5000){
				$hy=$hy+1;
			}
		}
		$this->assign('cz_count',$cz_count);
		$this->assign('cz_num',$cz_num);
		$this->assign('ff_num',$ff_num);
		$this->assign('yx',$yx);
		$this->assign('hy',$hy);
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_user');


	}

	public function jiechi(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		$xz=0;
		$zc=0;
		$yx=0;

		$sql='select t10.GjcID,t10.c,t10.dl_c,t10.Info,t6.zc_c,t6.yx_c  from
(select t7.GjcID,t7.c,t8.dl_c,t9.Info from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord
where GjcID between 80000000 and 98100000 and InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t7 left join
(select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t8 on t7.GjcID=t8.GjcID left join [QPRecordDB].[dbo].[GjcInfo] t9 on t7.GjcID=t9.ID
where t7.c>0)t10 left join
(select t5.GjcID,SUM(t5.zc_c) as zc_c,SUM(t5.yx_c) as yx_c from
(select t4.GjcID,t3.zc_c,t3.yx_c from (select GjcID,IP from QPRecordDB.dbo.GjcRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'"  group by GjcID,IP) t4 left join
(select t1.RegisterIP,t1.zc_c,t2.yx_c from
(select RegisterIP,COUNT(RegisterIP) as zc_c from QPRecordDB.dbo.RecordRegUser where InsertDate
between "'.$start_date.'" and "'.$end_date.'" group by RegisterIP) t1 left join
(select RegisterIP,COUNT(RegisterIP) as yx_c from QPRecordDB.dbo.RecordRegUser where (Rechange>0 or IsFF>0) and InsertDate
between "'.$start_date.'" and "'.$end_date.'" group by RegisterIP) t2 on t1.RegisterIP=t2.RegisterIP)t3 on t4.IP=t3.RegisterIP
where zc_c>0 )t5 group by t5.GjcID) t6 on t10.GjcID=t6.GjcID order by t10.c desc';
		$rs = $mssql->query($sql);
		$cc=count($rs);
		for($i=0;$i<$cc;$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
			$xz=$xz+$rs[$i]['dl_c'];
			$zc=$zc+$rs[$i]['zc_c'];
			$yx=$yx+$rs[$i]['yx_c'];

		}
		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('xz',$xz);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('zc',$zc);
		$this->assign('yx',$yx);

		$this->assign('date',$InsertTime);
    	$this->display('jiechi');

	}

	//实际劫持用户
	public function jiechi_user(){
		$mssql=M();

		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		//$start_date = $_GET['start_date'];
		//$end_date = $_GET['end_date'];
		$sql = 'select t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.GjcID between 80000000 and 98100000 group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser] t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID where (t4.IsFF=1 or t4.Rechange>0) order by InsertDate desc';
		$rs = $mssql->query($sql);
		$ff_num=0;
		$cz_num=0;
		$cz_count=0;
		$yx=0;
		$hy=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			if($rs[$i]['IsFF']>0){
				$ff_num=$ff_num+1;
			}
			if($rs[$i]['Rechange']>0){
				$cz_num=$cz_num+$rs[$i]['Rechange'];
				$cz_count=$cz_count+1;
			}
			if($rs[$i]['Rechange']>0 || $rs[$i]['IsFF']>0){
				$yx=$yx+1;
			}
			if($rs[$i]['Score']+$rs[$i]['InsureScore']!=5000){
				$hy=$hy+1;
			}
		}
		$this->assign('cz_count',$cz_count);
		$this->assign('cz_num',$cz_num);
		$this->assign('ff_num',$ff_num);
		$this->assign('yx',$yx);
		$this->assign('hy',$hy);
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('jiechi_user');


	}

	public function tj_test2(){
		$mssql = M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		/*
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		*/
		$xz=0;
		$zc=0;
		$yx=0;

		$sql = 'select top 1500 t1.GjcID,t1.c,t2.dl_c,t3.Info,t3.Pt from (select GjcID,count(GjcID) as c from QPRecordDB.dbo.GjcRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t1 left join (select GjcID,count(GjcID) as dl_c from QPRecordDB.dbo.GjcDlRecord where InsertDate between "'.$start_date.'" and "'.$end_date.'" group by GjcID) t2 on t1.GjcID=t2.GjcID left join [QPWebBackDB].[dbo].[GjcInfo] t3 on t1.GjcID=t3.ID where t1.c>0 order by t1.c desc';
		//echo $sql;
		//exit;
		$rs = $mssql->query($sql);



		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
			/*
			if($i<00){
				$rs[$i]['User']=$this->GetCzUser($rs[$i]['GjcID'],$start_date,$end_date);
			}
			*/
			//$rs[$i]['User']=$this->GetCzUser($rs[$i]['GjcID'],$start_date,$end_date);
			$xz=$xz+$rs[$i]['dl_c'];
			$zc=$zc+$rs[$i]['User']['user_c'];
			$yx=$yx+$rs[$i]['User']['user_c2'];
		}
		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('xz',$xz);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('zc',$zc);
		$this->assign('yx',$yx);

		$this->assign('date',$InsertTime);
    	$this->display('tj_test2');

	}

	public function GjcRecord(){
		$mssql = M();
		$GjcID = $_GET['GjcID'];
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		$sql2 = 'select Info from [QPRecordDB].[dbo].[GjcInfo] where ID='.$GjcID;
		$rs2=$mssql->query($sql2);
		$rs2[0]['Info']=iconv("GBK","UTF-8",$rs2[0]['Info']);

		$sql = 'select IP,Area,CONVERT(varchar,InsertDate,120) as InsertDate from QPRecordDB.dbo.GjcRecord where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'" order by ID desc';

		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
		}

		//print_r($rs);
		$this->assign('GjcID',$GjcID);
		$this->assign('Info',$rs2[0]['Info']);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('rs',$rs);
		$this->display('gjc_record');

	}

	public function GjcDlRecord(){
		$mssql = M();
		$GjcID = $_GET['GjcID'];
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		$sql = 'select IP,Area,CONVERT(varchar,InsertDate,120) as InsertDate from QPRecordDB.dbo.GjcDlRecord where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'" order by ID desc';
		//echo $sql;

		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
		}

		//print_r($rs);
		$this->assign('GjcID',$GjcID);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('rs',$rs);
		$this->display('gjc_dl_record');

	}

	public function GjcDlRecord2(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if($type==0){
			$sql = 'select t1.GjcID,t1.IP,t1.Area,CONVERT(varchar,t1.InsertDate,120) as InsertDate,t2.Info from QPRecordDB.dbo.GjcDlRecord(nolock) t1 left join QPRecordDB.dbo.GjcInfo(nolock) t2 on t1.GjcID=t2.ID where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and (t1.GjcID<80000000 or t1.GjcID>99000001) order by t1.ID desc';
		}else{
			$num = $type*100000;
			$num2 = $num+100000*$type2;
			$sql = 'select t1.GjcID,t1.IP,t1.Area,CONVERT(varchar,t1.InsertDate,120) as InsertDate,t2.Info from QPRecordDB.dbo.GjcDlRecord(nolock) t1 left join QPRecordDB.dbo.GjcInfo(nolock) t2 on t1.GjcID=t2.ID where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t1.GjcID between '.$num.' and '.$num2.' order by t1.ID desc';
		}
		//echo $sql;

		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
		}

		//print_r($rs);
		//$this->assign('GjcID',$GjcID);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('rs',$rs);
		$this->display('gjc_dl_record2');

	}

	//推广注册帐号
	public function tj_reguser(){
		$mssql=M();
		if(isset($_GET['type'])){
			$type = $_GET['type'];
		}else{
			$type = 0;
		}
		if(isset($_GET['type2'])){
			$type2 = $_GET['type2'];
		}else{
			$type2 = 2;
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		//$start_date = $_GET['start_date'];
		//$end_date = $_GET['end_date'];
		if($type==0){
			$sql = 'select t6.RegisterMachine,t4.MAC_C,t4.IP_C,t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName,CONVERT(varchar,t6.LastlogonDate,120) as LastlogonDate from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and (t2.GjcID<80000000 or t2.GjcID>99000001) group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser] t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID order by InsertDate desc';
		}else{
			$num = $type*100000;
			$num2 = $num+100000*$type2;
			$sql = 'select t6.RegisterMachine,t4.MAC_C,t4.IP_C,t3.UserID,t4.RegisterIP,t4.Rechange,t4.IsFF,CONVERT(varchar,t4.InsertDate,120) as InsertDate,t5.Score,t5.InsureScore,t6.GameID,t6.Accounts,t6.NickName,CONVERT(varchar,t6.LastlogonDate,120) as LastlogonDate from (select t1.UserID from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
 where t1.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.GjcID between '.$num.' and '.$num2.' group by t1.UserID)t3 left join
[QPRecordDB].[dbo].[RecordRegUser] t4 on t3.UserID=t4.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t5 on t3.UserID=t5.UserID left join QPAccountsDB.dbo.AccountsInfo(nolock) t6 on t3.UserID=t6.UserID order by InsertDate desc';
		}
		$rs = $mssql->query($sql);
		$ff_num=0;
		$cz_num=0;
		$cz_count=0;
		$yx=0;
		$hy=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			if($rs[$i]['IsFF']>0){
				$ff_num=$ff_num+1;
			}
			if($rs[$i]['Rechange']>0){
				$cz_num=$cz_num+$rs[$i]['Rechange'];
				$cz_count=$cz_count+1;
			}
			if($rs[$i]['Rechange']>0 || $rs[$i]['IsFF']>0){
				$yx=$yx+1;
			}
			if($rs[$i]['Score']+$rs[$i]['InsureScore']!=5000){
				$hy=$hy+1;
			}
		}
		$this->assign('cz_count',$cz_count);
		$this->assign('cz_num',$cz_num);
		$this->assign('ff_num',$ff_num);
		$this->assign('yx',$yx);
		$this->assign('hy',$hy);
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_reguser');

	}

	public function GetCzUser($GjcID,$start_date,$end_date){
		$mssql = M();
		$sql = 'select count(RecordID) as user_c from QPRecordDB.dbo.RecordRegUser where RegisterIP in (select IP from [QPRecordDB].[dbo].[GjcRecord] where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'") and InsertDate between "'.$start_date.'" and "'.$end_date.'"';
		$sql2 = 'select count(RecordID) as user_c2 from QPRecordDB.dbo.RecordRegUser where (Rechange>0 or IsFF>0) and RegisterIP in (select IP from [QPRecordDB].[dbo].[GjcRecord] where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'") and InsertDate between "'.$start_date.'" and "'.$end_date.'"';

		$rs=$mssql->query($sql);
		$rs2=$mssql->query($sql2);

		$return['user_c']=number_format($rs[0]['user_c']);
		$return['user_c2']=number_format($rs2[0]['user_c2']);

		return $return;

	}


	//有效用户点击
	public function tj_zc(){
		$mssql=M();
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		$GjcID=$_GET['GjcID'];
		$sql='SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.RegisterIP,t1.RegisterDate,t1.LastLogonDate,t1.RegisterFrom,t2.Score,t2.InsureScore from [QPAccountsDB].[dbo].[AccountsInfo](nolock) t1 left join [QPTreasureDB].[dbo].[GameScoreInfo](nolock) t2 on t1.UserID=t2.UserID where t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" and t1.RegisterIP in (select IP from QPRecordDB.dbo.GjcRecord where GjcID='.$GjcID.' and InsertDate between "'.$start_date.'" and "'.$end_date.'") order by RegisterDate desc';
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
		}
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_zc');


	}

	//有效用户点击
	public function tj_yx(){
		$mssql=M();
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		$GjcID=$_GET['GjcID'];

		$sql = 'select t3.UserID,t6.GameID,t6.NickName,t3.Rechange,t3.IsFF,t4.GjcID,t4.IP,t4.Area,t5.Info,t4.InsertDate from
(select t1.UserID,t1.RegisterIP,t1.Rechange,t1.IsFF
from [QPRecordDB].[dbo].[RecordRegUser] t1 left join QPRecordDB.dbo.GjcRecord t2 on t1.RegisterIP=t2.IP
where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t2.InsertDate between "'.$start_date.'"
and "'.$end_date.'" and t2.GjcID='.$GjcID.' and (t1.IsFF>0 or t1.Rechange>0) group by t1.UserID,t1.RegisterIP,t1.Rechange,t1.IsFF)t3 left join [QPRecordDB].[dbo].[GjcRecord] t4
on t3.RegisterIP=t4.IP left join [QPRecordDB].[dbo].[GjcInfo] t5 on t4.GjcID=t5.ID left join QPAccountsDB.dbo.AccountsInfo t6 on t3.UserID=t6.UserID where t4.InsertDate between "'.$start_date.'" and "'.$end_date.'"';

		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Area']=iconv("GBK","UTF-8",$rs[$i]['Area']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Info']=iconv("GBK","UTF-8",$rs[$i]['Info']);
		}
		$this->assign('rs',$rs);
		$this->assign('end_date',$end_date);
		$this->assign('start_date',$start_date);
		$this->display('tj_yx');


	}

	//充值未游戏用户
	public function cz_ungame(){
		$mssql = M();
		//$start_date = date('Y-m-d').' 00:00:00';
		//$end_date=date('Y-m-d').' 23:59:59';

		$sql = 'SELECT top 1000 t1.UserID,t1.RegisterIP,t1.Rechange,t1.IsFF,t1.IP_C,t1.MAC_C,CONVERT(varchar,t1.InsertDate,120) AS InsertDate,t2.GameID,t2.Accounts,t2.NickName,t2.LastLogonMachine,t2.UserMedal,t2.LockMobileFrom,t2.CustomID,t3.Score,t3.InsureScore,t4.zr,t5.zc FROM [QPRecordDB].[dbo].[RecordRegUser](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID left join QPTreasureDB.dbo.GameScoreInfo(nolock) t3 on t1.UserID=t3.UserID left join (select UserID,SUM(Score) as zr from QPRecordDB.dbo.RecordUserZz(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Inout=1 group by UserID) t4 on t1.UserID=t4.UserID left join  (select UserID,SUM(Score) as zc from QPRecordDB.dbo.RecordUserZz(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Inout=2 group by UserID) t5 on t1.UserID=t5.userID where t1.Rechange>0 and t3.WinCount=0 and t3.LostCount=0 and t3.DrawCount=0 order by t1.RecordID desc';
		//echo $sql;
		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			//$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
			if($rs[$i]['IP_C']==1 && $rs[$i]['MAC_C']==1){
				$rs[$i]['new']=1;
			}

		}
		$this->assign('rs',$rs);
		$this->display('cz_ungame');
	}

	public function AndroidCount(){
		$mssql = M();

		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		$xz=0;
		$zc=0;
		$yx=0;

		$sql='select count(ID) as c from QPRecordDB.dbo.RecordAndroidOpen(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Version=567801';
		$sql2='select count(UserID) as c from QPAccountsDB.dbo.AccountsInfo(nolock) where RegisterDate between "'.$start_date.'" and "'.$end_date.'" and RegisterFrom=5 and RegisterMachine in (select Machine from QPRecordDB.dbo.RecordAndroidOpen(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Version=567801)';
		$sql3='select count(UserID) as c from QPAccountsDB.dbo.AccountsInfo(nolock) where RegisterDate between "'.$start_date.'" and "'.$end_date.'" and RegisterFrom=5 and (CustomID>0 or LockMobileFrom>0) and RegisterMachine in (select Machine from QPRecordDB.dbo.RecordAndroidOpen(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Version=567801)';

		$rs = $mssql->query($sql);
		$Open_c=$rs[0]['c'];
		$rs2 = $mssql->query($sql2);
		$Reg_c=$rs2[0]['c'];
		$rs3 = $mssql->query($sql3);
		$Yx_c=$rs3[0]['c'];

		//print_r($rs);
		$this->assign('Open_c',$Open_c);
		$this->assign('Reg_c',$Reg_c);
		$this->assign('Yx_c',$Yx_c);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);

		$this->assign('date',$InsertTime);
    	$this->display('android_count');

	}

	public function OpenRecord(){
		$mssql = M();

		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		$sql='select IP,Machine,Version,CONVERT(varchar,InsertDate,120) AS InsertDate from QPRecordDB.dbo.RecordAndroidOpen(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Version=567801';

		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
            $rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['IP']);

		}

		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);

		$this->assign('date',$InsertTime);
    	$this->display('open_record');

	}

	public function OpenReg(){
		$mssql = M();

		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}

		$sql='select IP,Machine,Version,CONVERT(varchar,InsertDate,120) AS InsertDate from QPRecordDB.dbo.RecordAndroidOpen(nolock) where InsertDate between "'.$start_date.'" and "'.$end_date.'" and Version=567801';

		$rs = $mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
            $rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['IP']);

		}

		//print_r($rs);
		$this->assign('rs',$rs);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);

		$this->assign('date',$InsertTime);
    	$this->display('open_record');

	}

	//5678注册
	public function newUser_5678(){
		$mssql = M();
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'];
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'];
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$sql = 'select t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t1.PassPortID,t1.RegisterFrom,t1.MemberOrder,t1.CustomFaceVer,t1.LockMobileFrom,t1.CustomID,t2.Score,t2.InsureScore,t1.RegisterIP,t1.RegisterMachine,t1.RegisterMobile,t1.LastLogonIP,t1.LastLogonMachine,CONVERT(varchar,t1.RegisterDate,120) AS RegisterDate,t3.IP_C,t3.MAC_C from QPAccountsDB.dbo.AccountsInfo(NOLOCK) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID left join QPRecordDB.dbo.RecordRegUser(nolock) t3 on t1.UserID=t3.UserID where t1.isandroid=0 and (t1.RegisterFrom=5 or t1.RegisterFrom=15) and t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" order by t1.RegisterDate desc';
		//ECHO $sql;
		$rs = $mssql->query($sql);
//echo $sql;
		$sum=0;
		$yx=0;
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$sum=$sum+1;
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Re_city'] = $this->getIpPlace($rs[$i]['RegisterIP']);
            $rs[$i]['Login_city'] = $this->getIpPlace($rs[$i]['LastLogonIP']);
			if($rs[$i]['CustomID']>0 || $rs[$i]['LockMobileFrom']>0){
				$yx=$yx+1;
			}
		}
		$this->assign('rs',$rs);
		$this->assign('sum',$sum);
		$this->assign('yx',$yx);
		$this->display('new_5678user');
	}

	//5678chongzhi
	public function cz_5678(){
		$mssql = M();
		IF(ISSET($_GET['GameID'])){
			$sql2= 'SELECT t1.UserID,t1.DetailID,t1.GameID,t1.Accounts,t2.Present,t2.NickName,t2.LockMobileFrom,t2.RegisterFrom,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate ';
			$sql2.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where t2.GameID='.$_GET['GameID'].' order by DetailID desc';
		}
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$sum=0;
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
        $sql2= 'SELECT t1.UserID,t1.DetailID,t1.GameID,t1.Accounts,t2.Present,t2.NickName,t2.LockMobileFrom,t2.RegisterFrom,t1.OrderID,t1.BeforeGold,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate ';
        $sql2.= 'FROM QPTreasureDB.dbo.ShareDetailInfo(NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.UserID = t2.UserID where (t2.RegisterFrom=5 or t2.RegisterFrom=15) and ApplyDate between "'.$start_date.'" and "'.$end_date.'" order by DetailID desc';

        $rs2 = $mssql->query($sql2);

        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
            $rs2[$i]['BeforeGold'] = number_format($rs2[$i]['BeforeGold']);
			$sum=$sum+$rs2[$i]['PayAmount'];
        }
		$this->assign('sum',$sum);
        $this->assign('result',$rs2);
        $this->display('cz_5678');
	}

	//5678zhuanzhang
	public function zz_5678(){
		if(isset($_GET['start_date'])){
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$sum=0;
		$user=array();
		$conn=mssql_connect($GLOBALS['DB_TREASURE']['DB_HOST'],$GLOBALS['DB_TREASURE']['DB_USER'],$GLOBALS['DB_TREASURE']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_TREASURE']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_5678ZzList",$conn);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
    	for($i=0;$i<count($rs);$i++){
			$rs[$i]['no'] = $i+1;
			$rs[$i]['NickName1'] = iconv("GBK","UTF-8",$rs[$i]['NickName1']);
			$rs[$i]['NickName2'] = iconv("GBK","UTF-8",$rs[$i]['NickName2']);
			if($rs[$i]['SwapScore']>=100000000){
				$rs[$i]['color']=3;
			}elseif($rs[$i]['SwapScore']>=10000000){
				$rs[$i]['color']=2;
			}else{
				$rs[$i]['color']=1;
			}
			if($rs[$i]['MemberOrder1']>0 && $rs[$i]['MemberOrder2']==0){
				$sum=$sum+$rs[$i]['SwapScore'];
				if(!in_array($rs[$i]['GameID2'],$user)){
					$user[]=$rs[$i]['GameID2'];
				}
			}
			if($rs[$i]['MemberOrder1']==0 && $rs[$i]['MemberOrder2']>0){
				$sum=$sum-$rs[$i]['SwapScore'];
			}
			if($rs[$i]['MemberOrder1']==0 && $rs[$i]['MemberOrder2']==0){
				$sum=$sum+$rs[$i]['SwapScore'];
			}
			$rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
		}
		$usercount=count($user);
		$sum = number_format($sum);
		//$gold_sum = $this->getUserGold();
		//$this->assign('gold_sum',$gold_sum);
		$this->assign('start_date',$start_date);
		$this->assign('end_date',$end_date);
		$this->assign('usercount',$usercount);
		$this->assign('sum',$sum);
		$this->assign('type',$type);
		$this->assign('result',$rs);
    	$this->display('zz_list5678');
	}

	/*          渠道            */
	//
	public function QdList(){
		$mssql=M();
		$sql = 'select UserID,Username,TypeID,QdName,QdType,Bili,Price,IsUsed,Fenghao from QPAdminDB.dbo.QD_Users where TypeID>1100';
		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['QdName']=iconv("GBK","UTF-8",$rs[$i]['QdName']);
		}
		//var_dump($rs);
		$this->assign('rs',$rs);
		$this->display('tg_qdlist');
	}

	public function QdInfo(){

		$mssql=M();
		$QdType=$_GET['QdType'];
		$QdID=$_GET['QdID'];
		$start_date=date('Y-m-d').' 00:00:00';
		$end_date=date('Y-m-d').' 23:59:59';
		$sql2 = 'select Username,TypeID,QdName,QdType,Bili,Price,IsUsed from QPAdminDB.dbo.QD_Users where TypeID='.$QdID;
		$rs2=$mssql->query($sql2);
		$rs2[0]['QdName']=iconv("GBK","UTF-8",$rs2[0]['QdName']);
		$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("TG_QdInfo",$conn);
		mssql_bind($procedure,"@type", $QdID, SQLINT4);
		$resource = mssql_execute($procedure);
		$row = mssql_fetch_assoc($resource);
		mssql_free_statement($procedure);

		$procedure2 = mssql_init("TG_QdDayInfo",$conn);
		mssql_bind($procedure2,"@Date", date('Y-m-d'), SQLVARCHAR);
		mssql_bind($procedure2,"@QdID", $QdID, SQLINT4);
		$resource2 = mssql_execute($procedure2);
		$row2 = mssql_fetch_assoc($resource2);
		//var_dump($row2);
		mssql_free_statement($procedure2);
		mssql_close($conn);
		$sql = 'select top 100 OpenNum,ChargeNum,Lc1,Lc7,RegNum,RegRealNum,ChargeUser,FFNum,FFSum,Huoyue,RealOpenNum,RealChargeNum,CONVERT(varchar,InsertDate,102) as InsertDate,NewUser from QPRecordDB.dbo.RecordQdDayCount(nolock) where QdID='.$QdID.' order by ID desc';
		$rs=$mssql->query($sql);
		$lc_sum=0;
		$lc7_sum=0;
		$day=count($rs);
		for($i=0;$i<$day;$i++){
			$rs[$i]['day_fc'] = number_format($rs[$i]['ChargeNum']*$rs2[0]['Bili']/100,2);
			$lc_sum=$lc_sum+$rs[$i]['Lc1'];
			$lc7_sum=$lc7_sum+$rs[$i]['Lc7'];

		}

		$lc_avg = $lc_sum==0 ? 0 : number_format($lc_sum/$day,2);
		$lc7_avg = $lc_sum==0 ? 0 : number_format($lc7_sum/$day,2);
		$fc=number_format($row['charge_num']*$rs2[0]['Bili']/100,2);
		$row2['Date']=str_replace('-','.',$row2['Date']);
		$this->assign('rs',$rs);
		$this->assign('fc',$fc);
		$this->assign('lc_avg',$lc_avg);
		$this->assign('lc7_avg',$lc7_avg);
		$this->assign('rs2',$rs2[0]);
		$this->assign('QdID',$QdID);
		$this->assign('row',$row);
		$this->assign('row2',$row2);
		$this->display('tg_info');
	}

	public function getQdInfo(){

		$mssql=M();
		$QdID=$_GET['QdID'];
		$start_date=date('Y-m-d').' 00:00:00';
		$end_date=date('Y-m-d').' 23:59:59';

		$conn=mssql_connect($GLOBALS['DB_ACCOUNTS']['DB_HOST'],$GLOBALS['DB_ACCOUNTS']['DB_USER'],$GLOBALS['DB_ACCOUNTS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_ACCOUNTS']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("TG_GetQdInfo",$conn);
		mssql_bind($procedure,"@type", $QdID, SQLINT4);
		mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
		mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
		$resource = mssql_execute($procedure);
		$row = mssql_fetch_assoc($resource);
		mssql_free_statement($procedure);
		mssql_close($conn);
		echo json_encode($row);
	}

	public function AddQd(){
		if(!isset($_GET['Username'])){
			$this->display('tg_addqd');
			return;
		}
		$mssql = M();
		$Username = $_GET['Username'];
		$Password = strtolower(md5($_GET['Password']));
		$TypeID = $_GET['TypeID'];
		$QdName = iconv("UTF-8","GBK",$_GET['QdName']);
		$QdType = $_GET['QdType'];
		$Bili = number_format($_GET['Bili'], 2);
		$Price = number_format($_GET['Price'], 2);
		$IsUsed = $_GET['IsUsed'];
		$sql2 = 'select count(Username) as num from QPAdminDB.dbo.QD_Users where TypeID='.$TypeID;
		$rs2=$mssql->query($sql2);
		if($rs2[0]['num']>0){
			_location('渠道ID重复',WEB_ROOT.'index.php/User/AddQd');
			return;
		}

		$sql = 'Insert into QPAdminDB.dbo.QD_Users (Username,Password,TypeID,QdName,QdType,Bili,Price,IsUsed) values("'.$Username.'","'.$Password.'",'.$TypeID.',"'.$QdName.'",'.$QdType.','.$Bili.','.$Price.','.$IsUsed.')';
		if(!$mssql->query($sql)){
			_location('添加渠道成功',WEB_ROOT.'index.php/User/QdList');
		}else{
			_location('添加渠道失败',WEB_ROOT.'index.php/User/QdList');
		}
	}

	public function EditQd(){

		$mssql = M();
		$UserID = $_GET['UserID'];
		$sql = 'select UserID,Username,TypeID,QdName,QdType,Bili,Price,IsUsed from QPAdminDB.dbo.QD_Users where UserID='.$UserID;
		$rs = $mssql->query($sql);
		$rs[0]['QdName']=iconv("GBK","UTF-8",$rs[0]['QdName']);
		$this->assign('rs',$rs[0]);
		$this->display('tg_editqd');
	}

	public function Edit_do(){
		$mssql = M();
		$UserID = $_GET['UserID'];
		$TypeID = $_GET['TypeID'];
		$QdName=iconv("UTF-8","GBK",$_GET['QdName']);
		$QdType = $_GET['QdType'];
		$Bili = number_format($_GET['Bili'], 2);
		$Price = number_format($_GET['Price'], 2);
		$IsUsed = $_GET['IsUsed'];
		$sql = 'update QPAdminDB.dbo.QD_Users set TypeID='.$TypeID.',QdName="'.$QdName.'",QdType='.$QdType.',Bili='.$Bili.',Price='.$Price.',IsUsed='.$IsUsed.' where UserID='.$UserID;
		//echo $sql;
		//exit;
		if(!$mssql->query($sql)){
			$sql2 = 'insert into QPAdminDB.dbo.QDInfoChangeRecord (AdminID,QdID,QdName,QdType,Bili,Price,IsUsed,Fenghao) values('.$_SESSION['zs78_admin'][1].','.$TypeID.',"'.$QdName.'",'.$QdType.','.$Bili.','.$Price.','.$IsUsed.',0)';
			$mssql->query($sql2);
			_location('修改渠道成功',WEB_ROOT.'index.php/User/QdList');
		}else{
			_location('修改渠道失败',WEB_ROOT.'index.php/User/QdList');
		}
	}

	public function DelQd(){

		$mssql = M();
		$UserID = $_GET['UserID'];
		$sql = 'update QPAdminDB.dbo.QD_Users set Fenghao=1 where UserID='.$UserID;
		$rs = $mssql->query($sql);
		if(!$mssql->query($sql)){
			_location('删除渠道成功',WEB_ROOT.'index.php/User/QdList');
		}else{
			_location('删除渠道失败',WEB_ROOT.'index.php/User/QdList');
		}
	}

	public function AndroidQdList(){
		$mssql=M();
		$sql = 'select UserID,Username,TypeID,QdName,QdType,Bili,Price,IsUsed,Fenghao from QPAdminDB.dbo.QD_Users where TypeID<1100';
		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['QdName']=iconv("GBK","UTF-8",$rs[$i]['QdName']);
		}
		//var_dump($rs);
		$this->assign('rs',$rs);
		$this->display('android_qdlist');
	}

	public function QdChangeList(){
		if(!isset($_GET['TypeID'])){
			$TypeID=8;
		}else{
			$TypeID=$_GET['TypeID'];
		}
		$mssql=M();
		$zong=0;
		$ab=0;
		$appstore=0;
		$wx=0;
		$sql = 'select t1.shareID,t1.GameID,t1.Accounts,t2.NickName,t1.OrderID,t1.PayAmount,CONVERT(varchar,t1.ApplyDate,120) as ApplyDate,CONVERT(varchar,t2.RegisterDate,120) as RegisterDate,CONVERT(varchar,t2.LastLogonDate,120) as LastLogonDate,t2.RegisterIP from [QPTreasureDB].[dbo].[ShareDetailInfo](nolock) t1 left join QPAccountsDB.dbo.AccountsInfo(nolock) t2 on t1.UserID=t2.UserID where t1.OperUserID='.$TypeID.' order by t1.DetailID desc';
		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no']=$i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
			$rs[$i]['PayAmount']=intval($rs[$i]['PayAmount']);
			if($rs[$i]['shareID']==23){
				$appstore=$appstore+$rs[$i]['PayAmount'];
			}elseif($rs[$i]['shareID']==71){
				$ab=$ab+$rs[$i]['PayAmount'];
			}else{
				$wx=$wx+$rs[$i]['PayAmount'];
			}
			$zong=$zong+$rs[$i]['PayAmount'];
		}

		//var_dump($rs);
		$this->assign('zong',$zong);
		$this->assign('wx',$wx);
		$this->assign('ab',$ab);
		$this->assign('appstore',$appstore);
		$this->assign('rs',$rs);
		$this->display('charge_qdlist');
	}

	public function QdRegList(){
		if(!isset($_GET['TypeID'])){
			$TypeID=8;
		}else{
			$TypeID=$_GET['TypeID'];
		}
		if(isset($_GET['start_date'])){
			$start=$_GET['start_date'];
			$start_date = $_GET['start_date'].' 00:00:00';
		}else{
			$start=date('Y-m-d');
			$start_date = date('Y-m-d').' 00:00:00';
		}
		if(isset($_GET['end_date'])){
			$end = $_GET['end_date'];
			$end_date = $_GET['end_date'].' 23:59:59';
		}else{
			$end = date('Y-m-d');
			$end_date = date('Y-m-d').' 23:59:59';
		}
		$mssql=M();
		$sql = 'select t1.GameID,t1.Accounts,t1.NickName,t2.Score,t2.InsureScore,CONVERT(varchar,t1.RegisterDate,120) as RegisterDate,CONVERT(varchar,t1.LastLogonDate,120) as LastLogonDate,t1.RegisterIP,t3.IP_C,t3.MAC_C,t1.RegisterMachine  from QPAccountsDB.dbo.AccountsInfo(nolock) t1 left join QPTreasureDB.dbo.GameScoreInfo(nolock) t2 on t1.UserID=t2.UserID left join QPRecordDB.dbo.RecordRegUser(nolock) t3 on t1.UserID=t3.UserID where
t1.RegisterFrom between 80 and 100 and t1.RegisterDate between "'.$start_date.'" and "'.$end_date.'" and t1.RegisterMachine in (select Machine from QPRecordDB.dbo.RecordAndroidOpen(nolock) where TypeID='.$TypeID.') order by t1.RegisterDate desc';
		$rs=$mssql->query($sql);
		for($i=0;$i<count($rs);$i++){
			$rs[$i]['no']=$i+1;
			$rs[$i]['NickName']=iconv("GBK","UTF-8",$rs[$i]['NickName']);
			$rs[$i]['Accounts']=iconv("GBK","UTF-8",$rs[$i]['Accounts']);
		}
		$this->assign('TypeID',$TypeID);
		$this->assign('end_date',$end);
		$this->assign('start_date',$start);
		$this->assign('rs',$rs);
		$this->display('reg_qdlist');
	}

	public function AddAndroidQd(){
		if(!isset($_GET['TypeID'])){
			$this->display('addandroidqd');
			return;
		}
		$mssql = M();
		$Username = 'Android';
		$Password = '1';
		$TypeID = $_GET['TypeID'];
		$QdName = iconv("UTF-8","GBK",$_GET['QdName']);
		$QdType = '2';
		$Bili = '1';
		$Price = '1';
		$IsUsed = '1';
		$sql2 = 'select count(Username) as num from QPAdminDB.dbo.QD_Users where TypeID='.$TypeID;
		$rs2=$mssql->query($sql2);
		if($rs2[0]['num']>0){
			_location('渠道ID重复',WEB_ROOT.'index.php/User/AddQd');
			return;
		}

		$sql = 'Insert into QPAdminDB.dbo.QD_Users (Username,Password,TypeID,QdName,QdType,Bili,Price,IsUsed) values("'.$Username.'","'.$Password.'",'.$TypeID.',"'.$QdName.'",'.$QdType.','.$Bili.','.$Price.','.$IsUsed.')';
		if(!$mssql->query($sql)){
			_location('添加渠道成功',WEB_ROOT.'index.php/User/AndroidQdList');
		}else{
			_location('添加渠道失败',WEB_ROOT.'index.php/User/AndroidQdList');
		}
	}

	public function EditAndroidQd(){

		$mssql = M();
		$UserID = $_GET['UserID'];
		$sql = 'select UserID,Username,TypeID,QdName,QdType,Bili,Price,IsUsed from QPAdminDB.dbo.QD_Users where UserID='.$UserID;
		$rs = $mssql->query($sql);
		$rs[0]['QdName']=iconv("GBK","UTF-8",$rs[0]['QdName']);
		$this->assign('rs',$rs[0]);
		$this->display('tg_editqd');
	}

	public function EditAndroid_do(){
		$mssql = M();
		$UserID = $_GET['UserID'];
		$TypeID = $_GET['TypeID'];
		$QdName=iconv("UTF-8","GBK",$_GET['QdName']);
		$QdType = $_GET['QdType'];
		$Bili = number_format($_GET['Bili'], 2);
		$Price = number_format($_GET['Price'], 2);
		$IsUsed = $_GET['IsUsed'];
		$sql = 'update QPAdminDB.dbo.QD_Users set TypeID='.$TypeID.',QdName="'.$QdName.'",QdType='.$QdType.',Bili='.$Bili.',Price='.$Price.',IsUsed='.$IsUsed.' where UserID='.$UserID;
		//echo $sql;
		//exit;
		if(!$mssql->query($sql)){
			$sql2 = 'insert into QPAdminDB.dbo.QDInfoChangeRecord (AdminID,QdID,QdName,QdType,Bili,Price,IsUsed,Fenghao) values('.$_SESSION['zs78_admin'][1].','.$TypeID.',"'.$QdName.'",'.$QdType.','.$Bili.','.$Price.','.$IsUsed.',0)';
			$mssql->query($sql2);
			_location('修改渠道成功',WEB_ROOT.'index.php/User/QdList');
		}else{
			_location('修改渠道失败',WEB_ROOT.'index.php/User/QdList');
		}
	}



	//查询ip地址
	function getIpPlace($ip){
    	require_once(ROOT_PATH.'/Db/IP/IpLocation.php');//加载类文件IpLocation.php
    	$ipfile = ROOT_PATH.'/Db/IP/qqwry.dat';      //获取ip对应地区的信息文件
    	$iplocation = new IpLocation($ipfile);  //new IpLocation($ipfile) $ipfile ip对应地区信息文件
    	$ipresult = $iplocation->getlocation($ip); //根据ip地址获得地区 getlocation("ip地区")
    	return $ipresult;
	}


	public function getkouliang(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$game=$_POST['game'];
		$time=$_POST['time'];

$kouliang=$_POST['kouliang'];
		$mssql = M();

	  $sql = 'insert into  QPStatisticsDB.dbo.kouliang values("'.$kouliang.'","'.$time.'","'.$game.'") ';

		$mssql->query($sql);
		_back('设置成功');}
		else{

    $this->display('getkouliang');
		}

	}


	public function data_rc(){
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
               $re=S('result');
		if(!$re){


    $typeid=$_POST['typeid'];

		$conn=mssql_connect($GLOBALS['DB_STATISTICS']['DB_HOST'],$GLOBALS['DB_STATISTICS']['DB_USER'],$GLOBALS['DB_STATISTICS']['DB_PWD']);
		mssql_select_db($GLOBALS['DB_STATISTICS']['DB_NAME']);
		$rs = array();
		$procedure = mssql_init("PHP_RCdata",$conn);
		mssql_bind($procedure,"@typeid", $typeid, SQLVARCHAR);
 		$resource = mssql_execute($procedure);
		while($row = mssql_fetch_assoc($resource)){
			$rs[] = $row;
		}
		mssql_free_statement($procedure);
		mssql_close($conn);
		$mssql = M();
		$sql = 'SELECT TOP 1 kouliang from QPStatisticsDB.dbo.kouliang where qdid='.$typeid.' order by time desc';
		$rs2 = $mssql->query($sql);
		if($rs2[0]['kouliang']==''){
$rs2[0]['kouliang']=1;

		}
		   $rs[0]['kczje']=$rs[0]['czje']*$rs2[0]['kouliang'];
			 $rs[0]['kzcje']=$rs[0]['zcje']*$rs2[0]['kouliang'];
		   $rs[0]['kzcylc']= sprintf("%.2f", $rs[0]['zcylc']/$rs[0]['zhuceyh_num']*100);
			 $rs[0]['kffylc']= sprintf("%.2f", $rs[0]['ffylc']/$rs[0]['zhuceyh_num']*100);
			 $rs[0]['kqrlc']= sprintf("%.2f", $rs[0]['qrlc']/$rs[0]['zhuceyh_num']*100);
			 $rs[0]['kylc']=sprintf("%.2f", $rs[0]['ylc']/$rs[0]['zhuceyh_num']*100);

			 	S('result',$rs,1800);
		   $this->assign('result',$rs);
			    $this->display('data_rc');
				}else{

 $re=S('result');
 $this->assign('result',$re);
		$this->display('data_rc');

				}
		 }
			 else{
				   $this->display('data_rc');
			 }


 	}




	public function kouliang(){
		$mssql=M();
		$sql = 'select *
from QPStatisticsDB.dbo.kouliang   a
where EXISTS
(select 1 FROM
(select qdid,max(time)time from QPStatisticsDB.dbo.kouliang    group by qdid) b where a.qdid=b.qdid and a.time =b.time )';
 		$rs = $mssql->query($sql);
		$this->assign('result',$rs);
		$this->display('kouliang');

	}

	public function newUser_cz(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$RegisterFrom=$_POST['regFrom'];
			$typeid=$_POST['typeid'];
		$start_date=$_POST['start_date'];
		$end_date=$_POST['end_date'];
		$conn=mssql_connect($GLOBALS['DB_STATISTICS']['DB_HOST'],$GLOBALS['DB_STATISTICS']['DB_USER'],$GLOBALS['DB_STATISTICS']['DB_PWD']);
 	 mssql_select_db($GLOBALS['DB_STATISTICS']['DB_NAME']);
 	 $rs = array();
 	 $procedure = mssql_init("PHP_cznewUser",$conn);
 	 mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
 	 mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
	 mssql_bind($procedure,"@typeid", $typeid, SQLVARCHAR);
	 	 mssql_bind($procedure,"@regFrom", $RegisterFrom, SQLVARCHAR);
 	 $resource = mssql_execute($procedure);
 	 while($row = mssql_fetch_assoc($resource)){
 		 $rs[] = $row;
 	 }
 	 mssql_free_statement($procedure);
 	 mssql_close($conn);


  $this->assign('result',$rs);
	 	$this->display('newUser_cz');
	}
		else{

			$this->display('newUser_cz');

		}

	}

public function qdqx(){


		$mssql=M();
		$qx=$_SESSION['zs78_admin']['qudao'];
		$A="'".$qx."'";
		$sql='SELECT name,qudao FROM QPStatisticsDB.dbo.qdshangqx WHERE  charindex(qudao,'.$A.') > 0 ';
		$rs = $mssql->query($sql);
		$this->assign('result',$rs);
 		$this->display('qdqx');



}

public function getqdqx(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $game=$_POST['game'];
				    $Username=$_POST['Username'];
		     $str="";
        for ($i = 0;$i<count($game);$i++){
        if($i<(count($game)-1)){
        $str .= $game[$i].",";
        }else{
        $str .=  $game[$i]."";
        }
        }
				$A="'".$str."'";
				$B="'".$Username."'";
				$mssql=M();
				$sql='update QPStatisticsDB.dbo.qdshangqx set qudao='.$A.' where Name='.$B.' ';
				$rs = $mssql->query($sql);
        _back('修改成功');
	}
	$mssql=M();
	$sql='SELECT name FROM QPStatisticsDB.dbo.qdshangqx ';
	$rs = $mssql->query($sql);
	$this->assign('result',$rs);
$this->display('getqdqx');

}



public function regtuiguangnum(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $game=$_POST['game'];
				    $Username=$_POST['username'];
						$Password=md5($_POST['Password']);
		     $str="";
        for ($i = 0;$i<count($game);$i++){
        if($i<(count($game)-1)){
        $str .= $game[$i].",";
        }else{
        $str .=  $game[$i]."";
        }
        }
				$A="'".$str."'";
				$B="'".$Username."'";
				$C="'".$Password."'";
				$mssql=M();
				$sql1='select userName from QPStatisticsDB.dbo.tuiguangqx where userName='.$B.'';
				 $rs1 = $mssql->query($sql1);
				 if($rs1[0]['userName']!=''){
				  _back('添加失败账号已存在');
				 }else{


        $sql1='insert into QPStatisticsDB.dbo.tuiguangqx(Name,qudao,Password)values('.$B.','.$A.','.$C.') ';
  				$rs1 = $mssql->query($sql1);
         _back('添加成功');

			}
	}

$this->display('regtuiguangnum');

}



public function regqdnum(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $game=$_POST['game'];
				    $Username=$_POST['username'];
						$Password=md5($_POST['Password']);
		     $str="";
        for ($i = 0;$i<count($game);$i++){
        if($i<(count($game)-1)){
        $str .= $game[$i].",";
        }else{
        $str .=  $game[$i]."";
        }
        }
				$A="'".$str."'";
				$B="'".$Username."'";
				$C="'".$Password."'";
				$mssql=M();
				$sql1='select userName from QPStatisticsDB.dbo.qdshangqx where userName='.$B.'';
				 $rs1 = $mssql->query($sql1);
				 if($rs1[0]['userName']!=''){
				  _back('添加失败账号已存在');
				 }else{


        $sql1='insert into QPStatisticsDB.dbo.qdshangqx(Name,qudao,Password)values('.$B.','.$A.','.$C.') ';
  				$rs1 = $mssql->query($sql1);
         _back('添加成功');

			}
	}

$this->display('regqdnum');

}
public function  CheckTUN(){
$id=$_GET['id'];
$mssql=M();
$B="'".$id."'";
$sql1='select  Name from QPStatisticsDB.dbo.tuiguangqx where Name='.$B.'';
 $rs1 = $mssql->query($sql1);
if($rs1[0]['Name']!=''){

	 $data['status']='0';
  echo 0;

}else {
	$data['status']='1';
 echo 1;

}


}

public function  CheckUN(){
$id=$_GET['id'];
$mssql=M();
$B="'".$id."'";
$sql1='select  Name from QPStatisticsDB.dbo.qdshangqx where Name='.$B.'';
 $rs1 = $mssql->query($sql1);
if($rs1[0]['Name']!=''){

	 $data['status']='0';
  echo 0;

}else {
	$data['status']='1';
 echo 1;

}


}

}
