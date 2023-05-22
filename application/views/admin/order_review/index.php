<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form id="co2_averted_frm" method="post" action="">
                            <div class="col-md-3">
                                <label>Owner</label>
                                <select class="form-control select2" id="user_id" name="user_id">
                                    <option value=""></option>
                                    <?php
                                    if ($user_data) {
                                        foreach ($user_data as $owner) {
                                            $sel_user = isset($user_id) && $user_id == $owner->user_id ? 'selected=""' : '';
                                            ?>
                                            <option value="<?= $owner->user_id ?>" <?= $sel_user ?>><?= $owner->name . ' (' . $owner->mobile . ')'; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Transporter</label>
                                <select class="form-control select2" id="transporter_id" name="transporter_id">
                                    <option value=""></option>
                                    <?php
                                    if ($transporter_data) {
                                        foreach ($transporter_data as $transporter) {
                                            $sel_transporter = isset($transporter_id) && $transporter_id == $transporter->user_id ? 'selected=""' : '';
                                            ?>
                                            <option value="<?= $transporter->user_id ?>" <?= $sel_transporter ?>><?= $transporter->name . ' (' . $transporter->mobile . ')'; ?></option>
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
                                <input class="form-control btn btn-default" type="button" value="Reset" onclick="location.href = '<?= base_url('admin/order_reviews') ?>';">
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
                    <table id="order_review_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Owner Name</th>
                                <th>Transporter Name</th>
                                <th>Order Id</th>
                                <th>Amount</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Review Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($order_review_data) {
                                foreach ($order_review_data as $order_review) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $order_review->owner_name .' ('. $order_review->owner_mobile . ')' ?></td>
                                        <td><?= $order_review->transporter_name . ' (' . $order_review->transporter_mobile . ')' ?></td>
                                        <td><?= $order_review->order_id ?></td>
                                        <td><?= $order_review->currency .' '. $order_review->total_amount ?></td>
                                        <td>
                                            <?php
                                            if ($order_review->rating) {
                                                for ($k = 1; $k <= 5; $k++) {
                                                    if ($order_review->rating >= $k) {
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
                                        <td><?= $order_review->review ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($order_review->review_date)) ?></td>
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
                                        $('.select2').select2({width: '100%', placeholder: 'Select Owner'});
                                        $('#order_review_tbl').DataTable();
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