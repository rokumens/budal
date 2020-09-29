<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<style type="text/css">
.trumbowyg-editor, .trumbowyg-textarea {
  min-height: 106px !important;
}
</style>
<?php if(in_array('225',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_warning');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_warning', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/warning/add_warning', $attributes, $hidden);?>
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
                <div class="form-group" id="warning_to_ajax">
                  <label for="warning_to"><?=$this->lang->line('xin_warning_to');?></label>
                  <select name="warning_to" disabled id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" id="warning_type_ajax">
                      <label for="warning_to"><?=$this->lang->line('xin_warning_type');?></label>
                      <select class="select2" disabled data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_warning_type');?>" name="noneednametype">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="subject"><?=$this->lang->line('xin_subject');?></label>
                      <input class="form-control" placeholder="<?=$this->lang->line('xin_subject');?>" name="subject" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" id="warning_by_ajax">
                      <label for="warning_by"><?=$this->lang->line('xin_warning_by');?></label>
                      <select name="warning_by" disabled id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="warning_date"><?=$this->lang->line('xin_warning_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_warning_date');?>" readonly name="warning_date" type="text">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description">Reason</label>
                  <textarea class="form-control textarea" placeholder="Reason why employee get warning" name="description" cols="30" rows="10" id="description"></textarea>
                </div>
                <?#luffy 8 dec 2019 - 12:48 pm?>
                <!-- luffy 20 Dec 2019 05:43 pm | ga dipake lagi.
                <fieldset class="form-group">
                  <label for="warning_attachmentzz">Warning Letter</label>
                  <input type="file" class="form-control-file" accept="application/pdf" id="warning_attachmentzz" name="warning_attachmentzz">
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
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('left_warnings');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style='width:150px;'><?=$this->lang->line('xin_action');?></th>
            <th>Warning To</th>
            <th>Office Location</th>
            <th><?=$this->lang->line('xin_warning_type');?></th>
            <th><?=$this->lang->line('xin_subject');?></th>
            <th><?=$this->lang->line('xin_warning_by');?></th>
            <th><?=$this->lang->line('xin_warning_date');?></th>
            <th><?=$this->lang->line('xin_approval_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
