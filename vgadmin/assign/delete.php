<?
include('../../connect.php');

$assign_status = F;

for($i=0;$i<count($_POST["chkDel"]);$i++)
	{
		if($_POST["chkDel"][$i] != "")
		{
			$strSQL = " UPDATE admin_category SET category_status = '$assign_status' ";
			$strSQL .=" WHERE id = '".$_POST["chkDel"][$i]."' ";
			$objQuery = mysql_query($strSQL);
		}
	}

	echo " <script language='javascript'> window.location='index.php'; </script> ";

mysql_close();
?>
