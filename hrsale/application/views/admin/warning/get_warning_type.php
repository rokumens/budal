<?php $getCounter = $this->Warning_model->getCounterByEmployeeId($warning_to)->countWarningCounter;
$counterValue=$getCounter+1;
if($getCounter==3) $counterValue=3;
$getWarningType=$this->Warning_model->getWarningTypeNameById($counterValue);
empty($getCounter)?$counterName='First Warning':$counterName=$getWarningType->type;
?>
<div class="form-group">
  <label for="type"><?php echo $this->lang->line('xin_warning_type');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_warning_type');?>" name="type">
    <option value="<?php echo $counterValue;?>"><?php echo $counterName;?></option>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
