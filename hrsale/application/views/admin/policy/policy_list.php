<?php
/* Policy view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?=$get_animate;?>">
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('258',$role_resources_ids)) {?>
<div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_policy');?> </h3>
      </div>
      <div class="box-body">
        <?php $attributes = array('name' => 'add_policy', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/policy/add_policy', $attributes, $hidden);?>
        <!-- <div class="form-group">
          <input type="hidden" name="user_id" value="<?=$session['user_id'];?>">
          <label for="company"><?=$this->lang->line('module_company_title');?></label>
          <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_select_company');?>..." name="company">
            <option value="0"><?=$this->lang->line('xin_all_companies');?></option>
            <?php foreach($all_companies as $company) {?>
            <option value="<?=$company->company_id;?>"> <?=$company->name;?></option>
            <?php } ?>
          </select>
        </div> -->
        <div class="form-group">
          <label for="title"><?=$this->lang->line('xin_title');?></label>
          <input type="text" class="form-control" name="title" placeholder="<?=$this->lang->line('xin_title');?>">
        </div>
        <div class="form-group">
          <label for="message"><?=$this->lang->line('xin_description');?></label>
          <textarea class="form-control" placeholder="<?=$this->lang->line('xin_description');?>" name="description" id="description"></textarea>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
        </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?=$colmdval;?>">
    <div class="box">
      <div class="box-header with-borsder">
        <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_policies');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th style="width:150px;"><?=$this->lang->line('xin_action');?></th>
                <th><?=$this->lang->line('xin_title');?></th>
                <!-- <th><?=$this->lang->line('module_company_title');?></th>
                <th><?=$this->lang->line('xin_created_at');?></th>
                <th><?=$this->lang->line('xin_added_by');?></th> -->
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>
