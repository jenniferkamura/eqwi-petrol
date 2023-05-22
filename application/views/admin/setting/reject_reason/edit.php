<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="reject_reason-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title" value="<?= isset($reject_reason_data) && $reject_reason_data->title ? $reject_reason_data->title : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="text" class="form-control" id="display_order" name="display_order" placeholder="Enter email" value="<?= isset($reject_reason_data) && $reject_reason_data->display_order ? $reject_reason_data->display_order : $last_order ?>" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($reject_reason_data) && $reject_reason_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($reject_reason_data) && $reject_reason_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="reject_reason_id" value="<?= $reject_reason_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/setting/reject_reason") ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#reject_reason-form").validate({
            errorElement: "em",
            rules: {
                title: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                display_order: {required: true, digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    },
                },
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