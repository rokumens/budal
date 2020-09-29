$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
     "bDestroy": true,
  	 "ajax": {
          url : site_url+"timesheet/leave_list/",
          type : 'GET'
      },
  		"fnDrawCallback": function(settings){
  		    $('[data-toggle="tooltip"]').tooltip();
  		}
  });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_leave_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	$('#remarks').trumbowyg();
	// Date
	$('.date').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: new Date().getFullYear() + ':' + (new Date().getFullYear() + 10),
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
		var leave_id = button.data('leave_id');
		var modal = $(this);
	$.ajax({
		url : site_url+"timesheet/read_leave_record/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=leave&leave_id='+leave_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	/* Add */
	$("#xin-form").submit(function(e){
	  e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.btn').prop('disabled', true); // luffy 8 January 2020 10:36 am
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=leave&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          // luffy 8 January 2020 10:34 am
          $('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
				} else {
          xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in'); // luffy 8 January 2020 10:37 am
					$('.btn').prop('disabled', false);
          // luffy 8 January 2020 10:35 am
					// clear all fields
          $('#xin-form')[0].reset(); // To reset form fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('.select2-hidden-accessible').val(null).trigger('change');
          $('#remaining_leave').hide();
				}
			},error: function(xhr, textStatus, error) {
  				// console.log('Error Berat: ' + xhr.responseText);  // luffy
  				// console.log('Error Berat: ' + xhr.statusText); // luffy
  				// console.log('Error Berat: ' + textStatus); // luffy
  				// console.log('Error Berat: ' + error); // luffy
  				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
  				xin_table.api().ajax.reload(function(){
  					toastr.error("Error. Please contact dev team.");
  				}, true);
  				setTimeout(function(){
  					location.reload();
  				}, 1500);
  		},
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'timesheet/delete_leave/'+$(this).data('record-id'));
});
