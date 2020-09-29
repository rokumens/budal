<?php $result = $this->Appraisal_model->all_sub_departments();?>
<div class="form-group" id="ajx_department">
  <label for="subdepartment_id"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
  <select class="form-control aj_subdept" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="Choose sub department" id="aj_departments">
    <option value="allSubDepartments_val" selected>All Subdepartment</option>
    <?php foreach($result as $deparment){?><option value="<?php echo $deparment->sub_department_id;?>"><?php echo $deparment->department_name;?></option><?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({width:'100%'});
  jQuery(".aj_subdept").change(function(){
    if(this.value=='allSubDepartments_val'){
      jQuery.get(base_url+"/get_single_jobtask/", function(data,status){
        jQuery('.jobtask_ajax').html(data);
      });
      jQuery.get(base_url+"/get_single_employees/", function(data,status){
        jQuery('.employee_ajax').html(data);
      });
    }else{
      jQuery.get(base_url+"/get_jobtask/"+jQuery(this).val(), function(data,status){
        jQuery('.jobtask_ajax').html(data);
      });
      jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data,status){
        jQuery('.employee_ajax').html(data);
      });
    }
  });
});
</script>
