<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/sub_admin/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="sub_admin_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email Id</th>
                                <th>Role Name</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($sub_admin_data) {
                                foreach ($sub_admin_data as $sub_admin) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $sub_admin->full_name ?></td>
                                        <td><?= $sub_admin->email_id ?></td>
                                        <td><?= $sub_admin->role_name ?></td>
                                        <td><?= date('Y-m-d h:i A', strtotime($sub_admin->creation_datetime)) ?></td>
                                        <td><label class="label label-<?= $sub_admin->status ? 'success' : 'danger'; ?>"><?= $sub_admin->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/sub_admin/edit/" . $sub_admin->admin_id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/sub_admin/delete/" . $sub_admin->admin_id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#sub_admin_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>