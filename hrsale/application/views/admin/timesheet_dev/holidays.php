<?php
/* Holidays view */
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?=$get_animate;?>">
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('283',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_holiday');?> </h3>
      </div>
      <div class="box-body">
        <?php $attributes = array('name' => 'add_holiday', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/timesheet/add_holiday', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="first_name"><?=$this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?=$company->company_id?>"><?=$company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="name"><?=$this->lang->line('xin_event_name');?></label>
              <input type="text" class="form-control" name="event_name" placeholder="<?=$this->lang->line('xin_event_name');?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?=$this->lang->line('xin_start_date');?></label>
              <input class="form-control date" placeholder="<?=$this->lang->line('xin_start_date');?>" readonly name="start_date" type="text">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?=$this->lang->line('xin_end_date');?></label>
              <input class="form-control date" placeholder="<?=$this->lang->line('xin_end_date');?>" readonly name="end_date" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?=$this->lang->line('xin_description');?></label>
              <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" id="description"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="is_publish"><?=$this->lang->line('dashboard_xin_status');?></label>
              <select name="is_publish" class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_status');?>">
                <option value="1"><?=$this->lang->line('xin_published');?></option>
                <option value="0"><?=$this->lang->line('xin_unpublished');?></option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
        </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?=$colmdval;?>">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('left_holidays');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th style="width:120px;"><?=$this->lang->line('xin_action');?></th>
                <!-- <th><?=$this->lang->line('left_company');?></th> -->
                <th><?=$this->lang->line('xin_event_name');?></th>
                <th><?=$this->lang->line('dashboard_xin_status');?></th>
                <th><?=$this->lang->line('xin_start_date');?></th>
                <th><?=$this->lang->line('xin_end_date');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>
