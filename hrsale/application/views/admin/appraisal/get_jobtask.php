<?php
$jobtask=$this->Appraisal_model->ajax_jobtask_info($subdept_id);
$subDeptName=$this->Appraisal_model->getSubDeptNameBySubDeptId($subdept_id);
?>
<div class="form-group">
   <label for="jobtask">Main Task</label>
   <?php if(!is_null($jobtask)):?>
   <select multiple name="jobtask[]" class="form-control jobtaskIsKpiOrNot getGradeDetailId select2" data-plugin="select_hrm" data-placeholder="Choose main task [can multiple select]">
    <option value=""></option>
    <?php foreach($jobtask as $singJobtask) {?>
      <?php if(!empty($singJobtask->minimumRequirementBonus)): //task for bonus?>
        <option value="<?=$singJobtask->kpi_id;?>"><?=$singJobtask->name;?> [ <i> Monthly <?=$singJobtask->minimumRequirementBonus;?>x </i> ]</option>
      <?php else: //task for grade?>
        <option value="<?=$singJobtask->id;?>"><?=$singJobtask->name;?> [<i><?=$singJobtask->shift_name;?></i>]</option>
      <?php endif;?>
    <?php } ?>
  </select>
  <?php else:?>
  <div style='background:#eee;padding:20px 25px 10px;'>
  <p>No main task created yet for <?=strtolower($subDeptName->subDeptName);?>.</p>
  <p>You can create a main task <a href='appraisal_task_list'>here</a> &raquo;</p>
  <?php endif;?>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({width:'100%'});
});
</script>
