<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="product-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <?php
                        if ($product_data) {
                            foreach ($product_data as $product) {
                                $product_image = getImage('product_image', $product->image);
                                ?>
                                <div class="col-md-2">
                                    <div class="form-group text-center">
                                        <img src="<?= $product_image ?>" style="width: 50px;height: 50px;">
                                        <div><label><?= $product->name ?></label></div>
                                        <input type="hidden" name="product_id[]" value="<?= $product->category_id ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Price (<?= $this->common_model->getSiteSettingByTitle('currency_symbol'); ?>)</label>
                                        <input type="text" class="form-control" name="price[]" placeholder="Enter price">
                                    </div>
                                </div>
                                <?php
                            }
                        } 
                        ?>
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
                'price[]': {number: true,
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