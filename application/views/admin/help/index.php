<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/help/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="user_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Display Order</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 6%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($help_data) {
                                foreach ($help_data as $help) {
                                    ?> 
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $help->question ?></td>
                                        <td><?= $help->answer ?></td>
                                        <td><?= $help->display_order ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($help->created_date)) ?></td>
                                        <td><label class="label label-<?= $help->status ? 'success' : 'danger'; ?>"><?= $help->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/help/edit/" . $help->id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/help/delete/" . $help->id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#user_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>