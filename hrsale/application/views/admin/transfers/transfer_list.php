<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('210',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_transfer');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_transfer', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/transfers/add_transfer', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="first_name"><?=$this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?=$company->company_id?>"><?=$company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?=$this->lang->line('xin_employee_transfer');?></label>
                  <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                    <?php foreach($all_employees as $employee) {?>
                    <option value="<?=$employee->user_id;?>"> <?=$employee->first_name.' '.$employee->last_name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="transfer_date"><?=$this->lang->line('xin_transfer_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_transfer_date');?>" readonly name="transfer_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" id="department_ajax">
                      <label for="transfer_department"><?=$this->lang->line('xin_transfer_to_department');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_department');?>" name="transfer_department">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="location_ajax">
                      <label for="transfer_location"><?=$this->lang->line('xin_transfer_to_location');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_transfer_select_location');?>" name="transfer_location">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?=$this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="30" rows="9" id=""></textarea>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_transfers');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th><?=$this->lang->line('xin_employee_name');?></th>
            <th><?=$this->lang->line('left_company');?></th>
            <th><?=$this->lang->line('xin_transfer_date');?></th>
            <!-- <th>Transfer From (Location)</th> -->
            <th><?=$this->lang->line('xin_transfer_to_location');?></th>
            <th><?=$this->lang->line('xin_transfer_to_department');?></th>
            <th><?=$this->lang->line('dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
