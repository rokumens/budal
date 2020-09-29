<?php $requirement = $this->Kpi_sales_model->getLowestMonthlyRequirement($taskId);?>
<div class="form-group">
  <label for="min_monthly_grade">Min. Sales Requirement (Monthly)</label>
  <input class="form-control monthlyRequirement" id="monthlyRequirement" name="monthlyRequirement" value='<?=$requirement->monthlyRequirement;?>' type="number" readonly />
</div>
