<?php // luffy 8 Dec 2019 - 10:42 am
$arrEmployee = $this->Employees_model->employeeActiveAPG();?>
<div class="form-group">
  <label for="xin_department_head"><?=$this->lang->line('xin_warning_to');?></label>
   <select name="warning_to" id="select2-demo-6" class="form-control warningTo" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
    <option value=""></option>
    <?php foreach($arrEmployee->result() as $employee){?>
    <option value="<?=$employee->user_id;?>"> <?=$employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
  jQuery(".warningTo").change(function(){
		jQuery.get(base_url+"/get_warning_type/"+jQuery(this).val(), function(data, status){
			jQuery('#warning_type_ajax').html(data);
		});
	});
});
</script>
