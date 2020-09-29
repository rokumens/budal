<?php
/* Import Customer
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Import customer from CSV file.</h3>
    <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
      <a href="<?php echo site_url('admin/customer');?>" type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> &laquo; Back to Customer Data</a></a>
    </div>
  </div>
  <div class="box-body">
    <!-- <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line1');?></p>
    <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line2');?></p> -->
    <?php $attributes = array('name' => 'import_customer', 'id' => 'xin-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open_multipart('admin/customer/import_customer', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <fieldset class="form-group">
            <label for="logo"><?php echo $this->lang->line('xin_employee_upload_file');?></label>
            <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
            <small>Please select csv file to start importing customer data.</small>
          </fieldset>
          <!-- <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => "$this->Xin_model->form_button_class()", 'content' => '<i class="fa fa fa-check-square-o"></i> Import')); ?> -->
          <button name="hrsale_form" type="submit" class="btn btn-primary import"><i class="fa fa fa-check-square-o"></i> Import</button>
          <a href="<?php echo base_url();?>uploads/csv/sample-customer-data-for-A2.csv" style='margin-left:10px;' class="btn btn-secondary"> <i class="fa fa-download"></i> <?php echo $this->lang->line('xin_employee_import_download_sample');?> </a>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
