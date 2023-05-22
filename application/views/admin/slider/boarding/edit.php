<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="slider-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title" value="<?= isset($slider_data) && $slider_data->title ? $slider_data->title : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter description" rows="3"><?= isset($slider_data) && $slider_data->description ? $slider_data->description : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <?php
                                $slider_img = isset($slider_data) && $slider_data->image ? $slider_data->image : '';
                                ?>
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Image</label>
                                    <input type="file" class="form-control slider_img" name="slider_image" accept="image/*" <?= $slider_img != '' ? '' : 'required=""' ?>>
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">                                    
                                    <a href="<?= $slider_img != '' ? getImage('boarding_slider', $slider_img) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('boarding_slider', $slider_img) ?>" id="PhotoPrev" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" class="form-control" name="display_order" placeholder="Display Order" value="<?= isset($slider_data) && $slider_data->display_order ? $slider_data->display_order : ($last_display_order) ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($slider_data) && $slider_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($slider_data) && $slider_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="slider_id" value="<?= isset($slider_data) && $slider_data->slider_id ? $slider_data->slider_id : 0 ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/boarding_slider') ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#slider-form").validate({
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

    $(document).on('change', '.slider_img', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#PhotoPrev').attr('src', e.target.result);
                $('#PhotoPrev').parent().attr('href', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>