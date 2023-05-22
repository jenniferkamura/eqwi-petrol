<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6 col-md-offset-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <form action="" method="post" id="user-form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Owner</label>  
                            <select class="form-control" id="owner_id" name="owner_id" required="" onchange="get_stations()">
                                <option value="">Select Owner</option> 
                                <?php
                                if ($owner_data) {
                                    foreach ($owner_data as $owner) {
                                        ?>
                                        <option value="<?= $owner->user_id ?>" <?= isset($user_data) && $user_data->owner_id == $owner->user_id ? 'selected=""' : '' ?>><?= $owner->name . ' (' . $owner->mobile . ')' ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Station</label>
                            <select class="form-control" id="station_id" name="station_id" required="">
                                <option value="">Select Station</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?= isset($user_data) && $user_data->name ? $user_data->name : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= isset($user_data) && $user_data->email ? $user_data->email : '' ?>" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" value="<?= isset($user_data) && $user_data->mobile ? $user_data->mobile : '' ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>User Id</label>
                            <input type="text" class="form-control" id="login_id" name="login_id" placeholder="Enter user id" value="<?= isset($user_data) && $user_data->login_id ? $user_data->login_id : '' ?>" required="" autocomplete="off">
                        </div>
                        <?php if ($user_id == 0) { ?>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="chk_password input-group"> 
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required="" autocomplete="off">
                                    <span class="input-group-addon show-password"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="chk_password input-group"> 
                                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter confirm password" required="" autocomplete="off">
                                    <span class="input-group-addon show-password"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" placeholder="Enter address"><?= isset($user_data) && $user_data->address ? $user_data->address : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= isset($user_data) && $user_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($user_data) && $user_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="user_type" value="<?= $user_type ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/manager") ?>'">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    $(function () {
        $("#user-form").validate({
            errorElement: "em",
            rules: {
                name: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                login_id: {required: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    },
                    remote: {url: "<?= base_url('admin/manager/check_user_exists') ?>", type: "post",
                        data: {
                            id: '<?= $user_id ?>',
                            user_type: '<?= $user_type ?>',
                            type: 'login_id',
                            val: function () {
                                return $('#login_id').val();
                            }
                        }
                    }
                },
                email: {email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    },
                    remote: {url: "<?= base_url('admin/manager/check_user_exists') ?>", type: "post",
                        data: {
                            id: '<?= $user_id ?>',
                            user_type: '<?= $user_type ?>',
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
                    remote: {url: "<?= base_url('admin/manager/check_user_exists') ?>", type: "post",
                        data: {
                            id: '<?= $user_id ?>',
                            user_type: '<?= $user_type ?>',
                            type: 'mobile',
                            val: function () {
                                return $('#mobile').val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 6
                },
                cpassword: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                }
            },
            messages: {
                email: {remote: jQuery.validator.format("{0} is already in use")},
                mobile: {digits: "Please enter numbers only", remote: jQuery.validator.format("{0} is already in use")},
                cpassword: {equalTo: "Password and confirm password did not matched"},
                login_id: {remote: jQuery.validator.format("{0} is already in use")}
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

<?php if (isset($user_data) && $user_data->owner_id) { ?>
            get_stations();
<?php } ?>
    });

    function get_stations() {
        var _val = $('#owner_id').val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url("admin/manager/get_stations") ?>',
            dataType: 'json',
            data: {id: _val, selected: '<?= isset($user_data) && $user_data->station_id ? $user_data->station_id : 0 ?>'},
            success: function (_return_data) {
                $('#station_id').html(_return_data.data);
            }
        });
    }
</script>