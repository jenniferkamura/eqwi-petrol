<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/coupon/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="coupon_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Coupon Title</th>
                                <th>Coupon Code</th>
                                <th>Description</th>
                                <!--<th>Product Name</th>-->
                                <th>Start Date</th>
                                <th>Expiry Date</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($coupon_data) {
                                foreach ($coupon_data as $coupon) {
                                    
                                    $product_data = json_decode($coupon->product_data);
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $coupon->coupon_title ?></td>
                                        <td><?= $coupon->coupon_code ?></td>
                                        <td><?= $coupon->description ?></td>
                                        <?php /*
                                        <td><?= $product_data ? $product_data->name : '' ?></td> */ ?>
                                        <td><?= date('d/m/Y', strtotime($coupon->start_date)) ?></td>
                                        <td><?= date('d/m/Y', strtotime($coupon->end_date)) ?></td>
                                        <td><?= $coupon->is_discount ? 'Discount ' . ($coupon->discount .' on '. $coupon->on_amount) . ' amount' : '' ?></td>
                                        <td><label class="label label-<?= $coupon->status ? 'success' : 'danger'; ?>"><?= $coupon->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/coupon/edit/" . $coupon->coupon_id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/coupon/delete/" . $coupon->coupon_id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#coupon_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>