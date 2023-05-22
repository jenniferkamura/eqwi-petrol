<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="site_setting-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <?php
                        $site_logo = $google_map_api_key = $currency_code = $currency_symbol = $push_notification_key = '';
                        $invoice_amount = $shipping_charge = $tax = $site_address = $latitude = $longitude = $nearby_pickup_radius = $transporter_accept_time = '';
                        $site_contact_no = $service_available_radius = $display_advertisement = '';
                        if (isset($setting_data) && $setting_data) {
                            foreach ($setting_data as $setting) {
                                if ($setting->title == 'site_logo') {
                                    $site_logo = $setting->value;
                                }
                                if ($setting->title == 'google_map_api_key') {
                                    $google_map_api_key = $setting->value;
                                }
                                if ($setting->title == 'currency_code') {
                                    $currency_code = $setting->value;
                                }
                                if ($setting->title == 'currency_symbol') {
                                    $currency_symbol = $setting->value;
                                }
                                if ($setting->title == 'push_notification_key') {
                                    $push_notification_key = $setting->value;
                                }
                                if ($setting->title == 'shipping_charge') {
                                    $shipping_charge = $setting->value;
                                }
                                if ($setting->title == 'tax') {
                                    $tax = $setting->value;
                                }
                                if ($setting->title == 'invoice_amount') {
                                    $invoice_amount = $setting->value;
                                }
                                if ($setting->title == 'site_address') {
                                    $site_address = $setting->value;
                                }
                                if ($setting->title == 'site_contact_no') {
                                    $site_contact_no = $setting->value;
                                }
                                if ($setting->title == 'latitude') {
                                    $latitude = $setting->value;
                                }
                                if ($setting->title == 'longitude') {
                                    $longitude = $setting->value;
                                }
                                if ($setting->title == 'nearby_pickup_radius') {
                                    $nearby_pickup_radius = $setting->value;
                                }
                                if ($setting->title == 'transporter_accept_time') {
                                    $transporter_accept_time = $setting->value;
                                }
                                if ($setting->title == 'service_available_radius') {
                                    $service_available_radius = $setting->value;
                                }
                                if ($setting->title == 'display_advertisement') {
                                    $display_advertisement = $setting->value;
                                }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <div class="row col-md-12">
                                <div class="form-group" style="width: 80%;float: left;">
                                    <label>Site Logo</label>
                                    <input type="file" class="form-control site_logo" name="site_logo" <?= $site_logo ? '' : 'required=""' ?>>
                                    <div class="error">Allowed only PNG, JPG</div>
                                </div>
                                <div class="form-group" style="width: 20%;float: right;text-align: right;">
                                    <a href="javascript:void(0);" target="_blank" ><img src="<?= getImage('logo', $site_logo) ?>" id="PhotoPrev" height="100" width="100" ></a>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Currency Symbol</label>
                                <input type="text" class="form-control" name="currency_symbol" value="<?= $currency_symbol ?>" placeholder="Enter currency symbol" required="" autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <label>Currency Code</label>
                                <input type="text" class="form-control" name="currency_code" value="<?= $currency_code ?>" placeholder="Enter currency code" required="" autocomplete="off">
                            </div>
                        </div>
                        <?php
                        if (DEVELOPER_OPTIONS && ALLOW_GOOGLE_MAPS) {
                            ?>
                            <div class="form-group">
                                <label>Google Maps API Key</label>
                                <input type="text" class="form-control" name="google_map_api_key" value="<?= $google_map_api_key ?>" placeholder="Enter google maps server key" required="" autocomplete="off">
                            </div>
                            <?php
                        }
                        if (DEVELOPER_OPTIONS) {
                            ?> 
                            <div class="form-group">
                                <label>Firebase Push Notification Key</label>
                                <input type="text" class="form-control" name="push_notification_key" value="<?= $push_notification_key ?>" placeholder="Enter push notification server key" required="" autocomplete="off">
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label>Shipping Rate per km</label>
                            <input type="text" class="form-control" name="shipping_charge" value="<?= $shipping_charge ?>" placeholder="Enter shipping charge" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Tax (Percentage)</label>  
                            <input type="text" class="form-control" name="tax" value="<?= $tax ?>" max="100" placeholder="Enter tax" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Invoice Amount</label>
                            <input type="text" class="form-control" name="invoice_amount" value="<?= $invoice_amount ?>" placeholder="Enter invoice amount" required="" autocomplete="off">
                            <small>If Place Order Amount is greter than Invoice Amount then Invoice is generated.</small>
                        </div>
                        <div class="form-group">
                            <label>Site Address</label>  
                            <textarea class="form-control" name="site_address" placeholder="Enter site address" required=""><?= $site_address ?></textarea>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Latitude</label>  
                                <input type="text" class="form-control" name="latitude" value="<?= $latitude ?>" placeholder="Enter latitude" required="" autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <label>Longitude</label>  
                                <input type="text" class="form-control" name="longitude" value="<?= $longitude ?>" placeholder="Enter longitude" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Site Contact Number</label>  
                            <input type="text" class="form-control" name="site_contact_no" value="<?= $site_contact_no ?>" placeholder="Enter site contact number" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Nearby Pickup Radius (In KM)</label>  
                            <input type="text" class="form-control" name="nearby_pickup_radius" value="<?= $nearby_pickup_radius ?>" placeholder="Enter nearby delivery radius" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Display Time Left to Accept (In Minute)</label>  
                            <input type="text" class="form-control" name="transporter_accept_time" value="<?= $transporter_accept_time ?>" placeholder="Enter transporter accept time" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Area (Geo Fencing) Service Available Radius (In KM)</label>  
                            <input type="text" class="form-control" name="service_available_radius" value="<?= $service_available_radius ?>" placeholder="Enter service available radius" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Display Advertisement</label>
                            <select class="form-control" name="display_advertisement">
                                <option value="None" <?= $display_advertisement == 'None' ? 'selected=""' : '' ?>>None</option>
                                <option value="Both" <?= $display_advertisement == 'Both' ? 'selected=""' : '' ?>>Both</option>
                                <option value="Owner" <?= $display_advertisement == 'Owner' ? 'selected=""' : '' ?>>Owner</option>
                                <option value="Transporter" <?= $display_advertisement == 'Transporter' ? 'selected=""' : '' ?>>Transporter</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="site_setting" value="Submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $("#site_setting-form").validate({
            errorElement: "em",
            rules: {
                google_map_api_key: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                shipping_charge: {required: true, number: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                tax: {required: true, number: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                site_contact_no: {required: true, digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                nearby_pickup_radius: {required: true, number: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                service_available_radius: {required: true, number: true,
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

    $(document).on('change', '.site_logo', function () {
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