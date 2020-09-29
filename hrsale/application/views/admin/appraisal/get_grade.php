<?php $allGrade = $this->Appraisal_task_model->getGrade($subdept_id);?>
<div class="form-group">
   <label for="grade">Grade</label>
   <select name="grade" class="form-control grade" data-plugin="select_hrm" data-placeholder="Choose grade">
      <option value=""></option>
      <option value="chooseGrade">Choose grade</option>
      <?php foreach($allGrade as $singGrade) {?>
      <option value="<?php echo $singGrade->id?>"><?php echo $singGrade->gradeName?></option>
      <?php } ?>
    </select>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({width:'100%'});
  jQuery(".grade").change(function(){
    if(jQuery(this).val()!='chooseGrade'){
      jQuery.get(base_url+"/get_requirement/"+<?=$subdept_id;?>+'/'+jQuery(this).val(), function(data, status){
  			jQuery('.minRequirement').html(data);
  		});
    }
	});
});
</script>
