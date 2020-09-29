$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
    "ajax": {
      url : base_url+"/termination_list/",
      type : 'GET'
    },
		/*dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}*/
  });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	$('#description').trumbowyg();
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
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					toastr.error(JSON.error);
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
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
  // update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var warning_id = button.data('termination_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			enctype: 'multipart/form-data',
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=termination&termination_id='+warning_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var termination_id = button.data('termination_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_termination&termination_id='+termination_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
	/* add */
	$("#xin-form").submit(function(e){
    // luffy 8 Dec 2019 - 05:39 pm
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'termination');
		fd.append("form", action);
		e.preventDefault();
		// $('.save').prop('disabled', true);
    $('.btn').prop('disabled', true); // luffy 18 Dec 2019 10:44 am
		$.ajax({
			url: base_url+'/add_termination/',//e.target.action,
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
					// // luffy 18 Dec 2019 10:47 am
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
});
$( document ).on( "click", ".delete", function() {
  $('input[name=_token]').val($(this).data('record-id'));
  $('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
