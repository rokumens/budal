<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $session = $this->session->userdata('username');?>
<?php $attributes = array('method'=>'POST');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<div class="row">
  <?=form_open('admin/appraisal_report/import_tmp', $attributes, $hidden);?>
  <div class="col-md-6">
    <div class="form-group">
      <label for="type">Type</label>
      <?=form_dropdown('type',
      [
          '' => 'pilih',
          'DEPO' => 'Deposit',
          'WD' => 'Withdrawal',
          'TF' => 'Transfer',
          'ADJ' => 'Adjustment',
          'BONUS' => 'Bonus',
          'COMMISSION' => 'Commission',
          'CASHBACK' => 'Cashback',
          'REFERRAL' => 'Referral',
          'FREEBET' => 'Freebet',
          'AFFILIATE' => 'Affiliate',
          'SURRENDER' => 'Surrender',
          'CANCEL' => 'Cancel',
      ],
      set_value('type'), 'class="form-control"');?>
      <?=form_error('type', '<small class="from-text text-danger">', '</small>');?>
    </div>
    <div class="form-group">
      <label for="channel">Channel</label>
      <?=form_dropdown('channel',
    [
        '' => 'pilih',
        'ADMIN' => 'ADMIN',
        'MEMBER' => 'MEMBER',
    ],
    set_value('channel'), 'class="form-control"');?>
      <?=form_error('channel', '<small class="from-text text-danger">', '</small>');?>
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