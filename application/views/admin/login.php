<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= PROJECT_NAME; ?> | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= base_url('assets/bower_components/Ionicons/css/ionicons.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css'); ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/square/blue.css'); ?>">

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <style>
            .error{color: red;margin-bottom: 0px;font-size: 12px;font-style: 500;}
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box d-flex flex-row">
          <div class="form-section">
            <div class="login-logo">
                <a href="#"><b><?= PROJECT_NAME; ?></b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
              <div class="inner-login">
                <p class="welcome-text">Welcome Back!</p>
                <p class="login-box-msg">Please enter your details to sign into your account</p>
                <p class="text-center text-danger"><?= isset($msg) && $msg ? $msg : '' ?></p>
  
                  <form action="" method="post" id="login-form">
                      <div class="form-group has-feedback">
                          <label for="exampleFormControlInput1" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required="">
                          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                          <label for="exampleFormControlInput1" class="form-label">Password</label>
                          <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter your password" required="">
                          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block">Login</button>
                  </form>
              </div>
            </div>


          </div>
            <!-- /.login-box-body -->
          <div class='image-section'>
            <img 
              src="<?= base_url('assets/dist/img/login-image.png'); ?>" 
              class="login-image"
              alt="User Image"
            >
          </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('assets/jquery-validation/jquery.validate.js') ?>"></script>
        <script>
            $(function () {
                $("#login-form").validate({
                    errorElement: "em",
                    errorPlacement: function (error, element) {
                        // Add the `invalid-feedback` class to the error element
                        error.addClass("invalid-feedback");
                        if (element.prop("type") === "checkbox") {
                            error.insertAfter(element.next("label"));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass("is-invalid").removeClass("is-valid");
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).addClass("is-valid").removeClass("is-invalid");
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });
        </script>
    </body>
</html>