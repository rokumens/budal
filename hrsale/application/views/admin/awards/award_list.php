<?php
/* Awards view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('207',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_award');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_award', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?=form_open('admin/awards/add_award', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="first_name"><?=$this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?=$company->company_id?>"><?=$company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?=$this->lang->line('dashboard_single_employee');?></label>
                  <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="award_type"><?=$this->lang->line('xin_award_type');?></label>
                      <select name="award_type_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_award_type');?>">
                        <option value=""></option>
                        <?php foreach($all_award_types as $award_type) {?>
                        <option value="<?=$award_type->award_type_id;?>"><?=$award_type->award_type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="award_date"><?=$this->lang->line('xin_e_details_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_award_date');?>" readonly name="award_date" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="month_year"><?=$this->lang->line('xin_award_month_year');?></label>
                      <input class="form-control d_month_year" placeholder="<?=$this->lang->line('xin_award_month_year');?>" readonly name="month_year" type="text">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?=$this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="gift"><?=$this->lang->line('xin_gift');?></label>
                  <input class="form-control" placeholder="<?=$this->lang->line('xin_gift');?>" name="gift" type="text">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="cash"><?=$this->lang->line('xin_cash');?></label>
                  <input class="form-control" placeholder="<?=$this->lang->line('xin_cash');?>" name="cash" type="number">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="logo"><?=$this->lang->line('xin_award_photo');?></label>
                    <input type="file" class="form-control-file" id="award_picture" name="award_picture">
                    <small><?=$this->lang->line('xin_company_file_type');?></small>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="award_information"><?=$this->lang->line('xin_award_info');?></label>
              <textarea class="form-control" placeholder="<?=$this->lang->line('xin_award_info');?>" name="award_information" cols="30" rows="3" id="award_information"></textarea>
            </div>
            <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
          </div>
        </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('left_awards');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style="width:120px;"><?=$this->lang->line('xin_action');?></th>
            <th><?=$this->lang->line('left_company');?></th>
            <th><?=$this->lang->line('xin_employee_name');?></th>
            <th>Office Location</th>
            <th><?=$this->lang->line('xin_award_name');?></th>
            <th><?=$this->lang->line('xin_gift');?></th>
            <th><?=$this->lang->line('xin_cash_price');?></th>
            <th><?=$this->lang->line('xin_award_month_year');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
