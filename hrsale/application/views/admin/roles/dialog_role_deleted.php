<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['role_id']) && $_GET['data']=='role'){
$role_resources_ids = explode(',',$role_resources);
?>
<div class="modal-header">
  <?=form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
  <h4 class="modal-title" id="edit-modal-data-restore"><?=$this->lang->line('xin_role_editrole');?></h4>
</div>
<?php $attributes = array('name' => 'edit_role', 'id' => 'edit_role', 'autocomplete' => 'off','class' => '"m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'ext_name' => $role_name, '_token' => $role_id);?>
<?=form_open('admin/roles/update/'.$role_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_name"><?=$this->lang->line('xin_role_name');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_role_name');?>" name="role_name" type="text" value="<?=$role_name;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="first_name"><?=$this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?=$company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>><?=$company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
        	<input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_access"><?=$this->lang->line('xin_role_access');?></label>
              <select class="form-control custom-select" id="role_access_modal" name="role_access" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_role_access');?>">
                <option value="">&nbsp;</option>
                <option value="1" <?php if($role_access==1):?> selected="selected" <?php endif;?>><?=$this->lang->line('xin_role_all_menu');?></option>
                <option value="2" <?php if($role_access==2):?> selected="selected" <?php endif;?>><?=$this->lang->line('xin_role_cmenu');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="resources"><?=$this->lang->line('xin_role_resource');?></label>
              <div id="all_resources">
                <div class="demo-section k-content">
                  <div>
                    <div id="treeview_m1"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div id="all_resources">
                <div class="demo-section k-content">
                  <div>
                    <div id="treeview_m2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?=form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_update'))); ?>
  </div>
<?=form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		 $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		  checkboxClass: 'icheckbox_minimal-blue',
		  radioClass   : 'iradio_minimal-blue'
		});
		/* update */
		$("#edit_role").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=role&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						// On page load: datatable
						var xin_table = $('#table_roles_deleted').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?=site_url("admin/roles/deleted") ?>",
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
						$('.edit-modal-data-restore').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	});
  </script>
<?php }?>
