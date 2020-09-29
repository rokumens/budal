<?php ;
$session = $this->session->userdata('username');
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if($theme[0]->right_side_icons=='true') {
	$icons_right = 'expanded menu-icon-right';
} else {
	$icons_right = '';
}
if($theme[0]->bordered_menu=='true') {
	$menu_bordered = 'menu-bordered';
} else {
	$menu_bordered = '';
}
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->is_active!=1) {
	redirect('admin/');
}
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);
}

//luffy
$currUri = explode('/',$_SERVER['REQUEST_URI']);
$lastUri = end($currUri);
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $arr_mod = $this->Xin_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<?php $nik = $this->Employees_model->getNamebyUserId($session['user_id'])->employee_id; ?>
<?php $submenuicon = 'fa-circle-o';?>
<?php if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {?>
<?php $cpimg = base_url().'uploads/profile/'.$user_info[0]->profile_picture;?>
<?php } elseif(!empty($user_info[0]->profile_picture_sso)) {?>
<?php $cpimg = $user_info[0]->profile_picture_sso;?>
<?php $cimg = "<img src='".$user_info[0]->profile_picture_sso."' class='img-circle rounded-circle user_profile_avatar'>";?>
<?php } else {?>
<?php  if($user_info[0]->gender=='Male') { ?>
<?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
    <?php $cpimg = $de_file;?>
<?php  } ?>
<section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=$cpimg;?>" class="img-circle" alt="User Image" style='border-radius:10% !important;'>
        </div>
        <div class="pull-left info">
          <p><?=$user_info[0]->username;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="<?php if(!empty($arr_mod['active']))echo $arr_mod['active'];?>">
          <a href="<?=site_url('admin/dashboard');?>">
            <i class="fa fa-dashboard"></i> <span><?=$this->lang->line('dashboard_title');?></span>
          </a>
        </li>
				<?php #staff start?>
        <?php if(in_array('13',$role_resources_ids) || in_array('88',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('22',$role_resources_ids) || in_array('23',$role_resources_ids) || $user_info[0]->user_role_id==1){?>
        <li class="<?php if(!empty($arr_mod['stff_open']))echo $arr_mod['stff_open'];?> treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span><?=$this->lang->line('let_staff');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('13',$role_resources_ids)) { ?>
            <li class="<?php if(!empty($arr_mod['emp_active']))echo $arr_mod['emp_active'];?>"><a href="<?=site_url('admin/employees');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('dashboard_employees');?></a></li>
            <?php } ?>
            <?php if($user_info[0]->user_role_id==1) { ?>
            <li class="<?php if(!empty($arr_mod['roles_active']))echo $arr_mod['roles_active'];?>"><a href="<?=site_url('admin/roles');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_role_urole');?></a></li>
            <?php } ?>
            <?php if(in_array('88',$role_resources_ids)) { ?>
            <li class="<?php if(!empty($arr_mod['hremp_active']))echo $arr_mod['hremp_active'];?>"><a href="<?=site_url('admin/employees/hr');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_employees_directory');?></a></li>
            <?php } ?>
            <?php if(in_array('92',$role_resources_ids)) { ?>
            <li class="<?php if(!empty($arr_mod['importemp_active']))echo $arr_mod['importemp_active'];?>"><a href="<?=site_url('admin/employees/import');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_import_employees');?></a></li>
            <?php } ?>
            <?php if(in_array('23',$role_resources_ids)) { ?>
            <li class="<?php if(!empty($arr_mod['emp_ex_active']))echo $arr_mod['emp_ex_active'];?>"><a href="<?=site_url('admin/employee_exit');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_employees_exit');?></a></li>
            <?php } ?>
            <?php if(in_array('22',$role_resources_ids)) { ?>
            <li class="<?php if(!empty($arr_mod['emp_ll_active']))echo $arr_mod['emp_ll_active'];?>"><a href="<?=site_url('admin/employees_last_login');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_employees_last_login');?></a></li>
            <?php } ?>
          </ul>
        </li>
				<?php #staff end?>
				<?php #timesheet start?>
				<?php  if(in_array('27',$role_resources_ids) || in_array('28',$role_resources_ids) || in_array('29',$role_resources_ids) || in_array('30',$role_resources_ids) || in_array('31',$role_resources_ids) || in_array('7',$role_resources_ids) || in_array('8',$role_resources_ids) || in_array('46',$role_resources_ids) || in_array('1017',$role_resources_ids)) {?>
				<li class="<?php if(!empty($arr_mod['attnd_open']))echo $arr_mod['attnd_open'];?> <?php if($lastUri=='attendance_approval')echo 'active';if(($this->uri->segment(2)=='timesheet')&&($this->uri->segment(3)=='details')) echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-clock-o"></i> <span><?=$this->lang->line('left_timesheet');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('28',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>">
			        <a href="<?=site_url('admin/timesheet/attendance');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_attendance');?>
			        </a>
			      </li>
			      <?php } ?>
						<?php if(in_array('31',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['import_attnd_active']))echo $arr_mod['import_attnd_active'];?>">
			        <a href="<?=site_url('admin/timesheet/import');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_import_attendance');?>
			        </a>
			      </li>
			      <?php } ?>
						<?php if(in_array('1017',$role_resources_ids)) { ?>
						<li class="sidenav-link <?php if($lastUri=='attendance_approval')echo 'active';if(($this->uri->segment(2)=='timesheet')&&($this->uri->segment(3)=='details')) echo 'active';?>">
			        <a href="<?=site_url('admin/timesheet/attendance_approval');?>">
			          <i class="fa <?=$submenuicon;?>"></i> Attendance Approval
			        </a>
			      </li>
						<?php } ?>
			      <!-- luffy <?php if(in_array('29',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['dtwise_attnd_active']))echo $arr_mod['dtwise_attnd_active'];?>">
			        <a href="<?=site_url('admin/timesheet/date_wise_attendance');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_date_wise_attendance');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php if(in_array('30',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['upd_attnd_active']))echo $arr_mod['upd_attnd_active'];?>">
			        <a href="<?=site_url('admin/timesheet/update_attendance');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_update_attendance');?>
			        </a>
			      </li>
			     <?php } ?> -->
			      <?php if(in_array('7',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['offsh_active']))echo $arr_mod['offsh_active'];?>">
			        <a href="<?=site_url('admin/timesheet/office_shift');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_office_shifts');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php if(in_array('8',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['hol_active']))echo $arr_mod['hol_active'];?>">
			        <a href="<?=site_url('admin/timesheet/holidays');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_manage_holidays');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php if(in_array('46',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['leave_active']))echo $arr_mod['leave_active'];?>">
			        <a href="<?=site_url('admin/timesheet/leave');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_manage_leaves');?>
			        </a>
			      </li>
			     <?php } ?>
		     </ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #timesheet end?>
				<?php #appraisal start?>
	      <?php if($system[0]->module_appraisal=='true'){?>
	      <?php if(in_array('1000',$role_resources_ids) || in_array('1001',$role_resources_ids) || in_array('1002',$role_resources_ids) || in_array('1003',$role_resources_ids) || in_array('1004',$role_resources_ids) || in_array('1005',$role_resources_ids) || in_array('1006',$role_resources_ids) || in_array('1007',$role_resources_ids) || in_array('1008',$role_resources_ids) || in_array('1009',$role_resources_ids) || in_array('1010',$role_resources_ids)) {?>
	        <li class="<?php if($lastUri=='appraisal_assign_task'||$lastUri=='appraisal_task_list'||$lastUri=='appraisal_sub_task'||$lastUri=='rewards'||$lastUri=='punishment'||$lastUri=='kpi_sales'||$lastUri=='grade_list'||$lastUri=='assign_rewards'||$lastUri=='assign_punishment'||$lastUri=='appraisal_report'||($this->uri->segment(2)==='appraisal_report')&&($this->uri->segment(3)==='detail')) echo 'active';?> treeview">
	          <a href="javascript:;">
	            <i class="fa fa-odnoklassniki"></i> <span>Appraisal</span>
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	            <?php if(in_array('1002',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='appraisal_task_list')echo 'active';?>">
	                <a href="<?=site_url('admin/appraisal_task_list');?>">
	                  <i class="fa <?=$submenuicon;?>"></i> Main Task
	                </a>
	              </li>
	            <?php } ?>
							<?php if(in_array('1001',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='appraisal_assign_task')echo 'active';?>">
	                <a href="<?=site_url('admin/appraisal_assign_task');?>">
										<?php if(in_array('2044',$role_resources_ids)):?>
	                  	<i class="fa <?=$submenuicon;?>"></i> My Assigned Task
										<?php else:?>
	                  	<i class="fa <?=$submenuicon;?>"></i> Assign Main Task
										<?php endif;?>
	                </a>
	              </li>
	            <?php } ?>
	            <?php if(in_array('1003',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='appraisal_sub_task')echo 'active';?>">
	                <a href="<?=site_url('admin/appraisal_sub_task');?>">
	                  <i class="fa <?=$submenuicon;?>"></i> Subtask List
	                </a>
	              </li>
	            <?php } ?>
							<?php if(in_array('1007',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='grade_list')echo 'active';?>">
	                <a href="<?=site_url('admin/grade_list');?>">
	                  <i class="fa <?=$submenuicon;?>"></i> Grade List
	                </a>
	              </li>
								<?php #separator #garis #pembatas;?>
								<li class="sidenav-link"><a href="javascript:;"><hr style='margin:0; border-top:1px solid #96a1a9; width: 92%;' /></a></li>
	            <?php } ?>
							<?php if(in_array('1006',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='kpi_sales')echo 'active';?>">
	                <a href="<?=site_url('admin/kpi_sales');?>">
	                  <i class="fa <?=$submenuicon;?>"></i> KPI Sales
	                </a>
	              </li>
								<?php #separator #garis #pembatas;?>
								<li class="sidenav-link"><a href="javascript:;"><hr style='margin:0; border-top:1px solid #96a1a9; width: 92%;' /></a></li>
	            <?php } ?>
	            <?php if(in_array('1004',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='rewards')echo 'active';?>">
	                <a href="<?=site_url('admin/rewards');?>">
	                  <i class="fa <?=$submenuicon;?>"></i> Rewards List
	                </a>
	              </li>
	            <?php } ?>
	            <?php if(in_array('1008',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='assign_rewards')echo 'active';?>">
	                <a href="<?=site_url('admin/assign_rewards');?>">
										<?php if(in_array('2039',$role_resources_ids)):?>
	                  	<i class="fa <?=$submenuicon;?>"></i> My Rewards
										<?php else:?>
											<i class="fa <?=$submenuicon;?>"></i> Assign Rewards
										<?php endif;?>
	                </a>
	              </li>
								<?php #separator #garis #pembatas;?>
								<li class="sidenav-link"><a href="javascript:;"><hr style='margin:0; border-top:1px solid #96a1a9; width: 92%;' /></a></li>
	            <?php } ?>
	            <?php if(in_array('1005',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='punishment')echo 'active';?>">
	                <a href="<?=site_url('admin/punishment');?>">
	                  <i class="fa <?=$submenuicon;?>"></i> Punishment List
	                </a>
	              </li>
	            <?php } ?>
							<?php if(in_array('1009',$role_resources_ids)) { ?>
								<li class="sidenav-link <?php if($lastUri=='assign_punishment')echo 'active';?>">
	                <a href="<?=site_url('admin/assign_punishment');?>">
										<?php if(in_array('2044',$role_resources_ids)):?>
	                  	<i class="fa <?=$submenuicon;?>"></i> My Punishments
										<?php else:?>
	                  	<i class="fa <?=$submenuicon;?>"></i> Assign Punishment
										<?php endif;?>
	                </a>
	              </li>
								<?php #separator #garis #pembatas;?>
								<li class="sidenav-link"><a href="javascript:;"><hr style='margin:0; border-top:1px solid #96a1a9; width: 92%;' /></a></li>
	            <?php } ?>
							<?php if(in_array('1010',$role_resources_ids)) { ?>
								<li class="treeview">
	              <a href="#"><i class="fa fa-circle-o"></i> <?=$this->lang->line('xin_acc_reports');?>
	                <span class="pull-right-container">
	                  <i class="fa fa-angle-left pull-right"></i>
	                </span>
	              </a>
	              <ul class="treeview-menu" style="display: none;">
									<li class="sidenav-link <?php if($lastUri=='appraisal_report'||($this->uri->segment(2)==='appraisal_report')&&($this->uri->segment(3)==='detail'))echo 'active';?>">
		                <a href="<?=site_url('admin/appraisal_report');?>">
		                  <i class="fa <?=$submenuicon;?>"></i> Appraisal Report
		                </a>
		              </li>
									<li class="sidenav-link <?php if($lastUri=='kpi_report'||($this->uri->segment(2)==='kpi_report')&&($this->uri->segment(3)==='detail'))echo 'active';?>">
		                <a href="<?=site_url('admin/kpi_report');?>">
		                  <i class="fa <?=$submenuicon;?>"></i> KPI Report
		                </a>
		              </li>
	              </ul>
	            </li>
	            <?php } ?>
	          </ul>
	        </li>
        <?php } ?>
        <?php } ?>
				<?php #appraisal end?>
				<?php #organization start?>
        <?php  if(in_array('12',$role_resources_ids) || in_array('14',$role_resources_ids) || in_array('15',$role_resources_ids) || in_array('16',$role_resources_ids) || in_array('17',$role_resources_ids) || in_array('18',$role_resources_ids) || in_array('19',$role_resources_ids) || in_array('20',$role_resources_ids) || in_array('21',$role_resources_ids) || in_array('22',$role_resources_ids) || in_array('23',$role_resources_ids) || in_array('10',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['adm_open']))echo $arr_mod['adm_open'];?> treeview">
          <a href="#">
            <i class="fa fa-building"></i> <span><?=$this->lang->line('left_organization');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php if(in_array('3',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['dep_active']))echo $arr_mod['dep_active'];?>"><a href="<?=site_url('admin/department');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_department');?></a></li>
          <?php } ?>
          <?php if(in_array('3',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['sub_departments_active']))echo $arr_mod['sub_departments_active'];?>"><a href="<?=site_url('admin/department/sub_departments');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_sub_departments');?></a></li>
          <?php } ?>
          <?php if(in_array('4',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['des_active']))echo $arr_mod['des_active'];?>"><a href="<?=site_url('admin/designation');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_designation');?></a></li>
          <?php } ?>
          <?php if(in_array('5',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['com_active']))echo $arr_mod['com_active'];?>"><a href="<?=site_url('admin/company')?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_company');?></a></li>  
          <?php } ?>
          <?php if(in_array('1019',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['official_documents_active']))echo $arr_mod['official_documents_active'];?>"><a href="<?=site_url('admin/company/official_documents')?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_official_documents');?></a></li>
          <?php } ?>
          <?php if(in_array('6',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['loc_active']))echo $arr_mod['loc_active'];?>"><a href="<?=site_url('admin/location');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_location');?></a></li>
          <?php } ?>
		  		<?php if(in_array('11',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['ann_active']))echo $arr_mod['ann_active'];?>"><a href="<?=site_url('admin/announcement');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_announcements');?></a></li>
          <?php } ?>
          <?php if(in_array('9',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['pol_active']))echo $arr_mod['pol_active'];?>"><a href="<?=site_url('admin/policy');?>"><i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_policies');?></a></li>
          <?php } ?>
          <?php if($system[0]->module_orgchart=='true'){?>
          <?php if(in_array('96',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['org_chart_active']))echo $arr_mod['org_chart_active'];?>"><a href="<?=site_url('admin/organization/chart');?>"><i class="fa <?=$submenuicon;?>"></i><?=$this->lang->line('xin_org_chart_lnk');?></a></li>
          <?php } ?>
          <?php } ?>
          <?php if(in_array('10',$role_resources_ids)) { ?>
            <li class="sidenav-link <?php if(!empty($arr_mod['exp_active']))echo $arr_mod['exp_active'];?>">
              <a href="<?=site_url('admin/expense');?>">
                <i class="fa <?=$submenuicon;?>"></i> <span><?=$this->lang->line('left_expense');?></span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
				<?php #organization end?>
				<?php #ticket start?>
        <?php if($system[0]->module_inquiry=='true'){?>
      	<?php if(in_array('43',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['ticket_active']))echo $arr_mod['ticket_active'];?>">
          <a href="<?=site_url('admin/tickets');?>">
            <i class="fa fa-ticket"></i> <span><?=$this->lang->line('left_tickets');?></span>
          </a>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #ticket end?>
				<?php #core hr start?>
        <?php #if(in_array('12',$role_resources_ids) || in_array('14',$role_resources_ids) || in_array('15',$role_resources_ids) || in_array('16',$role_resources_ids) || in_array('17',$role_resources_ids) || in_array('18',$role_resources_ids) || in_array('19',$role_resources_ids) || in_array('20',$role_resources_ids) || in_array('21',$role_resources_ids) || in_array('22',$role_resources_ids) || in_array('23',$role_resources_ids)){?>
        <?php if(in_array('12',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['emp_open']))echo $arr_mod['emp_open'];?> treeview">
          <a href="#">
            <i class="fa fa-futbol-o"></i> <span><?=$this->lang->line('xin_hr');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($system[0]->module_awards=='true'){?>
			  		<?php if(in_array('14',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['awar_active']))echo $arr_mod['awar_active'];?>">
            <a href="<?=site_url('admin/awards');?>" >
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_awards');?>
            </a>
          </li>
          <?php } ?>
          <?php } ?>
          <?php if(in_array('15',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['tra_active']))echo $arr_mod['tra_active'];?>">
            <a href="<?=site_url('admin/transfers');?>" >
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_transfers');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('16',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['res_active']))echo $arr_mod['res_active'];?>">
            <a href="<?=site_url('admin/resignation');?>" >
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_resignations');?>
            </a>
          </li>
          <?php } ?>
          <?php if($system[0]->module_travel=='true'){?>
              <?php if(in_array('17',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['trav_active']))echo $arr_mod['trav_active'];?>">
            <a href="<?=site_url('admin/travel');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_travels');?>
            </a>
          </li>
          <?php } ?>
          <?php } ?>
          <?php if(in_array('18',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['pro_active']))echo $arr_mod['pro_active'];?>">
            <a href="<?=site_url('admin/promotion');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_promotions');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('19',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['compl_active']))echo $arr_mod['compl_active'];?>">
            <a href="<?=site_url('admin/complaints');?>">
             <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_complaints');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('20',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['warn_active']))echo $arr_mod['warn_active'];?>">
            <a href="<?=site_url('admin/warning');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_warnings');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('21',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['term_active']))echo $arr_mod['term_active'];?>">
            <a href="<?=site_url('admin/termination');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_terminations');?>
            </a>
          </li>
          <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php #core hr end?>

        <?php #Luffy 12 Feb 2020 03:14pm | Combine into Schedule?>
        <?php #Dayoff & Rolling Shift?>
        <?php  if(in_array('1012',$role_resources_ids) || in_array('1024',$role_resources_ids)) {?>
				<li class="<?php if(($this->uri->segment(2)=='dayoff')||($this->uri->segment(2)=='rollingshift')) echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-calendar"></i> <span>Schedule</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php #Dayoff?>
            <?php if($system[0]->module_offday=='true'){?>
            <?php if(in_array('1012',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>">
			        <a href="<?=site_url('admin/dayoff');?>">
			          <i class="fa <?=$submenuicon;?>"></i> Dayoff
              </a>
			      </li>
			      <?php } ?>
            <?php } ?>

            <?php #Rolling Shift?>
            <?php if(in_array('1024',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>">
			        <a href="<?=site_url('admin/rollingshift');?>">
			          <i class="fa <?=$submenuicon;?>"></i> Rolling Shift
              </a>
			      </li>
            <?php } ?>
            
		     </ul>
        </li>
        <?php } ?>
        
				<?php #finance start?>
				<?php if(in_array('71',$role_resources_ids) || in_array('72',$role_resources_ids) || in_array('73',$role_resources_ids) || in_array('74',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('77',$role_resources_ids) || in_array('78',$role_resources_ids) || in_array('79',$role_resources_ids) || in_array('80',$role_resources_ids) || in_array('81',$role_resources_ids) || in_array('82',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)){?>
        <li class="<?php
				if(!empty($arr_mod['hr_acc_open']))echo $arr_mod['hr_acc_open'];
				if($lastUri=='financeform')echo 'active';	// luffy
				?> treeview">
          <a href="#">
            <i class="fa fa-money"></i> <span><?=$this->lang->line('xin_hr_finance');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- luffy finance form from hrdmanage -->
            <?php if(in_array('1021',$role_resources_ids)) { ?>
						<li class="sidenav-link <?php if($lastUri=='financeform')echo 'active';?>">
							<a href="<?=site_url('admin/accounting/financeform');?>">
								<i class="fa <?=$submenuicon;?>"></i> Finance Form
							</a>
            </li>
            <?php } ?>
						<!-- luffy finance form from hrdmanage -->
            <?php if(in_array('72',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_bank_cash_active']))echo $arr_mod['hr_bank_cash_active'];?>">
                <a href="<?=site_url('admin/accounting/bank_cash');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_account_list');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('73',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_balances_active']))echo $arr_mod['hr_account_balances_active'];?>">
                <a href="<?=site_url('admin/accounting/account_balances');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_account_balances');?>
                </a>
              </li>
              <?php } ?>
			  		<?php if(in_array('80',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_payees_active']))echo $arr_mod['hr_payees_active'];?>">
                <a href="<?=site_url('admin/accounting/payees');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_payees');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('81',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_payers_active']))echo $arr_mod['hr_payers_active'];?>">
                <a href="<?=site_url('admin/accounting/payers');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_payers');?>
                </a>
              </li>
      			<?php } ?>
            <?php if(in_array('75',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_deposit_active']))echo $arr_mod['hr_deposit_active'];?>">
                <a href="<?=site_url('admin/accounting/deposit');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_new_deposit');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('76',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_expense_active']))echo $arr_mod['hr_account_expense_active'];?>">
                <a href="<?=site_url('admin/accounting/expense');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_new_expense');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('77',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_transfer_active']))echo $arr_mod['hr_account_transfer_active'];?>">
                <a href="<?=site_url('admin/accounting/transfer');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_transfer');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('78',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_transactions_active']))echo $arr_mod['hr_account_transactions_active'];?>">
                <a href="<?=site_url('admin/accounting/transactions');?>" >
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_view_transactions');?>
                </a>
            	</li>
           <?php } ?>
           <?php if(in_array('83',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_statement_active']))echo $arr_mod['hr_account_statement_active'];?>">
                <a href="<?=site_url('admin/accounting/account_statement');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_account_statement');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('82',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)){?>
              <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> <?=$this->lang->line('xin_acc_reports');?>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <?php if(in_array('84',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_expense_report_active']))echo $arr_mod['hr_expense_report_active'];?>">
                <a href="<?=site_url('admin/accounting/expense_report');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_expense_reports');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('85',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_income_report_active']))echo $arr_mod['hr_income_report_active'];?>">
                <a href="<?=site_url('admin/accounting/income_report');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_income_reports');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('86',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_transfer_report_active']))echo $arr_mod['hr_transfer_report_active'];?>">
                <a href="<?=site_url('admin/accounting/transfer_report');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_transfer_report');?>
                </a>
              </li>
     	 				<?php } ?>
              </ul>
            </li>
            <?php } ?>
           </ul>
        </li>
        <?php } ?>
				<?php #finance end?>
				<?php #payroll start?>
        <?php  if(in_array('32',$role_resources_ids) || in_array('33',$role_resources_ids) || in_array('34',$role_resources_ids) || in_array('35',$role_resources_ids) || in_array('36',$role_resources_ids) || in_array('37',$role_resources_ids) || in_array('38',$role_resources_ids) || in_array('39',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['payrl_open']))echo $arr_mod['payrl_open'];?> treeview">
          <a href="#">
            <i class="fa fa-calculator"></i> <span><?=$this->lang->line('left_payroll');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		  		<?php if(in_array('36',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>">
            <a href="<?=site_url('admin/payroll/generate_payslip');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_generate_payslip');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('37',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['pay_his_active']))echo $arr_mod['pay_his_active'];?>">
            <a href="<?=site_url('admin/payroll/payment_history');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_payment_history');?>
            </a>
          </li>
          <?php } ?>
         </ul>
        </li>
        <?php } ?>
				<?php #payroll end?>
				<?php #project manager start?>
        <?php if($system[0]->module_projects_tasks=='true'){?>
      	<?php if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids) || in_array('104',$role_resources_ids) || in_array('119',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['project_open']))echo $arr_mod['project_open'];?> treeview">
          <a href="#">
            <i class="fa fa-tasks"></i> <span><?=$this->lang->line('xin_project_manager_title');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('44',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['project_active']))echo $arr_mod['project_active'];?>">
			        <a href="<?=site_url('admin/project');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_projects');?>
			        </a>
			      </li>
			     <?php } ?>
			     <?php if(in_array('45',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['task_active']))echo $arr_mod['task_active'];?>">
			        <a href="<?=site_url('admin/timesheet/tasks');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_tasks');?>
			        </a>
			      </li>
			     <?php } ?>
			     <!-- luffy
					 <?php if(in_array('119',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['hr_clients_active']))echo $arr_mod['hr_clients_active'];?>">
			        <a href="<?=site_url('admin/clients');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_project_clients');?>
			        </a>
			      </li>
			     <?php } ?>
			     <?php if(in_array('120',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['hr_create_inv_active']))echo $arr_mod['hr_create_inv_active'];?>">
			        <a href="<?=site_url('admin/invoices/create/');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_invoice_create');?>
			        </a>
			      </li>
			     <?php } ?>
			     <?php if(in_array('121',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['hr_all_inv_active']))echo $arr_mod['hr_all_inv_active'];?>">
			        <a href="<?=site_url('admin/invoices/');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_invoices_title');?>
			        </a>
			      </li>
			     <?php } ?>
			     <?php if(in_array('122',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['hr_taxes_inv_active']))echo $arr_mod['hr_taxes_inv_active'];?>">
			        <a href="<?=site_url('admin/invoices/taxes/');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_invoice_tax_type');?>
			        </a>
			      </li>
			     <?php } ?>
				 	 -->
		     </ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #project manager end?>
				<?php #files manager start?>
 				<?php if($system[0]->module_files=='true'){?>
		  	<?php if(in_array('47',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['file_active']))echo $arr_mod['file_active'];?>">
          <a href="<?=site_url('admin/files');?>">
            <i class="fa fa-file-text-o"></i> <span><?=$this->lang->line('xin_files_manager');?></span>
          </a>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #files manager end?>
				<?php #assets start?>
        <?php if($system[0]->module_assets=='true'){?>
      	<?php if(in_array('24',$role_resources_ids) || in_array('25',$role_resources_ids) || in_array('26',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['asst_open']))echo $arr_mod['asst_open'];?> treeview">
          <a href="#">
            <i class="fa fa-flask"></i> <span><?=$this->lang->line('xin_assets');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('25',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['asst_active']))echo $arr_mod['asst_active'];?>">
            <a href="<?=site_url('admin/assets');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_assets');?>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array('26',$role_resources_ids)) { ?>
          <li class="sidenav-link <?php if(!empty($arr_mod['asst_cat_active']))echo $arr_mod['asst_cat_active'];?>">
            <a href="<?=site_url('admin/assets/category');?>">
              <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_acc_category');?>
            </a>
          </li>
          <?php } ?>
     		</ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #assets end?>
				<?php #events & meetings start?>
        <?php if($system[0]->module_events=='true'){?>
      	<?php if(in_array('97',$role_resources_ids) || in_array('98',$role_resources_ids) || in_array('99',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['hr_events_open']))echo $arr_mod['hr_events_open'];?> treeview">
          <a href="#">
            <i class="fa fa-calendar-plus-o"></i> <span><?=$this->lang->line('xin_hr_events_meetings');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('98',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_events_active']))echo $arr_mod['hr_events_active'];?>">
                <a href="<?=site_url('admin/events');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_events');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('99',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['hr_meetings_active']))echo $arr_mod['hr_meetings_active'];?>">
                <a href="<?=site_url('admin/meetings');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_meetings');?>
                </a>
              </li>
              <?php } ?>
             </ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #events & meetings end?>
        <?php if($system[0]->module_recruitment=='true'){?>
      	<?php if(in_array('48',$role_resources_ids) || in_array('49',$role_resources_ids) || in_array('51',$role_resources_ids) || in_array('52',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['recruit_open']))echo $arr_mod['recruit_open'];?> treeview">
          <a href="#">
            <i class="fa fa-newspaper-o"></i> <span><?=$this->lang->line('left_recruitment');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('49',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['jb_post_active']))echo $arr_mod['jb_post_active'];?>">
                <a href="<?=site_url('admin/job_post');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_job_posts');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('51',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['jb_cand_active']))echo $arr_mod['jb_cand_active'];?>">
                <a href="<?=site_url('admin/job_candidates');?>">
                  <i class="fa <?=$submenuicon;?>"></i>
				  			<?php if(in_array('387',$role_resources_ids)) { ?>
				  			<?=$this->lang->line('left_jobs_applied');?>
                  <?php } else {?>
                  	<?=$this->lang->line('left_job_candidates');?>
                  <?php } ?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('52',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['jb_int_active']))echo $arr_mod['jb_int_active'];?>">
                <a href="<?=site_url('admin/job_interviews');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_job_interviews');?>
                </a>
              </li>
      		 <?php } ?>
           </ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #hr report start?>
      	<?php if(in_array('110',$role_resources_ids) || in_array('111',$role_resources_ids) || in_array('112',$role_resources_ids) || in_array('113',$role_resources_ids) || in_array('114',$role_resources_ids) || in_array('115',$role_resources_ids) || in_array('116',$role_resources_ids) || in_array('117',$role_resources_ids) || in_array('1018',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['reports_open']))echo $arr_mod['reports_open'];if($this->uri->segment(3)=='general_report') echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-bar-chart"></i> <span><?=$this->lang->line('xin_hr_report_title');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('111',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['reports_payslip_active']))echo $arr_mod['reports_payslip_active'];?>">
			        <a href="<?=site_url('admin/reports/payslip');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_reports_payslip');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php if(in_array('112',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['reports_employee_attendance_active']))echo $arr_mod['reports_employee_attendance_active'];?>">
			        <a href="<?=site_url('admin/reports/employee_attendance');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_reports_attendance_employee');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php if($system[0]->module_training=='true'){?>
			      <?php if(in_array('113',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['reports_employee_training_active']))echo $arr_mod['reports_employee_training_active'];?>">
			        <a href="<?=site_url('admin/reports/employee_training');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_reports_training');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php } ?>
			      <?php if($system[0]->module_projects_tasks=='true'){?>
			      <?php if(in_array('114',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['reports_projects_active']))echo $arr_mod['reports_projects_active'];?>">
			        <a href="<?=site_url('admin/reports/projects');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_reports_projects');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php if(in_array('115',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['reports_tasks_active']))echo $arr_mod['reports_tasks_active'];?>">
			        <a href="<?=site_url('admin/reports/tasks');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_reports_tasks');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php } ?>
			      <?php if(in_array('116',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['reports_roles_active']))echo $arr_mod['reports_roles_active'];?>">
			        <a href="<?=site_url('admin/reports/roles');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_report_user_roles_report');?>
			        </a>
			      </li>
			      <?php } ?>
			      <?php if(in_array('117',$role_resources_ids)) { ?>
			      <li class="sidenav-link <?php if(!empty($arr_mod['reports_employees_active']))echo $arr_mod['reports_employees_active'];?>">
			        <a href="<?=site_url('admin/reports/employees');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_report_employees');?>
			        </a>
			      </li>
			      <?php } ?>
						<?php if(in_array('1018',$role_resources_ids)) { ?>
							<li class="sidenav-link <?php if($this->uri->segment(3)=='general_report') echo 'active';?>">
								<a href="<?=site_url('admin/reports/general_report');?>">
									<i class="fa <?=$submenuicon;?>"></i> General Report
								</a>
							</li>
						<?php } ?>
           </ul>
        </li>
        <?php } ?>
				<?php #hr report end?>
				<?php #hr calendar start?>
				<?php if(in_array('95',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['calendar_hr_active']))echo $arr_mod['calendar_hr_active'];?>">
          <a href="<?php echo site_url('admin/calendar/hr');?>">
            <i class="fa fa-calendar"></i> <span><?php echo $this->lang->line('xin_hr_calendar_title');?></span>
          </a>
        </li>
        <?php } ?>
				<?php #hr calendar end?>
				<?php #training start?>
        <?php if($system[0]->module_training=='true'){?>
      	<?php  if(in_array('53',$role_resources_ids) || in_array('54',$role_resources_ids) || in_array('55',$role_resources_ids) || in_array('56',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['training_open']))echo $arr_mod['training_open'];?> treeview">
          <a href="#">
            <i class="fa fa-graduation-cap"></i> <span><?=$this->lang->line('left_training');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
	        <ul class="treeview-menu">
	        <?php if(in_array('54',$role_resources_ids)) { ?>
		      <li class="sidenav-link <?php if(!empty($arr_mod['training_active']))echo $arr_mod['training_active'];?>">
		        <a href="<?=site_url('admin/training');?>">
		          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_training_list');?>
		        </a>
		      </li>
		      <?php } ?>
		      <?php if(in_array('55',$role_resources_ids)) { ?>
		      <li class="sidenav-link <?php if(!empty($arr_mod['tr_type_active']))echo $arr_mod['tr_type_active'];?>">
		        <a href="<?=site_url('admin/training_type');?>">
		          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_training_type');?>
		        </a>
		      </li>
		      <?php } ?>
		      <?php if(in_array('56',$role_resources_ids)) { ?>
		      <li class="sidenav-link <?php if(!empty($arr_mod['trainers_active']))echo $arr_mod['trainers_active'];?>">
		        <a href="<?=site_url('admin/trainers');?>">
		          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_trainers_list');?>
		        </a>
	      	</li>
    		 <?php } ?>
         </ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #training end?>
				<?php #performance start?>
	      <?php if($system[0]->module_performance=='true'){?>
	      <?php if(in_array('40',$role_resources_ids) || in_array('41',$role_resources_ids) || in_array('42',$role_resources_ids)) {?>
        <li class="<?php
				if(!empty($arr_mod['performance_open'])) echo $arr_mod['performance_open'];?> treeview">
          <a href="#">
            <i class="fa fa-cube"></i> <span><?=$this->lang->line('left_performance');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('41',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['per_indi_active']))echo $arr_mod['per_indi_active'];?>">
                <a href="<?=site_url('admin/performance_indicator');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_performance_xindicator');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('42',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['per_app_active']))echo $arr_mod['per_app_active'];?>">
                <a href="<?=site_url('admin/performance_appraisal');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_performance_xappraisal');?>
                </a>
              </li>
              <?php } ?>
             </ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #performance end?>
				<?php #goal tracking start?>
        <?php if($system[0]->module_goal_tracking=='true'){?>
      	<?php if(in_array('106',$role_resources_ids) || in_array('107',$role_resources_ids) || in_array('108',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['goal_tracking_open']))echo $arr_mod['goal_tracking_open'];?> treeview">
          <a href="#">
            <i class="fa fa-trophy"></i> <span><?=$this->lang->line('xin_hr_goal_tracking');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('107',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['goal_tracking_active']))echo $arr_mod['goal_tracking_active'];?>">
                <a href="<?=site_url('admin/goal_tracking');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_goal_tracking');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('108',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['goal_tracking_type_active']))echo $arr_mod['goal_tracking_type_active'];?>">
                <a href="<?=site_url('admin/goal_tracking/type');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_hr_goal_tracking_type_se');?>
                </a>
              </li>
              <?php } ?>
           </ul>
        </li>
        <?php } ?>
        <?php } ?>
				<?php #goal tracking end?>
				<?php #system start?>
				<?php  if(in_array('57',$role_resources_ids) || in_array('60',$role_resources_ids) || in_array('61',$role_resources_ids) || in_array('61',$role_resources_ids) || in_array('62',$role_resources_ids) || in_array('63',$role_resources_ids) || in_array('89',$role_resources_ids) || in_array('93',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['system_open']))echo $arr_mod['system_open'];?> treeview">
          <a href="#">
            <i class="fa fa-cog"></i> <span><?=$this->lang->line('xin_system');?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($system[0]->module_language=='true'){?>
          	<?php if(in_array('89',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['languages_active']))echo $arr_mod['languages_active'];?>">
                <a href="<?=site_url('admin/languages');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_multi_language');?>
                </a>
              </li>
              <?php } ?>
              <?php } ?>
              <?php if(in_array('60',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['settings_active']))echo $arr_mod['settings_active'];?>">
                <a href="<?=site_url('admin/settings');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_settings');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('93',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['modules_active']))echo $arr_mod['modules_active'];?>">
                <a href="<?=site_url('admin/settings/modules');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_setup_modules');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('94',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['theme_active']))echo $arr_mod['theme_active'];?>">
                <a href="<?=site_url('admin/theme');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_theme_settings');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('61',$role_resources_ids)) { ?>
              <li class="sidenav-link <?php if(!empty($arr_mod['constants_active']))echo $arr_mod['constants_active'];?>">
                <a href="<?=site_url('admin/settings/constants');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_constants');?>
                </a>
              </li>
              <?php } ?>
              <?php if(in_array('62',$role_resources_ids)) { ?>
              <!-- <li class="sidenav-link <?php if(!empty($arr_mod['db_active']))echo $arr_mod['db_active'];?>">
                <a href="<?=site_url('admin/settings/database_backup');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_db_backup');?>
                </a>
              </li> -->
              <?php } ?>
              <?php if(in_array('63',$role_resources_ids)) { ?>
              <!-- <li class="sidenav-link <?php if(!empty($arr_mod['email_template_active']))echo $arr_mod['email_template_active'];?>">
                <a href="<?=site_url('admin/settings/email_template');?>">
                  <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_email_templates');?>
                </a>
              </li> -->
              <?php } ?>
             </ul>
        </li>
        <?php } ?>
				<?php #system end?>
        <?php #company policy start?>
        <?php if(in_array('1020',$role_resources_ids)) { ?>
				<li class="messages-menu <?php #if(!empty($arr_mod['pol_active']))echo $arr_mod['pol_active'];?>">
					<a href="#" data-toggle="modal" data-target=".policy" >
						<i class="fa fa-flag-o"></i> <span>Company Policy</span>
					</a>
        </li>
        <?php } ?>
				<?php #company policy end?>

        <?php #devtools start?> 
        <?php 
        if($nik=='7380'||$nik=='7381') {?>
        <li class="<?php if($lastUri=='import'||$lastUri=='attendance'||$lastUri=='location_dev') echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-code"></i> <span>Dev Tools</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="sidenav-link">
			        <a href="<?=site_url('admin/roles_dev');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('xin_role_urole');?>
			        </a>
            </li>
            <!-- batas -->
            <li class="sidenav-link"><a href="javascript:;"><hr style='margin:0; border-top:1px solid #96a1a9; width: 92%;' /></a></li> 
            <!-- batas -->
            <li class="sidenav-link">
			        <a href="<?=site_url('admin/location_dev');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_location');?>
			        </a>
            </li>
            <!-- batas -->
            <li class="sidenav-link"><a href="javascript:;"><hr style='margin:0; border-top:1px solid #96a1a9; width: 92%;' /></a></li> 
            <!-- batas -->
            <li class="sidenav-link">
			        <a href="<?=site_url('admin/timesheet_dev/attendance');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_attendance');?>
			        </a>
			      </li>
            <li class="sidenav-link">
			        <a href="<?=site_url('admin/timesheet_dev/import');?>">
			          <i class="fa <?=$submenuicon;?>"></i> <?=$this->lang->line('left_import_attendance');?>
			        </a>
			      </li>
          </ul>
        </li>
        <?php }else{ ?>
        <?php } ?>
				<?php #devtools end?>

				<li>
          <a href="<?=site_url('admin/logout');?>">
            <i class="fa fa-sign-out"></i> <span><?=$this->lang->line('left_logout');?></span>
          </a>
        </li>
				<?php #customer data start?>
				<?php #if(in_array('3000',$role_resources_ids)) {?>
				<!-- <li class="<?php if($lastUri=='customer'||$lastUri=='import')echo 'active';?> treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Customer Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
						<?php if(in_array('3001',$role_resources_ids)) { ?>
          	<li class="sidenav-link <?php if($lastUri=='customer')echo 'active';?>">
							<a href="<?=site_url('admin/customer');?>">
								<i class="fa <?=$submenuicon;?>"></i> Customer List
							</a>
          	</li>
						<?php };?>
						<?php if(in_array('3002',$role_resources_ids)) { ?>
            <li class="sidenav-link <?php if($lastUri=='import')echo 'active';?>">
							<a href="<?=site_url('admin/customer/import');?>">
								<i class="fa <?=$submenuicon;?>"></i> Import Customer
							</a>
            </li>
						<?php };?>
        	</ul>
        </li> -->
				<?php #}?>
				<?php #customer data end?>
      </ul>
    </section>
