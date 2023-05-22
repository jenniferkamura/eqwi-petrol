<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="role-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Role Name</label>
                            <input type="text" class="form-control" name="role_name" placeholder="Enter Role name" value="<?= isset($role_data) && $role_data->role_name ? $role_data->role_name : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="0" <?= isset($role_data) && $role_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                                <option value="1" <?= isset($role_data) && $role_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="role_id" value="<?= isset($role_data) && $role_data->id ? $role_data->id : 0 ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/role') ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#role-form").validate({
            errorElement: "em",
            rules: {
                role_name: {required: true,
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