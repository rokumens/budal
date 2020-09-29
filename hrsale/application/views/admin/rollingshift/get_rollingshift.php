<?php
$getEmployeeNoQuotaBySubdeptId = $this->Rollingshift_model->getEmployeeNoQuotaBySubdeptId($subdept_id)->result();
$employeesBySubdept = $this->Rollingshift_model->getEmployeeBySubdeptId($subdept_id)->result();
// d($subdept_id);
if(!is_null($getEmployeeNoQuotaBySubdeptId)){
  $userIdNoQuota = [];
  foreach($getEmployeeNoQuotaBySubdeptId as $key => $value){
    $userIdNoQuota[$value->user_id]['user_id'] = $value->user_id;
    $userIdNoQuota[$value->user_id]['employee_id'] = $value->employee_id;
    $userIdNoQuota[$value->user_id]['username'] = $value->username;
  }
  $userIdEmployeeBySubdept = [];
  foreach($employeesBySubdept as $key => $value){
    $userIdEmployeeBySubdept[$value->user_id]['user_id'] = $value->user_id;
    $userIdEmployeeBySubdept[$value->user_id]['employee_id'] = $value->employee_id;
    $userIdEmployeeBySubdept[$value->user_id]['username'] = $value->username;
  }
  $employees = array_diff_values($userIdEmployeeBySubdept, $userIdNoQuota);
  foreach($employees as $employeex) {?>
  <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable data_rollingshift" data-toggle="modal" data-target="#myModalRollingshift" data-id="<?=$employeex['user_id'];?>">
    <div class="fc-content"><span class="fc-title"><?=$employeex['employee_id'].' - '.$employeex['username'];?></span></div>
  </a>
  <?php } }else{?>
  No employee under this department.
<?php }?>

<script>
$(document).ready(function(){
	$(".data_rollingshift").click(function(){
		const id = $(this).data('id');
		const date = $(this).children('div.fc-content').attr('data-date');
		$.ajax({
			type: "GET",
			url: site_url+'rollingshift/detail/',
			data: {id : id},
			dataType: 'json',
			success: function(data){
				$('h4.modal-title').html(data.employee_id+' - '+data.username);
				$('#user_id').val(data.user_id);
				$('#username').val(data.username);
				$('#employee_id').val(data.employee_id);
				$('#site').val(data.fingerprint_location);
				$('#divisi').val(data.department_name);
				$('#sub_department_id').val(data.sub_department_id);
				$('#shift').val(data.shift_name);
				$('#office_shift_id').val(data.office_shift_id);
				$('#date').val(date);
			}
		});
  });
});
</script>