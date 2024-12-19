<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(45);  // channel module id

if(!isset($is_allow))
{    
   redirect('login', 'refresh');
}
?>  
<!-- Add this style section at the top of index.php -->
<style>
.btn-group {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
}

.btn-group .btn {
  padding: 2px 4px;
  font-size: 11px;
}

@media (max-width: 768px) {
  .btn-group {
    flex-direction: column;
    gap: 5px;
  }
  
  .btn-group .btn {
    width: 100%;
  }
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $page_title; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                  <?php if($is_allow->allow_create) {?> 
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo anchor('series/create/', '<i class="fa fa-plus"></i> '.$add_text, array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                    </div>
                  <?php } ?>

                  <!-- /.box-header -->
                  <div class="box-body">
                    <div id="ajax_search_responce" class="table-responsive">
                      <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                      <?php } ?>
                      <table id="series" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Images</th>
                              <th>Store</th>
                              <th class="ott_platforms_row">OTT Platforms</th>
                              <th class="tv_platforms_row">TV Show Platforms</th>
                              <th>Language</th>
                              <th>Daily Episode Update</th>
                              <th></th>
                              <th>Actions</th>
                            </tr> 
                          </thead>
                          <tbody>
                            <?php 
                			/*echo '<pre>';
                			print_r($series);*/
                			foreach($series as $key=>$serie){?>
                              <tr>
                                <td><a href="<?=site_url('series/edit/'.$serie['id'])?>"><?=$serie['id']?></a></td>										
                                <!--<td><?php echo "<a href='".site_url('series/seasons/'.$serie['id'])."'>".ucwords($serie['name'])."</a>"?></td>                                   -->
                				<td><?php echo ucwords($serie['name']); ?></td>                                   
                				<td><img src="<?php  echo BASE_URL.LOCAL_PATH_IMAGES_CMS.$serie['logo'];?>" width="100" /></td>
                				<td><?=$serie['store_name']?></td>
                                <td class="ott_platforms_row">
                                     <?php
                                    if (empty($serie['ott_platforms'])) {
                                        echo "No Selection";
                                    } else {
                                        $series_platforms = explode(',', $serie['ott_platforms']);
                                        $platform_string = '';
                                        foreach ($series_platforms as $val) {
                                            $platform_string .= @$ott_platforms['platform_'.$val].' , ';
                                        }
                                        echo rtrim($platform_string, ' , ');
                                    }
                                    ?>
                                </td>
                                <td class="tv_platforms_row">
                                <?php
                                if (empty($serie['tv_show_platforms'])) {
                                    echo "No Selection";
                                } else {
                                    $series_platforms = explode(',', $serie['tv_show_platforms']);
                                    $platform_string = '';
                                    foreach ($series_platforms as $val) {
                                        $platform_string .= @$tv_platforms['platform_'.$val].'('.@$tv_platforms['language_'.$val].')'.' , ';
                                    }
                                    echo rtrim($platform_string, ' , ');
                                }
                                ?>
                                </td>


                                <td><?=$serie['language_name']?></td>    				
                				<th>
                                    <?php if($serie['episode_update'] == '1'){ echo '<span style=" color:#009900;">ON</span>';}else{ echo '<span style="color:red;">OFF</span>'; } ?>
                                </th>    				
                                <td>
                                    <span class="box-title"><?php echo anchor('series/seasons/'.$serie['id'], '<i class="fa fa-eye"></i> View Seasons', array('class' => 'btn btn-block btn-primary btn-flat')); ?></span>
                                </td>
                                <td>

                                    <div class="btn-group" role="group">

                                       <a href="<?php echo BASE_URL.'series/edit/'.$serie['id']?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>

                                        <a href="<?php echo  BASE_URL.'series/delete/'.$serie['id']?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?');">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
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