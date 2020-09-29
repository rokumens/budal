<?php $result = $this->Employees_model->ajax_shift_information();?>
<div class="form-group">
  <label for="shift"><?php echo $this->lang->line('left_office_shifts');?></label>
  <select class="form-control" name="shift_id" id="shift_id" data-plugin="select_hrm" data-placeholder="Select shift">
    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
    <?php foreach($result as $shift) {?>
    <option value="<?php echo $shift->office_shift_id?>"><?php echo $shift->shift_name?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
