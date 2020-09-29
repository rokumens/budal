<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
$role_resources_ids = $this->Xin_model->user_role_resource();
?>
<div class="box-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header">
      <div class="widget-user-image">
        <?php if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
        <img src="<?php  echo base_url().'uploads/profile/'.$user[0]->profile_picture;?>" alt="" class="img-circle ui-w-50 rounded-circle" style='border-radius:10% !important;'>
        <?php } elseif(!empty($user[0]->profile_picture_sso)) {;?>
        <img src="<?=$user[0]->profile_picture_sso;?>" alt="" class="img-circle ui-w-50 rounded-circle">
        <?php } else {?>
        <?php  if($user[0]->gender=='Male') { ?>
        <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
        <?php } else { ?>
        <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
        <?php } ?>
        <img src="<?php  echo $profile['image']->url;?>" alt="" id="user_avatar" class="img-circle ui-w-50 rounded-circle">
        <?php  } ?>
      </div>
      <h4 class="widget-user-username welcome-hrsale-user">Welcome back, <?=$user[0]->username;?>!</h4>
      <h5 class="widget-user-desc welcome-hrsale-user-text">Today is <?=date('l, j F Y');?></h5>
    </div>
  </div>

 <!-- luffy start -->
 <!-- <?php $company_license = $this->Xin_model->company_license_expiry();
 if(count($company_license)):?>
 <div class="alert alert-warning alert-dismissible">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
     <h4><i class="icon fa fa-warning"></i> Warning!</h4>
 <?php foreach($company_license as $clicense):?>
    <?php $date=date_create($clicense->expiry_date);?>
<p>Document <strong><?=$clicense->license_name;?></strong> is going to expire soon on <?=date_format($date,"d F Y");?>.</p>
<?php endforeach;?>
<p><a href="<?=site_url('admin/company/official_documents');?>">Renewal now</a> &raquo;</p>
</div>
<?php endif;?> -->
<!-- luffy marked. <?php /* ini buat yg expired */$company_license_exp = $this->Xin_model->company_license_expired();?>
<?php if(count($company_license_exp)): foreach($company_license_exp as $clicense_exp):?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Expired!</h4>
    License <a href="<?=site_url('admin/company/official_documents');?>"><?=$clicense_exp->license_name;?></a> is expired.
  </div>
<?php endforeach;endif;?> -->
<!-- luffy end -->
<hr class="container-m--x mt-0 mb-4">
<?php if($theme[0]->statistics_cards=='4' || $theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<div class="row">
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/employees');?>"><i class="ft-arrow-up"></i><?=$this->Employees_model->get_total_employees();?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_people');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-building-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/company');?>"><i class="ft-arrow-up"></i><?=$this->Xin_model->get_all_companies();?></a></span> <span class="info-box-text"><?=$this->lang->line('module_company_title');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-purple"><i class="fa fa-calendar"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/timesheet/leave');?>"> <?=$this->lang->line('left_leave');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_performance_management');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-cog"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/settings');?>"> Kanon HRM</a></span> <span class="info-box-text"><?=$this->lang->line('left_settings');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<?php } ?>
<?php if($theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<div class="row">
  <?php if($system[0]->module_files=='true'){?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/files');?>"> <?=$this->lang->line('xin_e_details_document');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_performance_management');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php } else {?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="fa fa-plane"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/timesheet/holidays');?>"> <?=$this->lang->line('xin_view');?></a></span> <span class="info-box-text"><?=$this->lang->line('left_holidays');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>

  <?php } ?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-table"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/theme');?>"> <?=$this->lang->line('xin_theme_title');?></a></span> <span class="info-box-text"><?=$this->lang->line('left_settings');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/project');?>"><i class="ft-arrow-up"></i><?=$this->Xin_model->get_all_projects();?></a></span> <span class="info-box-text"><?=$this->lang->line('dashboard_projects');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>

    <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="fa fa-calendar-check-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/timesheet/tasks');?>"><i class="ft-arrow-up"></i><?=$this->Xin_model->get_all_tasks();?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_tasks');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>

  <?php } else {?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-list"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/designation');?>"> <?=$this->lang->line('left_designation');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>

    <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="fa fa-calendar-plus-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/timesheet/office_shift');?>"> <?=$this->lang->line('left_office_shifts');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php } ?>
</div>
<?php } ?>
<?php if($theme[0]->statistics_cards=='12'){?>
<div class="row">
  <?php if($system[0]->module_training=='true'){?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-graduation-cap"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/training');?>"><i class="ft-arrow-up"></i><?=$this->lang->line('xin_performance_management');?></a></span> <span class="info-box-text"><?=$this->lang->line('left_training');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php } else {?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="fa fa-life-ring"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/settings/modules');?>"><i class="ft-arrow-up"></i><?=$this->lang->line('xin_modules');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_setup');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php }?>
  <?php if($system[0]->module_travel=='true'){?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-plane"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/travel');?>"> <?=$this->lang->line('xin_requests');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_travel');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php } else {?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-calendar-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/timesheet/attendance');?>"> <?=$this->lang->line('dashboard_attendance');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php } ?>
  <?php if($system[0]->module_inquiry=='true'){?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="fa fa-tags"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/tickets');?>"> <?=$this->Xin_model->get_all_tickets();?></a></span> <span class="info-box-text"><?=$this->lang->line('left_tickets');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php } else {?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="fa fa-building-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/department');?>"> <?=$this->lang->line('left_department');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <?php } ?>
  <div class="col-xl-3 col-md-3 col-12">
    <div class="info-box"> <span class="info-box-icon bg-light-blue"><i class="fa fa-lock"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/roles');?>"> <?=$this->lang->line('xin_roles');?></a></span> <span class="info-box-text"><?=$this->lang->line('xin_permission');?></span> </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>
<?php } ?>
<hr class="container-m--x mt-0 mb-4">
<?php #if(in_array('95',$role_resources_ids)) {?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<?php #}?>
<hr class="container-m--x mt-0 mb-4">
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$this->lang->line('xin_employee_department_txt');?></h3>
            </div>
            <div class="box-body">
              <div class="box-block">
                <div class="col-md-7">
                  <div class="overflow-scrolls" style="overflow:auto; height:200px;">
                    <div class="table-responsive">
                      <table class="table mb-0 table-dashboard">
                        <tbody>
                          <?php $c_color = array('#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC');?>
                          <?php $j=0;foreach($this->Department_model->all_departments() as $department) { ?>
                          <?php
                            // luffy - 11 December 2019 0401 pm
          									$condition = "department_id = $department->department_id AND is_active=1 AND deleted_at IS NULL AND fingerprint_location != 0";
          									$this->db->select('*');
          									$this->db->from('xin_employees');
          									$this->db->where($condition);
          									$query = $this->db->get();
          									// check if department available
          									if($query->num_rows() > 0) {
          								?>
                          <tr>
                            <td><div style="width:4px;border:5px solid <?=$c_color[$j];?>;"></div></td>
                            <td><?=htmlspecialchars_decode($department->department_name);?> (<?=$query->num_rows();?>)</td>
                          </tr>
                          <?php $j++; } ?>
                          <?php  } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>
                <div class="col-md-5">
                <canvas id="employee_department" height="200" width="" style="display: block;  height: 200px;"></canvas>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$this->lang->line('xin_employee_designation_txt');?></h3>
            </div>
            <div class="box-body">
                <div class="box-block">
                  <div class="col-md-7">
                    <div class="overflow-scrolls" style="overflow:auto; height:200px;">
                      <div class="table-responsive">
                        <table class="table mb-0 table-dashboard">
                          <tbody>
                            <?php $c_color2 =  array('#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976 A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED');?>
                            <?php $k=0;foreach($this->Designation_model->all_designations() as $designation) { ?>
                            <?php
            									// luffy - 11 December 2019 0403 pm
            									$condition1 = "designation_id = $designation->designation_id AND is_active=1 AND deleted_at IS NULL AND fingerprint_location != 0";
            									$this->db->select('*');
            									$this->db->from('xin_employees');
            									$this->db->where($condition1);
            									$query1 = $this->db->get();
            									// check if department available
            									if ($query1->num_rows() > 0) {
            								?>
                            <tr>
                              <td><div style="width:4px;border:5px solid <?=$c_color2[$k];?>;"></div></td>
                              <td><?=htmlspecialchars_decode($designation->designation_name);?> (<?=$query1->num_rows();?>)</td>
                            </tr>
                            <?php $k++; } ?>
                            <?php  } ?>
                          </tbody>
                      </table>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-5">
                  <canvas id="employee_designation" height="200" width="" style="display: block; height: 200px;"></canvas>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="container-m--x mt-0 mb-4">
<div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?=$this->lang->line('xin_hr_attendance_status_today');?></h3>
        </div>
        <div class="box-body">
          <div class="box-block">
          <div class="row">
          	<div class="col-md-5">
              <div class="overflow-scrolls">
                <div class="table-responsive">
                  <?php
        						$current_month = date('Y-m-d');
        						$working = $this->Xin_model->current_month_day_attendance($current_month);
        						$query = $this->Xin_model->all_employees_status();
        						$total = $query->num_rows();
        						// absent
        						$abs = $total - $working;
                    // luffy 11 Dec 2019 03:04 pm
                    $late = $this->Xin_model->current_month_day_late($current_month);
      						?>
                  <table class="table mb-0 table-dashboard">
                    <tbody>
                      <tr>
                        <td><div style="width:4px;height:0;border:5px solid rgb(60, 141, 188);top: 12px;overflow:hidden; position:absolute; "></div></td>
                        <td><?=$this->lang->line('xin_emp_working');?> (<?=$working;?>)</td>
                      </tr>
                      <tr>
                        <td><div style="width:4px;height:0;border:5px solid #DE2925;top: 46px;overflow:hidden; position:absolute; "></div></td>
                        <td>Late (<?=$late;?>)</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              </div>
              <div class="col-md-7 dashboard-employee-status">
                <div class="box-body">
                  <div class="row">
                    <?php
            					$emp_work = round($working / $total * 100).'%';
                      $emp_abs = round($abs / $total * 100).'%';
                      $emp_late = round($late / $total * 100).'%';
          					?>
                    <!-- <div class="col-xs-6 col-md-6 text-center">
                    	<input type="text" class="knob" value="<?=$emp_abs;?>" data-width="90" data-height="90" data-fgColor="#f56954" readonly="readonly">
                      <div class="knob-label"><?=$this->lang->line('xin_absent');?></div>
                    </div> -->
                    <div class="col-xs-6 col-md-6 text-center">
                    	<input type="text" class="knob" value="<?=$emp_work;?>" data-width="90" data-height="90" data-fgColor="#3c8dbc" readonly="readonly">
                      <div class="knob-label"><?=$this->lang->line('xin_emp_working');?></div>
                    </div>
                    <div class="col-xs-6 col-md-6 text-center">
                    	<input type="text" class="knob" value="<?=$emp_late;?>" data-width="90" data-height="90" data-fgColor="#f56954" readonly="readonly">
                      <div class="knob-label">Late</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="box text-xs-center">
      <div class="box-body px-1">
        <div class="box-header">
          <span class="danger"><?=$this->lang->line('dashboard_total_employees');?></span>
          <h3 class="display-4 blue-grey darken-1"><?=$total;?></h3>
        </div>
        <div id="recent-buyers" class="list-group position-relative">
          <ul class="list-inline clearfix">
            <li class="border-right-blue-grey border-right-lighten-2 pr-2">
              <h1 class="blue-grey darken-1 text-bold-400"><?=$this->Xin_model->male_employees();?>%</h1>
              <span class="success"><i class="icon-male"></i> <?=$this->lang->line('xin_gender_male');?></span>
            </li>
            <li class="pl-2">
              <h1 class="blue-grey darken-1 text-bold-400"><?=$this->Xin_model->female_employees();?>%</h1>
              <span class="warning darken-2"><i class="icon-female"></i> <?=$this->lang->line('xin_gender_female');?></span>
            </li>
          </ul>
        </div>
      </div>
    </div>
   </div>
   <div class="col-xl-3 col-md-3 col-sm-12">
		<div class="box">
      <div class="box-header">
      <h3 class="box-title"><?=$this->lang->line('xin_quick_links');?></h3>
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush quick-links-dashboard">
        <li class="list-group-item">
          <a href="<?=site_url('admin/employees');?>"><i class="fa fa-user-plus"></i> Add New Employee</a>
        </li>
        <li class="list-group-item">
          <a href="<?=site_url('admin/dayoff');?>"><i class="fa fa-calendar"></i> Create Dayoff</a>
        </li>
        <li class="list-group-item">
          <a href="<?=site_url('admin/rollingshift');?>"><i class="fa fa-calendar"></i> Create Rolling Shift</a>
        </li>
        <li class="list-group-item">
          <a href="<?=site_url('admin/appraisal_task_list');?>"><i class="fa fa-tasks"></i> <?=$this->lang->line('xin_add_tasks');?></a>
        </li>
      </ul>
    </div>
  </div>
</div>
</div>
<?php if(in_array('10',$role_resources_ids)) {?>
<hr class="container-m--x mt-0 mb-4">
<div class="row">
<?php $exp_am = $this->Expense_model->get_total_expenses();?>
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon info-box-icon-hrsale"><i class="fa fa-money text-red"></i></span>
    <div class="info-box-content info-box-content-hrsale">
      <span class="info-box-text"><?=$this->lang->line('dashboard_total_expenses');?> <span class="pull-right text-green dashboard-text"><?=$this->Xin_model->currency_sign($exp_am[0]->exp_amount);?></span></span>
      <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/expense');?>"> <?=$this->lang->line('xin_view');?> <i class="fa fa-arrow-right"></i></a></span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
  <?php $all_sal = total_salaries_paid();?>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon info-box-icon-hrsale"><i class="fa fa-dollar text-red"></i></span>
      <div class="info-box-content info-box-content-hrsale">
        <span class="info-box-text"><?=$this->lang->line('dashboard_total_salaries');?> <span class="pull-right text-green dashboard-text"><?=$this->Xin_model->currency_sign($all_sal);?></span></span>
        <span class="info-box-number"><a class="text-muted" href="<?=site_url('admin/payroll/payment_history');?>"> <?=$this->lang->line('xin_view');?> <i class="fa fa-arrow-right"></i></a></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    
    <!-- /.info-box -->
  </div>
</div>
<?php }?>

<hr class="container-m--x mt-0 mb-4">
<div class="row">
<?php if(in_array('32',$role_resources_ids)) {?>
<div class="col-sm-7 col-xl-8">
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$this->lang->line('left_payment_history');?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin">
          <thead>
            <tr>
              <th><?=$this->lang->line('xin_employee_name');?></th>
              <th><?=$this->lang->line('xin_paid_amount');?></th>
              <th><?=$this->lang->line('dashboard_xin_status');?></th>
              <th><?=$this->lang->line('xin_payment_month');?></th>
              <th><?=$this->lang->line('xin_payslip');?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($get_last_payment_history as $last_payments):?>
          <?php $user = $this->Xin_model->read_user_info($last_payments->employee_id);?>
          <?php if(!is_null($user)){?>
          <?php $full_name = $user[0]->first_name.' '.$user[0]->last_name;?>
          <?php
            $month_payment = date("F, Y", strtotime($last_payments->salary_month));
      			if($last_payments->wages_type == 1){
      				$bs = $last_payments->basic_salary;
      			} else {
      				$bs = $last_payments->daily_wages;
      			}
      			// $total_earning = $bs + $last_payments->total_allowances + $last_payments->total_overtime;
      			$total_earning = $bs + $last_payments->total_allowances;
      			// $total_deduction = $last_payments->total_loan + $last_payments->salary_income_tax + $last_payments->salary_ssempee;
            $total_deduction = $last_payments->salary_ssempee + $last_payments->total_adjustment_minus;
      			$total_net_salary = $total_earning - $total_deduction;
      			$p_amount = $this->Xin_model->currency_sign($total_net_salary);
          ?>
          <tr>
            <td><a target="_blank" href="<?=site_url().'admin/employees/detail/'.$last_payments->employee_id;?>/"><?=$full_name;?></a></td>
            <td><?=$p_amount;?></td>
            <td><span class="label label-success"><?=$this->lang->line('xin_payment_paid');?></span></td>
            <td><?=$month_payment;?></td>
            <td><a target="_blank" href="<?=site_url().'admin/payroll/payslip/id/'.$last_payments->payslip_id;?>/"><?=$this->lang->line('xin_payslip');?></a></td>
          </tr>
          <?php } ?>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      <a href="<?=site_url('admin/payroll/payment_history');?>" target="_blank" class="btn btn-sm btn-default btn-flat pull-right"><?=$this->lang->line('xin_all_payslips');?></a>
    </div>
    <!-- /.box-footer -->
  </div>
</div>
<?php }?>
<!-- <div class="col-md-5"> -->
<div class="col-md-12">
    <!-- USERS LIST -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><?=$this->lang->line('dashboard_new');?> <?=$this->lang->line('dashboard_employees');?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <ul class="users-list clearfix">
          <?php foreach($last_four_employees as $employee) {?>
          <?php
          if($employee->profile_picture!='' && $employee->profile_picture!='no file') {
            $de_file = base_url().'uploads/profile/'.$employee->profile_picture;
          }else{
            if($employee->gender=='Male') {
              $de_file = base_url().'uploads/profile/default_male.jpg';
            }else{
              $de_file = base_url().'uploads/profile/default_female.jpg';
            }
          }
          $fname = $employee->first_name.' '.$employee->last_name;
          ?>
          <li>
            <a class="users-list-name" href="<?=site_url();?>admin/employees/detail/<?=$employee->user_id;?>/"><img src="<?=$de_file;?>" alt="<?=$fname;?>" class="rounded-circle-img" style='border-radius:10% !important;'></a>
            <a class="users-list-name" href="<?=site_url();?>admin/employees/detail/<?=$employee->user_id;?>/">
              <?=$fname;?>
            </a>
          </li>
          <?php } ?>
        </ul>
        <!-- /.users-list -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="<?=site_url('admin/employees/');?>" class="uppercase">View All Users &raquo;</a>
      </div>
      <!-- /.box-footer -->
    </div>
    <!--/.box -->
  </div>
</div>
