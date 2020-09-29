<div class="form-group">
  <label for="subdepartment_id"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
  <select class="form-control aj_subdept" data-plugin="select_hrm" data-placeholder="All Sub Department" name="subdepartment_id">
    <option value=""></option>
    <option value="allSubDepartments_val" selected>All Subdepartment</option>
    <option value="chooseSubDepartment">Choose one of sub-department</option>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({width:'100%'});
  jQuery(".aj_subdept").change(function(){
    if(this.value=='chooseSubDepartment'){
      jQuery.get(base_url+"/get_subdepartments/", function(data,status){
				jQuery('.subdept_ajax').html(data);
			});
      jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data,status){
        jQuery('.employee_ajax').html(data);
      });
     }
     if(this.value=='allSubDepartments_val'){
       jQuery.get(base_url+"/get_single_jobtask/", function(data,status){
         jQuery('.jobtask_ajax').html(data);
       });
       jQuery.get(base_url+"/get_single_employees/", function(data,status){
         jQuery('.employee_ajax').html(data);
       });
     }
   });
});
</script>
