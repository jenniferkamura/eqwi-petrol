<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                        <form id="search_frm" method="post" action="">
                            <div class="col-md-3">
                                <label>Transporter</label>
                                <select class="form-control select2" id="user_id" name="user_id">
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
                            <div class="col-md-2">
                                <label>Order Status</label>
                                <select class="form-control select2" id="status" name="status">
                                    <option value="">All</option>
                                    <option value="New" <?= isset($status) && $status == 'New' ? 'selected=""' : '' ?>>New</option>
                                    <option value="Pending" <?= isset($status) && $status == 'Pending' ? 'selected=""' : '' ?>>Pending</option>
                                    <option value="Assigned" <?= isset($status) && $status == 'Assigned' ? 'selected=""' : '' ?>>Assigned</option>
                                    <option value="Accepted" <?= isset($status) && $status == 'Accepted' ? 'selected=""' : '' ?>>Accepted</option>
                                    <option value="Processing" <?= isset($status) && $status == 'Processing' ? 'selected=""' : '' ?>>Processing</option>
                                    <option value="Rejected" <?= isset($status) && $status == 'Rejected' ? 'selected=""' : '' ?>>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <input class="form-control btn btn-primary" type="submit" value="Filter">
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <input class="form-control btn btn-default" type="button" value="Reset" onclick="location.href = '<?= base_url('admin/vehicle/availability') ?>';">
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
                    <table id="availability_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Order Id</th>
                                <th>Product</th>
                                <th>Total Capacity</th>
                                <th>Delivery Address</th>
                                <th>Delivery Date</th>
                                <th>Transporter</th>
                                <th>Vehicle Capacity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($order_data) {
                                foreach ($order_data as $order) {

                                    $transporter_name = $order->name . ($order->mobile ? ' (' . $order->mobile . ')' : '');
                                    
                                    $address = '';
                                    if($order->address){
                                        $address = $order->address . ' ' . $order->city . ', ' . $order->state . ', ' . $order->country;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $order->order_id ?></td>
                                        <td><?= $order->product_name; ?></td>
                                        <td><?= $order->total_qty ?></td>
                                        <td><?= $order->station_name ?>
                                            <br><?= $address ?>
                                        </td>
                                        <td><?= date('d/m/Y h:i A', strtotime($order->delivery_date . ' ' . $order->delivery_time)) ?></td>
                                        <td><?= $transporter_name ?></td>
                                        <td><?= $order->vehicle_capacity ?></td>
                                        <td><label class="label label-<?= ($order->order_status == 'New' || $order->order_status == 'Pending') ? 'danger' : 'success'; ?>"><?= $order->order_status ?></label></td>
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
                                        $('#user_id').select2({width: '100%', placeholder: 'Select Transporter'});
                                        $('#status').select2({width: '100%', placeholder: 'All'});
                                        $('#availability_tbl').DataTable();
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