<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form id="feedback_frm" method="post" action="">
                            <div class="col-md-3">
                                <label>Transporter</label>
                                <select class="form-control select2" name="user_id">
                                    <option value=""></option>
                                    <?php
                                    if ($user_data) {
                                        foreach ($user_data as $user) {
                                            $sel_user = isset($user_id) && $user_id == $user->user_id ? 'selected=""' : '';
                                            ?>
                                            <option value="<?= $user->user_id ?>" <?= $sel_user ?>><?= $user->name . ' (' . $user->mobile . ')' ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>From Date</label>
                                <input type="text" class="form-control" id="from_date" name="from_date" placeholder="Select from date" value="<?= isset($from_date) && $from_date ? $from_date : '' ?>" readonly="">
                            </div>
                            <div class="col-md-2"> 
                                <label>To Date</label>
                                <input type="text" class="form-control" id="to_date" name="to_date" placeholder="Select to date" value="<?= isset($to_date) && $to_date ? $to_date : '' ?>" readonly="">
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <input class="form-control btn btn-primary" type="submit" value="Filter">
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <input class="form-control btn btn-default" type="button" value="Reset" onclick="location.href = '<?= base_url('admin/transporter/availability') ?>';">
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
                    <table id="user_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Employment Type</th>
                                <th>Not Available Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($not_available_data) {
                                foreach ($not_available_data as $not_available) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $not_available->name ?></td>
                                        <td><?= $not_available->email; ?></td>
                                        <td><?= $not_available->mobile ?></td>
                                        <td><?= $not_available->employment_type ?></td>
                                        <td><label class="text-danger"><?= date('d/m/Y', strtotime($not_available->set_date)) ?></label></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="<?= base_url('assets/bower_components/select2/dist/css/select2.min.css'); ?>">
<script src="<?= base_url('assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
<script>
    $(function () {
        $('.select2').select2({width: '100%', placeholder: 'Select Transporter'});
        $('#user_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();

        //Date picker
        $('#from_date').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
            endDate: "today"
        }).on('changeDate', function (e) {
            $('#to_date').datepicker('setStartDate', e.date);
        });
        $('#to_date').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
            startDate: "today"
        }).on('changeDate', function (e) {
            $('#from_date').datepicker('setEndDate', e.date);
        });
    });
</script>