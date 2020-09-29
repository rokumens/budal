<?php $requirement = $this->Appraisal_task_model->getMinimumRequirement($subDeptId,$gradeDetailId);?>
<div class="">
  <div class="col-md-6">
    <div class="form-group">
      <label for="min_daily_grade">Minimum Daily Requirement</label>
      <input class="form-control dailyRequirement" name="min_daily_grade" value='<?=$requirement->dailyRequirement;?>' type="number" readonly />
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="min_monthly_grade">Minimum Monthly Requirement</label>
      <input class="form-control monthlyRequirement" name="min_monthly_grade" value='<?=$requirement->monthlyRequirement;?>' type="number" readonly />
    </div>
  </div>
</div>
