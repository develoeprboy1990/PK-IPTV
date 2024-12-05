 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
    </section>
 
    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>customers/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="id" value="<?=$details->id?>">
              <div class="row"> 
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-2">
                   <select id="title" name="title" class="form-control">
                     <option value="Mr." <?=($details->title=="Mr.") ? "selected": ""?>> Mr.</option>
                     <option value="Mrs." <?=($details->title=="Mrs.") ? "selected": ""?>> Mrs.</option>
                     <option value="Ms." <?=($details->title=="Ms.") ? "selected": ""?>> Ms.</option>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">First Name *</label>
                  <div class="col-sm-4">
                   <input type="text" id="first_name" name="first_name" class="form-control" value="<?=$details->first_name?>" placeholder="First Name" required/>
                   <span class="text-danger"><?= form_error('first_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Last Name *</label>
                  <div class="col-sm-4">
                   <input type="text" id="last_name" name="last_name" class="form-control" value="<?=$details->last_name?>" placeholder="Last Name" required/>
                   <span class="text-danger"><?= form_error('last_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="phone" class="col-sm-2 control-label">Phone *</label>
                  <div class="col-sm-4">
                   <input type="text" id="phone" name="phone" class="form-control" value="<?=$details->phone?>" placeholder="Phone" required/>
                   <span class="text-danger"><?= form_error('phone'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="mobile" class="col-sm-2 control-label">Mobile *</label>
                  <div class="col-sm-4">
                   <input type="text" id="mobile" name="mobile" class="form-control" value="<?=$details->mobile?>" placeholder="Mobile" required/>
                   <span class="text-danger"><?= form_error('mobile'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email *</label>
                  <div class="col-sm-4">
                   <input type="email" id="email" name="email" class="form-control" value="<?=$details->email?>" placeholder="Email" required/>
                   <span class="text-danger"><?= form_error('email'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_country" class="col-sm-2 control-label">Country *</label>
                  <div class="col-sm-4">
                      <select id="billing_country" name="billing_country" class="form-control" required>
                        <option selected>Please Select Country</option>
                        <?php foreach($countries as $country){?>
                            <option value="<?=$country->id?>" <?=($country->id==$details->billing_country) ? "selected":""?>><?=$country->name?></option>
                        <?php }?>
                      </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">State *</label>
                  <div class="col-md-4">
                    <select id="billing_state" name="billing_state" class="form-control" required>
                      <?php foreach($billing_states as $state){?>
                          <option value="<?=$state->id?>" <?=($state->id==$details->billing_state) ? "selected":""?>><?=$state->name?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_city" class="col-sm-2 control-label">City *</label>
                  <div class="col-md-4">
                      <input type="text" name="billing_city" class="form-control" value="<?php echo $details->billing_city; ?>" required/>

                      <!--  <select id="billing_city" name="billing_city" class="form-control" required> 
                        <?php foreach($billing_cities as $city){?>
                          <option value="<?=$city->id?>" <?=($city->id==$details->billing_city) ? "selected":""?>><?=$city->name?></option>
                      <?php }?>
                      </select> -->
                  </div>
                </div> 
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_street" class="col-sm-2 control-label">Street *</label>
                  <div class="col-sm-4">
                   <input type="text" id="billing_street" name="billing_street" class="form-control" value="<?=$details->billing_street?>" placeholder="Street" required/>
                   <span class="text-danger"><?= form_error('billing_street'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_zip" class="col-sm-2 control-label">Zip *</label>
                  <div class="col-sm-4">
                   <input type="text" id="billing_zip" name="billing_zip" class="form-control" value="<?=$details->billing_zip?>" placeholder="Zip" required/>
                   <span class="text-danger"><?= form_error('billing_zip'); ?></span>
                  </div>
                </div>
              </div>
            
              <div class="row"> 
                <div class="form-group">
                  <label for="product_id" class="col-sm-2 control-label">Product</label>
                  <div class="col-sm-4">
                      <select id="product_id" name="product_id" class="form-control" required>
                        <option value="">Please Select a Product</option>
                        <?php foreach($products as $product){?>
                            <option value="<?=$product['id']?>" <?=($product['id']==$details->product_id) ? "selected" : ""?>><?=$product['name']?></option>
                        <?php }?>
                      </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-4">
                   <input type="text" id="" name="" class="form-control" value="<?=$details->username?>" disabled/>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-4">
                   <input type="text" id="password" name="password" class="form-control" value="<?=base64_decode($details->password)?>"/>
                   <span class="text-danger"><?= form_error('password'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <input type="checkbox" id="change-password" name="change_password" value="1"/> Change Password ?
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Customer</button>
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