<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $session = $this->session->userdata('username');?>

<?php $attributes = array('method'=>'POST');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<div class="row">
  <div class="col-md-6">
    <?=form_open('admin/appraisal_report/import', $attributes, $hidden);?>
      <div class="form-group">
        <label for="type">Type</label>
        <?=form_dropdown('type', 
          [
            ''=>'pilih',
            'DEPO' =>'Deposit',
            'WD' =>'Withdrawal',
            'TF'=>'Transfer'
          ], 
          set_value('type'), 'class="form-control"');?>
        <?=form_error('type', '<small class="from-text text-danger">', '</small>');?>
      </div>
      <div class="form-group">
        <label for="brand_id">Brand ID</label>
        <?=form_dropdown('brand_id', 
          [
            ''=>'pilih',
            1 =>'168 - 1 - Anonymous | 001 - 1 - SbobetHoki',
            2 =>'168 - 2 - Seniormasteragent',
            3 =>'168 - 3 - Ayosbobet'
          ], 
          set_value('brand_id'), 'class="form-control"');?>
        <?=form_error('brand_id', '<small class="from-text text-danger">', '</small>');?>
      </div>
      <div class="form-group">
        <label for="company_id">Company ID</label>
        <?=form_dropdown('company_id', [''=>'pilih',168=>168,'001'=>'001'], set_value('company_id'), 'class="form-control"');?>
        <?=form_error('company_id', '<small class="from-text text-danger">', '</small>');?>
      </div>
      <div class="form-group">
        <label for="channel">Channel</label>
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
        <label for="dateFrom">Date From</label>
        <?=form_input('dateFrom', set_value('dateFrom'), 'class="dateImport form-control"');?>
        <?=form_error('dateFrom', '<small class="from-text text-danger">', '</small>');?>
      </div>
      <div class="form-group">
        <label for="dateTo">Date To</label>
        <?=form_input('dateTo', set_value('dateTo'), 'class="dateImport form-control"');?>
        <?=form_error('dateTo', '<small class="from-text text-danger">', '</small>');?>
      </div>
      <button class="btn btn-primary" type="submit">import</button>
    <?=form_close();?>

  </div>
</div>