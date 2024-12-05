<!doctype html>
<html lang="en">
<head>
    <title>IPTV - Password Reset</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://imserver.threeiptv.com/assets/customer/css/login.css" rel="stylesheet" type="text/css" />
    <style>
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: 21px;
            position: relative;
            z-index: 2;
        }

        .container {
            padding-top: 50px;
            margin: auto;
        }
    </style>
</head>
<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <h2 class="heading-section"><img src="https://imserver.threeiptv.com/assets/ums/logo-general.png" style="height:160px;" alt="logo" /></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    <div class="login-wrap p-4 p-md-5">
                        <h3 class="text-center mb-4 text-white">Password Reset Initiated</h3>

                        <div class="form-group text-center">
                            <p class="fs-6 mb-4">
                                <span class="fw-semibold text-gray-500">We've sent instructions to reset your password.</span>
                            </p>
                            <h2 class="fw-bolder text-white-900 mb-5 text-white">
                                <?php 
                                if(isset($sent_to_email) && isset($sent_to_sms)) {
                                    echo "Please check your Email and SMS for password reset instructions.";
                                } elseif(isset($sent_to_email)) {
                                    echo "Please check your Email for password reset instructions.";
                                } elseif(isset($sent_to_sms)) {
                                    echo "Please check your SMS for password reset instructions.";
                                }
                                ?>
                            </h2>
                        </div>

                        <div class="form-group">
                            <a href="<?php echo BASE_URL;?>customer/customerlogin" class="form-control btn btn-primary rounded submit px-3">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <ul class="foote_bottom_ul_amrc">
            <li><a href="https://www.realtv.co" class="text-white">www.realtv.co</a></li>
        </ul>
    </div>
    <footer style="margin-bottom: 10px;">  
        <p style="margin-bottom: 10px;" class="text-center text-white">Copyright(c) <?php echo date('Y'); ?>, All rights reserved by <b>XTV Player</b>. <br></p>
    </footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>