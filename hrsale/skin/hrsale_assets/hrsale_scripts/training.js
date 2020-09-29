$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/training_list/",
			type : 'GET',
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' +	 xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
			},
		},
		"fnDrawCallback": function(settings){
		  $('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#description').trumbowyg();
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
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
	// udpate
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var training_id = button.data('training_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=training&training_id='+training_id,
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
		$('.btn').prop('disabled', true); // luffy 11 January 10:47 am
		$(".icon-spinner3").show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=training&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					 // luffy 11 January 10:47 am
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$(".icon-spinner3").hide();
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$(".icon-spinner3").hide();
					$('.btn').prop('disabled', false);
					 // luffy 11 January 10:47 am
					 // clear all fields
 					$('#xin-form')[0].reset(); // To reset form fields
 					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
     			$(':checkbox, :radio').prop('checked', false);
 					$('#description').trumbowyg('empty');
 					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			},
			// luffy 11 January 2020 11:38 am
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
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'))+'/';
});
