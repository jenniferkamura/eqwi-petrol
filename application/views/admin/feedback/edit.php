<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="feedback-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" value="<?= isset($feedback_data) && $feedback_data->name ? $feedback_data->name : '' ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <input type="text" class="form-control" placeholder="Enter rating" value="<?= isset($feedback_data) && $feedback_data->rating ? $feedback_data->rating : '' ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" placeholder="Enter description" rows="6" readonly=""><?= isset($feedback_data) && $feedback_data->description ? $feedback_data->description : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Quick Feedback</label>
                            <input type="text" class="form-control" placeholder="Enter quick feedback" value="<?= isset($feedback_data) && $feedback_data->quick_feedback ? $feedback_data->quick_feedback : '' ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($feedback_data) && $feedback_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($feedback_data) && $feedback_data->status == 0 ? 'selected=""' : '' ?>>Ban</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="feedback_id" value="<?= isset($feedback_data) && $feedback_data->id ? $feedback_data->id : 0 ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/feedbacks') ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#feedback-form").validate({
            errorElement: "em",
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