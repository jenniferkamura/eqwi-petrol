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
                            <input type="text" class="form-control" name="product_name" placeholder="Product name" value="<?= isset($product_data) && $product_data->name ? $product_data->name : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Product Type</label>
                            <input type="text" class="form-control" name="product_type" placeholder="Product type" value="<?= isset($product_data) && $product_data->type ? $product_data->type : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Product Image</label>
                                    <input type="file" class="form-control product_img" name="product_image" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">
                                    <?php
                                    $product_img = isset($product_data) && $product_data->image ? $product_data->image : '';
                                    ?>
                                    <a href="<?= $product_img != '' ? getImage('product_image', $product_img) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('product_image', $product_img) ?>" id="PhotoPrev" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Measurement</label>
                            <input type="text" class="form-control" name="measurement" placeholder="Enter measurement" value="<?= isset($product_data) && $product_data->measurement ? $product_data->measurement : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Minimum Order Qty</label>
                            <input type="number" class="form-control" name="minimum_order_qty" placeholder="Enter minimum order qty" value="<?= isset($product_data) && $product_data->minimum_order_qty ? $product_data->minimum_order_qty : 0 ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" class="form-control" name="display_order" placeholder="Display Order" value="<?= isset($product_data) && $product_data->display_order ? $product_data->display_order : ($last_display_order) ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($product_data) && $product_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($product_data) && $product_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="product_id" value="<?= isset($product_data) && $product_data->category_id ? $product_data->category_id : 0 ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/product') ?>'">Cancel</button>
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
                product_name: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                product_type: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                price: {required: true, number: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                measurement: {required: true, 
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