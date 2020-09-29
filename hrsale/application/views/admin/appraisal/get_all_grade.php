<?php $allGradeDetail = $this->Grade_detail_model->all_grade_detail()->result();?>
<div class="form-group">
   <label for="grade">Grade</label>
   <select name="grade" class="form-control grade" data-plugin="select_hrm" data-placeholder="Choose grade">
     <option value=""></option>
     <option value="chooseGrade">Choose grade</option>
     <?php foreach($allGradeDetail as $singGrade) {?>
     <option value="<?php echo $singGrade->grade_detail_id?>"><?php echo $singGrade->grade_name?></option>
     <?php } ?>
   </select>
</div>
