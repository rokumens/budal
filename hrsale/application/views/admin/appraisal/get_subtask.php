<?php
$allSubtaskTitle=$this->Appraisal_sub_task_model->getAllSubtaskTitleByMaintTaskId($maintask_id);
$maintaskName=$this->Appraisal_sub_task_model->getMaintaskName($maintask_id)[0]->name;
$subtaskCountKe=$this->Appraisal_sub_task_model->getSumSubTaskPoint($maintask_id,$user_id)[0]->sum_total_point+1;
#$subtaskVal=$maintaskName.' ke-'.$subtaskCountKe;
$subtaskVal='Subtask ke-'.$subtaskCountKe;
?>
<div class="form-group">
  <label for="subtask_name">Subtask</label>
  <select name="subtask_name" class="form-control" data-plugin="select_hrm" data-placeholder="Select subtask title">
    <?php foreach($allSubtaskTitle as $singSubtaskTitle) {?>
    <option value="<?php echo $singSubtaskTitle->id?>"><?php echo $singSubtaskTitle->sub_task_title_name;?></option>
    <?php } ?>
  </select>
  <div style='padding-top:10px;'><span style='margin-right:15px;font-style:italic;'><?=$subtaskVal;?></span></div>
</div>
