
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets/bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- Morris.js charts -->
<script src="<?= base_url('assets/bower_components/raphael/raphael.min.js'); ?>"></script>
<script src="<?= base_url('assets/bower_components/morris.js/morris.min.js'); ?>"></script>
<!-- Sparkline -->
<script src="<?= base_url('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'); ?>"></script>
<!-- DataTables -->
<script src="<?= base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url('assets/bower_components/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<!-- datepicker -->
<script src="<?= base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?= base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?= base_url('assets/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
<!-- bootstrap time picker -->
<script src="<?= base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<script src="<?= base_url('assets/jquery-validation/jquery.validate.js') ?>"></script>
<script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
<script type="text/javascript">

    $(".show-password").on('click', function () {
        var passwordId = $(this).parents('.chk_password').find('input').attr('id');
        if ($(this).find('i').hasClass('fa-eye-slash')) {
            $("#" + passwordId).attr("type", "text");
            $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            $("#" + passwordId).attr("type", "password");
            $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    function delete_action(ref) {
        var _url = $(ref).attr('data-url');
        if (confirm("Are you sure, you want to delete?")) {
            location.href = _url;
        }
    }
    function blockSpecialChar(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return (((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57)) && (k > 31 && (k < 48 || k > 57) && !(k == 46 || k == 8)));
    }
    function allowNumbers(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k >= 48 && k <= 57));
    }
    setTimeout(function () {
        $('.alert-success').fadeOut('fast');
        $('.alert-danger').fadeOut('fast');
    }, 3000);
    
</script>
</body>
</html>