<?php $result = $this->Employees_model->ajax_company_departments_info($company_id);?>

<div class="form-group">
  <label for="department"><?php echo $this->lang->line('xin_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="department_id" id="aj_department" >
    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
    <?php foreach($result as $department) {?>
    <option value="<?php echo $department->department_id?>"><?php echo $department->department_name?></option>
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
