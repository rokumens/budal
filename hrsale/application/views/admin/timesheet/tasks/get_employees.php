<?php
# luffy 2 January 2020 03:25 pm
// $result = $this->Department_model->ajax_company_employee_info($company_id);
$result = $this->Employees_model->employeeActiveAPG()->result();
?>
<div class="form-group">
  <label for="xin_department_head"><?=$this->lang->line('xin_assigned_to');?></label>
   <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_single_employee');?>">
    <option value=""></option>
    <?php foreach($result as $employee) {?>
    <option value="<?=$employee->user_id?>"> <?=$employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
