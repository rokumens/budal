<?php
# luffy 1 January 2020 05:03 pm
// $result = $this->Department_model->ajax_company_employee_info($company_id);
$result = $this->Employees_model->employeeActiveAPG()->result();?>
<div class="form-group">
  <label for="xin_department_head"><?=$this->lang->line('xin_complaint_against');?></label>
   <select multiple class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_complaint_employees');?>" name="complaint_against[]">
    <option value=""></option>
    <?php foreach($result as $employee) {?>
    <option value="<?=$employee->user_id;?>"> <?=$employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
