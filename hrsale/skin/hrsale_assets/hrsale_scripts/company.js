$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
		"ajax": {
      url : base_url+"/company_list/",
      type : 'GET',
      error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				xin_table.api().ajax.reload(function(){
					toastr.error("Error. Please contact dev team.");
				}, true);
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
    },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}
  });
  var xin_table_deleted = $('#xin_table_deleted').dataTable({
    "bDestroy": true,
		"ajax": {
      url : base_url+"/company_list_deleted/",
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
	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var company_id = button.data('company_id');
		var modal = $(this);
	  $.ajax({
  		url : base_url+"/read/",
  		type: "GET",
  		data: 'jd=1&is_ajax=1&mode=modal&data=company&company_id='+company_id,
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
		var company_id = button.data('company_id');
		var modal = $(this);
  	$.ajax({
  		url : base_url+"/read/",
  		type: "GET",
  		data: 'jd=1&is_ajax=1&mode=modal&data=view_company&company_id='+company_id,
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
		fd.append("add_type", 'company');
		fd.append("form", action);
		e.preventDefault();
		$('.btn').prop('disabled', true); // luffy 8 January 2020 06:02 pm
		$.ajax({
			url: base_url+'/add_company/',//e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON){
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          // luffy 8 January 2020 06:02 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
          // luffy 8 January 2020 06:02 pm
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
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
	   });
	});
}); //luff, end ready function
//open the lateral panel
$( document ).on( "click", ".cd-btn", function() {
	event.preventDefault();
	var company_id = $(this).data('company_id');
	$.ajax({
	url : site_url+"company/read_info/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=view_company&company_id='+company_id,
	success: function (response) {
		if(response) {
			//alert(response);
			$('.cd-panel').addClass('is-visible');
			$("#cd-panel").html(response);
		}
	}
	});
});
//clode the lateral panel
$( document ).on( "click", ".cd-panel", function() {
	if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) {
		$('.cd-panel').removeClass('is-visible');
		event.preventDefault();
	}
});
//del
$(document).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
//luffy restore
$(document).on( "click", ".restore", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#restore_record').attr('action',base_url+'/restore/'+$(this).data('record-id'));
});
