<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['transfer_id']) && $_GET['data']=='transfer'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_edit_transfer');?></h4>
</div>
<?php $attributes = array('name' => 'edit_transfer', 'id' => 'edit_transfer', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $transfer_id, 'ext_name' => $employee_id);?>
<?=form_open('admin/transfers/update/'.$transfer_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name"><?=$this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?=$company->company_id;?>" <?php if($company_id==$company->company_id):?> selected <?php endif;?>> <?=$company->name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group" id="employee_ajx">
          <label for="employee"><?=$this->lang->line('xin_employee_transfer');?></label>
          <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
            <option value=""></option>
            <?php foreach($all_employees as $employee) {?>
            <option value="<?=$employee->user_id;?>" <?php if($employee->user_id==$employee_id):?> selected="selected"<?php endif;?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="transfer_date"><?=$this->lang->line('xin_transfer_date');?></label>
              <input class="form-control edate" placeholder="<?=$this->lang->line('xin_transfer_date');?>" readonly name="transfer_date" type="text" value="<?=$transfer_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" id="department_ajx">
              <?php $cresult = $this->Company_model->ajax_company_departments_info($company_id);?>
              <label for="transfer_department"><?=$this->lang->line('xin_transfer_to_department');?></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_department');?>" name="transfer_department">
                <option value=""></option>
                <?php foreach($cresult as $department) {?>
                <option value="<?=$department->department_id?>" <?php if($department->department_id==$transfer_department):?> selected="selected"<?php endif;?>><?=$department->department_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" id="location_ajx">
              <?php $lresult = $this->Department_model->ajax_location_information($company_id);?>
              <label for="transfer_location"><?=$this->lang->line('xin_transfer_to_location');?></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_transfer_select_location');?>" name="transfer_location">
                <option value=""></option>
                <?php foreach($lresult as $location) {?>
                <option value="<?=$location->location_id?>" <?php if($location->location_id==$transfer_location):?> selected="selected"<?php endif;?>><?=$location->location_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="status"><?=$this->lang->line('dashboard_xin_status');?></label>
              <select name="status" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_status');?>">
                <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?=$this->lang->line('xin_pending');?></option>
                <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?=$this->lang->line('xin_accepted');?></option>
                <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?=$this->lang->line('xin_rejected');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?=$this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="30" rows="10" id="description2"><?=$description;?></textarea>
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
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
				jQuery('#department_ajx').html(data);
			});
			jQuery.get(base_url+"/get_locations/"+jQuery(this).val(), function(data, status){
				jQuery('#location_ajx').html(data);
			});
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
		});
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		$('#description2').trumbowyg();
		$('.edate').datepicker({
  		changeMonth: true,
  		changeYear: true,
  		dateFormat:'yy-mm-dd',
  		yearRange: '1900:' + (new Date().getFullYear() + 15),
  		beforeShow: function(input) {
  			$(input).datepicker("widget").show();
  		}
		});
		/* update */
		$("#edit_transfer").submit(function(e){
		  e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=transfer&form="+action,
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
							url : "<?=site_url("admin/transfers/transfer_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['transfer_id']) && $_GET['data']=='view_transfer'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_view_transfer');?></h4>
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
          <th><?=$this->lang->line('xin_employee_transfer');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($employee_id==$employee->user_id):?>
            <?=$employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_transfer_date');?></th>
          <td style="display: table-cell;"><?=$this->Xin_model->set_date_format($transfer_date);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_transfer_to_department');?></th>
          <td style="display: table-cell;"><?php foreach($all_departments as $department) {?>
            <?php if($transfer_department==$department->department_id):?>
            <?=$department->department_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_transfer_to_location');?></th>
          <td style="display: table-cell;"><?php foreach($all_locations as $location) {?>
            <?php if($transfer_location==$location->location_id):?>
            <?=$location->location_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php if($status=='0'): $t_status = $this->lang->line('xin_pending');?>
            <?php endif; ?>
            <?php if($status=='1'): $t_status = $this->lang->line('xin_accepted');?>
            <?php endif; ?>
            <?php if($status=='2'): $t_status = $this->lang->line('xin_rejected');?>
            <?php endif; ?>
            <?=$t_status;?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?=html_entity_decode($description);?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close(); ?>
<?php }
?>
