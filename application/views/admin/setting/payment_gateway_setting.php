<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="payment_gateway-form">
                    <div class="box-body">
                        <?php
                        $test_pg_url = $live_pg_url = $client_email = $pg_client_key = $pg_checksum_key = '';
                        if(isset($setting_data) && $setting_data){
                            foreach ($setting_data as $setting) {
                                if($setting->title == 'test_pg_url'){ 
                                    $test_pg_url = $setting->value;
                                }
                                if($setting->title == 'live_pg_url'){ 
                                    $live_pg_url = $setting->value;
                                }
                                if($setting->title == 'client_email'){ 
                                    $client_email = $setting->value;
                                }
                                if($setting->title == 'pg_client_key'){ 
                                    $pg_client_key = $setting->value;
                                }
                                if($setting->title == 'pg_checksum_key'){ 
                                    $pg_checksum_key = $setting->value;
                                }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>Test Payment Gateway URL</label>
                            <input type="url" class="form-control" name="test_pg_url" required="" placeholder="Enter test payment gateway url" value="<?= $test_pg_url ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Live Payment Gateway URL</label>
                            <input type="url" class="form-control" name="live_pg_url" required="" placeholder="Enter live payment gateway url" value="<?= $live_pg_url ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Client Email</label>
                            <input type="email" class="form-control" name="client_email" required="" placeholder="Enter client email" value="<?= $client_email ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Client Key</label>
                            <input type="text" class="form-control" name="pg_client_key" required="" placeholder="Enter client key" value="<?= $pg_client_key ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Checksum Key</label>
                            <input type="text" class="form-control" name="pg_checksum_key" required="" placeholder="Enter checksum key" value="<?= $pg_checksum_key ?>" autocomplete="off">
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
        $("#payment_gateway-form").validate({
            errorElement: "em",
            rules: {
                test_pg_url: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                live_pg_url: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                client_email: {required: true, email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                pg_client_key: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                pg_checksum_key: {required: true,
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