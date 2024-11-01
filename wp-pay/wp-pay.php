<?php 
/*
Plugin Name:WP-pay
Plugin URI: http://www.pakelab.com/
Description: 这是一款集成支付宝即时到账接口的插件,她可以实现即时到账，自动发货，订单管理等功能。
Version: 1.0
Author: 帕克实验室
Author URI:http://www.pakelab.com/
*/
?>
<?php


function admin_init(){
	add_meta_box("et_post_meta", "商品属性设置", "et_post_meta", "post", "normal", "high");
	add_meta_box("et_post_meta", "商品属性设置", "et_post_meta", "page", "normal", "high");
}
add_action("admin_init", "admin_init");

function et_post_meta($callback_args) {
	global $post;
	$custom = get_post_custom($post->ID);
	$price = isset($custom["price"][0]) ? $custom["price"][0] : '';
	$pid = isset($custom["pid"][0]) ? $custom["pid"][0] : '';
	$description =  isset($custom["description"][0]) ? $custom["description"][0] : '';
    $et_band =  isset($custom["et_band"][0]) ? $custom["et_band"][0] : '';
	$name = isset($custom["name"][0]) ? $custom["name"][0] : '';
	
	?>
	
	
	<p style="margin-bottom: 22px;">
		<label for="et_price">商品价格：</label>
		<input name="et_price"  type="text" value="<?php echo $price; ?>" size="20" />
		<small>(如： 29.99)</small>
	</p>
	<p style="margin-bottom: 22px;">
		
		<input name="et_pid"   type="hidden" value="<?php echo $post->ID; ?>" size="20" />
		
	</p>
	<p style="margin-bottom: 22px;">
		<label for="et_name">商品名称：</label>
		<input name="et_name"  type="text" value="<?php echo $name; ?>" size="20" />
		<small>(如： UFO-CMS主题)</small>
	</p>
	<p style="margin-bottom: 22px;">
		<label for="et_description">商品下载地址:</label><br/>
		<textarea  name="et_description" style="width: 90%"><?php echo $description; ?></textarea><br/>
		<small>(下载地址用户购买后可见,如：http://www.pakelab.com/123.zip)</small>
	</p>
	

	
	
	<p style="margin-bottom: 22px;">
		<?php $bands = array('on' => '开', );
		$bands = apply_filters('et_bands',$bands); ?>
		
		<label for="et_band">开关设置</label>
		<select id="et_band" name="et_band">
			<option value="">关</option>
			<?php foreach ($bands as $key => $value) { ?>
				<option <?php if (htmlspecialchars($et_band) == $key) echo('selected="selected"')?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
			<?php }; ?>
		</select>
	</p>
	<?php
}

function save_details($post_id){
	global $post;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
		
	if (isset($_POST["et_price"]) && $_POST["et_price"] <> '') update_post_meta($post->ID, "price", $_POST["et_price"]);
	if (isset($_POST["et_pid"]) && $_POST["et_pid"] <> '') update_post_meta($post->ID, "pid", $_POST["et_pid"]);
	if (isset($_POST["et_description"]) && $_POST["et_description"] <> '') update_post_meta($post->ID, "description", $_POST["et_description"]);
	if (isset($_POST["et_band"])) update_post_meta($post->ID, "et_band", $_POST["et_band"]);
	if (isset($_POST["et_name"]) && $_POST["et_name"] <> '') update_post_meta($post->ID, "name", $_POST["et_name"]);
	
}
add_action('save_post', 'save_details');







add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
 add_menu_page('支付宝配置', '支付宝配置', 8,'01','alipay_config');
 add_submenu_page('01','订单管理', '订单管理', 8, '02','alipay_Product');
}

function alipay_config() {
	?>
	 <div class="wrap" style="margin-left:100px;">
     <br><h2><img src="images/wp-logo-vs.png" style="vertical-align:text-bottom"> 插件配置页面</h2><br>
     <?php 

		
	 if ($_REQUEST[alipay]=="true")
	 {
      if ($_REQUEST[js_partner]=="" || $_REQUEST[js_key]=="" || $_REQUEST[js_seller_email]=="")
	  {
		echo "合作者身份ID、安全效验码、邮箱不能为空";  
	  }
	  else
	  {
	   if (get_option('glacier_db_version')=="") 
	   {
	   add_option('js_partner',$_REQUEST[js_partner],'','yes');
	   add_option('js_key',$_REQUEST[js_key],'','yes');
	   add_option('js_seller_email',$_REQUEST[js_seller_email],'','yes');
	   
	  
	   

	   echo "初次配置成功";
	   echo $myfile;
	   }
	   else
	   {
	   	   update_option('js_partner',$_REQUEST[js_partner]);
		   update_option('js_key',$_REQUEST[js_key]);
		   update_option('js_seller_email',$_REQUEST[js_seller_email]);

		 
	   echo "配置更改成功";
	   }
	  }
	 }
	 else
	 {
	 ?>
  <form id="form1" name="form1" method="post" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];?>&alipay=true ">
    <p>用户(partner ID):
  <input name="js_partner" type="text" id="js-partner" size="50" /> 
  <font color="#FF0000"> * </font> <font color="#CCCCCC">合作身份者id，以2088开头的16位纯数字</font><br><br>
      安全效验码 (Key):
      <input name="js_key" type="text" id="js-key" size="50" /> 
      <font color="#FF0000"> * </font> <font color="#CCCCCC">安全检验码，以数字和字母组成的32位字符</font><br><br>
      支付宝所使用邮箱:
      <input name="js_seller_email" type="text" id="js-seller_email" size="50" /> 
    <font color="#FF0000"> * </font> <font color="#CCCCCC">签约支付宝账号或卖家支付宝帐户</font></p>
      <br>
      <br>
      <input type="submit" name="button" id="button" value="保存设置" />
    </p>
  </form>
  <br><br><font color="#FF0000">插件作者:<a href="http://www.pakelab.com" target="_blank">帕克实验室</a></font><br><br>
  <font color="#666666"> * 提示：如何获取安全校验码和合作身份者id<br>
   * 1.用您的签约支付宝账号登录支付宝网站(www.alipay.com)<br>
   * 2.点击"商家服务"(https://b.alipay.com/order/myorder.htm)<br>
   * 3.点击"查询合作者身份(pid)"、"查询安全校验码(key)"<br>
   <br>
   </font>
  <?php }?>
</div>
	<?php
}

function alipay_Product(){

?>
<div style="width:800px; height:20px;border:1px solid #cccccc; background:#eeeeee">
    <table width="100%">
      <tr>
      
        <td width="5%">ID</td>
        <td width="20%">商品名称</td>
        <td width="15%">商品价格</td>
        <td width="30%">用户账号</td>
        <td width="25%">订单号</td>
      
      
		</tr>
    </table>
  </div>
<?php 
			 global $wpdb; $table_name = $wpdb->prefix; 
	   $results = mysql_query("select * from ".$table_name."users");

	
	  
	   
		
		?>
		<?php while($row = mysql_fetch_array($results)) {?>
  <table width="100%">
      <tr>
        <td width="5%"><?php echo $row[ID];?></td>
        <td width="20%"><?php echo $row[user_nicename];?></td>
		<td width="10%"><?php echo $row[user_url];?></td>
        <td width="30%"><?php echo $row[user_email];?></td>
        <td width="25%"><?php echo $row[user_login];?></td>
		</tr>
		</table>





<?php } ?>

		




<?php 

			
		
		
		
		}


?>
