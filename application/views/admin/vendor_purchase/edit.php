<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="vendor-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Vendor Name</label>
                            <select class="form-control sel_vendor" name="vendor_id" required="">
                                <option value=""></option>
                                <?php
                                if ($vendor_data) {
                                    foreach ($vendor_data as $vendor) {
                                        $sel_vendor = isset($vendor_purchase) && $vendor_purchase->vendor_id == $vendor->vendor_id ? 'selected=""' : '';
                                        ?>
                                        <option value="<?= $vendor->vendor_id ?>" <?= $sel_vendor ?>><?= $vendor->name . ' (' . $vendor->mobile . ')' ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control sel_product" name="product_id" required="">
                                <option value=""></option>
                                <?php
                                if ($product_data) {
                                    foreach ($product_data as $product) {
                                        $sel_product = isset($vendor_purchase) && $vendor_purchase->product_id == $product->category_id ? 'selected=""' : '';
                                        ?>
                                        <option value="<?= $product->category_id ?>" <?= $sel_product ?>><?= $product->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Enter invoice number" value="<?= isset($vendor_purchase) && $vendor_purchase->invoice_no ? $vendor_purchase->invoice_no : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Invoice Date</label>
                            <input type="text" class="form-control" id="invoice_date" name="invoice_date" placeholder="Enter invoice date" value="<?= isset($vendor_purchase) && $vendor_purchase->invoice_date ? date('d/m/Y', strtotime($vendor_purchase->invoice_date)) : '' ?>" required="" readonly="">
                        </div>
                        <?php /*
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Invoice Date</label>
                                    <input type="text" class="form-control" id="invoice_date" name="invoice_date" placeholder="Enter invoice date" value="<?= isset($vendor_purchase) && $vendor_purchase->invoice_date ? date('d/m/Y', strtotime($vendor_purchase->invoice_date)) : '' ?>" required="" readonly="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Inward Date</label>
                                    <input type="text" class="form-control" id="inward_date" name="inward_date" placeholder="Enter inward date" value="<?= isset($vendor_purchase) && $vendor_purchase->inward_date ? date('d/m/Y', strtotime($vendor_purchase->inward_date)) : '' ?>" required="" readonly="">
                                </div>
                            </div>
                        </div> */ ?>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Invoice Attachment</label>
                                    <input type="file" class="form-control invoice_img" name="invoice_attach" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">
                                    <?php
                                    $invoice_img = isset($vendor_purchase) && $vendor_purchase->invoice_attach ? $vendor_purchase->invoice_attach : '';
                                    ?>
                                    <a href="<?= $invoice_img != '' ? getImage('invoice_image', $invoice_img) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('invoice_image', $invoice_img) ?>" id="PhotoPrev" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Invoice Amount</label>
                            <input type="text" class="form-control" name="amount" placeholder="Enter invoice amount" value="<?= isset($vendor_purchase) && $vendor_purchase->amount ? $vendor_purchase->amount : '' ?>" required="">
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="vendor_purchase_id" value="<?= $vendor_purchase_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/vendor_purchase") ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<link rel="stylesheet" href="<?= base_url('assets/bower_components/select2/dist/css/select2.min.css'); ?>">
<script src="<?= base_url('assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
<script>
                            $(function () {
                                $('.sel_vendor').select2({width: '100%', placeholder: 'Select Vendor'});
                                $('.sel_product').select2({width: '100%', placeholder: 'Select Product'});

                                //Date picker
                                $('#invoice_date').datepicker({
                                    format: "dd/mm/yyyy",
                                    autoclose: true,
                                    todayHighlight: true,
                                    endDate: "today"
                                });
                                /*$('#inward_date').datepicker({
                                    format: "dd/mm/yyyy",
                                    autoclose: true,
                                    todayHighlight: true,
                                    endDate: "today"
                                });*/

                                $("#vendor-form").validate({
                                    errorElement: "em",
                                    rules: {
                                        name: {required: true,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            }
                                        },
                                        email: {email: true,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            },
                                            remote: {url: "<?= base_url('admin/vendor/check_vendor_exists') ?>", type: "post",
                                                data: {
                                                    id: '<?= $vendor_id ?>',
                                                    type: 'email',
                                                    val: function () {
                                                        return $('#email').val();
                                                    }
                                                }
                                            }
                                        },
                                        mobile: {required: true, digits: true, minlength: 5, maxlength: 15,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            },
                                            remote: {url: "<?= base_url('admin/vendor/check_vendor_exists') ?>", type: "post",
                                                data: {
                                                    id: '<?= $vendor_id ?>',
                                                    type: 'mobile',
                                                    val: function () {
                                                        return $('#mobile').val();
                                                    }
                                                }
                                            }
                                        },
                                        latitude: {number: true,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            }
                                        },
                                        longitude: {number: true,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            }
                                        } 
                                    },
                                    messages: {
                                        email: {remote: jQuery.validator.format("{0} is already in use")},
                                        mobile: {digits: "Please enter numbers only", remote: jQuery.validator.format("{0} is already in use")},
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

                            $(document).on('change', '.invoice_img', function () {
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