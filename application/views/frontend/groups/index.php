<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(9); 

if(!isset($is_allow))
{
    
   redirect('login', 'refresh');
}
?>  
            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                 <?php if($is_allow->allow_create) {?> 
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('groups/create', '<i class="fa fa-plus"></i> Create Role', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                                 <?php } ?>
                                <div class="box-body">
                                     <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                      <?php } ?>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('groups_name');?></th>
                                                <th><?php echo lang('groups_description');?></th>
                                               
                                                <th><?php echo lang('groups_action');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php foreach ($groups as $values):?>
                                          <?php if($values->id != 1) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($values->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($values->description, ENT_QUOTES, 'UTF-8'); ?></td>
<!--                                                <td><i class="fa fa-stop" style="color:<?php echo $values->bgcolor; ?>"></i></td>-->
                                                <td>
                                                <?php if($is_allow->allow_edit) {?>      <a href="groups/edit/<?php echo $values->id;?>"><i class="glyphicon glyphicon-edit text-primary"></i></a> <?php } ?>
                                                  <?php if($is_allow->allow_delete) {?>    &nbsp;&nbsp;<a href="groups/delete/<?php echo $values->id;?>"><i class="glyphicon glyphicon-trash text-danger"></i></a> <?php } ?>
                                                   </td>
                                            </tr>
                                          <?php } ?>
<?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
            </div>
