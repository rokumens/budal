<?php
/*
 * finance form
 * Author: Luffy - 7380
 */
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-3">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> Form Filters </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'financeform_report', 'id' => 'financeform_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/accounting/financeform', $attributes, $hidden);?>
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
                  <label for="first_name">Forms</label>
                  <select class="form-control" name="formId" id="formId" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_hr_report_user_roles');?>" required>
                    <option value="0">All Forms</option>
                    <?php foreach($all_api_form as $singForm) {?>
                    <option value="<?php echo $singForm->form_id?>"><?php echo $singForm->form_name?></option>
                    <?php } ?>
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
        <h3 class="box-title"> Form List </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th>Form Name</th>
                <th>Entry Number</th>
                <th>Date Created</th>
                <th>Harga USD</th>
                <th>Harga IDR</th>
                <th>Url</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
