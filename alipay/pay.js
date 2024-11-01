
function CheckForm()
{
	if (document.alipayment.subject.value.length == 0) {
		alert("请输入商品名称.");
		document.alipayment.subject.focus();
		return false;
	}
	
	if (document.alipayment.buyer_email.value.length == 0) {
		alert("请输入Email.");
		document.alipayment.buyer_email.focus();
		return false;
	}
	
	
	if (document.alipayment.total_fee.value.length == 0) {
		alert("请输入付款金额.");
		document.alipayment.total_fee.focus();
		return false;
	}
	var reg	= new RegExp(/^\d*\.?\d{0,2}$/);
	if (! reg.test(document.alipayment.total_fee.value))
	{
        alert("请正确输入付款金额");
		document.alipayment.total_fee.focus();
		return false;
	}
	if (Number(document.alipayment.total_fee.value) < 0.01) {
		alert("付款金额金额最小是1.00.");
		document.alipayment.total_fee.focus();
		return false;
	}
	function getStrLength(value){
        return value.replace(/[^\x00-\xFF]/g,'**').length;
    }
    if(getStrLength(document.alipayment.alibody.value) > 200){
        alert("备注过长！请在100个汉字以内");
        document.alipayment.alibody.focus();
        return false;
    }
    if(getStrLength(document.alipayment.subject.value) > 256){
        alert("标题过长！请在128个汉字以内");
        document.alipayment.subject.focus();
        return false;
    }

	document.aplipayment.alibody.value = document.aplipayment.alibody.value.replace(/\n/g,'');
}  

