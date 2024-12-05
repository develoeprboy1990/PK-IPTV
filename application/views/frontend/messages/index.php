 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
    </section>
 
    <!-- Main content -->
     <section class="content loader-parent">
        <div class="row">
          <div class="col-md-12">
                <?php if($responce = $this->session->flashdata('success')){ ?>
                    <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                <?php } ?>

                <?php if($responce = $this->session->flashdata('error')){ ?>
                    <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $responce;?></div>
                <?php } ?>
                <div class="message-container"></div>
                <div class="box">
                  <?php if($is_allow->allow_create) {?> 
                    <div class="box-header with-border">
                        <h3 class="box-title">
                          <a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat btn-add-message"><i class="fa fa-plus"></i> Add a Message</a>
                        </h3>
                    </div>
                  <?php } ?>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div id="ajax_search_responce">
                      <table id="messages" class="table table-bordered table-striped " style="width: 100%;">
                      <thead>
                        <tr>
                          <th width="20%">Date</th>
                          <th width="40%">Subject</th>
                          <th width="20%">Status</th>
                          <th width="20%">Action</th>
                        </tr> 
                      </thead>
                      
                      <tbody>                
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

  <div class="modal fade" id="modal-delete-confirmation-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Message ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-delete-message-confirmed">Delete</button>
            </div>
        </div>
    </div>
  </div>

<!--  Modal Create Contact Persons -->
<div class="modal fade" id="modal-create-message">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content loader-parent">
            <div class="modal-header">
                <h5 class="modal-title">Add a Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    <?=form_open('', ['id' => 'form-create-message', 'class' => 'cmxform']);?>
                    <div class="message-container"></div>
                    <div class="clearfix">         
                        <div class="form-group clearfix">
                            <label for="name">Subject</label>
                            <?=form_input(['name' => 'subject', 'id' => 'subject', 'class' => 'form-control']);?>
                        </div>
                        
                        <div class="form-group">
                          <label for="body">Message Body</label> 
                           <textarea id="body" name="body" class="form-control" /></textarea>
                        </div>
                       
                        <div class="form-group clearfix">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                    <?=form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-message">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content loader-parent">
            <div class="modal-header">
                <h5 class="modal-title">Edit Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    <?=form_open('', ['id' => 'form-update-message', 'class' => 'cmxform']);?>
                    <div class="message-container"></div>
                     <div class="clearfix">
                        <div class="form-group clearfix">
                            <label for="name">Subject</label>
                            <?=form_input(['name' => 'subject', 'id' => 'subject', 'class' => 'form-control']);?>
                        </div>

                        <div class="form-group">
                          <label for="updated-body">Message Body</label>
                          <textarea id="updated-body" name="body" class="form-control"/></textarea>
                        </div>
                       
                        <div class="form-group clearfix">
                            <input type="hidden" name="id" value="" />
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    <?=form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-send-confirmation-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group clearfix">
                    <label for="name">Send To</label>
                      <select multiple data-role="tagsinput" class="form-control" id="send-to" name="send_to">
                        <?php foreach($customers as $cust){?>
                          <option value="<?=$cust['email']?>"><?=$cust['email']?></option>
                        <?php } ?>
                      </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-send-message-confirmed">Send</button>
            </div>
        </div>
    </div>
  </div>