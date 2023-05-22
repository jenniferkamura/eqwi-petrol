<style>
    .tooltip{
        z-index: 0;
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?php /*
                      <table id="transaction_tbl" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th>#</th>
                      <th>Order Id</th>
                      <th>User Name</th>
                      <th>Station</th>
                      <th>Delivery Address</th>
                      <th>Total Amount</th>
                      <th>Order Status</th>
                      <th>Order Date</th>
                      <th>Delivery Date</th>
                      <th>Payment Type</th>
                      <th>Created</th>
                      <th style="width: 6%;">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i = 1;
                      if ($order_data) {
                      foreach ($order_data as $order) {
                      ?>
                      <tr>
                      <td><?= $i++; ?></td>
                      <td>#<?= $order->order_id ?></td>
                      <td><?= $order->name ?></td>
                      <td><?= $order->station_name ?></td>
                      <td><?= $order->address ?></td>
                      <td><?= $order->total_amount ?></td>
                      <td><?= $order->order_status ?></td>
                      <td><?= $order->order_date ?></td>
                      <td><?= $order->delivery_date . ($order->delivery_time ? ' '. date('h:i A', strtotime($order->delivery_time)) : '') ?></td>
                      <td><?= $order->payment_type ?></td>
                      <td><?= date('Y-m-d h:i A', strtotime($order->created_date)) ?></td>
                      <td>
                      <a class="label label-warning" href="javascript:void(0);" onclick="order_view('<?= $order->id ?>')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye"></i></a>
                      </td>
                      </tr>
                      <?php
                      }
                      }
                      ?>
                      </tbody>
                      </table>
                     */ ?>

                    <div class="tab" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist"> 
                            <li role="presentation" class="<?= $order_status == 'New' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/New') ?>">New (<?= $order_new ?>)</a>
                            </li>
                            <li role="presentation" class="<?= $order_status == 'Pending' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Pending') ?>">Pending (<?= $order_pending ?>)</a>
                            </li>
                            <li role="presentation" class="<?= $order_status == 'Assigned' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Assigned') ?>">Assigned (<?= $order_assigned ?>)</a>
                            </li>
                            <li role="presentation" class="<?= $order_status == 'Accepted' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Accepted') ?>">Accepted (<?= $order_accepted ?>)</a>
                            </li>
                            <li role="presentation" class="<?= $order_status == 'Processing' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Processing') ?>">Processing (<?= $order_processing ?>)</a>
                            </li>
                            <?php /*
                            <li role="presentation" class="<?= $order_status == 'Delivered' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Delivered') ?>">Delivered (<?= $order_delivered ?>)</a>
                            </li> */ ?>
                            <li role="presentation" class="<?= $order_status == 'Completed' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Completed') ?>">Completed (<?= $order_completed ?>)</a>
                            </li>
                            <li role="presentation" class="<?= $order_status == 'Rejected' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Rejected') ?>">Rejected (<?= $order_rejected ?>)</a>
                            </li>
                            <li role="presentation" class="<?= $order_status == 'Cancelled' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/orders/status/Cancelled') ?>">Cancelled (<?= $order_cancelled ?>)</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs">
                            <div role="tabpanel" class="tab-pane fade in active" id="new">
                                <div class="row">
                                    <form id="order_frm" method="get" action="">
                                        <br/>
                                        <div class="col-md-2">
                                            <label>Search Order Id</label>
                                            <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Enter order id" value="<?= isset($order_id) && $order_id ? $order_id : '' ?>">
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
                                            <input class="form-control btn btn-default" type="button" value="Reset" onclick="location.href = '<?= base_url('admin/orders/status/' . $order_status) ?>';">
                                        </div>
                                    </form>
                                    <div class="clearfix"></div>
                                    <br/>
                                </div>
                            </div>
                            <?php
                            $i = 1;
                            if ($order_data) {
                                foreach ($order_data as $order) {
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><?= $order->station_name ?></h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-10">
                                                        <span><strong>Order Id:</strong>
                                                            <span>#<?= $order->order_id ?></span>
                                                        </span>
                                                        <span><strong>Name:</strong>
                                                            <span><?= $order->name ?></span>
                                                        </span>
                                                        <span><strong>Total Amount:</strong>
                                                            <span><?= $order->total_amount ?></span>
                                                        </span>
                                                        <span><strong>Order Status:</strong>
                                                            <span><?= $order->order_status ?></span>
                                                        </span>
                                                        <span><strong>Payment Type:</strong>
                                                            <span><?= $order->payment_type ?></span>
                                                        </span>
                                                        <span><strong>Created Date:</strong>
                                                            <span><?= date('Y-m-d h:i A', strtotime($order->created_date)) ?></span>
                                                        </span>
                                                        <br/>
                                                        <span><strong>Order Date:</strong>
                                                            <span><?= $order->order_date ?></span>
                                                        </span>
                                                        <span><strong>Delivery Date:</strong>
                                                            <span><?= $order->delivery_date . ($order->delivery_time ? ' ' . date('h:i A', strtotime($order->delivery_time)) : '') ?></span>
                                                        </span>
                                                        <br/>
                                                        <span><strong>Delivery Address:</strong>
                                                            <span><?= $order->address ?></span>
                                                        </span>
                                                    </div>  
                                                    <div class="col-md-2">
                                                        <a class="btn btn-block btn-success" href="javascript:void(0);" onclick="order_view('<?= $order->id ?>')">Order Details</a>
                                                        <?php if ($order->order_status == 'New' || $order->order_status == 'Pending' || $order->order_status == 'Rejected') { ?> 
                                                            <a class="btn btn-block btn-danger" href="javascript:void(0);" onclick="cancel_order('<?= $order->id ?>')">Cancel Order</a>
                                                        <?php } ?>
        <!--<i class="fa fa-map-marker fa-lg text-green"></i>--> 
        <!--<a class="btn btn-block btn-success" target="_blank" href="https://maps.google.com/maps?saddr=<? $item->restaurant_lat ?>,<?= $item->restaurant_lng ?>&daddr=<?= $item->delivery_lat ?>,<?= $item->delivery_lng ?>" >Directions</a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div>No data found</div>';
                            }
                            echo $links;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal-order_view"></div>
<div class="modal fade" id="modal-invoice_view"></div>
<div class="modal fade" id="modal-print_invoice"></div>

<link rel="stylesheet" href="<?= base_url('assets/bower_components/select2/dist/css/select2.min.css'); ?>">
<script src="<?= base_url('assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
<script>
                                                                $(function () {
                                                                    //$('#transaction_tbl').DataTable();
                                                                    //$('[data-toggle="tooltip"]').tooltip();

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

                                                                function order_view(id) {
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: '<?= base_url("admin/orders/view") ?>',
                                                                        dataType: 'json',
                                                                        data: {id: id, order_status: '<?= $order_status ?>'},
                                                                        success: function (_return_data) {
                                                                            if (_return_data.status) {
                                                                                $('#modal-order_view').html(_return_data.view);
                                                                                $('#modal-order_view').modal('show');
                                                                            }
                                                                            return false;
                                                                        }
                                                                    });
                                                                }

                                                                function cancel_order(id) {
                                                                    if (confirm("Are you sure, you want to cancel this order?")) {
                                                                        location.href = '<?= base_url("admin/orders/cancel_order") ?>/' + id + '/<?= $order_status ?>';
                                                                    }
                                                                }

                                                                function change_status(id) {
                                                                    if (confirm("Are you sure, you want to change status pending to paid?")) {
                                                                        $('.temp_change_status').remove();
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: '<?= base_url("admin/orders/change_status") ?>',
                                                                            dataType: 'json',
                                                                            data: {id: id},
                                                                            success: function (_return_data) {
                                                                                if (_return_data.status == '1') {
                                                                                    $('.temp_change_status').remove();
                                                                                    $('#temp_change_status').show();
                                                                                }
                                                                                return false;
                                                                            }
                                                                        });
                                                                    }
                                                                }

                                                                function invoice_view(id) {
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: '<?= base_url("admin/orders/invoice_view") ?>',
                                                                        dataType: 'json',
                                                                        data: {id: id},
                                                                        success: function (_return_data) {
                                                                            if (_return_data.status) {
                                                                                $('#modal-invoice_view').html(_return_data.view);
                                                                                $('#modal-invoice_view').modal('show');
                                                                                $('#modal-order_view').css('overflow', 'auto');
                                                                            }
                                                                            return false;
                                                                        }
                                                                    });
                                                                }

                                                                function print_invoice(id) {
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: '<?= base_url("admin/orders/print_invoice") ?>',
                                                                        dataType: 'json',
                                                                        data: {id: id},
                                                                        success: function (_return_data) {
                                                                            if (_return_data.status) {
                                                                                $('#modal-print_invoice').html(_return_data.view);
                                                                                $('#modal-print_invoice').modal('show');
                                                                                $('#modal-invoice_view').css('overflow', 'auto');

                                                                                // define the html element to export
                                                                                var element = document.getElementById('invoice_html');
                                                                                // define optional configuration
                                                                                var options = {filename: 'invoice_' + id + '.pdf'};

                                                                                // create an instance of html2pdf class
                                                                                var exporter = new html2pdf(element, options);
                                                                                // download the pdf
                                                                                exporter.getPdf(true).then((pdf) => {
                                                                                    //console.log('pdf downloaded!', pdf);
                                                                                });

                                                                                // or download it directly without instancing the class object
                                                                                options.source = element;
                                                                                options.download = false;

                                                                                html2pdf.getPdf(options).then((pdf) => {
                                                                                    //console.log(pdf.output('datauristring'));
                                                                                    <?php /*
                                                                                    $.ajax({
                                                                                        type: 'POST',
                                                                                        url: '<?= base_url("admin/orders/save_print_invoice") ?>',
                                                                                        dataType: 'json',
                                                                                        data: {
                                                                                            json: pdf.output('datauristring'),
                                                                                            id: '<?= $order_data && $order_data->id ? $order_data->id : '' ?>'
                                                                                        },
                                                                                        success: function (_result) {

                                                                                        }
                                                                                    }); */ ?>
                                                                                });
                                                                            }
                                                                            return false;
                                                                        }
                                                                    });
                                                                }
</script>

<script src="<?= base_url('assets/dist/js/htmltopdf.js') ?>"></script>