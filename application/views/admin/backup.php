<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/home/create_backup") ?>">Create Backup</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="user_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>File Size</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $files = directory_map('./db_backup/');
                            if ($files) {
                                asort($files);
                                $sl = 0;
                                foreach ($files as $file) {
                                    $sl++;
                                    if (is_string($file) && pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                                        ?>
                                        <tr>
                                            <td><?= $sl; ?></td>
                                            <td><?= $file; ?></td>
                                            <td><?= formatSizeUnits(filesize('./db_backup/' . $file)); ?></td>
                                            <td><?= date("Y-m-d h:i A", filemtime('./db_backup/' . $file)); ?></td>
                                            <td>
                                                <a class="label label-primary" href="<?= base_url("admin/home/download_backup/" . $file) ?>" data-toggle="tooltip" title="Download" style="margin-right: 5px;"><i class="fa fa-download"></i></a>
                                                <?php if ($privilege->delete_p) { ?>
                                                    <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/home/delete_backup/" . $file) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
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
        $('#user_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>