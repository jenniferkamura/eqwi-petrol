<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="user_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Ticket Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Query Detail</th>
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
                                        <td><?= $help->ticket_id ?></td>
                                        <td><?= $help->name ?></td>
                                        <td><?= $help->email ?></td>
                                        <td><?= $help->mobile ?></td>
                                        <td><?= $help->query_detail ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($help->created_date)) ?></td>
                                        <td><label class="label label-<?= $help->status ? 'success' : 'danger'; ?>"><?= $help->status ? 'Resolved' : 'Pending'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/help/ticket_edit/" . $help->id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
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