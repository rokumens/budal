<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['assign_punishment_id']) && $_GET['data']=='assign_punishment_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Punishment Points</h4>
</div>
<?php $attributes = array('name' => 'edit_assign_punishment', 'id' => 'edit_assign_punishment', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $assPunishmentId, 'ext_name' => $assPunishmentId);?>
<?php echo form_open('admin/assign_punishment/update/'.$assPunishmentId, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
                  <select class="form-control aj_subdept" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="Choose sub department">
                    <option value=""></option>
                    <?php foreach($allSubDepartments as $singSubdept) {?>
                    <option value="<?php echo $singSubdept->sub_department_id;?>" <?php if($subDepartmentId==$singSubdept->sub_department_id):?> selected="selected" <?php endif;?>><?php echo $singSubdept->department_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group employee_ajax">
                  <label for="employee">Assign to</label>
                  <select name="assign_to" class="form-control" data-plugin="select_hrm" data-placeholder="Assign to">
                    <option value=""></option>
                    <?php foreach($allEmployees->result() as $singEmployee) {?>
                    <option value="<?php echo $singEmployee->user_id;?>" <?php if($employeesId==$singEmployee->user_id):?> selected="selected" <?php endif;?>><?php echo $singEmployee->first_name.' '.$singEmployee->last_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Punishment Date</label>
                  <input class="form-control punishmentDate" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="punishment_date" type="text" value="<?php echo $punishmentDate;?>">
                </div>
                <div class="form-group punishment_ajax">
                  <label for="punishment">Punishment</label>
                  <select name="punishment" class="form-control" data-plugin="select_hrm" data-placeholder="Select punishment">
                    <option value=""></option>
                    <?php foreach($allPunishment->result() as $singPunishment) {?>
                    <option value="<?php echo $singPunishment->id;?>" <?php if($punishmentId==$singPunishment->id):?> selected="selected" <?php endif;?>><?php echo $singPunishment->punishment_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type='text/javascript'>
$(document).ready(function(){
  jQuery(".aj_subdept").change(function(){
    jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
      jQuery('.employee_ajax').html(data);
    });
    jQuery.get(base_url+"/get_punishment/"+jQuery(this).val(), function(data, status){
      jQuery('.punishment_ajax').html(data);
    });
  });
  /* Update data */
	$("#edit_assign_punishment").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=assign_punishment_update&form="+action,
			cache: false,
			success: function (JSON,data) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : base_url+"/assign_punishment",
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

  // for date picker
	$('.punishmentDate').datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: '0',
		dateFormat:'yy-mm-dd',
		altField: "#date_format",
		altFormat: js_date_format,
		yearRange: '1970:' + new Date().getFullYear(),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
})
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['assign_punishment_id']) && $_GET['data']=='view_assign_punishment' && $_GET['type']=='view_assign_punishment'){?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Assigned Punishment</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Assigned to</label><br />
        <?php echo $assignTo;?>
      </div>
      <div class="form-group">
        <label>Sub Department</label><br />
        <?php echo $subDepartmentName;?>
      </div>
      <div class="form-group">
        <label>Punishment</label><br />
        <?php echo $punishment;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Punishment date</label><br />
        <?php echo $punishmentDate;?>
      </div>
      <div class="form-group">
        <label>Assigned by</label><br />
        <?php echo $assignedBy;?>
      </div>
      <div class="form-group">
        <label>Assigned at</label><br />
        <?php echo date('d-M-Y',strtotime($assignedAt));?>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php }
?>
