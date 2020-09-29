<?php
/*
* Tickets view
*/
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_employee_info($session['user_id']);?>
<?php if(in_array('306',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_create_new_ticket');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>

    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_ticket', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/tickets/add_ticket', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <!-- luffy start -->
                <div class="form-group" style="padding:10px 0 10px;">
                    <label class="radio-inline"><input type="radio" id="ticketForEmployee" name="ticket_for" value="for_employee" checked>Ticket for employee</label>
                    <label class="radio-inline" style="margin-left:20px;"><input type="radio" id="ticketForDepartment" name="ticket_for" value="for_department">Ticket for department</label>
                </div>
                <!-- luffy end -->
                <div class="form-group">
                  <label for="company_name"><?=$this->lang->line('module_company_title');?></label>
                  <?php if(!in_array('384',$role_resources_ids)) { #view own?>
                      <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('module_company_title');?>">
                        <option value=""><?=$this->lang->line('xin_select_one');?></option>
                        <?php foreach($all_companies as $company) {?>
                        <option value="<?=$company->company_id;?>"> <?=$company->name;?></option>
                        <?php } ?>
                      </select>
                  <?php } else {?>
                      <select class="form-control" name="noname" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('module_company_title');?>">
                        <option value=""><?=$this->lang->line('xin_select_one');?></option>
                        <?php foreach($all_companies as $company) {?>
                        <option value="<?=$company->company_id;?>" <?php #if($user_info[0]->company_id==$company->company_id): echo 'selected="selected"'; endif;?>> <?=$company->name;?></option><?php } ?>
                      </select>
                      <input type="hidden" name="company" id="companyValByAjCompany" />
                  <?php } ?>

                </div>
                <div class="form-group">
                  <label for="task_name"><?=$this->lang->line('xin_subject');?></label>
                  <input class="form-control" placeholder="<?=$this->lang->line('xin_subject');?>" name="subject" type="text" value="">
                </div>
                <!-- luffy start -->
                <div class="form-group">
                  <label for="ticket_priority" class="control-label"><?=$this->lang->line('xin_p_priority');?></label>
                  <select name="ticket_priority" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_priority');?>">
                    <option value=""></option>
                    <option value="1"><?=$this->lang->line('xin_low');?></option>
                    <option value="2"><?=$this->lang->line('xin_medium');?></option>
                    <option value="3"><?=$this->lang->line('xin_high');?></option>
                    <option value="4"><?=$this->lang->line('xin_critical');?></option>
                  </select>
                </div>
                <!-- luffy end -->
                <div class="row" id="rowEmployee">
				        <?php #$colmd = 'col-md-6';?>
                <?php #if(!in_array('384',$role_resources_ids)) { #view own ?>
                <?php #$colmd = 'col-md-6';?>
                  <div class="col-md-12">
                    <div class="form-group" id="employee_ajax">
                      <label for="employees"><?=$this->lang->line('xin_ticket_for_employee');?></label>
                      <select class="form-control" name="employee_id" id="selectemployee" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_single_employee');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <?php #} else {?>
                  <?php #$colmd = 'col-md-12'; ?>
                  <!-- <input type="hidden" name="employee_id" value="<?=$session['user_id'];?>" /> -->
                  <?php #} ?>
                  <!-- <div class="<?=$colmd;?>">
                    <?#tadinya pririty di sini?>
                  </div> -->
                </div>
                <!-- luffy start -->
                <div class="row" id="rowDepartment" style="display:none;">
                  <div class="col-md-6">
                    <div class="form-group" id="department_ajax">
                      <label for="department"><?=$this->lang->line('xin_hr_main_department');?></label>
                      <select class="form-control" id="aj_department" name="department_id" data-plugin="select_hrm" data-placeholder="Choose Department" disabled="disabled" >
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6" id="subdepartment_ajax">
                    <div class="form-group">
                      <label for="sub_department"><?=$this->lang->line('xin_hr_sub_department');?></label>
                      <select class="form-control" name="subdepartment_id" data-plugin="select_hrm" disabled="disabled" data-placeholder="Choose Sub Department" disabled="disabled">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- luffy end -->
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?=$this->lang->line('xin_ticket_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_ticket_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
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
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('left_tickets');?> </h3>
  </div>
  <div class="box-body">
    <!-- luffy start -->
    <?php  if($receiveAssignedTicket):?>
      <br />
      <?=form_open('admin/tickets/update_ticket_assigned_to');?>
      <?php foreach($receiveAssignedTicket as $singTicket):?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="confirm">You get a ticket <span style="color:#367FA9;"><?=$singTicket->ticket_code;?></span></label><br />
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-check-square-o"></i> Confirm Receive </button>
          </div>
        </div>
      </div>
      <?php endforeach;?>
      <?=form_close(); ?>
      <br />
    <?php endif;?>
    <!-- luffy end -->
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th><?=$this->lang->line('xin_ticket_code');?></th>
            <th><?=$this->lang->line('left_company');?></th>
            <th><?=$this->lang->line('dashboard_single_employee');?></th>
            <th>Office Location</th>
            <th><?=$this->lang->line('xin_subject');?></th>
            <th><?=$this->lang->line('xin_p_priority');?></th>
            <th><?=$this->lang->line('dashboard_xin_status');?></th>
            <th><?=$this->lang->line('xin_e_details_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
