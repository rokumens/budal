<?php $result = $this->Location_model->ajax_location_info($company_id);?>
<div class="form-group">
  <label for="location"><?php echo $this->lang->line('xin_location');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="Select location" name="location_id" id="location_id" >
    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
    <?php foreach($result as $location) {?>
    <option value="<?php echo $location->location_id?>"><?php echo $location->location_name?></option>
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
