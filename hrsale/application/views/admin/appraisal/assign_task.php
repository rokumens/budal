<?php // assign task ?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('2000',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Assign new main task</h3>
      <div class="box-tools pull-right"><a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_assign_task', 'id' => 'xin-form', 'class' => 'subtask-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/appraisal_assign_task/add_assign_task', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group subdept_ajax">
                  <label for="name"><?=$this->lang->line('xin_hr_sub_department');?></label>
                  <select class="form-control aj_subdept" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="Choose sub department">
                    <option value=""></option>
                    <option value="allSubDepartments_val">All Sub Department</option>
                    <?php foreach($all_sub_departments as $singSubdept) {?>
                    <option value="<?=$singSubdept->sub_department_id?>"><?=$singSubdept->department_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group jobtask_ajax">
                  <label for="jobtask">Main Task</label>
                  <select name="jobtask" class="form-control" data-plugin="select_hrm" data-placeholder="Choose main task" disabled>
                    <option value=""></option>
                  </select>
                </div>
                <div class="form-group employee_ajax">
                  <label for="employee">Employee</label>
                  <select name="employee" class="form-control aj_employees" data-plugin="select_hrm" data-placeholder="Choose employees" disabled>
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date">Start Date</label>
                      <input class="form-control appraisal_date" placeholder="<?=$this->lang->line('xin_select_date');?>" readonly name="start_date" type="text" value="<?=date('Y-m-d',strtotime('first day of this month', time()));?>">
                      <small> <i>Note: 'Start date' & 'Due date' = following payroll date.</i></small>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="due_date">Due Date</label>
                      <input class="form-control appraisal_date" placeholder="<?=$this->lang->line('xin_select_date');?>" readonly name="due_date" type="text" value="<?=date('Y-m-d', strtotime('last day of this month'));?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="note">Note</label>
                  <textarea class="form-control note" placeholder="Note" name="note" rows="9"></textarea>
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
    <h3 class="box-title">List All <?=$my_title;?> Main Tasks</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th>Employee</th>
            <th>Office Location</th>
            <th>Main Task</th>
            <th>Shift Task</th>
            <th>Points</th>
            <th>Status</th>
            <!-- <th>Approval</th> -->
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
