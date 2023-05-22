<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php if ($menu_type == 'main') { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/main_menu/edit/0") ?>">Add</a>
                    <?php } else { ?>
                        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/sub_menu/edit/0") ?>">Add</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="menu_tbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php if ($menu_type == 'sub') { ?>
                                    <th>Main Menu</th>
                                <?php } ?>
                                <th>Menu Name</th>
                                <th>Menu Icon</th>
                                <th>Menu URL</th>
                                <th>Display Order</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($menu_data) {
                                foreach ($menu_data as $menu) {
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <?php if ($menu_type == 'sub') { ?>
                                            <td><?= $menu->menu_type ?></td>
                                        <?php } ?>
                                        <td><?= $menu->menu_name ?></td>
                                        <td><?= $menu->menu_icon; ?></td>
                                        <td><?= $menu->menu_url ?></td>
                                        <td><?= $menu->display_order ?></td>
                                        <td><?= date('d/m/Y h:i A', strtotime($menu->created_date)) ?></td>
                                        <td><label class="label label-<?= $menu->status ? 'success' : 'danger'; ?>"><?= $menu->status ? 'Active' : 'Inactive'; ?></label></td>
                                        <td>
                                            <?php if ($menu_type == 'main') { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/main_menu/edit/" . $menu->id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
                                            <?php } else { ?>
                                                <a class="label label-primary" href="<?= base_url("admin/sub_menu/edit/" . $menu->id) ?>" data-toggle="tooltip" title="Edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i></a>
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
        $('#menu_tbl').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>