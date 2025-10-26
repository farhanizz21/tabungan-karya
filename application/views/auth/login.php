<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/Logo_Smartedu.svg'); ?>">
    <title>Login - Tabungan Karya</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css');?>">
    <style type="text/css">
    .login-container {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
    }


    body.bg-login {
        background-image: url('<?= base_url('assets_dashboard/img/unesa.webp'); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .bg-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 0;
    }



    @media (max-width: 992px) {
        .login-form:before {
            display: none;
        }

        .logo-mobile {
            display: block !important;
            width: 50px;
            margin: 0 auto 20px auto;
        }
    }
    </style>
</head>

<!-- <body class="bg-gradient-primary"> -->

<body class="bg-login">
    <div class="bg-overlay">


        <div class="container login-container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5 p-3">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 login-form">
                                    <div class="text-center d-none d-lg-block">
                                        <img src="<?= base_url('assets/img/Logo_Smartedu.svg');?>" class="w-100">
                                    </div>
                                </div>
                                <div class="col-lg-6 login-form ">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <div class="logo-mobile d-none">
                                                <img src="<?= base_url('assets/img/Logo_Smartedu.svg');?>"
                                                    class="w-100">
                                            </div>
                                            <h1 class="h4 text-gray-900 mb-4">Selamat datang di <br> Tabungan Karya !
                                            </h1>
                                            <?php if($this->session->flashdata('error_msg')): ?>
                                            <div class="alert alert-danger">
                                                <?= $this->session->flashdata('error_msg') ?>
                                            </div>
                                            <br>
                                            <?php endif ?>
                                        </div>
                                        <form class="user" action="" method="post">
                                            <div class="form-group">
                                                <input type="text" name="username"
                                                    class="form-control form-control-user <?= form_error('username') ? 'invalid' : '' ?>"
                                                    value="<?= set_value('username'); ?>"
                                                    placeholder="Masukkan Username">
                                                <div
                                                    class="invalid-feedback <?= !empty(form_error('username')) ? 'd-block':'';?>">
                                                    <?= form_error('username') ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password"
                                                    class="form-control form-control-user <?= form_error('password') ? 'invalid' : '' ?>"
                                                    value="<?= set_value('password'); ?>"
                                                    placeholder="Masukkan Password">
                                                <div
                                                    class="invalid-feedback <?= !empty(form_error('password')) ? 'd-block':'';?>">
                                                    <?= form_error('password') ?>
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

        <!-- Core plugin JavaScript-->
        <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

        <!-- Custom scripts for all pages-->
        <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>

        <script>
        VANTA.NET({
            el: "#bg-animate",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00
        })
        </script>

    </div>
</body>

</html>