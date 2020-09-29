<div class="form-group">
   <label for="employee">Employee</label>
   <select name="employee" class="form-control aj_employees" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" disabled>
    <option value="allEmployess_val" selected>All Employees</option>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({width:'100%'});
});
</script>
