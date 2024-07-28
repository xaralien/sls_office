<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/icon-sls.png" />
	<title><?= $title ?> | SLS</title>
	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="<?php echo base_url(); ?>login_lib/vendor/bootstrap/css/bootstrap-grid.css" rel="stylesheet"> -->
	<!-- Font Awesome -->
	<link href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="<?php echo base_url(); ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="<?php echo base_url(); ?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

	<!-- bootstrap-progressbar -->
	<link href="<?php echo base_url(); ?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	<!-- JQVMap -->
	<link href="<?php echo base_url(); ?>assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
	<!-- bootstrap-daterangepicker -->
	<link href="<?php echo base_url(); ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/build/css/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/build/css/owl.theme.default.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2/css/select2.min.css">
	<!-- footer menu -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mobile_menu/header.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mobile_menu/icons.css">
	<!-- My Style -->
	<link rel="stylesheet" href="<?= base_url('assets/css/mystyle.css') ?>">

	<style>
		.col-xs-3 {
			width: 25%;
			background-color: #008080;
		}

		.row {
			margin-left: 0px;
		}

		.container-fluid {
			padding-right: 0px;
			padding-left: 0px
		}

		.btn_footer_panel .tag_ {
			padding-top: 37px;
		}

		.justify-content-center {
			display: flex;
			justify-content: center;
		}
	</style>
	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
</head>

<header class="header_area sticky-header">
	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>
	<div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('message_error') ?>"></div>
	<!-- footer menu -->
	<div class="footer_panel">
		<div class="container-fluid text-center">
			<div class="row">

				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/create_memo">
						<i class="la-i la-i-m la-i-home"></i>
						<div class="tag_">
							<font color="white">Create</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/inbox">
						<i class="la-i la-i-m la-i-order"></i>
						<div class="tag_">
							<font color="white">Inbox</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/send_memo">
						<i class="la-i la-i-m la-i-notif"></i>
						<div class="tag_">
							<font color="white">Outbox</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>login/logout">
						<i class="la-i la-i-m la-i-akun"></i>
						<div class="tag_">
							<font color="white">Logout</font>
						</div>
					</a>
				</div>

			</div>
		</div>
	</div>
	<!-- footer menu -->
</header>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title text-center" style="border: 0;">
						<a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>assets/img/logo-sls.png" alt="..." width="50%" style="filter:drop-shadow(1px 1px 1px #fff)"></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="<?php echo base_url(); ?>assets/images/img.jpg" alt="..." class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Welcome,</span>
							<h2><?php echo $this->session->userdata('nama'); ?></h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<?php $this->load->view('layouts/side_menu.php'); ?>
					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->

					<!-- /menu footer buttons -->
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>

						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<img src="<?php echo base_url(); ?>assets/images/img.jpg" alt=""><?php echo $this->session->userdata('nama'); ?>
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li><a href="javascript:;"> Profile</a></li>
									<li>
										<a href="javascript:;">
											<span class="badge bg-red pull-right">50%</span>
											<span>Settings</span>
										</a>
									</li>
									<li><a href="javascript:;">Help</a></li>
									<li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log
											Out</a></li>
								</ul>
							</li>

							<li role="presentation" class="dropdown">
								<!--a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"-->
								<a href="<?php echo base_url() . "app/inbox"; ?>" class="dropdown-toggle info-number">
									<i class="fa fa-envelope-o"></i>
									<?php if ($count_inbox == 0) { ?>
										<span class="badge bg-green"><?php echo $count_inbox; ?></span>
									<?php } else { ?>
										<span class="badge bg-red"><?php echo $count_inbox; ?></span>
									<?php } ?>
								</a>
							</li>
							<?php include 'layouts/notif_tello.php' ?>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<?php $this->load->view($pages); ?>

			<!-- /page content -->

			<!-- footer content -->

			<!-- /footer content -->
		</div>
	</div>

	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url(); ?>assets/vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="<?php echo base_url(); ?>assets/vendors/nprogress/nprogress.js"></script>
	<!-- Chart.js -->
	<script src="<?php echo base_url(); ?>assets/vendors/Chart.js/dist/Chart.min.js"></script>
	<!-- gauge.js -->
	<script src="<?php echo base_url(); ?>assets/vendors/gauge.js/dist/gauge.min.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="<?php echo base_url(); ?>assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="<?php echo base_url(); ?>assets/vendors/iCheck/icheck.min.js"></script>
	<!-- Skycons -->
	<script src="<?php echo base_url(); ?>assets/vendors/skycons/skycons.js"></script>
	<!-- Flot -->
	<script src="<?php echo base_url(); ?>assets/vendors/Flot/jquery.flot.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/Flot/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/Flot/jquery.flot.time.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/Flot/jquery.flot.stack.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/Flot/jquery.flot.resize.js"></script>
	<!-- Flot plugins -->
	<script src="<?php echo base_url(); ?>assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/flot.curvedlines/curvedLines.js"></script>
	<!-- DateJS -->
	<script src="<?php echo base_url(); ?>assets/vendors/DateJS/build/date.js"></script>
	<!-- JQVMap -->
	<script src="<?php echo base_url(); ?>assets/vendors/jqvmap/dist/jquery.vmap.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="<?php echo base_url(); ?>assets/vendors/moment/min/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>assets/build/js/custom.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/build/js/owl.carousel.min.js"></script>
	<!-- Sweetalert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- Select 2 -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/select2/js/select2.min.js"></script>
	<!-- My Script -->
	<script src="<?php echo base_url(); ?>assets/js/myscript.js"></script>

	<script>
		$('.owl-carousel').owlCarousel({
			loop: true,
			margin: 10,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: true
				},
				600: {
					items: 3,
					nav: false
				},
				1000: {
					items: 1,
					nav: true,
					loop: true,
					autoplay: true,
				}
			}
		});
	</script>

	<script>
		$(document).ready(function() {
			get_detail_item();

			$('#select-direksi').hide();
			$('select[name="status"]').change(function() {
				var value = $(this).val();
				if (value == 1) {
					$('#select-direksi').show();
				} else {
					$('#select-direksi').hide();
				}
			})

			// $('.select2').select2({
			// 	width: '100%'
			// })

			$('#item-0').select2({
				width: '100%'
			});

			$('#detail-item-0').select2({
				width: '100%'
			});

			var rowCount = $(".baris").length;


			$(document).on("click", ".remove-form", function() {
				rowCount--;
				$(this).parents(".baris").remove();
				updateTotalItem();
			});
		})

		function count_item_out() {
			const item_out = document.querySelectorAll('.item-out');
			return item_out;
		}

		function get_detail_item() {
			$.each($(".item-out"), function(index, value) {
				$('#item-' + index).change(function() {
					$('#qty-' + index).attr('readonly', false);
					var id = $(this).val();
					$('#qty-' + index).val(0)
					$.ajax({
						url: "<?= base_url('asset/getItemById/') ?>",
						type: "POST",
						chace: false,
						data: {
							id: id,
						},
						dataType: "JSON",
						success: function(res) {
							var qty = $('#qty-' + index).val().replace(/\./g, "");
							var price = res.harga;
							qty = parseInt(qty);
							price = parseInt(price);
							qty = isNaN(qty) ? 0 : qty;
							price = isNaN(price) ? 0 : price;
							var total = qty * price;
							if (res.option) {
								// $('#select-detail-' + index).show();
								$('#detail-item-' + index).html(res.option)
								$('#price-' + index).val(formatNumber(convertToComa(res.harga)))
								$('#total-' + index).val(formatNumber(convertToComa(total)));
							} else {
								// $('#select-detail-' + index).hide();
								$('#price-' + index).val(formatNumber(convertToComa(res.harga)))
								$('#total-' + index).val(formatNumber(convertToComa(total)));
							}
							updateTotalItem();
						}
					})
				});

				$('#detail-item-' + index).change(function() {
					var count = $(this).select2('data').length;
					var price = $('#price-' + index).val().replace(/\./g, "");
					var total = parseInt(count) * parseInt(price);

					$('#qty-' + index).val(parseInt(count));
					$('#total-' + index).val(formatNumber(convertToComa(total)));
					$('#qty-' + index).attr('readonly', true);
					updateTotalItem();
				})
			})
		}

		function convertToComa(number) {
			return number.toString().replace('.', ",");
		}

		function updateTotalItem() {
			var total_pos_fix = 0;
			$(".baris").each(function() {
				var total = $(this).find('input[name="total[]"]').val().replace(/\./g, ""); // Ambil nilai total dari setiap baris
				total = parseFloat(total); // Ubah string ke angka float
				if (!isNaN(total)) {
					// Pastikan total adalah angka
					total_pos_fix += total; // Tambahkan nilai total ke total_pos_fix
				}
			});
			$("#nominal").val(formatNumber(total_pos_fix)); // Atur nilai input #nominal dengan total_pos_fix
		}
	</script>

</body>

</html>