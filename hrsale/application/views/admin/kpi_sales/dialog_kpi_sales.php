<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['kpi_sales_id']) && $_GET['data']=='kpi_sales_update'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update KPI Sales</h4>
</div>
<?php $attributes = array('name' => 'edit_kpi_sales', 'id' => 'edit_kpi_sales', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $kpi_sales_id, 'ext_name' => $kpi_sales_id);?>
<?php echo form_open('admin/kpi_sales/update/'.$kpi_sales_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Main Task</label>
                  <select class="form-control taskId" name="jobtask" data-plugin="select_hrm" data-placeholder="Choose main job">
                    <?php foreach($allJobTask as $singJobTask) {?>
                    <option value="<?php echo $singJobTask->id;?>" <?php if($jobTaskId==$singJobTask->id):?> selected="selected" <?php endif;?>><?php echo $singJobTask->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group minRequirement">
                  <label for="min_monthly_grade">Min. Sales Requirement (Monthly)</label>
                  <input class="form-control" id='monthlyRequirement' name="monthlyRequirement" value='<?=$monthlyRequirement;?>' type="number" readonly />
                </div>
                <div class="form-group">
                  <label for="minimumAmount">Min. New Player Deposit Amount (Monthly)</label>
                  <input class="form-control duit" id='minimumAmount' placeholder="Set minimum amount" value='<?php echo $minAmount;?>' name="minimumAmount" type="text" min='0' />
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="valuePercentage">Bonus Percentage (%)</label>
                      <input class="form-control" id='valuePercentage' placeholder="Set value percentage" value='<?php echo $valuePercentage;?>' name="valuePercentage" type="number" step='.05' min='0' max='100' />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="valueAmount">Value Amount (Rp.)</label>
                      <input class="form-control duit" id='valueAmount' name="valueAmount" value='<?php echo $valueAmount;?>' readonly type="text" min='0' />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="employeeBonus">Bonus Staff Amount</label>
                  <input class="form-control duit" id='employeeBonus' name="employeeBonus" value='<?php echo $employeeBonus;?>' readonly type="text" min='0' />
                </div>
                <div class="form-group">
                  <label for="totalDeposit">Total Deposit (Rp.)</label>
                  <input class="form-control duit" id='totalDeposit' name="totalDeposit" value='<?php echo $totalDeposit;?>' readonly type="text" min='0' />
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
  jQuery(".taskId").change(function(){
		jQuery.get(base_url+"/get_requirement/"+jQuery(this).val(), function(data, status){
			jQuery('.minRequirement').html(data);
		});
	});
  $('#valuePercentage, #minimumAmount').bind('keyup mouseup', function () {
      var minimumAmountVal=$('#minimumAmount');
      var monthlyRequirement=$('#monthlyRequirement').val();
      var minimumAmount=minimumAmountVal.val().split('.').join('');
      let result = Math.floor(parseInt($("#valuePercentage").val()*parseInt(minimumAmount/100))).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      let resultEmpBonus = Math.floor(parseInt($("#valuePercentage").val()*parseInt(minimumAmount/100)));
      let employeeBonus = Math.floor(resultEmpBonus*monthlyRequirement).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      let totalDeposit = Math.floor(minimumAmount*monthlyRequirement).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      $('#valueAmount').val(result || '');
      $('#employeeBonus').val(employeeBonus);
      $('#totalDeposit').val(totalDeposit);
	});
  // for money currency value with comma separated
	$('.duit').mask("#.##0", {reverse: true});
  /* Update data */
	$("#edit_kpi_sales").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=kpi_sales_update&form="+action,
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
						url : base_url+"/kpi_sales_list",
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
	});
})
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['kpi_sales_id']) && $_GET['data']=='view_kpi_sales_task' && $_GET['type']=='view_kpi_sales_task'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View KPI Sales</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="name">Main Task</label>
        <p><?php echo $jobTaskName;?></p>
      </div>
      <div class="form-group">
        <label for="minimumRequirement">Min. Sales Requirement (Monthly)</label>
        <p><?php echo $monthlyRequirement;?> x</p>
      </div>
      <div class="form-group">
        <label for="minimumAmount">Min. Sales Requirement (Monthly)</label>
        <p>Rp. <?php echo number_format($minAmount,0,',','.');?></p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="valuePercentage">Bonus Percentage</label>
            <p><?php echo $valuePercentage;?>%</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="valueAmount">Value Amount</label>
            <p>Rp. <?php echo number_format($valueAmount,0,',','.');?></p>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="employeeBonus">Bonus Staff Amount</label>
        <p>Rp. <?php echo number_format($employeeBonus,0,',','.');?></p>
      </div>
      <div class="form-group">
        <label for="totalDeposit">Total Deposit</label>
        <p>Rp. <?php echo number_format($totalDeposit,0,',','.');?></p>
      </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php }
?>
