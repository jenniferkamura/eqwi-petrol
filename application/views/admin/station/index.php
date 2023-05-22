<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($privilege->add_p) { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/station/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="station_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Owner Name</th>
                                <th>Station Name</th>
                                <th>Contact Person</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>County</th>
                                <th>Address</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($station_data) {
                                foreach ($station_data as $station) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $station->name ?></td>
                                        <td><?= $station->station_name ?></td>
                                        <td>
                                            <?= $station->contact_person ?><br/>
                                            Mo: <b><?= $station->contact_number ?></b>
                                        </td>
                                        <td><?= $station->country ?></td>
                                        <td><?= $station->city; ?></td>
                                        <td><?= $station->state ?></td>
                                        <td><?= $station->address ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($station->created_date)) ?></td>
                                        <td><label class="label label-<?= $station->status ? 'success' : 'danger'; ?>"><?= $station->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php
                                            if (ALLOW_GOOGLE_MAPS) {
                                                ?>
                                                <a class="label label-warning" href="<?= base_url("maps/view/station/" . $station->station_id) ?>" target="_blank" data-toggle="tooltip" title="Map" style="margin-right: 5px;"><i class="fa fa-map-marker"></i></a>
                                                <?php
                                            }
                                            ?>
                                            <?php if ($privilege->edit_p) { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/station/edit/" . $station->station_id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                                <?php
                                            }
                                            if ($privilege->delete_p) {
                                                ?>
                                                <a class="label label-danger" href="javascript:void(0);" onclick="delete_action(this)" data-url="<?= base_url("admin/station/delete/" . $station->station_id) ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
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
        $('#station_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>