<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['grade_id']) && $_GET['data']=='grade_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Grade</h4>
</div>
<?php $attributes = array('name' => 'edit_grade', 'id' => 'edit_grade', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $grade_id, 'ext_name' => $grade_id);?>
<?=form_open('admin/grade_list/update/'.$grade_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="grade_detail_id">Grade</label>
                  <select name="grade_detail_id" class="form-control" data-plugin="select_hrm" data-placeholder="Choose grade">
                    <option value="chooseGrade">Choose grade</option>
                    <?php foreach($allGradeDetail as $singGrade) {?>
                    <option value="<?=$singGrade->grade_detail_id?>" <?php if($gradeDetailId==$singGrade->grade_detail_id):?> selected="selected" <?php endif;?>><?=$singGrade->grade_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-6 col-xs-6'>
                      <div class="form-group">
                        <label for="dailyRequirement">Daily Requirement</label>
                        <input class="form-control dailyRequirement" placeholder="Set daily minimum requirement" name="dailyRequirement" type="number" min='0' value="<?=$dailyRequirement;?>" />
                      </div>
                    </div>
                    <div class='col-md-6 col-xs-6'>
                      <div class="form-group">
                        <label for="monthlyRequirement">Monthly Requirement</label>
                        <input class="form-control monthlyRequirement" placeholder="Set monthly minimum requirement" name="monthlyRequirement" type="number" min='1' value="<?=$monthlyRequirement;?>" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="grade_detail_id">Main Task</label>
                  <small><i>Update in <a href='appraisal_task_list'>Main Task &raquo;</a></i></small>
                  <select name="noname" disabled class="form-control" data-plugin="select_hrm" data-placeholder="Choose grade">
                    <option value="chooseGrade">Choose main task</option>
                    <?php foreach($allMainTask as $singMainTask) {?>
                    <option value="<?=$singMainTask->id;?>" <?php if($mainTaskId==$singMainTask->id):?> selected="selected" <?php endif;?>><?=$singMainTask->taskName?></option>
                    <?php } ?>
                  </select>
                  <input name='maintask' type='hidden' value='<?=$mainTaskId;?>' class="form-control" />
                </div>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-6 col-xs-6'>
                      <div class="form-group">
                        <label for="subdepartment_id"><?=$this->lang->line('xin_hr_sub_department');?></label>
                        <select name="noname" disabled class="form-control" data-plugin="select_hrm" data-placeholder="Choose sub department">
                          <option value="chooseSubDept">Choose sub department</option>
                          <?php foreach($allSubDept as $company) {?>
                          <option value="<?=$company->sub_department_id?>" <?php if($subDeptId==$company->sub_department_id):?> selected="selected" <?php endif;?>><?=$company->department_name?></option>
                          <?php } ?>
                        </select>
                        <input name='subdepartment_id' type='hidden' value='<?=$subDeptId;?>' class="form-control" />
                      </div>
                    </div>
                    <div class='col-md-6 col-xs-6'>
                      <div class="form-group">
                        <label for="name">Office Shift</label>
                        <select name="noname" disabled class="form-control subDeptId" data-plugin="select_hrm" data-placeholder="Choose shift">
                          <option value="">Not yet set</option>
                          <?php foreach($allShift as $singShift) {?>
                          <option value="<?=$singShift->office_shift_id;?>" <?php if($shiftId==$singShift->office_shift_id):?> selected="selected" <?php endif;?>><?=$singShift->shift_name?></option>
                          <?php } ?>
                        </select>
                        <input name='office_shift' type='hidden' value='<?=$shiftId;?>' class="form-control" />
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
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
  </div>
<?=form_close(); ?>
<script type='text/javascript'>
$(document).ready(function(){
  $('.dailyRequirement').bind('keyup mouseup', function () {
			var dailyRequirement = this.value;
			let result = Math.round(dailyRequirement*30);
			$('.monthlyRequirement').val(result);
	});
  $('.monthlyRequirement').bind('keyup mouseup', function () {
			var monthlyRequirement = this.value;
			let result = Math.round(monthlyRequirement/30);
			$('.dailyRequirement').val(result);
	});
  /* update */
	$("#edit_grade").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=grade_update&form="+action,
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
						url : base_url+"/grade_list",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['grade_id']) && $_GET['data']=='view_grade' && $_GET['type']=='view_grade'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Grade</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Grade</label><br />
        <?=$gradeName;?>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Daily Requirement</label><br />
            <?=number_format($dailyRequirement,0,'.','.');?> x
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Monthly Requirement</label><br />
            <?=number_format($monthlyRequirement,0,'.','.');?> x
          </div>
        </div>
      </div>
      <div class="form-group">
        <label>Main Task</label><br />
        <?=$mainTaskName;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Sub Department</label><br />
            <?=$subDepartmentName;?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Office Shift</label><br />
            <?=$shiftName;?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label>Grade Description</label><br />
        <?=$gradeDescription;?>
      </div>
      <div class="form-group">
        <label>Percentage</label><br />
        <?=$minimumPercentage." - ".$maximumPercentage;?>%
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
</div>
<?php };?>
