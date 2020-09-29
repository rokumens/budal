<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['policy_id']) && $_GET['data']=='policy'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_edit_policy');?></h4>
</div>
<?php $attributes = array('name' => 'edit_policy', 'id' => 'edit_policy', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $policy_id, 'ext_name' => $title);?>
<?=form_open('admin/policy/update/'.$policy_id, $attributes, $hidden);?>
  <div class="modal-body">
    <!-- <div class="form-group">
      <label for="company"><?=$this->lang->line('module_company_title');?></label>
      <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_company');?>..." name="company">
        <option value="0"><?=$this->lang->line('xin_all_companies');?></option>
        <?php foreach($all_companies as $company) {?>
        <option value="<?=$company->company_id;?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>> <?=$company->name;?></option>
        <?php } ?>
      </select>
    </div> -->
    <div class="form-group">
      <label for="title"><?=$this->lang->line('xin_title');?></label>
      <input type="text" class="form-control" name="title" placeholder="<?=$this->lang->line('xin_title');?>" value="<?=$title;?>">
    </div>
    <div class="form-group">
      <label for="message"><?=$this->lang->line('xin_description');?></label>
      <textarea class="form-control" placeholder="<?=$this->lang->line('xin_description');?>" name="description" id="description2"><?=$description;?></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
  </div>
<?=form_close(); ?>
<!-- <link rel="stylesheet" href="<?=base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?=base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script> -->
<script type="text/javascript">
 $(document).ready(function(){
		// $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		// $('[data-plugin="select_hrm"]').select2({ width:'100%' });
		$('#description2').trumbowyg();
		$("#edit_policy").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=policy&form="+action,
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
							url : "<?=site_url("admin/policy/policy_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['policy_id']) && $_GET['data']=='view_policy'){ ?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_view_policy');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <!-- <tr>
          <th><?=$this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?=$company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr> -->
        <tr>
          <th><?=$this->lang->line('xin_title');?></th>
          <td style="display: table-cell;"><?=$title;?></td>
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
<?php }?>
