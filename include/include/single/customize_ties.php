<?
if(empty($_POST['ip'])){
	$_POST['ip'] = $_SERVER['REMOTE_ADDR'];
}
require('./phpip2country.class.php');

include('../../connect.php');

/*RESELLER*/
$user_id = $_POST["user_id"];
$user_name = $_POST["user_name"];

$sql0 =	" SELECT * FROM admin_reseller WHERE reseller_company = '$user_name' AND reseller_type = 'Admin' ";
$query0 = mysql_db_query($dbname, $sql0) or die("Can't Query0");
$row0 = mysql_fetch_array($query0);
$id_user = $row0["id"];
$type_user = $row0["type"];
$brand_user = $row0["brand"];
$company_user = $row0["reseller_company"];

$order_product = ties;
$ties_orderid = $_POST["ties_orderid"];

if ($ties_orderid != "") {
	
	$order_id = $ties_orderid;
	
} else if ($ties_orderid == "") {
	
	$sql1 =	" SELECT MAX(order_id) FROM customize_order";
	$query1 = mysql_db_query($dbname, $sql1) or die("Can't Query1");
	$row1 = mysql_fetch_array($query1);
	$order_id = $row1[0] + 1 ;
	
}

$sql2 =	" SELECT MAX(id) FROM customize_checkout ";
$query2 = mysql_db_query($dbname, $sql2) or die("Can't Query2");
$row2 = mysql_fetch_array($query2);
$id_customize_checkout = $row2[0] + 1 ;

$sql3 = " SELECT MAX(id) FROM customize_order ";
$query3 = mysql_db_query($dbname, $sql3) or die("Can't Query3");
$row3 = mysql_fetch_array($query3);
$id_order = $row3[0] + 1 ;

$sql4 =	" SELECT MAX(product_id) FROM customize_order";
$query4 = mysql_db_query($dbname, $sql4) or die("Can't Query4");
$row4 = mysql_fetch_array($query4);
$product_id = $row4[0] + 1 ;

$sql5 = " SELECT MAX(id) FROM customize_ties_design ";
$query5 = mysql_db_query($dbname, $sql5) or die("Can't Query5");
$row5 = mysql_fetch_array($query5);
$id_ties = $row5[0] + 1 ;

/*FABRIC*/
$ties_fabric_no = $_POST["ties_fabric_no"];

$sql6 =	" SELECT * FROM admin_fabrics_ties WHERE fabricno = '$ties_fabric_no' ";
$query6 = mysql_db_query($dbname, $sql6) or die("Can't Query6");
$row6 = mysql_fetch_array($query6);
$fabrics_type = $row6["type"];
$fabrics_brand = $row6["brand"];

if ($row6["type"] != '') {

$sql01 = " SELECT `fabrictype_".$id_user."` FROM admin_fabrictype WHERE fabrictype_name = '$fabrics_type' AND fabrictype_product = 'Ties' ";
$query01 = mysql_db_query($dbname, $sql01) or die("Can't Query01");
$row01 = mysql_fetch_array($query01);
$ties_price = $row01["0"];

} else if ($row6["brand"] != '') {
	
$sql02 = " SELECT `fabricbrand_".$id_user."` FROM admin_fabricbrand WHERE fabricbrand_name = '$fabrics_brand' AND fabricbrand_product = 'Ties' ";
$query02 = mysql_db_query($dbname, $sql02) or die("Can't Query02");
$row02 = mysql_fetch_array($query02);	
$ties_price = $row02["0"];
	
}

/*ECT*/
$ties_date = date("m/d/Y");
$ties_time = date("H:i:s");
$ties_ip = $_POST['ip'];
$ties_status = T;

$sql7 =	" INSERT INTO customize_order (id, order_id, product_id, order_reseller, order_price, order_product, order_fabric_no, order_date, order_time, order_ip, order_status) VALUES ('$id_order', '$order_id', '$product_id', '$company_user', '$ties_price', '$order_product', '$ties_fabric_no', '$ties_date', '$ties_time', '$ties_ip', '$ties_status') ";
$query7 = mysql_query($sql7) or die("Can't Query7");

$sql8 = " INSERT INTO customize_ties_design (id, order_id, product_id, ties_fabric_no, ties_date, ties_time, ties_ip, ties_status)  VALUES ('$id_ties', '$order_id', '$product_id', '$ties_fabric_no', '$ties_date', '$ties_time', '$ties_ip', '$ties_status') ";
$query8 = mysql_query($sql8) or die("Can't Query8");

if ($ties_orderid != "") {
	
	$sql9 = " UPDATE customize_checkout SET checkout_company = '$company_user', checkout_date = '$ties_date', checkout_time = '$ties_time', checkout_ip = '$ties_ip', checkout_status = '$ties_status' WHERE checkout_orderid = '$order_id' ";
	$query9 = mysql_query($sql9) or die("Can't Query9");
	
} else if ($ties_orderid == "") {
	
	$sql9 = " INSERT INTO customize_checkout (id, checkout_company, checkout_orderid, checkout_date, checkout_time, checkout_ip, checkout_status) VALUES ('$id_customize_checkout', '$company_user', '$order_id', '$ties_date', '$ties_time', '$ties_ip', '$ties_status') ";
	$query9 = mysql_query($sql9) or die("Can't Query9");
	
}

if($query9) {
	
	echo " <script language='javascript'> window.location='../../../cart/single/index.php?orderid=".$order_id."'; </script> ";
	
}

mysql_close();
?>