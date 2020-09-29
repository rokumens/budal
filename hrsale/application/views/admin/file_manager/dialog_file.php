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
if(isset($_GET['jd']) && isset($_GET['file_id']) && $_GET['data']=='file_manager'){
?>
<?php $ext = pathinfo($file_name, PATHINFO_EXTENSION);?>
<?php $file = basename($file_name, '.'.$ext);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Edit</h4>
</div>
<?php $attributes = array('name' => 'edit_file', 'id' => 'edit_file', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'file_id' => $file_id, 'ext_name' => $ext);?>
<?=form_open('admin/files/update/'.$file_id, $attributes, $hidden);?>
<?php
$data = array(
  'name'        => 'did',
  'id'          => 'did',
  'type'        => 'hidden',
  'value'       => $department_id,
  'class'       => 'form-control',
);
echo form_input($data);
?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="file_name">File Name</label>
        <input class="form-control" placeholder="<?=$this->lang->line('xin_new_file_name');?>" name="name" type="text" value="<?=$name;?>">
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <?php if($file_name!=''):?>
        <i class="fa fa-eye" aria-hidden="true" style="color:blue;"></i>&nbsp;
        <a class="view-pdf" data-toggle="modal" data-target="#pdfSPmodal" data-dismiss="modal" href="<?=site_url()?>uploads/files/<?=$file_name;?>">
          See file
        </a>
        <span style='padding:0 10px 0;'>|</span>
        <i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i>&nbsp;
        <a href='<?=site_url('admin/download?type=files&filename=').$file_name?>'>Download</a>
        <?php else:?> - <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="oldfname" value="<?=$file_name;?>">
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
  <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
</div>
<?=form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		/* add */
		$("#edit_file").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=file&form="+action,
				cache: false,
				success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table_files = $('#xin_table_files').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?=site_url("admin/files/files_list") ?>/dId/"+$('#did').val(),
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();
						}
					});
					xin_table_files.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.payroll_template_modal').modal('toggle');
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});
</script>

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
      title:'File',
      message: iframe,
      closeButton:true,
      scrollable:false
    });
    return false;
  });
})
</script>
<!-- luffy end -->

<?php }?>
