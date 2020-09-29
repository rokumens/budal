<?php
/* Leave Detail view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
$sessionUserId = $session['user_id']; // user id from session // $session['user_id']; || 56 = helen || 73 = caroline
?>
<div class="row m-b-1">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
          <?php if($sessionUserId == $approval_1 || $sessionUserId == $approval_2): ?>
            <div class="box-header with-border">
              <h3 class="box-title"> <?= $this->lang->line('xin_leave_detail');?> </h3>
            </div>
            <div class="box-body">
              <div class="table-responsive" data-pattern="priority-columns">
                <table class="table table-striped m-md-b-0">
                  <tbody>
                    <tr>
                      <th scope="row" style="border-top:0px;">Status Approval</th>
                      <td class="text-right"><?=$statusName;?></td>
                    </tr>
                    <tr>
                      <th scope="row" style="border-top:0px;"><?= $this->lang->line('xin_employee');?></th>
                      <td class="text-right"><?= $full_name;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?= $this->lang->line('xin_leave_type');?></th>
                      <td class="text-right"><?= $type;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?= $this->lang->line('xin_applied_on');?></th>
                      <td class="text-right"><?= $this->Xin_model->set_date_format($created_at);?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?= $this->lang->line('xin_start_date');?></th>
                      <td class="text-right"><?= $this->Xin_model->set_date_format($from_date);?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?= $this->lang->line('xin_end_date');?></th>
                      <td class="text-right"><?= $this->Xin_model->set_date_format($to_date);?></td>
                    </tr>
                  </tbody>
                </table>
                <div class="bs-callout-success callout-border-left callout-square callout-transparent mt-1 p-1"> <?= $reason;?> </div>
              </div>
            </div>
          <?php else: ?>
            <div class="box-header with-border">
              <h3 class="box-title"> <?= $this->lang->line('xin_leave_detail');?> </h3>
            </div>
            <div class="box-body">
              <div class="table-responsive" data-pattern="priority-columns">
                <table class="table table-striped m-md-b-0">
                  <tbody>
                    <tr>
                      <th>Status</th>
                      <td><?=$statusName;?></td>
                    </tr>
                    <?php if($status != 0): ?>
                    <tr>
                      <th>Approval By</th>
                      <td><?=$approvalName_1->employee_id.' - '.$approvalName_1->username.' & '.$approvalName_2->employee_id.' - '.$approvalName_2->username;?></td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php endif; ?>
            <div class="box-header with-border">
              <h3 class="box-title"> <?= $this->lang->line('xin_leave_statistics');?> </h3>
            </div>
            <div class="box-body">
              <div class="box-block card-dashboard">
                <?php foreach($all_leave_types as $type) {?>
                <?php $count_l = $this->Timesheet_model->count_total_leaves($type->leave_type_id,$employee_id);?>
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
                <div id="leave-statistics">
                  <p><strong><?= $type->type_name;?> (<?= $count_l;?>/<?= $type->days_per_year;?>)</strong></p>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar" style="width: <?= $count_data;?>%;"></div>
                  </div>
                  <!--<progress class="progress <?= $progress_class;?>" value="<?= $count_data;?>" max="100"></progress>-->
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-8">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <?php if($sessionUserId == $approval_1 || $sessionUserId == $approval_2): ?>
              <div class="box-header with-border">
                <h3 class="box-title"> Approval Action </h3>
              </div>
              <div class="box-body">
                <?php $attributes = array('name' => 'edit_approval', 'id' => 'edit_approval', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
                <?php $hidden = array('_method' => 'EDIT', '_token' => $leave_id, 'ext_name' => $leave_id, 'leave_id' =>$leave_id);?>
                <?php echo form_open('admin/timesheet/edit_leave/'.$leave_id, $attributes, $hidden);?>
                  <!-- if user id == approval 1 -->
                  <?php if($sessionUserId == $approval_1): ?>
                  <div class="form-group">
                    <?=form_dropdown('approval_action', $dropdown_approval, $approval_action_by_1, 'class="" data-plugin="select_hrm"');?>
                  </div>
                  <!-- if user id == approval 2 -->
                  <?php elseif($sessionUserId == $approval_2): ?> 
                  <div class="form-group">
                    <?=form_dropdown('approval_action', $dropdown_approval, $approval_action_by_2, 'class="" data-plugin="select_hrm"');?>
                  </div>
                  <?php endif; ?>
                  <button type="submit" class="btn btn-primary save pull-right"> <i class="fa fa-check-square-o"></i> <?= $this->lang->line('xin_save');?> </button>
                <?=form_close();?>
              </div>
            <?php else: ?>
              
              <div class="box-header with-border">
                <h3 class="box-title"> <?= $this->lang->line('xin_edit_leave');?> </h3>
              </div>
              <?php $user = $this->Xin_model->read_employee_info($session['user_id']);?>
              <?php $leave_categories = $user[0]->leave_categories;?>
              <?php $leaave_cat = get_employee_leave_category($leave_categories,$session['user_id']);?>
              <?php $attributes = array('name' => 'edit_leave', 'id' => 'edit_leave', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
              <?php $hidden = array('_method' => 'EDIT', '_token' => $leave_id, 'ext_name' => $leave_id, 'status'=>$status);?>
              <?php echo form_open('admin/timesheet/edit_leave/'.$leave_id, $attributes, $hidden);?>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="leave_type" class="control-label"><?= $this->lang->line('xin_leave_type');?></label>
                      <select class="form-control" name="leave_type" data-plugin="select_hrm" data-placeholder="<?= $this->lang->line('xin_leave_type');?>">
                        <option value=""></option>
                        <?php foreach($leaave_cat as $type) {?>
                        <option value="<?= $type->leave_type_id?>" <?php if($type->leave_type_id==$leave_type_id):?> selected <?php endif;?>> <?= $type->type_name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="start_date"><?= $this->lang->line('xin_start_date');?></label>
                          <input class="form-control e_date" placeholder="<?= $this->lang->line('xin_start_date');?>" readonly="true" name="start_date" type="text" value="<?= $from_date;?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="end_date"><?= $this->lang->line('xin_end_date');?></label>
                          <input class="form-control e_date" placeholder="<?= $this->lang->line('xin_end_date');?>" readonly="true" name="end_date" type="text" value="<?= $to_date;?>">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="employee_id" id="employee_id" value="<?= $session['user_id'];?>" />
                    <input type="hidden" name="company_id" id="company_id" value="<?= $user[0]->company_id;?>" />
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="description"><?= $this->lang->line('xin_remarks');?></label>
                      <textarea class="form-control textarea" placeholder="<?= $this->lang->line('xin_remarks');?>" name="remarks" rows="5"><?= $remarks;?></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="reason"><?= $this->lang->line('xin_leave_reason');?></label>
                  <textarea class="form-control" placeholder="<?= $this->lang->line('xin_leave_reason');?>" name="reason" cols="30" rows="3" id="reason"><?= $reason;?></textarea>
                </div>
              </div>
              <div class="box-footer">
              <?php if($status == 0): ?>
                <button type="submit" class="btn btn-primary pull-right"><?php echo $this->lang->line('xin_update');?></button>
              <?php else: ?>
                <span class="pull-right">This leave already has been <?=strtolower($statusName);?></span>
              <?php endif; ?>
              </div>
              <?=form_close();?>
              
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<?php //if($user[0]->user_role_id == 1) {?>
<!-- <div class="col-md-4">
  <section id="decimal">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
              <h3 class="box-title"> <?= $this->lang->line('xin_update_status');?> </h3>
            </div>
          <div class="box-body">
                <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
              <?php $hidden = array('user_id' => $session['user_id'], '_token_status' => $leave_id);?>
                <?= form_open('admin/timesheet/update_leave_status/'.$leave_id, $attributes, $hidden);?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="status"><?= $this->lang->line('dashboard_xin_status');?></label>
                      <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= $this->lang->line('dashboard_xin_status');?>">
                        <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?= $this->lang->line('xin_pending');?></option>
                        <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?= $this->lang->line('xin_approved');?></option>
                        <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?= $this->lang->line('xin_rejected');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="remarks"><?= $this->lang->line('xin_remarks');?></label>
                      <textarea class="form-control textarea" placeholder="<?= $this->lang->line('xin_remarks');?>" name="remarks" id="remarks" cols="30" rows="5"><?= $remarks;?></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary save"> <i class="fa fa-check-square-o"></i> <?= $this->lang->line('xin_save');?> </button>
                </div>
              <?= form_close(); ?>
            </div>
          </div>
      </div>
    </div>
  </section>
</div> -->
<?php //} ?>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>