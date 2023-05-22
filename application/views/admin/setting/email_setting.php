<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="email-form">
                    <div class="box-body">
                        <?php
                        $smtp_host = $smtp_user = $smtp_password = $smtp_port = '';
                        if(isset($setting_data) && $setting_data){
                            foreach ($setting_data as $setting) {
                                if($setting->title == 'smtp_host'){ 
                                    $smtp_host = $setting->value;
                                }
                                if($setting->title == 'smtp_user'){ 
                                    $smtp_user = $setting->value;
                                }
                                if($setting->title == 'smtp_password'){ 
                                    $smtp_password = $setting->value;
                                }
                                if($setting->title == 'smtp_port'){ 
                                    $smtp_port = $setting->value;
                                }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>SMTP Host</label>
                            <input type="text" class="form-control" name="smtp_host" required="" placeholder="Enter smtp host" value="<?= $smtp_host ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>SMTP Username</label>
                            <input type="text" class="form-control" name="smtp_user" required="" placeholder="Enter username" value="<?= $smtp_user ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>SMTP Password</label>
                            <input type="text" class="form-control" name="smtp_password" required="" placeholder="Enter smtp password" value="<?= $smtp_password ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>SMTP Port</label>
                            <input type="text" class="form-control" name="smtp_port" required="" placeholder="Enter smtp port" value="<?= $smtp_port ?>" autocomplete="off">
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
        $("#email-form").validate({
            errorElement: "em",
            rules: {
                smtp_host: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                smtp_user: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                smtp_password: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                smtp_port: {required: true,
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
</script>