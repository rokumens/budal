  <?php
// Rewards list
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('2015',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Add New Reward Points</h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_rewards', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/rewards/add_rewards', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="rewardName">Reward Name</label>
                  <input type='text' name='rewardName' class="form-control" placeholder='Set reward name' />
                </div>
                <div class="form-group">
                  <label for="rewardPoint">Reward Point</label>
                  <input name='rewardPoint' class="form-control rewardPoint" placeholder='Set reward point' type='number' min=1 required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="valuePerPoint">Amount per 1 point (Rp.)</label>
                  <input name='valuePerPoint' type='number' min='0' class="form-control amountPerPoint" value="<?php echo $amount;?>" readonly />
                </div>
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input type='text' name='amount' class="form-control amount" type='text' readonly />
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
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> Rewards Points </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th>Rewards name</th>
            <th>Rewards point</th>
            <th>Amount</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
