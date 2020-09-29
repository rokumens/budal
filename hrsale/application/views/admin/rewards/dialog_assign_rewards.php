<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['assign_rewards_id']) && $_GET['data']=='assign_rewards_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Assigned Rewards</h4>
</div>
<?php $attributes = array('name' => 'edit_assign_rewards', 'id' => 'edit_assign_rewards', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $assRewardsId, 'ext_name' => $assRewardsId);?>
<?php echo form_open('admin/assign_rewards/update/'.$assRewardsId, $attributes, $hidden);?>
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
              <div class='col-md-6'>
                <div class="form-group">
                  <label for="name">Rewards Date</label>
                  <input class="form-control rewardsDate" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="rewards_date" type="text" value="<?php echo $rewardsDate;?>">
                </div>
                <div class="form-group rewards_ajax">
                  <label for="rewards">Rewards</label>
                  <select name="rewards" class="form-control" data-plugin="select_hrm" data-placeholder="Select rewards">
                    <option value=""></option>
                    <?php foreach($allRewards->result() as $singRewards) {?>
                    <option value="<?php echo $singRewards->id;?>" <?php if($rewardsId==$singRewards->id):?> selected="selected" <?php endif;?>><?php echo $singRewards->rewards_name;?></option>
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
    jQuery.get(base_url+"/get_rewards/"+jQuery(this).val(), function(data, status){
      jQuery('.rewards_ajax').html(data);
    });
  });
  /* Update data */
	$("#edit_assign_rewards").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=assign_rewards_update&form="+action,
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
						url : base_url+"/assign_rewards",
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
	$('.rewardsDate').datepicker({
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
<?php } else if(isset($_GET['jd']) && isset($_GET['assign_rewards_id']) && $_GET['data']=='view_assign_rewards' && $_GET['type']=='view_assign_rewards'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Assigned Rewards</h4>
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
        <label>Reward</label><br />
        <?php echo $rewards;?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Rewards date</label><br />
        <?php echo date('d-M-Y', strtotime($rewardsDate));?>
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
