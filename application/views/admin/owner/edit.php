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
                        <div class="form-group">
                            <label>Show Payment Option</label>
                            <select class="form-control" name="payment_option">
                                <option value="1" <?= isset($user_data) && $user_data->payment_option == 1 ? 'selected=""' : '' ?>>100% Payment</option>
                                <option value="2" <?= isset($user_data) && $user_data->payment_option == 2 ? 'selected=""' : '' ?>>50% Payment</option>
                            </select>
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
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/owner") ?>'">Cancel</button>
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
                    remote: {url: "<?= base_url('admin/owner/check_user_exists') ?>", type: "post",
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
                    remote: {url: "<?= base_url('admin/owner/check_user_exists') ?>", type: "post",
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
                    remote: {url: "<?= base_url('admin/owner/check_user_exists') ?>", type: "post",
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
                cpassword: {equalTo: "Password and confirm password did not matched"}
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

    /*$(document).on('change', '.profile_pic', function () {
     if (this.files && this.files[0]) {
     var reader = new FileReader();
     reader.onload = function (e) {
     $('#PhotoPrev').attr('src', e.target.result);
     $('#PhotoPrev').parent().attr('href', e.target.result);
     }
     reader.readAsDataURL(this.files[0]);
     }
     });*/
</script>