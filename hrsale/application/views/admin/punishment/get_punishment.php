<?php $allPunishment = $this->Punishment_model->all_punishment();?>
<div class="form-group">
   <label for="punishment">Punishment</label>
   <select name="punishment" class="form-control" data-plugin="select_hrm" data-placeholder="Select punishment">
    <option value=""></option>
    <?php foreach($allPunishment->result() as $singPunishment) {?>
    <option value="<?php echo $singPunishment->id;?>"><?php echo $singPunishment->punishment_name;?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
