<?php 
session_start();
$userid=$_SESSION['userid'];
 
//先得到加入购物车表里面的数据$data 包含cover title price num
 try{
	$pdo=new PDO("mysql:host=localhost;dbname=yonghu","root","yilushen",array(PDO::    ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$pdo->query("set names utf8");
	$sql="select p.id,p.cover,p.title,p.price,c.num from shop_product p right join 					         shop_cart c on p.id=c.productid where c.userid=?";
	$stmt=$pdo->prepare($sql);
	$stmt->execute(array($userid));
	$data=$stmt->fetchAll(PDO::FETCH_ASSOC);
	
	
	 
 }catch(PDOException $e){
	echo $e->getMessage();
 }  
 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>购物车</title>
<script src="jquery-3.1.1.js"></script>
<style>

 table{width:80%;border:1px solid #ccc;margin:50px auto;border-collapse:collapse;border-spacing:0;}
 #t1{font-size:20px;font-weight:bolder;height:40px;background:#CCF;}
 #t1 td{border-bottom:1px solid #ccc;}
 
 #t2{height:60px;}
 #t2 th{border-bottom:1px solid #ccc;}
 
 .t3{text-align:center;}
 
 #t4{font-size:20px;font-weight:bolder;height:40px;}
 #t4 td{border-top:1px solid #ccc;}
 a{color:red;}
 input{width:40px;height:24px;text-align:center}
 #btn{height:30px;border:none;background:#CCF;color:#330;font-weight:bold;}
</style>
</head>

<body>

	
    <table>
    	<tr id="t1">
        	<td colspan=6>商品列表</td>
        </tr>
        <tr id="t2">
        	<th>商品图片</th>
            <th>商品名称</th>
            <th>价格</th>
            <th>购买数量</th>
            <th>小计</th>
            <th>操作</th>
        </tr>
 

<?php 
//得到数据以后写入表格
$total=0;
foreach($data as $product){
?>
  
		<tr class="t3" id="tr-<?php echo $product['id']?>">
            <td><img src="<?php echo $product['cover']?>" /></td>
            <td><?php echo $product['title']?></td>
            <td><span id="danjia-<?php echo $product['id']?>"><?php echo $product['price']?></span></td>
            <td><input type="text" value="<?php echo $product['num']?>" onblur="		                changNum(<?php echo $product['id'];?>,this.value)" id="num-<?php echo $product['id']?>"/>
            </td>
            <td><span class="count" id="xiaoji-<?php echo $product['id']?>"><?php echo $product['num']*$product['price']?></span> 元</td>
            <td><a href="javascript:delP(<?php echo $product['id'] ?>)">删除</a></td>
        </tr>
        
<?php
 $total+=$product['num']*$product['price'];
} 
?>
		<tr id="t4">
        	<td id="oTd" colspan=5> 总价￥<span id="oTat"><?php echo $total;?></span>元</td>
            <td><a href="javascript:clearCart()"><button id="btn">清空购物车</button></a></td>
        </tr>
    </table>
    
<script>
	function changNum(productid,num){//当鼠标离开时，修改shop_cart数据表中的购买数量
		
		var url="changNum.php";
		var data={"productid":productid,"num":num};
		
		var success=function(response){
			
			if(response.errno==0){
				var price=$("#num-"+productid).val()*$("#danjia-"+productid).html();
				$("#xiaoji-"+productid).html(price);
				//alert($(".count").eq(0).html());
				var total=0;
				for(var i=0;i<$(".count").length;i++){
					
					//alert($(".count").eq(0).html());
					total+=parseInt($(".count").eq(i).html());
				}
				$("#oTd").html("总价￥"+total+"元");

			}else{
				
			}
		}
		$.post(url,data,success,"json");
	}
	
	
	
	function delP(productid){//当点击删除的时候把shop_cart数据表里的数据删除
		var url="delProduct.php";
		var data={"productid":productid};

		var success=function(response){
		
			if(response.errno==0){
				$("#tr-"+productid).remove();
			}else{
				
			}
		}
		$.post(url,data,success,"json");
	}
	
	function clearCart(){
		var url="clear.php";
		var success=function(response){
		
			if(response.errno==0){
				$(".t3").remove();
				$("#oTd").html("总价￥0元");
			}else{
				
			}
		}
		$.post(url,success,"json");
	}
</script>
    

</body>
</html>