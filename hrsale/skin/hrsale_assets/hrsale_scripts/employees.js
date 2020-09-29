$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/employees_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}
	});
	var xin_table_deleted = $('#xin_table_deleted').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/employees_list_deleted/",
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
	// use employee ID for email address too.
	$('.employeeId').keyup(function(){
		let empId=$(this).val()+'@asiapowergames.com';
		$('.employeeEmail').val(empId);
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// Date of birth
	$('.date_of_birth').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: '1960:' + new Date().getFullYear()
	});
	// Time of birth
	var input = $('.timepicker').clockpicker({
		placement: 'bottom',
		align: 'left',
		autoclose: true,
		'default': 'now'
	});
	// Date of joining
	$('.date_of_joining').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: '1990:' + ':' + new Date().getFullYear()
	});
	/* delete */
	$("#delete_record").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
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
	/* restore */
	$("#restore_record").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.restore-modal').modal('toggle');
					xin_table_deleted.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
				}
			},
			error: function(xhr, textStatus, error) {
					// console.log('Error Berat: ' + xhr.responseText);  // luffy
					// console.log('Error Berat: ' + xhr.statusText); // luffy
					// console.log('Error Berat: ' + textStatus); // luffy
					// console.log('Error Berat: ' + error); // luffy
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', true);
					xin_table_deleted.api().ajax.reload(function(){
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
		var warning_id = button.data('warning_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=warning&warning_id='+warning_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	// get departments
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#department_ajax').html(data);
		});
	});
	/*add*/
	// luffy modified: 7 Dec 2019 - 01:47 pm
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'employee');
		fd.append("form", action);
		e.preventDefault();
		// luffy 3 January 2020 07:49 pm
		// $('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data: fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 3 January 2020 08:58 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					// $('.save').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('.add-form').removeClass('in');
					$('.select2-selection__rendered').html('--Select--');
					$('#xin-form')[0].reset(); // To reset form fields
					// luffy 3 January 2020 09:05 pm
					// $('.save').prop('disabled', false);
					$('.btn').prop('disabled', false);
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
				toastr.error("Error. Please contact dev team.");
				setTimeout(function(){
					location.reload();
				}, 1500);
			},
		});
	});
});
//del
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
//restore
$( document ).on( "click", ".restore", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#restore_record').attr('action',base_url+'/restore/'+$(this).data('record-id'));
});
