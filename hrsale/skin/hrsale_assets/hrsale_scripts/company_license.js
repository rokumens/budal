$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
  	"ajax": {
      url : base_url+"/document_list/",
      type : 'GET'
    },
  	"fnDrawCallback": function(settings){
  	   $('[data-toggle="tooltip"]').tooltip();
  	}
  });
  var xin_table_deleted = $('#xin_table_deleted').dataTable({
    "bDestroy": true,
  	"ajax": {
      url : base_url+"/document_list_deleted/",
      type : 'GET'
    },
  	"fnDrawCallback": function(settings){
  	   $('[data-toggle="tooltip"]').tooltip();
  	}
  });
	$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
	$('[data-plugin="xin_select"]').select2({ width:'100%' });
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
	/* luffy restore */
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
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}
			}
		});
	});
	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var document_id = button.data('document_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read_document/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=document&document_id='+document_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	// view
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var document_id = button.data('document_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read_document/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_document&document_id='+document_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
	/* add */
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'official_document');
		fd.append("form", action);
		e.preventDefault();
		$('.btn').prop('disabled', true); // luffy 8 January 2020 06:28 pm
		$.ajax({
			url: base_url+'/add_official_document/',
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON){
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          // luffy 8 January 2020 06:28 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
          // luffy 8 January 2020 06:28 pm
          // clear all fields
					$('#xin-form')[0].reset(); // To reset form fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			},
			// luffy start
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
        // setTimeout(function(){
        //   location.reload();
        // }, 2000);
      },
	   });
	});
});
$(document).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete_document/'+$(this).data('record-id'));
});
// luffy restore
$(document).on( "click", ".restore", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#restore_record').attr('action',base_url+'/restore_document/'+$(this).data('record-id'));
});
