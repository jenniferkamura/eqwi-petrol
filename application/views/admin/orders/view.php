<div class="modal-dialog modal-lg" style="width: 90%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Order Detail</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="">
                        <div class="box-header with-border">
                            <h3 class="box-title">Order Id: &nbsp; #<?= isset($order_data) && $order_data->order_id ? $order_data->order_id : '' ?></h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input type="text" class="form-control" name="user_name" value="<?= isset($order_data) && $order_data->name ? $order_data->name : '' ?>" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="text" class="form-control" name="mobile" value="<?= isset($order_data) && $order_data->mobile ? $order_data->mobile : '' ?>" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Station</label>
                                        <input type="text" class="form-control" name="station_name" value="<?= isset($order_data) && $order_data->station_name ? $order_data->station_name : '' ?>" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label>Delivery Address</label>
                                        <input type="text" class="form-control" name="delivery_address" value="<?= isset($order_data) && $order_data->address ? $order_data->address : '' ?>" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <input type="text" class="form-control" name="payment_type" value="<?= isset($order_data) && $order_data->payment_type ? $order_data->payment_type : '' ?>" readonly="">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Date</label>
                                                <input type="text" class="form-control" name="order_date" value="<?= isset($order_data) && $order_data->order_date ? $order_data->order_date : '' ?>" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Delivery Date</label>
                                                <input type="text" class="form-control" name="delivery_date" value="<?= isset($order_data) && $order_data->delivery_date ? ($order_data->delivery_date . ($order_data->delivery_time ? ' ' . date('h:i A', strtotime($order_data->delivery_time)) : '')) : '' ?>" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Status</label>
                                                <input type="text" class="form-control" name="order_status" value="<?= isset($order_data) && $order_data->order_status ? $order_data->order_status : '' ?>" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Created Date</label>
                                                <input type="text" class="form-control" name="created_date" value="<?= isset($order_data) && $order_data->created_date ? date('Y-m-d h:i A', strtotime($order_data->created_date)) : '' ?>" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h4><b>Product Detail</b></h4><hr>
                                        <table id="order_detail_tbl" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Sr</th>
                                                    <th>Product Image</th>
                                                    <th>Product Name</th>
                                                    <th>Product Type</th>
                                                    <th>Measurement</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            //echo '<pre>';print_r($order_detail);
                                            if ($order_detail) {
                                                $sr = 1;
                                                foreach ($order_detail as $products) {
                                                    $product_image = getImage('product_image', $products->image);
                                                    ?> 
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $sr++ ?></td>
                                                            <td><img src="<?= $product_image ?>" style="width: 50px;height: 50px;"></td>
                                                            <td><?= $products->name ?></td>
                                                            <td><?= $products->type ?></td>
                                                            <td><?= $products->measurement ?></td>
                                                            <td><?= $products->qty ?></td>
                                                            <td><?= $products->currency . ' ' . number_format($products->price, 2) ?></td>
                                                            <td class="text-right"><?= number_format($products->total_price, 2) ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <tbody class="text-right">
                                                <tr>
                                                    <td colspan="7">Total Amount</td>
                                                    <td><?= isset($order_data) && $order_data->amount ? number_format($order_data->amount, 2) : '' ?></td>
                                                </tr>
                                                <?php if (isset($order_data) && round($order_data->discount)) { ?>
                                                    <tr>
                                                        <td colspan="7">Discount</td>
                                                        <td>-<?= number_format($order_data->discount, 2) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="7">Shipping Charge</td>
                                                    <td><?= isset($order_data) && $order_data->shipping_charge ? number_format($order_data->shipping_charge, 2) : '' ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">Tax</td>
                                                    <td><?= isset($order_data) && $order_data->tax ? number_format($order_data->tax, 2) : '' ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">Grand Total</td>
                                                    <td><?= isset($order_data) && $order_data->total_amount ? number_format($order_data->total_amount, 2) : '' ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <h4>
                                    <?php
                                    if ($payment_details) {
                                        $is_invoice
                                        ?>
                                        <b>Order Payment History</b>
                                        <?php if ($is_invoice == 0 && $remaining_payment) { ?>
                                            <span style="padding-left: 10px;">Remaining Amount : <b><?= $currency . ' ' . number_format($remaining_payment, 2) ?></b></span>
                                            <?php
                                        }
                                    } else {
                                        if ($remaining_payment) {
                                            ?>
                                            Remaining Amount : <b><?= $currency . ' ' . number_format($remaining_payment, 2) ?></b>
                                            <?php
                                        }
                                    }
                                    ?>
                                </h4>
                            </div>
                            <?php if ($payment_details) { ?>
                                <table id="order_detail_tbl" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr</th>
                                            <th>Transaction Id</th>
                                            <th>Amount</th>
                                            <th>Payment Type</th>
                                            <th>Transaction Type</th>
                                            <th>Payment Date</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    //echo '<pre>';print_r($assign_order_details);
                                    $sr = 1;
                                    foreach ($payment_details as $payment) {
                                        ?> 
                                        <tbody>
                                            <tr>
                                                <td><?= $sr++ ?></td>
                                                <td><?= $payment->payment_ref_id ?></td>
                                                <td><?= $payment->currency . ' ' . number_format($payment->amount, 2) ?></td>
                                                <td><?= $payment->payment_type ?></td>
                                                <td><?= $payment->transaction_type ?></td>
                                                <td><?= date('d/m/Y h:i A', strtotime($payment->payment_date)) ?></td>
                                                <td>
                                                    <label class="temp_change_status label label-<?= $payment->payment_status == 'Paid' ? 'success' : 'danger'; ?>"><?= $payment->payment_status ?></label>
                                                    <?php
                                                    if ($payment->is_invoice) {
                                                        /*
                                                        if ($payment->payment_status == 'Pending') {
                                                            ?>
                                                            <label id="temp_change_status" class="label label-success" style="display: none;">Paid</label>
                                                            &nbsp; <a class="temp_change_status label label-warning" href="javascript:void(0);" onclick="change_status('<?= $payment->order_id ?>')">Change to Paid</a>
                                                            <?php
                                                        } */
                                                        ?>
                                                        <?php /*
                                                          &nbsp; <a class="label label-primary" href="javascript:void(0);" onclick="invoice_view('<?= $payment->order_id ?>')">Invoice Detail</a>
                                                         */ ?>
                                                        &nbsp; <a class="label label-primary" href="javascript:void(0);" onclick="print_invoice('<?= $payment->order_id ?>')">Print Invoice</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                                <br/>
                                <div class="clearfix"></div>
                            <?php } ?>

                            <?php if ($assign_order_details) { ?>
                                <div class="form-group">
                                    <h4><b>Order History Track</b></h4><hr>
                                    <table id="order_detail_tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Description</th>
                                                <th>Date and Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        //echo '<pre>';print_r($assign_order_details);
                                        $sr = 1;
                                        foreach ($assign_order_details as $assign_order_detail) {
                                            $description = '';
                                            if ($assign_order_detail->order_status == 'New') {
                                                $description = 'New order';
                                            }
                                            if ($assign_order_detail->order_status == 'Pending') {
                                                $description = 'Order assigned to ' . $assign_order_detail->name;
                                            }
                                            if ($assign_order_detail->order_status == 'Accept') {
                                                $description = 'Order accepted by ' . $assign_order_detail->name;
                                            }
                                            if ($assign_order_detail->order_status == 'Reach') {
                                                $description = 'Transporter reached depot';
                                            }
                                            if ($assign_order_detail->order_status == 'Loaded') {
                                                $description = 'Transporter collected fuel';
                                            }
                                            if ($assign_order_detail->order_status == 'Delivered') {
                                                $description = 'Order delivered ';
                                                if ($order_data && $order_data->signature_file) {
                                                    $description .= '<a href="' . getImage('signature', $order_data->signature_file) . '" target="_blank">View Signature</a>';
                                                }
                                            }
                                            if ($assign_order_detail->order_status == 'Reject') {
                                                $description = 'Order rejected by ' . $assign_order_detail->name . '<br/>';
                                                $description .= $assign_order_detail->reason_title . ' : ' . $assign_order_detail->reason_description;
                                            }
                                            $date_time = date('d/m/Y h:i A', strtotime($assign_order_detail->date_time));

                                            $display_status = $assign_order_detail->order_status == 'Pending' ? 'Assigned' : $assign_order_detail->order_status;
                                            ?> 
                                            <tbody>
                                                <tr>
                                                    <td><?= $sr++ ?></td>
                                                    <td><?= $description ?></td>
                                                    <td><?= $date_time ?></td>
                                                    <td><?= $display_status ?></td>
                                                </tr>
                                            </tbody>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                    <div class="clearfix"></div>
                                </div> 
                            <?php } ?>

                            <?php
                            //echo '<pre>';print_r($assign_order);
                            $dis_assign = 0;
                            if (isset($assign_order) && $assign_order && $assign_order->assign_status == 'Reject') {
                                $dis_assign = 1;
                            } else {
                                if (isset($assign_order) && $order_data && ($order_data->order_status == 'Pending' || $assign_order->assign_status == 'New')) {
                                    $dis_assign = 1;
                                }
                            }

                            $dis_assign = $action_status == '' ? 0 : $dis_assign;

                            $dis_assign = $order_data && $order_data->order_status == 'Cancelled' ? 0 : $dis_assign;

                            //Transfer to another transporter
                            $order_status = isset($order_data) && $order_data->order_status ? $order_data->order_status : '';
                            if ($order_status != '' && ($order_status == 'Assigned' || $order_status == 'Accepted' || $order_status == 'Processing')) {
                                ?>
                                <a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="$('#assign-form').show();">Transferred to another</a>
                                <?php
                            }
                            ?>

                            <form action="" method="post" id="assign-form" style="<?= $dis_assign ? '' : 'display: none;' ?>">
                                <h4><b>Assign</b></h4><hr>

                                <div id="dis_manual" class="col-md-4">
                                    <label>Transporter Name</label> 
                                    <select name="transporter_name" class="form-control select2" required="">
                                        <option value=""></option>
                                        <?php
                                        if ($transporter_data) {

                                            $delivery_date = isset($order_data) && $order_data->delivery_date ? $order_data->delivery_date : '';

                                            foreach ($transporter_data as $transporter) {

                                                $availability = ' - Not Available';
                                                if ($this->common_model->getTransporterAvailability($transporter->user_id, $delivery_date)) {
                                                    $availability = ' - Available';
                                                }
                                                ?>
                                                <option value="<?= $transporter->user_id ?>"><?= $transporter->name . ' (' . $transporter->mobile . ')' . $availability ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <br/>
                                    <input type="hidden" name="action_status" value="<?= $action_status ?>">
                                    <input type="hidden" name="station_id" value="<?= isset($order_data) && $order_data->station_id ? $order_data->station_id : 0 ?>">
                                    <input type="hidden" name="order_id" value="<?= isset($order_data) && $order_data->id ? $order_data->id : 0 ?>">
                                    <input type="hidden" name="assign_order_id" value="<?= isset($assign_order) && $assign_order->id ? $assign_order->id : 0 ?>">
                                    <button type="submit" class="btn btn-success">Assign</button>
                                </div>
                            </form>

                            <?php if ($order_data && $order_data->receive_status) { ?>
                                <div class="form-group">
                                    <h4><b>Receive Order</b></h4><hr>
                                    <table id="order_detail_tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Quality of product</th>
                                                <th>Quantity of product</th>
                                                <th>Date and Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= 1 ?></td>
                                                <td><?= $order_data->quality_of_product ?></td>
                                                <td><?= $order_data->receive_qty ?></td>
                                                <td><?= date('d/m/Y h:i A', strtotime($order_data->receive_datetime)) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="clearfix"></div>
                                </div> 
                            <?php } ?>

                            <?php if ($order_data && $order_data->rating) { ?>
                                <div class="form-group">
                                    <h4><b>Order Rating & Review</b></h4><hr>
                                    <table id="order_detail_tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Transporter Name</th>
                                                <th>Rating</th>
                                                <th>Review</th>
                                                <th>Date and Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= 1 ?></td>
                                                <td><?php
                                                    if ($transporter = $this->db->get_where('user', ['user_id' => $order_data->transporter_id])->row()) {
                                                        echo $transporter->name . ' (' . $transporter->mobile . ')';
                                                    }
                                                    ?></td>
                                                <td>
                                                    <?php
                                                    if ($order_data->rating) {
                                                        for ($k = 1; $k <= 5; $k++) {
                                                            if ($order_data->rating >= $k) {
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
                                                <td><?= $order_data->review ?></td>
                                                <td><?= date('d/m/Y h:i A', strtotime($order_data->review_date)) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="clearfix"></div>
                                </div> 
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
    $('.select2').select2({width: '100%', placeholder: 'Select Transporter'});
    $("#assign-form").validate({
        errorElement: "em",
        /* rules: {
         email_id: {email: true,
         remote: {url: "<? base_url('admin/orders/check_transporter_exists') ?>", type: "post",
         data: {
         email_id: function () {
         return $('#email_id').val();
         }
         }
         }
         }
         },
         messages: {
         email_id: {remote: jQuery.validator.format("{0} is not register")}
         }, */
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
        submitHandler: function (form) {
            $('#assign-form').find('button[type=submit]').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?= base_url("admin/orders/assign_order") ?>',
                dataType: 'json',
                data: $(form).serialize(),
                success: function (_return_data) {
                    location.href = '<?= base_url("admin/orders/status/$action_status") ?>';
                    return false;
                }
            });
        }
    });

    function select_transporter(ref) {
        var _val = $(ref).val();
        if (_val == 'Manual') {
            $('#dis_manual').show();
            $('#dis_email').hide();
        } else {
            $('#dis_manual').hide();
            $('#dis_email').show();
        }
    }
</script>