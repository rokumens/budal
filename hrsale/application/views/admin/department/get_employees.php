<?php $arrActiveEmployees = $this->Employees_model->get_attendance_employees();?>
<div class="form-group">
  <label for="xin_department_head"><?php echo $this->lang->line('xin_department_head');?></label>
   <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_department_head');?>">
    <option value=""></option>
    <?php foreach($arrActiveEmployees->result() as $employee) {?>
    <option value="<?=$employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
