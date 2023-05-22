<style>
    .tooltip{
        z-index: 0;
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form id="report_frm" method="post" action="">
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
                            <div class="col-md-2">
                                <label>From Date</label>
                                <input type="text" class="form-control" id="from_date" name="from_date" placeholder="Select from date" value="<?= isset($from_date) && $from_date ? $from_date : '' ?>" readonly="">
                            </div>
                            <div class="col-md-2"> 
                                <label>To Date</label>
                                <input type="text" class="form-control" id="to_date" name="to_date" placeholder="Select to date" value="<?= isset($to_date) && $to_date ? $to_date : '' ?>" readonly="">
                            </div>
                            <!--<div class="col-md-4"> 
                                <label>Date</label>
                                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>-->
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <input class="form-control btn btn-primary" type="submit" value="Filter">
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <input class="form-control btn btn-default" type="button" value="Reset" onclick="location.href = '<?= base_url('admin/reports') ?>';">
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="$('#report_frm').attr('action', '<?= base_url("admin/reports/export_csv") ?>');$('#report_frm').submit();$('#report_frm').attr('action', '');">Export in CSV</a>
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="$('#report_frm').attr('action', '<?= base_url("admin/reports/export_pdf") ?>');$('#report_frm').submit();$('#report_frm').attr('action', '');">Export in PDF</a>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
                    <table id="transaction_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Id</th>
                                <th>Name</th>
                                <th>Product</th>
                                <th>Shipping Charge</th>
                                <th>Tax</th>
                                <th>Amount</th>
                                <th>Total Amount</th>
                                <th>Total Pay Amount</th>
                                <th>Remaining Amount</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($transaction_data) {
                                foreach ($transaction_data as $transaction) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $transaction->order_id ?></td>
                                        <td><?= $transaction->name . ' (' . $transaction->mobile . ')' ?></td>
                                        <td><?= $transaction->product_name ?></td>
                                        <td><?= $transaction->currency .' '. $transaction->shipping_charge ?></td>
                                        <td><?= $transaction->currency .' '. $transaction->tax ?></td>
                                        <td>
                                            <?= $transaction->currency .' '. $transaction->amount ?>
                                            <?php
                                            if ($transaction->discount != 0.00) {
                                                echo '<br>Discount: ' . $transaction->currency .' '. $transaction->discount;
                                            }
                                            ?>
                                        </td>
                                        <td><?= $transaction->currency .' '. $transaction->total_amount ?></td>
                                        <td><?= $transaction->currency .' '. $transaction->trans_amount ?></td>
                                        <td><?= $transaction->currency .' '. $transaction->remaining_amt ?></td>
                                        <td><?= date('d/m/Y', strtotime($transaction->order_date)) ?></td>
                                        <td> 
                                            <a class="label label-warning" href="javascript:void(0);" onclick="order_view('<?= $transaction->id ?>')" data-toggle="tooltip" title="View Order Detail"><i class="fa fa-eye"></i></a>
                                        </td>
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
<div class="modal fade" id="modal-order_view"></div>
<div class="modal fade" id="modal-invoice_view"></div>

<link rel="stylesheet" href="<?= base_url('assets/bower_components/select2/dist/css/select2.min.css'); ?>">
<script src="<?= base_url('assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
<script>
                                                $(function () {
                                                    $('.select2').select2({width: '100%', placeholder: 'Select Owner'});
                                                    $('#transaction_tbl').DataTable();
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

                                                    /*var start = moment().subtract(29, 'days');
                                                     var end = moment();
                                                     
                                                     function cb(start, end) {
                                                     $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                                                     }
                                                     
                                                     $('#reportrange').daterangepicker({
                                                     startDate: start,
                                                     endDate: end,
                                                     ranges: {
                                                     'Today': [moment(), moment()],
                                                     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                                     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                                     'This Month': [moment().startOf('month'), moment().endOf('month')],
                                                     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                                     }
                                                     }, cb);
                                                     
                                                     cb(start, end);*/
                                                });

                                                function order_view(id) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '<?= base_url("admin/orders/view") ?>',
                                                        dataType: 'json',
                                                        data: {id: id},
                                                        success: function (_return_data) {
                                                            if (_return_data.status) {
                                                                $('#modal-order_view').html(_return_data.view);
                                                                $('#modal-order_view').modal('show');
                                                            }
                                                            return false;
                                                        }
                                                    });
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
                                                            }
                                                            return false;
                                                        }
                                                    });
                                                }
</script>