<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['appraisal_task_id']) && $_GET['data']=='task_list_update'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Update Main Task</h4>
</div>
<?php $attributes = array('name' => 'edit_appraisal_task', 'id' => 'edit_appraisal_task', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $appraisal_task_id, 'ext_name' => $appraisal_task_id);?>
<?=form_open('admin/appraisal_task_list/update/'.$appraisal_task_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row m-b-1">
      <div class="col-md-12">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="maintask">Main Task</label>
                  <input class="form-control" value="<?=$name;?>" placeholder="Set the main task name" name="maintask" type="text">
                </div>
                <?php if(!is_null($allSubtaskTitle)):?>
                <div class="form-group">
                  <label for="subtaskTitle">Subtask Title</label>
                  <div class="table-responsive">
                    <!-- luffy 29 Dec 2019 11:20 am -->
                    <table class="table dynamicSubtaskTitleOnUpdate" style='border:none !important;'>
                      <?php foreach($allSubtaskTitle as $singSubtaskTitle):?>
                        <tr id="currentRowSubtaskTitleOnUpdate<?=$singSubtaskTitle->id;?>" style='margin-bottom:0 !important;'>
                          <td width="100%">
                            <input type="text" name="subtaskTitle<?=$singSubtaskTitle->id;?>" style='margin-bottom:10px;' value='<?=$singSubtaskTitle->sub_task_title_name;?>' class="form-control" />
                          </td>
                          <td style="float:right;">
                            <button type="button" name="remove" id="<?=$singSubtaskTitle->id;?>" class="btn btn-danger btnRemoveCurrentSubtaskTitle_<?=$singSubtaskTitle->id;?>"><span class="fa fa-close"></span></button>
                          </td>
                        </tr>
                        <script type="text/javascript">
                          // luffy 29 Dec 2019 03:03 pm
                          $( document ).on( "click", ".btnRemoveCurrentSubtaskTitle_<?=$singSubtaskTitle->id;?>", function() {
                            if(confirm('Delete this subtask title?')) {
                              $('input[name=_token]').val($(this).attr("id"));
                              var subtaskIdOnUpdate = $(this).attr("id");
                              $.ajax({
                                type: 'DELETE',
                                headers: { 'Access-Control-Allow-Methods':'DELETE'},
                                url: base_url+'/delete_subtask_title/'+$(this).attr("id"),
                                data: "id="+ subtaskIdOnUpdate,
                                success: function(){
                                  $('#currentRowSubtaskTitleOnUpdate'+subtaskIdOnUpdate).remove();
                                  toastr.success('Subtask title deleted.');
                                },
                                error: function(xhr, textStatus, error) {
                                  // console.log('Error Berat: ' + xhr.responseText);  // luffy
                                  // console.log('Error Berat: ' + xhr.statusText); // luffy
                                  // console.log('Error Berat: ' + textStatus); // luffy
                                  // console.log('Error Berat: ' + error); // luffy
                                  toastr.error("Error. Please contact dev team.");
                                },
                              });
                            }else{
                              return false;
                            }
                          });
                        </script>
                      <?php endforeach;?>
                      <!-- luffy 29 December 2019 04:47 pm -->
                      <?php $attributes = array('name' => 'delete_record', 'id' => 'delete_record_subtaskTitle_on_maintask', 'autocomplete' => 'off', 'role'=>'form');?>
                      <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>
                      <?=form_open('', $attributes, $hidden);?>
                  		<?php
                    		$del_token = array(
                    			'type'  => 'hidden',
                    			'id'  => 'token_type',
                    			'name'  => 'token_type',
                    			'value' => 0,
                    		); echo form_input($del_token)
                      ;?>
                      <!-- luffy 29 December 2019 01:44pm -->
                      <tr style='margin-bottom:0 !important;'>
                         <td width="90%"><input type="text" name="subtaskTitle[]" placeholder="Set title for subtask" class="form-control" /></td>
                         <td style='float:right;'><button type="button" name="gapunyanama" class="btn btn-success addSubtaskTitleOnUpdate"><span class="fa fa-plus"></span></button></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <?php endif;?>
                <div class="row">
                  <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                      <label for="name"><?=$this->lang->line('xin_hr_sub_department');?></label>
                      <!-- <select name="subdepartment_id" class="form-control subDeptId" data-plugin="select_hrm" data-placeholder="Select sub department"> -->
                      <select name="subdepartment_id" class="form-control" data-plugin="select_hrm" data-placeholder="Select sub department">
                        <option value="">Choose sub department</option>
                        <?php foreach($subDept as $singSubDept) {?>
                        <option value="<?=$singSubDept->sub_department_id;?>" <?php if($subDeptIdAppraisal==$singSubDept->sub_department_id):?> selected="selected" <?php endif;?>><?=$singSubDept->department_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                      <label for="name">Office Shift</label>
                      <select name="office_shift" class="form-control" data-plugin="select_hrm" data-placeholder="Choose shift">
                        <option value="">Choose shift</option>
                        <option value="allShift_val">All Shift</option>
                        <?php foreach($allShift as $singShift) {?>
                        <option value="<?=$singShift->office_shift_id;?>" <?php if($shiftId==$singShift->office_shift_id):?> selected="selected" <?php endif;?>><?=$singShift->shift_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="description"><?=$this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea description" placeholder="Main Task <?=$this->lang->line('xin_description');?>" name="description" rows="9"><?=str_replace('\"',"",html_entity_decode(strip_tags($description)));?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box-datatable table-responsive">
                  <div><label>Grade List for this main task</label></div>
                  <table class="datatables-demo table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th align='center'>Grade</th>
                        <th align='center'>Daily Requirement</th>
                        <th align='center'>Monthly Requirement</th>
                      </tr>
                      <?php foreach($allGradeByMainTask as $singGrade):?>
                      <tr>
                        <td align='center'><?=$singGrade->grade_name;?></td>
                        <td align='center'><?=$singGrade->minimum_daily_requirement;?></td>
                        <td align='center'><?=$singGrade->minimum_monthly_requirement;?></td>
                      </tr>
                    <?php endforeach;?>
                    </thead>
                  </table>
                  <small><i>Update or Add new grade in <a href='grade_list'>Grade List</a> &raquo;</i></small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?=$this->lang->line('xin_update');?></button>
  </div>
<?=form_close(); ?>
<script type='text/javascript'>
$(document).ready(function(){
  // luffy 29 December 2019 12:08 pm
  // dynamic subtask title
	let iSubtaskOnUpdate=<?=count($allSubtaskTitle)?>;
  $('.addSubtaskTitleOnUpdate').click(function(){
     iSubtaskOnUpdate++;
     $('.dynamicSubtaskTitleOnUpdate').append('<tr id="addRowSubtaskTitleOnUpdate'+iSubtaskOnUpdate+'"><td><input type="text" name="subtaskTitle[]" placeholder="Set title for subtask" class="form-control" /></td><td style="float:right;"><button type="button" name="remove" id="'+iSubtaskOnUpdate+'" class="btn btn-danger btnRemoveSubtaskTitle"><span class="fa fa-close"></span></button></td></tr>');
  });
  $(document).on('click', '.btnRemoveSubtaskTitle', function(){
     var buttonRemoveSubtaskIdOnUpdate = $(this).attr("id");
     $('#addRowSubtaskTitleOnUpdate'+buttonRemoveSubtaskIdOnUpdate).remove();
  });
  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
  $('.description').trumbowyg();
  jQuery(".subDeptId").change(function(){
		jQuery.get(base_url+"/get_grade/"+jQuery(this).val(), function(data, status){
			jQuery('.grade_ajax').html(data);
		});
    $('.dailyRequirement').val('');
    $('.monthlyRequirement').val('');
	});
  /* update */
	$("#edit_appraisal_task").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=task_list_update&form="+action,
			cache: false,
			success: function (JSON,data) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
  					"bDestroy": true,
  					"ajax": {
  						url : base_url+"/task_listzz",
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
          // console.log(e.target);return false;
          // console.log(obj.serialize());return false;
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', true);
				toastr.error("Error. Please contact dev team.");
			},
		});
	});
})
</script>
<?php }elseif(isset($_GET['jd']) && isset($_GET['appraisal_task_id']) && $_GET['data']=='view_appraisal_task' && $_GET['type']=='view_appraisal_task'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View Main Task</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Main Task</label><br />
        <?=$name;?>
      </div>
      <div class="form-group">
        <label>Subtask</label><br />
        <?=$listAllSubtaskTitle;?>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Sub Department</label><br />
            <?=$department_name;?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Office Shift</label><br />
            <?=$shiftName;?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label><?=$this->lang->line('xin_description');?></label><br />
        <?=(empty($description))?'-':str_replace('\"',"",html_entity_decode(strip_tags($description)));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box-datatable table-responsive">
        <div><label>Grade List for this main task</label></div>
        <table class="datatables-demo table table-striped table-bordered">
          <thead>
            <tr>
              <th align='center'>Grade</th>
              <th align='center'>Daily Requirement</th>
              <th align='center'>Monthly Requirement</th>
            </tr>
            <?php foreach($allGradeByMainTask as $singGrade):?>
            <tr>
              <td align='center'><?=$singGrade->grade_name;?></td>
              <td align='center'><?=$singGrade->minimum_daily_requirement;?></td>
              <td align='center'><?=$singGrade->minimum_monthly_requirement;?></td>
            </tr>
          <?php endforeach;?>
          </thead>
        </table>
        <small><i>View <a href='grade_list'>Grade List</a> &raquo;</i></small>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$this->lang->line('xin_close');?></button>
</div>
<?php }
?>
