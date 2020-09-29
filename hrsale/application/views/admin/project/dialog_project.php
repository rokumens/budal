<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['project_id']) && $_GET['data']=='view_project'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_view');?> <?=$this->lang->line('xin_project');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <?php
    	 	if($project_progress <= 20) {
    			$progress_class = 'progress-danger';
    			$txt_class = 'text-danger';
    		}elseif($project_progress > 20 && $project_progress <= 50){
    			$progress_class = 'progress-warning';
    			$txt_class = 'text-warning';
    		}elseif($project_progress > 50 && $project_progress <= 75){
    			$progress_class = 'progress-info';
    			$txt_class = 'text-info';
    		} else {
    			$progress_class = 'progress-success';
    			$txt_class = 'text-success';
    		}
    		?>
        <tr>
          <th><?=$this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?=$company->name;?>
            <?php endif;?>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_title');?></th>
          <td style="display: table-cell;"><?=$title;?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_client_name');?></th>
          <td style="display: table-cell;"><?=$client_name;?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_start_date');?></th>
          <td style="display: table-cell;"><?=$this->Xin_model->set_date_format($start_date);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_end_date');?></th>
          <td style="display: table-cell;"><?=$this->Xin_model->set_date_format($end_date);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('dashboard_xin_progress');?></th>
          <td style="display: table-cell;"><?=$this->lang->line('xin_completed').' '.$project_progress;?>%</td>
        </tr>
        <?php if($status=='0'):?> <?php $projectStatus = $this->lang->line('xin_not_started');?> <?php endif; ?>
        <?php if($status=='1'):?> <?php $projectStatus = $this->lang->line('xin_in_progress');?> <?php endif; ?>
        <?php if($status=='2'):?> <?php $projectStatus = $this->lang->line('xin_completed');?> <?php endif; ?>
        <?php if($status=='3'):?> <?php $projectStatus = $this->lang->line('xin_deffered');?> <?php endif; ?>
        <tr>
          <th><?=$this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?=$projectStatus;?></td>
        </tr>
        <?php if($priority==1):?> <?php $projectPriority = $this->lang->line('xin_highest');?> <?php endif;?>
        <?php if($priority==2):?> <?php $projectPriority = $this->lang->line('xin_high');?> <?php endif;?>
        <?php if($priority==3):?> <?php $projectPriority = $this->lang->line('xin_normal');?> <?php endif;?>
        <?php if($priority==4):?> <?php $projectPriority = $this->lang->line('xin_low');?> <?php endif;?>
        <tr>
          <th><?=$this->lang->line('xin_p_priority');?></th>
          <td style="display: table-cell;"><?=$projectPriority;?></td>
        </tr>
        <?php
        # luffy 2 January 2020 01:21 pm
        // $result = $this->Department_model->ajax_company_employee_info($company_id);
        $result = $this->Employees_model->employeeActiveAPG();
        ?>
        <?php $assigned_ids = explode(',',$assigned_to); ?>
        <tr>
          <th><?=$this->lang->line('xin_project_manager');?></th>
          <td style="display: table-cell;"><ol><?php foreach($result as $employee) {?><?php if(isset($_GET)) { if(in_array($employee->user_id,$assigned_ids)):?> <li><?=$employee->first_name.' '.$employee->last_name;?></li> <?php endif; } } ?></ol></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_description');?></th>
          <td style="display: table-cell;">
          <?php if(str_word_count($description) > 65) { ?>
		         <div style="overflow:auto; height:200px;"><?=html_entity_decode($description);?></div>
          <?php } else { ?> <?=html_entity_decode($description);?> <?php } ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close(); ?>
<?php }elseif(isset($_GET['jd']) && isset($_GET['project_id']) && $_GET['data']=='project'){
	$assigned_ids = explode(',',$assigned_to);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_edit_project');?></h4>
</div>
<?php $attributes = array('name' => 'edit_project', 'id' => 'edit_project', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $project_id, 'ext_name' => $title);?>
<?=form_open('admin/project/update/'.$project_id, $attributes, $hidden);?>
  <div class="modal-body">
     <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="title"><?=$this->lang->line('xin_title');?></label>
            <input class="form-control" placeholder="<?=$this->lang->line('xin_title');?>" name="title" type="text" value="<?=$title;?>">
          </div>
          <div class="row">
            <!-- luffy
            <div class="col-md-6">
              <div class="form-group">
                <label for="client_name"><?=$this->lang->line('xin_client_name');?></label>
                <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_client_name');?>">
                <option value=""></option>
                <?php foreach($all_clients as $client) {?>
                <option value="<?=$client->client_id;?>" <?php if($client_id == $client->client_id):?> selected="selected" <?php endif;?>> <?=$client->name;?></option>
                <?php } ?>
              </select>
              </div>
            </div> -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="award_date"><?=$this->lang->line('module_company_title');?></label>
                <select name="company_id" id="ajx_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('module_company_title');?>">
                  <option value=""></option>
                  <?php foreach($all_companies as $company) {?>
                  <option value="<?=$company->company_id;?>" <?php if($company->company_id==$company_id):?> selected="selected" <?php endif;?>> <?=$company->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="start_date"><?=$this->lang->line('xin_start_date');?></label>
                <input class="form-control edate" placeholder="<?=$this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="<?=$start_date;?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="end_date"><?=$this->lang->line('xin_end_date');?></label>
                <input class="form-control edate" placeholder="<?=$this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="<?=$end_date;?>">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="description"><?=$this->lang->line('xin_description');?></label>
            <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description2"><?=$description;?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group" id="employee_ajx">
           <?php
           # luffy 2 January 2020 01:24 pm
           // $result = $this->Department_model->ajax_company_employee_info($company_id);
           $result = $this->Employees_model->employeeActiveAPG()->result();
           ?>
            <label for="employee"><?=$this->lang->line('xin_project_manager');?></label>
            <select multiple name="assigned_to[]" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_project_manager');?>">
              <option value=""></option>
              <?php foreach($result as $employee) {?>
              <option value="<?=$employee->user_id?>" <?php if(isset($_GET)) { if(in_array($employee->user_id,$assigned_ids)):?> selected <?php endif; }?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
          <label for="status"><?=$this->lang->line('dashboard_xin_status');?></label>
          <select name="status" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_status');?>...">
            <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?=$this->lang->line('xin_not_started');?></option>
            <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?=$this->lang->line('xin_in_progress');?></option>
            <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?=$this->lang->line('xin_completed');?></option>
            <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?=$this->lang->line('xin_deffered');?></option>
          </select>
          <input type="hidden" id="progres_val" name="progres_val" value="<?=$project_progress;?>">
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="employee"><?=$this->lang->line('xin_p_priority');?></label>
            <select name="priority" id="select2-demo-6" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_p_priority');?>">
              <option value="1" <?php if($priority==1):?> selected="selected"<?php endif;?>><?=$this->lang->line('xin_highest');?></option>
              <option value="2" <?php if($priority==2):?> selected="selected"<?php endif;?>><?=$this->lang->line('xin_high');?></option>
              <option value="3" <?php if($priority==3):?> selected="selected"<?php endif;?>><?=$this->lang->line('xin_normal');?></option>
              <option value="4" <?php if($priority==4):?> selected="selected"<?php endif;?>><?=$this->lang->line('xin_low');?></option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="summary"><?=$this->lang->line('xin_summary');?></label>
            <textarea class="form-control" placeholder="<?=$this->lang->line('xin_summary');?>" name="summary" cols="30" rows="1" id="summary"><?=$summary;?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="progress"><?=$this->lang->line('dashboard_xin_progress');?></label>
            <input type="text" id="range_grid">
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
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	});
	$('#description2').trumbowyg();
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('.edate').datepicker({
  	changeMonth: true,
  	changeYear: true,
  	dateFormat:'yy-mm-dd',
  	yearRange: '1900:' + (new Date().getFullYear() + 10),
  	beforeShow: function(input) {
  		$(input).datepicker("widget").show();
  	}
	});
	/* update */
	$("#edit_project").submit(function(e){
	  e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=project&form="+action,
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
							url : "<?=site_url("admin/project/project_list") ?>",
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
				}
			}
		});
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#range_grid").ionRangeSlider({
		type: "single",
		min: 0,
		max: 100,
		from: '<?=$project_progress;?>',
		grid: true,
		force_edges: true,
		onChange: function (data) {
			$('#progres_val').val(data.from);
		}
	});
});
</script>
<?php }
?>
