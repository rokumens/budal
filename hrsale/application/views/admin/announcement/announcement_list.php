<?php
/* Announcement view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('254',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_announcement');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_announcement', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/announcement/add_announcement', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="title"><?=$this->lang->line('xin_title');?></label>
                <input class="form-control" placeholder="<?=$this->lang->line('xin_title');?>" name="title" type="text" value="">
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="start_date"><?=$this->lang->line('xin_start_date');?></label>
                    <input class="form-control date" placeholder="<?=$this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="end_date"><?=$this->lang->line('xin_end_date');?></label>
                    <input class="form-control date" placeholder="<?=$this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="designation" class="control-label"><?=$this->lang->line('module_company_title');?></label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('module_company_title');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?=$company->company_id?>"><?=$company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group" id="department_ajax">
                    <label for="department" class="control-label"><?=$this->lang->line('xin_department');?></label>
                    <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_department');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="description"><?=$this->lang->line('xin_description');?></label>
                <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="8" rows="6" id="description"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="summary"><?=$this->lang->line('xin_summary');?></label>
            <textarea class="form-control" placeholder="<?=$this->lang->line('xin_summary');?>" name="summary" cols="30" rows="3" id="summary"></textarea>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
          </div>
          <?=form_close(); ?> </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_announcements');?> </h3>
    <?php if($userRole==1): #superAdmin?>
    <div class="box-tools pull-right">
      <a class="text-dark" href="<?=site_url('admin/announcement/deleted');?>" aria-expanded="false">
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
            <th style='width:150px;'><?=$this->lang->line('xin_action');?></th>
            <th><?=$this->lang->line('xin_title');?></th>
            <th><?=$this->lang->line('xin_summary');?></th>
            <th><?=$this->lang->line('xin_published_for');?></th>
            <th><?=$this->lang->line('xin_start_date');?></th>
            <th><?=$this->lang->line('xin_end_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">var announcement_url = '<?=site_url("announcement") ?>';</script>
