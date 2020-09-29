<?php
/* Files Manager list*/
$session = $this->session->userdata('username');
?>
<?php $file_setting = $this->Xin_model->read_file_setting_info(1);?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($user[0]->user_role_id==1){
	$all = 'department-file';
	$val = '0';
} else {
	if($file_setting[0]->is_enable_all_files=='yes'):
		$val = '0';
		$all = 'department-file';
	else:
		$val = $user[0]->department_id;
		$all = 'not-allowed';
	endif;
}
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?=$get_animate;?>">
  <div class="col-md-3">
    <div class="box">
      <input type="hidden" id="depval" value="<?=$val;?>" />
      <div class="box-header with-border">
        <h3 class="box-title"> <?=$this->lang->line('xin_departments');?> </h3>
      </div>
      <div class="list-group">
        <?php if($user[0]->user_role_id==1){?>
        <a class="list-group-item list-group-item-action nav-tabs-link department-file" href="javascript:void(0);" data-department-id="0" data-toggle="tab" aria-expanded="true" data-config="0"><?=$this->lang->line('xin_all_departments');?></a>
        <?php } ?>
        <?php foreach($all_departments as $department):?>
	        <?php if($user[0]->user_role_id==1){?>
	        	<a class="list-group-item list-group-item-action nav-tabs-link department-file" href="javascript:void(0);" data-toggle="tab" aria-expanded="true" data-department-id="<?=$department->department_id;?>" data-config="<?=$department->department_id;?>"><?=$department->department_name;?></a>
	        <?php } else {?>
		        <?php
				  	if($user[0]->department_id==$department->department_id){
							$dep_all = 'department-file';
						} else {
							if($file_setting[0]->is_enable_all_files=='yes'):
								$dep_all = 'department-file';
							else:
								$dep_all = 'not-allowed';
							endif;
						}
					  ?>
		        <a class="list-group-item list-group-item-action nav-tabs-link <?=$dep_all;?>" href="javascript:void(0);" data-toggle="tab" aria-expanded="true" data-department-id="<?=$department->department_id;?>" data-config="<?=$department->department_id;?>"><?=$department->department_name;?></a>
	        <?php } ?>
        <?php endforeach;?>
      </div>
    </div>
  </div>
  <div class="col-md-9 <?=$get_animate;?>">
    <div class="box mb-4">
      <div class="box-header with-border">
        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_files');?> </h3>
      </div>
      <div class="box-body">
        <?php //if($user[0]->user_role_id==1){?>
        <div role="tabpanel" class="tab-all-files tab-pane animated fadeInRight active" id="all_files">
          <div class="box-block bg-white">
            <?php $attributes = array('name' => 'add_files', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?=form_open_multipart('admin/files/add_files', $attributes, $hidden);?>
            <div class="row">
              <?php if($user[0]->user_role_id==1){?>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="department_id"><?=$this->lang->line('left_department');?></label>
                  <select name="department_id" id="department_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_department');?>">
                    <option value=""></option>
                    <?php foreach($all_departments as $department) {?>
                    <option value="<?=$department->department_id;?>"> <?=$department->department_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } else { ?>
              <input type="hidden" name="department_id" id="department_id" value="<?=$user[0]->department_id;?>" />
              <?php } ?>
              <div class="col-md-4">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="name">File Name</label>
                    <input type="text" name="name" class="form-control" placeholder="set name for your file" />
                  </fieldset>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="logo"><?=$this->lang->line('xin_e_details_document_file');?></label>
                    <input type="file" name="xin_file" id="xin_file">
                    <br />
                    <small><?=$this->lang->line('xin_upload_file_only_for_resume');?> <?=$file_setting[0]->allowed_extensions;?></small>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions" style="float:left;padding:24px 0 24px !important;">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
            <?=form_close(); ?> </div>
        </div>
      </div>
      <!-- tab -->
    </div>
    <div class="box <?=$get_animate;?>">
      <div class="box-header with-border">
        <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_files');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table_files">
            <thead>
              <tr>
                <th style="width:100px;"><?=$this->lang->line('xin_action');?></th>
                <th><?=$this->lang->line('xin_single_file');?></th>
                <th><?=$this->lang->line('left_department');?></th>
                <th><?=$this->lang->line('xin_single_size');?></th>
                <!-- <th><?=$this->lang->line('xin_extension');?></th>
                <th><?=$this->lang->line('xin_uploaded_date');?></th> -->
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.not-allowed { display:none; }
</style>
