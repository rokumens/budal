<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php
if(empty($wz_lang)):
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';
elseif($wz_lang == 'english'):
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
endif;
$role_user = $this->Xin_model->read_user_role_info($user[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);
}
//$designation_info = $this->Xin_model->read_designation_info($user_info[0]->designation_id);
// set color
if($theme[0]->is_semi_dark==1):
	$light_cls = 'navbar-semi-dark navbar-shadow';
	$ext_clr = '';
else:
	$light_cls = 'navbar-dark';
	$ext_clr = $theme[0]->top_nav_dark_color;
endif;
// set layout / fixed or static
if($theme[0]->boxed_layout=='true'){
	$lay_fixed = 'container boxed-layout';
} else {
	$lay_fixed = '';
}
$animated = 'animated bounceInDown';

/**
	*	luffy slack notif - start 23 nov 2019 2:41 pm
**/
// for Employee Document
function sendNotifSlackForEmployeeDocumentExpiry($employeeId,$documentType,$employeeName,$documentNumber,$expiryDate,$notifKe){
	// to 9-it-support-kanon-a2
	$callSlack=curl_init('https://hooks.slack.com/services/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');
	// to testing channel.
	#$callSlack=curl_init('https://hooks.slack.com/services/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');
	$redirectTo=site_url().'admin/employees/detail/'.$employeeId;
	if(empty($documentNumber))
		$value="_You have not yet provided ".strtolower($documentType)." data in 'Immigration section' for this employee._"; #kasih underscore u/ text miring.
	else $value=$documentNumber;
	$expiryDate=date("d F Y", strtotime($expiryDate));
	if($notifKe==1) $prefix='1st';
	else $prefix='2nd';
	$array = array(
		'username' => 'APG Bot',
		'text' => 'Hello, <@UJ9H9LDHR> or <@UHYCRABSM>', #9302 #2002
		'mrkdwn' => true,
		'attachments' => array(
			 array(
				'color' => '#ff4757',
				'title' => "Employee name: $employeeName",
				'fallback' => 'fallback',
				'pretext' => "$prefix Notification for Employee $documentType Expiry",
				'author_name' => "Click <$redirectTo|here> to check the employee's ".strtolower($documentType),
				'author_link' => '#',
				'author_icon' => 'https://emoji.slack-edge.com/T03JZKZCX/apg/5032c072b6a519ac.png',
				#'title_link' => '',
				'text' => "$documentType number: ".$value,
				'fields' => array(
					array(
						'title' => '',
						'value' => "Date of expiry: $expiryDate",
						'short' => false
					)
				),
				// 'footer' => "footer",
				// 'footer_icon'=> 'https://emoji.slack-edge.com/T03JZKZCX/angell/a2a5624c4de0e7f9.gif'
			)
		)
	);
	$data = json_encode($array);
	curl_setopt($callSlack, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($callSlack, CURLOPT_POSTFIELDS, $data);
	curl_setopt($callSlack, CURLOPT_CRLF, true);
	curl_setopt($callSlack, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($callSlack, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($callSlack, CURLOPT_HTTPHEADER, array(
		'Content-Type => application/json',
		'Content-Length => ' . strlen($data))
	);
	$result = curl_exec($callSlack);
	curl_close($callSlack);
	return $result;
}

// for Official Document
function sendNotifSlackForOfficialDocumentExpiry($licenseName,$licenseNumber,$expiryDate,$notifKe){
	// to 9-it-support-kanon-a2
	$callSlack=curl_init('https://hooks.slack.com/services/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');
	// to testing channel.
	#$callSlack=curl_init('https://hooks.slack.com/services/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');
	$redirectTo=site_url().'admin/company/official_documents';
	$expiryDate=date("d F Y", strtotime($expiryDate));
	if($notifKe==1) $prefix='1st';
	else $prefix='2nd';
	$array = array(
		'username' => 'APG Bot',
		'text' => 'Hello, <@UJ9H9LDHR> or <@UHYCRABSM>', #9302 #2002
		'mrkdwn' => true,
		'attachments' => array(
			 array(
				'color' => '#ff4757',
				'title' => "License name: $licenseName",
				'fallback' => 'fallback',
				'pretext' => "$prefix Notification for Official Document Expiry",
				'author_name' => "Click <$redirectTo|here> to check the official document.",
				'author_link' => '#',
				'author_icon' => 'https://emoji.slack-edge.com/T03JZKZCX/apg/5032c072b6a519ac.png',
				#'title_link' => '',
				'text' => "Lisense number: ".$licenseNumber,
				'fields' => array(
					array(
						'title' => '',
						'value' => "Date of expiry: $expiryDate",
						'short' => false
					)
				),
				// 'footer' => "footer",
				// 'footer_icon'=> 'https://emoji.slack-edge.com/T03JZKZCX/angell/a2a5624c4de0e7f9.gif'
			)
		)
	);
	$data = json_encode($array);
	curl_setopt($callSlack, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($callSlack, CURLOPT_POSTFIELDS, $data);
	curl_setopt($callSlack, CURLOPT_CRLF, true);
	curl_setopt($callSlack, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($callSlack, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($callSlack, CURLOPT_HTTPHEADER, array(
		'Content-Type => application/json',
		'Content-Length => ' . strlen($data))
	);
	$result = curl_exec($callSlack);
	curl_close($callSlack);
	return $result;
}
/**
	*	luffy calling model - start 23 nov 2019 3:32 pm
**/
$today=date('Y-m-d');
$ci =&get_instance();
$ci->load->model('Employees_model');
$ci->load->model('Company_model');
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?=site_url('admin/dashboard/');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><img alt="HR Sale" src="<?=base_url();?>uploads/logo/<?=$company_info[0]->logo;?>" class="brand-logo" style="width:32px;"></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img alt="HR Sale" src="<?=base_url();?>uploads/logo/<?=$company_info[0]->logo;?>" class="brand-logo" style="width:32px;"> <b><?=$system[0]->application_name;?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <?php if($system[0]->module_recruitment=='true'){?>
					  <?php if($system[0]->enable_job_application_candidates=='1'){?>
						  <?php  if(in_array('50',$role_resources_ids)) { //job listing?>
			          <li class="messages-menu">
			            <a target="_blank" href="<?=site_url();?>frontend/jobs/">
			              <?=$this->lang->line('header_apply_jobs_frontend');?>
			            </a>
			          </li>
		          <?php  } ?>
	          <?php  } ?>
          <?php  } ?>

					<?php  if(in_array('90',$role_resources_ids)) { //notification. di sini: views> admin > roles > role_values.php?>

          <li class="dropdown messages-menu">

						<?php
						$official_license_expiry = $this->Xin_model->company_license_expiry();
						$employee_license_expiry = $this->Xin_model->employee_license_expiry();
						$receiveAssignedTicket=$this->Xin_model->get_my_assigned_ticket($session['user_id'],$session['user_id'])->result();
						if((count($official_license_expiry))||(count($employee_license_expiry)||(count($receiveAssignedTicket)))):
							$countCompanyExp=count($official_license_expiry);
							$countEmployeExp=count($employee_license_expiry);
							$totExp=$countCompanyExp+$countEmployeExp;
							$totAssignedTicket=count($receiveAssignedTicket);
						?>
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger" style="font-size:11px !important;">
								<?php
									if(($user[0]->user_role_id==1)||($user[0]->user_role_id==8)) #superadmin / admin
										echo $totExp;
									else echo $totAssignedTicket; #selain admin
								?>
							</span>
            </a>
            <ul class="dropdown-menu <?=$animated;?>">
              <li class="header">Document Expiry Notification</li>
              <li>
                <ul class="menu">
									<?php // luffy start, untuk office document notification
									// superadmin, hrd, admin.
									if(($user[0]->user_role_id=='1') || ($user[0]->user_role_id=='7') || ($user[0]->user_role_id=='8')): ;?>
								 	<?php foreach($official_license_expiry as $singExpiry):?>
									<li>
										<a href="<?=site_url().'admin/company/official_documents';?>" style="cursor:normal;">
											<div class="pull-left">
												 <img src="<?=site_url('uploads/icon/document.png');?>" alt="" id="user_avatar" class="user_profile_avatar">
											</div>
											<h4 style="font-size:12px;font-weight:normal;">
												Official document
												<?php $date=date_create($singExpiry->expiry_date);?>
												<small><i class="fa fa-calendar"></i> <?=date_format($date,"j/M/y");?></small>
											</h4>
											<p style="font-size:14px;color:#111;padding:8px 0 0;font-weight:bold;"><?=mb_strimwidth($singExpiry->license_name, 0, 29, "...");?></p>
										</a>
									</li>
								<?php
								$licenseName=$singExpiry->license_name;
								$licenseNumber=$singExpiry->license_number;
								$expiryDate=$singExpiry->expiry_date;
								if(($today>=$singExpiry->notification_date_1)&&($today<$singExpiry->notification_date_2)&&($singExpiry->notif1==0)&&($singExpiry->notif2==0)){
									$data=array('is_sent_notification_1' => 1);
									$ci->Company_model->update_company_document_record($data,$singExpiry->document_id);
									sendNotifSlackForOfficialDocumentExpiry($licenseName,$licenseNumber,$expiryDate,1);
								}elseif(($today>=$singExpiry->notification_date_2)&&($today<=$singExpiry->expiry_date)&&($singExpiry->notif1==1)&&($singExpiry->notif2==0)){
									$data=array('is_sent_notification_2' => 1);
									$ci->Company_model->update_company_document_record($data,$singExpiry->document_id);
									sendNotifSlackForOfficialDocumentExpiry($licenseName,$licenseNumber,$expiryDate,2);
								}
								?>
								<?php endforeach;?>
								<?php
									foreach($employee_license_expiry as $singEmpExpiry):?>
									<li>
										<a href="<?=site_url().'admin/employees/detail/'.$singEmpExpiry->employee_id?>" style="cursor:normal;">
											<div class="pull-left">
												 <img src="<?=site_url('uploads/icon/passport.png');?>" alt="" id="user_avatar" class="user_profile_avatar">
											</div>
											<h4 style="font-size:12px;font-weight:normal;">
												Employee document
												<?php $date=date_create($singEmpExpiry->expiry_date);?>
												<small><i class="fa fa-calendar"></i> <?=date_format($date,"j/M/y");?></small>
											</h4>
											<p style="font-size:14px;color:#111;padding:5px 0 0;font-weight:bold;"><?=mb_strimwidth($singEmpExpiry->title, 0, 29, "...");?></p>
										</a>
									</li>
								<?php
								$employeeId=$singEmpExpiry->employee_id;
								$documentType=$singEmpExpiry->document_type;
								$employeeName=$singEmpExpiry->employeeNIK.' - '.$singEmpExpiry->username;
								$documentNumber=$singEmpExpiry->document_number;
								$expiryDate=$singEmpExpiry->expiry_date;
								if(($today>=$singEmpExpiry->notification_date_1)&&($today<$singEmpExpiry->notification_date_2)&&($singEmpExpiry->notif1==0)&&($singEmpExpiry->notif2==0)){
									$data=array('is_sent_notification_1' => 1);
									$ci->Employees_model->document_info_update($data,$singEmpExpiry->document_id);
									sendNotifSlackForEmployeeDocumentExpiry($employeeId,$documentType,$employeeName,$documentNumber,$expiryDate,1);
								}elseif(($today>=$singEmpExpiry->notification_date_2)&&($today<=$singEmpExpiry->date_of_expiry)&&($singEmpExpiry->notif1==1)&&($singEmpExpiry->notif2==0)){
									$data=array('is_sent_notification_2' => 1);
									$ci->Employees_model->document_info_update($data,$singEmpExpiry->document_id);
									sendNotifSlackForEmployeeDocumentExpiry($employeeId,$documentType,$employeeName,$documentNumber,$expiryDate,2);
								}
								?>
								<?php endforeach;?>
								<?php endif; // endif admin & hrd ?>

								<?=form_open('admin/tickets/update_ticket_assigned_to');?>
								<?php foreach($receiveAssignedTicket as $singTicket):?>
									<li>
										<a href="#" style="cursor:normal">
											<h4 style="font-size:12px;font-weight:normal; padding-left:12px;">
												You get a ticket <span style="color:#367FA9;"><?=$singTicket->ticket_code;?></span>
											</h4>
											<p style="font-size:14px;color:#111;padding:0px 0 0;font-weight:bold; padding-left:12px;">
												<button type="submit" class="btn btn-primary btn-xs"> <i class="fa fa-check-square-o"></i> Confirm Receive</button>
											</p>
										</a>
									</li>
								<?php endforeach;?>
								<?=form_close(); ?>
                </ul>
              </li>
            </ul>
						<?php
							else:
						?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <i class="fa fa-bell-o"></i>
            </a>
            <ul class="dropdown-menu <?=$animated;?>">
              <li class="footer">
								<a class="users-list-name" href="javascript:;"><img src="<?=site_url('uploads/icon/notif.gif');?>" class="rounded-circle-img" style="border:none!important; width:45px!important; border-radius:unset!important;"></a>
								<a href="javascript:;">All caught up!</a>
							</li>
            </ul>
						<?php endif;?>
          </li>

				<?php /* ini buat notifikasi leave application */ ?>
				<!-- <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-bell-o"></i>
            <span class="label label-success">4</span>
          </a>
          <ul class="dropdown-menu <?=$animated;?>">
            <li class="header"><?=$this->lang->line('xin_leave_app');?></li>
            <li>
              <ul class="menu">
               <?php
               	if($user[0]->user_role_id=='1'){
									$leaveapp = $this->Xin_model->get_last_leave_applications();
								} else {
									$leaveapp = $this->Xin_model->get_last_user_leave_applications($session['user_id']);
								}
							 ?>
                <?php foreach($leaveapp as $leave_notify){?>
									<?php $employee_info = $this->Xin_model->read_user_info($leave_notify->employee_id);?>
                  <?php
                      if(!is_null($employee_info)){
                          $emp_name = $employee_info[0]->first_name. ' '.$employee_info[0]->last_name;
                      } else {
                          $emp_name = '--';
                      }
                  ?>
                  <li>
                  <a href="<?=site_url('admin/timesheet/leave_details/id')?>/<?=$leave_notify->leave_id;?>/">
                    <div class="pull-left">
                      <?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
                      <img src="<?php  echo base_url().'uploads/profile/'.$user[0]->profile_picture;?>" alt="" id="user_avatar"
                      class="img-circle user_profile_avatar">
                      <?php } else {?>
                      <?php  if($user[0]->gender=='Male') { ?>
                      <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                      <?php } else { ?>
                      <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                      <?php } ?>
                      <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="img-circle user_profile_avatar">
                      <?php  } ?>
                    </div>
                    <h4>
                      <?=$emp_name;?>
                      <small><i class="fa fa-calendar"></i> <?=$this->Xin_model->set_date_format($leave_notify->applied_on);?></small>
                    </h4>
                    <p><?=$this->lang->line('header_has_applied_for_leave');?></p>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </li>
            <li class="footer"><a href="<?=site_url('admin/timesheet/leave');?>"><?=$this->lang->line('xin_read_all');?></a></li>
          </ul>
        </li> -->

				<?php } //end notification?>
				<?php /* luffy end, untuk office document notification */ ;?>






          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          	<?php  if(in_array('61',$role_resources_ids) || in_array('93',$role_resources_ids) || in_array('63',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('62',$role_resources_ids) || in_array('94',$role_resources_ids) || in_array('96',$role_resources_ids) || in_array('60',$role_resources_ids) || $user[0]->user_role_id==1) { ?>
            <!-- <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                  <i class="fa fa-asterisk"></i>
                </a>
                <ul class="dropdown-menu <?=$animated;?>">
                  <?php  if(in_array('61',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/settings/constants');?>"> <i class="fa fa-align-justify"></i><?=$this->lang->line('left_constants');?></a></li>
                  <?php } ?>
				  				<?php  if($user[0]->user_role_id==1) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/roles');?>"> <i class="fa fa-unlock-alt"></i><?=$this->lang->line('xin_role_urole');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('93',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/settings/modules');?>"> <i class="fa fa-life-ring"></i><?=$this->lang->line('xin_setup_modules');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('63',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/settings/email_template');?>"> <i class="fa fa-envelope"></i><?=$this->lang->line('left_email_templates');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('92',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/employees/import');?>"> <i class="fa fa-users"></i><?=$this->lang->line('xin_import_employees');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('62',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/settings/database_backup');?>"> <i class="fa fa-database"></i><?=$this->lang->line('header_db_log');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('94',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/theme');?>"> <i class="fa fa-columns"></i><?=$this->lang->line('xin_theme_settings');?></a></li>
                  <?php } ?>
                  <?php if($system[0]->module_orgchart=='true'){?>
            	  	<?php if(in_array('96',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/organization/chart');?>"> <i class="fa fa-sitemap"></i><?=$this->lang->line('xin_org_chart_title');?></a></li>
                  <?php } ?>
                  <?php } ?>
                  <?php if(in_array('60',$role_resources_ids)) { ?>
                  <li class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/settings');?>"> <i class="fa fa-cog text-aqua"></i><?=$this->lang->line('header_configuration');?></a></li>
                  <?php } ?>
                </ul>
              </li> -->
            <?php } ?>
          	<?php if($system[0]->module_language=='true'){?>
            	<li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                  <?=$flg_icn;?>
                </a>
                <ul class="dropdown-menu <?=$animated;?>">
	                <?php $languages = $this->Xin_model->all_languages();?>
									<?php foreach($languages as $lang):?>
                	<?php $flag = '<img src="'.base_url().'uploads/languages_flag/'.$lang->language_flag.'">';?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/dashboard/set_language/').$lang->language_code;?>"><?=$flag;?> &nbsp; <?=$lang->language_name;?></a></li>
                  <?php endforeach;?>
                  <?php if($system[0]->module_language=='true'){?>
            			<?php  if(in_array('89',$role_resources_ids)) { ?>
                  <li class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?=site_url('admin/languages');?>"> <i class="fa fa-cog text-aqua"></i><?=$this->lang->line('left_settings');?></a></li>
                  <?php } ?>
                  <?php } ?>
                </ul>
            	</li>
            <?php } ?>
            <!-- luffy<li class="messages-menu">
            <a data-toggle="modal" data-target=".policy" href="#">
              <i class="fa fa-flag-o"></i>
            </a>
          </li>  -->
              <li class="dropdown user user-menu">
              <?php #if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
            	<?php #$cpimg = base_url().'uploads/profile/'.$user[0]->profile_picture;?>
            	<?php #$cimg = '<img src="'.$cpimg.'" alt="" id="user_avatar" class="img-circle rounded-circle user_profile_avatar">';?>
							<?php /*} else*/if(!empty($user[0]->profile_picture_sso)) {?>
							<?php $cpimg = $user[0]->profile_picture_sso;?>
							<?php $cimg = "<img src='".$user[0]->profile_picture_sso."' class='img-circle rounded-circle user_profile_avatar'>";?>
	            <?php } else {?>
	            <?php  if($user[0]->gender=='Male') { ?>
	            <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
	            <?php } else { ?>
	            <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
	            <?php } ?>
            	<?php $cpimg = $de_file;?>
            	<?php $cimg = '<img src="'.$de_file.'" alt="" id="user_avatar" class="img-circle rounded-circle user_profile_avatar">';?>
            <?php  } ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=$cpimg;?>" class="user-image" alt="<?=$user[0]->username;?>">
            </a>
            <ul class="dropdown-menu <?=$animated;?>">
              <!-- User image -->
              <li class="user-header">
                <?=$cimg;?>
                <p>
                  <?=$user[0]->username;?>
                  <small><?=$this->lang->line('xin_emp_member_since');?> <?=date('M. Y',strtotime($user[0]->date_of_joining));?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body"> -->
                <!-- <div class="row">
                  <div class="col-xs-6 text-center">
                    <a href="<?=site_url('admin/auth/lock')?>"><?=$this->lang->line('xin_lock_user');?></a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="<?=site_url('admin/profile?change_password=true')?>"><?=$this->lang->line('xin_employee_password');?></a>
                  </div>
                </div> -->
                <!-- /.row -->
              <!-- </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=site_url('admin/profile');?>" class="btn btn-default btn-flat"><?=$this->lang->line('header_my_profile');?></a>
                </div>
                <div class="pull-right">
									<?php if(!empty($_SESSION['access_token'])):?>
										<a href="<?=site_url('admin/auth/logout_sso');?>" class="btn btn-default btn-flat text-red"><?=$this->lang->line('header_sign_out');?></a>
									<?php else:?>
										<a href="<?=site_url('admin/logout');?>" class="btn btn-default btn-flat text-red"><?=$this->lang->line('header_sign_out');?></a>
									<?php endif;?>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gear fa-spin"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
