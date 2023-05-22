<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/setting/reject_reason_edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="reject_reason_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Title</th>
                                <th>Display Order</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 6%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($reject_reason_data) {
                                foreach ($reject_reason_data as $reject_reason) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $reject_reason->title ?></td>
                                        <td><?= $reject_reason->display_order; ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($reject_reason->created_date)) ?></td>
                                        <td><label class="label label-<?= $reject_reason->status ? 'success' : 'danger'; ?>"><?= $reject_reason->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/setting/reject_reason_edit/" . $reject_reason->id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/setting/reject_reason_delete/" . $reject_reason->id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#reject_reason_tbl').DataTable();
        /*$('#reject_reason_tbl').DataTable({
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
         // Load data for the table's content from an Ajax source
         "ajax": {
         "url": '<? base_url('admin/setting/reject_reason_ajax_list'); ?>',
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