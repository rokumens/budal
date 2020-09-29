<?php
/* Deleted Departments */
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title">
        <div class="box-tools pull-right">
          <a class="text-dark" href="<?=site_url('admin/employees');?>" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-arrow-circle-left"></span> Back to Employees List</button>
          </a>
        </div>
      </h3>
    </div>
  </div>
</div>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> All Deleted <?=$this->lang->line('xin_employees');?>  List </h3>
  </div>
  <div class="box-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table_deleted">
      <thead>
        <tr>
          <th style="width:80px;"><?=$this->lang->line('xin_action');?></th>
          <th><?=$this->lang->line('xin_employees_id');?></th>
          <th><?=$this->lang->line('dashboard_username');?></th>
          <th><?=$this->lang->line('xin_employees_full_name');?></th>
          <!-- <th><?=$this->lang->line('left_company');?></th> -->
          <th>Office Location</th>
          <th><?=$this->lang->line('dashboard_email');?></th>
          <th><?=$this->lang->line('xin_employee_role');?></th>
          <th><?=$this->lang->line('xin_designation');?></th>
          <th><?=$this->lang->line('dashboard_xin_status');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
</div>
