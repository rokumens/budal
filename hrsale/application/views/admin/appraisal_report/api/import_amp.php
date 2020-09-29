<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $session = $this->session->userdata('username');?>
<?php $attributes = array('method'=>'POST');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php
// $company_id = '';
// $brand_id = '';
// $type = '';
// $date_from = '';
// $date_to = '';

// $company_id = $_POST['company_id'];
// $brand_id = $this->uri->segment(7);
// $type = strtoupper($this->uri->segment(9));
// $date_from = $this->uri->segment(9);
// $date_to = $this->uri->segment(11);
?>
<div class="row">
  <?=form_open("admin/appraisal_report/import_amp", $attributes, $hidden);?>
  <div class="col-md-6">
    <div class="form-group">
      <label for="type">Type</label>
      <?=form_dropdown('type', 
        [
          ''=>'pilih',
          'WD' =>'Withdrawal',
          'DEPO' =>'Deposit',
          'TF'=>'Transfer'
        ], 
        set_value('type'), 'class="form-control"');?>
      <?=form_error('type', '<small class="from-text text-danger">', '</small>');?>
    </div>
    <div class="form-group">
      <label for="channel">CHANNEL</label>
      <?=form_dropdown('channel', 
        [
          ''=>'pilih',
          'ADMIN' =>'ADMIN',
          'MEMBER' =>'MEMBER'
        ], 
        set_value('channel'), 'class="form-control"');?>
      <?=form_error('channel', '<small class="from-text text-danger">', '</small>');?>
    </div>
    <div class="form-group">
      <label for="company_id">Company ID</label>
      <?=form_dropdown('company_id', [''=>'pilih',168=>168,'001'=>'001'], set_value('company_id'), 'class="form-control"');?>
      <?=form_error('company_id', '<small class="from-text text-danger">', '</small>');?>
    </div>
    <div class="form-group">
      <label for="brand_id">Brand ID</label>
      <?=form_dropdown('brand_id', 
        [
          ''=>'pilih',
          1 =>'1 - Anonymous / SbobetHoki',
          2 =>'2 - Seniormasteragent',
          3 =>'3 - Ayosbobet'
        ], 
        set_value('brand_id'), 'class="form-control"');?>
      <?=form_error('brand_id', '<small class="from-text text-danger">', '</small>');?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="dateFrom">Date From</label>
      <?=form_input('dateFrom', set_value('dateFrom'), 'class="dateImport form-control"');?>
      <?=form_error('dateFrom', '<small class="from-text text-danger">', '</small>');?>
    </div>
    <div class="form-group">
      <label for="dateTo">Date To</label>
      <?=form_input('dateTo', set_value('dateTo'), 'class="dateImport form-control"');?>
      <?=form_error('dateTo', '<small class="from-text text-danger">', '</small>');?>
    </div>
    <br />
    <button class="btn btn-primary" type="submit">Import</button>
  </div>
  <?=form_close();?>
</div>