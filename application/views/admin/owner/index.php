<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/owner/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="user_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>User Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Wallet Amount</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 6%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($user_data) {
                                foreach ($user_data as $user) {
                                    $currency = $this->common_model->getSiteSettingByTitle('currency_symbol');
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $user->login_id ?></td>
                                        <td><?= $user->name ?></td>
                                        <td><?= $user->email; ?></td>
                                        <td><?= $user->mobile ?>
                                            <!--Verified: <label class="label label-<? $user->mobile_verified == '1' ? 'success' : 'danger'; ?>"><? $user->mobile_verified == '1' ? 'Yes' : 'No'; ?></label>-->
                                        </td>
                                        <td><?= $currency .' '. $user->wallet_balance; ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($user->created_date)) ?></td>
                                        <td><label class="label label-<?= $user->status ? 'success' : 'danger'; ?>"><?= $user->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/owner/edit/" . $user->user_id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/owner/delete/" . $user->user_id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="modal-user_documents" tabindex="-1" role="basic" aria-hidden="true"></div>
<script>
    $(function () {
        $('#user_tbl').DataTable();
        /*$('#user_tbl').DataTable({
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
         // Load data for the table's content from an Ajax source
         "ajax": {
         "url": '<? base_url('admin/user/ajax_list'); ?>',
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

    function user_documents(user_id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url("admin/user/user_documents") ?>',
            dataType: 'json',
            data: {user_id: user_id},
            success: function (_return_data) {
                $('#modal-user_documents').html(_return_data.view);
                $('#modal-user_documents').modal('show');
                return false;
            }
        });
    }
</script>