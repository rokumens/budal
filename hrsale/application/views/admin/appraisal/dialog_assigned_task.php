<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['appraisal_id']) && $_GET['data']=='assign_task_update'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Assigned Main Task</h4>
</div>
<?php $attributes = array('name' => 'edit_assign_task', 'id' => 'edit_assign_task', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $appraisal_id, 'ext_name' => $appraisal_id);?>
<?=form_open('admin/appraisal_assign_task/update/'.$appraisal_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Employee Progress Status</label><br />
                  <?php if($appraisalStatus==4): //delayed?>
                    <?=$appraisalStatusName;?> (<?=$delayedDays;?> days)
                  <?php elseif($appraisalStatus==5): //overdue?>
                    <span style='color:#c18c11;'><?=$appraisalStatusName;?> (<?=$overDueDays;?> days)</span>
                  <?php else:?>
                    <?=$appraisalStatusName;?>
                  <?php endif;?>
                </div>
                <!-- <div class="form-group">
                  <label for="name">
                    Approval
                    <?php #&nbsp;<small>(used for counting total bonus & appraisal report)</small>?>
                  </label>
                  <select name="approvalStatus" class="form-control" data-plugin="select_hrm" data-placeholder="Select approval status">
                    <?php foreach($allApprovalStatus->result() as $singStatus) {?>
                    <option value="<?=$singStatus->id?>" <?php if($approvalStatus==$singStatus->id):?> selected="selected" <?php endif;?>><?=$singStatus->name?></option>
                    <?php } ?>
                  </select>
                </div> -->
                <div class="form-group employee_ajax">
                  <label for="employee_id">Employee</label>
                  <select name="employee" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>" disabled>
                    <?php foreach($allEmployees as $singEmployee) {?>
                    <option value="<?=$singEmployee->user_id;?>" <?php if($employeeId==$singEmployee->user_id):?> selected="selected" <?php endif;?>><?=$singEmployee->first_name." ".$singEmployee->last_name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="name"><?=$this->lang->line('xin_hr_sub_department');?></label>
                  <select class="form-control aj_subdept" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="Choose sub department" required disabled>
                    <?php foreach($allSubDept as $singSubdept) {?>
                    <option value="<?=$singSubdept->sub_department_id;?>" <?php if($subDeptIdAppraisal==$singSubdept->sub_department_id):?> selected="selected" <?php endif;?>><?=$singSubdept->department_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group jobtask_ajax">
                  <label for="jobtask">Main Task</label>
                  <select name="jobtask" class="form-control" data-plugin="select_hrm" data-placeholder="Choose main task" disabled>
                    <?php foreach($allJobtask as $singJobtask) {?>
                    <option value="<?=$singJobtask->id;?>" <?php if($jobId==$singJobtask->id):?> selected="selected" <?php endif;?>><?=$singJobtask->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date">Start Date</label>
                      <input class="form-control appraisal_date" placeholder="<?=$this->lang->line('xin_select_date');?>" readonly name="start_date" type="text" value="<?=date('Y-m-d',strtotime($startDate,time()));?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="due_date">Due Date</label>
                      <input class="form-control appraisal_date" placeholder="<?=$this->lang->line('xin_select_date');?>" readonly name="due_date" type="text" value="<?=date('Y-m-d', strtotime('last day of this month'));?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="note">Note</label>
                  <textarea class="form-control note" placeholder="Note" name="note" rows="16"><?=$note;?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
  </div>
<?=form_close(); ?>
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
  /* Update */
	$("#edit_assign_task").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=assign_task_update&form="+action,
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
						url : base_url+"/assign_task",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['appraisal_id']) && $_GET['data']=='view_assigned_task' && $_GET['type']=='view_assigned_task'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Assigned Main Task: Period <?=$period;?></h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label>
          <?php $delayedOverdue='';
            if($appraisalStatus==4){//delayed
              $colorBar='yellow';$colorStatus='#da2c5c;';
            }elseif($appraisalStatus==5){//overdue
              $colorBar='pink';$colorStatus='#c18c11';
            }elseif($appraisalStatus==3){//completed
              $colorBar='green';$colorStatus='#2c7923';
            }elseif($appraisalStatus==2){//in progress
              $colorBar='blue';$colorStatus='#054ead;';
            }elseif($appraisalStatus==1){//pending
              $colorBar='red';$colorStatus='#f50404';
            };?>
          Employee Progress Status: <span style='color:<?=$colorStatus;?>'><?=$appraisalStatusName.' '.$delayedOverdue;?></span>
        </label>
        <?php #if($taskProgress>=97/*reached Grade A+*/){$colorBar='green';}elseif(($taskProgress>0)&&($taskProgress<97)){$colorBar='blue';}else{$colorBar='pink';}?>
        <div class="progress <?=$colorBar?>" style="margin:15px 20px 30px 0;">
          <div class="progress-bar <?=$colorBar?>" style="width:<?=$taskProgress;?>%;">
            <div class="progress-value"><?=$taskProgress;?>%</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Main Task</label><br />
        <?=$jobTaskName." <small>(for: ".$shiftName.")</small>";?>
      </div>
      <div class="form-group">
        <label>Employee</label><br />
        <?=$employee;?>
      </div>
      <div class="form-group">
        <label>Sub Department</label><br />
        <?=$subDepartment;?>
      </div>
      <div class="form-group">
        <label>Note</label><br />
        <?=empty($note)?'-':str_replace('\"',"",html_entity_decode(strip_tags($note)));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Actual Reached Grade</label><br />
            <?=empty($actualGrade)?'-':$actualGrade;?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Targeted Grade</label><br />
            <?=empty($grade)?'-':$grade;?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Points Reached</label><br />
            <?=$finalPoint;?>
          </div>
        </div>
        <div class="col-md-6">
          <?php if($bonus):?>
          <div class="form-group">
            <label>Bonus Staff Amount</label><br />
            <?=$bonus;?>
          </div>
          <?php endif;?>
        </div>
      </div>
      <div class="form-group">
        <label>Assigned by</label><br />
        <?=$reviewer;?>
      </div>
      <!-- <div class="form-group">
        <label>Approval Status</label><br />
        <?=$approvalName;?>
      </div> -->
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
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
    font-size: 12px;
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
    border-bottom-color: #eaab1b;
}
.progress.red .progress-bar:after{
    border-bottom-color: #ff6262;
}
.progress.blue .progress-bar:after{
    border-bottom-color: #3485ef;
}
.progress-bar.pink{
    background:#ff4b7d;
}
.progress-bar.green{
    background:#5fad56;
}
.progress-bar.yellow{
    background:#eaab1b;
}
.progress-bar.blue{
    background:#3485ef;
}
.progress-bar.red{
    background:#ff6262;
}

@-webkit-keyframes animate-positive{
    0% { width: 0; }
}
@keyframes animate-positive{
    0% { width: 0; }
}
</style>
