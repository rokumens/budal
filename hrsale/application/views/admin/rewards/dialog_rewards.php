<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['rewards_id']) && $_GET['data']=='rewards_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Rewards Points</h4>
</div>
<?php $attributes = array('name' => 'edit_rewards', 'id' => 'edit_rewards', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $rewards_id, 'ext_name' => $rewards_id);?>
<?php echo form_open('admin/rewards/update/'.$rewards_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="rewardName">Reward Name</label>
                  <input type='text' name='rewardName' class="form-control" value='<?php echo $rewardName;?>' placeholder='Set reward name' />
                </div>
                <div class="form-group">
                  <label for="rewardPoint">Reward Point</label>
                  <input name='rewardPoint' class="form-control rewardPoint" value='<?php echo $rewardPoint;?>' placeholder='Set reward point' min=1 type='number' />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="valuePerPoint">Amount Per 1 Point</label>
                  <input name='valuePerPoint' class="form-control amountPerPoint" value="<?php echo $valuePerPoint;?>" type='text' readonly />
                </div>
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input name='amount' class="form-control amount duit" value='<?php echo $amount;?>' type='text' readonly />
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
  $('.rewardPoint').bind('keyup mouseup', function() {
			var rewardPoint = this.value;
      var amountPerPoint = $('.amountPerPoint').val();
			let result = Math.round(rewardPoint*amountPerPoint).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			$('.amount').val(result);
	});
  // for money currency value with comma separated
	$('.duit').mask("#.##0", {reverse: true});
  /* Update data */
	$("#edit_rewards").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=rewards_update&form="+action,
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
						url : base_url+"/rewards_list",
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
					// setTimeout(function(){
					// 	location.reload();
					// }, 1500);
			},
		});
	});
})
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['rewards_id']) && $_GET['data']=='view_rewards_task' && $_GET['type']=='view_rewards_task'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Rewards Points</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Reward Name</label><br />
        <?php echo $rewardName;?>
      </div>
      <div class="form-group">
        <label>Reward</label><br />
        <?php echo $rewardPoint;?> point
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
<?php }
?>
