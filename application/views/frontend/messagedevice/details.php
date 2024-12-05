 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$pagetitle ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>messagedevice/details/<?php echo $msg_id;?>" enctype="multipart/form-data" class="form-horizontal">

              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-4">
                   <input type="text" id="title" name="title" class="form-control" value="<?php echo $details->title;?>" placeholder="Title"/>
                   <span class="text-danger"><?= form_error('title'); ?></span>
                  </div>
                </div> 
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="cover" class="col-sm-2 control-label">Image (215 X 215)</label>
                  <div class="col-sm-4">
                   <input type="file" id="image_msg" name="image_msg"/>
				   <img src="<?php echo LOCAL_PATH_IMAGES_CRMD.$details->image_msg;?>" />
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <!--<input type="text" id="description" name="description" class="form-control" value="" placeholder="Description"/>-->
				   <textarea class="form-control" id="description" name="description"><?php echo $details->title;?></textarea>
                   <span class="text-danger"><?= form_error('description'); ?></span>
                  </div>
                </div>
              </div>

              

              

              

              

              <div class="row"> 
                <div class="form-group">
                  <label for="date_start" class="col-sm-2 control-label">Start Date</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="start_date" name="start_date" value="<?php echo date('Y-m-d',strtotime($details->start_date));?>" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>

              
       <div class="row"> 
                <div class="form-group">
                  <label for="date_start" class="col-sm-2 control-label">End Date</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="end_date" name="end_date" value="<?php echo date('Y-m-d',strtotime($details->end_date));?>">
                    </div>
                  </div>
                </div>
              </div>
              

              

              

              

              

              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Add <?=$title?></button>
                  </div>
                </div>
              </div>

            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


 