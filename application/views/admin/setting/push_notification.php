<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{background-color: #3c8dbc !important;}
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{color: #000 !important;}
</style>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="push_notification-form">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Owners</label>
                            <label style="float: right;">
                                <input type="checkbox" id="owners" class="check_all">
                                Check All
                            </label>
                            <select class="form-control select2" multiple="multiple" id="check_owners" name="owners[]" style="width:100%;">
                                <?php
                                foreach ($owner_data as $user) {
                                    if (!empty($user->name)) {
                                        ?>
                                        <option value="<?= $user->user_id ?>"><?= $user->name ?> &nbsp; (<?= $user->mobile ?>)</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Managers</label>
                            <label style="float: right;">
                                <input type="checkbox" id="managers" class="check_all">
                                Check All
                            </label>
                            <select class="form-control select2" multiple="multiple" id="check_managers" name="managers[]" style="width:100%;">
                                <?php
                                foreach ($manager_data as $user) {
                                    if (!empty($user->name)) {
                                        ?>
                                        <option value="<?= $user->user_id ?>"><?= $user->name ?> &nbsp; (<?= $user->mobile ?>)</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Attendants</label>
                            <label style="float: right;">
                                <input type="checkbox" id="attendants" class="check_all">
                                Check All
                            </label>
                            <select class="form-control select2" multiple="multiple" id="check_attendants" name="attendants[]" style="width:100%;">
                                <?php
                                foreach ($attendant_data as $user) {
                                    if (!empty($user->name)) {
                                        ?>
                                        <option value="<?= $user->user_id ?>"><?= $user->name ?> &nbsp; (<?= $user->mobile ?>)</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Transporters</label>
                            <label style="float: right;">
                                <input type="checkbox" id="transporters" class="check_all">
                                Check All
                            </label>
                            <select class="form-control select2" multiple="multiple" id="check_transporters" name="transporters[]" style="width:100%;">
                                <?php
                                foreach ($transporter_data as $user) {
                                    if (!empty($user->name)) {
                                        ?>
                                        <option value="<?= $user->user_id ?>"><?= $user->name ?> &nbsp; (<?= $user->mobile ?>)</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" value="" required="">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" rows="10" name="message" required="" minlength="20"></textarea>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
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
        $('.select2').select2();
        $("#push_notification-form").validate({
            errorElement: "em",
            rules: {
                driver_feature: {required: true}
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

    $(document).on('change', '.check_all', function () {
        var _check_all = $(this).attr('id');
        if ($(this).prop("checked") == true) {
            $('#check_' + _check_all + ' option').prop('selected', true);
        } else {
            $('#check_' + _check_all + ' option').prop('selected', false);
        }
        $('#check_' + _check_all).trigger("change");
    });
</script>