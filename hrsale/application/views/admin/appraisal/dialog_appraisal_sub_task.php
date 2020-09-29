<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['subtask_id']) && $_GET['data']=='subtask_update'){
$role_resources_ids = $this->Xin_model->user_role_resource();
if((in_array('2084',$role_resources_ids))||(in_array('2085',$role_resources_ids))){
  $auditorReviewer='TRUE';
  $disabled='disabled';
  $displayNone='display:none;';
}else{
  $auditorReviewer='FALSE';
  $disabled='';
  $displayNone='';
}
?>
<style type="text/css">
.iframe-container {padding-bottom:60%;padding-top:30px;height:0;overflow:hidden;}
.iframe-container iframe,
.iframe-container object,
.iframe-container embed {position:absolute;top:0;left:0;width:100%;height:100%;}
.luffy-modal {width:65% !important;margin:auto;}
</style>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Subtask</h4>
</div>
<?php $attributes = array('name' => 'edit_subtask', 'id' => 'edit_subtask', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $subtask_id, 'ext_name' => $subtask_id);?>
<?=form_open_multipart('admin/appraisal_sub_task/update/'.$subtask_id, $attributes, $hidden);?>
  <input type="hidden" name="subtask_id" value="<?=$subtask_id;?>">
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Main Task</label>
                  <input class="form-control" readonly value='<?=$jobTaskName;?>' name="job_task" type="text">
                </div>
                <div class="form-group">
                  <label for="subtask_name">Subtask</label>
                  <?php if($auditorReviewer==='FALSE'):?>
                    <select name="subtask_name" class="form-control" data-plugin="select_hrm" data-placeholder="Select subtask title">
                      <?php foreach($allSubtaskByMainTask as $singSubtaskTitle) {?>
                      <option value="<?=$singSubtaskTitle->id?>" <?php if($subtaskTitleId==$singSubtaskTitle->id):?> selected="selected" <?php endif;?>><?=$singSubtaskTitle->sub_task_title_name;?></option>
                      <?php } ?>
                    </select>
                    <?php else:?>
                    <select name="noname" class="form-control" data-plugin="select_hrm" data-placeholder="Select subtask title" disabled>
                      <?php foreach($allSubtaskByMainTask as $singSubtaskTitle) {?>
                      <option value="<?=$singSubtaskTitle->id?>" <?php if($subtaskTitleId==$singSubtaskTitle->id):?> selected="selected" <?php endif;?>><?=$singSubtaskTitle->sub_task_title_name;?></option>
                      <?php } ?>
                    </select>
                    <input class="form-control" readonly value='<?=$subtaskTitleId;?>' name="subtask_name" type="hidden">
                  <?php endif;?>
                </div>
                <div class="row" style="<?=$displayNone;?>">
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="scan_file">Upload Image</label>
                        <input type="file" class="form-control-file" accept="image/png, image/jpg, image/jpeg, application/pdf" id="scan_file" name="scan_file">
                        <small>Image allowed: png, jpg, jpeg</small>
                      </fieldset>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php if($subtaskFile!='' && $subtaskFile!='no file'):?>
                        <label for="scan_file">&nbsp;</label>
                        <br />
                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        <a class="view-file" data-toggle="modal" data-target=".subtaskModal" data-dismiss="modal" href="<?=site_url()?>uploads/appraisal/subtask/<?=$subtaskFile;?>">
                          View image
                        </a>
                      <?php endif;?>
                    </div>
                  </div>
                </div>
                <div class="row" style="<?=$displayNone;?>">
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="scan_video">Upload Video</label>
                        <input type="file" class="form-control-file" accept="video/mp4, video/mkv, video/avi" id="scan_video" name="scan_video">
                        <small>Image allowed: mp4, mkv, avi</small>
                      </fieldset>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php if($subtaskFileVideo!='' && $subtaskFileVideo!='no file'):?>
                        <label for="scan_file">&nbsp;</label>
                        <br />
                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        <a class="view-file" data-toggle="modal" data-target=".subtaskModal" data-dismiss="modal" href="<?=site_url()?>uploads/appraisal/subtask/<?=$subtaskFileVideo;?>">
                          View video
                        </a>
                      <?php endif;?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="urlPost">Url</label>
                  <input class="form-control" placeholder="Use http:// or https://" value='<?=(empty($subtaskUrl))?'':'http://'.$subtaskUrl;?>' name="url" type="url" />
                </div>
                <!-- approval by Auditor & Reviewer in the Role-->
                <?php if(in_array('2084',$role_resources_ids)): #Approval: "Valid & Rejected" by Auditor?>
                <div class="form-group">
                  <label for="subtask_status">Status</label>
                  <select name="subtask_status" class="form-control" data-plugin="select_hrm" data-placeholder="Select subtask status">
                    <?php if($subtaskStatusId!=1):?>
                      <option value='3' <?php if($subtaskStatusId==3):?>selected='selected'<?php endif;?>>Pending</option>
                      <?php foreach($allSubTaskStatusAuditor as $singStatusAuditor){?>
                      <option value="<?=$singStatusAuditor->id?>" <?php if($subtaskStatusId==$singStatusAuditor->id):?> selected="selected" <?php endif;?>><?=$singStatusAuditor->name?></option>
                      <?php } ?>
                    <?php else:?>
                      <option value='4' selected='selected'>Qualified</option>
                    <?php endif;?>
                  </select>
                </div>
                <?php elseif(in_array('2085',$role_resources_ids)): #Approval: "Qualified & Rejected" by Reviewer?>
                  <?php if(($asReviewer==TRUE)&&($isValidByAuditor==1)):?>
                  <div class="form-group">
                    <label for="subtask_status">Status</label>
                    <select name="subtask_status" class="form-control" data-plugin="select_hrm" data-placeholder="Select subtask status">
                      <option value='2' <?php if($subtaskStatusId==2):?>selected='selected'<?php endif;?>>Valid</option>
                      <?php foreach($allSubTaskStatusReviewer as $singStatusReviewer){?>
                        <option value="<?=$singStatusReviewer->id?>" <?php if($subtaskStatusId==$singStatusReviewer->id):?> selected="selected" <?php endif;?>><?=$singStatusReviewer->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php else:?>
                    <div class="form-group">
                      <label for="subtask_status">Status</label>
                      <select name="gaperlunamacumabuatdisplay" class="form-control" data-plugin="select_hrm" data-placeholder="Select subtask status" disabled>
                        <?php foreach($allSubtaskStatus as $singAllSubtaskStatus) {?>
                          <option value="<?=$singAllSubtaskStatus->id?>" <?php if($subtaskStatusId==$singAllSubtaskStatus->id):?> selected="selected" <?php endif;?>><?=$singAllSubtaskStatus->name?></option>
                        <?php } ?>
                      </select>
                      <input name='subtask_status' value='<?=$subtaskStatusId;?>' readonly type='hidden' class='form-control' />
                    </div>
                  <?php endif;?>
                <?php else:?>
                  <div class="form-group">
                    <label for="subtask_status">Status</label>
                    <input class="form-control" readonly value='<?=$statusName;?>' name="gaperlunama" type="text">
                    <input class="form-control" readonly value='<?=$statusId;?>' name="subtask_status" type="hidden">
                  </div>
                <?php endif;?>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description">Note</label>
                  <?php if(($asReviewer==TRUE)||($asAuditor==TRUE)):?>
                  <textarea class="form-control textarea description" placeholder="Subtask's note" name="gaperlunama" rows="12" disabled><?=(empty($subTaskDescription))?'':$subTaskDescription;?></textarea>
                  <!-- <textarea class="form-control" placeholder="Subtask's note" style="visibility:hidden" name="subtask_description" rows="9"><?=$subTaskDescription;?></textarea> -->
                  <input class="form-control" readonly value='<?=$subTaskDescription;?>' name="subtask_description" type="hidden">
                  <?php else:?>
                  <textarea class="form-control textarea description" placeholder="Subtask's note" name="subtask_description" rows="12"><?=$subTaskDescription;?></textarea>
                  <?php endif;?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php if((($asReviewer==TRUE)&&($isValidByAuditor==0))||(($asMyOwn==TRUE)&&($isValidByAuditor==0)&&($isQualifiedByReviewer==0)&&($subtaskStatusId==3))):?>
      <div class="col-md-6 col-xs-6">
        <span style='float:left !important; text-align:left !important;'><small><i>Waiting for Auditor to <b><i>valid</i></b> this subtask. <br />You can still edit it if needed.</i></small></span>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
        <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
      </div>
    <?php elseif(($asMyOwn==TRUE)&&($subtaskStatusId==4)&&($isRejectedByAuditor==1)):?>
      <div class="col-md-6 col-xs-6">
        <span style='float:left !important; text-align:left !important;'><small><i>It has been <b><i>rejected by Auditor</b>. <br />You can still edit it and resubmit this subtask.</i></small></span>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
        <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
      </div>
    <?php elseif(($asMyOwn==TRUE)&&($isValidByAuditor==1)&&($isQualifiedByReviewer==0)&&($subtaskStatusId==2)):?>
      <div class="col-md-6 col-xs-6">
        <span style='float:left !important; text-align:left !important;'><small><i>It has been <b><i>validated</i></b>, no more updating this subtask.</i></small></span>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
      </div>
    <?php elseif(($asMyOwn==TRUE)&&($isValidByAuditor==1)&&($isQualifiedByReviewer==1)&&($subtaskStatusId==1)):?>
      <div class="col-md-6 col-xs-6">
        <span style='float:left !important; text-align:left !important;'><small><i>It has been <b><i>qualified</i></b>, no more updating this subtask.</i></small></span>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
      </div>
    <?php elseif(($asAuditor==TRUE)&&($isValidByAuditor==1)&&($isQualifiedByReviewer==1)&&($subtaskStatusId==1)):?>
      <div class="col-md-6 col-xs-6">
        <span style='float:left !important; text-align:left !important;'><small><i>It has been <b><i>qualified</i></b>, no more updating this subtask.</i></small></span>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
      </div>
    <?php elseif(($asMyOwn==TRUE)&&($subtaskStatusId==4)&&($isRejectedByReviewer==1)): #rejected?>
      <div class="col-md-6 col-xs-6">
        <span style='float:left !important; text-align:left !important;'><small><i>It has been <b><i>rejected</i> by Reviewer</b>. Try to create a new subtask.</i></small></span>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
      </div>
    <?php else:#asAuditor||asMyOwn?>
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
      <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
    <?php endif;?>
  </div>
<?=form_close(); ?>
<script type='text/javascript'>
$(document).ready(function(){
  $('.description').trumbowyg();
  /* update */
	$("#edit_subtask").submit(function(e){
    var fd = new FormData(this);
    var obj = $(this), action = obj.attr('name');
    fd.append("is_ajax", 2);
    fd.append("edit_type", 'subtask_update');
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
      success: function(JSON){
        if (JSON.error != '') {
          toastr.error(JSON.error);
          $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
        } else {
          // On page load: datatable
          var xin_table = $('#xin_table').dataTable({
              "bDestroy": true,
              "ajax": {
  						url : base_url+"/subtask_list",
              type : 'GET'
            },
            // dom: 'lBfrtip',
            // "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
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
			error: function(xhr, textStatus, error) {
        console.log('Error Berat: ' + xhr.responseText);  // luffy
        console.log('Error Berat: ' + xhr.statusText); // luffy
        console.log('Error Berat: ' + textStatus); // luffy
        console.log('Error Berat: ' + error); // luffy
        // $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
        // $('.save').prop('disabled', true);
        // xin_table.api().ajax.reload(function(){
        //   toastr.error("Error. Please contact dev team.");
        // }, true);
        // setTimeout(function(){
        //   location.reload();
        // }, 1500);
			},
		});
	});
})
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['subtask_id']) && $_GET['data']=='view_subtask' && $_GET['type']=='view_subtask'){?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title view-modal-data" id="view-modal-data">View Subtask</h4>
</div>
<form class="m-b-1">
<div class="modal-body">
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th>Main Task</th>
          <td style="display: table-cell;"><?=$jobTaskName;?></td>
        </tr>
        <tr>
          <th>Subtask</th>
          <td style="display: table-cell;"><?=$subtaskName;?></td>
        </tr>
        <tr>
          <th>Url</th>
          <td style="display: table-cell;"><?=(empty($subtaskUrl))?'-':"<a href='http://".$subtaskUrl."'>http://$subtaskUrl<a/>";?></td>
        </tr>
        <tr>
          <th>Image</th>
          <td style="display: table-cell;">
            <?php if(!empty($subtaskFile)):?>
            <i class="fa fa-eye-slash" aria-hidden="true"></i>
            <a class="view-file" data-toggle="modal" data-target=".subtaskModal" data-dismiss="modal" href="<?=site_url()?>uploads/appraisal/subtask/<?=$subtaskFile;?>">View image</a>
          <?php else:?>-<?php endif;?>
          </td>
        </tr>
        <tr>
          <th>Video</th>
          <td style="display: table-cell;">
            <?php if(!empty($subtaskFileVideo)):?>
            <i class="fa fa-eye-slash" aria-hidden="true"></i>
            <a class="view-file" data-toggle="modal" data-target=".subtaskModal" data-dismiss="modal" href="<?=site_url()?>uploads/appraisal/subtask/<?=$subtaskFileVideo;?>">View video</a>
          <?php else:?>-<?php endif;?>
          </td>
        </tr>
        <tr>
          <th valign='top'>Note</th>
          <td style="display: table-cell;"><?=(empty($subTaskDescription))?'-':html_entity_decode($subTaskDescription);?></td>
        </tr>
        <tr>
          <th>Status</th>
          <td style="display: table-cell;"><?=$statusDetail;?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
</div>
<?php }?>
<script language="javascript" type="text/javascript">
(function(a){a.createModal=function(b){defaults={title:"",message:"",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height:800px;overflow-y: auto;"':"";html='<div class="modal fade subtaskModal" id="">';html+='<div class="modal-dialog luffy-modal">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a(".subtaskModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);
$(function(){
  $('.view-file').on('click',function(){
    $(".edit-modal-data").modal("hide");
    $(".view-modal-data-bg").modal("hide");
    var file_link = $(this).attr('href');
    var iframe = '<div class="iframe-container"><iframe src="'+file_link+'"></iframe></div>'
    $.createModal({
      title:'Subtask File',
      message: iframe,
      closeButton:true,
      scrollable:false
    });
    return false;
  });
})
</script>
