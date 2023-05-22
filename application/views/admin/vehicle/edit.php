<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="vehicle-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Transporter Name</label>
                            <select class="form-control" name="user_id" required="">
                                <option value="">Select Transporter</option>
                                <?php
                                if ($user_data) {
                                    foreach ($user_data as $user) {
                                        ?>
                                        <option value="<?= $user->user_id ?>" <?= isset($vehicle_data) && $vehicle_data->user_id == $user->user_id ? 'selected=""' : '' ?>><?= $user->name . ' (' . $user->mobile . ')' ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12"> 
                                <?php
                                $vehicle_img1 = isset($vehicle_data) && $vehicle_data->front_vehicle_photo ? $vehicle_data->front_vehicle_photo : '';
                                ?>
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Front Vehicle Image</label>
                                    <input type="file" class="form-control vehicle_img" data-id="front_vehicle_photo" name="front_vehicle_photo" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">                                    
                                    <a href="<?= $vehicle_img1 != '' ? getImage('vehicle_photo', $vehicle_img1) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img1) ?>" id="front_vehicle_photo" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <?php
                                $vehicle_img2 = isset($vehicle_data) && $vehicle_data->back_vehicle_photo ? $vehicle_data->back_vehicle_photo : '';
                                ?>
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Back Vehicle Image</label>
                                    <input type="file" class="form-control vehicle_img" data-id="back_vehicle_photo" name="back_vehicle_photo" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">
                                    <a href="<?= $vehicle_img2 != '' ? getImage('vehicle_photo', $vehicle_img2) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img2) ?>" id="back_vehicle_photo" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <?php
                                $vehicle_img3 = isset($vehicle_data) && $vehicle_data->left_vehicle_photo ? $vehicle_data->left_vehicle_photo : '';
                                ?>
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Left Vehicle Image</label>
                                    <input type="file" class="form-control vehicle_img" data-id="left_vehicle_photo" name="left_vehicle_photo" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">
                                    <a href="<?= $vehicle_img3 != '' ? getImage('vehicle_photo', $vehicle_img3) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img3) ?>" id="left_vehicle_photo" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <?php
                                $vehicle_img4 = isset($vehicle_data) && $vehicle_data->right_vehicle_photo ? $vehicle_data->right_vehicle_photo : '';
                                ?>
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Right Vehicle Image</label>
                                    <input type="file" class="form-control vehicle_img" data-id="right_vehicle_photo" name="right_vehicle_photo" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">
                                    <a href="<?= $vehicle_img4 != '' ? getImage('vehicle_photo', $vehicle_img4) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img4) ?>" id="right_vehicle_photo" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Vehicle Document</label>
                                    <input type="file" class="form-control" name="vehicle_document" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG, PDF</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;padding-top: 30px;">
                                    <?php
                                    $vehicle_doc = isset($vehicle_data) && $vehicle_data->vehicle_document ? $vehicle_data->vehicle_document : '';
                                    ?>
                                    <a href="<?= $vehicle_doc != '' ? getImage('vehicle_photo', $vehicle_doc) : 'javascript:void(0);' ?>" <?= $vehicle_doc != '' ? 'download=""' : '' ?>><?= $vehicle_doc != '' ? 'Download' : '' ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Driving License</label>
                                    <input type="file" class="form-control vehicle_img" data-id="driving_license" name="driving_license" accept="image/*">
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">
                                    <?php
                                    $driving_license = isset($vehicle_data) && $vehicle_data->driving_license_url ? $vehicle_data->driving_license_url : getImage('user_documents', '');
                                    ?>
                                    <a href="<?= $driving_license != '' ? $driving_license : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= $driving_license ?>" id="driving_license" height="80" width="80" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>License Number</label>
                            <input type="text" class="form-control" id="license_number" name="license_number" placeholder="Enter license number" value="<?= isset($vehicle_data) && $vehicle_data->license_number ? $vehicle_data->license_number : '' ?>" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>Vehicle Number</label>
                            <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" placeholder="Enter vehicle number" value="<?= isset($vehicle_data) && $vehicle_data->vehicle_number ? $vehicle_data->vehicle_number : '' ?>" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>Vehicle Capacity</label>
                            <input type="text" class="form-control" id="vehicle_capacity" name="vehicle_capacity" placeholder="Enter vehicle capacity" value="<?= isset($vehicle_data) && $vehicle_data->vehicle_capacity ? $vehicle_data->vehicle_capacity : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Measurement</label>
                            <input type="text" class="form-control" name="measurement" placeholder="Enter measurement" value="<?= isset($vehicle_data) && $vehicle_data->measurement ? $vehicle_data->measurement : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Number of Compartment</label>
                            <select class="form-control" name="no_of_compartment" onchange="change_compartment(this)">
                                <option value="">Select Compartment</option>
                                <option value="1" <?= isset($vehicle_data) && $vehicle_data->no_of_compartment == 1 ? 'selected=""' : '' ?>>1</option>
                                <option value="2" <?= isset($vehicle_data) && $vehicle_data->no_of_compartment == 2 ? 'selected=""' : '' ?>>2</option>
                                <option value="3" <?= isset($vehicle_data) && $vehicle_data->no_of_compartment == 3 ? 'selected=""' : '' ?>>3</option>
                                <option value="4" <?= isset($vehicle_data) && $vehicle_data->no_of_compartment == 4 ? 'selected=""' : '' ?>>4</option>
                                <option value="5" <?= isset($vehicle_data) && $vehicle_data->no_of_compartment == 5 ? 'selected=""' : '' ?>>5</option>
                                <option value="6" <?= isset($vehicle_data) && $vehicle_data->no_of_compartment == 6 ? 'selected=""' : '' ?>>6</option>
                            </select>
                        </div>
                        <div class="row" id="dis_compartment" style="display1: none;">
                            <?php
                            if ($vehicle_detail) {
                                foreach ($vehicle_detail as $detail) {
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label><?= ordinal_number($detail->compartment_no) ?></label> Compartment Capacity
                                        <input type="text" class="form-control" name="compartment_capacity[<?= $detail->compartment_no ?>]" value="<?= $detail->compartment_capacity ?>" required="">
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($vehicle_data) && $vehicle_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($vehicle_data) && $vehicle_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="vehicle_id" value="<?= $vehicle_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/vehicle") ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#vehicle-form").validate({
            errorElement: "em",
            rules: {
                name: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                vehicle_number: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                vehicle_capacity: {required: true, digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                measurement: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                no_of_compartment: {required: true, digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                'compartment_no[]': {required: true, digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                'compartment_capacity[]': {required: true, digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                license_number: {required: true,
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

    $(document).on('change', '.vehicle_img', function () {
        var _id = $(this).attr('data-id');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + _id).attr('src', e.target.result);
                $('#' + _id).parent().attr('href', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    function change_compartment(ref) {
        var _val = $(ref).val();
        if (_val != '') {
            $('#dis_compartment').html('');
            for (var i = 1; i <= _val; i++) {
                var _compartment_no = '';
                _compartment_no += '<div class="form-group col-md-6">';
                _compartment_no += '    <label>' + ordinal_suffix_of(i) + '</label> Compartment Capacity';
                _compartment_no += '    <input type="text" name="compartment_capacity[' + i + ']" class="form-control" value="" required="">';
                _compartment_no += '</div>';

                $('#dis_compartment').append(_compartment_no);
            }
        }
    }

    function ordinal_suffix_of(i) {
        var j = i % 10,
                k = i % 100;
        if (j == 1 && k != 11) {
            return i + "st";
        }
        if (j == 2 && k != 12) {
            return i + "nd";
        }
        if (j == 3 && k != 13) {
            return i + "rd";
        }
        return i + "th";
    }
</script>