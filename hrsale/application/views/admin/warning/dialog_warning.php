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
/* luffy 10 dec 2019 - 02:01 pm */
.trumbowyg-editor, .trumbowyg-textarea {
  min-height: 106px !important;
}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['warning_id']) && $_GET['data']=='warning'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?=$this->lang->line('xin_warning_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_warning', 'id' => 'edit_warning', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $warning_id, 'ext_name' => $warning_id);?>
<?=form_open('admin/warning/update/'.$warning_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="first_name">Warning Letter Number</label>
          <input class="form-control" readonly type="text" value="<?=$letterNumber;?>">
        </div>
        <div class="form-group">
          <label for="first_name"><?=$this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?=$company->company_id?>" <?php if($company->company_id==$company_id):?> selected <?php endif; ?>><?=$company->name?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" id="employee_ajx">
              <?php $wtresult = $this->Department_model->ajax_company_employee_info($company_id);?>
              <label for="warning_to"><?=$this->lang->line('xin_warning_to');?></label>
              <select name="warning_to" id="select2-demo-6" class="form-control warningTo" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
                <option value=""></option>
                <?php foreach($wtresult as $employee) {?>
                <option value="<?=$employee->user_id;?>" <?php if($employee->user_id==$warning_to):?> selected="selected"<?php endif;?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <!-- luffy -->
          <div class="col-md-6">
            <div class="form-group" id="warning_counter_ajax">
              <label for="subject">Total Get Warning:</label>
              <?php if($counter==3){$color='#F1A9A0';}else{$color='#fff';}?>
              <input class="form-control" style="border:none; background:<?=$color;?>" value='<?php
              if($counter<1){echo 'never';}else{echo $counter.' time'; if($counter>=2)echo 's';}?>' readonly />
              <input name='warning_counter' value='<?=$counter;?>' type='hidden' readonly />
            </div>
          </div>
          <!-- luffy -->
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group warning_type_ajax">
              <label for="type"><?=$this->lang->line('xin_warning_type');?></label>
              <select class="select2" disabled data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_warning_type');?>" name="type">
                <option value=""></option>
                <?php foreach($all_warning_types as $warning_type) {?>
                <option value="<?=$warning_type->warning_type_id?>" <?php if($warning_type->warning_type_id==$warning_type_id):?> selected="selected"<?php endif;?>><?=$warning_type->type;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="subject"><?=$this->lang->line('xin_subject');?></label>
              <input class="form-control" placeholder="<?=$this->lang->line('xin_subject');?>" name="subject" type="text" value="<?=$subject;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" id="warning_employee_ajx">
              <?php $wbresult = $this->Department_model->ajax_company_employee_info($company_id);?>
              <label for="warning_by"><?=$this->lang->line('xin_warning_by');?></label>
              <select name="warning_by" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('xin_choose_an_employee');?>">
                <option value=""></option>
                <?php foreach($wbresult as $employee) {?>
                <option value="<?=$employee->user_id;?>" <?php if($employee->user_id==$warning_by):?> selected="selected"<?php endif;?>> <?=$employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="warning_date"><?=$this->lang->line('xin_warning_date');?></label>
              <input class="form-control d_date" placeholder="<?=$this->lang->line('xin_warning_date');?>" readonly name="warning_date" type="text" value="<?=$warning_date;?>">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description">Reason</label>
          <textarea class="form-control textarea" placeholder="Reason why employee get warning" name="description" cols="30" rows="9" id="description2"><?=$description;?></textarea>
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
    </div>
</div>
<?php $status==1?$display='display:block;':$display='display:none;'; // status: accepted?>
<div class="modal-footer">
  <?php if(($status==1)&&($counter==3)):?>
  <span style='padding-right:23px;'>This employee got warning <u>3 times</u>, can't update anymore.</span>
  <?php elseif(($status==1)&&($counter<3)):?>
  <span style='padding-right:23px;'>It has been <u>accepted</u>, can't update anymore.</span>
  <?php elseif($status==2):?>
  <span style='padding-right:23px;'>It has been <u>rejected</u>, can't update anymore.</span>
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
		jQuery.get(base_url+"/get_employees_warning/"+jQuery(this).val(), function(data, status){
			jQuery('#warning_employee_ajx').html(data);
		});
	});
  // luffy 10 Dec 2019 - 02:17 pm | update get total warning & warning type
  jQuery(".warningTo").change(function(){
		jQuery.get(base_url+"/get_warning_counter/"+jQuery(this).val(), function(data, status){
			jQuery('#warning_counter_ajax').html(data);
		});
    jQuery.get(base_url+"/get_warning_type/"+jQuery(this).val(), function(data, status){
			jQuery('.warning_type_ajax').html(data);
		});
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
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
	$("#edit_warning").submit(function(e){
    var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'warning');
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
			success: function(JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						$('.icon-spinner3').hide();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?=site_url("admin/warning/warning_list") ?>",
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
					$('.icon-spinner3').hide();
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
<?php }
else if(isset($_GET['jd']) && isset($_GET['warning_id']) && $_GET['data']=='view_warning'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Warning</h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <!-- <tr>
          <th><?=$this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?=$company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr> -->
        <tr>
          <th><?=$this->lang->line('xin_warning_to');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($warning_to==$employee->user_id):?>
            <?=$employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_warning_type');?></th>
          <td style="display: table-cell;"><?php foreach($all_warning_types as $warning_type) {?>
            <?php if($warning_type_id==$warning_type->warning_type_id):?>
            <?=$warning_type->type;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_warning_by');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($warning_by==$employee->user_id):?>
            <?=$employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_warning_date');?></th>
          <td style="display: table-cell;"><?=$this->Xin_model->set_date_format($warning_date);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_subject');?></th>
          <td style="display: table-cell;"><?=$subject;?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?=html_entity_decode($description);?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php if($status=='0'): $w_status = $this->lang->line('xin_pending');?>
            <?php endif; ?>
            <?php if($status=='1'): $w_status = $this->lang->line('xin_accepted');?>
            <?php endif; ?>
            <?php if($status=='2'): $w_status = $this->lang->line('xin_rejected');?>
            <?php endif; ?>
            <?=$w_status;?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  </div>
<?=form_close(); ?>
<?php }
?>
<!-- luffy start -->
<script language="javascript" type="text/javascript">
(function(a){a.createModal=function(b){defaults={title:"",message:"",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height:800px;overflow-y: auto;"':"";html='<div class="modal fade" id="pdfSPmodal">';html+='<div class="modal-dialog luffy-modal">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#pdfSPmodal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);
$(function(){
  $('.view-pdf').on('click',function(){
    $(".edit-modal-data").modal("hide");
    $(".view-modal-data").modal("hide");
    var pdf_link = $(this).attr('href');
    var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
    $.createModal({
      title:'<?=$warning_type_id;?><sup><?=$ordinalNumber;?></sup> Warning Letter',
      message: iframe,
      closeButton:true,
      scrollable:false
    });
    return false;
  });
})
</script>
<!-- luffy end -->
