 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
                <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>employee/add">

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Name</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_name; ?>" id="operator_name" name="operator_name" class="form-control" maxlength="128" required="yes" />
                  <span class="text-danger"><?= form_error('operator_name'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Street</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_street; ?>" id="operator_street" name="operator_street" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_street'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Postal</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_postal; ?>"id="operator_postal" name="operator_postal" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_postal'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>City</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_city; ?>"id="operator_city" name="operator_city" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_city'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Country</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_country; ?>" id="operator_country" name="operator_country" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_country'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Telephone</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_telephone; ?>"id="operator_telephone" name="operator_telephone" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_telephone'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Mobile</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_mobile; ?>" id="operator_mobile" name="operator_mobile" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_mobile'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>E-mail</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_email; ?>" id="operator_email" name="operator_email" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_email'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Bank Details</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_bank_details; ?>" id="operator_bank_details" name="operator_bank_details" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_bank_details'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Invoice Header</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_invoice_header; ?>" id="operator_invoice_header" name="operator_invoice_header" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_invoice_header'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Mailing Header</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_mailing_header; ?>"id="operator_mailing_header" name="operator_mailing_header" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_mailing_header'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Invoice Day of the Month</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text"  value="<?= $operator_details->operator_invoice_day_of_the_month; ?>" id="operator_invoice_day_of_the_month" name="operator_invoice_day_of_the_month" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_invoice_day_of_the_month'); ?></span>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Terms Link</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_terms_link; ?>" id="operator_terms_link" name="operator_terms_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_terms_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Contact Link</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_contact_link; ?>" id="operator_contact_link" name="operator_contact_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_contact_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>operator Link</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_operator_link; ?>" id="operator_operator_link" name="operator_operator_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_operator_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Client Login Link</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?= $operator_details->operator_client_login_link; ?>" id="operator_client_login_link" name="operator_client_login_link" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_client_login_link'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Registeration E-mails</h4>
                </div>
                <div class="form-group col-md-6">
                  <select class="form-control" name="operator_registration_emails" id="operator_registration_emails">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                  <span class="text-danger"><?= form_error('operator_registration_emails'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Auto Invoiceing Enabled</h4>
                </div>
                <div class="form-group col-md-6">
                  <select class="form-control" name="operator_auto_invoicing_enabled" id="operator_auto_invoicing_enabled">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                  <span class="text-danger"><?= form_error('operator_auto_invoicing_enabled'); ?></span>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Support E-mail</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_support_email" name="operator_support_email" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_support_email'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Default Language</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_default_language" name="operator_default_language" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_default_language'); ?></span>
                </div>
              </div>


              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>GUI Logo</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_gui_logo" name="operator_gui_logo" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_gui_logo'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>GUI Background</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_gui_background" name="operator_gui_background" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_gui_background'); ?></span>
                </div>
              </div>


              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Selection Color</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_selection_color" name="operator_selection_color" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_selection_color'); ?></span>
                </div>
              </div>


              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>GUI Text</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_gui_text" name="operator_gui_text" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_gui_text'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>QR Code</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_qrcode" name="operator_qrcode" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_qrcode'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Product API Location</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_product_api_location" name="operator_product_api_location" class="form-control" />
                  <span class="text-danger"><?= form_error('operator_product_api_location'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Web API Location</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_web_api_location" name="operator_web_api_location" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_web_api_location'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Use Register</h4>
                </div>
                <div class="form-group col-md-6">
                  <select class="form-control" name="operator_use_register" id="operator_use_register">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                  <span class="text-danger"><?= form_error('operator_use_register'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Use Trail</h4>
                </div>
                <div class="form-group col-md-6">
                  <select class="form-control" name="operator_use_trial" id="operator_use_trial">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                  <span class="text-danger"><?= form_error('operator_use_trial'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Use Renew By Key</h4>
                </div>
                <div class="form-group col-md-6">
                  <select class="form-control" name="operator_use_renew_by_key" id="operator_use_renew_by_key">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                  <span class="text-danger"><?= form_error('operator_use_renew_by_key'); ?></span>
                </div>
              </div>


              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Product Trail ID</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_product_trial_id" name="operator_product_trial_id" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_product_trial_id'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Disclaimer</h4>
                </div>
                <div class="form-group col-md-6">
                  <textarea id="operator_disclaimer" name="operator_disclaimer" class="form-control"></textarea>
                  <span class="text-danger"><?= form_error('operator_disclaimer'); ?></span>
                </div>
              </div> 

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Is Show Disclaimer</h4>
                </div>
                <div class="form-group col-md-6">
                  <select class="form-control" name="operator_is_show_disclaimer" id="operator_is_show_disclaimer">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                  <span class="text-danger"><?= form_error('operator_is_show_disclaimer'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <h4>Storage</h4>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="operator_storage" name="operator_storage" class="form-control"/>
                  <span class="text-danger"><?= form_error('operator_storage'); ?></span>
                </div>
              </div> 

              
              <div class="row">
                <div class="form-group col-md-6 text-center">
                  <button type="submit" class="btn btn-success ">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->   




