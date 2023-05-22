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
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?= isset($vendor_data) && $vendor_data->name ? $vendor_data->name : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= isset($vendor_data) && $vendor_data->email ? $vendor_data->email : '' ?>" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" value="<?= isset($vendor_data) && $vendor_data->mobile ? $vendor_data->mobile : '' ?>" required="">
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Latitude</label>
                                        <input type="text" class="form-control" name="latitude" placeholder="Enter latitude" value="<?= isset($vendor_data) && $vendor_data->latitude ? $vendor_data->latitude : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control" name="longitude" placeholder="Enter longitude" value="<?= isset($vendor_data) && $vendor_data->longitude ? $vendor_data->longitude : '' ?>">
                                    </div>
                                </div>
                                <br/>
                            </div>
                            <?php
                            if (ALLOW_GOOGLE_MAPS) {
                                ?>
                                <div class="col-md-1">
                                    <label>Map</label>
                                    <div>
                                        <a href="<?= base_url('maps') ?>" target="_blank"><i class="fa fa-map-marker"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" placeholder="Enter address"><?= isset($vendor_data) && $vendor_data->address ? $vendor_data->address : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($vendor_data) && $vendor_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($vendor_data) && $vendor_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="vendor_id" value="<?= $vendor_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/vendor") ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
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

    /*$(document).on('change', '.profile_pic', function () {
     if (this.files && this.files[0]) {
     var reader = new FileReader();
     reader.onload = function (e) {
     $('#PhotoPrev').attr('src', e.target.result);
     $('#PhotoPrev').parent().attr('href', e.target.result);
     }
     reader.readAsDataURL(this.files[0]);
     }
     });*/
</script>