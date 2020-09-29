<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row <?=$get_animate;?>">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?=$this->lang->line('xin_not_started');?></span> <span class="info-box-number"><?=$this->Project_model->not_started_projects(); ?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?=$this->lang->line('xin_in_progress');?></span> <span class="info-box-number"><?=$this->Project_model->inprogress_projects();?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?=$this->lang->line('xin_completed');?></span> <span class="info-box-number"><?=$this->Project_model->complete_projects(); ?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?=$this->lang->line('xin_deffered');?></span> <span class="info-box-number"><?=$this->Project_model->deffered_projects(); ?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('315',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('xin_add_new');?> <?=$this->lang->line('xin_project');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_project', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/project/add_project', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="title"><?=$this->lang->line('xin_title');?></label>
                  <input class="form-control" placeholder="<?=$this->lang->line('xin_title');?>" name="title" type="text">
                </div>
                <div class="row">
                  <!-- luffy <div class="col-md-6">
                    <div class="form-group">
                      <label for="client_id"><?=$this->lang->line('xin_client_name');?></label>
                      <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_client_name');?>">
                        <option value=""></option>
                        <?php foreach($all_clients as $client) {?>
                        <option value="<?=$client->client_id;?>"> <?=$client->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div> -->
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="company_id"><?=$this->lang->line('module_company_title');?></label>
                      <select name="company_id" id="aj_company" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('module_company_title');?>">
                        <option value=""></option>
                        <?php foreach($all_companies as $company) {?>
                        <option value="<?=$company->company_id;?>"> <?=$company->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?=$this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_start_date');?>" readonly name="start_date" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?=$this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?=$this->lang->line('xin_end_date');?>" readonly name="end_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="employee"><?=$this->lang->line('xin_p_priority');?></label>
                      <select name="priority" id="select2-demo-6" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_p_priority');?>">
                        <option value="1"><?=$this->lang->line('xin_highest');?></option>
                        <option value="2"><?=$this->lang->line('xin_high');?></option>
                        <option value="3"><?=$this->lang->line('xin_normal');?></option>
                        <option value="4"><?=$this->lang->line('xin_low');?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?=$this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?=$this->lang->line('xin_project_manager');?></label>
                  <select multiple name="assigned_to[]" id="select2-demo-6" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_project_manager');?>">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="summary"><?=$this->lang->line('xin_summary');?></label>
                  <textarea class="form-control" placeholder="<?=$this->lang->line('xin_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?=form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('xin_projects');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <!-- luffy 2 January 2020 12:25 pm -->
            <th>Project Title</th>
            <th>Summary</th>
            <!-- <?php #if(!in_array('386',$role_resources_ids)) {?>
            <th><?php #echo $this->lang->line('xin_project_client');?></th>
            <?php #} ?> -->
            <th><?=$this->lang->line('xin_p_priority');?></th>
            <th><?=$this->lang->line('xin_p_enddate');?></th>
            <th><?=$this->lang->line('dashboard_xin_progress');?></th>
            <th>Project Manager(s)</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
