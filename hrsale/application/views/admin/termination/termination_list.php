<?php
/* Termination*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?# luffy 8 Dec 2019 - 04:52 pm?>
<style type="text/css">
.trumbowyg-editor, .trumbowyg-textarea {
  min-height: 106px !important;
}
</style>
<?php if(in_array('228',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_termination');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_termination', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/termination/add_termination', $attributes, $hidden);?>
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
                  <label for="employee"><?=$this->lang->line('xin_employee_terminated');?></label>
                  <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="notice_date"><?=$this->lang->line('xin_notice_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_notice_date');?>" readonly name="notice_date" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="termination_date"><?=$this->lang->line('xin_termination_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_termination_date');?>" readonly name="termination_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="type"><?=$this->lang->line('xin_termination_type');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_termination_type_select');?>" name="type">
                        <option value=""></option>
                        <?php foreach($all_termination_types as $termination_type) {?>
                        <option value="<?=$termination_type->termination_type_id?>"><?=$termination_type->type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description">Reason</label>
                      <textarea class="form-control textarea" placeholder="Reason of termination" name="description" cols="30" rows="10" id="description"></textarea>
                    </div>
                  </div>
                </div>
                <?#luffy 8 dec 2019 - 04:54 pm?>
                <!-- luffy 15 Dec 2019 07:54 pm | ngga dipake lagi
                <fieldset class="form-group">
                  <label for="termination_attachmentzz">Termination Letter</label>
                  <input type="file" class="form-control-file" accept="application/pdf" id="termination_attachmentzz" name="termination_attachmentzz">
                  <small>Files allowed: pdf</small>
                </fieldset> -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="approval_by_1">Approval 1 By</label>
                      <select class="form-control" name="approval_by_1" data-plugin="select_hrm" data-placeholder="Choose who will approve this termination.">
                        <option value=""></option>
                        <?php foreach($allApprover as $singApprover){?>
                          <?php $approver=$this->Employees_model->getNamebyUserId($singApprover->approver);?>
                          <option value="<?=$approver->user_id?>"><?=$approver->employee_id.' - '.$approver->username;?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="approval_by_2">Approval 2 By</label>
                      <select class="form-control" name="approval_by_2" data-plugin="select_hrm" data-placeholder="Choose who will approve this termination.">
                        <option value=""></option>
                        <?php foreach($allApprover as $singApprover){?>
                          <?php $approver=$this->Employees_model->getNamebyUserId($singApprover->approver);?>
                          <option value="<?=$approver->user_id?>"><?=$approver->employee_id.' - '.$approver->username;?></option>
                        <?php }?>
                      </select>
                    </div>
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
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('left_terminations');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th>Terminated <?=$this->lang->line('dashboard_single_employee');?></th>
            <th>Office Location</th>
            <th><?=$this->lang->line('xin_termination_type');?></th>
            <th><?=$this->lang->line('xin_notice_date');?></th>
            <th><?=$this->lang->line('xin_termination_date');?></th>
            <th>Status</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
