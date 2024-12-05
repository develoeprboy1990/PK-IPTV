 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>customer"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->

    <section class="content">
      <div class="row">
        <div class="col-md-12">
        <?php if($responce = $this->session->flashdata('success')){ ?>
            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
        <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <!-- About Me Box -->
          <div class="box box-primary">
           
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Subscription Package</strong><br />
              <strong><?=$product->name?></strong>
              <p class="text-muted">
                Expires on <?=$user_info->date_expired?>
              </p>
              
              <hr>
              <strong><i class="fa fa-pencil margin-r-5"></i> Devices Attached</strong>
              <p><?php foreach($devices as $device){?> <span class="label label-success"><?=$device->model_name?></span> <?php }?></p>

              <hr>
              <strong><i class="fa fa-pencil margin-r-5"></i> Channel Groups</strong>
              <p><?php foreach($channels_groups as $group){?> <span class="label label-info"><?=$group->name?></span> <?php }?></p>


              <hr>
              <strong><i class="fa fa-pencil margin-r-5"></i> Channels</strong>
              <p>
                <?php foreach($channels as $channel){?>
                  <img src="<?=base_url()."uploads/channels/logo/".$channel->channel_image?>" alt="<?=$channel->channel_name?>" width="70" style="margin-bottom:10px;">
                <?php }?>
              </p>

              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
              <p class="text-muted"><?=($user_info->city) ? $user_info->city."," : ""?> <?=($user_info->country) ? $user_info->country : ""?></p>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="#tab_1" data-toggle="tab">News</a></li>
              <li><a href="#tab_2" data-toggle="tab">Timeline</a></li>
              <li><a href="#tab_3" data-toggle="tab">Settings</a></li>
              <li><a href="#tab_4" data-toggle="tab">Messages</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="tab_1">
                <!-- Post -->
                <div class="post">
                  <p>
                    Lorem ipsum represents a long-held tradition for designers,
                    typographers and the like. Some people hate it and argue for
                    its demise, but others ignore the hate as they create awesome
                    tools to help create filler text for everyone from bacon lovers
                    to Charlie Sheen fans.
                  </p>
                  <!-- <ul class="list-inline">
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                    </li>
                    <li class="pull-right">
                      <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                        (5)</a></li>
                  </ul> -->

                  <!-- <input class="form-control input-sm" type="text" placeholder="Type a comment"> -->
                </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_3">
                <form method="post" action="<?=site_url('customer/updateProfile')?>" class="form-horizontal">
                  <input type="hidden" name="user_id" value="<?=$user_id?>">
                  <div class="form-group">
                    <label for="first_name" class="col-sm-2 control-label">First Name *</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$user_info->first_name?>" placeholder="First Name" required>
                      <span class="text-danger"><?= form_error('first_name'); ?></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="last_name" class="col-sm-2 control-label">Last Name *</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$user_info->last_name?>" placeholder="Last Name" required>
                      <span class="text-danger"><?= form_error('last_name'); ?></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email *</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="email" name="email" value="<?=$user_info->email?>" placeholder="Email" required>
                      <span class="text-danger"><?= form_error('email'); ?></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Phone *</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="phone" name="phone" value="<?=$user_info->phone?>" placeholder="Phone" required>
                      <span class="text-danger"><?= form_error('phone'); ?></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="mobile" class="col-sm-2 control-label">Mobile *</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="c_mobile" name="c_mobile" value="<?=$user_info->c_mobile?>" placeholder="Mobile" required>
                      <span class="text-danger"><?= form_error('mobile'); ?></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="billing_country" class="col-sm-2 control-label">Country *</label>
                    <div class="col-sm-4">
                        <select id="billing_country" name="billing_country" class="form-control" required>
                          <option selected>Please Select Country</option>
                          <?php foreach($countries as $country){?>
                              <option value="<?=$country->id?>" <?=($country->id==$user_info->billing_country) ? "selected":""?>><?=$country->name?></option>
                          <?php }?>
                        </select>
                        <span class="text-danger"><?= form_error('billing_country'); ?></span>
                    </div>
                  </div>
               
                  <div class="form-group">
                    <label for="billing_state" class="col-sm-2 control-label">State *</label>
                    <div class="col-md-4">
                      <select id="billing_state" name="billing_state" class="form-control" required>
                        <?php foreach($billing_states as $state){?>
                            <option value="<?=$state->id?>" <?=($state->id==$user_info->billing_state) ? "selected":""?>><?=$state->name?></option>
                        <?php }?>
                      </select>
                      <span class="text-danger"><?= form_error('billing_state'); ?></span>
                    </div>
                  </div>
  
                  <div class="form-group">
                    <label for="billing_city" class="col-sm-2 control-label">City *</label>
                    <div class="col-md-4">
                        <select id="billing_city" name="billing_city" class="form-control" required> 
                          <?php foreach($billing_cities as $city){?>
                            <option value="<?=$city->id?>" <?=($city->id==$user_info->billing_city) ? "selected":""?>><?=$city->name?></option>
                        <?php }?>
                        </select>
                        <span class="text-danger"><?= form_error('billing_city'); ?></span>
                    </div>
                  </div> 
            
                  <div class="form-group">
                    <label for="billing_street" class="col-sm-2 control-label">Street *</label>
                    <div class="col-sm-4">
                     <input type="text" id="billing_street" name="billing_street" class="form-control" value="<?=$user_info->billing_street?>" placeholder="Street" required/>
                     <span class="text-danger"><?= form_error('billing_street'); ?></span>
                    </div>
                  </div>
              
                  <div class="form-group">
                    <label for="billing_zip" class="col-sm-2 control-label">Zip *</label>
                    <div class="col-sm-4">
                     <input type="text" id="billing_zip" name="billing_zip" class="form-control" value="<?=$user_info->billing_zip?>" placeholder="Zip" required/>
                     <span class="text-danger"><?= form_error('billing_zip'); ?></span>
                    </div>
                  </div>
         
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="tab-pane" id="tab_4">
                 <table id="messages" class="table table-bordered table-striped table-hover" style="width: 100%;">
                    <thead>
                      <tr>
                        <th width="80%">Subject</th>
                        <th width="20%">Date</th>
                      </tr> 
                    </thead>
                    
                    <tbody> 
                  
                      <?php foreach($messages as $msg){?>
                      <tr class="message-popup" data-a="<?=$msg['id']?>">                        
                        <td><?=$msg['subject']?></th>
                        <td><?=$msg['created_date']?></th>
                      </tr>  
                    <?php }?>
                    </tbody>
                  </table>
              </div>

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--  Modal Messages Popup -->
<div class="modal fade" id="modal-message">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content loader-parent">
            <div class="modal-header">
                <h5 class="modal-title">Message Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    
                </div>
            </div>
        </div>
    </div>
</div>