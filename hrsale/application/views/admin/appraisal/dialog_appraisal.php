<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['appraisal_id']) && $_GET['data']=='appraisal_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Appraisal</h4>
</div>
<?php $attributes = array('name' => 'edit_appraisal', 'id' => 'edit_appraisal', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $appraisal_id, 'ext_name' => $appraisal_id);?>
<?php echo form_open('admin/appraisal/update/'.$appraisal_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Appraisal Status</label><br />
                  <?php if($appraisalStatus==4): //delayed?>
                    <?php echo $appraisalStatusName;?> (<?php echo $delayedDays;?> days)
                  <?php elseif($appraisalStatus==5): //overdue?>
                    <span style='color:#ff0000;'><?php echo $appraisalStatusName;?> (<?php echo $overDueDays;?> days)</span>
                  <?php else:?>
                    <?php echo $appraisalStatusName;?>
                  <?php endif;?>
                </div>
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
                  <select class="form-control aj_subdept" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="Choose sub department" required disabled>
                    <?php foreach($allSubDept as $singSubdept) {?>
                    <option value="<?php echo $singSubdept->sub_department_id;?>" <?php if($subDeptIdAppraisal==$singSubdept->sub_department_id):?> selected="selected" <?php endif;?>><?php echo $singSubdept->department_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group jobtask_ajax">
                  <label for="name">Job Task</label>
                  <select name="jobtask" class="form-control" data-plugin="select_hrm" data-placeholder="Choose job task" disabled>
                    <?php foreach($allJobtask as $singJobtask) {?>
                    <option value="<?php echo $singJobtask->id;?>" <?php if($jobId==$singJobtask->id):?> selected="selected" <?php endif;?>><?php echo $singJobtask->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group employee_ajax">
                  <label for="employee_id">Employee</label>
                  <select name="employee" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" disabled>
                    <?php foreach($allEmployees as $singEmployee) {?>
                    <option value="<?php echo $singEmployee->user_id;?>" <?php if($employeeId==$singEmployee->user_id):?> selected="selected" <?php endif;?>><?php echo $singEmployee->first_name." ".$singEmployee->last_name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date">Start Date</label>
                      <input class="form-control appraisal_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="due_date">Due Date</label>
                      <input class="form-control appraisal_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="due_date" type="text" value="<?php echo date('Y-m-d', strtotime('today + 30 days'));?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="note">Note</label>
                  <textarea class="form-control note" placeholder="Note" name="note" rows="15"><?php echo $note;?></textarea>
                </div>
                <div class="form-group">
                  <label for="name">Approval Status</label>
                  <select name="approvalStatus" class="form-control" data-plugin="select_hrm" data-placeholder="Select approval status">
                    <?php foreach($allApprovalStatus->result() as $singStatus) {?>
                    <option value="<?php echo $singStatus->id?>" <?php if($approvalStatus==$singStatus->id):?> selected="selected" <?php endif;?>><?php echo $singStatus->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type='text/javascript'>
$(document).ready(function(){
  $('.note').trumbowyg();
  jQuery(".aj_subdept").change(function(){
		jQuery.get(base_url+"/get_jobtask/"+jQuery(this).val(), function(data, status){
			jQuery('.jobtask_ajax').html(data);
		});
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('.employee_ajax').html(data);
		});
	});
  /* Update data */
	$("#edit_appraisal").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=appraisal_update&form="+action,
			cache: false,
			success: function (JSON,data) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : base_url+"/appraisal_list",
						type : 'GET'
					},
					// dom: 'lBfrtip',
					// "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
					"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();
					}
					});
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
          // console.log(e.target);return false;
          // console.log(obj.serialize());return false;
				}
			},
			error: function(xhr, textStatus, error) {
					// console.log('Error Berat: ' + xhr.responseText);  // luffy
					// console.log('Error Berat: ' + xhr.statusText); // luffy
					// console.log('Error Berat: ' + textStatus); // luffy
					// console.log('Error Berat: ' + error); // luffy
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', true);
					xin_table.api().ajax.reload(function(){
						toastr.error("Error. Please contact dev team.");
					}, true);
					setTimeout(function(){
						location.reload();
					}, 1500);
			},
		});
	}); // end update
})
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['appraisal_id']) && $_GET['data']=='view_appraisal_task' && $_GET['type']=='view_appraisal_task'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Appraisal</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Period</label><br />
        <?php echo $period;?>
      </div>
      <div class="form-group">
        <label>Employee</label><br />
        <?php echo $employee;?>
      </div>
      <div class="form-group">
        <label>Sub Department</label><br />
        <?php echo $subDepartment;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Reviewer</label><br />
        <?php echo $reviewer;?>
      </div>
      <div class="form-group">
        <label>Grade (for current appraisal)</label><br />
        <?php echo empty($grade)?'-':$grade;?>
      </div>
      <div class="form-group">
        <label>Bonus (for current appraisal)</label><br />
        <?php echo $bonus;?>
      </div>
    </div>
  </div>
  <hr />
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Job Task</label><br />
        <?php echo $jobTaskName;?>
      </div>
      <div class="form-group">
        <label>Appraisal Status</label><br />
        <?php if($appraisalStatus==4):?>
          <?php echo $appraisalStatusName;?> (<?php echo $delayedDays;?> days)
        <?php elseif($appraisalStatus==5):?>
          <span style='color:#ff0000;'><?php echo $appraisalStatusName;?> (<?php echo $overDueDays;?> days)</span>
        <?php else:?>
          <?php echo $appraisalStatusName;?>
        <?php endif;?>
      </div>
      <div class="form-group">
        <label>Note</label><br />
        <?php echo empty($note)?'-':str_replace('\"',"",html_entity_decode(strip_tags($note)));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Progress to reach grade B</label><br />
          <div class="progress blue" style="margin: 25px 20px;">
            <div class="progress-bar" style="width:<?php echo $progressPercentageB;?>%; background:#3485ef;">
              <div class="progress-value"><?php echo $progressPercentageB;?>%</div>
            </div>
          </div>
      </div>
      <div class="form-group">
        <label>Progress to reach grade A</label><br />
          <div class="progress pink" style="margin: 25px 20px;">
            <div class="progress-bar" style="width:<?php echo $progressPercentageA;?>%; background:#ff4b7d;">
              <div class="progress-value"><?php echo $progressPercentageA;?>%</div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php }
?>
<style type='text/css'>
.progress-title{
    font-size: 16px;
    font-weight: 700;
    color: #011627;
    margin: 0 0 20px;
}
.progress{
    height: 10px;
    background: #cbcbcb;
    border-radius: 0;
    box-shadow: none;
    margin-bottom: 30px;
    overflow: visible;
}
.progress .progress-bar{
    box-shadow: none;
    position: relative;
    -webkit-animation: animate-positive 2s;
    animation: animate-positive 2s;
}
.progress .progress-bar:after{
    content: "";
    display: block;
    border: 15px solid transparent;
    border-bottom: 21px solid transparent;
    position: absolute;
    top: -26px;
    right: -12px;
}
.progress .progress-value{
    font-size: 13px;
    font-weight: bold;
    color: #000;
    position: absolute;
    top: -30px;
    right: 0;
}
.progress.pink .progress-bar:after{
    border-bottom-color: #ff4b7d;
}
.progress.green .progress-bar:after{
    border-bottom-color: #5fad56;
}
.progress.yellow .progress-bar:after{
    border-bottom-color: #e8d324;
}
.progress.blue .progress-bar:after{
    border-bottom-color: #3485ef;
}
@-webkit-keyframes animate-positive{
    0% { width: 0; }
}
@keyframes animate-positive{
    0% { width: 0; }
}

</style>
