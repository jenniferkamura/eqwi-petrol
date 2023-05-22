<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-6 col-sm-offset-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile" style="padding-top: 30px;">

                    <form id="change_pass-form" action="" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Current Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Current password" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-3 control-label">New Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New password" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-3 control-label">Confirm Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm password" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<script>
    $(function () {
        $("#change_pass-form").validate({
            rules: {
                password: {required: true},
                newpassword: {
                    required: true,
                    minlength: 6
                },
                cpassword: {
                    required: true,
                    minlength: 6,
                    equalTo: "#newpassword"
                }
            },
            messages: {
                password: {required: "Enter current password"},
                newpassword: {required: "Enter new password"},
                cpassword: {
                    required: "Enter confirm new password",
                    equalTo: "New password and confirm password did not matched"
                }
            },
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
</script>