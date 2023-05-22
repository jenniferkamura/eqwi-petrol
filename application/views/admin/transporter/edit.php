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
                            <label>Transporter Type</label>
                            <select class="form-control" name="employment_type">
                                <option value="Own Employee" <?= isset($user_data) && $user_data->employment_type == 'Own Employee' ? 'selected=""' : '' ?>>Own Employee</option>
                                <option value="Freelancer" <?= isset($user_data) && $user_data->employment_type == 'Freelancer' ? 'selected=""' : '' ?>>Freelancer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Document Type</label>
                            <input type="text" class="form-control" name="document_type" value="<?= $documents && $documents->document_type ? $documents->document_type : 'Driving License' ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Document Number</label>
                            <input type="text" class="form-control" name="document_number" placeholder="Enter document number" value="<?= $documents && $documents->document_number ? $documents->document_number : '' ?>">
                        </div>
                        <div class="col-md-12">
                            <label>Front Photo</label>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <?php
                                    $front_photo = $documents ? $documents->front_photo : '';
                                    ?>
                                    <a href="<?= $front_photo != '' ? getImage('user_documents', $front_photo) : 'javascript:void(0);' ?>" target="_blank" >
                                        <img id="front_photo" src="<?= getImage('user_documents', $front_photo) ?>" height="200" width="200">
                                    </a>
                                </div>
                                <?php if ($front_photo != '') { ?>
                                    <div class="form-group col-md-6">
                                        <a class="btn btn-primary" href="<?= getImage('user_documents', $front_photo) ?>" download="" title="Download">Download Document</a>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="button" class="btn btn-danger" name="del_doc" onclick="delete_doc()" value="Delete Document" title="Delete">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control doc_img" data-id="front_photo" name="front_photo">
                            </div>
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
                        <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/transporter") ?>'">Cancel</button>
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
                    remote: {url: "<?= base_url('admin/transporter/check_user_exists') ?>", type: "post",
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
                    remote: {url: "<?= base_url('admin/transporter/check_user_exists') ?>", type: "post",
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
                    remote: {url: "<?= base_url('admin/transporter/check_user_exists') ?>", type: "post",
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
    });

    $(document).on('change', '.doc_img', function () {
        var _id = $(this).attr('data-id');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + _id).attr('src', e.target.result);
                $('#' + _id).parent().attr('href', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    function delete_doc() {
        if (confirm("Are you sure, you want to delete document?")) {
            location.href = '<?= base_url('admin/transporter/delete_document/' . $user_id) ?>';
        }
    }
</script>