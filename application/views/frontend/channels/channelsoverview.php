<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(11);  // channel module id
if(!isset($is_allow))
{   
   redirect('login', 'refresh');
}
?>  
<div class="content-wrapper">
    <section class="content-header">
      <?php echo $page_title; ?>
      <?php echo $breadcrumb; ?>
    </section> 
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Channels Overview</h3>
              </div>

              <!-- /.box-header -->
              <div class="box-body">
                <div id="ajax_search_responce" class="table-responsive">
                  <?php if($responce = $this->session->flashdata('success')){ ?>
                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                  <?php } ?>
                  <table id="channels" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>C No</th>	
                      <th>Logo</th>								  
                      <th>Channel Name</th>									 
                      <th>EPG Name</th>
                      <th>Server/url</th>
                      <th>DVR</th>
                      <th>Catchup/URL</th>	
                      <th>Show Home</th>										  
                      <th>Status</th>
                      <th>Edit</th>
                    </tr> 
                  </thead>
                  <tbody>
                    <?php foreach($channels as $channel){?>
                       <tr>
                        <td><?=@$channel['id']?></td>
                        <td><?=@$channel['channel_number']?></td> 
                				<td><img src="<?php echo base_url().LOCAL_PATH_IMAGES_CMS. @$channel['channel_image_icon']; ?>" width="30" /></td>
                        <td><?=@$channel['channel_name']?></td>										
                				
                				<td><?php echo @$epg_arr['epg_'.$channel['epg_name']]; ?></td>
                				<td><?php echo @$server_urls['high_server_'.$channel['server_url_high']].$channel['url_high'];?></td>
                				<td><?=(@$channel['is_flussonic']==1) ? '<span style="color:green;">On</span>' : '<span style="color:red;">Off</span>'; ?></td>
                				<td><?php echo @$catchup_server_urls['catchup_server_'.$channel['server_url_interactivetv']]. @$channel['url_interactivetv']?></td>
                				<td><?=(@$channel['show_on_home']==1) ? '<span style="color:green;">Yes</span>' : '<span style="color:red;">No</span>'; ?></td>
                        <td><?=(@$channel['status']==1) ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Inactive</span>'?></td>
                        <td><?php echo btn_edit(BASE_URL.'channels/details/'.@$channel['id'])?></td>
                      </tr> 
                    <?php } ?>
                  </tbody>
                </table>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
         </div>
      </div>
    </section>
</div>
