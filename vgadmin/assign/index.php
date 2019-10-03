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
<link rel="shortcut icon" href="../images/favicon.ico">
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
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
      <!-- begin::Body -->
      <div class="m-content">
        <div class="row">
          <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption" align="center">
                  <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text" style="text-transform:uppercase;" style="font-family: 'Roboto', sans-serif;">
                    <strong> Assign Fabrics </strong>
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
              <!--begin::Form-->
              <form class="m-form m-form--fit m-form--label-align-right" action="../include/assign_add_code.php" method="post" enctype="multipart/form-data" name="frmMain">
                <div class="m-portlet__body">

									<!-- Category Select -->
                  <div class="form-group m-form__group">
                    <label style="font-family: 'Roboto', sans-serif;"> Select category: </label><br />
                    <input type="hidden" name="assign_admin" id="assign_admin" value="<?=$row_user['id'];?>" required>
                    <?
                      $strSQL1 = " SELECT * FROM admin_category WHERE category_status = 'T' ORDER BY category_name ASC ";
			                $objQuery1 = mysql_query($strSQL1) or die ("Error Query [".$strSQL1."]");
			              ?>
                    <select class="form-control m-input" style="font-family: 'Roboto', sans-serif;" name="category_category" id="category_category">
                      <? while($objResult1 = mysql_fetch_array($objQuery1)) { ?>
                      <option style="font-family: 'Roboto', sans-serif;" value="<?=$objResult1['category_name'];?>">
                      <?=$objResult1['category_name'];?>
                      </option>
                      <? } ?>
                    </select>
                    <span class="m-form__help" style="font-family: 'Roboto', sans-serif;"> Show all category created by admin </span> </div>

										<!-- FabricType Select -->
										<div class="form-group m-form__group" id="select_fabrics_type">
											<label style="font-family: 'Roboto', sans-serif;"> Select Fabric Type: </label><br />
											<input type="hidden" name="admin_fabrictype" id="admin_fabrictype" value="<?=$row_user['id'];?>" required>
											<?
											$strSQL3 = " SELECT DISTINCT(fabrictype_name) FROM admin_fabrictype WHERE fabrictype_status = 'T' ORDER BY fabrictype_name ASC ";
											$objQuery3 = mysql_query($strSQL3) or die ("Error Query [".$strSQL3."]");
											?>
											<div style="font-family: 'Roboto', sans-serif;">
												<? while($objResult3 = mysql_fetch_array($objQuery3)) { ?>
													<label class="m-checkbox"><?=$objResult3["fabrictype_name"]?>
														<input type="checkbox"  name="fabrictype_category[]" id="fabrictype_category" style="font-family: 'Roboto', sans-serif;" value="<?php echo $objResult3['id'];?>"><span></span>
													</label>  &nbsp;&nbsp;
												<? } ?>
											</div>
										</div>

										<!-- FabricBrand Select -->
                      <div class="form-group m-form__group" id="select_fabrics_brand">
												<label style="font-family: 'Roboto', sans-serif;"> Select Fabric Brand: </label>
												<input type="hidden" name="admin_fabrictype" id="admin_fabrictype" value="<?=$row_user['id'];?>" required>
                        <?
                          $strSQL1 = " SELECT DISTINCT(fabricbrand_name) FROM admin_fabricbrand WHERE fabricbrand_status = 'T' ORDER BY fabricbrand_name ASC ";
                          $objQuery1 = mysql_query($strSQL1) or die ("Error Query [".$strSQL1."]");
                        ?>
												<div style="font-family: 'Roboto', sans-serif;">
													<? while($objResult1 = mysql_fetch_array($objQuery1)) { ?>
														<label class="m-checkbox" ><?=$objResult1["fabricbrand_name"]?>
															<input type="checkbox" name="fabricbrand_category[]" id="fabricbrand_category" style="font-family: 'Roboto', sans-serif;" value="<?php echo $objResult1['id'];?>"><span></span>
														</label>  &nbsp;&nbsp;
													<? } ?>
												</div>
											</div>


                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions">
                    <button type="submit" class="btn btn-primary" style="font-family: 'Roboto', sans-serif;"> Submit </button>
                  </div>
                </div>
              </form>
              <!--end::Form-->
            </div>
          </div>
        </div>

				<div class="m-portlet m-portlet--mobile">
					<div class="m-portlet__body">
						<!--begin: Datatable -->
						<?
							$strSQL2 = " SELECT * FROM admin_assign WHERE assign_status = 'T' ORDER BY id ASC ";
				$objQuery2 = mysql_query($strSQL2) or die ("Error Query [".$strSQL2."]");
				?>
				<form name="frmMain" action="delete.php" method="post" OnSubmit="return checkDelete()">
						<table class="table table-striped- table-bordered table-hover table-checkable">
							<!-- <button type="submit" class="btn btn-danger" style="margin-bottom: 10px">Delete</button> -->
							<thead>
								<tr>
									<th style="font-family: 'Roboto', sans-serif;"> <button type="submit" class="btn btn-danger" style="font-family: 'Roboto', sans-serif;"> Delete </button></th>
									<th style="font-family: 'Roboto', sans-serif;"> Category </th>
									<th style="font-family: 'Roboto', sans-serif;"> Fabric Type </th>
									<th style="font-family: 'Roboto', sans-serif;"> Fabric Brand </th>
									<th style="font-family: 'Roboto', sans-serif;"> </th>
								</tr>
							</thead>
							<tbody>
								<? while($objResult2 = mysql_fetch_array($objQuery2)) { ?>
								<tr>
									<td style="font-family: 'Roboto', sans-serif;"><input type="checkbox" name="chkDel[]" value="<?php echo $objResult2['id'];?>"></td><!--Here-->
									<td style="font-family: 'Roboto', sans-serif;"><?=$objResult2["category_category"]?></td>
									<td style="font-family: 'Roboto', sans-serif;"><?=$objResult2["category_fabrictype"]?></td>
									<td style="font-family: 'Roboto', sans-serif;"><?=$objResult2["category_fabricbrand"]?></td>
									<td style="font-family: 'Roboto', sans-serif;"><a href="edit.php?id=<?=$objResult2["id"]?>"> Edit </a></td>
								</tr>
								<? } ?>
							</tbody>
						</table>
				</form>
					</div>
				</div>


      </div>
      <!-- end::Body -->
    </div>
  </div>
  <!-- end:: Body -->
  <!-- begin::Footer -->
  <footer class="m-grid__item m-footer">
    <div class="m-container m-container--fluid m-container--full-height m-page__container">
      <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
        <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last"> <span class="m-footer__copyright"> 2019 &copy; Reseller Online </span> </div>
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
<script src="../js/scrollable.js" type="text/javascript"></script>
<script type="text/javascript"> function tab_select_type_one(){ document.getElementById("select_fabrics_type").style.display="block",document.getElementById("select_fabrics_brand").style.display="none"} </script>
<script type="text/javascript"> function tab_select_type_two(){ document.getElementById("select_fabrics_type").style.display="none",document.getElementById("select_fabrics_brand").style.display="block"} </script>
<!--end::Base Scripts -->
</body>
<!-- end::Body -->
</html>
