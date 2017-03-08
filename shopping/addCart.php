<?php
//接收数据$userid,$productid,$num
session_start();
$userid=$_SESSION['userid'];
$productid=intval($_POST["productid"]);
$num=intval($_POST["num"]);

try{
	$pdo=new PDO("mysql:host=localhost;dbname=yonghu","root","yilushen",array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));//连接数据库
	$pdo->query("set names utf8");
	$sql="select price from shop_product where id=?";
	$stmt=$pdo->prepare($sql);
	$stmt->execute(array($productid));
	$data=$stmt->fetch(PDO::FETCH_ASSOC);
	$price=$data["price"];//获取数据$price
	$createTime=time();//获取数据$createTime
	
	//把接收到的和获取到的数据写进数据库
	$sql="select * from shop_cart where productid=? and userid=?";
	$stmt=$pdo->prepare($sql);
	$stmt->execute(array($productid,$userid));
	$data=$stmt->fetch(PDO::FETCH_ASSOC);
	
	if($data){
		$sql="update shop_cart set num=num+? where productid=? and userid=?";
		$parameter=array($num,$productid,$userid);
	}else{
		$sql="insert into shop_cart(productid,userid,num,price,createtime) values(?,?,?,?,?)";
		$parameter=array($productid,$userid,$num,$price,$createTime);
	}
	
	
	$stmt=$pdo->prepare($sql);
	$stmt->execute($parameter);
	$rows=$stmt->rowCount();
	
}catch(PDOException $e){
	
	echo $e->getMessage();
}

if($rows){
	$response=array("errno"=>0,"errmsg"=>"success","data"=>true);
}else{
	$response=array("errno"=>-1,"errmsg"=>"fail","data"=>false);
}
echo json_encode($response);//解析成json格式

















?>