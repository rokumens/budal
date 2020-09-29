<?php
// appraisal list
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('2000',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Add New Appraisal</h3>
      <div class="box-tools pull-right"><a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_appraisal', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/appraisal/add_appraisal', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
                  <select class="form-control aj_subdept" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="Choose sub department">
                    <option value=""></option>
                    <?php foreach($all_sub_departments as $singSubdept) {?>
                    <option value="<?php echo $singSubdept->sub_department_id?>"><?php echo $singSubdept->department_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group jobtask_ajax">
                  <label for="jobtask">Job Task</label>
                  <select name="jobtask" class="form-control" data-plugin="select_hrm" data-placeholder="Choose job task" disabled>
                    <option value=""></option>
                  </select>
                </div>
                <div class="form-group employee_ajax">
                  <label for="employee">Employee</label>
                  <select name="employee" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" disabled>
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date">Start Date</label>
                      <input class="form-control appraisal_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="start_date" type="text" value="<?php echo date('Y-m-d',strtotime('first day of this month', time()));?>">
                      <small> <i>Note: 'Start date' & 'Due date' = following payroll date.</i></small>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="due_date">Due Date</label>
                      <input class="form-control appraisal_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="due_date" type="text" value="<?php echo date('Y-m-d', strtotime('last day of this month'));?>">
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
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> Appraisal </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th>Employee</th>
            <th>Job Task</th>
            <th>Points</th>
            <th>Status</th>
            <th>Approval</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
