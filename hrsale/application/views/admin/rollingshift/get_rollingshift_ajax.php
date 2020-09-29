<?php
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $employees = $this->Rollingshift_model->getRollingshift($curr_subdept_id, $date)->result_array(); ?>
<?php if(!is_null($employees)): ?>
	<?php foreach($employees as $employeex): ?>
	<a data-date="<?=$date;?>" class="data_dayoff fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" data-id="<?=$employeex['user_id'];?>">
		<div class="fc-content"><span class="fc-title"><?=$employeex['employee_id'].' - '.$employeex['username'];?></span></div>
	</a>
	<?php endforeach; ?>
<?php else: ?>
No employee under this department.
<?php endif; ?>

<script>
$(document).ready(function(){
	$(".detailShift").click(function(){
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