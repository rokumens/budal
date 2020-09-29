<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('2025',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Add New KPI Sales</h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_kpi_sales', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/kpi_sales/add_kpi_sales', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Main Task</label>
                  <select class="form-control taskId" name="jobtask" data-plugin="select_hrm" data-placeholder="Choose main task">
                    <option value=""></option>
                    <?php foreach($allJobTask as $singJobtask) {?>
                    <option value="<?php echo $singJobtask->id?>"><?php echo $singJobtask->taskName?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group minRequirement">
                  <label for="minimumRequirement">Min. Sales Requirement (Monthly)</label>
                  <input class="form-control monthlyRequirement" name="monthlyRequirement" type="number" readonly />
                </div>
                <div class="form-group">
                  <label for="minimumAmount">Min. New Player Deposit Amount (Monthly)</label>
                  <input class="form-control minimumAmount duit" placeholder="Set minimum new player deposit amount (monthly)" name="minimumAmount" type="text" min='0' />
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="valuePercentage">Bonus Percentage (%)</label>
                      <input class="form-control valuePercentage" placeholder="Set bonus percentage (%)" name="valuePercentage" type="number" step='.05' min='0' max='100' />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="valueAmount">Value Amount (Rp.)</label>
                      <input class="form-control valueAmount" name="valueAmount" readonly type="text" min='0' />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="employeeBonus">Bonus Staff Amount</label>
                  <input class="form-control employeeBonus" name="employeeBonus" readonly type="text" min='0' />
                </div>
                <div class="form-group">
                  <label for="totalDeposit">Total Deposit (Rp.)</label>
                  <input class="form-control totalDeposit duit" name="totalDeposit" readonly type="text" min='0' />
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
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> KPI Sales </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th>Main Task</th>
            <th>Min. Sales Requirement (Monthly)</th>
            <th>Min. New Player Deposit Amount (Monthly)</th>
            <th>Total Deposit</th>
            <th>Bonus Percentage (%)</th>
            <th>Value Amount</th>
            <th>Bonus Staff Amount</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
