<section class="content">
    <!-- Small boxes (Stat box) -->

    <div class="row">
        <?php
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $privilege_owner = $this->common_model->get_menu_privilege($admin_id, "admin/owner");
        if ($privilege_owner && $privilege_owner->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/owner') ?>" class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $count_owners ?></h3>
                        <p>Owners</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_manager = $this->common_model->get_menu_privilege($admin_id, "admin/manager");
        if ($privilege_manager && $privilege_manager->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/manager') ?>" class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $count_managers ?></h3>
                        <p>Managers</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_attendant = $this->common_model->get_menu_privilege($admin_id, "admin/attendant");
        if ($privilege_attendant && $privilege_attendant->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/attendant') ?>" class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $count_attendants ?></h3>
                        <p>Attendants</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_transporter = $this->common_model->get_menu_privilege($admin_id, "admin/transporter");
        if ($privilege_transporter && $privilege_transporter->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/transporter') ?>" class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $count_transporters ?></h3>
                        <p>Transporters</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_station = $this->common_model->get_menu_privilege($admin_id, "admin/station");
        if ($privilege_station && $privilege_station->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/station') ?>" class="small-box bg-orange">
                    <div class="inner">
                        <h3><?= $count_stations ?></h3>
                        <p>Stations</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_vehicle = $this->common_model->get_menu_privilege($admin_id, "admin/vehicle");
        if ($privilege_vehicle && $privilege_vehicle->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/vehicle') ?>" class="small-box bg-blue">
                    <div class="inner">
                        <h3><?= $count_vehicles ?></h3>
                        <p>Vehicles</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-truck"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_vendor = $this->common_model->get_menu_privilege($admin_id, "admin/vendor");
        if ($privilege_vendor && $privilege_vendor->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/vendor') ?>" class="small-box bg-aqua-gradient">
                    <div class="inner">
                        <h3><?= $count_vendors ?></h3>
                        <p>Vendors</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_product = $this->common_model->get_menu_privilege($admin_id, "admin/product");
        if ($privilege_product && $privilege_product->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/product') ?>" class="small-box bg-orange-active">
                    <div class="inner">
                        <h3><?= $count_products ?></h3>
                        <p>Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-product-hunt"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_feedbacks = $this->common_model->get_menu_privilege($admin_id, "admin/feedbacks");
        if ($privilege_feedbacks && $privilege_feedbacks->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/feedbacks') ?>" class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $count_feedbacks ?></h3>
                        <p>Feedbacks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-commenting-o"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_completed_order = $this->common_model->get_menu_privilege($admin_id, "admin/orders/status");
        if ($privilege_completed_order && $privilege_completed_order->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="<?= base_url('admin/orders/status/Completed') ?>" class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $count_orders ?></h3>
                        <p>Completed Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_pending_order = $this->common_model->get_menu_privilege($admin_id, "admin/orders/status");
        if ($privilege_pending_order && $privilege_pending_order->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6"> 
                <!-- small box -->
                <a href="<?= base_url('admin/orders/status/Pending') ?>" class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $count_pending_orders ?></h3>
                        <p>Pending Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_vendor_purchase = $this->common_model->get_menu_privilege($admin_id, "admin/vendor_purchase");
        if ($privilege_vendor_purchase && $privilege_vendor_purchase->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6"> 
                <!-- small box -->
                <a href="<?= base_url('admin/vendor_purchase') ?>" class="small-box bg-blue">
                    <div class="inner">
                        <h3><?= $count_vendor_purchase ?></h3>
                        <p>Vendor Purchases</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_coupon = $this->common_model->get_menu_privilege($admin_id, "admin/coupon");
        if ($privilege_coupon && $privilege_coupon->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6"> 
                <!-- small box -->
                <a href="<?= base_url('admin/coupon') ?>" class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $count_coupons ?></h3>
                        <p>Coupons</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_pending_transactions = $this->common_model->get_menu_privilege($admin_id, "admin/transactions");
        if ($privilege_pending_transactions && $privilege_pending_transactions->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6"> 
                <!-- small box -->
                <a href="<?= base_url('admin/transactions') ?>" class="small-box bg-orange">
                    <div class="inner">
                        <h3><?= $count_pending_transaction ?></h3>
                        <p>Pending Transactions</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        $privilege_paid_transactions = $this->common_model->get_menu_privilege($admin_id, "admin/transactions");
        if ($privilege_paid_transactions && $privilege_paid_transactions->list_p == 1) {
            ?>
            <div class="col-lg-3 col-xs-6"> 
                <!-- small box -->
                <a href="<?= base_url('admin/transactions') ?>" class="small-box bg-blue">
                    <div class="inner">
                        <h3><?= $count_paid_transaction ?></h3>
                        <p>Paid Transactions</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </a>
            </div>
            <?php
        }
        ?>
    </div> 
</section>