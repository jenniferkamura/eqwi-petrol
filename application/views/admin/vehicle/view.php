<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Transporter Name</label>
                            <select class="form-control" name="user_id" required="" disabled="">
                                <option value="">Select Transporter</option>
                                <?php
                                if ($user_data) {
                                    foreach ($user_data as $user) {
                                        ?>
                                        <option value="<?= $user->user_id ?>" <?= isset($vehicle_data) && $vehicle_data->user_id == $user->user_id ? 'selected=""' : '' ?>><?= $user->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Vehicle Number</label>
                            <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" placeholder="Enter vehicle number" value="<?= isset($vehicle_data) && $vehicle_data->vehicle_number ? $vehicle_data->vehicle_number : '' ?>" autocomplete="off" required="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Vehicle Capacity</label>
                            <input type="text" class="form-control" id="vehicle_capacity" name="vehicle_capacity" placeholder="Enter vehicle capacity" value="<?= isset($vehicle_data) && $vehicle_data->vehicle_capacity ? $vehicle_data->vehicle_capacity : '' ?>" required="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Measurement</label>
                            <input type="text" class="form-control" name="measurement" placeholder="Enter measurement" value="<?= isset($vehicle_data) && $vehicle_data->measurement ? $vehicle_data->measurement : '' ?>" required="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Number of Compartment</label>
                            <input type="text" class="form-control" name="no_of_compartment" placeholder="Enter number of compartment" value="<?= isset($vehicle_data) && $vehicle_data->no_of_compartment ? $vehicle_data->no_of_compartment : '' ?>" required="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select class="form-control" name="status" disabled="">
                                <option value="1" <?= isset($vehicle_data) && $vehicle_data->status == 1 ? 'selected=""' : '' ?>>Active</option>
                                <option value="0" <?= isset($vehicle_data) && $vehicle_data->status == 0 ? 'selected=""' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Front Vehicle Image</label>
                            <?php
                            $vehicle_img1 = isset($vehicle_data) && $vehicle_data->front_vehicle_photo ? $vehicle_data->front_vehicle_photo : '';
                            ?>
                            <div>
                                <a href="<?= $vehicle_img1 != '' ? getImage('vehicle_photo', $vehicle_img1) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img1) ?>" id="PhotoPrev" height="80" width="80" ></a>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Back Vehicle Image</label>
                            <?php
                            $vehicle_img2 = isset($vehicle_data) && $vehicle_data->back_vehicle_photo ? $vehicle_data->back_vehicle_photo : '';
                            ?>
                            <div>
                                <a href="<?= $vehicle_img2 != '' ? getImage('vehicle_photo', $vehicle_img2) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img2) ?>" id="PhotoPrev" height="80" width="80" ></a>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Left Vehicle Image</label>
                            <?php
                            $vehicle_img3 = isset($vehicle_data) && $vehicle_data->left_vehicle_photo ? $vehicle_data->left_vehicle_photo : '';
                            ?>
                            <div>
                                <a href="<?= $vehicle_img3 != '' ? getImage('vehicle_photo', $vehicle_img3) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img3) ?>" id="PhotoPrev" height="80" width="80" ></a>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Right Vehicle Image</label>
                            <?php
                            $vehicle_img4 = isset($vehicle_data) && $vehicle_data->right_vehicle_photo ? $vehicle_data->right_vehicle_photo : '';
                            ?>
                            <div>
                                <a href="<?= $vehicle_img4 != '' ? getImage('vehicle_photo', $vehicle_img4) : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= getImage('vehicle_photo', $vehicle_img4) ?>" id="PhotoPrev" height="80" width="80" ></a>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Vehicle Document</label>
                            <?php
                            $vehicle_doc = isset($vehicle_data) && $vehicle_data->vehicle_document ? $vehicle_data->vehicle_document : '';
                            if ($vehicle_doc != '') {
                                ?>
                                <div>
                                    <a href="<?= $vehicle_doc != '' ? getImage('vehicle_photo', $vehicle_doc) : 'javascript:void(0);' ?>" download=""><?= $vehicle_doc != '' ? 'Download' : '' ?></a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Driving License</label>
                            <?php 
                            $driving_license = isset($vehicle_data) && $vehicle_data->driving_license_url ? $vehicle_data->driving_license_url : getImage('user_documents', '');
                            ?>
                            <div>
                                <a href="<?= $driving_license != '' ? $driving_license : 'javascript:void(0);' ?>" target="_blank" ><img src="<?= $driving_license ?>" id="PhotoPrev" height="80" width="80" ></a>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>License Number</label>
                            <input type="text" class="form-control" name="license_number" placeholder="Enter license number" value="<?= isset($vehicle_data) && $vehicle_data->license_number ? $vehicle_data->license_number : '' ?>" required="" readonly="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Vehicle Details</b></h3>
                        </div>
                        <?php
                        if ($vehicle_detail) {
                            foreach ($vehicle_detail as $detail) {
                                ?>
                                <div class="form-group col-md-4">
                                    <label><?= ordinal_number($detail->compartment_no) ?></label> Compartment Capacity
                                    <input type="text" class="form-control" value="<?= $detail->compartment_capacity ?>" readonly="">
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-default" onclick="location.href = '<?= base_url("admin/vehicle") ?>'">Cancel</button>
                </div>
            </div>

        </div>
    </div>
</section>