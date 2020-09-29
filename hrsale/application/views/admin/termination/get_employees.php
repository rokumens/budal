<?php // luffy 8 Dec 2019 - 04:19 pm
$arrEmployee = $this->Employees_model->employeeActiveAPG();?>
<div class="form-group">
  <label for="xin_department_head"><?=$this->lang->line('xin_employee_terminated');?></label>
   <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
    <option value=""></option>
    <?php foreach($arrEmployee->result() as $employee) {?>
    <option value="<?=$employee->user_id;?>"> <?=$employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
