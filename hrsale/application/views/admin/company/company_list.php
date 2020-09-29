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
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('module_company_title');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_company', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open_multipart('admin/company/add_company', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name"><?=$this->lang->line('xin_company_name');?></label>
                <input class="form-control" placeholder="<?=$this->lang->line('xin_company_name');?>" name="name" type="text">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?=$this->lang->line('xin_company_type');?></label>
                    <select class="form-control" name="company_type" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_company_type');?>">
                      <option value=""><?=$this->lang->line('xin_select_one');?></option>
                      <?php foreach($get_company_types as $ctype) {?>
                      <option value="<?=$ctype->type_id;?>"> <?=$ctype->name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="trading_name"><?=$this->lang->line('xin_company_trading');?></label>
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_company_trading');?>" name="trading_name" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="registration_no"><?=$this->lang->line('xin_company_registration');?></label>
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_company_registration');?>" name="registration_no" type="text">
                  </div>
                  <div class="col-md-6">
                    <label for="contact_number"><?=$this->lang->line('xin_contact_number');?></label>
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_contact_number');?>" name="contact_number" type="number">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="email"><?=$this->lang->line('xin_email');?></label>
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_email');?>" name="email" type="email">
                  </div>
                  <div class="col-md-6">
                    <label for="website"><?=$this->lang->line('xin_website');?></label>
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_website_url');?>" name="website" type="text">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="xin_gtax"><?=$this->lang->line('xin_gtax');?></label>
                <input class="form-control" placeholder="<?=$this->lang->line('xin_gtax');?>" name="xin_gtax" type="text">
              </div>
              <div class="form-group">
                <label for="address"><?=$this->lang->line('xin_address');?></label>
                <input class="form-control" placeholder="<?=$this->lang->line('xin_address_1');?>" name="address_1" type="text">
                <br>
                <input class="form-control" placeholder="<?=$this->lang->line('xin_address_2');?>" name="address_2" type="text">
                <br>
                <div class="row">
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_city');?>" name="city" type="text">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_state');?>" name="state" type="text">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?=$this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                  </div>
                </div>
                <br>
                <select class="form-control" name="country" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_country');?>">
                  <option value=""><?=$this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?=$country->country_id;?>"> <?=$country->country_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="email"><?=$this->lang->line('dashboard_username');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('dashboard_username');?>" name="username" type="text">
            </div>
            <div class="col-md-3">
              <label for="website"><?=$this->lang->line('xin_employee_password');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_employee_password');?>" name="password" type="text">
            </div>
            <div class="col-md-6">
              <fieldset class="form-group">
                <label for="logo"><?=$this->lang->line('xin_company_logo');?></label>
                <input type="file" class="form-control-file" id="logo" name="logo">
                <small><?=$this->lang->line('xin_company_file_type');?></small>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
        </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_companies');?> </h3>
    <?php if($userRole==1): #superAdmin?>
    <div class="box-tools pull-right">
      <a class="text-dark" href="<?=site_url('admin/company/deleted');?>" aria-expanded="false">
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
            <th><?=$this->lang->line('module_company_title');?></th>
            <th><?=$this->lang->line('xin_email');?></th>
            <th><?=$this->lang->line('xin_website');?></th>
            <th><?=$this->lang->line('xin_city');?></th>
            <th><?=$this->lang->line('xin_country');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
