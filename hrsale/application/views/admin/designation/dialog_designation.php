<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['designation_id']) && $_GET['data']=='designation'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_designation_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_designation', 'id' => 'edit_designation', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $designation_id, 'ext_name' => $designation_name);?>
<?=form_open('admin/designation/update/'.$designation_id, $attributes, $hidden);?>
  <div class="modal-body">
     <div class="row">
      <div class="col-md-4">
        <div class="form-group">
              <label for="first_name"><?=$this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?=$company->company_id?>" <?php if($company->company_id==$company_id) {?> selected="selected" <?php } ?>><?=$company->name?></option>
                <?php } ?>
              </select>
            </div>
      </div>
      <div class="col-md-4">
        <div class="form-group" id="ajx_department">
          <label for="name"><?=$this->lang->line('xin_hr_main_department');?></label>
          <?php $result = $this->Company_model->ajax_company_departments_info($company_id);?>
          <select name="department_id" id="aj_subdepartments" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_department');?>">
            <option value=""></option>
            <?php foreach($result as $deparment) {?>
            <option value="<?=$deparment->department_id?>" <?php if($deparment->department_id==$department_id) {?> selected="selected" <?php } ?>><?=$deparment->department_name?></option>
            <?php } ?>
          </select>
        </div>
       </div>
       <div class="col-md-4">
        <div class="form-group" id="subdepartment_ajx">
          <label for="name"><?=$this->lang->line('xin_hr_sub_department');?></label>
          <?php $dresult = get_sub_departments($department_id);?>
          <select name="subdepartment_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_department');?>">
            <option value=""></option>
            <?php foreach($dresult as $_deparment) {?>
            <option value="<?=$_deparment->sub_department_id?>" <?php if($_deparment->sub_department_id==$sub_department_id) {?> selected="selected" <?php } ?>><?=$_deparment->department_name?></option>
            <?php } ?>
          </select>
        </div>
       </div>
     <div class="col-md-4">
        <div class="form-group">
        <label for="designation"><?=$this->lang->line('xin_designation');?></label>
        <input type="text" class="form-control" name="designation_name" value="<?=$designation_name;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
  </div>
<?=form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#department_ajx').html(data);
		});
	});
	jQuery("#aj_subdepartments").change(function(){
		jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#subdepartment_ajx').html(data);
		});
	});
	/* update */
	$("#edit_designation").submit(function(e){
    e.preventDefault();
    var obj = $(this), action = obj.attr('name');
    $('.save').prop('disabled', true);
    $.ajax({
      type: "POST",
      url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=designation&form="+action,
      cache: false,
			success: function (JSON,data) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					var xin_table = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
							url : base_url+"/designation_list",
              type : 'GET'
  					},
  					"fnDrawCallback": function(settings){
  					$('[data-toggle="tooltip"]').tooltip();
  					}
  					});
  					xin_table.api().ajax.reload(function(){
  						toastr.success(JSON.result);
  					}, true);
  					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
  					$('.edit-modal-data').modal('toggle');
  					$('.save').prop('disabled', false);
            // console.log(e.target);return false;
            // console.log(obj.serialize());return false;
  				}
  			},
  			error: function(xhr, textStatus, error) {
  					// console.log('Error Berat: ' + xhr.responseText);  // luffy
  					// console.log('Error Berat: ' + xhr.statusText); // luffy
  					// console.log('Error Berat: ' + textStatus); // luffy
  					// console.log('Error Berat: ' + error); // luffy
  					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
  					$('.save').prop('disabled', true);
  					xin_table.api().ajax.reload(function(){
  						toastr.error("Error. Please contact dev team.");
  					}, true);
  					setTimeout(function(){
  						location.reload();
  					}, 1500);
  			},
		});
	});
});
</script>
<?php }?>
