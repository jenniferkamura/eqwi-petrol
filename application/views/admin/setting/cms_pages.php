<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <form action="" method="post" id="cms_pages-form">
                    <?php
                    $about_body = $terms_body = $privacy_policy = '';
                    if (isset($setting_data) && $setting_data) {
                        foreach ($setting_data as $setting) {
                            if ($setting->title == 'about_body') {
                                $about_body = $setting->value;
                            }
                            if ($setting->title == 'terms_body') {
                                $terms_body = $setting->value;
                            }
                            if ($setting->title == 'privacy_policy') {
                                $privacy_policy = $setting->value;
                            }
                        }
                    }
                    ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>About Us</label>
                            <textarea id="about_body" name="about_body" required=""><?= $about_body ?></textarea>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Terms & Conditions</label>
                            <textarea id="terms_body" name="terms_body" required=""><?= $terms_body ?></textarea>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Privacy Policy</label>
                            <textarea id="privacy_policy" name="privacy_policy" required=""><?= $privacy_policy ?></textarea>
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
<script src="<?= base_url('assets/bower_components/ckeditor/ckeditor.js') ?>"></script>
<script>
    $(function () {
        CKEDITOR.replace('about_body');
        CKEDITOR.replace('terms_body');
        CKEDITOR.replace('privacy_policy');
    });
</script>