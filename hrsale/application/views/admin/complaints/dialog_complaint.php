<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['complaint_id']) && $_GET['data']=='complaint'){
	$assigned_ids = explode(',',$complaint_against);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_edit_complaint');?></h4>
</div>
<?php $attributes = array('name' => 'edit_complaint', 'id' => 'edit_complaint', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $complaint_id, 'ext_name' => $complaint_id);?>
<?=form_open('admin/complaints/update/'.$complaint_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name"><?=$this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?=$company->company_id?>" <?php if($company->company_id==$company_id):?> selected <?php endif; ?>><?=$company->name?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group" id="employee_ajx">
					<?php
					# luffy 1 January 2020 05:08 pm
					// $result = $this->Department_model->ajax_company_employee_info($company_id);
					$result = $this->Employees_model->employeeActiveAPG()->result();?>
          <label for="employee"><?=$this->lang->line('xin_complaint_from');?></label>
          <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
            <option value=""></option>
            <?php foreach($result as $employee) {?>
            <option value="<?=$employee->user_id;?>" <?php if($employee->user_id==$complaint_from):?> selected="selected"<?php endif;?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title"><?=$this->lang->line('xin_complaint_title');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_complaint_title');?>" name="title" type="text" value="<?=$title;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="complaint_date"><?=$this->lang->line('xin_complaint_date');?></label>
              <input class="form-control d_date" placeholder="<?=$this->lang->line('xin_complaint_date');?>" readonly name="complaint_date" type="text" value="<?=$complaint_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" id="complaint_employee_ajx">
              <?php
							#$cresult = $this->Department_model->ajax_company_employee_info($company_id);
							$cresult = $this->Employees_model->employeeActiveAPG()->result();?>
              <label for="complaint_against"><?=$this->lang->line('xin_complaint_against');?></label>
              <select multiple class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_complaint_employees');?>" name="complaint_against[]">
                <option value=""></option>
                <?php foreach($cresult as $employee) {?>
                <option value="<?=$employee->user_id;?>" <?php if(in_array($employee->user_id,$assigned_ids)):?> selected
								<?php endif; ?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
				<div class="row">
		      <div class="col-md-12">
		        <div class="form-group">
		          <label for="status"><?=$this->lang->line('dashboard_xin_status');?></label>
		          <select name="status" id="select2-demo-6" class="form-control selectStatus" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_xin_status');?>">
		            <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?=$this->lang->line('xin_pending');?></option>
		            <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?=$this->lang->line('xin_accepted');?></option>
		            <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?=$this->lang->line('xin_rejected');?></option>
		            <option value="4" <?php if($status=='4'):?> selected <?php endif; ?>><?=$this->lang->line('xin_solved');?></option>
		          </select>
		        </div>
		      </div>
		    </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?=$this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="Complaint about..." name="description" id="description2"><?=$description;?></textarea>
        </div>
				<?php $status==4?$display='display:block;':$display='display:none;'; // status: solved?>
				<div class="form-group divCompanyResponse" style='<?=$display;?>'>
					<label for="company_response">Company Response</label>
					<textarea class="form-control textarea" placeholder="Company Response" name="company_response"><?=$companyResponse;?></textarea>
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
		$('#description2').trumbowyg();
		$('#compResponseTextarea').trumbowyg();
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
			jQuery.get(base_url+"/get_complaint_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#complaint_employee_ajx').html(data);
			});
		});
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		$('.d_date').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd',
			yearRange: '1900:' + (new Date().getFullYear() + 10),
			beforeShow: function(input) {
				$(input).datepicker("widget").show();
			}
		});
		$(document).on("change",".selectStatus",function(){
			if($(this).val()==4){
				$('.divCompanyResponse').show('fast');
			}else{
				$('.divCompanyResponse').hide('fast');
			}
		});
		/* update */
		$("#edit_complaint").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=complaint&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?=site_url("admin/complaints/complaint_list") ?>",
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
					}
				}
			});
		});
	});
  </script>
<?php }elseif(isset($_GET['jd']) && isset($_GET['complaint_id']) && $_GET['data']=='view_complaint'){
	$assigned_ids = explode(',',$complaint_against);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_view_complaint');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?=$this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?=$company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_complaint_from');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($complaint_from==$employee->user_id):?>
            <?=$employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_complaint_title');?></th>
          <td style="display: table-cell;"><?=$title;?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_complaint_date');?></th>
          <td style="display: table-cell;"><?=$this->Xin_model->set_date_format($complaint_date);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_complaint_against');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if(in_array($employee->user_id,$assigned_ids)):?>
           <?=$employee->first_name.' '.$employee->last_name;?><br />
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?=html_entity_decode($description);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?=$complaintStatus;?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close();?>
<?php }?>
