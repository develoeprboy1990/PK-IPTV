  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
      
		<div class="pull-left image">
          <!--<img src="<?= DEFAULT_ASSETS ?>logo.png" class="img-circle" alt="User Management System">-->
		  <img src="<?= DEFAULT_ASSETS ?>logo-general.png"style="width: 120px !important;max-width: 120px !important;margin-top: -39px;margin-left: -35px;" class="img-circle" alt="User Management System">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->first_name. ' '. $this->session->last_name; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> 
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

          <li><a href="<?= BASE_URL?>dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
          <?php if(!empty($this->ion_auth->checkPermission(83))){?>
          <li><a href="<?php echo site_url('stats/'); ?>"><i class="fa fa-tachometer"></i> <span>Statistics</span></a></li>   
          <?php }?>          

          <?php if(!empty($this->ion_auth->checkPermission(57))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='users') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Users & Roles</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(1))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='users') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>users"><i class="fa fa-list"></i> Users </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(9))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='role_groups') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>groups"><i class="fa fa-plus"></i> Roles </a></li>
            <?php }?>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(56))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='customers') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Customers & Devices</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(13))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='customers') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>customers"><i class="fa fa-list"></i> Customers </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(36))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='customer_devices') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>customer_devices"><i class="fa fa-plus"></i> Devices </a></li>
            <?php }?>
			
			<?php if(!empty($this->ion_auth->checkPermission(75))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='messagedevice') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>messagedevice"><i class="fa fa-plus"></i> Message to all Devices </a></li>
            <?php }?>
			
            </ul>
          </li>
          <?php }?>
          
		   <?php if(!empty($this->ion_auth->checkPermission(62))){?>
		  <li class="treeview <?=isset($main_nav) && ($main_nav=='customerPanel') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Customers Web Service</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(63))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='subscription_plans') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>customerpanel"><i class="fa fa-list"></i> Subscription Plans </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(64))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='walletmoney') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>customerpanel/walletmoney"><i class="fa fa-plus"></i> Wallet </a></li>
            <?php }?>
			
			 <?php if(!empty($this->ion_auth->checkPermission(76))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='subscriptiongroup') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>customerpanel/subscriptiongroup"><i class="fa fa-plus"></i> Subscription Group </a></li>
            <?php }?>
            </ul>
          </li>
		  <?php } ?>
		  
		  
		   <?php if(!empty($this->ion_auth->checkPermission(69))){?>
		  <li class="treeview <?=isset($main_nav) && ($main_nav=='resellerweb') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Reseller & Web Service</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(70))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='reseller') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reseller"><i class="fa fa-list"></i> Reseller </a></li>
            <?php }?>

			<?php if(!empty($this->ion_auth->checkPermission(77))){?>
              
		   <li <?=isset($sub_nav) && ($sub_nav=='walletmoneycode') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reseller/resellermoneycode"><i class="fa fa-list"></i>Reseller Money Code</a></li>
		   
            <?php }?>
			
			<?php if(!empty($this->ion_auth->checkPermission(71))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='walletpayment') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reseller/walletpayment"><i class="fa fa-list"></i>Wallet Money</a></li>
            <?php }?>
			
		<!--	<?php if(!empty($this->ion_auth->checkPermission(72))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='addcode') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reseller/addcode"><i class="fa fa-list"></i> Add Plans </a></li>
            <?php }?>-->
			
			<?php if(!empty($this->ion_auth->checkPermission(73))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='subscription') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reseller/subscription"><i class="fa fa-list"></i> Add Subscription Code </a></li>
            <?php }?>
			
            
            </ul>
          </li>
		  <?php } ?>
		  
		  
          <?php if(!empty($this->ion_auth->checkPermission(58))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='products') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Products & Services</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(35))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='services') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>services"><i class="fa fa-newspaper-o"></i> Services </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(34))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='devices') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>devices"><i class="fa fa-newspaper-o"></i> Devices</a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(37))){?> 
              <li <?=isset($sub_nav) && ($sub_nav=='gui_versions') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>gui_versions"><i class="fa fa-newspaper-o"></i> GUI Versions </a></li>
            <?php }?>
            
            <?php if(!empty($this->ion_auth->checkPermission(38))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='gui_settings') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>gui_settings"><i class="fa fa-newspaper-o"></i> GUI Settings </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(15))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='servers') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>servers"><i class="fa fa-newspaper-o"></i> Servers Url </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(20))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='products') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>products"><i class="fa fa-newspaper-o"></i> Products </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(74))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='resellerplans') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reseller/resellerplans"><i class="fa fa-plus"></i> Plans </a></li>
            <?php }?>
			
			 <?php if(!empty($this->ion_auth->checkPermission(20))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='user_interface') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>user_interface"><i class="fa fa-newspaper-o"></i> User Interface </a></li>
            <?php }?>
			
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(55))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='mi') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Menu Items</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(21))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='menus') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>menus"><i class="fa fa-newspaper-o"></i> Menu </a></li>
            <?php } ?>

            <?php if(!empty($this->ion_auth->checkPermission(39))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='menu_packages') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>menu_packages"><i class="fa fa-newspaper-o"></i> Packages </a></li>
            <?php } ?>
            </ul>
          </li>                             
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(22))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='vod') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Video on Demand</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(40))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='movie_stores') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>movie_stores"><i class="fa fa-newspaper-o"></i> Movie Stores </a></li>
            <?php }?>
            <?php if(!empty($this->ion_auth->checkPermission(41))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='movie_genres') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>movie_genres"><i class="fa fa-newspaper-o"></i> Movie Genres </a></li>
            <?php }?>
            <?php if(!empty($this->ion_auth->checkPermission(68))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='overviews') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>movies/overviews"><i class="fa fa-newspaper-o"></i> Movies Overviews </a></li>
            <?php }?>
			<?php if(!empty($this->ion_auth->checkPermission(43))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='movies') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>movies"><i class="fa fa-newspaper-o"></i> Movies </a></li>
            <?php }?>
            <?php if(!empty($this->ion_auth->checkPermission(61))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='movie_tags') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>movie_tags"><i class="fa fa-newspaper-o"></i> Tags </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(61))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='movie_ott_platforms') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>movie_ott_platforms"><i class="fa fa-newspaper-o"></i> OTT Platforms </a></li>
            <?php }?>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(23))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='sod') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Series on Demand</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(44))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='series_stores') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>series_stores"><i class="fa fa-newspaper-o"></i> Series Stores </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(45))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='series') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>series"><i class="fa fa-newspaper-o"></i> Series </a></li>
            <?php }?>
			
			 <?php if(!empty($this->ion_auth->checkPermission(80))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='daily_episode_update') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>daily_episode_update"><i class="fa fa-newspaper-o"></i> Daily Episode Update </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(45))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='series_ott_platforms') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>series_ott_platforms"><i class="fa fa-newspaper-o"></i> OTT Platforms </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(45))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='tv_show_platforms') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>tv_show_platforms"><i class="fa fa-newspaper-o"></i> TV Show Platforms </a></li>
            <?php }?>
			
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(24))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='mod') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Music on Demand</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

            <?php if(!empty($this->ion_auth->checkPermission(59))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='categories') ? 'class="active"' : ''?>><a href="<?=BASE_URL?>music_categories"><i class="fa fa-newspaper-o"></i> Categories </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(18))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='albums') ? 'class="active"' : ''?>><a href="<?=BASE_URL?>albums"><i class="fa fa-group"></i> Albums </a></li>
            <?php }?>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(25))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='tar') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Television and Radio</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(46))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='groups') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>groups_channel"><i class="fa fa-group"></i> Groups (Genres) </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(11))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='channels') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>channels"><i class="fa fa-newspaper-o"></i> Channels </a></li>
            <?php }?>
			<?php if(!empty($this->ion_auth->checkPermission(11))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='channelsoverview') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>channels/channelsoverview"><i class="fa fa-newspaper-o"></i> Channels Overview </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(47))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='packages') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>packages"><i class="fa fa-newspaper-o"></i> Packages </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(14))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='playlists') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>playlists"><i class="fa fa-newspaper-o"></i> Playlists </a></li>
            <?php }?>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(26))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='aaps') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Andriod Apps</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(48))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='app_categories') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>app_categories"><i class="fa fa-newspaper-o"></i> Categories </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(60))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='apps') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>app"><i class="fa fa-newspaper-o"></i> App </a></li>
            <?php }?>
            
            <?php if(!empty($this->ion_auth->checkPermission(49))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='app_packages') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>app_packages"><i class="fa fa-group"></i> Packages </a></li>
            <?php }?>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(27))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='advs') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Advertisements</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(50))){?> 
              <li <?=isset($sub_nav) && ($sub_nav=='banners') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>banners"><i class="fa fa-group"></i> Banners </a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(51))){?>   
              <li <?=isset($sub_nav) && ($sub_nav=='prerolls') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>prerolls"><i class="fa fa-newspaper-o"></i> Video Prerolls </a></li>
            <?php }?>
            
            <?php if(!empty($this->ion_auth->checkPermission(52))){?>   
              <li <?=isset($sub_nav) && ($sub_nav=='overlays') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>overlays"><i class="fa fa-newspaper-o"></i> Video Overlays </a></li>
            <?php }?>
            
            <?php if(!empty($this->ion_auth->checkPermission(53))){?>   
              <li <?=isset($sub_nav) && ($sub_nav=='tickers') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>tickers"><i class="fa fa-newspaper-o"></i> Video Tickers </a></li>
            <?php }?>
            </ul>
          </li>
          <?php }?>

           <?php if(!empty($this->ion_auth->checkPermission(33))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='news') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>News</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            <?php if(!empty($this->ion_auth->checkPermission(33))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='news_groups') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>news_groups"><i class="fa fa-group"></i> News Groups </a></li>
            <?php } ?>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(7))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='reports') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-black-tie"></i>
              <span>Reports</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(!empty($this->ion_auth->checkPermission(7))){?>
                <li <?=isset($sub_nav) && ($sub_nav=='analytics') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reports/analytics"><i class="fa fa-group"></i> Analytics </a></li>

                <li <?=isset($sub_nav) && ($sub_nav=='users_report') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>reports/users_report"><i class="fa fa-group"></i> Users Report </a></li>
              <?php }?>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(17))){?>
              <li <?=isset($main_nav) && ($main_nav=='homescreen') ? 'class="active"' : ''?>><a href="<?= BASE_URL?>homescreen"><i class="fa fa-newspaper-o"></i> <span>HomeScreen Items</span></a></li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(4))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='system') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-wrench"></i>
              <span>System</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(!empty($this->ion_auth->checkPermission(12))){?>
                <li <?=isset($sub_nav) && ($sub_nav=='security') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>securities"><i class="fa fa-envelope"></i> Security </a></li>
              <?php }?>
              
              <?php if(!empty($this->ion_auth->checkPermission(5))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='settings') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>settings"><i class="fa fa-envelope"></i> Settings </a></li>
              <?php }?>
			  
			   <?php if(!empty($this->ion_auth->checkPermission(5))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='epg') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>settings/epg"><i class="fa fa-envelope"></i> EPG </a></li>
              <?php }?>
			  
			  <?php if(!empty($this->ion_auth->checkPermission(5))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='epgcron') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>settings/epgCron"><i class="fa fa-envelope"></i>EPG Cron</a></li>
              <?php }?>
              
              <?php if(!empty($this->ion_auth->checkPermission(30))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='keys') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>keys"><i class="fa fa-envelope"></i> Generate Keys </a></li>
              <?php }?>

              <?php if(!empty($this->ion_auth->checkPermission(31))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='email_templates') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>email_templates"><i class="fa fa-envelope"></i> E-mail Templates </a></li>
              <?php }?>

              <?php if(!empty($this->ion_auth->checkPermission(31))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='sms_templates') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>sms_templates"><i class="fa fa-envelope"></i> SMS Templates </a></li>
              <?php }?>

              <?php //if(!empty($this->ion_auth->checkPermission(31))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='messages') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>messages"><i class="fa fa-envelope"></i>Messages</a></li>
              <?php //}?>

              <?php if(!empty($this->ion_auth->checkPermission(54))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='server_items_urls') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>server_items_urls"><i class="fa fa-file-text"></i> Cname Initials</a></li>
              <?php }?>

              <?php if(!empty($this->ion_auth->checkPermission(32))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='logs') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>logs"><i class="fa fa-file-text"></i> Logs </a></li>
              <?php }?>

              <?php if(!empty($this->ion_auth->checkPermission(42))){?>  
              <li <?=isset($sub_nav) && ($sub_nav=='languages') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>languages"><i class="fa fa-newspaper-o"></i>Languages </a></li>
            <?php }?>
			  
			 <?php if(!empty($this->ion_auth->checkPermission(79))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='pages') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>pages"><i class="fa fa-plus"></i>Pages</a></li>
            <?php }?>
			
			 <?php if(!empty($this->ion_auth->checkPermission(78))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='registrationOtp') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>registrationOtp/otp/1"><i class="fa fa-plus"></i>Registration OTP</a></li>
            <?php }?>

            <?php if(!empty($this->ion_auth->checkPermission(81))){?>
              <li <?=isset($sub_nav) && ($sub_nav=='app_publish') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>app_publish"><i class="fa fa-envelope"></i> App Publish </a></li>
              <?php }?>
			
            </ul>
          </li>
          <?php }?>
          
          <?php if(!empty($this->ion_auth->checkPermission(29))){?>
          <li class="treeview <?=isset($main_nav) && ($main_nav=='os') ? 'active' : ''?>">
            <a href="#">
              <i class="fa fa-wrench"></i>
              <span>Operator Settings</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li <?=isset($sub_nav) && ($sub_nav=='operator') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>operator"><i class="fa fa-tag"></i> Operator </a></li>
              <li <?=isset($sub_nav) && ($sub_nav=='main') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>operator/contact/main"><i class="fa fa-tag"></i> Main Contact </a></li>
              <li <?=isset($sub_nav) && ($sub_nav=='welcome') ? 'class="active"' : ''?>><a href="<?= BASE_URL ?>operator/contact/welcome"><i class="fa fa-envelope"></i> Welcome Contact </a></li>
            </ul>
          </li>
          <?php }?>

          <?php if(!empty($this->ion_auth->checkPermission(28))){?>
          <li <?=isset($main_nav) && ($main_nav=='publish') ? 'class="active"' : ''?>><a href="<?= BASE_URL?>publish"><i class="fa fa-newspaper-o"></i> <span>Publish</span></a></li>
          <li <?=isset($main_nav) && ($main_nav=='publish_vod_classic_ims') ? 'class="active"' : ''?>><a href="<?= BASE_URL?>publish_vod_classic_ims"><i class="fa fa-newspaper-o"></i> <span>Publish Classic IMS VOD</span></a></li>
          <?php }?>

          <li><a href="<?= BASE_URL?>logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>