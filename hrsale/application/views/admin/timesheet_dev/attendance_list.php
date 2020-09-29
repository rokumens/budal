<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?=$get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource();
  if(in_array('2075',$role_resources_ids)):?>
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Propose attendance. Or forgot fingerprint? </h3>
      <hr style='margin:10px 0 !important;' />
      <div>
        <i class="fa fa-arrow-right"></i> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false"><strong>Click here</strong></a> to propose your attendance directly to HRD.
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_clockin', 'id' => 'add-clock-manually-form', 'class' => 'subtask-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/timesheet/add_clockin', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-group" style="padding:10px 0 10px;">
                    <label class="radio-inline"><input type="radio" id="clockInRadio" name="clock_for" value="for_clockIn" checked>Set Clock In</label>
                    <label class="radio-inline" style="margin-left:20px;"><input type="radio" id="clockOutRadio" name="clock_for" value="for_clockOut">Set Clock Out</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date">Date</label>
                      <input class="form-control attendance_date" readonly placeholder="<?=$this->lang->line('xin_select_date');?>" name="fingerprintDate" type="text" value="<?=date('Y-m-d',strtotime('today',time()));?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="rowClockIn">
                      <label for="clock_in">Clock In</label>
                      <input class="form-control timepicker" id="idClockIn" readonly name="clockIn" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="rowClockOut" style="display:none;">
                      <label for="clock_out">Clock Out</label>
                      <input class="form-control timepicker" id="idClockOut" readonly name="clockOut" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="employee">It's for yourself</label>
                  <!-- <select name="employee" class="form-control" data-plugin="select_hrm" data-placeholder="Choose employee">
                    <option value="">Choose employee</option>
                    <?php #if (count($employees)) :?>
                    <?php #foreach($employees->result() as $employee) :?>
                      <option value="<?=$employee->employee_id;?>"> <?=$employee->username.' - '.$employee->first_name.' '.$employee->last_name;?></option>
                    <?php #endforeach;#endif;?>
                  </select> -->
                  <select name="noname" disabled class="form-control" data-plugin="select_hrm" data-placeholder="Choose employee">
                    <option value="">Choose employee</option>
                    <?php if (!is_null($employees)) :?>
                    <?php foreach($employees->result() as $employee) :?>
                      <option value="<?=$employee->employee_id;?>" <?php if($employeeId==$employee->employee_id):?>selected='selected'<?php endif;?>> <?=$employee->username.' - '.$employee->first_name.' '.$employee->last_name;?></option>
                    <?php endforeach;endif;?>
                  </select>
                  <input class="form-control" readonly name="employee" type="hidden" value="<?=$employeeId;?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="reason">Reason</label>
                  <textarea class="form-control note" placeholder="Explain your reason here..." name="reason" rows="8"></textarea>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary saveManualClock"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?=form_close();?></div>
    </div>
  </div>
</div>
<?php endif;?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">See Fingerprint Attendance by Range Date</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'attendance_daily_report', 'id' => 'attendance_daily_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/timesheet/attendance_list', $attributes, $hidden);?>
        <?php
				$data = array(
				  'type'        => 'hidden',
				  'name'        => 'date_format',
				  'id'          => 'date_format',
				  'value'       => $this->Xin_model->set_date_format(date('Y-m-d')),
				  'class'       => 'form-control',
				);
				echo form_input($data);
				?>
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label><?=$this->lang->line('xin_set_range_date');?> From</label>
              <input class="form-control attendance_date" placeholder="<?=$this->lang->line('xin_select_date');?>" readonly id="attendance_date" name="attendance_date" type="text" value="<?=date('Y-m-d');?>">
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label>To</label>
              <input class="form-control attendance_date" placeholder="<?=$this->lang->line('xin_select_date');?>" readonly id="attendance_to_date" name="attendance_to_date" type="text" value="<?=date('Y-m-d');?>">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label>&nbsp;</label>
              <button type="submit" class="btn btn-small btn-primary save form-control">See Attendance</button>
            </div>
          </div>
        </div>
        <?=form_close(); ?>
      </div>
    </div>
    <hr />
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th colspan="4"><?=$this->lang->line('xin_hr_info');?></th>
            <th colspan="6"><?=$this->lang->line('xin_attendance_report');?></th>
          </tr>
          <tr>
            <th style="width:50px;">ID</th>
            <th style="width:100px;">Nickname</th>
            <th style="width:120px;"><?=$this->lang->line('xin_employee');?></th>
            <th style="width:100px;">Office location</th>
            <th style="width:100px;"><?=$this->lang->line('xin_e_details_date');?></th>
            <th style="width:100px;"><?=$this->lang->line('dashboard_clock_in');?></th>
            <th style="width:100px;"><?=$this->lang->line('dashboard_clock_out');?></th>
            <th style="width:100px;">Break Out</th>
            <th style="width:100px;">Break In</th>
            <th style="width:100px;">Each Break</th>
            <th style="width:100px;">Total Break</th>
            <th style="width:100px;"><?=$this->lang->line('dashboard_late');?></th>
            
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
