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
if(isset($_GET['jd']) && isset($_GET['document_id']) && $_GET['data']=='document'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?=$this->lang->line('xin_edit_company');?></h4>
</div>
<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['document_id'], 'ext_name' => $license_name);?>
<?=form_open_multipart('admin/company/update_official_document/'.$document_id, $attributes, $hidden);?>
  <div class="modal-body">
<div class="form-body">
  <div class="row">
	<div class="col-md-6">
	  <div class="form-group">
		<label for="license_name"><?=$this->lang->line('xin_hr_official_license_name');?></label>
		<input class="form-control" placeholder="<?=$this->lang->line('xin_hr_official_license_name');?>" name="license_name" type="text" value="<?=$license_name;?>">
	  </div>
	  <div class="form-group">
		<div class="row">
		  <div class="col-md-6">
			<label for="company_id"><?=$this->lang->line('left_company');?></label>
			<select class="form-control" name="company_id" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('left_company');?>">
			  <option value=""></option>
			  <?php foreach($get_all_companies as $company) {?>
			  <option value="<?=$company->company_id?>" <?php if($company->company_id==$company_id):?> selected="selected"<?php endif?>><?=$company->name?></option>
			  <?php } ?>
			</select>
		  </div>
		  <div class="col-md-6">
			<label for="expiry_date"><?=$this->lang->line('xin_expiry_date');?></label>
			<input class="form-control ddate" placeholder="<?=$this->lang->line('xin_expiry_date');?>" name="expiry_date" type="text" value="<?=$expiry_date;?>">
		  </div>
		</div>
		<div class="row" style="padding-top:15px;">
		  <div class="col-md-6">
			<div class="form-group">
			  <fieldset class="form-group">
				<label for="scan_file"><?=$this->lang->line('xin_hr_official_license_scan');?></label>
				<input type="file" class="form-control-file" accept="image/png, image/jpg, image/jpeg, application/pdf" id="scan_file" name="scan_file">
				<small><?=$this->lang->line('xin_company_file_type');?></small>
			  </fieldset>
        <?php if($document!=''):?>
        <i class="fa fa-eye" aria-hidden="true" style="color:blue;"></i>&nbsp;
        <a class="view-pdf" data-toggle="modal" data-target="#pdfSPmodal" data-dismiss="modal" href="<?php echo site_url()?>uploads/company/official_documents/<?php echo $document;?>">
          See document
        </a>
        <?php endif; ?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  <?php /* luffy start */ ?>
	<div class="col-md-6">
    <div class="form-group">
      <label for="license_number"><?=$this->lang->line('xin_hr_official_license_number');?></label>
      <input class="form-control" placeholder="<?=$this->lang->line('xin_hr_official_license_number');?>" name="license_number" type="text" value="<?=$license_number;?>">
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-md-5">
          <label for="xin_gtax"><?=$this->lang->line('xin_hr_official_license_alarm');?> 1</label>
          <input class="form-control" placeholder="" name="license_notification_1" type="number" value="<?=$license_notification_1;?>" />
        </div>
        <div class="col-md-7">
          <label for="xin_gtax_satuan">&nbsp;</label>
          <select class="form-control" name="license_notification_satuan_1" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_hr_official_license_alarm');?>">
            <option value="days" <?php if("days"==$notification_interval_satuan_1):?> selected="selected"<?php endif?>>Day</option>
            <option value="weeks" <?php if("weeks"==$notification_interval_satuan_1):?> selected="selected"<?php endif?>>Week</option>
            <option value="months" <?php if("months"==$notification_interval_satuan_1):?> selected="selected"<?php endif?>>Month</option>
            <option value="years" <?php if("years"==$notification_interval_satuan_1):?> selected="selected"<?php endif?>>Year</option>
          </select>
        </div>
      </div>
    </div>
	</div>
	<div class="col-md-6">
    <div class="form-group">
      <div class="row">
        <div class="col-md-5">
          <label for="xin_gtax"><?=$this->lang->line('xin_hr_official_license_alarm');?> 2</label>
          <input class="form-control" placeholder="" name="license_notification_2" type="number" value="<?=$license_notification_2;?>" />
        </div>
        <div class="col-md-7">
          <label for="xin_gtax_satuan">&nbsp;</label>
          <select class="form-control" name="license_notification_satuan_2" data-plugin="xin_select" data-placeholder="<?=$this->lang->line('xin_hr_official_license_alarm');?>">
            <option value="days" <?php if("days"==$notification_interval_satuan_2):?> selected="selected"<?php endif?>>Day</option>
            <option value="weeks" <?php if("weeks"==$notification_interval_satuan_2):?> selected="selected"<?php endif?>>Week</option>
            <option value="months" <?php if("months"==$notification_interval_satuan_2):?> selected="selected"<?php endif?>>Month</option>
            <option value="years" <?php if("years"==$notification_interval_satuan_2):?> selected="selected"<?php endif?>>Year</option>
          </select>
        </div>
      </div>
    </div>
	</div>
  <?php /* luffy end */ ?>
  </div>
</div
</div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary save"><?=$this->lang->line('xin_update');?></button>
  </div>
<?=form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){

		$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
		$('[data-plugin="xin_select"]').select2({ width:'100%' });

		// Expiry Date
		$('.ddate').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd',
			yearRange: '1900:' + (new Date().getFullYear() + 15),
			beforeShow: function(input) {
				$(input).datepicker("widget").show();
			}
		});

		/* Edit data */
		$("#edit_document").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'document');
			fd.append("form", action);
			e.preventDefault();
			$('.save').prop('disabled', true);
			$.ajax({
				url: e.target.action,
				type: "POST",
				data:  fd,
				contentType: false,
				cache: false,
				processData:false,
				success: function(JSON)
				{
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?=site_url("admin/company/document_list") ?>",
								type : 'GET'
							},
							dom: 'lBfrtip',
							"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
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
				error: function()
				{
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
		   });
		});
	});
  </script>
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_document' && isset($_GET['document_id']) ){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-eye4"></i> <?=$this->lang->line('xin_hr_official_document_view');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?=$this->lang->line('xin_hr_official_license_name');?></th>
          <td style="display: table-cell;"><?=$license_name;?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('left_company');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
            <?php if($company_id==$company->company_id){?>
            <?=$company->name;?>
            <?php } } ?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_expiry_date');?></th>
          <td style="display: table-cell;"><?=$expiry_date;?></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_hr_official_license_number');?></th>
          <td style="display: table-cell;"><?=$license_number;?></span></td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_hr_official_license_alarm');?> 1</th>
            <td style="display: table-cell;">
              <span><?=$license_notification_full_1;?></span>
			     </td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_hr_official_license_alarm');?> 2</th>
            <td style="display: table-cell;">
              <span><?=$license_notification_full_2;?></span>
			     </td>
        </tr>
        <tr>
          <th><?=$this->lang->line('xin_hr_official_license_scan');?></th>
          <td style="display: table-cell;">
            <?php if($document!=''):?>
            <i class="fa fa-eye" aria-hidden="true" style="color:blue;"></i>&nbsp;
            <a class="view-pdf" data-toggle="modal" data-target="#pdfSPmodal" data-dismiss="modal" href="<?php echo site_url()?>uploads/company/official_documents/<?php echo $document;?>">
              See document
            </a>
            <span style='padding:0 10px 0;'>|</span>
            <i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i>&nbsp;
            <a href='<?=site_url('admin/download?type=company/official_documents&filename=').$document?>'>Download</a>
            <?php else:?> - <?php endif; ?>
          </td>
        </tr>
      </tbody>
    </table></div>
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
      title:'Official Document',
      message: iframe,
      closeButton:true,
      scrollable:false
    });
    return false;
  });
})
</script>
<!-- luffy end -->
