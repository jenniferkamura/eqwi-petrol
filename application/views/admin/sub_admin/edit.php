<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="sub_admin-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="full_name" placeholder="Enter name" value="<?= isset($admin_details->full_name) && $admin_details->full_name ? $admin_details->full_name : '' ?>" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" id="role_id" name="role_id" required="">
                                        <option value="">--Select Role--</option>
                                        <?php
                                        if ($role_data) {
                                            foreach ($role_data as $role) {
                                                $sel_role = isset($admin_details->role_id) && $admin_details->role_id == $role->id ? 'selected=""' : '';
                                                ?>
                                                <option value="<?= $role->id ?>" <?= $sel_role ?>><?= $role->role_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="0" <?= isset($admin_details->status) && $admin_details->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                                        <option value="1" <?= isset($admin_details->status) && $admin_details->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (empty($admin_details)) { ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Enter email" value="<?= isset($admin_details->email_id) && $admin_details->email_id ? $admin_details->email_id : '' ?>" required="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="" required="" autocomplete="off">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="table-responsive">
                            <h4 class="box-title">Sub Admin Rights</h4>
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>Main Menu</th>
                                        <th>Sub Menu</th>
                                        <th><center><input type="checkbox" id="check_all_menu" value="1"> Menu Privilege</center></th>
                                <th><center><input type="checkbox" id="check_all_add" value="1"> Add Privilege</center></th>
                                <th><center><input type="checkbox" id="check_all_edit" value="1"> Edit Privilege</center></th>
                                <th><center><input type="checkbox" id="check_all_delete" value="1"> Delete Privilege</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //echo '<pre>';print_r($menu_items);
                                    $sno = 1;
                                    if (isset($menu_items) && $menu_items) {
                                        foreach ($menu_items as $mval) {
                                            # code...
                                            ?>
                                            <tr>
                                                <td><?= $mval->menu_name ?></td>
                                                <td>&nbsp;</td>
                                                <td><center>
                                            <input type="checkbox" class="check_menu" name="mpriv[<?= $mval->id ?>][list_p]" value="1" <?= $mval->list_p == 1 ? 'checked=""' : '' ?> />
                                        </center></td>
                                        <td><center>
                                            <input type="checkbox" class="check_add" name="mpriv[<?= $mval->id ?>][add_p]" value="1" <?= $mval->add_p == 1 ? 'checked=""' : '' ?> />
                                        </center></td>
                                        <td><center>
                                            <input type="checkbox" class="check_edit" name="mpriv[<?= $mval->id ?>][edit_p]" value="1" <?= $mval->edit_p == 1 ? 'checked=""' : '' ?> />
                                        </center></td>
                                        <td><center>
                                            <input type="checkbox" class="check_delete" name="mpriv[<?= $mval->id ?>][delete_p]" value="1" <?= $mval->delete_p == 1 ? 'checked=""' : '' ?> />
                                        </center></td>
                                        </tr>
                                        <input type="hidden" name="mpriv[<?= $mval->id ?>][menu_type]" value="<?= $mval->menu_type ?>" />
                                        <input type="hidden" name="mpriv[<?= $mval->id ?>][menu_id]" value="<?= $mval->id ?>" />
                                        <input type="hidden" name="mpriv[<?= $mval->id ?>][menu_name]" value="<?= $mval->menu_name ?>" />
                                        <input type="hidden" name="mpriv[<?= $mval->id ?>][menu_url]" value="<?= $mval->menu_url ?>" />
                                        <input type="hidden" name="mpriv[<?= $mval->id ?>][admin_id]" value="<?= isset($admin_details->admin_id) && $admin_details->admin_id ? $admin_details->admin_id : 0 ?>" />
                                        <input type="hidden" name="mpriv[<?= $mval->id ?>][id]" value="<?= $mval->pid ?>" />
                                        <?php
                                        foreach ($mval->sub_menu as $sval) {
                                            # code...
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td><?= $sval->menu_name ?></td>
                                                <td><center>
                                                <input type="checkbox" class="check_menu" name="spriv[<?= $sval->id ?>][list_p]" value="1" <?= $sval->list_p == 1 ? 'checked=""' : '' ?> />
                                            </center></td>
                                            <td><center>
                                                <input type="checkbox" class="check_add" name="spriv[<?= $sval->id ?>][add_p]" value="1" <?= $sval->add_p == 1 ? 'checked=""' : '' ?> />
                                            </center></td>
                                            <td><center>
                                                <input type="checkbox" class="check_edit" name="spriv[<?= $sval->id ?>][edit_p]" value="1" <?= $sval->edit_p == 1 ? 'checked=""' : '' ?> />
                                            </center></td>
                                            <td><center>
                                                <input type="checkbox" class="check_delete" name="spriv[<?= $sval->id ?>][delete_p]" value="1" <?= $sval->delete_p == 1 ? 'checked=""' : '' ?> />
                                            </center></td>
                                            </tr>
                                            <input type="hidden" name="spriv[<?= $sval->id ?>][menu_type]" value="<?= $sval->menu_type ?>" />
                                            <input type="hidden" name="spriv[<?= $sval->id ?>][menu_id]" value="<?= $sval->id ?>" />
                                            <input type="hidden" name="spriv[<?= $sval->id ?>][menu_name]" value="<?= $sval->menu_name ?>" />
                                            <input type="hidden" name="spriv[<?= $sval->id ?>][menu_url]" value="<?= $sval->menu_url ?>" />
                                            <input type="hidden" name="spriv[<?= $sval->id ?>][admin_id]" value="<?= isset($admin_details->admin_id) && $admin_details->admin_id ? $admin_details->admin_id : 0 ?>" />
                                            <input type="hidden" name="spriv[<?= $sval->id ?>][id]" value="<?= $sval->pid ?>" />
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Main Menu</th>
                                        <th>Sub Menu</th>
                                        <th><center>Menu Privilege</center></th>
                                <th><center>Add Privilege</center></th>
                                <th><center>Edit Privilege</center></th>
                                <th><center>Delete Privilege</center></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="sub_admin_id" value="<?= isset($admin_details->admin_id) && $admin_details->admin_id ? $admin_details->admin_id : 0 ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/sub_admin') ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        //Check All Menu
        $('#check_all_menu').on('click', function () {
            var _check = $(this).prop('checked');
            if (_check == true) {
                $('.check_menu').prop('checked', true);
            } else {
                $('.check_menu').prop('checked', false);
            }
        });

        //Check All Add
        $('#check_all_add').on('click', function () {
            var _check = $(this).prop('checked');
            if (_check == true) {
                $('.check_add').prop('checked', true);
            } else {
                $('.check_add').prop('checked', false);
            }
        });

        //Check All Edit
        $('#check_all_edit').on('click', function () {
            var _check = $(this).prop('checked');
            if (_check == true) {
                $('.check_edit').prop('checked', true);
            } else {
                $('.check_edit').prop('checked', false);
            }
        });

        //Check All Delete
        $('#check_all_delete').on('click', function () {
            var _check = $(this).prop('checked');
            if (_check == true) {
                $('.check_delete').prop('checked', true);
            } else {
                $('.check_delete').prop('checked', false);
            }
        });

        $("#sub_admin-form").validate({
            errorElement: "em",
            rules: {
                full_name: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                }
            },
            errorPlacement: function (error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.next("label"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>