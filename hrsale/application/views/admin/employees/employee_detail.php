<?php /* Employee Details */?>
<style type="text/css">
.iframe-container {
  padding-bottom: 60%;
  padding-top: 30px; height: 0; overflow: hidden;
}
.iframe-container iframe,
.iframe-container object,
.iframe-container embed {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.luffy-modal {
  width: 65%;
  margin: auto;
}
</style>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php //$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);?>
<?php
$eid = $this->uri->segment(4);
$eresult = $this->Employees_model->read_employee_information($eid);
?>
<?php
$ar_sc = explode('- ',$system[0]->default_currency_symbol);
$sc_show = $ar_sc[1];
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom mb-4">
      <ul class="nav nav-tabs">
        <li class="nav-item active"> <a class="nav-link active show" data-toggle="tab" href="#xin_general"><?=$this->lang->line('xin_general');?></a> </li>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#xin_profile_picture"><?=$this->lang->line('xin_e_details_profile_picture');?></a> </li>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#xin_employee_set_salary">Set Payslip</a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane <?=$get_animate;?> active" id="xin_general">
          <div class="card-body">
            <div class="card overflow-hidden">
              <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                  <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action  nav-tabs-link active" data-toggle="list" href="javascript:void(0);" data-profile="1" data-profile-block="user_basic_info" aria-expanded="true" id="user_profile_1"><?=$this->lang->line('xin_e_details_basic');?></a>
                    <!-- <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="2" data-profile-block="immigration" aria-expanded="true" id="user_profile_2"><?=$this->lang->line('xin_employee_immigration');?></a> -->
                    <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="3" data-profile-block="contacts" aria-expanded="true" id="user_profile_3"><?=$this->lang->line('xin_employee_emergency_contacts');?></a>
                    <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="4" data-profile-block="social-networking" aria-expanded="true" id="user_profile_4"><?=$this->lang->line('xin_e_details_social');?></a>
                    <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="5" data-profile-block="documents" aria-expanded="true" id="user_profile_5"><?=$this->lang->line('xin_e_details_document');?></a>
                    <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="6" data-profile-block="qualification" aria-expanded="true" id="user_profile_6"><?=$this->lang->line('xin_e_details_qualification');?></a>
                    <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="7" data-profile-block="work-experience" aria-expanded="true" id="user_profile_7"><?=$this->lang->line('xin_e_details_w_experience');?></a>
                    <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="8" data-profile-block="bank-account" aria-expanded="true" id="user_profile_8"><?=$this->lang->line('xin_e_details_baccount');?></a>
                    <!-- <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="9" data-profile-block="change-password" aria-expanded="true" id="user_profile_9"><?=$this->lang->line('xin_e_details_cpassword');?></a> -->
                    <a class="list-group-item list-group-item-action nav-tabs-link" data-toggle="list" href="javascript:void(0);" data-profile="10" data-profile-block="leave" aria-expanded="true" id="user_profile_10"><?=$this->lang->line('xin_e_details_leave');?></a>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="tab-content">
                    <div class="tab-pane active current-tab <?=$get_animate;?>" id="user_basic_info">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_e_details_basic_info');?> </h3>
                      </div>
                      <div class="box-body">
                        <?php $attributes = array('name' => 'basic_info', 'id' => 'basic_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                        <?=form_open_multipart('admin/employees/basic_info', $attributes, $hidden);?>
                        <div class="bg-white">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="first_name"><?=$this->lang->line('xin_employee_first_name');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?=$first_name;?>">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="last_name" class="control-label"><?=$this->lang->line('xin_employee_last_name');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="<?=$last_name;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="employee_id"><?=$this->lang->line('dashboard_employee_id');?></label>
                                <input class="form-control employeeId" placeholder="<?=$this->lang->line('dashboard_employee_id');?>" name="employee_id" minlength='4' maxlength="4" type="text" value="<?=$employee_id;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="username"><?=$this->lang->line('dashboard_username');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('dashboard_username');?>" name="username" type="text" value="<?=$username;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="email" class="control-label"><?=$this->lang->line('dashboard_email');?></label>
                                <input class="form-control employeeEmail" placeholder="<?=$this->lang->line('dashboard_email');?>" name="email" type="text" value="<?=$email;?>" readonly />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="first_name"><?=$this->lang->line('left_company');?></label>
                                <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                                  <option value=""></option>
                                  <?php foreach($get_all_companies as $company) {?>
                                  <option value="<?=$company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected"<?php endif;?>><?=$company->name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group" id="ajx_department">
                                <label for="department"><?=$this->lang->line('xin_employee_department');?></label>
                                <select class="form-control" name="department_id" id="aj_subdepartments" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_employee_department');?>">
                                  <option value=""></option>
                                  <?php foreach($all_departments as $department) {?>
                                  <option value="<?=$department->department_id?>" <?php if($department_id==$department->department_id):?> selected <?php endif;?>><?=$department->department_name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4" id="subdepartment_ajax">
                            <?php $depid = $eresult[0]->department_id; ?>
                            <?php #if(isset($depid)): $depid = 1; else: $depid = $depid; endif; //asem ini bugs dari hr sale?>
                            <?php $subresult = get_sub_departments($depid);?>
                              <div class="form-group">
                                <label for="designation"><?=$this->lang->line('xin_hr_sub_department');?></label>
                                <select class="form-control" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_employee_department');?>" id="aj_subdepartment">
                                  <option value=""></option>
                                  <?php foreach($subresult as $sbdeparment) {?>
                                  <option value="<?=$sbdeparment->sub_department_id;?>" <?php if($sub_department_id==$sbdeparment->sub_department_id):?> selected="selected" <?php endif;?>><?=$sbdeparment->department_name;?></option>
								                  <?php } ?>
                                </select>
                              </div>
                            </div>

                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group" id="designation_ajax">
                                <label for="designation"><?=$this->lang->line('xin_designation');?></label>
                                <select class="form-control" name="designation_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_designation');?>">
                                  <option value=""></option>
                                  <?php foreach($all_designations as $designation) {?>
                                  <option value="<?=$designation->designation_id?>" <?php if($designation_id==$designation->designation_id):?> selected <?php endif;?>><?=$designation->designation_name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="date_of_joining" class="control-label"><?=$this->lang->line('xin_employee_doj');?></label>
                                <input class="form-control date" readonly placeholder="<?=$this->lang->line('xin_employee_doj');?>" name="date_of_joining" type="text" value="<?=$date_of_joining;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="office_shift_id" class="control-label"><?=$this->lang->line('xin_employee_office_shift');?></label>
                                <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_employee_office_shift');?>">
                                  <?php foreach($all_office_shifts as $shift) {?>
                                  <option value="<?=$shift->office_shift_id?>" <?php if($office_shift_id == $shift->office_shift_id):?> selected="selected" <?php endif; ?>><?=$shift->shift_name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="role"><?=$this->lang->line('xin_employee_role');?></label>
                                <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_employee_role');?>">
                                  <option value=""></option>
                                  <?php foreach($all_user_roles as $role) {?>
                                  <option value="<?=$role->role_id?>" <?php if($user_role_id==$role->role_id):?> selected <?php endif;?>><?=$role->role_name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="gender" class="control-label"><?=$this->lang->line('xin_employee_gender');?></label>
                                <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_employee_gender');?>">
                                  <option value="Male" <?php if($gender=='Male'):?> selected <?php endif; ?>>Male</option>
                                  <option value="Female" <?php if($gender=='Female'):?> selected <?php endif; ?>>Female</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="marital_status" class="control-label"><?=$this->lang->line('xin_employee_mstatus');?></label>
                                <select class="form-control" name="marital_status" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_employee_mstatus');?>">
                                  <option value="Single" <?php if($marital_status=='Single'):?> selected <?php endif;?>>Single</option>
                                  <option value="Married" <?php if($marital_status=='Married'):?> selected <?php endif;?>>Married</option>
                                  <option value="Complicated" <?php if($marital_status=='Complicated'):?> selected <?php endif;?>>Complicated</option>
                                  <option value="Widowed" <?php if($marital_status=='Widowed'):?> selected <?php endif;?>>Widowed</option>
                                  <option value="Divorced" <?php if($marital_status=='Divorced'):?> selected <?php endif;?>>Divorced</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                          	<div class="col-md-4">
                              <div class="form-group">
                                <label for="date_of_birth"><?=$this->lang->line('xin_employee_dob');?></label>
                                <input class="form-control date" readonly placeholder="<?=$this->lang->line('xin_employee_dob');?>" name="date_of_birth" type="text" value="<?=$date_of_birth;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="time_of_birth">Time of Birth</label>
                                <!-- <input class="form-control" placeholder="Time of Birth" name="time_of_birth" type="time" value="<?=($birthTime=='00:00:00')?'00:00:00':$birthTime;?>"> -->
                                <input class="form-control timepicker" placeholder="Time of Birth" readonly name="time_of_birth" type="text" value="<?=($birthTime=='00:00:00')?'00:00':substr($birthTime, 0, -3);?>">
                              </div>
                            </div>
							              <?php $leave_categories_ids = explode(',',$leave_categories);?>
                            <div class="col-md-4">
                              <div class="form-group">
                                <!-- <label for="xin_hr_leave_cat"><?=$this->lang->line('xin_hr_leave_cat');?></label> -->
                                <label for="xin_hr_leave_cat">Leave Allowed</label>
                                <input type="hidden" name="leave_categories[]" value="0" />
                                <select multiple="multiple" class="form-control" name="leave_categories[]" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_hr_leave_cat');?>">
                                  <?php foreach($all_leave_types as $leave_type) {?>
                                  <option value="<?=$leave_type->leave_type_id?>" <?php if(isset($_GET)) { if(in_array($leave_type->leave_type_id,$leave_categories_ids)):?> selected <?php endif; }?>><?=$leave_type->type_name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="contact_no" class="control-label"><?=$this->lang->line('xin_contact_number');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="<?=$contact_no;?>">
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group">
                                <label for="address"><?=$this->lang->line('xin_employee_address');?></label>
                                <input type="text" class="form-control" placeholder="<?=$this->lang->line('xin_employee_address');?>" name="address" value="<?=$address;?>" />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <?# luffy 6 Des 2019 - 06:44 pm?>
                          	<div class="col-md-4">
                              <div class="form-group">
                                <fieldset class="form-group">
                                  <label for="bazi_file">Bazi File</label>
                                  <input type="file" class="form-control-file" id="bazi_file" name="bazi_file">
                                  <input type="hidden" class="form-control" name="existingBazi" value="<?=$baziFile?>" readonly />
                                  <small>Upload files only: png, jpg, jpeg, pdf, gif, pdf</small>
                                  <?php if(!empty($baziFile)):?>
                                  <br />
                                  <i class="fa fa-eye" aria-hidden="true" style="color:#3c8dbc;"></i>&nbsp;
                                  <a class="view-bazi" data-toggle="modal" data-target="#noneedid" href="<?=site_url();?>uploads/profile/bazi/<?=$baziFile;?>">
                                    See bazi file
                                  </a>.
                                  <?php endif;?>
                                </fieldset>
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group">
                                <label for="bazi_desc">Bazi Description</label>
                                <input type="text" class="form-control" placeholder="Bazi result description from 'suhu'" name="bazi_desc" value="<?=$baziDesc;?>" />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="date_of_leaving" class="control-label"><?=$this->lang->line('xin_employee_dol');?></label>
                                <input class="form-control date" readonly placeholder="<?=$this->lang->line('xin_employee_dol');?>" name="date_of_leaving" type="text" value="<?=$date_of_leaving;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group"><?d($all_exit_types);?>
                                <label for="status" class="control-label"><?=$this->lang->line('dashboard_xin_status');?></label>
                                <select class="form-control" id="statusIsActive" name="status" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_xin_status');?>">
                                  <option value="0" <?php if($is_active=='0'):?> selected <?php endif; ?>><?=$this->lang->line('xin_employees_inactive');?></option>
                                  <option value="1" <?php if($is_active=='1'):?> selected <?php endif; ?>><?=$this->lang->line('xin_employees_active');?></option>
                                </select>
                              </div>
                            </div>
                            <?php $reasonVisibility=''; if($is_active=='1') $reasonVisibility='style="display:none;"';?>
                            <div class="col-md-4" id="rowInactiveReason" <?=$reasonVisibility;?>>
                              <div class="form-group">
                                <label for="inactive_reason" class="control-label">Inactive Reason</label>
                                <select class="form-control" name="inactive_reason" data-plugin="select_hrm" data-placeholder="Choose inactive reason">
                                  <?php foreach($all_exit_types as $singReason):?>
                                  <option value="<?=$singReason->exit_type_id;?>" <?php if($inactiveReason==$singReason->exit_type_id):?> selected <?php endif; ?>><?=$singReason->type;?></option>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                        </div>
                        <?=form_close(); ?> </div>
                    </div>

                    <?php //luff: immigration?>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="immigration">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_employee_immigration');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'immigration_info', 'id' => 'immigration_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('user_id' => $user_id, 'u_document_info' => 'UPDATE');?>
                        <?=form_open_multipart('admin/employees/immigration_info', $attributes, $hidden);?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="relation"><?=$this->lang->line('xin_e_details_document');?></label>
                              <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_e_details_choose_dtype');?>">
                                <option value=""></option>
                                <?php foreach($all_document_types as $document_type) {?>
                                <option value="<?=$document_type->document_type_id;?>"> <?=$document_type->document_type;?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="document_number" class="control-label"><?=$this->lang->line('xin_employee_document_number');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_document_number');?>" name="document_number" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="issue_date" class="control-label"><?=$this->lang->line('xin_issue_date');?></label>
                              <input class="form-control date" readonly="readonly" placeholder="Issue Date" name="issue_date" type="text">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="expiry_date" class="control-label"><?=$this->lang->line('xin_e_details_doe');?></label>
                              <input class="form-control date" readonly="readonly" placeholder="<?=$this->lang->line('xin_e_details_doe');?>" name="expiry_date" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <fieldset class="form-group">
                                <label for="logo"><?=$this->lang->line('xin_e_details_document_file');?></label>
                                <input type="file" class="form-control-file" id="p_file2" name="document_file">
                                <small><?=$this->lang->line('xin_e_details_d_type_file');?></small>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="eligible_review_date" class="control-label"><?=$this->lang->line('xin_eligible_review_date');?></label>
                              <input class="form-control date" readonly="readonly" placeholder="<?=$this->lang->line('xin_eligible_review_date');?>" name="eligible_review_date" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="send_mail"><?=$this->lang->line('xin_country');?></label>
                              <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_country');?>">
                                <option value=""><?=$this->lang->line('xin_select_one');?></option>
                                <?php foreach($all_countries as $scountry) {?>
                                <option value="<?=$scountry->country_id;?>"> <?=$scountry->country_name;?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_assigned_immigration');?> <?=$this->lang->line('xin_records');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_imgdocument" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('xin_e_details_document');?></th>
                                  <th>Document Number</th> <!-- luffy 5 January 2020 07:35 pm -->
                                  <th><?=$this->lang->line('xin_issued_by');?></th>
                                  <th><?=$this->lang->line('xin_issue_date');?></th>
                                  <th><?=$this->lang->line('xin_expiry_date');?></th>
                                  <th><?=$this->lang->line('xin_eligible_review_date');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php //luffy: immigration?>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="contacts">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_e_details_contact');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'contact_info', 'id' => 'contact_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'ADD');?>
                        <?=form_open('admin/employees/contact_info', $attributes, $hidden);?>
                        <?php
            						  $data_usr1 = array(
            								'type'  => 'hidden',
            								'name'  => 'user_id',
            								'id'    => 'user_id',
            								'value' => $user_id,
            						 );
            						 echo form_input($data_usr1);
            					  ?>
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="relation"><?=$this->lang->line('xin_e_details_relation');?></label>
                              <select class="form-control" name="relation" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_one');?>">
                                <option value=""><?=$this->lang->line('xin_select_one');?></option>
                                <option value="Self"><?=$this->lang->line('xin_self');?></option>
                                <option value="Parent"><?=$this->lang->line('xin_parent');?></option>
                                <option value="Spouse"><?=$this->lang->line('xin_spouse');?></option>
                                <option value="Child"><?=$this->lang->line('xin_child');?></option>
                                <option value="Sibling"><?=$this->lang->line('xin_sibling');?></option>
                                <option value="In Laws"><?=$this->lang->line('xin_in_laws');?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-7">
                            <div class="form-group">
                              <label for="work_email" class="control-label"><?=$this->lang->line('dashboard_email');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_work');?>" name="work_email" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label>
                                <input type="checkbox" class="minimal" value="1" id="is_primary" name="is_primary">
                                <?=$this->lang->line('xin_e_details_pcontact');?></span> </label>
                              &nbsp;
                              <label>
                                <input type="checkbox" class="minimal" value="2" id="is_dependent" name="is_dependent">
                                <?=$this->lang->line('xin_e_details_dependent');?></span> </label>
                            </div>
                          </div>
                          <div class="col-md-7">
                            <div class="form-group">
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_personal');?>" name="personal_email" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="name" class="control-label"><?=$this->lang->line('xin_name');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_name');?>" name="contact_name" type="text">
                            </div>
                          </div>
                          <div class="col-md-7">
                            <div class="form-group" id="designation_ajax">
                              <label for="address_1" class="control-label"><?=$this->lang->line('xin_address');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_address_1');?>" name="address_1" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="work_phone"><?=$this->lang->line('xin_phone');?></label>
                              <div class="row">
                                <div class="col-md-8">
                                  <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_work');?>" name="work_phone" type="text">
                                </div>
                                <div class="col-md-4">
                                  <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_phone_ext');?>" name="work_phone_extension" type="text">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-7">
                            <div class="form-group">
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_address_2');?>" name="address_2" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_mobile');?>" name="mobile_phone" type="text">
                            </div>
                          </div>
                          <div class="col-md-7">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-5">
                                  <input class="form-control" placeholder="<?=$this->lang->line('xin_city');?>" name="city" type="text">
                                </div>
                                <div class="col-md-4">
                                  <input class="form-control" placeholder="<?=$this->lang->line('xin_state');?>" name="state" type="text">
                                </div>
                                <div class="col-md-3">
                                  <input class="form-control" placeholder="<?=$this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_home');?>" name="home_phone" type="text">
                            </div>
                          </div>
                          <div class="col-md-7">
                            <div class="form-group">
                              <select name="country" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_country');?>">
                                <option value=""></option>
                                <?php foreach($all_countries as $country) {?>
                                <option value="<?=$country->country_id;?>"> <?=$country->country_name;?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_e_details_contacts');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_contact" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('xin_employees_full_name');?></th>
                                  <th>Type</th>
                                  <th><?=$this->lang->line('xin_e_details_relation');?></th>
                                  <th><?=$this->lang->line('dashboard_email');?></th>
                                  <th><?=$this->lang->line('xin_e_details_mobile');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="documents">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_e_details_document');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'document_info', 'id' => 'document_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_document_info' => 'UPDATE');?>
                        <?=form_open_multipart('admin/employees/document_info', $attributes, $hidden);?>
                        <?php
                				  $data_usr2 = array(
                						'type'  => 'hidden',
                						'name'  => 'user_id',
                						'value' => $user_id,
                  				);
                  				echo form_input($data_usr2);
                			  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="relation"><?=$this->lang->line('xin_e_details_dtype');?></label>
                              <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_e_details_choose_dtype');?>">
                                <option value=""></option>
                                <?php foreach($all_document_types as $document_type) {?>
                                <option value="<?=$document_type->document_type_id;?>"> <?=$document_type->document_type;?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date_of_expiry" class="control-label"><?=$this->lang->line('xin_e_details_doe');?></label>
                              <input class="form-control date" readonly placeholder="<?=$this->lang->line('xin_e_details_doe');?>" name="date_of_expiry" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="title" class="control-label"><?=$this->lang->line('xin_e_details_dtitle');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_dtitle');?>" name="title" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-5">
                                  <label for="xin_gtax"><?=$this->lang->line('xin_hr_official_license_alarm');?> 1</label>
                                  <input class="form-control" placeholder="" name="license_notification_1" type="number" min="1" />
                                </div>
                                <div class="col-md-7">
                                  <label for="xin_gtax_satuan">&nbsp;</label>
                                  <select class="form-control" name="license_notification_satuan_1" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_hr_official_license_alarm');?>">
                                    <option value="days">Day</option>
                                    <option value="weeks">Week</option>
                                    <option value="months">Month</option>
                                    <option value="years">Year</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <fieldset class="form-group">
                                <label for="logo"><?=$this->lang->line('xin_e_details_document_file');?></label>
                                <input type="file" class="form-control-file" id="document_file" name="document_file">
                                <small><?=$this->lang->line('xin_e_details_d_type_file');?></small>
                              </fieldset>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-5">
                                  <label for="xin_gtax"><?=$this->lang->line('xin_hr_official_license_alarm');?> 2</label>
                                  <input class="form-control" placeholder="" name="license_notification_2" type="number" min="1" />
                                </div>
                                <div class="col-md-7">
                                  <label for="xin_gtax_satuan">&nbsp;</label>
                                  <select class="form-control" name="license_notification_satuan_2" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_hr_official_license_alarm');?>">
                                    <option value="days">Day</option>
                                    <option value="weeks">Week</option>
                                    <option value="months">Month</option>
                                    <option value="years">Year</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="description" class="control-label"><?=$this->lang->line('xin_description');?></label>
                              <textarea class="form-control" placeholder="<?=$this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
                            </div>
                          </div>
                          <div class="col-md-6" style='display:none;'>
                            <div class="form-group" style='visibility:hidden;'><?#sengaja di'hidden. notif to slack, not to email.?>
                              <label for="email" class="control-label"><?=$this->lang->line('xin_e_details_notifyemail');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_notifyemail');?>" name="email" type="email">
                            </div>
                            <div class="form-group" style='visibility:hidden;'><?#sengaja di'hidden. notif to slack, not to email.?>
                              <label for="send_mail"><?=$this->lang->line('xin_e_details_send_notifyemail');?></label>
                              <select name="send_mail" id="send_mail" class="form-control" data-plugin="select_hrm">
                                <option value="1"><?=$this->lang->line('xin_yes');?></option>
                                <option value="2"><?=$this->lang->line('xin_no');?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_e_details_documents');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('xin_e_details_dtype');?></th>
                                  <th><?=$this->lang->line('dashboard_xin_title');?></th>
                                  <th><?=$this->lang->line('xin_e_details_doe');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="qualification">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_e_details_qualification');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'qualification_info', 'id' => 'qualification_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/qualification_info', $attributes, $hidden);?>
                        <?php
                				  $data_usr3 = array(
                						'type'  => 'hidden',
                						'name'  => 'user_id',
                						'value' => $user_id,
                  				);
                  				echo form_input($data_usr3);
                			  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name"><?=$this->lang->line('xin_e_details_inst_name');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_inst_name');?>" name="name" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="education_level" class="control-label"><?=$this->lang->line('xin_e_details_edu_level');?></label>
                              <select class="form-control" name="education_level" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_e_details_edu_level');?>">
                                <?php foreach($all_education_level as $education_level) {?>
                                <option value="<?=$education_level->education_level_id?>"><?=$education_level->name?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="from_year" class="control-label"><?=$this->lang->line('xin_e_details_timeperiod');?></label>
                              <div class="row">
                                <div class="col-md-6">
                                  <input class="form-control date" readonly="readonly" placeholder="<?=$this->lang->line('xin_e_details_from');?>" name="from_year" type="text">
                                </div>
                                <div class="col-md-6">
                                  <input class="form-control date" readonly="readonly" placeholder="<?=$this->lang->line('dashboard_to');?>" name="to_year" type="text">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="language" class="control-label"><?=$this->lang->line('xin_e_details_language');?></label>
                              <select class="form-control" name="language" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_e_details_language');?>">
                                <?php foreach($all_qualification_language as $qualification_language) {?>
                                <option value="<?=$qualification_language->language_id?>"><?=$qualification_language->name?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="skill" class="control-label"><?=$this->lang->line('xin_e_details_skill');?></label>
                              <select class="form-control" name="skill" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_e_details_skill');?>">
                                <option value=""></option>
                                <?php foreach($all_qualification_skill as $qualification_skill) {?>
                                <option value="<?=$qualification_skill->skill_id?>"><?=$qualification_skill->name?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="to_year" class="control-label"><?=$this->lang->line('xin_description');?></label>
                              <textarea class="form-control" placeholder="<?=$this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_e_details_qualification');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_qualification" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('xin_e_details_inst_name');?></th>
                                  <!-- <th><?=$this->lang->line('xin_e_details_timeperiod');?></th> -->
                                  <th><?=$this->lang->line('xin_e_details_edu_level');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="work-experience">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_e_details_w_experience');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'work_experience_info', 'id' => 'work_experience_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/work_experience_info', $attributes, $hidden);?>
                        <?php
                				  $data_usr4 = array(
                						'type'  => 'hidden',
                						'name'  => 'user_id',
                						'value' => $user_id,
                  				);
                  				echo form_input($data_usr4);
                			  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="company_name"><?=$this->lang->line('xin_company_name');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_company_name');?>" name="company_name" type="text" value="" id="company_name">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="post">Position as</label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_post');?>" name="post" type="text" value="" id="post">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="from_year" class="control-label"><?=$this->lang->line('xin_e_details_timeperiod');?></label>
                              <div class="row">
                                <div class="col-md-6">
                                  <input class="form-control date" readonly="readonly" placeholder="<?=$this->lang->line('xin_e_details_from');?>" name="from_date" type="text">
                                </div>
                                <div class="col-md-6">
                                  <input class="form-control date" readonly="readonly" placeholder="<?=$this->lang->line('dashboard_to');?>" name="to_date" type="text">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="description">Job <?=$this->lang->line('xin_description');?></label>
                              <textarea class="form-control" placeholder="<?=$this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="4" id="description"></textarea>
                              <span class="countdown"></span> </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close();?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_e_details_w_experience');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_work_experience" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('xin_company_name');?></th>
                                  <th><?=$this->lang->line('xin_e_details_frm_date');?></th>
                                  <th><?=$this->lang->line('xin_e_details_to_date');?></th>
                                  <th>Position as</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="bank-account">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_e_details_baccount');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'bank_account_info', 'id' => 'bank_account_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/bank_account_info', $attributes, $hidden);?>
                        <?php
                				  $data_usr4 = array(
                						'type'  => 'hidden',
                						'name'  => 'user_id',
                						'value' => $user_id,
                  				);
                  				echo form_input($data_usr4);
                			  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="account_title">Acount Name</label>
                              <input class="form-control" placeholder="Account Name" name="account_title" type="text" value="" id="account_name">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="account_number"><?=$this->lang->line('xin_e_details_acc_number');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_acc_number');?>" name="account_number" type="number" min='0' value="" id="account_number">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="bank_name"><?=$this->lang->line('xin_e_details_bank_name');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_bank_name');?>" name="bank_name" type="text" value="" id="bank_name">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="bank_code"><?=$this->lang->line('xin_e_details_bank_code');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_bank_code');?>" name="bank_code" type="text" value="" id="bank_code">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="bank_branch"><?=$this->lang->line('xin_e_details_bank_branch');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_bank_branch');?>" name="bank_branch" type="text" value="" id="bank_branch">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_e_details_baccount');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_bank_account" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th>Account Name</th>
                                  <th><?=$this->lang->line('xin_e_details_acc_number');?></th>
                                  <th><?=$this->lang->line('xin_e_details_bank_name');?></th>
                                  <th><?=$this->lang->line('xin_e_details_bank_code');?></th>
                                  <th><?=$this->lang->line('xin_e_details_bank_branch');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="social-networking">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_e_details_social');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'social_networking', 'id' => 'f_social_networking', 'autocomplete' => 'off');?>
                        <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/social_info', $attributes, $hidden);?>
                        <div class="bg-white">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="facebook_profile"><?=$this->lang->line('xin_e_details_fb_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_fb_profile');?>" name="facebook_link" type="text" value="<?=$facebook_link;?>">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="facebook_profile"><?=$this->lang->line('xin_e_details_twit_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_twit_profile');?>" name="twitter_link" type="text" value="<?=$twitter_link;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="twitter_profile"><?=$this->lang->line('xin_e_details_blogr_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_blogr_profile');?>" name="blogger_link" type="text" value="<?=$blogger_link;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="blogger_profile"><?=$this->lang->line('xin_e_details_linkd_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_linkd_profile');?>" name="linkdedin_link" type="text" value="<?=$linkdedin_link;?>">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="blogger_profile"><?=$this->lang->line('xin_e_details_gplus_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_gplus_profile');?>" name="google_plus_link" type="text" value="<?=$google_plus_link;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="linkdedin_profile"><?=$this->lang->line('xin_e_details_insta_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_insta_profile');?>" name="instagram_link" type="text" value="<?=$instagram_link;?>">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="linkdedin_profile"><?=$this->lang->line('xin_e_details_pintrst_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_pintrst_profile');?>" name="pinterest_link" type="text" value="<?=$pinterest_link;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="linkdedin_profile"><?=$this->lang->line('xin_e_details_utube_profile');?></label>
                                <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_utube_profile');?>" name="youtube_link" type="text" value="<?=$youtube_link;?>">
                              </div>
                            </div>
                          </div>
                          <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                        </div>
                        <?=form_close(); ?> </div>
                    </div>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="change-password">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('header_change_password');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/change_password', $attributes, $hidden);?>
                        <?php
            						  $data_usr5 = array(
            								'type'  => 'hidden',
            								'name'  => 'user_id',
            								'value' => $user_id,
            						  );
            						  echo form_input($data_usr5);
            					  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="new_password"><?=$this->lang->line('xin_e_details_enpassword');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="new_password_confirm" class="control-label"><?=$this->lang->line('xin_e_details_ecnpassword');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                    </div>
                    <div class="tab-pane current-tab <?=$get_animate;?>" id="leave">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_e_details_leave');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <div class="row">
                          <?php foreach($all_leave_types as $type) {?>
                          <?php $count_l = $this->Timesheet_model->count_total_leaves($type->leave_type_id,$this->uri->segment(4));?>
                          <?php
              							if($count_l == 0){
              								$progress_class = '';
              								$count_data = 0;
              							} else {
              								$count_data = $count_l / $type->days_per_year * 100;
              								// progress
              								if($count_data <= 20) {
              									$progress_class = 'progress-success';
              								} else if($count_data > 20 && $count_data <= 50){
              									$progress_class = 'progress-info';
              								} else if($count_data > 50 && $count_data <= 75){
              									$progress_class = 'progress-warning';
              								} else {
              									$progress_class = 'progress-danger';
              								}
              							}
              						?>
                          <div class="col-md-4">
                            <div class="box mb-4">
                              <div class="box-body">
                                <div class="d-flex align-items-center">
                                  <div class="fa fa-calendar-check-o display-4 text-success"></div>
                                  <div class="ml-3">
                                    <div class="text-muted small"> <?=$type->type_name;?> (<?=$count_l;?>/<?=$type->days_per_year;?>)</div>
                                    <div class="text-large">
                                      <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="width: <?=$count_data;?>%;"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                					}
                					?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="xin_profile_picture">
          <div class="box-body">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-12">
                <div class="tab-content">
                  <div class="tab-pane  <?=$get_animate;?> active" id="profile-picture">
                    <div class="box-body pb-2">
                      <?php $attributes = array('name' => 'profile_picture', 'id' => 'f_profile_picture', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_profile_picture' => 'UPDATE');?>
                      <?=form_open_multipart('admin/employees/profile_picture', $attributes, $hidden);?>
                      <?php
                        $data_usr = array(
                          'type'  => 'hidden',
                          'name'  => 'user_id',
                          'id'    => 'user_id',
                          'value' => $user_id,
                        );
                        echo form_input($data_usr);
                      ?>
                      <?php
                        $data_usr = array(
                          'type'  => 'hidden',
                          'name'  => 'session_id',
                          'id'    => 'session_id',
                          'value' => $session['user_id'],
                        );
                        echo form_input($data_usr);
                      ?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <fieldset class="form-group">
                                <label for="logo"><?=$this->lang->line('xin_browse');?></label>
                                <input type="file" class="form-control-file" id="p_file" name="p_file">
                                <small><?=$this->lang->line('xin_e_details_picture_type');?></small>
                              </fieldset>
                              <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                              <img src="<?=base_url().'uploads/profile/'.$profile_picture;?>" width="50px" style="margin-left:20px;" id="u_file">
                              <?php } else {?>
                              <?php if($gender=='Male') { ?>
                              <?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
                              <?php } else { ?>
                              <?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
                              <?php } ?>
                              <img src="<?=$de_file;?>" width="50px" style="margin-left:20px;" id="u_file">
                              <?php } ?>
                              <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                              <br />
                              <label>
                                <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                <?=$this->lang->line('xin_e_details_remove_pic');?></span> </label>
                              <?php } else {?>
                              <div id="remove_file" style="display:none;">
                                <label>
                                  <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                  <?=$this->lang->line('xin_e_details_remove_pic');?></span> </label>
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <div class="form-action box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                      </div>
                      <?=form_close(); ?> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane <?=$get_animate;?>" id="xin_employee_set_salary">
          <div class="card-body">
            <div class="card overflow-hidden">
              <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                  <div class="list-group list-group-flush account-settings-links">
                    <a class="salary-tab-list list-group-item list-group-item-action active salary-tab" data-toggle="list" href="javascript:void(0);" data-profile="1" data-profile-block="salary" aria-expanded="true" id="suser_profile_1"><?=$this->lang->line('xin_employee_update_salary');?></a>
                    <!-- <a class="salary-tab-list list-group-item list-group-item-action salary-tab" data-toggle="list" href="javascript:void(0);" data-profile="2" data-profile-block="overtime" aria-expanded="true" id="suser_profile_2"><?=$this->lang->line('dashboard_overtime');?></a>
                    <a class="salary-tab-list list-group-item list-group-item-action salary-tab" data-toggle="list" href="javascript:void(0);" data-profile="3" data-profile-block="loan_deductions" aria-expanded="true" id="suser_profile_3"><?=$this->lang->line('xin_employee_set_loan_deductions');?></a> -->
                    <a class="salary-tab-list list-group-item list-group-item-action salary-tab" data-toggle="list" href="javascript:void(0);" data-profile="4" data-profile-block="adjustment_plus" aria-expanded="true" id="suser_profile_4">Adjustment (+)</a>
                    <a class="salary-tab-list list-group-item list-group-item-action salary-tab" data-toggle="list" href="javascript:void(0);" data-profile="5" data-profile-block="adjustment_minus" aria-expanded="true" id="suser_profile_5">Adjustment (-)</a>
                    <!-- <a class="salary-tab-list list-group-item list-group-item-action salary-tab" data-toggle="list" href="javascript:void(0);" data-profile="5" data-profile-block="statutory_deductions" aria-expanded="true" id="suser_profile_5"><?=$this->lang->line('xin_employee_set_statutory_deductions');?></a>
                    <a class="salary-tab-list list-group-item list-group-item-action salary-tab" data-toggle="list" href="javascript:void(0);" data-profile="5" data-profile-block="other_payment" aria-expanded="true" id="suser_profile_5"><?=$this->lang->line('xin_employee_set_other_payment');?></a> -->
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="tab-content active">
                    <div class="tab-pane <?=$get_animate;?> salary-current-tab active" id="salary">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_employee_update_salary');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'employee_update_salary', 'id' => 'employee_update_salary', 'autocomplete' => 'off');?>
                        <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/update_salary_option', $attributes, $hidden);?>
                        <div class="bg-white">
                          <div class="row">
                            <div class="col-md-4">
                              <label for="basic_salary"><?=$this->lang->line('xin_payroll_basic_salary');?></label>
                              <div class="form-group">
                                <input class="form-control basic_salary" placeholder="<?=$this->lang->line('xin_payroll_basic_salary');?>" name="basic_salary" type="number" min="0" value="<?=$basic_salary;?>">
                              </div>
                              <div class="form-group">
                                <button name="hrsale_form" type="submit" class="btn btn-primary"><i class="fa fa fa-check-square-o"></i> Save</button>
                              </div>
                            </div>
                            <div class="col-md-4" style="visibility:hidden"> <?#forced hidden?>
                              <label for="daily_wages"><?=$this->lang->line('xin_employee_daily_wages');?></label>
                              <div class="form-group">
                                <input class="form-control daily_wages" placeholder="<?=$this->lang->line('xin_employee_daily_wages');?>" name="daily_wages" type="number" min="0" value="<?=$daily_wages;?>">
                              </div>
                            </div>
                            <div class="col-md-4" style="visibility:hidden"> <?#forced hidden?>
                              <div class="form-group">
                                <label for="wages_type"><?=$this->lang->line('xin_employee_type_wages');?></label>
                                <select name="wages_type" id="wages_type" class="form-control" data-plugin="select_hrm">
                                  <!-- <option value="1" <?php if($wages_type==1):?> selected="selected"<?php endif;?>><?=$this->lang->line('xin_payroll_basic_salary');?></option>
                                  <option value="2" <?php if($wages_type==2):?> selected="selected"<?php endif;?>><?=$this->lang->line('xin_employee_daily_wages');?></option> -->
                                  <?#forced selected to basic salary?>
                                  <option value="1" selected="selected"><?=$this->lang->line('xin_payroll_basic_salary');?></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <!-- <div   class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div> -->
                        </div>
                        <?=form_close(); ?>
                      </div>
                    </div>

                    <?# adjustment plus - luffy 29 nov 2019 - 03:34 pm?>
                    <div class="tab-pane <?=$get_animate;?> salary-current-tab" id="adjustment_plus">
                      <div class="box-header with-border">
                        <h3 class="box-title"> Adjustment (+) </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'employee_update_allowance', 'id' => 'employee_update_allowance', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/employee_allowance_option', $attributes, $hidden);?>
                        <?php
                				  $data_usr4 = array(
                						'type'  => 'hidden',
                						'name'  => 'user_id',
                						'value' => $user_id,
                  				);
                  				echo form_input($data_usr4);
                			  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="allowance_title"><?=$this->lang->line('dashboard_xin_title');?></label>
                              <input class="form-control" placeholder="Set title" name="allowance_title" type="text" value="" id="allowance_title">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="allowance_amount"><?=$this->lang->line('xin_amount');?></label>
                              <input class="form-control" placeholder="Set amount" name="allowance_amount" type="number" min="0" value="" id="allowance_amount">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> Adjustment (+) </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_all_allowances" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('dashboard_xin_title');?></th>
                                  <th><?=$this->lang->line('xin_amount');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <?# adjustment minus - luffy 29 nov 2019 - 03:34 pm?>
                    <div class="tab-pane <?=$get_animate;?> salary-current-tab" id="adjustment_minus">
                      <div class="box-header with-border">
                        <h3 class="box-title"> Adjustment (-) </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'employee_add_adjustment_minus', 'id' => 'employee_add_adjustment_minus', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/add_adjustment_minus', $attributes, $hidden);?>
                        <?php
                				  $data_usr4 = array(
                						'type'  => 'hidden',
                						'name'  => 'user_id',
                						'value' => $user_id,
                  				);
                  				echo form_input($data_usr4);
                			  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="adjustment_min_title">Title</label>
                              <input class="form-control" placeholder="Set title" name="adjustment_min_title" type="text" value="" id="allowance_title">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="adjustment_min_amount">Amount</label>
                              <input class="form-control" placeholder="Set amount" name="adjustment_min_amount" type="number" min="0" value="" id="allowance_amount">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> Adjustment (-) </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_adjustment_minus" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('dashboard_xin_title');?></th>
                                  <th><?=$this->lang->line('xin_amount');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane <?=$get_animate;?> salary-current-tab" id="loan_deductions">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_employee_set_loan_deductions');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'add_loan_info', 'id' => 'add_loan_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/employee_loan_info', $attributes, $hidden);?>
                        <?php
          							  $data_usr4 = array(
          									'type'  => 'hidden',
          									'name'  => 'user_id',
          									'value' => $user_id,
            							);
            							echo form_input($data_usr4);
          						  ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="month_year"><?=$this->lang->line('dashboard_xin_title');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('dashboard_xin_title');?>" name="loan_deduction_title" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="edu_role"><?=$this->lang->line('xin_employee_monthly_installment_title');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_monthly_installment_title');?>" name="monthly_installment" type="number" min="0" id="m_monthly_installment">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="month_year"><?=$this->lang->line('xin_start_date');?></label>
                              <input class="form-control cont_date" placeholder="<?=$this->lang->line('xin_start_date');?>" readonly="readonly" name="start_date" type="text">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="end_date"><?=$this->lang->line('xin_end_date');?></label>
                              <input class="form-control cont_date" readonly="readonly" placeholder="<?=$this->lang->line('xin_end_date');?>" name="end_date" type="text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="description"><?=$this->lang->line('xin_reason');?></label>
                              <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_reason');?>" name="reason" cols="30" rows="2" id="reason2"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_employee_set_loan_deductions');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_all_deductions" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('dashboard_xin_title');?></th>
                                  <th><?=$this->lang->line('xin_employee_monthly_installment_title');?></th>
                                  <th><?=$this->lang->line('xin_start_date');?></th>
                                  <th><?=$this->lang->line('xin_end_date');?></th>
                                  <th><?=$this->lang->line('xin_employee_loan_time');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane <?=$get_animate;?> salary-current-tab" id="statutory_deductions">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_employee_set_statutory_deductions');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'statutory_deductions_info', 'id' => 'statutory_deductions_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/set_statutory_deductions', $attributes, $hidden);?>
                        <?php
          							  $data_usr4 = array(
          									'type'  => 'hidden',
          									'name'  => 'user_id',
          									'value' => $user_id,
            							 );
            							 echo form_input($data_usr4);
          						  ?>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_ssempee"><?=$this->lang->line('xin_employee_set_ssempee');?> (%)</label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_ssempee" type="number" min="0" value="<?=$salary_ssempee;?>" id="salary_ssempee">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_ssempeer"><?=$this->lang->line('xin_employee_set_ssempeer');?> (%)</label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_ssempeer" type="number" min="0" value="<?=$salary_ssempeer;?>" id="salary_ssempeer">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_income_tax"><?=$this->lang->line('xin_employee_set_inc_tax');?> (%)</label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_income_tax" type="number" min="0" value="<?=$salary_income_tax;?>" id="salary_income_tax">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                    </div>
                    <div class="tab-pane <?=$get_animate;?> salary-current-tab" id="other_payment">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('xin_employee_set_other_payment');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'other_payments_info', 'id' => 'other_payments_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/set_other_payments', $attributes, $hidden);?>
                        <?php
          							  $data_usr4 = array(
          									'type'  => 'hidden',
          									'name'  => 'user_id',
          									'value' => $user_id,
            							);
            							echo form_input($data_usr4);
          						  ?>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_commission"><?=$this->lang->line('xin_employee_set_oth_commission');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_commission" type="number" min="0" value="<?=$salary_commission;?>" id="salary_commission">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_claims"><?=$this->lang->line('xin_employee_set_oth_claims');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_claims" type="number" min="0" value="<?=$salary_claims;?>" id="salary_claims">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_paid_leave"><?=$this->lang->line('xin_employee_set_oth_paid_leave');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_paid_leave" type="number" min="0" value="<?=$salary_paid_leave;?>" id="salary_paid_leave">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_director_fees"><?=$this->lang->line('xin_employee_set_oth_director_fees');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_director_fees" type="number" min="0" value="<?=$salary_director_fees;?>" id="salary_director_fees">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="salary_advance_paid"><?=$this->lang->line('xin_employee_set_oth_ad_paid');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_amount');?>" name="salary_advance_paid" type="number" min="0" value="<?=$salary_advance_paid;?>" id="salary_advance_paid">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                    </div>
                    <div class="tab-pane <?=$get_animate;?> salary-current-tab" id="overtime">
                      <div class="box-header with-border">
                        <h3 class="box-title"> <?=$this->lang->line('dashboard_overtime');?> </h3>
                      </div>
                      <div class="box-body pb-2">
                        <?php $attributes = array('name' => 'overtime_info', 'id' => 'overtime_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                        <?=form_open('admin/employees/set_overtime', $attributes, $hidden);?>
                        <?php
            						  $data_usr4 = array(
            								'type'  => 'hidden',
            								'name'  => 'user_id',
            								'value' => $user_id,
            						  );
            						  echo form_input($data_usr4);
            					  ?>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="overtime_type"><?=$this->lang->line('xin_employee_overtime_title');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_overtime_title');?>" name="overtime_type" type="text" value="" id="overtime_type">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="no_of_days"><?=$this->lang->line('xin_employee_overtime_no_of_days');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_overtime_no_of_days');?>" name="no_of_days" type="number" min="0" value="" id="no_of_days">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="overtime_hours"><?=$this->lang->line('xin_employee_overtime_hour');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_overtime_hour');?>" name="overtime_hours" type="number" min="0" value="" id="overtime_hours">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="overtime_rate"><?=$this->lang->line('xin_employee_overtime_rate');?></label>
                              <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_overtime_rate');?>" name="overtime_rate" type="number" min="0" value="" id="overtime_rate">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                        <?=form_close(); ?> </div>
                      <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('dashboard_overtime');?> </h3>
                        </div>
                        <div class="box-body">
                          <div class="box-datatable table-responsive">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_emp_overtime" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?=$this->lang->line('xin_action');?></th>
                                  <th><?=$this->lang->line('xin_employee_overtime_title');?></th>
                                  <th><?=$this->lang->line('xin_employee_overtime_no_of_days');?></th>
                                  <th><?=$this->lang->line('xin_employee_overtime_hour');?></th>
                                  <th><?=$this->lang->line('xin_employee_overtime_rate');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?#luffy bazi modal - 6 Des 2019 - 06:47 pm?>
<div class="modal fade" id="modalBazi" role="dialog" aria-labelledby="BaziFileLabel" aria-hidden="true">
  <div class="modal-dialog luffy-modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Bazi</h4>
      </div>
      <div class="modal-body">
        <div class="iframe-container"><iframe src="<?=site_url();?>uploads/profile/bazi/<?=$baziFile;?>"></iframe></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="<?=site_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  $(".view-bazi").on("click", function(){
    $('#modalBazi').modal('toggle');
  });
</script>
<!-- luffy end -->
