<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/vehicle/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="vehicle_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Transporter Name</th>
                                <th>Vehicle Number</th>
                                <th>Vehicle Capacity</th>
                                <th>Measurement</th>
                                <th>Front Vehicle Photo</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($vehicle_data) {
                                foreach ($vehicle_data as $vehicle) {
                                    $vehicle_photo = getImage('vehicle_photo', $vehicle->front_vehicle_photo);
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td>
                                            <?= $vehicle->name ?><br/>
                                            Mo: <b><?= $vehicle->mobile ?></b>
                                        </td>
                                        <td><?= $vehicle->vehicle_number ?></td>
                                        <td><?= $vehicle->vehicle_capacity ?></td>
                                        <td><?= $vehicle->measurement ?></td>
                                        <td><img src="<?= $vehicle_photo ?>" style="width: 80px;height: 80px;"></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($vehicle->created_date)) ?></td>
                                        <td><label class="label label-<?= $vehicle->status ? 'success' : 'danger'; ?>"><?= $vehicle->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($privilege->list_p) { ?>
                                                <a class="label label-warning" href="<?= base_url("admin/vehicle/view/" . $vehicle->vehicle_id) ?>" data-toggle="tooltip" title="View" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>
                                                <?php
                                            }
                                            if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/vehicle/edit/" . $vehicle->vehicle_id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/vehicle/delete/" . $vehicle->vehicle_id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="modal-vehicle_documents" tabindex="-1" role="basic" aria-hidden="true"></div>
<script>
    $(function () {
        $('#vehicle_tbl').DataTable();
        /*$('#vehicle_tbl').DataTable({
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
         // Load data for the table's content from an Ajax source
         "ajax": {
         "url": '<? base_url('admin/vehicle/ajax_list'); ?>',
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