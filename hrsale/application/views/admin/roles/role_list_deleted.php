<?php /* Deleted Roles */?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title">
        <div class="box-tools pull-right">
          <a class="text-dark" href="<?=site_url('admin/roles');?>" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-arrow-circle-left"></span> Back to Role List</button>
          </a>
        </div>
      </h3>
    </div>
  </div>
</div>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> All Deleted <?=$this->lang->line('xin_roles');?> List </h3>
  </div>
  <div class="box-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table_deleted">
      <thead>
        <tr>
          <th><?=$this->lang->line('xin_action');?></th>
          <th><?=$this->lang->line('xin_role_name');?></th>
          <th><?=$this->lang->line('xin_role_menu_per');?></th>
          <th><?=$this->lang->line('left_company');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
</div>
<style type="text/css">
.k-in { display:none !important; }
</style>
