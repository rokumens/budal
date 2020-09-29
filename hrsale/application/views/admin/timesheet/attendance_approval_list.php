<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
  </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Request Approval List</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table_attendance_approval">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th>ID</th>
            <th>Nickname</th>
            <th><?php echo $this->lang->line('xin_employee');?></th>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('dashboard_clock_in');?></th>
            <th><?php echo $this->lang->line('dashboard_clock_out');?></th>
            <th>Reason</th>
            <th>Approval</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
