<?php
include($_SERVER['DOCUMENT_ROOT'] ."/wp-config.php");
$con = mysql_connect(constant("DB_HOST"),constant("DB_USER"),constant("DB_PASSWORD"));
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db(constant("DB_NAME"), $con);

/*
	*功能：设置帐户有关信息及返回路径（基础配置页面）
	*版本：3.1
	*日期：2010-10-29
	'说明：
	'以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/

/** 提示：如何获取安全校验码和合作身份者ID
1.访问支付宝商户服务中心(b.alipay.com)，然后用您的签约支付宝账号登陆.
2.访问“技术服务”→“下载技术集成文档”（https://b.alipay.com/support/helperApply.htm?action=selfIntegration）
3.在“自助集成帮助”中，点击“合作者身份(Partner ID)查询”、“安全校验码(Key)查询”

安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
解决方法：
1、检查浏览器配置，不让浏览器做弹框屏蔽设置
2、更换浏览器或电脑，重新登录查询。
*/

//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，以2088开头的16位纯数字
$result = mysql_query("SELECT * FROM ".$table_prefix."options where option_name='js_partner'");
$row = mysql_fetch_array($result);
$aliapy_config['partner'] 		= $row[option_value];

//安全检验码，以数字和字母组成的32位字符
$result = mysql_query("SELECT * FROM ".$table_prefix."options where option_name='js_key'");
$row = mysql_fetch_array($result);
$aliapy_config['key']   			= $row[option_value];

//签约支付宝账号或卖家支付宝帐户
$result = mysql_query("SELECT * FROM ".$table_prefix."options where option_name='js_seller_email'");
$row = mysql_fetch_array($result);
$aliapy_config['seller_email']	= $row[option_value];

//return_url的域名不能写成http://localhost/js_php_utf8/return_url.php ，否则会导致return_url执行无效
$aliapy_config['return_url'] 	= "http://".$_SERVER['HTTP_HOST']."/alipay/return_url.php";
//交易过程中服务器通知的页面 要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$aliapy_config['notify_url'] 		= "http://".$_SERVER['HTTP_HOST']."/alipay/notify_url.php";






//签名方式 不需修改
$aliapy_config['sign_type'] 		= "MD5";

//字符编码格式 目前支持 GBK 或 utf-8
$aliapy_config['input_charset']	= "utf-8";

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$aliapy_config['transport']		= "http";

?>