<!-- Start 7381-Jazz 29Jan2020 : 17:52 -->
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
<?php $session=$this->session->userdata('username');?>
<?php $get_animate=$this->Xin_model->get_content_animate();?>
<div class="box">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-body">
            <input type="hidden" name="name" value="" class="currentSubDept" readonly>
            <div id='rollingshift_list'></div>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>