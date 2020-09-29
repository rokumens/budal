<?php $employees = $this->Appraisal_model->ajax_subdept_employee_info($subdept_id);?>
<div class="form-group">
   <label for="employee">Assign to</label>
   <select name="assign_to" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
    <option value=""></option>
    <?php foreach($employees as $employee) {?>
    <option value="<?php echo $employee->user_id;?>"><?php echo $employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
