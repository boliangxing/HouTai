<?php
// 本类由系统自动生成，仅供测试用途
class VipAction extends BaseAction {
    public function mem_list(){
        $date=date('Y-m-d H:i:s');
        if(isset($_GET['type'])){
            $type=$_GET['type'];
        }else{
            $type=1;
        }
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        $mssql=M();
        $sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo where Isandroid=0 and MemberOrder>0 and Nullity=0 and MemberOverDate>"'.$date.'"';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];
        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }
        if($type==1){
            $sql2 = 'SELECT UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,MemberOverDate FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,MemberOverDate FROM ';
            $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t3.Score,t3.InsureScore,t3.Score+t3.InsureScore as gold_sum,CONVERT(varchar,t1.MemberOverDate,111) as MemberOverDate ';
            $sql2.= 'FROM  QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t3 on t1.UserID=t3.UserID ';
            $sql2.= 'where t1.Isandroid=0 and t1.Nullity=0 and t1.MemberOrder>0 and t1.MemberOverDate>"'.$date.'" order by MemberOverDate asc,t1.UserID asc) t4 order by MemberOverDate desc,UserID desc) t5 order by MemberOverDate asc,UserID asc';
        }elseif($type==2){
            $sql2 = 'SELECT UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,MemberOverDate FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,MemberOverDate FROM ';
            $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t3.Score,t3.InsureScore,t3.Score+t3.InsureScore as gold_sum,CONVERT(varchar,t1.MemberOverDate,111) as MemberOverDate ';
            $sql2.= 'FROM  QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t3 on t1.UserID=t3.UserID ';
            $sql2.= 'where t1.Isandroid=0 and t1.Nullity=0 and t1.MemberOrder>0 and t1.MemberOverDate>"'.$date.'" order by gold_sum desc,t1.UserID desc) t4 order by gold_sum asc,UserID asc) t5 order by gold_sum desc,UserID desc';
        }else{
            $sql2 = 'SELECT UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,MemberOverDate,GroupNum FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,Score,InsureScore,gold_sum,MemberOverDate,GroupNum FROM ';
            $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t3.Score,t3.InsureScore,t3.Score+t3.InsureScore as gold_sum,CONVERT(varchar,t1.MemberOverDate,111) as MemberOverDate,t4.GroupNum ';
            $sql2.= 'FROM  QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t3 on t1.UserID=t3.UserID left join QPWebBackDB.dbo.VipMember t4 on t1.UserID=t4.UserID ';
            $sql2.= 'where t1.Isandroid=0 and t1.Nullity=0  and t1.MemberOrder>0 and t1.MemberOverDate>"'.$date.'" order by GroupNum asc,t1.UserID asc) t4 order by GroupNum desc,UserID desc) t5 order by GroupNum asc,UserID asc';
			//echo $sql2;

        }

        $rs2=$mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
            $rs2[$i]['gold_sum'] = $rs2[$i]['Score']+$rs2[$i]['InsureScore'];
            $sum['Score_sum'] = $sum['Score_sum']+$rs2[$i]['Score'];
            $sum['InsureScore_sum'] = $sum['InsureScore_sum']+$rs2[$i]['InsureScore'];
            $rs2[$i]['Score'] = number_format($rs2[$i]['Score']);
            $rs2[$i]['InsureScore'] = number_format($rs2[$i]['InsureScore']);
            $rs2[$i]['gold_sum'] = number_format($rs2[$i]['gold_sum']);
            $rs2[$i]['GroupNum'] = $this->getGroup($rs2[$i]['UserID']);
        }
        $sum['sum'] = number_format($sum['Score_sum']+$sum['InsureScore_sum']);
        $sum['InsureScore_sum'] = number_format($sum['InsureScore_sum']);
        $sum['Score_sum'] = number_format($sum['Score_sum']);
        $this->assign('sum',$sum);
        $pageNum = ceil($count/$pageSize);
        $this->assign('type',$type);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('vip');
    }

    //得到分类
    public function getGroup($UserID){
        $mssql=M();
        $sql = 'select GroupNum from QPWebBackDB.dbo.VipMember where UserID='.$UserID;
        $rs = $mssql->query($sql);
        if($rs[0]['GroupNum']){
            return $rs[0]['GroupNum'];
        }else{
            $sql2 = 'INSERT QPWebBackDB.dbo.VipMember (UserID,GroupNum) values('.$UserID.',9999)';
            if(!$mssql->query($sql2)){
                return 9999;
            }
        }
    }

    //查看vip信息
    public function vip_info(){
        $UserID=$_GET['UserID'];
        $mssql = M();
        $sql2 = 'select UserID from QPWebBackDB.dbo.VipMember where UserID='.$UserID;
        $rs2 = $mssql->query($sql2);
        if(!$rs2){
            $sql3 = 'insert into QPWebBackDB.dbo.VipMember (UserID) values('.$UserID.')';
            $mssql->query($sql3);
        }
        $sql = 'select t1.UserID,t1.QQ,t1.Shopname,t1.URL,t1.GroupNum,t2.GameID,t2.NickName,t2.RegisterMobile,t2.PassPortID,t2.Compellation,CONVERT(varchar,t2.MemberOverDate,120) as MemberOverDate from QPWebBackDB.dbo.VipMember t1,QPAccountsDB.dbo.AccountsInfo t2 where t1.UserID=t2.UserID and t1.UserID='.$UserID;
        $rs = $mssql->query($sql);
        $rs[0]['Shopname'] = iconv("GBK","UTF-8",$rs[0]['Shopname']);
        $rs[0]['NickName'] = iconv("GBK","UTF-8",$rs[0]['NickName']);
        $rs[0]['Compellation'] = iconv("GBK","UTF-8",$rs[0]['Compellation']);
        $this->assign('result',$rs[0]);
        $this->display('vip_info');
    }

    //修改vip信息
    public function vip_change(){
        $UserID = $_GET['UserID'];
        if($_GET['GroupNum']){
            $GroupNum = $_GET['GroupNum'];
        }else{
            $GroupNum = 9999;
        }
        if($_GET['Shopname']){
            $Shopname = iconv("UTF-8","GBK",$_GET['Shopname']);
        }else{
            $Shopname = ' ';
        }
        if($_GET['QQ']){
            $QQ = $_GET['QQ'];
        }else{
            $QQ = ' ';
        }
        if($_GET['URL']){
            $URL = $_GET['URL'];
        }else{
            $URL = ' ';
        }
        $mssql = M();
        $sql = 'update QPWebBackDB.dbo.VipMember set GroupNum='.$GroupNum.',Shopname="'.$Shopname.'",QQ="'.$QQ.'",URL="'.$URL.'" where UserID ='.$UserID;
        if(!$mssql->query($sql)){
            _location('保存成功',WEB_ROOT.'index.php/Vip/vip_info?UserID='.$UserID);
        }else{
            _location('保存失败',WEB_ROOT.'index.php/Vip/vip_info?UserID='.$UserID);
        }

    }

    //vip id 搜索
    public function vip_search(){
        $type=$_GET['type'];
        $GameID=$_GET['GameID'];
        $date = date('Y-m-d H:i:s');
        $mssql = M();
        if($type==1){
            $sql= 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t3.Score,t3.InsureScore,CONVERT(varchar,t1.MemberOverDate,111) as MemberOverDate ';
            $sql.= 'FROM  QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t3 on t1.UserID=t3.UserID ';
            $sql.= 'where t1.GameID='.$GameID.' and t1.MemberOrder>0 and t1.MemberOverDate>"'.$date.'"';
        }else{
            $sql= 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t3.Score,t3.InsureScore,CONVERT(varchar,t1.MemberOverDate,111) as MemberOverDate ';
            $sql.= 'FROM  QPAccountsDB.dbo.AccountsInfo t1,QPTreasureDB.dbo.GameScoreInfo t3,QPWebBackDB.dbo.VipMember t4 ';
            $sql.= 'where t1.UserID=t3.UserID and t1.Nullity=0 and t1.UserID=t4.UserID and t4.GroupNum='.$GameID.' and t1.MemberOrder>0 and t1.MemberOverDate>"'.$date.'"';
			//echo $sql;
			//exit;
        }
        $rs=$mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['no'] = $i+1;
            $rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            $sum['Score_sum'] = $sum['Score_sum']+$rs[$i]['Score'];
            $sum['InsureScore_sum'] = $sum['InsureScore_sum']+$rs[$i]['InsureScore'];
            $rs[$i]['gold_sum'] = $rs[$i]['Score']+$rs[$i]['InsureScore'];
            $rs[$i]['Score'] = number_format($rs[$i]['Score']);
            $rs[$i]['InsureScore'] = number_format($rs[$i]['InsureScore']);
            $rs[$i]['gold_sum'] = number_format($rs[$i]['gold_sum']);
            $rs[$i]['GroupNum'] = $this->getGroup($rs[$i]['UserID']);
        }
        $sum['sum'] = number_format($sum['Score_sum']+$sum['InsureScore_sum']);
        $sum['InsureScore_sum'] = number_format($sum['InsureScore_sum']);
        $sum['Score_sum'] = number_format($sum['Score_sum']);
        $this->assign('sum',$sum);
        $this->assign('result',$rs);
        $this->display('vip');
    }

    //vip转账情况
    public function vip_zz(){
        if($_SESSION['zs78_admin']['role']>2){
            _location('无此权限',WEB_ROOT.'index.php/User');
            return;
        }
        $date = date('Y-m-d');
        if(!$_GET['s_date']){
            $s_date = date('Y-m-d');
            //$s_date = '2014-02-14';
        }else{
            $s_date = $_GET['s_date'];
        }
        $start_date = $s_date.' 00:00:00';
        $end_date = date('Y-m-d H:i:s',strtotime($start_date)+3600*24-1);
        if(!$_GET['type']){
            //$s_date = date('Y-m-d');
            $type = 1;
        }else{
            $type = $_GET['type'];
        }
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        $pageSize = PAGE_SIZE_2;
        $mssql=M();
        if($_GET['GameID']){
            $GameID=$_GET['GameID'];
            $sql = 'SELECT UserID,GameID,Accounts,NickName FROM QPAccountsDB.dbo.AccountsInfo where GameID='.$GameID.' and Nullity=0 and MemberOrder>0 and MemberOverDate>"'.$date.'"';
            $rs=$mssql->query($sql);
            if(!$rs[0]['UserID']){
                _location('无此GameID，请重试', WEB_ROOT."index.php/Vip/vip_zz");
                return;
            }else{
                $rs[0]['Accounts'] = iconv("GBK","UTF-8",$rs[0]['Accounts']);
                $rs[0]['NickName'] = iconv("GBK","UTF-8",$rs[0]['NickName']);
                $rs[0]['GroupNum'] = $this->getGroup($rs[0]['UserID']);
                $rs[0]['zz'] = $this->getVipzz($rs[0]['UserID'],$s_date,$type);
                $rs[0]['sum'] = $rs[0]['zz']['zc_sum']-$rs[0]['zz']['zr_sum'];
                $rs[0]['zz']['zr_sum'] = number_format($rs[0]['zz']['zr_sum']);
                $rs[0]['zz']['zc_sum'] = number_format($rs[0]['zz']['zc_sum']);
                $rs[0]['zz']['zz_sum'] = number_format($rs[0]['zz']['zz_sum']);
                $this->assign('type',$type);
                $this->assign('GameID',$GameID);
                $this->assign('s_date',$s_date);
                $this->assign('result',$rs);
                $this->display('vip_zz');
            }
            return;
        }

        $sql1 = 'select count(UserID) as num from QPAccountsDB.dbo.AccountsInfo where MemberOrder>0 and Nullity=0 and MemberOverDate>"'.date('Y-m-d H:i:s').'"';
        $rs1 = $mssql->query($sql1);
        $count = $rs1[0]['num'];
        if($pageNo*$pageSize>$count){
            $num = $count-(($pageNo-1)*$pageSize);
        }else{
            $num = $pageSize;
        }

        $sql2 = 'SELECT UserID,GameID,Accounts,NickName,GroupNum FROM (SELECT TOP ('.$num.') UserID,GameID,Accounts,NickName,GroupNum FROM ';
        $sql2.= '(SELECT TOP ('.$pageNo*$pageSize.') t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t3.GroupNum ';
        $sql2.= 'FROM QPAccountsDB.dbo.AccountsInfo t1 left join QPWebBackDB.dbo.VipMember t3 on t1.UserID=t3.UserID ';
        $sql2.= 'where t1.Nullity=0 and t1.MemberOrder>0 and t1.MemberOverDate>"'.$date.'" order by GroupNum asc,t1.UserID asc) t4 order by GroupNum desc,UserID desc) t5 order by GroupNum asc,UserID asc';

        $rs2=$mssql->query($sql2);
        for($i=0;$i<count($rs2);$i++){
            $rs2[$i]['no'] = $i+1+($pageNo-1)*PAGE_SIZE_2;
            $rs2[$i]['Accounts'] = iconv("GBK","UTF-8",$rs2[$i]['Accounts']);
            $rs2[$i]['NickName'] = iconv("GBK","UTF-8",$rs2[$i]['NickName']);
            $rs2[$i]['zz'] = $this->getVipzz($rs2[$i]['UserID'],$s_date,$type);
            $sum['zr_sum'] = $sum['zr_sum'] + $rs2[$i]['zz']['zr_sum'];
            $sum['zc_sum'] = $sum['zc_sum'] + $rs2[$i]['zz']['zc_sum'];
            $sum['zz_sum'] = $sum['zz_sum'] + $rs2[$i]['zz']['zz_sum'];
            $rs2[$i]['zz']['zr_sum'] = number_format($rs2[$i]['zz']['zr_sum']);
            $rs2[$i]['zz']['zc_sum'] = number_format($rs2[$i]['zz']['zc_sum']);
            $rs2[$i]['zz']['zz_sum'] = number_format($rs2[$i]['zz']['zz_sum']);
            $rs2[$i]['sum'] = $rs2[$i]['zz']['zc_sum']-$rs2[$i]['zz']['zr_sum'];
        }
        $sum['zz_sum'] = number_format($sum['zz_sum']);
        $sum['zr_sum'] = number_format($sum['zr_sum']);
        $sum['zc_sum'] = number_format($sum['zc_sum']);
        $pageNum = ceil($count/$pageSize);
        //print_r($rs2);
        $this->assign('type',$type);
        $this->assign('sum',$sum);
        $this->assign('s_date',$s_date);
        $this->assign('pageNum',$pageNum);
        $this->assign('result',$rs2);
        $this->display('vip_zz');
    }

    //vip转账详细
    public function vip_all_record(){
        $zz_type=$_GET['zz_type'];
        $user_type=$_GET['user_type'];
        $s_date = $_GET['s_date'];
        $UserID = $_GET['UserID'];
        $start_date = $s_date.' 00:00:00';
        $end_date = $s_date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
        $procedure = mssql_init("PHP_VipZzRecord",$conn);
        mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        mssql_bind($procedure,"@zz_type", $zz_type, SQLINT4);
        mssql_bind($procedure,"@user_type", $user_type, SQLINT4);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
        mssql_close($conn);
        if($zz_type==4){
            for($i=0;$i<count($rs);$i++){
                $rs[$i]['no'] = $i+1;
                $rs[$i]['user_zr'] = $this->getInfoByUserID($rs[$i]['zr_UserID']);
                $rs[$i]['user_zc'] = $this->getInfoByUserID($rs[$i]['zc_UserID']);
                $rs[$i]['zr_UserID'] = $rs[$i]['user_zr']['UserID'];
                $rs[$i]['zc_UserID'] = $rs[$i]['user_zc']['UserID'];
                $rs[$i]['zr_GameID'] = $rs[$i]['user_zr']['GameID'];
                $rs[$i]['zc_GameID'] = $rs[$i]['user_zc']['GameID'];
                $rs[$i]['zr_NickName'] = $rs[$i]['user_zr']['NickName'];
                $rs[$i]['zc_NickName'] = $rs[$i]['user_zc']['NickName'];
                $rs[$i]['SwapScore'] = number_format($rs[$i]['zr_Score']);
                $rs[$i]['CollectDate'] = $rs[$i]['InsertTime'];
            }
        }else{
            for($i=0;$i<count($rs);$i++){
                $rs[$i]['no'] = $i+1;
                $rs[$i]['zr_NickName'] = iconv("GBK","UTF-8",$rs[$i]['zr_NickName']);
                $rs[$i]['zc_NickName'] = iconv("GBK","UTF-8",$rs[$i]['zc_NickName']);
                $rs[$i]['SwapScore'] = number_format($rs[$i]['SwapScore']);
            }
        }
        if($zz_type==1 && $user_type==1){
            $title='所有转入记录';
        }elseif($zz_type==1 && $user_type==2) {
            $title='所有转出记录';
        }elseif($zz_type==2 && $user_type==1) {
            $title='vip转入记录';
        }elseif($zz_type==2 && $user_type==2) {
            $title='vip转出记录';
        }elseif($zz_type==3 && $user_type==1) {
            $title='普通转入记录';
        }elseif($zz_type==3 && $user_type==2) {
            $title='普通转出记录';
        }elseif($zz_type==4 && $user_type==1) {
            $title='指导费转入记录';
        }elseif($zz_type==4 && $user_type==2) {
            $title='指导费转出记录';
        }
        $this->assign('result',$rs);
        $this->assign('title',$title);
        $this->assign('type',$zz_type);
        $this->assign('s_date',$s_date);
        $this->display('vip_zz_record');
    }

    //vip转入转出情况
    public function getVipzz($UserID,$s_date,$type){
        $start_date = $s_date.' 00:00:00';
        $end_date = $s_date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();

        $procedure = mssql_init("PHP_VipZzInfo",$conn);

        mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        mssql_bind($procedure,"@type", $type, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        if($row = mssql_fetch_assoc($resource)){
                //$rs['game'] = $this->getGameName($rs[$i]['KindID']);
            $rs['zz_sum'] = $row['zc_sum']-$row['zr_sum'];
            $rs['zr_count'] = $row['zr_count'];
            $rs['zr_sum'] = $row['zr_sum'];
            $rs['zc_count'] = $row['zc_count'];
            $rs['zc_sum'] = $row['zc_sum'];
        }
        mssql_free_statement($procedure);
        mssql_close($conn);
        return $rs;
    }

    //vip所有转入转出情况
    public function getVipZzAll($UserID,$s_date){
        $start_date = $s_date.' 00:00:00';
        $end_date = $s_date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();

        $procedure = mssql_init("PHP_VipZzAll",$conn);

        mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        if($row = mssql_fetch_assoc($resource)){
                //$rs['game'] = $this->getGameName($rs[$i]['KindID']);
            $rs['zr_count'] = $row['zr_count'];
            $rs['zr_sum'] = $row['zr_sum'];
            $rs['zc_count'] = $row['zc_count'];
            $rs['zc_sum'] = $row['zc_sum'];
            $rs['wzq_zr_count'] = $row['wzq_zr_count'];
            $rs['wzq_zr_sum'] = $row['wzq_zr_sum'];
            $rs['wzq_zc_count'] = $row['wzq_zc_count'];
            $rs['wzq_zc_sum'] = $row['wzq_zc_sum'];
        }
        mssql_free_statement($procedure);
        mssql_close($conn);
        return $rs;
    }

    //vip所有转入转出情况(月统计)
    public function getVipZzAll2($UserID,$start_date,$end_date){
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();

        $procedure = mssql_init("PHP_VipZzAll",$conn);

        mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        if($row = mssql_fetch_assoc($resource)){
                //$rs['game'] = $this->getGameName($rs[$i]['KindID']);
            $rs['zr_count'] = $row['zr_count'];
            $rs['zr_sum'] = $row['zr_sum'];
            $rs['zc_count'] = $row['zc_count'];
            $rs['zc_sum'] = $row['zc_sum'];
            $rs['wzq_zr_count'] = $row['wzq_zr_count'];
            $rs['wzq_zr_sum'] = $row['wzq_zr_sum'];
            $rs['wzq_zc_count'] = $row['wzq_zc_count'];
            $rs['wzq_zc_sum'] = $row['wzq_zc_sum'];
        }
        mssql_free_statement($procedure);
        mssql_close($conn);
        return $rs;
    }

    //转账详细情况
    public function zz_record(){
        $UserID = $_GET['UserID'];
        $type=$_GET['type'];
        $s_date = $_GET['s_date'];
        $count = $_GET['count'];
        $pageSize = PAGE_SIZE_2;
        if($_GET['pageNo']){
            $pageNo = $_GET['pageNo'];
        }else{
            $pageNo = 1;
        }
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
        $procedure = mssql_init("PHP_VipZzRecord",$conn);
        mssql_bind($procedure,"@UserID", $UserID, SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        mssql_bind($procedure,"@type", $type, SQLINT4);
        mssql_bind($procedure,"@pageNo", $pageNo, SQLINT4);
        mssql_bind($procedure,"@pageSize", $pageSize, SQLINT4);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
        mssql_close($conn);

        for($i=0;$i<count($rs);$i++){
            $rs[$i]['game'] = $this->getGameName('51');
            //$rs[$i]['room'] = $result[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['ServerName']);
            $rs[$i]['no'] = $i+1+($pageNo-1)*$pageSize;
            $rs[$i]['Score'] = number_format($rs[$i]['Score']);
            $rs[$i]['users'] = $this->getGameList($rs[$i]['DrawID_1']);
        }
        $pageNum = ceil($count/$pageSize);

        $this->assign('pageNum',$pageNum);
        $this->assign('UserID',$UserID);
        $this->assign('result',$rs);
        $this->display('zz_record');
    }

    //vip导出金币信息
    public function vip_export(){
        $mssql = M();
        $sql = 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t4.GroupNum,t3.Score,t3.InsureScore,t3.Score+t3.InsureScore as gold_sum,CONVERT(varchar,t1.MemberOverDate,111) as MemberOverDate ';
        $sql.= 'FROM  QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t3 on t1.UserID=t3.UserID left join QPWebBackDB.dbo.VipMember t4 on t1.UserID=t4.UserID ';
        $sql.= 'where t1.Nullity=0 and t1.MemberOrder>0 and t1.MemberOverDate>"'.date('Y-m-d H:i:s').'" order by GroupNum asc';
        $rs = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
            $result[$i]['GameID'] = $rs[$i]['GameID'];
            $result[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $result[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            $result[$i]['GroupNum'] = $rs[$i]['GroupNum'];
            $result[$i]['Score'] = $rs[$i]['Score'];
            $result[$i]['InsureScore'] = $rs[$i]['InsureScore'];
            $result[$i]['gold_sum'] = $rs[$i]['gold_sum'];
            $result[$i]['MemberOverDate'] = $rs[$i]['MemberOverDate'];
        }
        $title = array('GameID','用户账号','用户昵称','群组','身上金币','银行金币','总金币','到期时间');
        $filename = date('Y-m-d H:i:s').'vip金币统计';
        exportexcel($result,$title,$filename);
    }

    //vip导出转账信息
    public function vip_export2(){
        if($_GET['s_date']){
            $s_date = $_GET['s_date'];
        }else{
            $s_date = date('Y-m-d');
        }
        $mssql = M();
        $sql = 'SELECT t1.UserID,t1.GameID,t1.Accounts,t1.NickName,t4.GroupNum,t3.Score,t3.InsureScore,t3.Score+t3.InsureScore as gold_sum,CONVERT(varchar,t1.MemberOverDate,111) as MemberOverDate ';
        $sql.= 'FROM  QPAccountsDB.dbo.AccountsInfo t1 left join QPTreasureDB.dbo.GameScoreInfo t3 on t1.UserID=t3.UserID left join QPWebBackDB.dbo.VipMember t4 on t1.UserID=t4.UserID ';
        $sql.= 'where t4.GroupNum<9999 and t1.Nullity=0 and t1.MemberOrder>0 and t1.MemberOverDate>"'.date('Y-m-d H:i:s').'" order by GroupNum asc';
        $rs = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['zz'] = $this->getVipZzAll($rs[$i]['UserID'],$s_date);
            $result[$i]['GameID'] = $rs[$i]['GameID'];
            $result[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $result[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            $result[$i]['GroupNum'] = $rs[$i]['GroupNum'];
            $result[$i]['zr_count'] = $rs[$i]['zz']['zr_count'];
            $result[$i]['zr_sum'] = $rs[$i]['zz']['zr_sum'];
            $result[$i]['zc_count'] = $rs[$i]['zz']['zc_count'];
            $result[$i]['zc_sum'] = $rs[$i]['zz']['zc_sum'];
            $result[$i]['wzq_zr_count'] = $rs[$i]['zz']['wzq_zr_count'];
            $result[$i]['wzq_zr_sum'] = $rs[$i]['zz']['wzq_zr_sum'];
            $result[$i]['wzq_zc_count'] = $rs[$i]['zz']['wzq_zc_count'];
            $result[$i]['wzq_zc_sum'] = $rs[$i]['zz']['wzq_zc_sum'];
            $result[$i]['MemberOverDate'] = $rs[$i]['MemberOverDate'];
        }
        $title = array('GameID','用户账号','用户昵称','群组','转入次数','转入总额','转出次数','转出金额','五子棋转入次数','五子棋转入金额','五子棋转出次数','五子棋转出金额','到期时间');
        $filename = date('Y-m-d H:i:s').'vip转账统计';
        exportexcel($result,$title,$filename);
    }

    //vip月统计
    public function vip_ytj(){
        $this->display('vip_ytj');
    }

    //vip月统计搜索
    public function vip_ytj_s(){
        if($_SESSION['zs78_admin']['role']>2){
            _location('无此权限',WEB_ROOT.'index.php/User');
            return;
        }
        if($_GET['GameID']){
            $GameID = $_GET['GameID'];
        }else{
            header('Location: '.WEB_ROOT.'index.php/Vip/vip_ytj');
        }
        $start_date = $_GET['start_date'].' 00:00:00';
        $end_date = $_GET['end_date'].' 23:59:59';
        $mssql=M();
        $sql = 'SELECT UserID,GameID,Accounts,NickName ';
        $sql.= 'FROM QPAccountsDB.dbo.AccountsInfo ';
        $sql.= 'where GameID='.$GameID;
        $result = $mssql->query($sql);
        if(!$result[0]['UserID']){
            _location('无该GameID用户信息',WEB_ROOT.'index.php/Vip/vip_ytj');
        }
        $result[0]['Accounts'] = iconv("GBK","UTF-8",$result[0]['Accounts']);
        $result[0]['NickName'] = iconv("GBK","UTF-8",$result[0]['NickName']);
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();

        $procedure = mssql_init("PHP_VipUserZz",$conn);

        mssql_bind($procedure,"@UserID", $result[0]['UserID'], SQLINT4);
        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        if($row = mssql_fetch_assoc($resource)){
                //$rs['game'] = $this->getGameName($rs[$i]['KindID']);
            $rs['count'] = $row['zc_count'] + $row['zr_count'];
            $rs['num'] = $row['zc_num'] - $row['zr_num'];
            $rs['zc_count'] = number_format($row['zc_count']);
            $rs['zc_num'] = number_format($row['zc_num']);
            $rs['zr_count'] = number_format($row['zr_count']);
            $rs['zr_num'] = number_format($row['zr_num']);
            $rs['zc_pt_count'] = number_format($row['zc_pt_count']);
            $rs['zc_pt_num'] = number_format($row['zc_pt_num']);
            $rs['zc_vip_count'] = number_format($row['zc_vip_count']);
            $rs['zc_vip_num'] = number_format($row['zc_vip_num']);
            $rs['vip_zr_count'] = number_format($row['vip_zr_count']);
            $rs['vip_zr_num'] = number_format($row['vip_zr_num']);
            $rs['pt_zr_count'] = number_format($row['pt_zr_count']);
            $rs['pt_zr_num'] = number_format($row['pt_zr_num']);
            $rs['count'] = number_format($rs['count']);
            $rs['num'] = number_format($rs['num']);
        }
        //print_r($rs[0]);
        $this->assign('rs',$rs);
        $this->assign('result',$result[0]);
        $this->assign('start_date',$start_date);
        $this->assign('end_date',$end_date);
        $this->display('vip_ytj_xx');

    }

    //获取用户信息
    public function getInfoByUserID($UserID){
        $mssql = M();
        $sql = 'select UserID,GameID,Accounts,NickName from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where UserID = '.$UserID;
        $result = $mssql->query($sql);
        $result[0]['Accounts'] = iconv("GBK","UTF-8",$result[0]['Accounts']);
        $result[0]['NickName'] = iconv("GBK","UTF-8",$result[0]['NickName']);
        return $result[0];
    }

	//当日转出排行
    public function day_list(){
        if($_GET['date']){
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
        $start_date = $date.' 00:00:00';
        $end_date = $date.' 23:59:59';
     
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
		$UserIDs = array();

        $procedure = mssql_init("PHP_VipDayList",$conn);

        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
		/*
		$procedure2 = mssql_init("PHP_VipUnGame",$conn);

        mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
        $resource2 = mssql_execute($procedure2);
        while($row2 = mssql_fetch_assoc($resource2)){
			array_push($UserIDs,$row2['UserID']);
        }
        mssql_free_statement($procedure2);
		*/

        mssql_close($conn);
		$mssql = M();
		$sql = 'SELECT t3.GameID,SUM(t1.SwapScore) as num FROM [QPTreasureDB].[dbo].[CancelInsure](NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.TargetUserID=t2.UserID left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3 on t1.SourceUserID=t3.UserID ';
		$sql.= 'where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t3.MemberOrder>0 and t2.MemberOrder=0 group by t3.GameID';
		$result = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
			foreach ($result as $key => $val) {
				if($rs[$i]['GameID']==$val['GameID']){
					$rs[$i]['Num'] = $rs[$i]['Num']-$val['num'];
				}
			}
			if($rs[$i]['Num']>=20000000){
            $rs[$i]['no'] = $i+1;
			}
            $rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            if($rs[$i]['Num']>=3000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.1;
            }
            if($rs[$i]['Num']>=1000000000 and $rs[$i]['Num']<3000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.08;
            }
            if($rs[$i]['Num']>=500000000 and $rs[$i]['Num']<1000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.06;
            }
            if($rs[$i]['Num']>=100000000 and $rs[$i]['Num']<500000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.04;
            }
			if($rs[$i]['Num']>=60000000 and $rs[$i]['Num']<100000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.03;
            }
			if($rs[$i]['Num']>=20000000 and $rs[$i]['Num']<60000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.02;
            }
			/*
			if(in_array($rs[$i]['SourceUserID'],$UserIDs)){
				$rs[$i]['isChange'] =1;
			}else{
				$rs[$i]['isChange'] =0;
			}
			*/
			$sum = $sum+$rs[$i]['give'];
            $rs[$i]['Num'] = number_format($rs[$i]['Num']);
            $rs[$i]['give'] = number_format($rs[$i]['give']);
        }
		$sum = number_format($sum);
        $this->assign('result',$rs);
        $this->assign('date',$date);
		$this->assign('sum',$sum);
        $this->display('vip_day_list');
    }

	//当日普通玩家转出排行
    public function pt_list(){
        if($_GET['date']){
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
        $start_date = $date.' 00:00:00';
        $end_date = $date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
		$UserIDs = array();

        $procedure = mssql_init("PHP_PtDayList",$conn);

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
			$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
			//$sum = $sum+$rs[$i]['give'];
            $rs[$i]['Num'] = number_format($rs[$i]['Num']);
            //$rs[$i]['give'] = number_format($rs[$i]['give']);
        }
		//$sum = number_format($sum);
        $this->assign('result',$rs);
        $this->assign('date',$date);
		//$this->assign('sum',$sum);
        $this->display('pt_day_list');
    }

//奖励新游戏
    public function new_list(){
        if($_GET['date']){
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
        $start_date = $date.' 00:00:00';
        $end_date = $date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();

        $procedure = mssql_init("PHP_VipDayList2",$conn);

        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
        mssql_close($conn);

        for($i=0;$i<count($rs);$i++){

			if($rs[$i]['Num']>20000000){
            $rs[$i]['no'] = $i+1;
			}
            $rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            if($rs[$i]['Num']>=3000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.1;
            }
            if($rs[$i]['Num']>=2000000000 and $rs[$i]['Num']<3000000000){
                $rs[$i]['give'] = 120000000;
            }
            if($rs[$i]['Num']>=1500000000 and $rs[$i]['Num']<2000000000){
                $rs[$i]['give'] = 78000000;
            }
            if($rs[$i]['Num']>=1000000000 and $rs[$i]['Num']<1500000000){
                $rs[$i]['give'] = 50000000;
            }
            if($rs[$i]['Num']>=500000000 and $rs[$i]['Num']<1000000000){
                $rs[$i]['give'] = 22000000;
            }
            if($rs[$i]['Num']>=300000000 and $rs[$i]['Num']<500000000){
                $rs[$i]['give'] = 12500000;
            }
            if($rs[$i]['Num']>=250000000 and $rs[$i]['Num']<300000000){
                $rs[$i]['give'] = 11000000;
            }
            if($rs[$i]['Num']>=200000000 and $rs[$i]['Num']<250000000){
                $rs[$i]['give'] = 8000000;
            }
            if($rs[$i]['Num']>=150000000 and $rs[$i]['Num']<200000000){
                $rs[$i]['give'] = 6000000;
            }
            if($rs[$i]['Num']>=100000000 and $rs[$i]['Num']<150000000){
                $rs[$i]['give'] = 3500000;
            }
            if($rs[$i]['Num']>=50000000 and $rs[$i]['Num']<100000000){
                $rs[$i]['give'] = 2200000;
            }
            if($rs[$i]['Num']>=20000000 and $rs[$i]['Num']<50000000){
                $rs[$i]['give'] = 1000000;
            }
			$sum = $sum+$rs[$i]['give'];
            $rs[$i]['Num'] = number_format($rs[$i]['Num']);
            $rs[$i]['give'] = number_format($rs[$i]['give']);
        }
		$sum = number_format($sum);
        $this->assign('result',$rs);
        $this->assign('date',$date);
		$this->assign('sum',$sum);
        $this->display('vip_day_list2');
    }

	public function test(){
        if($_GET['date']){
            $date = $_GET['date'];
        }else{
			$date = '2015-03-29';
            //$date = date('Y-m-d');
        }
        $start_date = $date.' 00:00:00';
        $end_date = $date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
		$UserIDs = array();

        $procedure = mssql_init("PHP_VipDayList",$conn);

        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
		/*
		$procedure2 = mssql_init("PHP_VipUnGame",$conn);

        mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
        $resource2 = mssql_execute($procedure2);
        while($row2 = mssql_fetch_assoc($resource2)){
			array_push($UserIDs,$row2['UserID']);
        }
        mssql_free_statement($procedure2);
		*/

        mssql_close($conn);
		$mssql = M();
		$sql = 'SELECT t3.GameID,SUM(t1.SwapScore) as num FROM [QPTreasureDB].[dbo].[CancelInsure](NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.TargetUserID=t2.UserID left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3 on t1.SourceUserID=t3.UserID ';
		$sql.= 'where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t3.MemberOrder>0 and t2.MemberOrder=0 group by t3.GameID';
		$result = $mssql->query($sql);
		print_r($result);

        for($i=0;$i<count($rs);$i++){
			foreach ($result as $key => $val) {
				if($rs[$i]['GameID']==$val['GameID']){
					$rs[$i]['Num'] = $rs[$i]['Num']-$val['num'];
				}
			}
			if($rs[$i]['Num']>=20000000){
            $rs[$i]['no'] = $i+1;
			}
            $rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            $rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            if($rs[$i]['Num']>=3000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.1;
            }
            if($rs[$i]['Num']>=1000000000 and $rs[$i]['Num']<3000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.08;
            }
            if($rs[$i]['Num']>=500000000 and $rs[$i]['Num']<1000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.06;
            }
            if($rs[$i]['Num']>=100000000 and $rs[$i]['Num']<500000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.04;
            }
			if($rs[$i]['Num']>=60000000 and $rs[$i]['Num']<100000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.03;
            }
			if($rs[$i]['Num']>=20000000 and $rs[$i]['Num']<60000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.02;
            }
			/*
			if(in_array($rs[$i]['SourceUserID'],$UserIDs)){
				$rs[$i]['isChange'] =1;
			}else{
				$rs[$i]['isChange'] =0;
			}
			*/
			$sum = $sum+$rs[$i]['give'];
            $rs[$i]['Num'] = number_format($rs[$i]['Num']);
            $rs[$i]['give'] = number_format($rs[$i]['give']);
        }
		$sum = number_format($sum);
        $this->assign('result',$rs);
        $this->assign('date',$date);
		$this->assign('sum',$sum);
        $this->display('vip_day_list');
    }

	//添加奖励统计
    public function add_jl_record(){
        $date = date("Y-m-d",strtotime("-1 day"));
        //$date='2015-05-06';
        $start_date = $date.' 00:00:00';
        $end_date = $date.' 23:59:59';
        $conn=mssql_connect($GLOBALS['DB_NEW']['DB_HOST'],$GLOBALS['DB_NEW']['DB_USER'],$GLOBALS['DB_NEW']['DB_PWD']);
        mssql_select_db($GLOBALS['DB_NEW']['DB_NAME']);
        $rs = array();
        $UserIDs = array();

        $procedure = mssql_init("PHP_VipDayList",$conn);

        mssql_bind($procedure,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure,"@end_date", $end_date, SQLVARCHAR);
        $resource = mssql_execute($procedure);
        while($row = mssql_fetch_assoc($resource)){
            $rs[] = $row;
        }
        mssql_free_statement($procedure);
        /*
        $procedure2 = mssql_init("PHP_VipUnGame",$conn);

        mssql_bind($procedure2,"@start_date", $start_date, SQLVARCHAR);
        mssql_bind($procedure2,"@end_date", $end_date, SQLVARCHAR);
        $resource2 = mssql_execute($procedure2);
        while($row2 = mssql_fetch_assoc($resource2)){
            array_push($UserIDs,$row2['UserID']);
        }
        mssql_free_statement($procedure2);
        */

        mssql_close($conn);
        $mssql = M();
        $sql = 'SELECT t3.GameID,SUM(t1.SwapScore) as num FROM [QPTreasureDB].[dbo].[CancelInsure](NOLOCK) t1 left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t2 on t1.TargetUserID=t2.UserID left join QPAccountsDB.dbo.AccountsInfo(NOLOCK) t3 on t1.SourceUserID=t3.UserID ';
        $sql.= 'where t1.InsertDate between "'.$start_date.'" and "'.$end_date.'" and t3.MemberOrder>0 and t2.MemberOrder=0 group by t3.GameID';
        $result = $mssql->query($sql);
        for($i=0;$i<count($rs);$i++){
            foreach ($result as $key => $val) {
                if($rs[$i]['GameID']==$val['GameID']){
                    $rs[$i]['Num'] = $rs[$i]['Num']-$val['num'];
                }
            }
            if($rs[$i]['Num']>=20000000){
            $rs[$i]['no'] = $i+1;
            }
            //$rs[$i]['Accounts'] = iconv("GBK","UTF-8",$rs[$i]['Accounts']);
            //$rs[$i]['NickName'] = iconv("GBK","UTF-8",$rs[$i]['NickName']);
            if($rs[$i]['Num']>=3000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.1;
            }
            if($rs[$i]['Num']>=1000000000 and $rs[$i]['Num']<3000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.08;
            }
            if($rs[$i]['Num']>=500000000 and $rs[$i]['Num']<1000000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.06;
            }
            if($rs[$i]['Num']>=100000000 and $rs[$i]['Num']<500000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.04;
            }
            if($rs[$i]['Num']>=60000000 and $rs[$i]['Num']<100000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.03;
            }
            if($rs[$i]['Num']>=20000000 and $rs[$i]['Num']<60000000){
                $rs[$i]['give'] = $rs[$i]['Num']*0.02;
            }
            /*
            if(in_array($rs[$i]['SourceUserID'],$UserIDs)){
                $rs[$i]['isChange'] =1;
            }else{
                $rs[$i]['isChange'] =0;
            }
            */
            //$sum = $sum+$rs[$i]['give'];

            $sql2 = 'Insert into QPWebbackDB.dbo.GiveRecord (UserID,GameID,Accounts,NickName,Num,Give,IsSend,InsertDate) values('.$rs[$i]['SourceUserID'].','.$rs[$i]['GameID'].',"'.$rs[$i]['Accounts'].'","'.$rs[$i]['NickName'].'",'.$rs[$i]['Num'].','.$rs[$i]['give'].',0,"'.$date.'")';
            //echo $sql2;
			$mssql->query($sql2);
            //$rs[$i]['Num'] = number_format($rs[$i]['Num']);
            //$rs[$i]['give'] = number_format($rs[$i]['give']);
        }
        //echo 11;
    }

}
