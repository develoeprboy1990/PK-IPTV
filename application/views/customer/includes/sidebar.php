  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= DEFAULT_ASSETS ?>logo.png" class="img-circle" alt="User Management System">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->first_name. ' '. $this->session->last_name; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

          <li><a href="<?= BASE_URL?>customer"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>          
                
          <li class="<?=isset($main_nav) && ($main_nav=='os') ? 'active' : ''?>">
            <a href="<?=site_url('customer/channelGroups')?>">
              <i class="fa fa-wrench"></i>
              <span>Channel Groups</span>
            </a>
          </li>

          <li class="<?=isset($main_nav) && ($main_nav=='os') ? 'active' : ''?>">
            <a href="<?=site_url('customer/devices')?>">
              <i class="fa fa-wrench"></i>
              <span>Devices</span>
            </a>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-handshake-o"></i>
              <span>Settings</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= BASE_URL ?>customer/index/3"><i class="fa fa-list"></i> Update Profile </a></li>
              <li><a href="<?= BASE_URL ?>customer/changePassword"><i class="fa fa-plus"></i> Change Password </a></li>
            </ul>
          </li>

          <li><a href="<?= BASE_URL?>customer/logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>