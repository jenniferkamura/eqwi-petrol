<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?> : <?= isset($help_data) && $help_data->ticket_id ? $help_data->ticket_id : '' ?></h3>
                </div>
                <form action="" method="post" id="help-form" enctype="multipart/form-data">
                    <div class="box-body row">
                        <div class="col-md-4 form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?= isset($help_data) && $help_data->name ? $help_data->name : '' ?>" required="" readonly="">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter email" value="<?= isset($help_data) && $help_data->email ? $help_data->email : '' ?>" required="" readonly="">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Enter mobile" value="<?= isset($help_data) && $help_data->mobile ? $help_data->mobile : '' ?>" required="" readonly="">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Query Detail</label>
                            <textarea class="form-control" id="query_detail" name="query_detail" rows="5" placeholder="Enter answer" readonly=""><?= isset($help_data) && $help_data->query_detail ? $help_data->query_detail : '' ?></textarea>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($help_data) && $help_data->status == 1 ? 'selected=""' : '' ?>>Resolved</option>
                                <option value="0" <?= isset($help_data) && $help_data->status == 0 ? 'selected=""' : '' ?>>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="help_id" value="<?= $help_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/help/ticket") ?>'">Cancel</button>
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