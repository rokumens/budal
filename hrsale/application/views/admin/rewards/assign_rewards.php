<?php
// Assign rewards
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('2035',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Assign New Rewards</h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_assign_rewards', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/assign_rewards/add_assign_rewards', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('xin_hr_sub_department');?></label>
                  <select class="form-control aj_subdept" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="Choose sub department">
                    <option value=""></option>
                    <?php foreach($all_sub_departments as $singSubdept) {?>
                    <option value="<?php echo $singSubdept->sub_department_id?>"><?php echo $singSubdept->department_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group employee_ajax">
                  <label for="employee">Assign to</label>
                  <select name="assign_to" class="form-control" data-plugin="select_hrm" data-placeholder="Assign to" disabled>
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Rewards Date</label>
                  <input class="form-control rewardsDate" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="rewards_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
                <div class="form-group rewards_ajax">
                  <label for="rewards">Rewards</label>
                  <select name="rewards" class="form-control" data-plugin="select_hrm" data-placeholder="Select rewards" disabled>
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');echo $my_title;?> Rewards Summary </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th>Assigned to</th>
            <th>Location</th>
            <th>Sub Departement</th>
            <th>Rewards</th>
            <th>Point</th>
            <th>Amount</th>
            <th>Assigned at</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
