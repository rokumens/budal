<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-3">
        <div class="box">
          <div class="box-body">
            <div class="box-header with-border">
              <h3 class="box-title"> Dayoff Calendar </h3>
            </div>
            <input type="hidden" id="exact_date" value="" />
            <div class="list-group">
              <?php if(in_array('8',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-green"> <i class="fa fa-space-shuttle"></i> <?php echo $this->lang->line('left_holidays');?></span>
              <?php } ?>
              <?php if(in_array('46',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-aqua"> <i class="fa fa-envelope"></i> <?php echo $this->lang->line('xin_hr_calendar_lv_request');?></span>
              <?php } ?>
              <?php if($system[0]->module_travel=='true'){?>
              <?php if(in_array('17',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-light-blue"> <i class="fa fa-plane"></i> <?php echo $this->lang->line('xin_hr_calendar_trvl_request');?></span>
              <?php } ?>
              <?php } ?>
              <span class="list-group-item calendar-options text-red"> <i class="fa fa-gift"></i> <?php echo $this->lang->line('xin_hr_calendar_upc_birthday');?></span>
              <?php if($system[0]->module_training=='true'){?>
              <?php if(in_array('53',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-yellow"> <i class="fa fa-graduation-cap"></i> <?php echo $this->lang->line('xin_hr_calendar_tranings');?></span>
              <?php } ?>
              <?php } ?>
              <?php if($system[0]->module_projects_tasks=='true'){?>
              <?php if(in_array('44',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-purple"> <i class="fa fa-pencil-square"></i> <?php echo $this->lang->line('left_projects');?></span>
              <?php } ?>
              <?php if(in_array('45',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-maroon"> <i class="fa fa-tasks"></i> <?php echo $this->lang->line('left_tasks');?></span>
              <?php } ?>
              <?php } ?>
              <?php if($system[0]->module_events=='true'){?>
              <?php if(in_array('98',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-navy"> <i class="fa fa-calendar-plus-o"></i> <?php echo $this->lang->line('xin_hr_events');?></span>
              <?php } ?>
              <?php if(in_array('99',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-teal"> <i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('xin_hr_meetings');?></span>
              <?php } ?>
              <?php } ?>
              <?php if($system[0]->module_goal_tracking=='true'){?>
              <?php if(in_array('106',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-light-blue"> <i class="fa fa-trophy"></i> <?php echo $this->lang->line('xin_hr_goals_title');?></span>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body">
            <div id='calendar_hr'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">

</style>
