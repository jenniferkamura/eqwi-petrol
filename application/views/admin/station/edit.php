<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="station-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Owner</label>
                                    <select class="form-control" name="owner_id">
                                        <option value="">Select Owner</option>
                                        <?php
                                        if ($owners) {
                                            foreach ($owners as $owner) {
                                                ?>
                                                <option value="<?= $owner->user_id ?>" <?= isset($station_data) && $station_data->owner_id == $owner->user_id ? 'selected=""' : '' ?>><?= $owner->name . ' (' . $owner->mobile . ')' ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Station Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="station_name" placeholder="Station name" value="<?= isset($station_data) && $station_data->station_name ? $station_data->station_name : '' ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Contact Person Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="contact_person" placeholder="Contact person name" value="<?= isset($station_data) && $station_data->contact_person ? $station_data->contact_person : '' ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Phone Number <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="contact_number" placeholder="Phone number" value="<?= isset($station_data) && $station_data->contact_number ? $station_data->contact_number : '' ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Alternate Number</label>
                                    <input type="text" class="form-control" name="alternate_number" placeholder="Alternate phone number" value="<?= isset($station_data) && $station_data->alternate_number ? $station_data->alternate_number : '' ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="country" placeholder="Country" value="<?= isset($station_data) && $station_data->country ? $station_data->country : '' ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" placeholder="City" value="<?= isset($station_data) && $station_data->city ? $station_data->city : '' ?>">
                                </div> 
                                <div class="form-group">
                                    <label>County</label>
                                    <input type="text" class="form-control" name="state" placeholder="State" value="<?= isset($station_data) && $station_data->state ? $station_data->state : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Pincode</label>
                                    <input type="text" class="form-control" name="pincode" placeholder="Pincode" value="<?= isset($station_data) && $station_data->pincode ? $station_data->pincode : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address <span class="required">*</span></label>
                            <textarea class="form-control" name="address" required=""><?= isset($station_data) && $station_data->address ? $station_data->address : '' ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Landmark</label>
                                        <input type="text" class="form-control" name="landmark" placeholder="Landmark" value="<?= isset($station_data) && $station_data->landmark ? $station_data->landmark : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1" <?= isset($station_data) && $station_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                            <option value="0" <?= isset($station_data) && $station_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Latitude</label>
                                        <input type="text" class="form-control" name="latitude" placeholder="Enter latitude" value="<?= isset($station_data) && $station_data->latitude ? $station_data->latitude : '' ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control" name="longitude" placeholder="Enter longitude" value="<?= isset($station_data) && $station_data->longitude ? $station_data->longitude : '' ?>">
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
                                <br/>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="station_id" value="<?= isset($station_data) && $station_data->station_id ? $station_data->station_id : 0 ?>">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url('admin/station') ?>'">Cancel</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#station-form").validate({
            errorElement: "em",
            rules: {
                station_name: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                contact_person: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                contact_number: {required: true, digits: true, minlength: 5, maxlength: 15,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                country: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                pincode: {digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                address: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
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