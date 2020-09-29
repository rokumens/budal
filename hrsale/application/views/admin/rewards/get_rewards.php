<?php $allRewards = $this->Rewards_model->all_rewards();;?>
<div class="form-group">
   <label for="rewards">Rewards</label>
   <select name="rewards" class="form-control" data-plugin="select_hrm" data-placeholder="Select rewards">
    <option value=""></option>
    <?php foreach($allRewards->result() as $singRewards) {?>
    <option value="<?php echo $singRewards->id;?>"><?php echo $singRewards->rewards_name;?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
