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
                                <th>User Name</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($notification_data) {
                                foreach ($notification_data as $notification) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $notification->name . ' (' . $notification->mobile . ')'; ?></td>
                                        <td><?= $notification->title; ?></td>
                                        <td><?= $notification->message ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($notification->date_time)) ?></td>
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
        //$('[data-toggle="tooltip"]').tooltip();
    });
</script>