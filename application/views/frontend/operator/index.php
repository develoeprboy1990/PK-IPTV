 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php echo $page_title; ?>
      <?php echo $breadcrumb; ?>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
          <div class="box-body">
            <?php if($responce = $this->session->flashdata('success')){ ?>
                <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
            <?php } ?>
            <form method="post" action="<?=BASE_URL ?>operator" enctype="multipart/form-data">
            <input type="hidden" name="operator_id" value="<?=$operator_details->id?>">
              
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_name" class="col-sm-12 control-label">Company Name</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_name; ?>" id="operator_name" name="operator_name" class="form-control" maxlength="128" required="yes" />
                  <span class="text-danger"><?= form_error('operator_name'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_crm" class="col-sm-12 control-label">CRM Name</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?=$operator_details->operator_crm; ?>" id="operator_crm" name="operator_crm" class="form-control" maxlength="128" required="yes" />
                  <span class="text-danger"><?= form_error('operator_crm'); ?></span>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_brand" class="col-sm-12 control-label">Brand Name</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_brand; ?>" id="operator_brand" name="operator_brand" class="form-control" maxlength="128" required="yes" />
                  <span class="text-danger"><?= form_error('operator_brand'); ?></span>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="country_id" class="col-sm-12 control-label">Country</label>
                </div>
                <div class="form-group col-md-6">
                    <select id="country_id" name="operator_country" class="form-control">
                      <option selected>Please Select Country</option>
                      <?php foreach($countries as $country){?>
                          <option value="<?=$country->id?>" <?=($operator_details->operator_country==$country->id) ? "selected": ""?>><?=$country->name?></option>
                      <?php }?>
                    </select>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="state_id" class="col-sm-12 control-label">State</label>
                </div>

                <div class="form-group col-md-6">
                  <select id="state_id" name="operator_state" class="form-control">
                    <?php foreach($states as $state){?>
                        <option value="<?=$state->id?>" <?=($operator_details->operator_state==$state->id) ? "selected": ""?>><?=$state->name?></option>
                    <?php }?>
                  </select>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="city_id" class="col-sm-12 control-label">City</label>
                </div>

                <div class="form-group col-md-6">
                    <select id="city_id" name="operator_city" class="form-control"> 
                      <?php foreach($cities as $city){?>
                        <option value="<?=$city->id?>" <?=($operator_details->operator_city==$city->id) ? "selected": ""?>><?=$city->name?></option>
                    <?php }?>
                    </select>
                </div>
              </div> 

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_street" class="col-sm-12 control-label">Street</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?=$operator_details->operator_street; ?>" id="operator_street" name="operator_street" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_street'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_postal" class="col-sm-12 control-label">Postal</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_postal; ?>" id="operator_postal" name="operator_postal" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_postal'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_telephone" class="col-sm-12 control-label">Telephone</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_telephone; ?>" id="operator_telephone" name="operator_telephone" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_telephone'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_mobile" class="col-sm-12 control-label">Mobile</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_mobile; ?>" id="operator_mobile" name="operator_mobile" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_mobile'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_email" class="col-sm-12 control-label">E-mail</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_email; ?>" id="operator_email" name="operator_email" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_email'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_bank_details" class="col-sm-12 control-label">Bank Details</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_bank_details; ?>" id="operator_bank_details" name="operator_bank_details" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_bank_details'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_invoice_header" class="col-sm-12 control-label">Invoice Header</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_invoice_header; ?>" id="operator_invoice_header" name="operator_invoice_header" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_invoice_header'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_mailing_header" class="col-sm-12 control-label">Mailing Header</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_mailing_header; ?>" id="operator_mailing_header" name="operator_mailing_header" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_mailing_header'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_invoice_day_of_the_month" class="col-sm-12 control-label">Invoice Day of the Month</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text"  value="<?= $operator_details->operator_invoice_day_of_the_month; ?>" id="operator_invoice_day_of_the_month" name="operator_invoice_day_of_the_month" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_invoice_day_of_the_month'); ?></span>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_terms_link" class="col-sm-12 control-label">Terms Link</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_terms_link; ?>" id="operator_terms_link" name="operator_terms_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_terms_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_contact_link" class="col-sm-12 control-label">Contact Link</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_contact_link; ?>" id="operator_contact_link" name="operator_contact_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_contact_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                   <label for="operator_operator_link" class="col-sm-12 control-label">Operator Link</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_operator_link; ?>" id="operator_operator_link" name="operator_operator_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_operator_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                   <label for="operator_client_login_link" class="col-sm-12 control-label">Client Login Link</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_client_login_link; ?>" id="operator_client_login_link" name="operator_client_login_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_client_login_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_registration_emails" class="col-sm-12 control-label">Registeration E-mails</label>
                </div>
                <div class="form-group col-md-6">
                  <div class="onoffswitch">
                    <input type="checkbox" name="operator_registration_emails" class="onoffswitch-checkbox" id="operator_registration_emails" value="1" <?=($operator_details->operator_registration_emails==1) ? "checked" : ""?>>
                    <label class="onoffswitch-label" for="operator_registration_emails">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </div>
              </div>
             
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_auto_invoicing_enabled" class="col-sm-12 control-label">Auto Invoiceing Enabled</label>
                </div>
                <div class="form-group col-md-6">
                  <div class="onoffswitch">
                    <input type="checkbox" name="operator_auto_invoicing_enabled" class="onoffswitch-checkbox" id="operator_auto_invoicing_enabled" value="1" <?=($operator_details->operator_auto_invoicing_enabled==1) ? "checked" : ""?>>
                    <label class="onoffswitch-label" for="operator_auto_invoicing_enabled">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_support_email" class="col-sm-12 control-label">Support E-mail</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?=$operator_details->operator_support_email;?>" id="operator_support_email" name="operator_support_email" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_support_email'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_default_language" class="col-sm-12 control-label">Default Language</label>
                </div>
                <div class="form-group col-md-2">
                  <select id="operator_default_language" value="<?=$operator_details->operator_default_language;?>" name="operator_default_language" class="form-control">
                    <option value="english" selected>English</option>
                  </select>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_image_location" class="col-sm-12 control-label">Image Location</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_image_location" value="<?=$operator_details->operator_image_location;?>" name="operator_image_location" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_image_location'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_content_api_location" class="col-sm-12 control-label">Content API Location</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_content_api_location" value="<?=$operator_details->operator_content_api_location;?>" name="operator_content_api_location" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_content_api_location'); ?></span>
                </div>
              </div>
            
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_product_api_location" class="col-sm-12 control-label">Product API Location</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_product_api_location" value="<?=$operator_details->operator_product_api_location;?>" name="operator_product_api_location" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_product_api_location'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_web_api_location" class="col-sm-12 control-label">Web API Location</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_web_api_location" value="<?=$operator_details->operator_web_api_location;?>" name="operator_web_api_location" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_web_api_location'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_news_image_location" class="col-sm-12 control-label">News Image Location</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_news_image_location" value="<?=$operator_details->operator_news_image_location;?>" name="operator_news_image_location" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_news_image_location'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_font" class="col-sm-12 control-label">Font</label>
                </div>
                <div class="form-group col-md-2">
                  <select id="operator_font" name="operator_font" class="form-control">
                    <option value="Lato" selected>Lato</option>
                  </select>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_primary_color" class="col-sm-12 control-label">Highlight Primary Color</label>
                </div>
                <div class="form-group col-md-2">
                  <input type="text" id="operator_primary_color" value="<?=$operator_details->operator_primary_color;?>" name="operator_primary_color" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_primary_color'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_secondary_color" class="col-sm-12 control-label">Highlight Secondary Color</label>
                </div>
                <div class="form-group col-md-2">
                  <input type="text" id="operator_secondary_color" value="<?=$operator_details->operator_secondary_color;?>" name="operator_secondary_color" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_secondary_color'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_use_register" class="col-sm-12 control-label">Use Register</label>
                </div>
                <div class="form-group col-md-6">
                  <div class="onoffswitch">
                    <input type="checkbox" name="operator_use_register" class="onoffswitch-checkbox" id="operator_use_register" value="1" <?=($operator_details->operator_use_register==1) ? "checked" : ""?>>
                    <label class="onoffswitch-label" for="operator_use_register">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_use_trial" class="col-sm-12 control-label">Use Trial</label>
                </div>
                <div class="form-group col-md-6">
                  <div class="onoffswitch">
                    <input type="checkbox" name="operator_use_trial" class="onoffswitch-checkbox" id="operator_use_trial" value="1" <?=($operator_details->operator_use_trial==1) ? "checked" : ""?>>
                    <label class="onoffswitch-label" for="operator_use_trial">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </div>
              </div>
             
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_use_renew_by_key" class="col-sm-12 control-label">Use Renew By Key</label>
                </div>
                <div class="form-group col-md-6">
                  <div class="onoffswitch">
                    <input type="checkbox" name="operator_use_renew_by_key" class="onoffswitch-checkbox" id="operator_use_renew_by_key" value="1" <?=($operator_details->operator_use_renew_by_key==1) ? "checked" : ""?>>
                    <label class="onoffswitch-label" for="operator_use_renew_by_key">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                   <label for="operator_product_trial_id" class="col-sm-12 control-label">Product Trail ID</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_product_trial_id" value="<?=$operator_details->operator_product_trial_id;?>" name="operator_product_trial_id" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_product_trial_id'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_disclaimer" class="col-sm-12 control-label">Disclaimer</label>
                </div>
                <div class="form-group col-md-6">
                  <textarea id="operator_disclaimer" name="operator_disclaimer" class="form-control"><?=$operator_details->operator_disclaimer;?></textarea>
                  <span class="text-danger"><?= form_error('operator_disclaimer'); ?></span>
                </div>
              </div> 

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_is_show_disclaimer" class="col-sm-12 control-label">Show Disclaimer ?</label>
                </div>

                <div class="form-group col-md-6">
                  <div class="onoffswitch">
                    <input type="checkbox" name="operator_is_show_disclaimer" class="onoffswitch-checkbox" id="operator_is_show_disclaimer" value="1" <?=($operator_details->operator_is_show_disclaimer==1) ? "checked" : ""?>>
                    <label class="onoffswitch-label" for="operator_is_show_disclaimer">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_sleepmode" class="col-sm-12 control-label">Sleepmode</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_sleepmode" name="operator_sleepmode"  value="<?=$operator_details->operator_sleepmode;?>" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_sleepmode'); ?></span>
                </div>
              </div> 

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_storage" class="col-sm-12 control-label">Storage</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_storage" name="operator_storage"  value="<?=$operator_details->operator_storage;?>" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_storage'); ?></span>
                </div>
              </div> 

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_storage" class="col-sm-12 control-label"></label>
                </div>
                <div class="form-group col-md-6">
                   <button type="submit" class="btn btn-success ">Update</button>
                </div>
              </div> 
            </form>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->   