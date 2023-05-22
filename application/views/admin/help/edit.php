<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="help-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control" name="question" placeholder="Enter question" value="<?= isset($help_data) && $help_data->question ? $help_data->question : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea class="form-control" id="answer" name="answer" rows="5" placeholder="Enter answer"><?= isset($help_data) && $help_data->answer ? $help_data->answer : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" class="form-control" name="display_order" placeholder="Display Order" value="<?= isset($help_data) && $help_data->display_order ? $help_data->display_order : ($last_display_order) ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($help_data) && $help_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($help_data) && $help_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="help_id" value="<?= $help_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/help") ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#help-form").validate({
            errorElement: "em",
            rules: {
                question: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                answer: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                display_order: {required: true, digits: true,
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