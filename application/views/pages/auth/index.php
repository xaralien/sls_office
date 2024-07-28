<!DOCTYPE html>

<html lang="en">

<head>

    <title><?= $title ?> - SLS</title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--===============================================================================================-->

    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/icon-sls.png" />

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/vendor/bootstrap/css/bootstrap.min.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/vendor/animate/animate.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/vendor/css-hamburgers/hamburgers.min.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/vendor/animsition/css/animsition.min.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/vendor/select2/select2.min.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/vendor/daterangepicker/daterangepicker.css">

    <!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/css/util.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/login_lib/css/main.css">

    <!--===============================================================================================-->

</head>

<body>

    <div class="limiter">

        <div class="container-login100" style="background-image: url('');">

            <div class="wrap-login390 p-t-10 p-b-10">

                <span class="login100-form-title p-b-41">

                    <img src="<?= base_url(); ?>assets/img/logo-sls.png" alt="..." width="50%" style="filter:drop-shadow(1px 1px 1px #fff)">

                </span>

                <?php if (isset($pages)) $this->load->view($pages); ?>

            </div>

            <br>
            <div class="text-center">
                <font color="white">Kodesis.id &copy;2024 <br> BOC 2.0</font>
            </div>

        </div>

    </div>

    </div>

    <!--===============================================================================================-->

    <script src="<?= base_url(); ?>assets/login_lib/vendor/jquery/jquery-3.2.1.min.js"></script>

    <!--===============================================================================================-->

    <script src="<?= base_url(); ?>assets/login_lib/vendor/animsition/js/animsition.min.js"></script>

    <!--===============================================================================================-->

    <script src="<?= base_url(); ?>assets/login_lib/vendor/bootstrap/js/popper.js"></script>

    <script src="<?= base_url(); ?>assets/login_lib/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!--===============================================================================================-->

    <script src="<?= base_url(); ?>assets/login_lib/vendor/select2/select2.min.js"></script>

    <!--===============================================================================================-->

    <script src="<?= base_url(); ?>assets/login_lib/vendor/daterangepicker/moment.min.js"></script>

    <script src="<?= base_url(); ?>assets/login_lib/vendor/daterangepicker/daterangepicker.js"></script>

    <!--===============================================================================================-->

    <script src="<?= base_url(); ?>assets/login_lib/vendor/countdowntime/countdowntime.js"></script>

    <!--===============================================================================================-->

    <script src="<?= base_url(); ?>assets/login_lib/js/main.js"></script>

</body>

</html>