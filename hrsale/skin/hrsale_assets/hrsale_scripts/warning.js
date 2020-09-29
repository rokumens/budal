$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/warning_list/",
			type : 'GET',
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
			},
		},
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#description').trumbowyg();
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_employees_warning_to/"+jQuery(this).val(), function(data, status){
			jQuery('#warning_to_ajax').html(data);
		});
		jQuery.get(base_url+"/get_employees_warning_by/"+jQuery(this).val(), function(data, status){
			jQuery('#warning_by_ajax').html(data);
		});
	});
	// // luffy 21 Dec 2019 10:22 am | not used anymore.
	// $(document).on("change",".selectStatus",function(){
	// 	if($(this).val()==1){
	// 		$('.divAttachment').show('fast');
	// 	}else{
	// 		$('.divAttachment').hide('fast');
	// 		$('.attachVal').val('');
	// 		$('.warningAttachment').val('');
	// 	}
	// });
	/* del */
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
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					toastr.error(JSON.error);
					$('.delete-modal').modal('toggle'); //luffy 11 Dec 2019 11:16 pm
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
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

	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var warning_id = button.data('warning_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			enctype: 'multipart/form-data',
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=warning&warning_id='+warning_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var warning_id = button.data('warning_id');
		var modal = $(this);
			$.ajax({
			url : base_url+"/read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=view_warning&warning_id='+warning_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_view").html(response);
				}
			}
		});
	});
	// luffy 9 Dec 2019 - 04:03 pm
	// update warning detail
	$("#update_warning_detail").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=update_warning_detail&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					setTimeout(function(){
						location.href=base_url;
					},1000);
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
			},
		});
	});
	/*add*/
	$("#xin-form").submit(function(e){
		// luffy 8 Dec 2019 - 11:58 on
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'warning');
		fd.append("form", action);
		e.preventDefault();
		$('.btn').prop('disabled', true);
		$.ajax({
			url: base_url+'/add_warning/',//e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
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
					$('.btn').prop('disabled', false);
					// luffy 9 dec 2019 - 12:36 pm
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			},
			error: function(xhr, textStatus, error){
        // console.log('Error Berat: ' + xhr.responseText);  // luffy
        // console.log('Error Berat: ' + xhr.statusText); // luffy
        // console.log('Error Berat: ' + textStatus); // luffy
        // console.log('Error Berat: ' + error); // luffy
        $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
        $('.btn').prop('disabled', true);
        toastr.error("Error. Please contact dev team.");
        setTimeout(function(){
        	location.reload();
        }, 1500);
			}
		});
	});
});	// $(document).ready(function()
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
