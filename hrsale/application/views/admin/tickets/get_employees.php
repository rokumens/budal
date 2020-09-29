<?php $employees = $this->Employees_model->employeeActiveAPG();?>
<div class="form-group" id="employee_ajax">
  <label for="employees"><?=$this->lang->line('xin_ticket_for_employee');?></label>
  <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_single_employee');?>">
    <option value=""></option>
    <?php foreach($employees->result() as $employee) {?>
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
