<?php $result = get_sub_departments($department_id);?>
<div class="form-group" id="subdepartment_ajax">
  <label for="subdepartment_id"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="Choose Sub Department" name="subdepartment_id" id="aj_subdepartment" >
    <option value=""></option>
    <?php foreach($result as $deparment) {?>
    <option value="<?php echo $deparment->sub_department_id?>"><?php echo $deparment->department_name?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>