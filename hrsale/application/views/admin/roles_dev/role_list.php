<?php
/* User Roles view*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_employee_role');?></h3>
      <div class="box-tools pull-right">
        <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-plus-square"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'add_role', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('_user' => $session['user_id']);?>
            <?=form_open('admin/roles/add_role', $attributes, $hidden);?>
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_name"><?=$this->lang->line('xin_role_name');?></label>
                        <input class="form-control" placeholder="<?=$this->lang->line('xin_role_name');?>" name="role_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="first_name"><?=$this->lang->line('left_company');?></label>
                        <select class="form-control" name="company_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                          <option value=""></option>
                          <?php foreach($get_all_companies as $company) {?>
                          <option value="<?=$company->company_id?>"><?=$company->name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_access"><?=$this->lang->line('xin_role_access');?></label>
                        <select class="form-control custom-select" id="role_access" data-plugin="select_hrm" name="role_access"  data-placeholder="<?=$this->lang->line('xin_role_access');?>">
                          <option value="">&nbsp;</option>
                          <option value="1"><?=$this->lang->line('xin_role_all_menu');?></option>
                          <option value="2"><?=$this->lang->line('xin_role_cmenu');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="resources"><?=$this->lang->line('xin_role_resource');?></label>
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r1"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r2"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?=form_close(); ?> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_roles');?> </h3>
    <?php if($userRole==1): #superAdmin?>
    <div class="box-tools pull-right">
      <a class="text-dark" href="<?=site_url('admin/roles/deleted');?>" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-trash"></span> Show Deleted</button>
      </a>
    </div>
    <?php endif;?>
  </div>
  <div class="box-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?=$this->lang->line('xin_action');?></th>
          <th><?=$this->lang->line('xin_role_name');?></th>
          <th><?=$this->lang->line('xin_role_menu_per');?></th>
          <th><?=$this->lang->line('left_company');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
</div>
<style type="text/css">
.k-in { display:none !important; }
</style>