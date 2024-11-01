
<style>


.wide { width:100%; float:left; }
.wide h2, .thin h2 { font-size:20px; line-height:24px; margin-bottom:20px; color:#fff;border-bottom:1px dashed #729e9b; padding-bottom:10px; }
#contact-form .row { width:100%; margin-bottom:20px; overflow:hidden; }
#contact-form .textfield { width:272px; float:left; }
#contact-form .textarea { width:100%; float:left; margin-bottom:20px; }
#contact-form .textfield.right { float:right; }
#contact-form .textfield input.text {-moz-border-radius: 4px; border-radius: 4px; width:92%; padding:8px; background-color:#eee; background-position: center; border:1px dashed #cbc8be; font-size:16px; font-family: "Book Antiqua", Georgia, serif; color:#4a3d2e; }
#contact-form textarea {-moz-border-radius: 4px; border-radius: 4px; width:98%; padding:8px; background-color:#ccc; background-position: center; border:1px dashed #cbc8be; font-size:16px; font-family: "Book Antiqua", Georgia, serif; color:#4a3d2e; height:100px; }
#contact-form textarea:focus, #contact-form input.text:focus { border:1px dashed #b1ad9e; }
#contact-form label { color:#577a77; font-style: italic; margin-bottom:5px; width:100%; display:block; }
input.submit {-moz-border-radius: 4px; border-radius: 4px; float:right; border:1px dashed #729e9b; padding:8px; background-color:#09b; background-position: center; font-family:  Georgia, serif; color:#fff; font-size:20px; width:272px; }

input.submit:focus { padding:3px 8px 7px 8px; }
.required { color:#fffff; }
#contact-form .block-header, #contact-details .block-header {
	margin-bottom:20px;background-color:#09c; 
}
#contact-details li { height:50px; background-repeat:no-repeat; background-position:right top; border-bottom: 1px dashed #CBC8BE;padding-bottom:10px; margin-bottom:10px; }

/* contact page */



</style> 
 <SCRIPT language="javascript" src="<?php echo 'http://'.$_SERVER['HTTP_HOST']?>/alipay/pay.js" type="text/javascript"></SCRIPT>
 

<?php $custom = get_post_custom($post->ID);
$et_price = isset($custom["price"][0]) ? $custom["price"][0] : '';
$et_pid = isset($custom["pid"][0]) ? $custom["pid"][0] : '';
$et_description = isset($custom["description"][0]) ? $custom["description"][0] : '';
$et_band =  isset($custom["et_band"][0]) ? $custom["et_band"][0] : '';
$et_name = isset($custom["name"][0]) ? $custom["name"][0] : '';

 ?>

<?php if ($et_band <> '') { ?>  

<div class="wide" id="contact-form"> 
       
      <div class="block-header"><h2>购买流程：填写表单→付款→付款完成→等待跳转到下载页</h2></div> 
<form class="formBuilderForm" name=alipayment onSubmit="return CheckForm();" action="<?php echo 'http://'.$_SERVER['HTTP_HOST']?>/alipay/alipayto.php" method=post target="_blank"> 
    
    <div class="row"> 
      <div class="textfield"> 
        <label for="name">Commodity Name:</label> 
        <input class="text" id="name" name="name"value="<?php echo($et_name); ?>"disabled> 
      </div> 
       <div class="textfield right"> 
	    <label for="price">Commodity Price:</label> 
       <input class="text"  name="price"value="￥<?php echo($et_price); ?>"disabled> 
        
      </div> 
    </div> 
    <div class="row"> 
      <div class="textfield"> 
        <label for="website">Your Alipay Email</span>:</label> 
        <input class="text" id="website" name="buyer_email"value=""> 
      </div> 
      <div class="textfield right"> 
        <label for="price">　</label> 
        <input type="submit" value="用支付宝购买" class="submit"> 
      </div> 
    </div> 
    
    <div class="row"> 
	 
    </div> 
    <div> 
    <input type="hidden" name="subject" value="<?php echo($et_name); ?>"> 
	<input type="hidden"name="body" value="<?php echo($et_pid); ?>"> 
    <input type="hidden" name="total_fee" value="<?php echo($et_price); ?>"> 
    </div> 
</form> 

</div>


 <?php }; ?> 

