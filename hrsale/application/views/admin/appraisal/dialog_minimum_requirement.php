<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['minimum_requirement_id']) && $_GET['data']=='minimum_requirement_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Minimum Requirement</h4>
</div>
<?php $attributes = array('name' => 'edit_minimum_requirement', 'id' => 'edit_minimum_requirement', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $minimum_requirement_id, 'ext_name' => $minimum_requirement_id);?>
<?php echo form_open('admin/minimum_requirement/update/'.$minimum_requirement_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dailyRequirement">Daily Minimum Requirement</label>
                  <input class="form-control dailyRequirement" placeholder="Set daily minimum requirement" name="dailyRequirement" type="number" min='0' value="<?php echo $dailyRequirement;?>" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="monthlyRequirement">Monthly Minimum Requirement</label>
                  <input class="form-control monthlyRequirement" placeholder="Set monthly minimum requirement" name="monthlyRequirement" type="number" min='1' value="<?php echo $monthlyRequirement;?>" />
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
  $('.dailyRequirement').bind('keyup mouseup', function () {
			var dailyRequirement = this.value;
			let result = Math.round(dailyRequirement*30);
			$('.monthlyRequirement').val(result);
	});
  $('.monthlyRequirement').bind('keyup mouseup', function () {
			var monthlyRequirement = this.value;
			let result = Math.round(monthlyRequirement/30);
			$('.dailyRequirement').val(result);
	});
  /* Update data */
	$("#edit_minimum_requirement").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=minimum_requirement_update&form="+action,
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
						url : base_url+"/minimum_requirement_list",
						type : 'GET'
					},
					// dom: 'lBfrtip',
					// "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
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
	}); // end update
})
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['minimum_requirement_id']) && $_GET['data']=='view_minimum_requirement' && $_GET['type']=='view_minimum_requirement'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Minimum Requirement</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Daily Minimum Requirement</label><br />
        <?php echo $dailyRequirement;?>x
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Monthly Minimum Requirement</label><br />
        <?php echo $monthlyRequirement;?>x
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php };?>
