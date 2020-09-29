<?php $jobtask = $this->Appraisal_model->ajax_single_task_list();?>
<div class="form-group">
   <label for="jobtask">Main Task</label>
   <select name="jobtask" class="form-control jobtaskIsKpiOrNot getGradeDetailId" data-plugin="select_hrm" data-placeholder="Choose main task">
    <option value=""></option>
    <?php foreach($jobtask as $singJobtask) {?>
      <?php if(!empty($singJobtask->minimumRequirementBonus)): //task for bonus?>
        <option value="<?=$singJobtask->kpi_id;?>"><?=$singJobtask->name;?> [Monthly requirement for Bonus: <?=$singJobtask->minimumRequirementBonus;?>x]</option>
      <?php else: //task for grade?>
        <option value="<?=$singJobtask->id;?>"><?=$singJobtask->name;?> [<i><?=$singJobtask->shift_name;?></i>]</option>
      <?php endif;?>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({width:'100%'});
});
</script>
