<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['location_id']) && $_GET['data']=='location'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_edit_location');?></h4>
</div>
<?php $attributes = array('name' => 'edit_location', 'id' => 'edit_location', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $company_id, 'ext_name' => $location_name);?>
<?=form_open('admin/location/update/'.$location_id, $attributes, $hidden);?>
<div class="modal-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="company_name"><?=$this->lang->line('xin_edit_company');?></label>
          <select class="form-control" name="company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_edit_company');?>">
            <option value=""><?=$this->lang->line('xin_edit_company');?></option>
            <?php foreach($all_companies as $company) {?>
            <option value="<?=$company->company_id;?>" <?php if($company_id==$company->company_id):?> selected <?php endif;?>> <?=$company->name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="name"><?=$this->lang->line('xin_location_name');?></label>
          <input class="form-control" placeholder="<?=$this->lang->line('xin_location_name');?>" name="name" type="text" value="<?=$location_name;?>">
        </div>
        <!-- <div class="form-group">
          <label for="email"><?=$this->lang->line('xin_email');?></label>
          <input class="form-control" placeholder="<?=$this->lang->line('xin_email');?>" name="email" type="email" value="<?=$email;?>">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="phone"><?=$this->lang->line('xin_phone');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_phone');?>" name="phone" type="number" value="<?=$phone;?>">
            </div>
            <div class="col-md-6">
              <label for="xin_faxn"><?=$this->lang->line('xin_faxn');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_faxn');?>" name="fax" type="number" value="<?=$fax;?>">
            </div>
          </div>
        </div> -->
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="dns">DNS</label> <small class="form-text text-muted"> (Ask IT staff for DNS)</small>
          <input type="text" class="form-control" value="<?=$dns;?>" name="dns" placeholder="Domain Name System">
        </div>
        <div class="form-group">
          <label for="local_ip">Local IP</label> <small class="form-text text-muted"> (Ask IT staff for Local IP</small>
          <input type="text" class="form-control" value="<?=$local_ip;?>" name="local_ip" placeholder="Local IP">
          <small class="form-text text-muted">Backup if DNS down</small>
        </div>
        <div class="form-group">
          <label for="location_active">Status</label>
          <?=form_dropdown('location_active', $dropdown_status, $location_active, 'class="form-control" data-plugin="select_hrm"');?>
        </div>
        <!-- <div class="form-group" id="employee_ajx">
          <div class="row">
            <div class="col-md-12">
              <?php #$result = $this->Department_model->ajax_company_employee_info($company_id);?>
              <label for="email"><?=$this->lang->line('xin_view_locationh');?></label>
              <select class="form-control" name="location_head" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_view_locationh');?>">
                <option value=""><?=$this->lang->line('xin_select_one');?></option>
                <?php foreach($all_employees as $employee) {?>
                <option value="<?=$employee->user_id;?>" <?php if($location_head==$employee->user_id):?> selected <?php endif;?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div> -->
        <!-- <div class="form-group">
          <label for="address"><?=$this->lang->line('xin_address');?></label>
          <input class="form-control" placeholder="<?=$this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?=$address_1;?>">
          <br>
          <input class="form-control" placeholder="<?=$this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?=$address_2;?>">
          <br>
          <div class="row">
            <div class="col-xs-4">
              <input class="form-control" placeholder="<?=$this->lang->line('xin_city');?>" name="city" type="text" value="<?=$city;?>">
            </div>
            <div class="col-xs-4">
              <input class="form-control" placeholder="<?=$this->lang->line('xin_state');?>" name="state" type="text" value="<?=$state;?>">
            </div>
            <div class="col-xs-4">
              <input class="form-control" placeholder="<?=$this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?=$zipcode;?>">
            </div>
          </div>
          <br>
          <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_country');?>">
            <option value=""><?=$this->lang->line('xin_select_one');?></option>
            <?php foreach($all_countries as $country) {?>
            <option value="<?=$country->country_id;?>" <?php if($countryid==$country->country_id):?> selected <?php endif;?>> <?=$country->country_name;?></option>
            <?php } ?>
          </select>
        </div> -->
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary save"><?=$this->lang->line('xin_update');?></button>
  </div>
<?=form_close(); ?>
<link rel="stylesheet" href="<?=base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?=base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
		});

		/* update */
		$("#edit_location").submit(function(e){
		  e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=location&form="+action,
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
								url : "<?=site_url("admin/location/location_list") ?>",
								type : 'GET'
							},
              // luffy 8 January 2020 07:27 pm
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
<?php } else if(isset($_GET['jd']) && isset($_GET['location_id']) && $_GET['data']=='view_location'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_view_location');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?=$this->lang->line('module_company_title');?></th>
            <td style="display: table-cell;"><?php foreach($all_companies as $company) {?>
              <?php if($company_id==$company->company_id):?>
              <?=$company->name;?>
              <?php endif;?>
              <?php } ?></td>
          </tr>
          <tr>
            <th><?=$this->lang->line('xin_location_name');?></th>
            <td style="display: table-cell;"><?=$location_name;?></td>
          </tr>
          <tr>
            <th>DNS (Domain Name System)</th>
            <td style="display: table-cell;"><?=!empty($dns) ? $dns : '-';?></td>
          </tr>
          <tr>
            <th>Local IP</th>
            <td style="display: table-cell;"><?=!empty($local_ip) ? $local_ip : '-';?></td>
          </tr>
          <tr>
            <th>Status</th>
            <td style="display: table-cell;"><?=$location_active == 1 ? 'Active' : 'Not Active';?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close(); ?>
<?php }?>
