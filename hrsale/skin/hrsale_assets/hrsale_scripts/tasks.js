$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/task_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#description').trumbowyg();
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_company_project/"+jQuery(this).val(), function(data, status){
			jQuery('#project_ajax').html(data);
		});
		jQuery.get(base_url+"/get_company_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	// Date
	$('.date').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: new Date().getFullYear() + ':' + (new Date().getFullYear() + 10)
	});
	/* del */
	$("#delete_record").submit(function(e){
	  e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}
			}
		});
	});
	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var task_id = button.data('task_id');
		var mname = button.data('mname');
		var modal = $(this);
		$.ajax({
			url : site_url+"timesheet/read_task_record/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=task&task_id='+task_id+"&mname="+mname,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	/* add */
	$("#xin-form").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.btn').prop('disabled', true); // luffy 9 January 2020 08:41 pm
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=task&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 9 January 2020 08:41 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
					// luffy 9 January 2020 08:41 pm
					// clear all fields
					$('#xin-form')[0].reset(); // To reset form fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			},
      error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				xin_table.api().ajax.reload(function(){
					toastr.error("Error. Please contact dev team.");
				}, true);
			},
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'timesheet/delete_task/'+$(this).data('record-id'));
});
