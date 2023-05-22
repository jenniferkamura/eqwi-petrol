<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="product_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Log Type</th>
                                <th>Volunteer Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($logs_data) {
                                foreach ($logs_data as $log) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><b><?= $log->type ?></b></td>
                                        <td><?= $log->name ?></td>
                                        <td><?= $log->email ?></td>
                                        <td><?= $log->mobile ?></td>
                                        <td><?= date('d/m/Y', strtotime($log->date_time)) ?></td>
                                        <td><?= date('h:i A', strtotime($log->date_time)) ?></td>
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
        $('#product_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>