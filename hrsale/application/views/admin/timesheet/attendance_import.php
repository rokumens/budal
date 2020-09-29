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
  <div class="form-group" style="display: none">
    <div class="form-group" style="padding:10px 0 10px;">
      <label style="padding-right:10px;">Select Import Type:</label>
      <label class="radio-inline"><input type="radio" checked="checked" class="typeImport" name="typeImport" value="">Today</label>
      <label class="radio-inline" style="margin-left:20px;"><input type="radio" class="typeImport" name="typeImport" value="all">All</label>
    </div>
  </div>
  <!-- end : 7381-jazz 17jan2020 21:28 -->
  <h6>
    <button class='btn btn-primary importFingerprint' type="button">
      <span class='txtFingerprintDone'> Import </span>
      <span class='txtFingerprintStart' style='display:none;'> <i class="fa fa-spinner fa-spin"></i> Start importing data, please be patience... </span>
    </button>
  </h6>
  <div class="fingerprintResponse"><div class='result' style='display:none;'></div></div>
</div>
