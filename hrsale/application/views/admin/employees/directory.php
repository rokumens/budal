<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-3">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> Filters </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'employees_directory_form', 'id' => 'employees_directory_form', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/employees/employees_directory', $attributes, $hidden);?>
            <?php
              $data = array(
                'name'        => 'user_id',
                'id'          => 'user_id',
                'type'        => 'hidden',
                'value'   	   => $session['user_id'],
                'class'       => 'form-control',
              );
              echo form_input($data);
            ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                    <?php foreach($all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <!-- luffy start -->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="location_ajax">
                  <label for="location"><?php echo $this->lang->line('xin_location');?></label>
                  <select disabled="disabled" class="form-control" name="location_id" id="location_id" data-plugin="select_hrm" data-placeholder="Office Location">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  </select>
                </div>
              </div>
            </div>
            <!-- luffy end -->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="department_ajax">
                  <label for="department"><?php echo $this->lang->line('xin_employee_department');?></label>
                  <select disabled="disabled" class="form-control" name="department_id" id="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" id="shift_ajax">
                <div class="form-group">
                  <label for="shift"><?php echo $this->lang->line('left_office_shifts');?></label>
                  <select disabled="disabled" class="form-control" id="shift_id" name="shift_id" data-plugin="select_hrm" data-placeholder="Select shift">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 <?php echo $get_animate;?>">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('xin_employee')." ".$this->lang->line('xin_role_list');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_employees_id');?></th>
                <th>Nickname</th>
                <!-- <th><?php echo $this->lang->line('xin_employees_full_name');?></th> -->
                <!-- <th><?php echo $this->lang->line('left_company');?></th> -->
                <th><?php echo $this->lang->line('dashboard_email');?></th>
                <th>Location</th>
                <th><?php echo $this->lang->line('xin_employee_department');?></th>
                <th><?php echo $this->lang->line('xin_designation');?></th>
                <!-- <th><?php echo $this->lang->line('dashboard_xin_status');?></th> -->
                <th>Shift</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
