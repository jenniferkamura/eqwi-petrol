<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= PROJECT_NAME; ?> | <?= $title ?></title>
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
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= base_url('assets/dist/css/skins/_all-skins.min.css'); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'); ?>">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css'); ?>">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">  
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="<?= base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css'); ?>">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <!-- jQuery 3 -->
        <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <style>
            .error{
                color: red;
                margin-bottom: 0px;
                font-size: 12px;
                font-style: 500;
            }
            .required{
                color: red;
            }
            .select2-container .select2-selection--single{
                height: 32px !important;
            }
        </style>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?= base_url() ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>EP</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b><?= PROJECT_NAME ?></b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <?php
                                    $unread_alert = $this->common_model->getUnreadAdmnNotifications();
                                    if ($unread_alert) {

                                        $this->db->where('admin_id', $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id);
                                        $alert = $this->db->get('admin')->row()->unread_alert;

                                        $this->db->where('admin_id', $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id);
                                        $this->db->update('admin', array('unread_alert' => $unread_alert));

                                        if ($unread_alert > $alert) {
                                            $this->session->set_flashdata('admin_alert', $unread_alert);
                                        }
                                    }

                                    if ($this->session->flashdata('admin_alert')) {
                                        $this->session->set_flashdata('admin_alert', 0);
                                        ?>
                                        <script>
                                            var audio = new Audio('<?= base_url('assets/sounds/bigbox.mp3') ?>');
                                            audio.play();
                                        </script>
                                        <?php
                                    }
                                    ?>
                                    <span class="label label-warning"><?= $unread_alert ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!--<li class="header">You have 10 notifications</li>-->
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php
                                            if ($notifications = $this->common_model->getAllNotifications(10)) {
                                                foreach ($notifications as $notification) {
                                                    ?>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-warning text-yellow"></i> <?= $notification->message ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="<?= base_url('admin/admin_notifications/alert') ?>">View all</a></li>
                                </ul>
                            </li>                              

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs">Admin</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?= base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
                                        <p><a href="<?= base_url('admin/home/profile') ?>" style="color: white;">Profile</a></p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= base_url('admin/change_password') ?>" class="btn btn-default btn-flat">Change Password</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/home/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
