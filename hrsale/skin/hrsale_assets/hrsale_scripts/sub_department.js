$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
		"ajax": {
      url : base_url+"/sub_department_list/",
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
   var xin_table_deleted = $('#xin_table_deleted').dataTable({
    "bDestroy": true,
		"ajax": {
      url : base_url+"/sub_department_list_deleted/",
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
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
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
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
				}
			},
      // },
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
      },
		});
	});
	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var department_id = button.data('department_id');
		var modal = $(this);
  	$.ajax({
  		url : base_url+"/read_sub_record/",
  		type: "GET",
  		data: escapeHtmlSecure('jd=1&is_ajax=1&mode=modal&data=department&department_id='+department_id),
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
		$('.btn').prop('disabled', true); // luffy 8 January 2020 05:22 pm
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=department&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          // luffy 8 January 2020 05:22 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('.icon-spinner3').hide();
					$('.btn').prop('disabled', false);
          // luffy 8 January 2020 05:22 pm
          // clear all fields
					$('#xin-form')[0].reset(); // To reset form fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	var delUrl = base_url+'/sub_delete/'+$(this).data('record-id');
	$('#delete_record').attr('action',escapeHtmlSecure(delUrl));
});
$( document ).on( "click", ".restore", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	var delUrl = base_url+'/sub_restore/'+$(this).data('record-id');
	$('#restore_record').attr('action',escapeHtmlSecure(delUrl));
});
