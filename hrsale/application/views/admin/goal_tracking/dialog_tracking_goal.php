<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['tracking_id']) && $_GET['data']=='tracking'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_hr_edit_goal_title');?></h4>
</div>
<?php $attributes = array('name' => 'edit_goal', 'id' => 'edit_goal', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $tracking_id, 'ext_name' => $tracking_id);?>
<?=form_open('admin/goal_tracking/update_goal/'.$tracking_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
            <label for="company_name"><?=$this->lang->line('module_company_title');?></label>
            <select class="form-control" name="company" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('module_company_title');?>">
              <option value=""><?=$this->lang->line('xin_select_one');?></option>
              <?php foreach($all_companies as $company) {?>
              <option value="<?=$company->company_id;?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>> <?=$company->name;?></option>
              <?php } ?>
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="tracking_type"><?=$this->lang->line('xin_hr_goal_tracking_type_se');?></label>
              <select class="form-control" name="tracking_type" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_hr_goal_tracking_type_se');?>">
                <option value=""></option>
                <?php foreach($all_tracking_types as $tracking_type) {?>
                <option value="<?=$tracking_type->tracking_type_id?>" <?php if($tracking_type_id==$tracking_type->tracking_type_id):?> selected="selected" <?php endif;?>><?=$tracking_type->type_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="subject"><?=$this->lang->line('xin_subject');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_subject');?>" name="subject" type="text" value="<?=$subject;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="target_achiement"><?=$this->lang->line('xin_hr_target_achiement');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_hr_target_achiement');?>" name="target_achiement" type="text" value="<?=$target_achiement;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?=$this->lang->line('xin_start_date');?></label>
              <input class="form-control d_date" placeholder="<?=$this->lang->line('xin_start_date');?>" readonly="true" name="start_date" type="text" value="<?=$start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?=$this->lang->line('xin_end_date');?></label>
              <input class="form-control d_date" placeholder="<?=$this->lang->line('xin_end_date');?>" readonly="true" name="end_date" type="text" value="<?=$end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
            	<input type="hidden" id="progres_val" name="progres_val" value="<?=$goal_progress;?>">
              <label for="progress"><?=$this->lang->line('dashboard_xin_progress');?></label>
              <input type="text" id="range_grid">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="status"><?=$this->lang->line('dashboard_xin_status');?></label>
              <select name="status" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_status');?>...">
                <option value="0" <?php if($goal_status=='0'):?> selected <?php endif; ?>><?=$this->lang->line('xin_not_started');?></option>
                <option value="1" <?php if($goal_status=='1'):?> selected <?php endif; ?>><?=$this->lang->line('xin_in_progress');?></option>
                <option value="2" <?php if($goal_status=='2'):?> selected <?php endif; ?>><?=$this->lang->line('xin_completed');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?=$this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" id="description2"><?=$description;?></textarea>
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
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#description2').trumbowyg();
	$('.d_date').datepicker({
  	changeMonth: true,
  	changeYear: true,
  	dateFormat:'yy-mm-dd',
  	yearRange: '1900:' + (new Date().getFullYear() + 10),
  	beforeShow: function(input) {
  		$(input).datepicker("widget").show();
  	}
	});
	/* update */
	$("#edit_goal").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=tracking&form="+action,
			cache: false,
			success: function (JSON) {
				if(JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
  					"bDestroy": true,
  					"ajax": {
  						url : "<?=site_url("admin/goal_tracking/goal_tracking_list") ?>",
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
		from: '<?=$goal_progress;?>',
		grid: true,
		force_edges: true,
		onChange: function (data) {
			$('#progres_val').val(data.from);
		}
	});
});
</script>
<?php }elseif(isset($_GET['jd']) && isset($_GET['tracking_id']) && $_GET['data']=='view_tracking'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_hr_view_goal_title');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
   <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <th><?=$this->lang->line('module_company_title');?></th>
        <td style="display: table-cell;"><?php foreach($all_companies as $company) {?><?php if($company->company_id==$company_id):?> <?=$company->name?> <?php endif;?><?php } ?></td>
      </tr>
      <?php
	// get tracking type
		$type = $this->Goal_tracking_model->read_tracking_type_information($tracking_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type_name;
		} else {
			$itype = '--';
		}
	  ?>
      <tr>
        <th><?=$this->lang->line('xin_hr_goal_tracking_type_se');?></th>
        <td style="display: table-cell;"><?=$itype;?></td>
      </tr>
      <tr>
        <th><?=$this->lang->line('xin_subject');?></th>
        <td style="display: table-cell;"><?=$subject;?></td>
      </tr>
      <tr>
        <th><?=$this->lang->line('xin_hr_target_achiement');?></th>
        <td style="display: table-cell;"><?=$target_achiement;?></td>
      </tr>
      <tr>
        <th><?=$this->lang->line('xin_start_date');?></th>
        <td style="display: table-cell;"><?=$start_date;?></td>
      </tr>
      <tr>
        <th><?=$this->lang->line('xin_end_date');?></th>
        <td style="display: table-cell;"><?=$end_date;?></td>
      </tr>
      <?php
	  //project_progress
		if($goal_progress <= 20) {
			$progress_class = 'bg-danger';
		} else if($goal_progress > 20 && $goal_progress <= 50){
			$progress_class = 'bg-warning';
		} else if($goal_progress > 50 && $goal_progress <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		// progress
    # luffy 27 December 2019 05:46 pm
    // $pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').'</p><div class="progress"><div class="progress-bar '.$progress_class.' progress-sm" style="width: '.$goal_progress.'%;">'.$goal_progress.'%</div></div>';
    // $pbar = '<div class="progress"><div class="progress-bar '.$progress_class.' progress-sm" style="height:100%; width: '.$goal_progress.'  %;">'.$goal_progress.'%</div></div>';
    // jazz 7381 - 2020-08-02 16:40
    // change progress bar
    $pbar = "
      <div class='progress'>
        <div class='progress-bar $progress_class' role='progressbar' aria-valuenow='40'
        aria-valuemin='0' aria-valuemax='100' style='width:$goal_progress%'>
        $goal_progress %
        </div>
      </div>
    ";
		//$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$goal_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$goal_progress.'" max="100">'.$goal_progress.'%</progress>';
		?>
        <?php
		if($goal_status=='0'): $status = $this->lang->line('xin_not_started');
		elseif($goal_status=='1'): $status = $this->lang->line('xin_in_progress');
		else: $goal_status = $this->lang->line('xin_completed');
		endif; ?>
      <tr>
        <th><?=$this->lang->line('dashboard_xin_status');?></th>
        <td style="display: table-cell;"><?=$status;?></td>
      </tr>
      <tr>
        <th><?=$this->lang->line('dashboard_xin_progress');?></th>
        <td style="display: table-cell;"><?=$pbar;?></td>
      </tr>
      <tr>
        <th><?=$this->lang->line('xin_description');?></th>
        <td style="display: table-cell;"><?=html_entity_decode($description);?></td>
      </tr>
    </tbody>
  </table>
  </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close(); ?>
<?php }
?>
