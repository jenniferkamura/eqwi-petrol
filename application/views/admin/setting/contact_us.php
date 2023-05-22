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
                        $contact_website_url = $contact_address = $contact_description = $contact_landline_no = $contact_email = $contact_mobile_no = '';
                        if (isset($setting_data) && $setting_data) {
                            foreach ($setting_data as $setting) {
                                if ($setting->title == 'contact_website_url') {
                                    $contact_website_url = $setting->value;
                                }
                                if ($setting->title == 'contact_address') {
                                    $contact_address = $setting->value;
                                }
                                if ($setting->title == 'contact_description') {
                                    $contact_description = $setting->value;
                                }
                                if ($setting->title == 'contact_landline_no') {
                                    $contact_landline_no = $setting->value;
                                }
                                if ($setting->title == 'contact_email') {
                                    $contact_email = $setting->value;
                                }
                                if ($setting->title == 'contact_mobile_no') {
                                    $contact_mobile_no = $setting->value;
                                }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>Website URL</label>
                            <input type="text" class="form-control" name="contact_website_url" value="<?= $contact_website_url ?>" placeholder="Enter website url" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="contact_address" placeholder="Enter contact address" rows="3" required=""><?= $contact_address ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="contact_description" placeholder="Enter description" rows="5" required=""><?= $contact_description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Landline Number</label>
                            <input type="text" class="form-control" name="contact_landline_no" value="<?= $contact_landline_no ?>" placeholder="Enter landline number" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Contact Email</label>
                            <input type="email" class="form-control" name="contact_email" value="<?= $contact_email ?>" placeholder="Enter contact email" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Contact Mobile Number</label>
                            <input type="text" class="form-control" name="contact_mobile_no" value="<?= $contact_mobile_no ?>" placeholder="Enter contact mobile number" required="" autocomplete="off">
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

    $(document).on('change', '.contact_us_image', function () {
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