<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/product/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="product_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Product Type</th>
                                <th>Measurement</th>
                                <th>Minimum Order Qty</th>
                                <th>Display Order</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($product_data) {
                                foreach ($product_data as $product) {
                                    $product_image = getImage('product_image', $product->image);
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><img src="<?= $product_image ?>" style="width: 50px;height: 50px;"></td>
                                        <td><?= $product->name ?></td>
                                        <td><?= $product->type ?></td>
                                        <td><?= $product->measurement ?></td>
                                        <td><?= $product->minimum_order_qty ?></td>
                                        <td><?= $product->display_order ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($product->created_date)) ?></td>
                                        <td><label class="label label-<?= $product->status ? 'success' : 'danger'; ?>"><?= $product->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/product/edit/" . $product->category_id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/product/delete/" . $product->category_id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#product_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>