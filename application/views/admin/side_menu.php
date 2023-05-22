<?php
$admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
$admin_menu = $this->common_model->get_menu_details($admin_id);
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php
            $segment_uri = $this->uri->segments;
            $url1 = $segment_uri[2];
            $url2 = isset($segment_uri[3]) ? $segment_uri[3] : '';

            $menu_url = $custom_active_sub_url = 'admin/' . $url1 . ($url2 != '' ? '/' . $url2 : '');
            $menu_url = str_replace('/edit', '', $menu_url);

            //echo '<pre>';print_r($admin_menu);die;
            if ($this->common_model->check_menu_privilege($admin_id, $menu_url, 'list_p', $is_super_admin) && $admin_menu) {
                foreach ($admin_menu as $menu) {
                    if ($menu->list_p) {
                        $treeview = $menu->sub_menu ? 'treeview' : '';
                        ?>
                        <li class="<?= $treeview ?> <?= $menu->sub_menu ? ($url1 == strtolower($menu->menu_name) ? 'active' : '') : ($menu_url == $menu->menu_url ? 'active' : '') ?>">
                            <a href="<?= base_url($menu->menu_url) ?>"><i class="<?= $menu->menu_icon ?>"></i>
                                <span><?= $menu->menu_name ?></span>

                                <?php if ($menu->sub_menu) { ?>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                <?php } ?>
                            </a>
                            <?php if ($menu->sub_menu) { ?>
                                <ul class="treeview-menu">
                                    <?php
                                    foreach ($menu->sub_menu as $sub_menu) {
                                        ?>
                                        <li class="<?= $custom_active_sub_url == $sub_menu->menu_url ? 'active' : '' ?>">
                                            <a href="<?= base_url($sub_menu->menu_url) ?>"><i class="<?= $sub_menu->menu_icon ?>"></i>
                                                <span><?= $sub_menu->menu_name ?></span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            <?php } ?>
                        </li>
                        <?php
                    }
                }
            }

            /* $segment_uri = $this->uri->segments;
              $url1 = $segment_uri[2];
              $url2 = isset($segment_uri[3]) ? $segment_uri[3] : '';

              $menu_url = $custom_active_sub_url = 'admin/' . $url1 . ($url2 != '' ? '/' . $url2 : '');
              $menu_url = str_replace('/edit', '', $menu_url);

              //echo '<pre>';print_r($admin_menu);die;
              if ($this->common_model->check_menu_privilege($admin_id, $menu_url, 'list_p', $is_super_admin) && $admin_menu) {
              foreach ($admin_menu as $menu) {
              if ($menu->list_p) {
              $treeview = $menu->sub_menu ? 'treeview' : '';

              $sel_menu = $menu->sub_menu ? explode(',', $menu->sub_menu) : array();
              ?>
              <li class="<?= $treeview ?> <?= $menu->sub_menu ? (in_array($menu->id, $sel_menu) ? 'active' : '') : ($menu_url == $menu->menu_url ? 'active' : '') ?>">
              <a href="<?= base_url($menu->menu_url) ?>"><i class="<?= $menu->menu_icon ?>"></i>
              <span><?= $menu->menu_name ?></span>

              <?php if ($menu->sub_menu) { ?>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span>
              <?php } ?>
              </a>
              <?php if ($menu->sub_menu) { ?>
              <ul class="treeview-menu">
              <?php
              foreach ($menu->sub_menu as $sub_menu) {
              ?>
              <li class="<?= $custom_active_sub_url == $sub_menu->menu_url ? 'active' : '' ?>">
              <a href="<?= base_url($sub_menu->menu_url) ?>"><i class="<?= $sub_menu->menu_icon ?>"></i>
              <span><?= $sub_menu->menu_name ?></span>
              </a>
              </li>
              <?php
              }
              ?>
              </ul>
              <?php } ?>
              </li>
              <?php
              }
              }
              } */
            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>