<?php
/* Customer view */
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> Customers </h3>
    <?php if(in_array('3002',$role_resources_ids)) {?>
    <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
      <a href="<?php echo site_url('admin/customer/import');?>" type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> Import Customer &raquo;</a></a>
      <button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal"><span class="fa fa-trash"></span> Empty Customer Data </button>
    </div>
  <?php };?>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="customer_data">
        <thead>
          <tr>
            <!-- <th style="width:80px;"><?php echo $this->lang->line('xin_action');?></th> -->
            <th style='width:20px;'>No</th>
            <th style='width:300px;'>Mobile Number</th>
            <th>Email Address</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> Duplicate Mobile Number </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="duplicate_number_table">
        <thead>
          <tr>
            <th style='width:300px;'>Mobile Number</th>
            <th>Duplicates</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
