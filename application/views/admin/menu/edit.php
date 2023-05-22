<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="user-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <?php if ($menu_type == 'sub') { ?>
                            <div class="form-group">
                                <label>Select Menu</label>
                                <select class="form-control" name="parent_id" required="">
                                    <option value="">Select</option>
                                    <?php
                                    if ($main_menu) {
                                        foreach ($main_menu as $menu) {
                                            ?>
                                            <option value="<?= $menu->id ?>" <?= isset($menu_data) && $menu_data->menu_id == $menu->id ? 'selected=""' : '' ?>><?= $menu->menu_name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Menu Name</label>
                            <input type="text" class="form-control" name="menu_name" placeholder="Enter name" value="<?= isset($menu_data) && $menu_data->menu_name ? $menu_data->menu_name : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Menu URL</label>
                            <input type="text" class="form-control" id="menu_url" name="menu_url" placeholder="Enter menu url" value="<?= isset($menu_data) && $menu_data->menu_url ? $menu_data->menu_url : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Menu Icon</label>
                            <input type="text" class="form-control" id="menu_icon" name="menu_icon" placeholder="Enter menu icon" value="<?= isset($menu_data) && $menu_data->menu_icon ? $menu_data->menu_icon : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="text" class="form-control" name="display_order" placeholder="Enter display order" value="<?= isset($menu_data) && $menu_data->display_order ? $menu_data->display_order : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="0" <?= isset($menu_data) && $menu_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                                <option value="1" <?= isset($menu_data) && $menu_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="menu_id" value="<?= $menu_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <?php if ($menu_type == 'main') { ?>
                            <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/main_menu") ?>'">Cancel</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/sub_menu") ?>'">Cancel</button>
                        <?php } ?>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#user-form").validate({
            errorElement: "em",
            rules: {
                menu_name: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                menu_url: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                menu_icon: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                display_order: {required: true, digits: true}
            },
            messages: {
                display_order: {digits: "Please enter numbers only"}
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