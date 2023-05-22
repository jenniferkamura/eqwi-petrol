<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="product-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <select class="form-control" name="product_id" required="">
                                <option value="">Select Product</option>
                                <?php
                                if ($product_data) {
                                    foreach ($product_data as $product) {
                                        ?>
                                        <option value="<?= $product->category_id ?>"><?= $product->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Price (<?= $this->common_model->getSiteSettingByTitle('currency_symbol'); ?>)</label>
                            <input type="text" class="form-control" name="price" placeholder="Enter price">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/product_price') ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#product-form").validate({
            errorElement: "em",
            rules: {
                product_id: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                price: {required: true, number: true,
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

    $(document).on('change', '.product_img', function () {
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