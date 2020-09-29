<!-- Start 7381-Jazz 29Jan2020 : 17:52 -->
<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($sessionUserId);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $session=$this->session->userdata('username');?>
<?php $get_animate=$this->Xin_model->get_content_animate();?>
<!-- 7381 - Jazz 31-01-2020 12:23 -->
<!-- Form edit note -->


<div class="row m-b-1 <?=$get_animate;?>">
  <?php $attributes = array('name' => 'update_dayoff', 'id' => 'update_dayoff', 'autocomplete' => 'off');?>
  <?php $hidden = array('user_id' => $sessionUserId,'periodParam' => $period); #luffy 8 feb 2020 08:51 pm | add period?>
  <?php echo form_open('admin/dayoff/update_dayoff', $attributes, $hidden);?>
  <?php
  $data = array(
    'name'        => 'period',
    'id'          => 'period',
    'type'        => 'hidden',
    'value'   	   => $this->uri->segment(4),
    'class'       => 'form-control',
  );
  echo form_input($data);
  ?>
  <div class="col-md-4">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> Approval </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <div class="datatables-demo table table-striped" data-pattern="priority-columns">
                <table class="table table-striped m-md-b-0">
                  <tbody>
                    <tr>
                      <th scope="row">Prepared by</th>
                      <td class="text-right"><?=$prepare_by->employee_id.' '.$prepare_by->username;?></td>
                    </tr>
                    <tr>
                      <th scope="row">Prepared date</th>
                      <td class="text-right"><?=date('d F Y', strtotime($approval_status->created_at));?></td>
                    </tr>
                    <tr>
                      <th scope="row">Period</th>
                      <td class="text-right"><?=date('d F Y', strtotime($approval_status->dayoff_start_day)).' - '.date('d F Y', strtotime($approval_status->dayoff_end_day));?></td>
                    </tr>
                    <tr>
                      <th style="vertical-align : top !important" scope="row">Approval by</th>
                      <td>
                        <ul class="pull-right">
                          <li><?=$approval_1->employee_id.' - '.$approval_1->username;?></li>
                          <li><?=$approval_2->employee_id.' - '.$approval_2->username;?></li>
                          <li><?=$approval_3->employee_id.' - '.$approval_3->username;?></li>
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> Note </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <div class="datatables-demo table" data-pattern="priority-columns">
                <table class="table m-md-b-0">
                  <tbody>
                    <tr>
                      <?php if($sessionUserId !=  $approval_user_1 && $sessionUserId !=  $approval_user_2 && $sessionUserId !=  $approval_user_3): ?>
                      <td>
                        <div class="form-group jobtask_ajax">
                          <div class="form-group">
                            <label for="approval_by_1">Approval 1 By</label>
                            <?=form_dropdown('approval_by_1', $allApprover, $approval_user_1, 'class="form-control" data-plugin="select_hrm" data-placeholder="Choose who will approve this dayoff."');?>
                          </div>
                        </div>
                      </td>
                      <?php endif; ?>
                      <td>
                        <div class="form-group">
                          <label for="status">Status</label>
                          <?php if($sessionUserId == $approval_user_1 || $sessionUserId == $approval_user_2 || $sessionUserId == $approval_user_3): ?>
                            <?=form_dropdown('approval_status', $status_dropdown, $selectedApproval, 'id="approval" class="form-control" data-plugin="select_hrm" data-placeholder="'.$this->lang->line("dashboard_xin_status").'"');?>
                          <?php else: ?>
                          <?php
                            $status = '';
                            if($approval_status->approval_status == 0){
                              $status = $this->lang->line('xin_pending');
                            }elseif($approval_status->approval_status == 1){
                              $status = $this->lang->line('xin_accepted');
                            }elseif($approval_status->approval_status == 2){
                              $status = $this->lang->line('xin_rejected');
                            }
                          ?>
                          <input type="text" class="form-control" style="border:none;" value="<?=$status;?>" readonly>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <?php if($sessionUserId !=  $approval_user_1 && $sessionUserId !=  $approval_user_2 && $sessionUserId !=  $approval_user_3): ?>
                      <td style="vertical-align : top !important;">
                        <div class="form-group jobtask_ajax">
                          <div class="form-group">
                            <label for="approval_by_2">Approval 2 By</label>
                            <?=form_dropdown('approval_by_2', $allApprover, $approval_user_2, 'class="form-control" data-plugin="select_hrm" data-placeholder="Choose who will approve this dayoff."');?>
                          </div>
                        </div>
                        <div class="form-group jobtask_ajax">
                          <div class="form-group">
                            <label for="approval_by_3">Approval 3 By</label>
                            <?=form_dropdown('approval_by_3', $allApprover, $approval_user_3, 'class="form-control" data-plugin="select_hrm" data-placeholder="Choose who will approve this dayoff."');?>
                          </div>
                        </div>
                      </td>
                      <?php endif; ?>
                      <td>
                        <div class="form-group">
                          <label for="note">Note</label>
                          <textarea class="form-control" name="note" id="note" cols="50" rows="5"><?=$note;?></textarea>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-check-square-o"></i> Update </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?=form_close(); ?>
  <div class="col-md-12">
    <div class="box">
        <div class="box-body">
          <input type="hidden" name="name" value="" class="currentSubDept" readonly>
          <div id='dayoff_list'></div>
        </div>
      </div>
  </div>
</div>