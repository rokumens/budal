<style type="text/css">
.d-none {display:none;}
</style>
<?php $session=$this->session->userdata('username');?>
<?php $get_animate=$this->Xin_model->get_content_animate();?>
<div class="box <?=$get_animate;?>">
<div class="box-header with-border">Employee fingerprint attendance.</div>
<div class="box-body">
  <p class="card-text">Click the button to start importing data from fingerprint machine.</p>
  <!-- strat : 7381-jazz 17jan2020 21:28 -->
  <!-- add filter by for dev -->
  <div class="form-group" style="">
    <div class="form-group" style="padding:10px 0 10px;">
      <label style="padding-right:10px;">Select Import Type:</label>
      <label class="radio-inline"><input type="radio" checked="checked" class="typeImport normal" name="typeImport" value="today">Today</label>
      <label class="radio-inline" style="margin-left:20px;"><input type="radio" class="typeImport normal" name="typeImport" value="all">All</label>
      <label class="radio-inline" style="margin-left:20px;"><input type="radio" class="typeImport range" name="typeImport" value="range">Range date</label>
    </div>
  </div>
  <!-- end : 7381-jazz 17jan2020 21:28 -->

  <div class="range-date" style="display : none">
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
    </div>
    <?=form_close(); ?>
  </div>

  <h6>
    <button class='btn btn-primary importFingerprint' type="button">
      <span class='txtFingerprintDone'> Import </span>
      <span class='txtFingerprintStart' style='display:none;'> <i class="fa fa-spinner fa-spin"></i> Start importing data, please be patience... </span>
    </button>
  </h6>
  <div class="fingerprintResponse"><div class='result' style='display:none;'></div></div>
</div>
