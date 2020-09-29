<?php defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['appraisal_id']) && $_GET['data']=='view_appraisal_report' && $_GET['type']=='view_appraisal_report'){?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Appraisal Result</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Grade</label><br />
        <?php echo $grade;?>
      </div>
      <div class="form-group">
        <label>Total Rewards Point</label><br />
        <?php echo $totalRewardsPoint;?>
      </div>
      <div class="form-group">
        <label>Total Rewards Amount</label><br />
        <?php echo $totalRewardsAmount;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Total Bonus</label><br />
        <?php echo $bonus;?>
      </div>
      <div class="form-group">
        <label>Total Punishment Point</label><br />
        <?php echo $totalPunishmentPoint;?>
      </div>
      <div class="form-group">
        <label>Total Punishment Amount</label><br />
        <?php echo $totalPunishmentAmount;?>
      </div>
    </div>
    <div class="col-md-12"><hr style="border:1px solid #f4f4f4;" /></div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Employee</label><br />
        <?php echo $employee;?>
      </div>
      <div class="form-group">
        <label>Sub Department</label><br />
        <?php echo $subDepartment;?>
      </div>
      <div class="form-group">
        <label>Total Points Reached</label><br />
        Get <?php echo $finalPoint;?> points from: <?php echo $taskName;?>
      </div>
      <div class="form-group">
        <label>Period</label><br />
        <?php echo $period;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Appraisal Status</label><br />
        <?php echo $appraisalStatusName;?>
      </div>
      <div class="form-group">
        <label>Reviewer</label><br />
        <?php echo $reviewer;?>
      </div>
      <div class="form-group">
        <label>Approval</label><br />
        <?php echo $approvalName;?>
      </div>
      <div class="form-group">
        <label>Approval By</label><br />
        <?php echo $approvedBy;?>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php }?>
