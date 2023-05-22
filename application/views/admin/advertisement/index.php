<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/advertisement/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="ads_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Display Advertisement</th>
                                <th>Display Order</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($ads_data) {
                                foreach ($ads_data as $ads) {
                                    $ads_image = getImage('advertisement', $ads->image);
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><img src="<?= $ads_image ?>" style="width: 80px;"></td>
                                        <td><?= $ads->title ?></td>
                                        <td><?= $ads->description ?></td>
                                        <td><?= $ads->advertisement_type ?></td>
                                        <td><?= $ads->display_order ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($ads->created_date)) ?></td>
                                        <td><label class="label label-<?= $ads->status ? 'success' : 'danger'; ?>"><?= $ads->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/advertisement/edit/" . $ads->id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/advertisement/delete/" . $ads->id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#ads_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>