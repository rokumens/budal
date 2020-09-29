<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <?php $attributes = array('name' => 'general_report', 'id' => 'general_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/reports/general_report_list', $attributes, $hidden);?>
          <?php
  				$data = array(
  				  'type'        => 'hidden',
  				  'name'        => 'date_format',
  				  'id'          => 'date_format',
  				  'value'       => $this->Xin_model->set_date_format(date('Y-m')),
  				  'class'       => 'form-control',
  				);
  				echo form_input($data);
  				?>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="month_year">Month</label>
                <input class="form-control report_month" placeholder="<?php echo $this->lang->line('xin_select_month');?>" readonly id="report_month" name="report_month" type="text" value="<?php echo date('Y-m');?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-small btn-primary save form-control">Filter</button>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <!-- <label>Employee</label>
                <select></select> -->
              </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header">
    <h3 class="box-title"> General Report  for <span class="text-danger reportMonthFormat"></span> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style='width:100px;'><?php echo $this->lang->line('xin_action');?></th>
            <th>ID</th>
            <th>Nickname</th>
            <th><?php echo $this->lang->line('xin_employee');?></th>
            <th>Office location</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
