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
                        <h3 class="box-title">Notification Settings for <?php echo $reseller['name']; ?></h3>
                    </div>

                    <div class="box-body">
                        <?php if($responce = $this->session->flashdata('success')){ ?>
                            <div class="alert alert-success" role="alert"><?php echo $responce;?></div>
                        <?php } ?>

                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Notification Subject</label>
                                <div class="col-sm-10">
                                    <input type="text" name="notification_subject" class="form-control" 
                                           value="<?php echo set_value('notification_subject', $reseller['notification_subject']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Notification Body</label>
                                <div class="col-sm-10">
                                    <textarea name="notification_body" class="form-control" rows="10" required><?php echo set_value('notification_body', $reseller['notification_body']); ?></textarea>
                                    <small class="help-block">Available variables:</small>
                                    <div class="well well-sm">
                                        <?php foreach($template_variables as $var => $desc): ?>
                                            <strong><?php echo $var; ?></strong> - <?php echo $desc; ?><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Renewal URL</label>
                                <div class="col-sm-10">
                                    <input type="url" name="renewal_url" class="form-control" 
                                           value="<?php echo set_value('renewal_url', $reseller['renewal_url']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">QR Code</label>
                                <div class="col-sm-10">
                                    <input type="file" name="qr_code" class="form-control" accept="image/*">
                                    <?php if(!empty($reseller['qr_code'])): ?>
                                        <div class="mt-3">
                                            <p>Current QR Code:</p>
                                            <img src="<?php echo $reseller['qr_code']; ?>" 
                                                 alt="Current QR Code" 
                                                 style="max-width: 200px; border: 1px solid #ddd; padding: 5px; margin-top: 10px;">
                                        </div>
                                    <?php endif; ?>
                                    <?php if($this->session->flashdata('error')): ?>
                                        <div class="alert alert-danger mt-2">
                                            <?php echo $this->session->flashdata('error'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" name="save_notification" class="btn btn-primary">Save Settings</button>
                                </div>
                            </div>
                        </form>

                        <?php if($json_preview = $this->session->flashdata('json_preview')): ?>
                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h4>JSON Preview for Frontend:</h4>
                                <pre style="background: #f5f5f5; padding: 15px; border-radius: 4px;"><?php echo $json_preview; ?></pre>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>