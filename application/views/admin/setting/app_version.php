<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="version-form">
                    <div class="box-body">
                        <?php
                        $android_app_version = $ios_app_version = '';
                        if(isset($setting_data) && $setting_data){
                            foreach ($setting_data as $setting) {
                                if($setting->title == 'android_app_version'){ 
                                    $android_app_version = $setting->value;
                                }
                                if($setting->title == 'ios_app_version'){ 
                                    $ios_app_version = $setting->value;
                                }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>Android App Version</label>
                            <input type="text" class="form-control" name="android_app_version" required="" placeholder="Enter android app version" value="<?= $android_app_version ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>IOS App Version</label>
                            <input type="text" class="form-control" name="ios_app_version" required="" placeholder="Enter ios app version" value="<?= $ios_app_version ?>" autocomplete="off">
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#version-form").validate({
            errorElement: "em",
            rules: {
                android_app_version: {required: true, digits: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                ios_app_version: {required: true, digits: true, 
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