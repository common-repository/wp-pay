
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝即时支付</title>
        <style type="text/css">
            .font_content{
                font-family:"宋体";
                font-size:14px;
                color:#FF6600;
				width:
            }
            .font_title{
                font-family:"宋体";
                font-size:16px;
                color:#FF0000;
                font-weight:bold;
            }
            table{
                border: 1px solid #CCCCCC;
            }
        </style></head>
    <body>
<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.2
 * 日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数AlipayFunction.logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 
 * TRADE_FINISHED(表示交易已经成功结束，为普通即时到帐的交易状态成功标识);
 * TRADE_SUCCESS(表示交易已经成功结束，为高级即时到帐的交易状态成功标识);
 */
 include($_SERVER['DOCUMENT_ROOT'] ."/wp-config.php");
$con = mysql_connect(constant("DB_HOST"),constant("DB_USER"),constant("DB_PASSWORD"));
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db(constant("DB_NAME"), $con);


require_once($_SERVER['DOCUMENT_ROOT'] ."/alipay/alipay.config.php");
require_once($_SERVER['DOCUMENT_ROOT'] ."/alipay/lib/alipay_notify.class.php");
?>


<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
    $out_trade_no	= $_GET['out_trade_no'];	//获取订单号
    $trade_no		= $_GET['trade_no'];		//获取支付宝交易号
    $total_fee		= $_GET['price'];			//获取总价格
    $id             =  $_GET['body'];
	$buyer_email    =  $_GET['buyer_email'];
    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理（可参考“集成教程”中“3.4返回数据处理”）
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
$jal_db_version = "1.0";
 global $wpdb;
   global $jal_db_version;

   $table_name = $wpdb->prefix . "users";
   
     

      $dingdan =$_GET['out_trade_no'];
      $name = $_GET['subject'];
	   $price = $_GET['total_fee'];
	    $email = $_GET['buyer_email'];

      $insert = "INSERT INTO " . $table_name .
            " (user_login, user_nicename, user_url,user_email) " .
            "VALUES ('" . $wpdb->escape($dingdan) . "','" . $wpdb->escape($name) . "','" . $wpdb->escape($price) . "','". $wpdb->escape($email) ."')";

      $results = $wpdb->query( $insert );
 
      add_option("jal_db_version", $jal_db_version);

$meta_key = 'description';
$down=$wpdb->get_var($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE  post_id = '".$id."' AND meta_key = %s", $meta_key));


	



	
	  
	   
		
		
	

       echo" <table align='center' width='400' cellpadding='5'cellspacing='0'>
            <tr>
                <td align='center' class='font_title' colspan='2'>通知返回</td>
            </tr>
            <tr>
                <td class='font_content' align='right'>支付宝交易号：</td>
                <td class='font_content' align='left'> ".$_GET['trade_no']."</td>
            </tr>
            <tr>
                <td class='font_content' align='right'>订单号：</td>
                <td class='font_content' align='left'>" .$_GET['out_trade_no']."</td>
            </tr>
            <tr>
                <td class='font_content' align='right'>付款总金额：</td>
                <td class='font_content' align='left'>". $_GET['total_fee']."</td>
            </tr>
            <tr>
                <td class='font_content' align='right'>商品标题：</td>
                <td class='font_content' align='left'>".$_GET['subject']."</td>
            </tr>
           
                <td class='font_content' align='right'>买家账号：</td>
                <td class='font_content' align='left'>".$_GET['buyer_email']."</td>
            </tr>
            <tr>
                <td class='font_content' align='right'>交易状态：</td>
                <td class='font_content' align='left'>". $_GET['trade_status']."</td>
            </tr>
			 <tr>
                <td class='font_content' align='right'>商品下载：</td>
                <td class='font_conten' align='left'><a href='". $down."'target='_blank'>点击下载</a></td>
            </tr>

          
        </table>
	";
	
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的return_verify函数，比对sign和mysign的值是否相等，或者检查$veryfy_result有没有返回true
	
	echo "<br/>";





     echo" <table align='center' width='350' cellpadding='5'cellspacing='0'>
            <tr>
                <td align='center' class='font_title' colspan='2'>购买失败，请联系作者</td>
            </tr>
            
        </table>
	";
      
	
}
?>


    </body>
</html>