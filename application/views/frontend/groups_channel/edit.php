 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?= $page_title ?>
      <?php echo $breadcrumb; ?>
    </section>

     <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>groups_channel/edit/<?= $groups_detail->id; ?>">

              <div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="name">Name</label>
                  <input type="text" id="name" name="name" value="<?= $groups_detail->name; ?>" class="form-control"/>
                  <span class="text-danger"><?= form_error('name'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="position">Position</label>
                  <input type="text" id="position" name="position" value="<?= $groups_detail->position; ?>" class="form-control"/>
                  <span class="text-danger"><?= form_error('position'); ?></span>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6 text-center">
                  <button type="submit" class="btn btn-success ">Edit Group</button>
                </div>
              </div>

            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->