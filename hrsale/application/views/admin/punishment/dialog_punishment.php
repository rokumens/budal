<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['punishment_id']) && $_GET['data']=='punishment_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Punishment Points</h4>
</div>
<?php $attributes = array('name' => 'edit_punishment', 'id' => 'edit_punishment', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $punishment_id, 'ext_name' => $punishment_id);?>
<?php echo form_open('admin/punishment/update/'.$punishment_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="punishmentName">Punishment Name</label>
                  <input type='text' name='punishmentName' class="form-control" value='<?php echo $punishmentName;?>' placeholder='Set punishment name' />
                </div>
                <div class="form-group">
                  <label for="punishmentPoint">Punishment Point</label>
                  <input name='punishmentPoint' class="form-control punishmentPoint" value='<?php echo $punishmentPoint;?>' placeholder='Set punishment point. Eg: -5, -20, -100' type='number' max=-1 required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="valuePerPoint">Amount Per 1 Point (Rp.)</label>
                  <input name='valuePerPoint' class="form-control valuePerPoint" value="<?php echo $valuePerPoint;?>" type='text' readonly/>
                </div>
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input name='amount' class="form-control amount duitMinus" value='<?php echo $amount;?>' type='text' readonly />
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
  $('.punishmentPoint').bind('keyup mouseup', function () {
    var punishmentPoint = this.value;
    var amountPerPoint = $('.amountPerPoint').val();
    let result = Math.round(punishmentPoint*amountPerPoint).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $('.amount').val(result);
	});
  // for money currency value with comma separated
  $('.duitMinus').mask("#.##0", {
		reverse: true,
			translation: {
				'#': {
						pattern: /-|\d/,
						recursive: true
				}
			}
	});
  /* Update data */
	$("#edit_punishment").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=punishment_update&form="+action,
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
						url : base_url+"/punishment_list",
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
})
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['punishment_id']) && $_GET['data']=='view_punishment_task' && $_GET['type']=='view_punishment_task'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Punishment Points</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Punishment Name</label><br />
        <?php echo $punishmentName;?>
      </div>
      <div class="form-group">
        <label>Punishment</label><br />
        <?php echo $punishmentPoint;?> point
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Amount per 1 point</label><br />
        <?php echo "Rp. ".number_format($valuePerPoint,0,',','.');?>
      </div>
      <div class="form-group">
        <label>Amount</label><br />
        <?php echo "Rp. ".number_format($amount,0,',','.');?>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php };?>
