<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['attendance_id']) && $_GET['data']=='view_timesheet_approval' && $_GET['type']=='view_timesheet_approval'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Attendance Approval</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="employee">Proposed By</label><br />
        <?=$employee;?>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="date">Attendance date</label><br />
            <?=$date;?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?php if($clockStatus==0) :?>
            <label for="clock_in">Clock-in</label><br />
            <?=$clockIn;?>
            <?php else:?>
            <label for="clock_out">Clock-out</label><br />
            <?=$clockOut;?>
            <?php endif;?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="reason">Reason</label><br />
        <?=$reason;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="approval">Approval</label><br />
        <?php if($approvalStatus==0):?> <?=$this->lang->line('xin_pending');?> <?php endif; ?>
        <?php if($approvalStatus==1):?> <?=$this->lang->line('xin_accepted');?> <?php endif; ?>
        <?php if($approvalStatus==2):?> <?=$this->lang->line('xin_rejected');?> <?php endif; ?>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="approved_by">Approval by</label><br />
            <?=$approver;?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="approved_on">Approved on</label><br />
            <?=$approvedAt;?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="note">Note from HRD</label><br />
        <?=$noteByApprover;?>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
</div>
<?php };?>
