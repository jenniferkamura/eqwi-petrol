<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/boarding_slider/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="slider_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Display Order</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($slider_data) {
                                foreach ($slider_data as $slider) {
                                    $slider_image = getImage('boarding_slider', $slider->image);
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><img src="<?= $slider_image ?>" style="width: 80px;"></td>
                                        <td><?= $slider->title ?></td>
                                        <td><?= $slider->description ?></td>
                                        <td><?= $slider->display_order ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($slider->created_date)) ?></td>
                                        <td><label class="label label-<?= $slider->status ? 'success' : 'danger'; ?>"><?= $slider->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/boarding_slider/edit/" . $slider->slider_id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/boarding_slider/delete/" . $slider->slider_id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#slider_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>