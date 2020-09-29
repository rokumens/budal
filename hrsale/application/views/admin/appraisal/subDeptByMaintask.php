<?php $awyeah = $this->Grade_model->getSubdeptByMainTask($maintask_id);?>
<div class="">
  <div class="col-md-6">
    <div class="form-group">
      <label for="subdepartment_id">Sub Department</label>
      <input class="form-control" name="gaperlunama" value='<?=$awyeah->department_name;?>' type="text" readonly />
      <input class="form-control" name="subdepartment_id" value='<?=$awyeah->sub_department_id;?>' type="hidden" readonly />
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="office_shift">Office Shift</label>
      <input class="form-control" name="gaperlunama" value='<?=$awyeah->shift_name;?>' type="text" readonly />
      <input class="form-control" name="office_shift" value='<?=$awyeah->office_shift_id;?>' type="hidden" readonly />
    </div>
  </div>
</div>
