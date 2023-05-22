<?php
$this->load->view('admin/header');
$this->load->view('admin/side_menu');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $title ?> 
        </h1>
        <!--        <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Examples</a></li>
                    <li class="active">User profile</li>
                </ol>-->
    </section>
    <?php
    $this->load->view('_partials/messages');

    if (isset($view)) {
        $this->load->view($view);
    }
    ?>

</div>
<!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<?php
$this->load->view('admin/footer');
?>