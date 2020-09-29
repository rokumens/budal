<?php
/* Payment History view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> <?=$this->lang->line('left_payment_history');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th><?=$this->lang->line('dashboard_employee_id');?></th>
            <th><?=$this->lang->line('xin_employee_name');?></th>
            <th>Office Location</th>
            <th><?=$this->lang->line('xin_paid_amount');?></th>
            <th><?=$this->lang->line('xin_payment_month');?></th>
            <th><?=$this->lang->line('xin_payment_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
