<?php
/* Company view */
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('246',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_e_details_document');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_official_document', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open_multipart('admin/company/add_official_document', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="license_name"><?=$this->lang->line('xin_hr_official_license_name');?></label>
                <input class="form-control" placeholder="<?=$this->lang->line('xin_hr_official_license_name');?>" name="license_name" type="text">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="company_id"><?=$this->lang->line('left_company');?></label>
                    <select class="form-control" name="company_id" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?=$company->company_id?>"><?=$company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="expiry_date"><?=$this->lang->line('xin_expiry_date');?></label>
                    <input class="form-control date" placeholder="<?=$this->lang->line('xin_expiry_date');?>" name="expiry_date" type="text">
                  </div>
                </div>
                <div class="row" style="padding-top:15px;">
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="scan_file"><?=$this->lang->line('xin_hr_official_license_scan');?></label>
                        <input type="file" class="form-control-file" accept="image/png, image/jpg, image/jpeg, application/pdf" id="scan_file" name="scan_file">
                        <small><?=$this->lang->line('xin_company_file_type');?></small>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="license_number"><?=$this->lang->line('xin_hr_official_license_number');?></label>
                <input class="form-control" placeholder="<?=$this->lang->line('xin_hr_official_license_number');?>" name="license_number" type="text">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-3">
                    <label for="xin_gtax"><?=$this->lang->line('xin_hr_official_license_alarm');?> 1</label>
                    <input class="form-control" placeholder="" name="license_notification_1" type="number" />
                  </div>
                  <?#luffy start?>
                  <div class="col-md-9">
                    <label for="xin_gtax_satuan">&nbsp;</label>
                    <select class="form-control" name="license_notification_satuan_1" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_hr_official_license_alarm');?>">
                      <option value="days">Day</option>
                      <option value="weeks">Week</option>
                      <option value="months">Month</option>
                      <option value="years">Year</option>
                    </select>
                  </div>
                  <?#luffy end?>
                </div>
              </div>
              <?#luffy start?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-3">
                    <label for="xin_gtax"><?=$this->lang->line('xin_hr_official_license_alarm');?> 2</label>
                    <input class="form-control" placeholder="" name="license_notification_2" type="number" />
                  </div>
                  <div class="col-md-9">
                    <label for="xin_gtax_satuan">&nbsp;</label>
                    <select class="form-control" name="license_notification_satuan_2" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_hr_official_license_alarm');?>">
                      <option value="days">Day</option>
                      <option value="weeks">Week</option>
                      <option value="months">Month</option>
                      <option value="years">Year</option>
                    </select>
                  </div>
                </div>
              </div>
              <?#luffy end?>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
        </div>
        <?=form_close();?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_hr_official_documents');?> </h3>
    <?php if($userRole==1): #superAdmin?>
    <div class="box-tools pull-right">
      <a class="text-dark" href="<?=site_url('admin/company/official_documents_deleted');?>" aria-expanded="false">
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
            <th width="150px;"><?=$this->lang->line('xin_action');?></th>
            <!-- <th><?=$this->lang->line('left_company');?></th> -->
            <th>License Name</th>
            <th>Lisense <?=$this->lang->line('xin_hr_license_number');?></th>
            <th><?=$this->lang->line('xin_expiry_date');?></th>
            <!-- <th><?=$this->lang->line('header_notifications');?> 1</th>
            <th><?=$this->lang->line('header_notifications');?> 2</th> -->
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
