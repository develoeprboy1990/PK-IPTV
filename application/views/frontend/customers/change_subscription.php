<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
       <span class="text-gray-600">Customer Type: <b><?php echo $customer_type; ?></b></span>
    </section>
 
    <!-- Main content -->
    <section class="content">
      <?php if($responce = $this->session->flashdata('success')){ ?>
            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
      <?php } ?>

      <div class="box box-primary">
          <div class="box-header"><h3> Current Product</h3></div>
          <div class="box-body">
             <div class="row"> 
                <div class="form-group">
                  <div class="col-sm-2 control-label">Customer</div>
                  <div class="col-sm-4"><?=@$details->first_name.' '.@$details->last_name?></div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <div class="col-sm-2 control-label">Product</div>
                  <div class="col-sm-4"><?=@$product->name?></div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <div class="col-sm-2 control-label">Plan</div>
                  <div class="col-sm-4"><?=@$product_plan->name?></div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <div class="col-sm-2 control-label">Expire Date</div>
                  <div class="col-sm-4"><?=date('l, d F Y',strtotime(@$details->subscription_expire))?></div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <div class="col-sm-2 control-label">Subscription Length</div>
                  <div class="col-sm-4"><?=@$product->subscription_length?> <?=ucfirst(@$product->subscription_days_or_month)?></div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <div class="col-sm-2 control-label">Status</div>
                  <div class="col-sm-4"><?=(@$product->status==1) ? "Active" : "Inactive"?></div>
                </div>
              </div>
          </div>
      </div>

      <div class="box box-primary">
          <div class="box-header"><h3>Product Selection</h3></div>
          <div class="box-body">
            <form method="post" action="<?=BASE_URL ?>customers/changeSubscription/<?=$customer_id?>" class="form-horizontal">
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
                  <label for="plan_id" class="col-sm-2 control-label">Plan</label>
                  <div class="col-sm-4">
                      <select id="plan_id" name="plan_id" class="form-control" required>
                        <option value="">Please Select a Product</option>
                        <?php foreach($product_plans as $plan){?>
                            <option value="<?=$plan['id']?>" <?=($plan['id']==$details->plan_id) ? "selected" : ""?>><?=$plan['name']?></option>
                        <?php }?>
                      </select>
                  </div>
                </div>
              </div>


              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Plan</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>
    </section>
</div>