<?php 
//接收数据$userid,$productid
session_start();

$userid=$_SESSION['userid'];
$productid=intval($_POST["productid"]);

try{
	$pdo=new PDO("mysql:host=localhost;dbname=yonghu","root","yilushen",array(PDO::                  ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));//连接数据库
	$pdo->query("set names utf8");
	$sql="delete from shop_cart where productid=? and userid=?";
	$stmt=$pdo->prepare($sql);
	$stmt->execute(array($productid,$userid));
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