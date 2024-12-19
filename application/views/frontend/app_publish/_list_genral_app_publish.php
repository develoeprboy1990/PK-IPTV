<div class="box box-primary">
    <div class="box-header">
      <h4>General</h4>
      <div class="pull-right">

        <?php
        // Get active record for copy URL
        $activeRecord = $this->App_publish_m->getActiveRecord('General');
        if($activeRecord) {
            $appUrl = $activeRecord->url;
        }
        ?>
        <button class="btn btn-info copy-app-url" data-url="<?php echo isset($appUrl) ? $appUrl : ''; ?>">
            <i class="fa fa-copy"></i> Copy App URL
        </button>


        <!-- <button class="btn btn-info copy-download-link" data-type="General">
          <i class="fa fa-copy"></i> Copy Download Link
        </button> -->
        
        <a href="<?php echo base_url('app_publish/download/General'); ?>" class="btn btn-success" target="_blank">
            <i class="fa fa-download"></i> Download General App
        </a>
        <button class="btn btn-primary publish-app" data-type="General">
            Publish General App
        </button>
      </div>
    </div>
    <div class="box-body">
      <div id="ajax_search_responce" class="table-responsive">
        <table id="activation-keys" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Sr No</th>
              <th>Version No</th>
              <th>Title</th>
              <th>Date</th>
              <th>Status</th>
              <th>Force Update</th>
              <th>Action</th>
            </tr> 
          </thead>          
          <tbody>
            <?php 
            $sr_no = 1;
            foreach($generals as $key){?>
             <tr>
                <td><?php echo $sr_no++; ?></td>
                <td><?php echo $key['version_number']; ?></td>
                <td><?php echo $key['title']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($key['date'])); ?></td>
                <td>
                  <label class="switch">
                    <input type="checkbox" class="status-toggle" data-id="<?php echo $key['id']; ?>" 
                    data-type="<?php echo $key['type']; ?>" <?php echo ($key['status']=='1') ? "checked" : ""; ?>>
                    <span class="slider round"></span>
                  </label>
                </td>
                <td><?php echo $key['forceupdate'] == '1' ? 'True' : 'False'; ?></td>
                <td>
                  <button class="btn btn-info btn-sm view-details" data-id="<?php echo $key['id']; ?>">
                    <i class="fa fa-eye"></i> View
                  </button>

                  <button class="btn btn-warning btn-sm edit-record" data-id="<?php echo $key['id']; ?>">
                    <i class="fa fa-edit"></i> Edit
                  </button>

                  <button class="btn btn-danger btn-sm delete-record" data-id="<?php echo $key['id']; ?>">
                    <i class="fa fa-trash"></i> Delete
                  </button>
                </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
</div>

<!-- Modal for displaying details -->
<div class="modal fade" id="detailsGeneralModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">App Publish Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalGeneralBody">
        <!-- Details will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>