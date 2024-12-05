 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Logged In Customers</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div id="ajax_search_responce">
                <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Username/Pin</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Last Logged in </th>
                  </tr> 
                </thead>
                
                <tbody>
                  <?php foreach($logged_in_customers as $customer){?>
                    <tr>
                      <td><?=$customer->username?></td>
                      <td><?=base64_decode($customer->password)?></td>
                      <td><?=$customer->email?></td>
                      <td><?=date('Y-m-d H:i:s',$customer->last_login)?></td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Subscription</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Username/Pin</th>
                    <th>Subscription Item</th>
                    <th>Subscription Date</th>
                    <th>Subscription Expire</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($latest_subscriptions as $subscription){ ?>
                    <tr>
                      <td><?=$subscription->username?></td>
                      <td><?=$subscription->name?></td>
                      <td><?=$subscription->date_used?></td>
                      <td><?=$subscription->subscription_expire?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> -->
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Subscriptions</a>
            </div>
            <!-- /.box-footer -->
          </div>  
        </div>

        <div class="col-lg-6 col-xs-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Expiring Customers</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div>
                <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Username/Pin</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Expires On</th>
                  </tr>  
                </thead>
                
                <tbody>
                  <?php foreach($expiring_customers as $customer){?>
                   <tr>
                      <td><?=$customer->username?></td>
                      <td><?=$customer->mobile?></td>
                      <td><?=$customer->email?></td>
                      <td><?=$customer->subscription_expire?></td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>  
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->