<?php $result=$this->Company_model->ajax_company_departments_info($company_id);?>
<div class="form-group" id="ajx_department">
  <label for="department_id"><?php echo $this->lang->line('xin_hr_main_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="Choose Department" name="department_id" id="aj_subdepartments" >
    <option value=""></option>
    <?php foreach($result as $deparment) {?>
    <option value="<?php echo $deparment->department_id?>"><?php echo $deparment->department_name?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// get sub departments
	jQuery("#aj_subdepartments").change(function(){
		jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#subdepartment_ajax').html(data);
		});
	});
});
</script>
