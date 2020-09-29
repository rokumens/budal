<?php
/*
* Timesheet Approval Detail view
*/
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row m-b-1 <?=$get_animate;?>">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Attendance Request Detail. </h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <div class="datatables-demo table table-striped table-bordered" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row">Date</th>
                        <td class="text-right"><?=$date;?></td>
                      </tr>
                      <tr>
                        <?php if($clockStatus==0) :?>
                        <?php $clockLabel='Clock In';?>
                        <?php $clockTime=$clockIn;?>
                        <?php else:?>
                        <?php $clockLabel='Clock Out';?>
                        <?php $clockTime=$clockOut;?>
                        <?php endif;?>
                        <th scope="row"><?=$clockLabel;?></th>
                        <td class="text-right"><?=$clockTime;?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="datatables-demo table table-striped" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row" width='30%'>Proposed by</th>
                        <td class="text-right"><?=$submittedBy;?></td>
                      </tr>
                      <tr>
                        <th scope="row">Reason</th>
                        <td class="text-right"><?=$reason;?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-8 <?=$get_animate;?>">
    <div class="col-xl-12 col-lg-12">
      <div class="box">
        <div class="box-block">
          <?php if(($currentEmailLoggedIn==='9302@asiapowergames.com')||($currentEmailLoggedIn==='2002@asiapowergames.com')||($currentEmailLoggedIn==='7380@asiapowergames.com')):?>
          <ul class="nav nav-tabs nav-top-border no-hover-bg">
            <li class="nav-item active"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-comment"></i> Submit Approval</a> </li>
          </ul>
          <!-- tab -->
          <div class="tab-content pt-1">
            <div role="tabpanel" class="tab-pane active <?=$get_animate;?>" id="tabIcon11" aria-expanded="true" aria-labelledby="baseIcon-tab11">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <?php $attributes2 = array('name' => 'update_approval', 'id' => 'update_approval', 'autocomplete' => 'off');?>
                    <?php $hidden2 = array('user_id' => $session['user_id']);?>
                    <?=form_open('admin/timesheet/update_approval_detail/'.$attendanceId, $attributes2, $hidden2);?>
                    <?php
            					$dataApproval = array(
            					  'name'        => 'attendance_id',
            					  'id'          => 'attendance_id',
            					  'type'        => 'hidden',
            					  'value'   	   => $attendanceId,
            					  'class'       => 'form-control',
            					);
            					echo form_input($dataApproval);
          					?>
                    <div class="row">
                      <?php if($approvalStatus!=0):?>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="status">Approval</label>
                          <select name="approval" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_xin_status');?>">
                            <option value="0" <?php if($approvalStatus==0):?> selected <?php endif; ?>><?=$this->lang->line('xin_pending');?></option>
                            <option value="1" <?php if($approvalStatus==1):?> selected <?php endif; ?>><?=$this->lang->line('xin_accepted');?></option>
                            <option value="2" <?php if($approvalStatus==2):?> selected <?php endif; ?>><?=$this->lang->line('xin_rejected');?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="approvedBy" style='padding-left:12px;'>By</label>
                          <input type='text' class='form-control' value='<?=$approvedBy;?>' name='noname' readonly style='background:none;border:none;'>
                        </div>
                      </div>
                      <?php else:?>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status">Approval</label>
                          <select name="approval" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_xin_status');?>">
                            <option value="0" <?php if($approvalStatus==0):?> selected <?php endif; ?>><?=$this->lang->line('xin_pending');?></option>
                            <option value="1" <?php if($approvalStatus==1):?> selected <?php endif; ?>><?=$this->lang->line('xin_accepted');?></option>
                            <option value="2" <?php if($approvalStatus==2):?> selected <?php endif; ?>><?=$this->lang->line('xin_rejected');?></option>
                          </select>
                        </div>
                      </div>
                      <?php endif?>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="note">Note for Employee</label>
                          <textarea class="form-control note" name="noteByApprover" placeholder="Provide a note here for this employee (if any)."rows="5"><?=$noteByApprover;?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions box-footer">
                      <?php //hidden field data for sending notif to slack?>
                      <input type='hidden' value='<?=$employee;?>' name='paramEmployee' readonly style='background:none;border:none;'>
                      <input type='hidden' value='<?=str_replace('-',' ',$date);?>' name='paramDate' readonly style='background:none;border:none;'>
                      <input type='hidden' value='<?=str_replace(':00','',$clockTime);?>' name='param<?=str_replace(' ','',$clockLabel);?>' readonly style='background:none;border:none;'>
                      <input type='hidden' value='<?=$submittedBy;?>' name='paramProposedBy' readonly style='background:none;border:none;'>
                      <?php //hidden field data for sending notif to slack?>
                      <a href=<?=base_url()."admin/timesheet/attendance_approval";?> type="button" style="margin-right:10px;" class="btn btn-md btn-secondary"> <i class="fa fa-hand-o-left custom"></i> Cancel </a>
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
                    </div>
                    <?=form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
            <?php else:?>
            <ul class="nav nav-tabs nav-top-border no-hover-bg">
              <li class="nav-item active"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-comment"></i> Approval Detail</a> </li>
            </ul>
            <!-- tab -->
            <div class="tab-content pt-1">
              <div role="tabpanel" class="tab-pane active <?=$get_animate;?>" id="tabIcon11" aria-expanded="true" aria-labelledby="baseIcon-tab11">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="status">Status</label><br />
                            <?php
                            if($approvalStatus==0){echo $this->lang->line('xin_pending');
                            }elseif($approvalStatus==1){echo $this->lang->line('xin_accepted').' by '.$approvedBy;
                            }else{echo $this->lang->line('xin_rejected').' by '.$approvedBy;}
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="status">Note from HRD</label>
                            <br /><?=$noteByApprover;?>
                          </div>
                        </div>
                      </div>
                      <div class="form-actions box-footer">
                        <a href=<?=base_url()."admin/timesheet/attendance_approval";?> type="button" style="float:right" class="btn btn-md btn-secondary"> <i class="fa fa-hand-o-left custom"></i> Back </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif;?>
            <!-- tab -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
