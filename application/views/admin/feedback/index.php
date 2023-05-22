<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form id="feedback_frm" method="post" action="">
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
                                <input class="form-control btn btn-default" type="button" value="Reset" onclick="location.href = '<?= base_url('admin/feedbacks') ?>';">
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="$('#feedback_frm').attr('action', '<?= base_url("admin/feedbacks/export_csv") ?>');$('#feedback_frm').submit();$('#feedback_frm').attr('action', '');">Export in CSV</a>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
                    <table id="feedback_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Rating</th>
                                <th>Description</th>
                                <th>Quick feedback</th>
                                <th>Created Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($feedback_data) {
                                foreach ($feedback_data as $feedback) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $feedback->name ?></td>
                                        <td>
                                            <?php
                                            if ($feedback->rating) {
                                                for ($k = 1; $k <= 5; $k++) {
                                                    if ($feedback->rating >= $k) {
                                                        ?>
                                                        <i class="fa fa-star text-yellow"></i>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <i class="fa fa-star text-gray"></i>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?= $feedback->description ?></td>
                                        <td><?= $feedback->quick_feedback ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($feedback->created_date)) ?></td>
                                        <td><label class="label label-success">Active</label></td>
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

<script>
    $(function () {
        $('#feedback_tbl').DataTable();
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
            endDate: "today"
        }).on('changeDate', function (e) {
            $('#from_date').datepicker('setEndDate', e.date);
        });
    });
</script>