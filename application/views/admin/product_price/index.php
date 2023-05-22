<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/product_price/edit") ?>">Update Price</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row" style="padding-bottom: 10px;">
                        <form id="available_point_frm" method="post" action="">
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
                                <input class="form-control btn btn-default" type="button" value="Reset" onclick="location.href = '<?= base_url('admin/product_price') ?>';">
                            </div>
                        </form>
                    </div>
                    <table id="product_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Price Date</th>
                                <th>Created Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($product_price_data) {
                                foreach ($product_price_data as $product) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $product->name ?></td>
                                        <td><?= $this->common_model->getSiteSettingByTitle('currency_symbol') .' '. $product->price ?></td>
                                        <td><?= date('d/m/Y', strtotime($product->price_date)) ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($product->date_time)) ?></td>
                                        <td><label class="label label-<?= $product->status ? 'success' : 'danger'; ?>"><?= $product->status ? 'Active' : 'Inactive'; ?></label></td>
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
        $('#product_tbl').DataTable();
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