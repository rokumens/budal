<style type="text/css">
.iframe-container {
  padding-bottom: 60%;
  padding-top: 30px; height: 0; overflow: hidden;
}
.iframe-container iframe,
.iframe-container object,
.iframe-container embed {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.luffy-modal {
  width: 65%;
  margin: auto;
}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['termination_id']) && $_GET['data']=='termination'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_edit_termination');?></h4>
</div>
<?php $session = $this->session->userdata('username');?>
<?php $attributes = array('name' => 'edit_termination', 'id' => 'edit_termination', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $termination_id, 'ext_name' => $termination_id, 'user_id' => $session['user_id']);?>
<?=form_open('admin/termination/update/'.$termination_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name">Termination Letter Number</label>
          <input class="form-control" readonly type="text" value="<?=$letterNumber;?>">
        </div>
        <div class="form-group">
          <label for="first_name"><?=$this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="ajx_company" disabled data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?=$company->company_id?>" <?php if($company->company_id==$company_id):?> selected <?php endif; ?>><?=$company->name?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group" id="employee_ajx">
        <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
          <label for="employee"><?=$this->lang->line('xin_employee_terminated');?></label>
          <select name="noname" id="select2-demo-6" class="form-control" disabled data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
            <option value=""></option>
            <?php foreach($result as $employee) {?>
            <option value="<?=$employee->user_id;?>" <?php if($employee->user_id==$employee_id):?> selected="selected"<?php endif;?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
            <?php } ?>
          </select>
          <input class="form-control" readonly name="employee_id" type="hidden" value="<?=$employee_id;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="notice_date"><?=$this->lang->line('xin_notice_date');?></label>
              <input class="form-control d_date" placeholder="<?=$this->lang->line('xin_notice_date');?>" readonly name="notice_date" type="text" value="<?=$notice_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="termination_date"><?=$this->lang->line('xin_termination_date');?></label>
              <input class="form-control d_date" placeholder="<?=$this->lang->line('xin_termination_date');?>" readonly name="termination_date" type="text" value="<?=$termination_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="type"><?=$this->lang->line('xin_termination_type');?></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_termination_type_select');?>" name="type">
                <option value=""></option>
                <?php foreach($all_termination_types as $termination_type) {?>
                <option value="<?=$termination_type->termination_type_id?>" <?php if($termination_type->termination_type_id==$termination_type_id):?> selected="selected"<?php endif;?>><?=$termination_type->type;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="approval_by_1">Approval 1 By</label>
              <select class="form-control" name="approval_by_1" data-plugin="select_hrm" data-placeholder="Choose who will approve this termination.">
                <option value=""></option>
                <?php foreach($allApprover as $singApprover){?>
                  <?php $approver=$this->Employees_model->getNamebyUserId($singApprover->approver);?>
                  <option value="<?=$approver->user_id?>" <?php if($approver->user_id==$approval_1) echo 'selected';?>><?=$approver->employee_id.' - '.$approver->username;?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="approval_by_2">Approval 2 By</label>
              <select class="form-control" name="approval_by_2" data-plugin="select_hrm" data-placeholder="Choose who will approve this termination.">
                <option value=""></option>
                <?php foreach($allApprover as $singApprover){?>
                  <?php $approver=$this->Employees_model->getNamebyUserId($singApprover->approver);?>
                  <option value="<?=$approver->user_id?>" <?php if($approver->user_id==$approval_2) echo 'selected';?>><?=$approver->employee_id.' - '.$approver->username;?></option>
                <?php }?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?=$this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?=$this->lang->line('xin_description');?>" name="description" cols="30" rows="9" id="description2"><?=$description;?></textarea>
        </div>
        <div class="form-group">
          <label for="status"><?=$this->lang->line('dashboard_xin_status');?></label>
          <?php
          $selectedPending='';
          $selectedAccepted='';
          $selectedRejected='';
          if($currentUser==$approval_1){
            if($approval_status_by_1=='0') $selectedPending='selected';
            if($approval_status_by_1=='1') $selectedAccepted='selected';
            if($approval_status_by_1=='2') $selectedRejected='selected';
          }elseif($currentUser==$approval_2){
            if($approval_status_by_2=='0') $selectedPending='selected';
            if($approval_status_by_2=='1') $selectedAccepted='selected';
            if($approval_status_by_2=='2') $selectedRejected='selected';
          }else{
            if($status=='0') $selectedPending='selected';
            if($status=='1') $selectedAccepted='selected';
            if($status=='2') $selectedRejected='selected';
          }
          ?>
          <select name="status" id="select2-demo-6" class="form-control selectStatus" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_xin_status');?>">
            <option value="0" <?=$selectedPending;?>><?=$this->lang->line('xin_pending');?></option>
            <option value="1" <?=$selectedAccepted;?>><?=$this->lang->line('xin_accepted');?></option>
            <option value="2" <?=$selectedRejected;?>><?=$this->lang->line('xin_rejected');?></option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php if(($currentUser!=$approval_1)&&($currentUser!=$approval_2)):?>
      <?php if($status==1):?>
      <span style='padding-right:23px;'>It has been <u>accepted</u>, can't update anymore.</span>
      <?php elseif($status==2):?>
      <span style='padding-right:23px;'>It has been <u>rejected</u>, can't update anymore.</span>
      <?php else:?>
      <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
      <?php endif;?>
    <?php else:?>
      <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
    <?php endif;?>
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
  $(document).on("change",".selectStatus",function(){
		if($(this).val()==1){
			$('.divAttachment').show('fast');
		}else{
			$('.divAttachment').hide('fast');
			$('.attachVal').val('');
			$('.terminationAttachment').val('');
		}
	});
	$('#description2').trumbowyg();
	$('.d_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1900:' + (new Date().getFullYear() + 10),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
	});
	/* update */
	$("#edit_termination").submit(function(e){
    var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'termination');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
      url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON){
				if(JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
  					"bDestroy": true,
  					"ajax": {
  						url : "<?=site_url("admin/termination/termination_list") ?>",
  						type : 'GET'
  					},
  					"fnDrawCallback": function(settings){
  					  $('[data-toggle="tooltip"]').tooltip();
  					}
					});
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			},
      error: function(xhr, textStatus, error){
        // console.log('Error Berat: ' + xhr.responseText);  // luffy
        // console.log('Error Berat: ' + xhr.statusText); // luffy
        // console.log('Error Berat: ' + textStatus); // luffy
        // console.log('Error Berat: ' + error); // luffy
        $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
        $('.save').prop('disabled', true);
        toastr.error("Error. Please contact dev team.");
        setTimeout(function(){
        	location.reload();
        }, 1500);
			}
		});
	});
});
</script>
<?php }elseif(isset($_GET['jd']) && isset($_GET['termination_id']) && $_GET['data']=='view_termination'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_view_termination');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th>Termination Letter Number</th>
          <td style="display: table-cell;">
            <?=$letterNumber;?>
          </td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_employee_terminated');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($employee_id==$employee->user_id):?>
            <?=$employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_notice_date');?></th>
          <td style="display: table-cell;"><?=$this->Xin_model->set_date_format($notice_date);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_termination_date');?></th>
          <td style="display: table-cell;"><?=$this->Xin_model->set_date_format($termination_date);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_termination_type');?></th>
          <td style="display: table-cell;"><?php foreach($all_termination_types as $termination_type) {?>
            <?php if($termination_type_id==$termination_type->termination_type_id):?>
            <?=$termination_type->type;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th>Reason</th>
          <td style="display: table-cell;"><?=html_entity_decode($description);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php if($status=='0'): $t_status = $this->lang->line('xin_pending');?>
            <?php endif; ?>
            <?php if($status=='1'): $t_status = $this->lang->line('xin_accepted');?>
            <?php endif; ?>
            <?php if($status=='2'): $t_status = $this->lang->line('xin_rejected');?>
            <?php endif; ?>
            <?=$t_status;?></td>
        </tr>
        <?php # luffy 18 Dec 2019 03:31 pm?>
        <tr>
          <th>Approval by</th>
          <td style="display: table-cell;">
            <?=$approver1Name;?> and <?=$approver2Name;?>
          </td>
        </tr>
        <?php # luffy 18 Dec 2019 10:22 am?>
        <tr>
          <th>Termination Letter</th>
          <td style="display: table-cell;">
            <i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i>&nbsp;
            <a class="view-pdf" data-toggle="modal" data-target="#pdfTerminationModal" data-dismiss="modal" href="<?=site_url()?>admin/termination/termination_letter/p/<?=$termination_id;?>">
              See termination letter
            </a>.
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close(); ?>
<?php }?>
<!-- luffy start -->
<script language="javascript" type="text/javascript">
(function(a){a.createModal=function(b){defaults={title:"",message:"",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height:800px;overflow-y: auto;"':"";html='<div class="modal fade" id="pdfTerminationModal">';html+='<div class="modal-dialog luffy-modal">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#pdfTerminationModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);
$(function(){
  $('.view-pdf').on('click',function(){
    $(".edit-modal-data").modal("hide");
    $(".view-modal-data").modal("hide");
    var pdf_link = $(this).attr('href');
    var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
    $.createModal({
      title:'Termination Letter',
      message: iframe,
      closeButton:true,
      scrollable:false
    });
    return false;
  });
})
</script>
<!-- luffy end -->
