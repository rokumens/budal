$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/office_shift_list/",
			type : 'GET',
			// luffy 7 January 2020 07:26 pm
			// error: function(xhr, textStatus, error){
      //   console.log('Error Berat: ' + xhr.responseText);  // luffy
      //   console.log('Error Berat: ' + xhr.statusText); // luffy
      //   console.log('Error Berat: ' + textStatus); // luffy
      //   console.log('Error Berat: ' + error); // luffy
      //   toastr.error("Error. Please contact dev team.");
			// }
		},
		/*dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}*/
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('.clockpicker').clockpicker();
	var input = $('.timepicker').clockpicker({
		placement: 'bottom',
		align: 'left',
		autoclose: true,
		'default': 'now'
	});
	$(".clear-time").click(function(){
		var clear_id  = $(this).data('clear-id');
		$(".clear-"+clear_id).val('');
	});
	/* delete */
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
				}else{
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
		var office_shift_id = button.data('office_shift_id');
		var modal = $(this);
	$.ajax({
		url : site_url+"timesheet/read_shift_record/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=shift&office_shift_id='+office_shift_id,
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
		$('.btn').prop('disabled', true); // luffy 7 January 2020 07:27 pm
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=office_shift&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 7 January 2020 07:27 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.add-form').removeClass('in');
					// luffy 7 January 2020 07:27 pm
					$('.btn').prop('disabled', false);
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			}
		});
	});
}); // end ready function
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'timesheet/delete_shift/'+$(this).data('record-id'));
});
$( document ).on( "click", ".default-shift", function() {
	var officeshift_id = $(this).data('office_shift_id');
	$.ajax({
	type: "GET",
	url: site_url+"timesheet/default_shift/?office_shift_id="+officeshift_id,
		success: function (JSON) {
			var xin_table2 = $('#xin_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : site_url+"timesheet/office_shift_list/",
					type : 'GET'
				},
				"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();
				}
			});
			xin_table2.api().ajax.reload(function(){
				toastr.success(JSON.result);
			}, true);
		}
	});
});
