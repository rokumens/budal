<?php
/* Office Shift view */
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('280',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('left_office_shift');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_office_shift', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/timesheet/add_office_shift', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-10">
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('left_company');?></label>
                  <div class="col-md-4">
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?=$company->company_id?>"><?=$company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_shift_name');?></label>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_shift_name');?>" name="shift_name" type="text" value="" id="name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_monday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-1" placeholder="<?=$this->lang->line('xin_in_time');?>" readonly name="monday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-1" placeholder="<?=$this->lang->line('xin_out_time');?>" readonly name="monday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="1"><?=$this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_tuesday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-2" placeholder="<?=$this->lang->line('xin_in_time');?>" readonly name="tuesday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-2" placeholder="<?=$this->lang->line('xin_out_time');?>" readonly name="tuesday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="2"><?=$this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_wednesday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-3" placeholder="<?=$this->lang->line('xin_in_time');?>" readonly name="wednesday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-3" placeholder="<?=$this->lang->line('xin_out_time');?>" readonly name="wednesday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="3"><?=$this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_thursday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-4" placeholder="<?=$this->lang->line('xin_in_time');?>" readonly name="thursday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-4" placeholder="<?=$this->lang->line('xin_out_time');?>" readonly name="thursday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="4"><?=$this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_friday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-5" placeholder="<?=$this->lang->line('xin_in_time');?>" readonly name="friday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-5" placeholder="<?=$this->lang->line('xin_out_time');?>" readonly name="friday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="5"><?=$this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_saturday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-6" placeholder="<?=$this->lang->line('xin_in_time');?>" readonly name="saturday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-6" placeholder="<?=$this->lang->line('xin_out_time');?>" readonly name="saturday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="6"><?=$this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?=$this->lang->line('xin_sunday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-7" placeholder="<?=$this->lang->line('xin_in_time');?>" readonly name="sunday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-7" placeholder="<?=$this->lang->line('xin_out_time');?>" readonly name="sunday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="7"><?=$this->lang->line('xin_clear');?></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('left_office_shift');?></h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="120px"><?=$this->lang->line('xin_option');?></th>
            <!-- <th><?=$this->lang->line('left_company');?></th> -->
            <th>Shift Name</th>
            <th><?=$this->lang->line('xin_monday');?></th>
            <th><?=$this->lang->line('xin_tuesday');?></th>
            <th><?=$this->lang->line('xin_wednesday');?></th>
            <th><?=$this->lang->line('xin_thursday');?></th>
            <th><?=$this->lang->line('xin_friday');?></th>
            <th><?=$this->lang->line('xin_saturday');?></th>
            <th><?=$this->lang->line('xin_sunday');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
