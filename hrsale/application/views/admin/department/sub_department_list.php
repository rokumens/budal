<?php
/* Sub Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row m-b-1 <?=$get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php if(in_array('240',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_hr_sub_department');?> </h3>
      </div>
      <div class="box-body">
        <?php $attributes = array('name' => 'add_sub_department', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/department/add_sub_department', $attributes, $hidden);?>
        <div class="form-group">
        <label for="name"><?=$this->lang->line('xin_name');?></label>
          <?php
			$data = array(
			  'name'        => 'department_name',
			  'id'          => 'department_name',
			  'value'       => '',
			  'placeholder'   => $this->lang->line('xin_name'),
			  'class'       => 'form-control',
			);
		echo form_input($data);
		?>
        </div>
        <div class="form-group">
          <label for="designation"><?=$this->lang->line('xin_hr_main_department');?></label>
          <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_department');?>" name="department_id">
            <option value=""></option>
            <?php foreach($all_departments as $deparment) {?>
            <option value="<?=$deparment->department_id;?>"><?=$deparment->department_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-actions box-footer"> <?=form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?=$colmdval;?>">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_hr_sub_departments');?> </h3>
        <?php if($userRole==1): #superAdmin?>
        <div class="box-tools pull-right">
          <a class="text-dark" href="<?=site_url('admin/department/sub_departments_deleted');?>" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-trash"></span> Show Deleted</button>
          </a>
        </div>
        <?php endif;?>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?=$this->lang->line('xin_action');?></th>
                <th><?=$this->lang->line('xin_name');?></th>
                <th><?=$this->lang->line('xin_hr_main_department');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
