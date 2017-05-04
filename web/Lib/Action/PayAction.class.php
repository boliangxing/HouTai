<?php



class PayAction extends Action {

    public function index(){  

        $this->display('PayIndex');     

    }

    

    public function PayAli(){

        $this->display('PayAli');

    }

    

    public function PayAliSend(){

        header("Content-Type:text/html;charset=utf-8");

        //require_once(ROOT_PATH . '/Pay/zfb/alipay.config.php');

        //require_once(ROOT_PATH . '/Pay/zfb/lib/alipay_submit.class.php');

        //$Accounts = iconv("UTF-8","GB2312",$_POST['txtPayAccounts']);
        //原本是通过网页充值,取用户的登录名。现在改成用户的gameid

        /** 过滤  TODO **/
        /** 同个ip地址 下订单的次数和时间间隔 TODO**/
        
        $data = json_decode(file_get_contents('php://input'),true);
        file_put_contents('data1.txt', json_encode($data));
        $GameID = $data['biz_content']['game_id'];
        $price = $data['biz_content']['pay_price'];
        $payType = $data['biz_content']['pay_type'];
        $IPAddress = $_SERVER["REMOTE_ADDR"];
        //验证产品
        $user = $this->CheckUser($GameID);
        if(!$user){
            $this->autoReturn(array('code'=> 0, 'err'=>'用户不存在'));
            return;
        }


        $card = $this->GetCardID($price);

        if(!$card){
            $this->autoReturn(array('code'=> 2, 'err'=>'未找到充值卡,金额错误'));
            return;
        }

        $CardTypeID = $card[0]['CardTypeID'];

        $GameID = $user[0]['GameID'];

        $typeArray = $this->payTypeArray();
        
        if(!in_array($payType, $typeArray)){
          $this->autoReturn(array('eax'=> 4, 'err'=>'订单前缀没找到'));
        }
        
        $payTypeId = 0;
        
        foreach($typeArray as $k=>$v){
          if($v==$payType){
            $payTypeId = $k;
            break;
          }
        }
        
        if($payTypeId==0){
          $this->autoReturn(array('eax'=> 6, 'err'=>'订单前缀id没找到'));
        }

        $OrderID = $this->GetOrderID($payTypeId);
 
        if ($this->ProduceOrder($GameID,$CardTypeID,$IPAddress,$OrderID)){
            $this->autoReturn(array('eax'=> 8, 'err'=>'订单创建失败'));
        };
        $this->autoReturn(array('OrderID'=> $OrderID, 'price'=>$price));
        //echo json_encode(array('OrderID'=> $OrderID, 'price'=>$price))
        // //生成订单

        // if(!$this->ProduceOrder($GameID,$CardTypeID,$IPAddress,$OrderID)){

        //     /**************************请求参数**************************/

        //     //支付类型

        //     $payment_type = "1";

        //     //必填，不能修改

        //     //服务器异步通知页面路径

        //     $notify_url = "http://game188.v.sdo.com/index.php/Pay/CheckOrderResult";

        //     //需http://格式的完整路径，不能加?id=123这类自定义参数



        //     //页面跳转同步通知页面路径

        //     $return_url = "http://game188.v.sdo.com/index.php/Pay/PayResult";

        //     //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/



        //     //卖家支付宝帐户

        //     $seller_email = 'cc@zjsykt.com';

        //     //必填



        //     //商户订单号

        //     $out_trade_no = $OrderID;

        //     //商户网站订单系统中唯一订单号，必填



        //     //订单名称

        //     $subject = $Price;

        //     //必填



        //     //付款金额

        //     $total_fee = $Price;

        //     //必填



        //     //订单描述           

        //     $body = "";

        //     //商品展示地址

        //     $show_url = "";

        //     //需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html



        //     //防钓鱼时间戳

        //     $anti_phishing_key = "";

        //     //若要使用请调用类文件submit中的query_timestamp函数



        //     //客户端的IP地址

        //     $exter_invoke_ip = $IPAddress;

        //     //非局域网的外网IP地址，如：221.0.0.1





        // /************************************************************/

        // //构造要请求的参数数组，无需改动

        //     $parameter = array(

        //             "service" => "create_direct_pay_by_user",

        //             "partner" => trim($alipay_config['partner']),

        //             "payment_type"  => $payment_type,

        //             "notify_url"    => $notify_url,

        //             "return_url"    => $return_url,

        //             "seller_email"  => $seller_email,

        //             "out_trade_no"  => $out_trade_no,

        //             "subject"   => $subject,

        //             "total_fee" => $total_fee,

        //             "body"  => $body,

        //             "show_url"  => $show_url,

        //             "anti_phishing_key" => $anti_phishing_key,

        //             "exter_invoke_ip"   => $exter_invoke_ip,

        //             "_input_charset"    => trim(strtolower($alipay_config['input_charset']))

        //     );

        //     //建立请求

        //     $alipaySubmit = new AlipaySubmit($alipay_config);

        //     $html_text = $alipaySubmit->buildRequestForm($parameter,"get","确认");

        //     echo $html_text;

        // }



    }

    //http://game188.v.sdo.com/index.php/Pay/PayResult?buyer_email=742711893%40qq.com&buyer_id=2088202804333025&exterface=create_direct_pay_by_user&is_success=T&notify_id=RqPnCoPT3K9%252Fvwbh3I75K6WmI5KKE2YZf303HcioMCgXsPGYeX435zwqPTSffN19%252B3Im&notify_time=2013-11-14+11%3A23%3A59&notify_type=trade_status_sync&out_trade_no=WebAli201311144TH0WP&payment_type=1&seller_email=cc%40zjsykt.com&seller_id=2088901660658076&subject=1&total_fee=1.00&trade_no=2013111442294202&trade_status=TRADE_SUCCESS&sign=4d813f468697419b8a056b53721ab786&sign_type=MD5

    //結果返回验证

    public function PayResult(){

        //header("Content-Type:text/html;charset=utf-8");

        require_once(ROOT_PATH . '/Pay/zfb/alipay.config.php');

        require_once(ROOT_PATH . '/Pay/zfb/lib/alipay_notify.class.php');

        $alipayNotify = new AlipayNotify($alipay_config);

        $verify_result = $alipayNotify->verifyReturn();

        if($verify_result) {//验证成功

            //file_put_contents('asddds.txt', $verify_result);

            //商户订单号

            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号

            $trade_no = $_GET['trade_no'];

            //交易状态

            $trade_status = $_GET['trade_status'];



            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {



                $user = $this->GetUserByOrderID($out_trade_no);

                $this->assign('user',$user);

                $this->assign('return',$_GET);

                $this->display('PaySucceed');  

                //判断该笔订单是否在商户网站中已经做过处理

                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序

                    //如果有做过处理，不执行商户的业务程序

            }

            else {

              echo "trade_status=".$_GET['trade_status'];

            }



        }

        else {

            $this->display('PayFailure');

            

        }

    }

    //回调通知结果

    public function CheckOrderResult(){

        header("Content-Type:text/html;charset=utf-8");

        //require_once(ROOT_PATH . '/Pay/zfb/alipay.config.php');

        //require_once(ROOT_PATH . '/Pay/zfb/lib/alipay_notify.class.php');

        //计算得出通知验证结果

        //file_put_contents('post2.txt', $_POST);
        $data = json_decode(file_get_contents('php://input'),true);
        $resultType = $data['type'];
        $order_no = $data['data']['object']['order_no'];
        $amount = $data['data']['object']['amount'];
        $channel = $data['data']['object']['channel'];

        if ($resultType == 'charge.succeeded') {
            # code...
            $error = $this->ProcessOrder($order_no,$amount);
            file_put_contents('r1.txt', $order_no.$amount.$channel.'err:'.$error);
            if($error==0){
                echo 'success';
            }else{
                echo 'fail';
            }
        }

        return;
        $alipayNotify = new AlipayNotify($alipay_config);

        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功

            //商户订单号

            $insert_error = $this->SaveAliReturn($_POST);

            if($insert_error==0){

               //file_put_contents('r1.txt', $insert_error);

            }else{

                //file_put_contents('r2.txt', $insert_error);

            }

            $OrderID = $_POST['out_trade_no'];

            //支付宝交易号

            $PayAmount = $_POST['total_fee'];

            //交易状态

            $trade_status = $_POST['trade_status'];

            if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {



                $error = $this->ProcessOrder($OrderID,$PayAmount);

                if($error==0){

                    echo 'success';

                }else{

                    echo 'fail';

                }

            }

        }

        else {

            //验证失败

            echo 'fail';

        }

    }

    //根据订单号得到用户数据

    public function GetUserByOrderID($OrderID){

        $mssql=M();

        $sql='SELECT GameID,Accounts,CardGold,OrderAmount FROM QPTreasureDB.dbo.OnLineOrder WHERE OrderID="'.$OrderID.'"';

        if($rs = $mssql->query($sql)){

            return $rs[0];

        }

    }
    
    //处理订单

    public function ProcessOrder($OrderID,$PayAmount){

        $mssql=M();

        $mssql->query("BEGIN TRANSACTION ProcessOrder"); //开始事务

        $sql = 'SELECT OperUserID,ShareID,UserID,GameID,Accounts,OrderID,CardTypeID,CardPrice,CardTotal,';

        $sql.= 'OrderAmount,DiscountScale,PayAmount,IPAddress,OrderStatus FROM QPTreasureDB.dbo.OnLineOrder WHERE OrderID="'.$OrderID.'"';

        //验证订单

        if($rs = $mssql->query($sql)){

            if($rs[0]['OrderStatus'] ==2 || $rs[0]['OrderAmount'] !=$PayAmount / 100){

                file_put_contents('w1.txt', $sql);

                return 1;

            }

        }

        $sql2='SELECT CardGold FROM QPTreasureDB.dbo.M_GlobalLivcard WHERE CardTypeID='.$rs[0]["CardTypeID"];

        if($rs2 = $mssql->query($sql2)){

            $CardGold = $rs2[0]['CardGold'];

        }

        $sql3='SELECT Score FROM QPTreasureDB.dbo.GameScoreInfo WHERE UserID='.$rs[0]["UserID"];

        if($rs3 = $mssql->query($sql3)){

            $Score = $rs3[0]['Score'];

        }

        $sql4='UPDATE QPTreasureDB.dbo.GameScoreInfo SET InsureScore=InsureScore+'.$CardGold.' WHERE UserID='.$rs[0]["UserID"];

        if($mssql->query($sql4)){

            $mssql->query("ROLLBACK TRANSACTION ProcessOrder"); //回滚事务

            file_put_contents('w2.txt', $sql4);

            return 2;

        }

        $sql5='INSERT INTO QPTreasureDB.dbo.ShareDetailInfo(

        OperUserID,ShareID,UserID,GameID,Accounts,OrderID,CardTypeID,CardPrice,CardGold,BeforeGold,

        CardTotal,OrderAmount,DiscountScale,PayAmount,IPAddress)

    VALUES('.$rs[0]["OperUserID"].','.$rs[0]["ShareID"].','.$rs[0]["UserID"].','.$rs[0]["GameID"].',"'.$rs[0]["Accounts"].'","'.$rs[0]["OrderID"].'",'.$rs[0]["CardTypeID"].',"'.$rs[0]["CardPrice"].'",'.$CardGold.','.$Score.','.$rs[0]["CardTotal"].',"'.$rs[0]["OrderAmount"].'","'.$rs[0]["DiscountScale"].'","'.$rs[0]["PayAmount"].'","'.$rs[0]["IPAddress"].'")';

        if($mssql->query($sql5)){

            $mssql->query("ROLLBACK TRANSACTION ProcessOrder"); //回滚事务

            file_put_contents('w3.txt', $sql5);

            return 3;

        }

        $sql6='UPDATE QPTreasureDB.dbo.OnLineOrder SET OrderStatus=2 WHERE OrderID="'.$OrderID.'"';

        if($mssql->query($sql6)){

            $mssql->query("ROLLBACK TRANSACTION ProcessOrder"); //回滚事务

            file_put_contents('w4.txt', $sql6);

            return 4;

        }
        file_put_contents('w4-1.txt', $sql6);

        $sql7='select CAST(CAST(GETDATE() AS FLOAT) AS INT) AS DateID';

        if($rs7=$mssql->query($sql7)){

            $DateID=$rs7[0]['DateID'];

        }

        $sql8='select count(DateID) as num from QPTreasureDB.dbo.StreamShareInfo where DateID='.$DateID.' AND ShareID='.$rs[0]["ShareID"];

        if($rs8=$mssql->query($sql8)){

            if($rs8[0]['num']>0){

                $sql9 = 'UPDATE QPTreasureDB.dbo.StreamShareInfo SET ShareTotals=ShareTotals+1 WHERE DateID='.$DateID.' AND ShareID='.$rs[0]["ShareID"];

                              

            }else{

                $sql9='INSERT INTO QPTreasureDB.dbo.StreamShareInfo(DateID,ShareID,ShareTotals) VALUES ('.$DateID.','.$rs[0]["ShareID"].',1)';

            }

            $mssql->query($sql9);

        }

        $mssql->query("COMMIT TRANSACTION ProcessOrder"); //提交事务

        file_put_contents('w5.txt', $sql9);

        return 0;

    }


    //验证用户

    public function CheckUser($GameID){

        $mssql = M();

        $sql = 'select UserID,GameID from QPAccountsDB.dbo.AccountsInfo where GameID="'.$GameID.'"';

        $rs = $mssql->query($sql);
        return $rs;       

    }

    //获取产品id

    public function GetCardID($CardPrice){

        $mssql = M();

        $sql = 'select CardTypeID from QPTreasureDB.dbo.M_GlobalLivcard where PayKind=4 and CardPrice="'.$CardPrice.'"';

        $rs = $mssql->query($sql);

        return $rs;        

    }

    //生成订单

    public function ProduceOrder($GameID,$CardTypeID,$IPAddress,$OrderID){

        $mssql=M();

        $res = array();

        $ApplyDate = date('Y-m-d H:i:s');

        $sql1 = 'select UserID,GameID,Accounts from QPAccountsDB.dbo.AccountsInfo(NOLOCK) where GameID = '.$GameID;

        if($rs1 = $mssql->query($sql1)){

            $UserID = $rs1[0]['UserID'];

            $GameID = $rs1[0]['GameID'];

            $Accounts = $rs1[0]['Accounts'];

        }



        $sql2 = 'select CardPrice,CardGold from QPTreasureDB.dbo.M_GlobalLivcard(NOLOCK) where CardTypeID = '.$CardTypeID;

        if($rs2 = $mssql->query($sql2)){

            $CardGold = $rs2[0]['CardGold'];

            $PayAmount = $rs2[0]['CardPrice'];

        }

        $sql = 'insert into QPTreasureDB.dbo.OnLineOrder (OperUserID,ShareID,UserID,GameID,Accounts,OrderID,CardTypeID,CardPrice,CardGold,CardTotal,OrderAmount,DiscountScale,PayAmount,OrderStatus,IPAddress,ApplyDate) values('.$UserID.',13,'.$UserID.','.$GameID.',"'.$Accounts.'","'.$OrderID.'",'.$CardTypeID.','.$PayAmount.','.$CardGold.',1,'.$PayAmount.',0,'.$PayAmount.',0,"'.$IPAddress.'","'.$ApplyDate.'")';

        if(!$mssql->query($sql)){

            return false;

        }

    }

    //得到唯一订单号

    public function GetOrderID($TypeId){

        $mssql = M();

        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $count = strlen($str);
        $typeArray = $this->payTypeArray();
        $OrderID = $typeArray[$TypeId].date('Ymd');
        $str1 = '';

        for($i=0;$i<6;$i++){

            $str1 = $str{rand(0, $count-1)};

            $OrderID = $OrderID.$str1;

        }

        $sql = 'select count(OnLineID) as num from QPTreasureDB.dbo.OnLineOrder(NOLOCK) where OrderID ="'.$OrderID.'"';

        $rs = $mssql->query($sql);

        if($rs[0]['num']==1){

            $this->GetOrderID($TypeId);

        }else{

            return $OrderID;

        }   

    }

    //保存支付宝返回信息

    public function SaveAliReturn($_POST){

        $mssql = M();

        $date=date('Y-m-d H:i:s');

        $sql = 'insert into QPTreasureDB.dbo.ReturnAliDetailInfo (p1_MerId,r0_Cmd,r1_Code,r2_TrxId,r3_Amt,r4_Cur,r5_Pid,r6_Order,r7_Uid,r8_MP,r9_BType,rb_BankId,ro_BankOrderId,rp_PayDate,rq_CardNo,ru_Trxtime,hmac,CollectDate) values("'.$_POST['seller_id'].'","'.$_POST['payment_type'].'","'.$_POST['trade_status'].'","'.$_POST['trade_no'].'","'.number_format($_POST['total_fee']) .'","RMB","'.$_POST['subject'].'","'.$_POST['out_trade_no'].'","'.$_POST['buyer_email'].'","'.$_POST['extra_common_param'].'","'.substr($_POST['trade_status'], 0,2).'","","","'.$_POST['notify_time'].'","","'.$_POST['notify_time'].'","'.$_POST['sign'].'","'.$date.'")';

        //file_put_contents('lll.txt', $sql);

        if($mssql->query($sql)){

            return 0;

        }else{

            return 1;

        }
    }
    
    public function GetIP(){
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else{
            $cip = "无法获取！";
        }
        return $cip;
    }


    /**
      +----------------------------------------------------------
      * 根据$_REQUEST['rdt']传进来的值, 返回不同的值, 函数调用后结束执行
      * 'json'/'xml'中的字符串为utf-8
      +----------------------------------------------------------
    **/
      private function autoReturn($data){
        $rdt = $this->_REQUEST('rdt', 'trim', 'json');
        $rdt = strtolower($rdt);
        switch($rdt){
          case 'json':
            //die('['.json_encode($data).']');  // 特殊处理一下
            $this->ajaxReturn($data, 'JSON');
            break;
          case 'xml':
            $this->ajaxReturn($data, 'XML');
            break;
          case 'lua':
            $this->ajaxReturn($data, 'LUA'); // 暂时用这个函数代替一下
            break;
          default:
            dump($data);
            break;
        }
        die('');
      }

    function payTypeArray(){
        return array(
            1 =>'MbAli',
            2 =>'MbWx',
            3 =>'MbYb',
            4 =>'WebAli',
            5 =>'WebWx',
            6 =>'WebYb',
            7 =>'WapAli',
        );
    }
}
