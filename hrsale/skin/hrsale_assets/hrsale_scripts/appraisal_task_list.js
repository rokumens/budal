$(document).ready(function(){
	//subtask dinamit bumbumbum hahaa
	let iSubtask=1;
	let subtaskLimit=100;
  $('.addSubtask').click(function(){
     iSubtask++;
		 // if(iSubtask<=subtaskLimit){
			//  	$('.dynamicSubtask').append('<tr id="row'+iSubtask+'"><td><input type="text" name="subtaskTitle[]" placeholder="Set title for subtask" class="form-control" /></td><td style="float:right;"><button type="button" name="remove" id="'+iSubtask+'" class="btn btn-danger btn_remove"><span class="fa fa-close"></span></button></td></tr>');
		 // }else{toastr.error("Subtask title limited up to "+subtaskLimit+" only.");}
		 $('.dynamicSubtask').append('<tr id="row'+iSubtask+'"><td><input type="text" name="subtaskTitle[]" placeholder="Set title for subtask" class="form-control" /></td><td style="float:right;"><button type="button" name="remove" id="'+iSubtask+'" class="btn btn-danger btnRemoveSubtaskTitle"><span class="fa fa-close"></span></button></td></tr>');
  });
  $(document).on('click', '.btnRemoveSubtaskTitle', function(){
     var buttonRemoveSubtaskId = $(this).attr("id");
     $('#row'+buttonRemoveSubtaskId+'').remove();
  });
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/task_listzz/",
			type : 'GET',
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
			},
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('.dailyRequirement').bind('keyup mouseup', function () {
			var dailyRequirement = this.value;
			let result = Math.round(dailyRequirement*30);
			$('.monthlyRequirement').val(result);
	});
  $('.monthlyRequirement').bind('keyup mouseup', function () {
			var monthlyRequirement = this.value;
			let result = Math.round(monthlyRequirement/30);
			$('.dailyRequirement').val(result);
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('.description').trumbowyg();
	jQuery(".subDeptId").change(function(){
		if($(this).val()=='allSubDepartments_val'){
			jQuery.get(base_url+"/get_all_grade/", function(data, status){
				jQuery('.grade_ajax').html(data);
			});
			jQuery.get(base_url+"/create_requirement/", function(data, status){
				jQuery('.minRequirement').html(data);
			});
		}else{
			jQuery.get(base_url+"/get_grade/"+jQuery(this).val(), function(data, status){
				jQuery('.grade_ajax').html(data);
			});
		}
	});
	/* add */
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'add_task_list');
		fd.append("form", action);
		e.preventDefault();
		$('.btn').prop('disabled', true); // luffy 8 January 2020 11:47 am
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 8 January 2020 11:47 am
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				}else{
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('#xin-form')[0].reset(); // To reset form fields
					// luffy 9 dec 2019 - 12:36 pm
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('.description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
					$('.btn').prop('disabled', false); // luffy 8 January 2020 11:47 am
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', true);
				xin_table.api().ajax.reload(function(){
					toastr.error("Error. Please contact dev team.");
				}, true);
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
		});
	});
	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var appraisal_task_id = button.data('appraisal_task_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=task_list_update&appraisal_task_id='+appraisal_task_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	// view and get data
	$('.view-modal-data-bg').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var appraisal_task_id = button.data('appraisal_task_id');
		var modal = $(this);
		$.ajax({
			url: base_url+'/read/',
			type: "GET",
			data: 'jd=1&is_ajax=4&mode=modal&data=view_appraisal_task&type=view_appraisal_task&appraisal_task_id='+appraisal_task_id,
			success: function (response) {
				if(response) {
					$("#pajax_modal_view").html(response);
				}
			},
			// error: function(xhr, textStatus, error) {
			// 		console.log('Error Berat: ' + xhr.responseText);  // luffy
			// 		console.log('Error Berat: ' + xhr.statusText); // luffy
			// 		console.log('Error Berat: ' + textStatus); // luffy
			// 		console.log('Error Berat: ' + error); // luffy
			// },
		});
	});
	/* del */
	$("#delete_record_appraisal_task").submit(function(e){
		/*submit*/
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if(JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}else{
					$('.del-modal-appraisal-task').modal('toggle');
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.c8srf_hash);
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				xin_table.api().ajax.reload(function(){
					toastr.error("Error. Please contact dev team.");
				}, true);
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
		});
	});
}); // end document
$(document).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record_appraisal_task').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
