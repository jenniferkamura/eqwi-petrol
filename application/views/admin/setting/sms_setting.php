<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="sms-form">
                    <div class="box-body">
                        <?php
                        $sms_url = $api_key = $sender_id = '';
                        if(isset($setting_data) && $setting_data){
                            foreach ($setting_data as $setting) {
                                if($setting->title == 'sms_url'){ 
                                    $sms_url = $setting->value;
                                }
                                if($setting->title == 'api_key'){ 
                                    $api_key = $setting->value;
                                }
                                if($setting->title == 'sender_id'){ 
                                    $sender_id = $setting->value;
                                }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="url" class="form-control" name="url" required="" placeholder="Enter url" value="<?= $sms_url ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>API KEY</label>
                            <input type="text" class="form-control" name="api_key" required="" placeholder="Enter api key" value="<?= $api_key ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Sender ID</label>
                            <input type="text" class="form-control" name="sender_id" required="" placeholder="Enter sender id" value="<?= $sender_id ?>" autocomplete="off">
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
        $("#sms-form").validate({
            errorElement: "em",
            rules: {
                url: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                api_key: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                sender_id: {required: true,
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