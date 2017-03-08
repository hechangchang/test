<?php 
session_start();
$_SESSION['productid']=1;
$_SESSION['userid']=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品页面</title>
<style>
body{line-height:2em}
div{float:left;border:1px solid #ccc;margin-right:20px;height:440px}
#div2{padding-left:20px}
input{width:40px;height:30px;text-align:center}
#button1{height:40px;border:none;background:#F9F;color:#c00;font-size:16px}
#button2{height:40px;border:none;background:#C00;color:#fff;font-size:16px}
span{border:1px solid red;display:inline-block;width:60px;height:50px;line-height:50px;text-align:center}
</style>
<script src="jquery-3.1.1.js"></script>
</head>

<body>
<div>
<img src="01.jpg"/>
</div>

<div id="div2">
<h3>SUPOR/苏泊尔 CFXB40HC807-120智能球釜IH电饭煲3-4人正品4L</h3>
<p>价格:￥269</p>
<p>颜色：<span>咖啡色</span><br /><br />
数量：<input type="text" name="number" value="1" id="number"/><br /><br />
<button id="button1">立即购买</button> <a href="javascript:addCart(<?php echo $_SESSION['productid'];?>)"><button id="button2">加入购物车</button></a>
</div>
<script>

	function addCart(productid){
		
		var url="addCart.php";
		var data={"productid":productid,"num":parseInt($("#number").val())};
		//alert(productid);
		var success=function(response){
			//alert(response);
			if(response.errno==0){
				alert("成功加入购物车");
			}else{
				alert("加入购物车失败");	
			}
		}
		$.post(url,data,success,"json");	
	}

	
	
	
	

	
	
	
	


</script>
</body>
</html>
