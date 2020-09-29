<?php $employees = $this->Appraisal_model->ajax_subdept_employee_info($subdept_id);?>
<div class="form-group">
   <label for="employee">Employee</label>
   <select name="employee" class="form-control aj_employees" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
    <option value=""></option>
    <?php if(count($employees)):?>
    <option value="allSubEmployess_val">All employees in this sub-department</option>
    <?php foreach($employees as $employee) {?>
      <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
    <?php }?>
    <?php endif;?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
  jQuery(".aj_employees").change(function(){
		if(this.value=='allEmployess_val'){
			jQuery.get(base_url+"/get_subdepartments_disabled/", function(data,status){
				jQuery('.subdept_ajax').html(data);
			});
			jQuery.get(base_url+"/get_single_jobtask/", function(data,status){
				jQuery('.jobtask_ajax').html(data);
			});
      jQuery.get(base_url+"/get_single_employees/"+jQuery(this).val(), function(data,status){
				jQuery('.employee_ajax').html(data);
			});
		}else if(this.value=='allSubEmployess_val'){
      <?php //make it single task if All employees in this subdepartment was choosed.;?>
      jQuery.get(base_url+"/get_single_jobtask/", function(data,status){
				jQuery('.jobtask_ajax').html(data);
			});
    }
  });
  jQuery(".aj_subdept").change(function(){
		if(this.value=='allSubDepartments_val'){
			jQuery.get(base_url+"/get_single_jobtask/", function(data,status){
				jQuery('.jobtask_ajax').html(data);
			});
      jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data,status){
				jQuery('.employee_ajax').html(data);
			});
		}
	});
});
</script>
