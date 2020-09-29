$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/assign_rewards/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery(".aj_subdept").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('.employee_ajax').html(data);
		});
		jQuery.get(base_url+"/get_rewards/"+jQuery(this).val(), function(data, status){
			jQuery('.rewards_ajax').html(data);
		});
	});
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'add_assign_rewards');
		fd.append("form", action);
		e.preventDefault();
		$('.btn').prop('disabled', true); // luffy 8 January 2020 04:16 pm
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
					// luffy 8 January 2020 04:16 pm
					$('.btn').prop('disabled', false);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
					// luffy 8 January 2020 04:16 pm
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

	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var assign_rewards_id = button.data('assign_rewards_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=assign_rewards_update&assign_rewards_id='+assign_rewards_id,
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
		var assign_rewards_id = button.data('assign_rewards_id');
		var modal = $(this);
		$.ajax({
			url: base_url+'/read/',
			type: "GET",
			data: 'jd=1&is_ajax=4&mode=modal&data=view_assign_rewards&type=view_assign_rewards&assign_rewards_id='+assign_rewards_id,
			success: function (response) {
				if(response) {
					$("#pajax_modal_view").html(response);
				}
			}
		});
	});

	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
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
	// for date picker
	$('.rewardsDate').datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: '0',
		dateFormat:'yy-mm-dd',
		altField: "#date_format",
		altFormat: js_date_format,
		yearRange: '1970:' + new Date().getFullYear(),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});

}); // end document

$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
