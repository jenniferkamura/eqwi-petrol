<?php
$currency = $this->common_model->getSiteSettingByTitle('currency_symbol');
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/vendor_purchase/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="vendor_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Invoice No</th>
                                <th>Product Name</th>
                                <th>Product Type</th>
                                <th>Vendor Name</th>
                                <th>Vendor Email</th>
                                <th>Vendor Mobile</th>
                                <th>Amount</th>
                                <th>Invoice Attachment</th>
                                <th>Invoice Date</th>
                                <!--<th>Inward Date</th>-->
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($vendor_purchase) {
                                foreach ($vendor_purchase as $purchase) {
                                    $product_data = $purchase->product_data ? json_decode($purchase->product_data) : array();
                                    $vandor_data = $purchase->vendor_data ? json_decode($purchase->vendor_data) : array();
                                    $invoice_image = getImage('invoice_image', $purchase->invoice_attach);
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $purchase->invoice_no ?></td>
                                        <td><?= $product_data ? $product_data->name : '' ?></td>
                                        <td><?= $product_data ? $product_data->type : '' ?></td>
                                        <td><?= $vandor_data ? $vandor_data->name : '' ?></td>
                                        <td><?= $vandor_data ? $vandor_data->email : '' ?></td>
                                        <td><?= $vandor_data ? $vandor_data->mobile : '' ?></td>
                                        <td><?= $currency .' '. $purchase->amount ?></td>
                                        <td><img src="<?= $invoice_image ?>" style="width: 50px;height: 50px;"></td>
                                        <td><?= date('d/m/Y', strtotime($purchase->invoice_date)) ?></td>
                                        <?php /*
                                        <td><?= date('d/m/Y', strtotime($purchase->inward_date)) ?></td>
                                         */ ?> 
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/vendor_purchase/edit/" . $purchase->id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/vendor_purchase/delete/" . $purchase->id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
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
<script>
    $(function () {
        $('#vendor_tbl').DataTable();
        /*$('#vendor_tbl').DataTable({
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
         // Load data for the table's content from an Ajax source
         "ajax": {
         "url": '<? base_url('admin/vendor/ajax_list'); ?>',
         "type": "POST",
         },
         
         //Set column definition initialisation properties.
         "columnDefs": [
         {
         "targets": [0, 1], //first column / numbering column
         "orderable": false, //set not orderable
         },
         ],
         "lengthMenu": [[10, 50, 100, 250, 500, -1], [10, 50, 100, 250, 500, "All"]]
         });*/
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>