<?php
/*
* Rollingshift view
*/
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_employee_info($session['user_id']);?>
<?php if(in_array('1025',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Generate Rolling Shift</h3>
      <div class="box-tools pull-right"><a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> Generate</button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_rollingshift', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/rollingshift/add_rollingshift', $attributes, $hidden);?>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="dateFrom">Date from</label>
                  <?=form_input('dateFrom', set_value('dateFrom'), 'id="dateFrom" class="dateShift form-control" readonly','required');?>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label for="dateTo">Date to</label>
                  <?=form_input('dateTo', set_value('dateTo'), 'id="dateTo" class="form-control" readonly','required');?>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> Generate </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?=form_close();?>
    </div>
  </div>
</div>
<?php }?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> Rolling Shift </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th>Date From</th>
            <th>Date To</th>
            <th>Created By</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
