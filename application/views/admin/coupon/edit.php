<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="coupon-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <?php /*
                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control select2" name="product_id" required="">
                                <option value=""></option>
                                <?php
                                if ($product_data) {
                                    foreach ($product_data as $product) {
                                        $sel_product = isset($coupon_data) && $coupon_data->product_id == $product->category_id ? 'selected=""' : '';
                                        ?>
                                        <option value="<?= $product->category_id ?>" <?= $sel_product ?>><?= $product->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div> */ ?>
                        <div class="form-group">
                            <label>Coupon Title</label>
                            <input type="text" class="form-control" name="coupon_title" placeholder="Enter coupon title" value="<?= isset($coupon_data) && $coupon_data->coupon_title ? $coupon_data->coupon_title : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter description" required=""><?= isset($coupon_data) && $coupon_data->description ? $coupon_data->description : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date" value="<?= isset($coupon_data) && $coupon_data->start_date ? date('d/m/Y', strtotime($coupon_data->start_date)) : '' ?>" required="" readonly="">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date" value="<?= isset($coupon_data) && $coupon_data->end_date ? date('d/m/Y', strtotime($coupon_data->end_date)) : '' ?>" required="" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Is Discount</label>
                            <select class="form-control" id="is_discount" name="is_discount" onchange="check_discount(this)">
                                <option value="0" <?= isset($coupon_data) && $coupon_data->is_discount == 0 ? 'selected=""' : '' ?>>No</option>
                                <option value="1" <?= isset($coupon_data) && $coupon_data->is_discount == 1 ? 'selected=""' : '' ?>>Yes</option>
                            </select>
                        </div>
                        <div class="form-group dis_discount" style="<?= isset($coupon_data) && $coupon_data->is_discount ? '' : 'display: none;' ?>">
                            <label>Discount</label>
                            <input type="text" class="form-control" name="discount" placeholder="Enter discount" value="<?= isset($coupon_data) && $coupon_data->discount ? $coupon_data->discount : '' ?>" required="">
                        </div>
                        <div class="form-group dis_discount" style="<?= isset($coupon_data) && $coupon_data->is_discount ? '' : 'display: none;' ?>">
                            <label>Discount On Amount</label>
                            <input type="text" class="form-control" name="on_amount" placeholder="Enter discount on amount" value="<?= isset($coupon_data) && $coupon_data->on_amount ? $coupon_data->on_amount : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($coupon_data) && $coupon_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($coupon_data) && $coupon_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="coupon_id" value="<?= isset($coupon_data) && $coupon_data->coupon_id ? $coupon_data->coupon_id : 0 ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/coupon') ?>'">Cancel</button>
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
                                $('.select2').select2({width: '100%', placeholder: 'Select Product'});
                                
                                //Date picker 
                                $('#start_date').datepicker({
                                    format: "dd/mm/yyyy", 
                                    autoclose: true,
                                    todayHighlight: true,
                                    startDate: "today"
                                }).on('changeDate', function (e) {
                                    $('#end_date').datepicker('setStartDate', e.date);
                                });
                                $('#end_date').datepicker({
                                    format: "dd/mm/yyyy",
                                    autoclose: true,
                                    todayHighlight: true,
                                    startDate: "today"
                                }).on('changeDate', function (e) {
                                    $('#start_date').datepicker('setEndDate', e.date);
                                });

                                $("#coupon-form").validate({
                                    errorElement: "em",
                                    rules: {
                                        coupon_title: {required: true,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            }
                                        },
                                        start_date: {required: true},
                                        end_date: {required: true},
                                        discount: {required: true, numbers: true,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            }
                                        },
                                        on_amount: {required: true, numbers: true,
                                            normalizer: function (value) {
                                                return $.trim(value);
                                            }
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
                            
                            function check_discount(ref){
                                var _val = $(ref).val();
                                if(_val == 1){
                                    $('.dis_discount').show();
                                }else{
                                    $('.dis_discount').hide();
                                }
                            }
</script>