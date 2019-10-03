<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<?	
	include('../../connect.php');
	
	session_start();
	
	$user = $_COOKIE['user'];

	$sql_user =	" SELECT * FROM admin WHERE admin_username = '$user' ";
	$query_user = mysql_query($sql_user) or die("Can't Query");
	$row_user = mysql_fetch_array($query_user);
	$name = $row_user['admin_username'];

	if($user == ""){ header("HTTP/1.1 301 Moved Permanently"); header('Location: ../'); exit(); }
	else if($user != $name){ header("HTTP/1.1 301 Moved Permanently"); header('Location: ../'); exit(); }
	
	$report = $_POST["report"];
	$reseller = $_POST["reseller"];
	$start_date = $_POST["start_date"];
	$end_date = $_POST["end_date"];
?>
<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>
<meta charset="utf-8">
<title>RESELLER ONLINE | Admin</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--begin::Base Styles -->
<link href="https://fonts.googleapis.com/css?family=Adamina|Roboto&display=swap" rel="stylesheet">
<link href="../css/vendors.bundle.css" rel="stylesheet" type="text/css">
<link href="../css/style.bundle.css" rel="stylesheet" type="text/css">
<link href="../css/datatables.bundle.css" rel="stylesheet" type="text/css">
<!--end::Base Styles -->
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
<style type="text/css">
#printable {
	display: block;
}

@media print {
#non-printable {
	display: none;
}
#printable {
	display: block;
}
}
</style>
<link rel="shortcut icon" href="../images/favicon.ico">
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<?
	function DateEng($strDate)
	{
		$strYear = date("Y",strtotime($strDate));
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		$strMonthEng=$strMonthCut[$strMonth];
		return "$strDay $strMonthEng $strYear";
	}
?>
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page"> 
  <!-- BEGIN: Header -->
  <header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
      <div class="m-stack m-stack--ver m-stack--desktop"> 
        <!-- BEGIN: Brand -->
        <div class="m-stack__item m-brand m-brand--skin-dark">
          <div class="m-stack m-stack--ver m-stack--general">
            <div class="m-stack__item m-stack__item--middle m-brand__tools"> 
              <!-- BEGIN: Left Aside Minimize Toggle --> 
              <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block"> <span></span> </a> 
              <!-- END --> 
              <!-- BEGIN: Responsive Aside Left Menu Toggler --> 
              <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block"> <span></span> </a> 
              <!-- END --> 
              <!-- BEGIN: Responsive Header Menu Toggler --> 
              <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block"> <span></span> </a> 
              <!-- END --> 
              <!-- BEGIN: Topbar Toggler --> 
              <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block"> <i class="flaticon-more"></i> </a> 
              <!-- BEGIN: Topbar Toggler --> 
            </div>
          </div>
        </div>
        <!-- END: Brand --> 
        <!-- BEGIN: Topbar -->
        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
          <div class="m-stack__item m-topbar__nav-wrapper">
            <ul class="m-topbar__nav m-nav m-nav--inline">
              <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click"> <a href="#" class="m-nav__link m-dropdown__toggle"> <span class="m-topbar__userpic" style="font-family: 'Roboto', sans-serif;"> <img src="../images/icon.png" class="m--img-rounded m--marginless m--img-centered"> </span> <span class="m-topbar__username m--hide">
                <?=$row_user['admin_firstname'];?>
                </span> </a>
                <div class="m-dropdown__wrapper"> <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                  <div class="m-dropdown__inner">
                    <div class="m-dropdown__header m--align-center">
                      <div class="m-card-user m-card-user--skin-dark">
                        <div class="m-card-user__pic"> <img src="../images/icon.png" class="m--img-rounded m--marginless"> </div>
                        <div class="m-card-user__details"> <span class="m-card-user__name m--font-weight-500" style="font-family: 'Roboto', sans-serif;">
                          <?=$row_user['admin_firstname'];?>
                          <?=$row_user['admin_lastname'];?>
                          </span> <a href="" class="m-card-user__email m--font-weight-300 m-link" style="font-family: 'Roboto', sans-serif;">
                          <?=$row_user['admin_email'];?>
                          </a> </div>
                      </div>
                    </div>
                    <div class="m-dropdown__body">
                      <div class="m-dropdown__content">
                        <ul class="m-nav m-nav--skin-light">
                          <li class="m-nav__section m--hide"> <span class="m-nav__section-text"> Section </span> </li>
                          <li class="m-nav__item"> <a href="" class="m-nav__link"> <span class="m-nav__link-text" style="font-family: 'Roboto', sans-serif;"> My Profile </span> </a> </li>
                          <li class="m-nav__item"> <a href="../logout/" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" style="font-family: 'Roboto', sans-serif;"> Logout </a> </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- END: Topbar --> 
        
      </div>
    </div>
  </header>
  <!-- END: Header --> 
  <!-- begin::Body -->
  <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body"> 
    <!-- BEGIN: Left Aside -->
    <? include('../header/index.php'); ?>
    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper"> 
      <!-- BEGIN: Subheader -->
      
      <div class="m-content">
        <div id="non-printable">
          <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption" align="center">
                  <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text" style="text-transform:uppercase;" style="font-family: 'Roboto', sans-serif;">
                    <strong> Categorywise Sales Report </strong>
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
              <div id="non-printable">
                <div align="left">
                  <form class="m-form m-form--fit m-form--label-align-right" action="search.php" method="post">
                    <div class="col-md-12"> <br>
                      <br>
                      <label style="font-family: 'Roboto', sans-serif;"> Report For &nbsp;&nbsp;&nbsp;&nbsp; </label>
                      <label style="font-family: 'Roboto', sans-serif;">
                        <select class="form-control m-input" name="report" id="report">
                          <option value="<?=$report?>">
                          <?=$report?>
                          </option>
                          <option value=""> All </option>
                          <option value="Jacket"> Jacket </option>
                          <option value="Jeans"> Jeans </option>
                          <option value="Overcoat"> Overcoat </option>
                          <option value="Pants"> Pants </option>
                          <option value="Shirt"> Shirt </option>
                          <option value="Suits"> Suits </option>
                          <option value="Suits with Vest"> Suits with Vest </option>
                          <option value="Ties"> Ties </option>
                          <option value="Tuxedo Jacket"> Tuxedo Jacket </option>
                          <option value="Tuxedo Suits"> Tuxedo Suits </option>
                          <option value="Tuxedo with Vest"> Tuxedo with Vest </option>
                          <option value="Vest"> Vest </option>
                        </select>
                      </label>
                      <label style="font-family: 'Roboto', sans-serif;"> &nbsp;&nbsp;&nbsp;&nbsp; </label>
                      <label style="font-family: 'Roboto', sans-serif;"> Search by Reseller &nbsp;&nbsp;&nbsp;&nbsp; </label>
                      <label style="font-family: 'Roboto', sans-serif;">
                        <? if ($reseller != '') { ?>
                        <select class="form-control m-input" name="reseller" id="reseller">
                          <?
                      $strSQL = " SELECT * FROM admin_reseller WHERE reseller_status = 'T' AND reseller_type = 'Admin' ORDER BY id ASC ";
					  $objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
					  ?>
                          <option value="<?=$reseller?>">
                          <?=$reseller?>
                          </option>
                          <? while($objResult = mysql_fetch_array($objQuery)) { ?>
                          <option value="<?=$objResult["reseller_company"]?>">
                          <?=$objResult["reseller_company"]?>
                          </option>
                          <? } ?>
                          <option value=""> All </option>
                        </select>
                        <? } else if ($reseller == '') { ?>
                        <select class="form-control m-input" name="reseller" id="reseller">
                          <?
                      $strSQL = " SELECT * FROM admin_reseller WHERE reseller_status = 'T' AND reseller_type = 'Admin' ORDER BY id ASC ";
					  $objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
					  ?>
                          <? while($objResult = mysql_fetch_array($objQuery)) { ?>
                          <option value="<?=$objResult["reseller_company"]?>">
                          <?=$objResult["reseller_company"]?>
                          </option>
                          <? } ?>
                          <option value=""> All </option>
                        </select>
                        <? } ?>
                      </label>
                    </div>
                    <div class="col-md-12">
                      <label style="font-family: 'Roboto', sans-serif;"> Search by Date &nbsp;&nbsp;&nbsp;&nbsp; </label>
                      <label style="font-family: 'Roboto', sans-serif;">
                      <div class="input-daterange input-group" id="m_datepicker_5">
                        <div class="input-group-append"> <span class="input-group-text"> From </span> </div>
                        <input type="text" class="form-control m-input" name="start_date" id="start_date" value="<?=$start_date?>" readonly>
                        <div class="input-group-append"> <span class="input-group-text"> To </span> </div>
                        <input type="text" class="form-control" name="end_date" id="end_date" value="<?=$end_date?>" readonly>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" style="font-family: 'Roboto', sans-serif;" onclick="clearlist();"> Delete Date </button>
                        &nbsp;&nbsp;&nbsp;&nbsp; </div>
                      </label>
                      <label style="font-family: 'Roboto', sans-serif;"> <span class="m-form__help" style="font-family: 'Roboto', sans-serif;"> month/day/year </span> </label>
                    </div>
                    <div class="col-md-12">
                      <label style="font-family: 'Roboto', sans-serif;">
                        <button type="submit" class="btn btn-primary" style="font-family: 'Roboto', sans-serif;"> Search </button>
                      </label>
                    </div>
                  </form>
                </div>
              </div>
              <div id="non-printable" align="right">
                <label style="font-family: 'Roboto', sans-serif;">
                  <button type="button" class="btn btn-primary" style="font-family: 'Roboto', sans-serif;" onClick="window.print();"> Print & Save PDF </button>
                </label>
              </div>
              <div id="printable"><br>
                <? if ($report == "" && $reseller == "" && $start_date == "" && $end_date == "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong> ALL CATEGORY SALES </strong></div>
                <? } else if ($report != "" && $reseller != "" && $start_date != "" && $end_date != "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?=$reseller?>
                  -
                  <?=$report?>
                  <br>
                  <?
                  $strSQL01 = " SELECT * FROM admin_uploadlogo WHERE uploadlogo_status = 'T' AND uploadlogo_reseller = '$reseller' ";
				  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				  ?>
                  <img src="../../../images/logo/<?=$objResult01['uploadlogo_image'];?>?v=1001" width="250" height="55" onerror="this.src='../../../images/logo/0.jpg?v=1001';"> CATEGORY SALES </strong></div>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?
        		  $strDate = $start_date;
				  echo DateEng($strDate);
				  ?>
                  -
                  <?
        		  $strDate = $end_date;
				  echo DateEng($strDate);
				  ?>
                  </strong></div>
                <? } else if ($report == "" && $reseller == "" && $start_date != "" && $end_date != "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong> ALL CATEGORY SALES </strong></div>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?
        		  $strDate = $start_date;
				  echo DateEng($strDate);
				  ?>
                  -
                  <?
        		  $strDate = $end_date;
				  echo DateEng($strDate);
				  ?>
                  </strong></div>
                <? } else if ($report == "" && $reseller != "" && $start_date != "" && $end_date != "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?=$reseller?>
                  <br>
                  <?
                  $strSQL01 = " SELECT * FROM admin_uploadlogo WHERE uploadlogo_status = 'T' AND uploadlogo_reseller = '$reseller' ";
				  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				  ?>
                  <img src="../../../images/logo/<?=$objResult01['uploadlogo_image'];?>?v=1001" width="250" height="55" onerror="this.src='../../../images/logo/0.jpg?v=1001';"> </strong></div>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?
        		  $strDate = $start_date;
				  echo DateEng($strDate);
				  ?>
                  -
                  <?
        		  $strDate = $end_date;
				  echo DateEng($strDate);
				  ?>
                  </strong></div>
                <? } else if ($report != "" && $reseller == "" && $start_date != "" && $end_date != "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?=$report?>
                  CATEGORY SALES </strong></div>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?
        		  $strDate = $start_date;
				  echo DateEng($strDate);
				  ?>
                  -
                  <?
        		  $strDate = $end_date;
				  echo DateEng($strDate);
				  ?>
                  </strong></div>
                <? } else if ($report != "" && $reseller != "" && $start_date == "" && $end_date == "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?=$reseller?>
                  -
                  <?=$report?>
                  CATEGORY SALES <br>
                  <?
                  $strSQL01 = " SELECT * FROM admin_uploadlogo WHERE uploadlogo_status = 'T' AND uploadlogo_reseller = '$reseller' ";
				  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				  ?>
                  <img src="../../../images/logo/<?=$objResult01['uploadlogo_image'];?>?v=1001" width="250" height="55" onerror="this.src='../../../images/logo/0.jpg?v=1001';"></strong></div>
                <? } else if ($report != "" && $reseller == "" && $start_date == "" && $end_date == "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?=$report?>
                  CATEGORY SALES </strong></div>
                <? } else if ($report == "" && $reseller != "" && $start_date == "" && $end_date == "") { ?>
                <div style="font-family: 'Roboto', sans-serif; text-transform:uppercase; color:#000000; font-size:16px; letter-spacing:1px;" align="center"><strong>
                  <?=$reseller?>
                  <br>
                  <?
                  $strSQL01 = " SELECT * FROM admin_uploadlogo WHERE uploadlogo_status = 'T' AND uploadlogo_reseller = '$reseller' ";
				  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				  ?>
                  <img src="../../../images/logo/<?=$objResult01['uploadlogo_image'];?>?v=1001" width="250" height="55" onerror="this.src='../../../images/logo/0.jpg?v=1001';"> </strong></div>
                <? } ?>
                <br>
                <!--begin: Datatable -->
                <? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                <?
              $strSQL1 = " SELECT * FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";
			  $objQuery1 = mysql_query($strSQL1) or die ("Error Query [".$strSQL1."]");
		      ?>
                <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                <?
              $strSQL1 = " SELECT * FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";
			  $objQuery1 = mysql_query($strSQL1) or die ("Error Query [".$strSQL1."]");
		      ?>
                <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                <?
              $strSQL1 = " SELECT * FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";
			  $objQuery1 = mysql_query($strSQL1) or die ("Error Query [".$strSQL1."]");
		      ?>
                <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                <?
              $strSQL1 = " SELECT * FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";
			  $objQuery1 = mysql_query($strSQL1) or die ("Error Query [".$strSQL1."]");
		      ?>
                <? } ?>
                <table width="100%">
                  <thead>
                    <tr style="height:50px;">
                      <th width="20%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Date </strong></div></th>
                      <th width="10%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Reseller Name </strong></div></th>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Jacket </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Jeans </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Overcoat </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Pants </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Shirt </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Suits </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Suits with Vest </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Tuxedo Jacket </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Tuxedo Suits </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Tuxedo with Vest </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Vest </strong></div></th>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <th width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Ties </strong></div></th>
                      <? } ?>
                      <th width="10%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Amount </strong></div></th>
                    </tr>
                  </thead>
                  <tbody>
                    <? while($objResult1 = mysql_fetch_array($objQuery1)) { ?>
                    <? if ($report == 'Jacket' && $objResult1['checkout_jacket'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Jeans' && $objResult1['checkout_jeans'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Overcoat' && $objResult1['checkout_overcoat'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Pants' && $objResult1['checkout_pants'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Shirt' && $objResult1['checkout_shirt'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Suits' && $objResult1['checkout_suits'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Suits with Vest' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Tuxedo Jacket' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Tuxedo Suits' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Tuxedo with Vest' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Vest' && $objResult1['checkout_vest'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == 'Ties' && $objResult1['checkout_ties'] != '0') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? if ($report == '') { ?>
                    <tr style="height:50px;">
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?
        				  $strDate = $objResult1['checkout_date'];
						  echo DateEng($strDate);
						  ?>
                        </div></td>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1["checkout_company"]?>
                        </div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL2 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				$objResult2 = mysql_fetch_array($objQuery2);
				?>
                        <? if ($objResult2['order_id'] != '' && $objResult1['checkout_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jacket'];?>
                        </div>
                        <? } else if ($objResult2['order_id'] == '' || $objResult1['checkout_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL3 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'jeans' ORDER BY rand() LIMIT 1 ";	
				$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
				$objResult3 = mysql_fetch_array($objQuery3);
				?>
                        <? if ($objResult3['order_id'] != '' && $objResult1['checkout_jeans'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_jeans'];?>
                        </div>
                        <? } else if ($objResult3['order_id'] == '' || $objResult1['checkout_jeans'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL4 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'overcoat' ORDER BY rand() LIMIT 1 ";	
				$objQuery4 = mysql_query($strSQL4) or die ("Error Query [".$strSQL4."]");
				$objResult4 = mysql_fetch_array($objQuery4);
				?>
                        <? if ($objResult4['order_id'] != '' && $objResult1['checkout_overcoat'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_overcoat'];?>
                        </div>
                        <? } else if ($objResult4['order_id'] == '' || $objResult1['checkout_overcoat'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL5 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'pants' ORDER BY rand() LIMIT 1 ";	
				$objQuery5 = mysql_query($strSQL5) or die ("Error Query [".$strSQL5."]");
				$objResult5 = mysql_fetch_array($objQuery5);

				?>
                        <? if ($objResult5['order_id'] != '' && $objResult1['checkout_pants'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_pants'];?>
                        </div>
                        <? } else if ($objResult5['order_id'] == '' || $objResult1['checkout_pants'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL6 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'shirt' ORDER BY rand() LIMIT 1 ";	
				$objQuery6 = mysql_query($strSQL6) or die ("Error Query [".$strSQL6."]");
				$objResult6 = mysql_fetch_array($objQuery6);
				?>
                        <? if ($objResult6['order_id'] != '' && $objResult1['checkout_shirt'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_shirt'];?>
                        </div>
                        <? } else if ($objResult6['order_id'] == '' || $objResult1['checkout_shirt'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL7 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery7 = mysql_query($strSQL7) or die ("Error Query [".$strSQL7."]");
				$objResult7 = mysql_fetch_array($objQuery7);
				?>
                        <? if ($objResult7['order_id'] != '' && $objResult1['checkout_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits'];?>
                        </div>
                        <? } else if ($objResult7['order_id'] == '' || $objResult1['checkout_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL8 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'suits_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery8 = mysql_query($strSQL8) or die ("Error Query [".$strSQL8."]");
				$objResult8 = mysql_fetch_array($objQuery8);
				?>
                        <? if ($objResult8['order_id'] != '' && $objResult1['checkout_suits_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_suits_with_vest'];?>
                        </div>
                        <? } else if ($objResult8['order_id'] == '' || $objResult1['checkout_suits_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL9 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_jacket' ORDER BY rand() LIMIT 1 ";	
				$objQuery9 = mysql_query($strSQL9) or die ("Error Query [".$strSQL9."]");
				$objResult9 = mysql_fetch_array($objQuery9);
				?>
                        <? if ($objResult9['order_id'] != '' && $objResult1['checkout_tuxedo_jacket'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_jacket'];?>
                        </div>
                        <? } else if ($objResult9['order_id'] == '' || $objResult1['checkout_tuxedo_jacket'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL10 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_suits' ORDER BY rand() LIMIT 1 ";	
				$objQuery10 = mysql_query($strSQL10) or die ("Error Query [".$strSQL10."]");
				$objResult10 = mysql_fetch_array($objQuery10);
				?>
                        <? if ($objResult10['order_id'] != '' && $objResult1['checkout_tuxedo_suits'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_suits'];?>
                        </div>
                        <? } else if ($objResult10['order_id'] == '' || $objResult1['checkout_tuxedo_suits'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL11 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'tuxedo_with_vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery11 = mysql_query($strSQL11) or die ("Error Query [".$strSQL11."]");
				$objResult11 = mysql_fetch_array($objQuery11);
				?>
                        <? if ($objResult11['order_id'] != '' && $objResult1['checkout_tuxedo_with_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_tuxedo_with_vest'];?>
                        </div>
                        <? } else if ($objResult11['order_id'] == '' || $objResult1['checkout_tuxedo_with_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL12 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'vest' ORDER BY rand() LIMIT 1 ";	
				$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
				$objResult12 = mysql_fetch_array($objQuery12);
				?>
                        <? if ($objResult12['order_id'] != '' && $objResult1['checkout_vest'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_vest'];?>
                        </div>
                        <? } else if ($objResult12['order_id'] == '' || $objResult1['checkout_vest'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
                $strSQL13 = " SELECT DISTINCT(order_id) FROM customize_order WHERE order_id = ".$objResult1['checkout_orderid']." AND order_product = 'ties' ORDER BY rand() LIMIT 1 ";	
				$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
				$objResult13 = mysql_fetch_array($objQuery13);
				?>
                        <? if ($objResult13['order_id'] != '' && $objResult1['checkout_ties'] != '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult1['checkout_ties'];?>
                        </div>
                        <? } else if ($objResult13['order_id'] == '' || $objResult1['checkout_ties'] == '0') { ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#FF0000; font-size:10px; letter-spacing:1px;"> - </div>
                        <? } ?></td>
                      <? } ?>
                      <td style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><?
					$country = $objResult1['checkout_country'];
                    $sqlcountry1 =	" SELECT * FROM admin_country WHERE country_name = '$country' ";
					$querycountry1 = mysql_db_query($dbname, $sqlcountry1) or die("Can't QueryCountry1");
					$rowcountry1 = mysql_fetch_array($querycountry1);
					$currency = $rowcountry1['country_currency'];
					?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$currency?>
                          <?=$objResult1['checkout_price'];?>
                        </div></td>
                    </tr>
                    <? } ?>
                    <? } ?>
                    <tr style="height:50px;">
                      <td width="20%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"></td>
                      <td width="10%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;" align="center"><strong> Total </strong></div></td>
                      <? if ($report == 'Jacket' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_jacket)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Jeans' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jeans) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jeans) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jeans) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_jeans) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_jeans)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Overcoat' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_overcoat) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_overcoat) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_overcoat) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_overcoat) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_overcoat)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Pants' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_pants) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_pants) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_pants) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_pants) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_pants)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Shirt' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_shirt) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_shirt) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_shirt) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_shirt) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_shirt)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Suits' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_suits)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Suits with Vest' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_suits_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_suits_with_vest)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Jacket' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_jacket) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_tuxedo_jacket)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo Suits' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_suits) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_tuxedo_suits)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Tuxedo with Vest' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send'  ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_tuxedo_with_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_tuxedo_with_vest)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Vest' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_vest) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_vest)'];?>
                        </div></td>
                      <? } ?>
                      <? if ($report == 'Ties' || $report == '') { ?>
                      <td width="5%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"><? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_ties) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_ties) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_ties) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                        <?
                    $strSQL01 = " SELECT SUM(checkout_ties) FROM customize_checkout WHERE checkout_price !='' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ";	
					$objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
					$objResult01 = mysql_fetch_array($objQuery01);
					?>
                        <? } ?>
                        <div style="font-family: 'Roboto', sans-serif; color:#000000; font-size:10px; letter-spacing:1px;">
                          <?=$objResult01['SUM(checkout_ties)'];?>
                        </div></td>
                      <? } ?>
                      <td width="10%" style="border: 1px solid #c5c5c5; font-weight:100;" align="center"></td>
                    </tr>
                  </tbody>
                </table>
                <div id="printable" style="font-family: 'Roboto', sans-serif; color:#000000; font-size:14px; letter-spacing:1px;" align="left"><br>
                  <strong> TOTAL </strong><br>
                  <? if ($reseller == "" && $start_date == "" && $end_date == "") { ?>
                  <?
                  $strSQL01 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Austria' ";
	  			  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				
                  $strSQL02 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Australia' ";
	  			  $objQuery02 = mysql_query($strSQL02) or die ("Error Query [".$strSQL02."]");
				  $objResult02 = mysql_fetch_array($objQuery02);
				
                  $strSQL03 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Belgium' ";
	  			  $objQuery03 = mysql_query($strSQL03) or die ("Error Query [".$strSQL03."]");
				  $objResult03 = mysql_fetch_array($objQuery03);
				
                  $strSQL04 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Canada' ";
	  			  $objQuery04 = mysql_query($strSQL04) or die ("Error Query [".$strSQL04."]");
				  $objResult04 = mysql_fetch_array($objQuery04);
				
                  $strSQL05 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Denmark' ";
	  			  $objQuery05 = mysql_query($strSQL05) or die ("Error Query [".$strSQL05."]");
				  $objResult05 = mysql_fetch_array($objQuery05);
				
                  $strSQL06 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Germany' ";
	  			  $objQuery06 = mysql_query($strSQL06) or die ("Error Query [".$strSQL06."]");
				  $objResult06 = mysql_fetch_array($objQuery06);
				
                  $strSQL07 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Italy' ";
	  			  $objQuery07 = mysql_query($strSQL07) or die ("Error Query [".$strSQL07."]");
				  $objResult07 = mysql_fetch_array($objQuery07);
				
                  $strSQL08 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Netherlands' ";
	  			  $objQuery08 = mysql_query($strSQL08) or die ("Error Query [".$strSQL08."]");
				  $objResult08 = mysql_fetch_array($objQuery08);
				
                  $strSQL09 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Norway' ";
	  			  $objQuery09 = mysql_query($strSQL09) or die ("Error Query [".$strSQL09."]");
				  $objResult09 = mysql_fetch_array($objQuery09);
				
                  $strSQL010 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Sweden' ";
	  			  $objQuery010 = mysql_query($strSQL010) or die ("Error Query [".$strSQL010."]");
				  $objResult010 = mysql_fetch_array($objQuery010);
				
                  $strSQL011 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Switzerland' ";
	  			  $objQuery011 = mysql_query($strSQL011) or die ("Error Query [".$strSQL011."]");
				  $objResult011 = mysql_fetch_array($objQuery011);
				
                  $strSQL012 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'Thailand' ";
	  			  $objQuery012 = mysql_query($strSQL012) or die ("Error Query [".$strSQL012."]");
				  $objResult012 = mysql_fetch_array($objQuery012);
				
                  $strSQL013 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'UK' ";
	  			  $objQuery013 = mysql_query($strSQL013) or die ("Error Query [".$strSQL013."]");
				  $objResult013 = mysql_fetch_array($objQuery013);
				
                  $strSQL014 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_country = 'US' ";
	  			  $objQuery014 = mysql_query($strSQL014) or die ("Error Query [".$strSQL014."]");
				  $objResult014 = mysql_fetch_array($objQuery014);
				  ?>
                  <? } else if ($reseller != "" && $start_date != "" && $end_date != "") { ?>
                  <?
                  $strSQL01 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Austria' ";
	  			  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				
                  $strSQL02 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Australia' ";
	  			  $objQuery02 = mysql_query($strSQL02) or die ("Error Query [".$strSQL02."]");
				  $objResult02 = mysql_fetch_array($objQuery02);
				
                  $strSQL03 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Belgium' ";
	  			  $objQuery03 = mysql_query($strSQL03) or die ("Error Query [".$strSQL03."]");
				  $objResult03 = mysql_fetch_array($objQuery03);
				
                  $strSQL04 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Canada' ";
	  			  $objQuery04 = mysql_query($strSQL04) or die ("Error Query [".$strSQL04."]");
				  $objResult04 = mysql_fetch_array($objQuery04);
				
                  $strSQL05 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Denmark' ";
	  			  $objQuery05 = mysql_query($strSQL05) or die ("Error Query [".$strSQL05."]");
				  $objResult05 = mysql_fetch_array($objQuery05);
				
                  $strSQL06 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Germany' ";
	  			  $objQuery06 = mysql_query($strSQL06) or die ("Error Query [".$strSQL06."]");
				  $objResult06 = mysql_fetch_array($objQuery06);
				
                  $strSQL07 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Italy' ";
	  			  $objQuery07 = mysql_query($strSQL07) or die ("Error Query [".$strSQL07."]");
				  $objResult07 = mysql_fetch_array($objQuery07);
				
                  $strSQL08 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Netherlands' ";
	  			  $objQuery08 = mysql_query($strSQL08) or die ("Error Query [".$strSQL08."]");
				  $objResult08 = mysql_fetch_array($objQuery08);
				
                  $strSQL09 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Norway' ";
	  			  $objQuery09 = mysql_query($strSQL09) or die ("Error Query [".$strSQL09."]");
				  $objResult09 = mysql_fetch_array($objQuery09);
				
                  $strSQL010 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Sweden' ";
	  			  $objQuery010 = mysql_query($strSQL010) or die ("Error Query [".$strSQL010."]");
				  $objResult010 = mysql_fetch_array($objQuery010);
				
                  $strSQL011 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Switzerland' ";
	  			  $objQuery011 = mysql_query($strSQL011) or die ("Error Query [".$strSQL011."]");
				  $objResult011 = mysql_fetch_array($objQuery011);
				
                  $strSQL012 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Thailand' ";
	  			  $objQuery012 = mysql_query($strSQL012) or die ("Error Query [".$strSQL012."]");
				  $objResult012 = mysql_fetch_array($objQuery012);
				
                  $strSQL013 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'UK' ";
	  			  $objQuery013 = mysql_query($strSQL013) or die ("Error Query [".$strSQL013."]");
				  $objResult013 = mysql_fetch_array($objQuery013);
				
                  $strSQL014 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'US' ";
	  			  $objQuery014 = mysql_query($strSQL014) or die ("Error Query [".$strSQL014."]");
				  $objResult014 = mysql_fetch_array($objQuery014);
				  ?>
                  <? } else if ($reseller != "" && $start_date == "" && $end_date == "") { ?>
                  <?
                  $strSQL01 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Austria' ";
	  			  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				
                  $strSQL02 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Australia' ";
	  			  $objQuery02 = mysql_query($strSQL02) or die ("Error Query [".$strSQL02."]");
				  $objResult02 = mysql_fetch_array($objQuery02);
				
                  $strSQL03 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Belgium' ";
	  			  $objQuery03 = mysql_query($strSQL03) or die ("Error Query [".$strSQL03."]");
				  $objResult03 = mysql_fetch_array($objQuery03);
				
                  $strSQL04 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Canada' ";
	  			  $objQuery04 = mysql_query($strSQL04) or die ("Error Query [".$strSQL04."]");
				  $objResult04 = mysql_fetch_array($objQuery04);
				
                  $strSQL05 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Denmark' ";
	  			  $objQuery05 = mysql_query($strSQL05) or die ("Error Query [".$strSQL05."]");
				  $objResult05 = mysql_fetch_array($objQuery05);
				
                  $strSQL06 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Germany' ";
	  			  $objQuery06 = mysql_query($strSQL06) or die ("Error Query [".$strSQL06."]");
				  $objResult06 = mysql_fetch_array($objQuery06);
				
                  $strSQL07 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Italy' ";
	  			  $objQuery07 = mysql_query($strSQL07) or die ("Error Query [".$strSQL07."]");
				  $objResult07 = mysql_fetch_array($objQuery07);
				
                  $strSQL08 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Netherlands' ";
	  			  $objQuery08 = mysql_query($strSQL08) or die ("Error Query [".$strSQL08."]");
				  $objResult08 = mysql_fetch_array($objQuery08);
				
                  $strSQL09 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Norway' ";
	  			  $objQuery09 = mysql_query($strSQL09) or die ("Error Query [".$strSQL09."]");
				  $objResult09 = mysql_fetch_array($objQuery09);
				
                  $strSQL010 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Sweden' ";
	  			  $objQuery010 = mysql_query($strSQL010) or die ("Error Query [".$strSQL010."]");
				  $objResult010 = mysql_fetch_array($objQuery010);
				
                  $strSQL011 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Switzerland' ";
	  			  $objQuery011 = mysql_query($strSQL011) or die ("Error Query [".$strSQL011."]");
				  $objResult011 = mysql_fetch_array($objQuery011);
				
                  $strSQL012 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'Thailand' ";
	  			  $objQuery012 = mysql_query($strSQL012) or die ("Error Query [".$strSQL012."]");
				  $objResult012 = mysql_fetch_array($objQuery012);
				
                  $strSQL013 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'UK' ";
	  			  $objQuery013 = mysql_query($strSQL013) or die ("Error Query [".$strSQL013."]");
				  $objResult013 = mysql_fetch_array($objQuery013);
				
                  $strSQL014 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_company = '$reseller' AND checkout_country = 'US' ";
	  			  $objQuery014 = mysql_query($strSQL014) or die ("Error Query [".$strSQL014."]");
				  $objResult014 = mysql_fetch_array($objQuery014);
				  ?>
                  <? } else if ($reseller == "" && $start_date != "" && $end_date != "") { ?>
                  <?
                  $strSQL01 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Austria' ";
	  			  $objQuery01 = mysql_query($strSQL01) or die ("Error Query [".$strSQL01."]");
				  $objResult01 = mysql_fetch_array($objQuery01);
				
                  $strSQL02 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Australia' ";
	  			  $objQuery02 = mysql_query($strSQL02) or die ("Error Query [".$strSQL02."]");
				  $objResult02 = mysql_fetch_array($objQuery02);
				
                  $strSQL03 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Belgium' ";
	  			  $objQuery03 = mysql_query($strSQL03) or die ("Error Query [".$strSQL03."]");
				  $objResult03 = mysql_fetch_array($objQuery03);
				
                  $strSQL04 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Canada' ";
	  			  $objQuery04 = mysql_query($strSQL04) or die ("Error Query [".$strSQL04."]");
				  $objResult04 = mysql_fetch_array($objQuery04);
				
                  $strSQL05 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Denmark' ";
	  			  $objQuery05 = mysql_query($strSQL05) or die ("Error Query [".$strSQL05."]");
				  $objResult05 = mysql_fetch_array($objQuery05);
				
                  $strSQL06 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Germany' ";
	  			  $objQuery06 = mysql_query($strSQL06) or die ("Error Query [".$strSQL06."]");
				  $objResult06 = mysql_fetch_array($objQuery06);
				
                  $strSQL07 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Italy' ";
	  			  $objQuery07 = mysql_query($strSQL07) or die ("Error Query [".$strSQL07."]");
				  $objResult07 = mysql_fetch_array($objQuery07);
				
                  $strSQL08 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Netherlands' ";
	  			  $objQuery08 = mysql_query($strSQL08) or die ("Error Query [".$strSQL08."]");
				  $objResult08 = mysql_fetch_array($objQuery08);
				
                  $strSQL09 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Norway' ";
	  			  $objQuery09 = mysql_query($strSQL09) or die ("Error Query [".$strSQL09."]");
				  $objResult09 = mysql_fetch_array($objQuery09);
				
                  $strSQL010 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Sweden' ";
	  			  $objQuery010 = mysql_query($strSQL010) or die ("Error Query [".$strSQL010."]");
				  $objResult010 = mysql_fetch_array($objQuery010);
				
                  $strSQL011 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Switzerland' ";
	  			  $objQuery011 = mysql_query($strSQL011) or die ("Error Query [".$strSQL011."]");
				  $objResult011 = mysql_fetch_array($objQuery011);
				
                  $strSQL012 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'Thailand' ";
	  			  $objQuery012 = mysql_query($strSQL012) or die ("Error Query [".$strSQL012."]");
				  $objResult012 = mysql_fetch_array($objQuery012);
				
                  $strSQL013 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'UK' ";
	  			  $objQuery013 = mysql_query($strSQL013) or die ("Error Query [".$strSQL013."]");
				  $objResult013 = mysql_fetch_array($objQuery013);
				
                  $strSQL014 = " SELECT SUM(checkout_price) FROM customize_checkout WHERE checkout_number != '0' AND checkout_status = 'T' AND checkout_status_send = 'send' AND checkout_date BETWEEN '$start_date' AND '$end_date' AND checkout_country = 'US' ";
	  			  $objQuery014 = mysql_query($strSQL014) or die ("Error Query [".$strSQL014."]");
				  $objResult014 = mysql_fetch_array($objQuery014);
				  ?>
                  <? } ?>
                  <? if ($objResult01["SUM(checkout_price)"] != '') { ?>
                  EURO
                  <?=$objResult01["SUM(checkout_price)"]?>
                  (Austria) <br>
                  <? } else { } ?>
                  <? if ($objResult02["SUM(checkout_price)"] != '') { ?>
                  USD
                  <?=$objResult01["SUM(checkout_price)"]?>
                  (Australia) <br>
                  <? } else { } ?>
                  <? if ($objResult03["SUM(checkout_price)"] != '') { ?>
                  EURO
                  <?=$objResult01["SUM(checkout_price)"]?>
                  (Belgium) <br>
                  <? } else { } ?>
                  <? if ($objResult04["SUM(checkout_price)"] != '') { ?>
                  USD
                  <?=$objResult01["SUM(checkout_price)"]?>
                  (Canada) <br>
                  <? } else { } ?>
                  <? if ($objResult05["SUM(checkout_price)"] != '') { ?>
                  DKK
                  <?=$objResult05["SUM(checkout_price)"]?>
                  (Denmark) <br>
                  <? } else { } ?>
                  <? if ($objResult06["SUM(checkout_price)"] != '') { ?>
                  EURO
                  <?=$objResult06["SUM(checkout_price)"]?>
                  (Germany) <br>
                  <? } else { } ?>
                  <? if ($objResult07["SUM(checkout_price)"] != '') { ?>
                  EURO
                  <?=$objResult07["SUM(checkout_price)"]?>
                  (Italy) <br>
                  <? } else { } ?>
                  <? if ($objResult08["SUM(checkout_price)"] != '') { ?>
                  EURO
                  <?=$objResult08["SUM(checkout_price)"]?>
                  (Netherlands) <br>
                  <? } else { } ?>
                  <? if ($objResult09["SUM(checkout_price)"] != '') { ?>
                  NOK
                  <?=$objResult09["SUM(checkout_price)"]?>
                  (Norway) <br>
                  <? } else { } ?>
                  <? if ($objResult010["SUM(checkout_price)"] != '') { ?>
                  SEK
                  <?=$objResult010["SUM(checkout_price)"]?>
                  (Sweden) <br>
                  <? } else { } ?>
                  <? if ($objResult011["SUM(checkout_price)"] != '') { ?>
                  EURO
                  <?=$objResult011["SUM(checkout_price)"]?>
                  (Switzerland) <br>
                  <? } else { } ?>
                  <? if ($objResult012["SUM(checkout_price)"] != '') { ?>
                  THB
                  <?=$objResult012["SUM(checkout_price)"]?>
                  (Thailand) <br>
                  <? } else { } ?>
                  <? if ($objResult013["SUM(checkout_price)"] != '') { ?>
                  GBP
                  <?=$objResult013["SUM(checkout_price)"]?>
                  (UK) <br>
                  <? } else { } ?>
                  <? if ($objResult014["SUM(checkout_price)"] != '') { ?>
                  USD
                  <?=$objResult014["SUM(checkout_price)"]?>
                  (US) <br>
                  <? } else { } ?>
                </div>
              </div>
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
      
      <!-- end::Body --> 
    </div>
  </div>
  <!-- end:: Body --> 
  <!-- begin::Footer -->
  <footer class="m-grid__item m-footer">
    <div id="non-printable">
      <div class="m-container m-container--fluid m-container--full-height m-page__container">
        <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
          <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last"> <span class="m-footer__copyright"> 2019 &copy; Reseller Online </span> </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- end::Footer --> 
</div>
<!-- end:: Page --> 
<!--begin::Base Scripts --> 
<script src="../js/vendors.bundle.js" type="text/javascript"></script> 
<script src="../js/scripts.bundle.js" type="text/javascript"></script> 
<script src="../js/datatables.bundle.js" type="text/javascript"></script> 
<script src="../js/bootstrap-datepicker.js" type="text/javascript"></script> 
<script> function changeLocation(menuObj) { var i = menuObj.selectedIndex; if(i > 0) { window.location = menuObj.options[i].value; } } </script> 
<!--end::Base Scripts --> 
<script> function clearlist() { document.getElementById('start_date').value=""; document.getElementById('end_date').value=""; } </script>
</body>
<!-- end::Body -->
</html>