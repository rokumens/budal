<?php
/* Task List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('319',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_task');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_task', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/timesheet/add_task', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="company_name"><?=$this->lang->line('module_company_title');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('module_company_title');?>">
                    <option value=""><?=$this->lang->line('xin_select_one');?></option>
                    <?php foreach($all_companies as $company) {?>
                    <option value="<?=$company->company_id;?>"> <?=$company->name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="task_name">Task Name</label>
                  <input class="form-control" placeholder="Set a task name" name="task_name" type="text" value="">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?=$this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?=$this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="task_hour" class="control-label"><?=$this->lang->line('xin_estimated_hour');?></label>
                      <input class="form-control" placeholder="<?=$this->lang->line('xin_estimated_hour');?>" name="task_hour" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="project_ajax">
                      <label for="project_ajax" class="control-label"><?=$this->lang->line('xin_project');?></label>
                      <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_project');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group" id="employee_ajax">
                      <label for="employees" class="control-label"><?=$this->lang->line('xin_assigned_to');?></label>
                      <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_single_employee');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?=$this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
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
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_worksheets');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th>Task Name</th>
            <th><?=$this->lang->line('xin_project');?></th>
            <th><?=$this->lang->line('xin_end_date');?></th>
            <th><?=$this->lang->line('dashboard_xin_status');?></th>
            <th><?=$this->lang->line('xin_assigned_to');?></th>
            <th><?=$this->lang->line('xin_created_by');?></th>
            <th><?=$this->lang->line('dashboard_xin_progress');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
