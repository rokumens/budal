$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
  	"ajax": {
        url : base_url+"/role_list/",
        type : 'GET'
    },
  });
  var xin_table_deleted = $('#xin_table_deleted').dataTable({
    "bDestroy": true,
  	"ajax": {
        url : base_url+"/role_list_deleted/",
        type : 'GET',
        // error: function(xhr, textStatus, error) {
        //   console.log('Error Berat: ' + xhr.responseText);  // luffy
        //   console.log('Error Berat: ' + xhr.statusText); // luffy
        //   console.log('Error Berat: ' + textStatus); // luffy
        //   console.log('Error Berat: ' + error); // luffy
        // },
    },
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
		var role_id = button.data('role_id');
		var modal = $(this);
  	$.ajax({
  		url : base_url+"/read/",
  		type: "GET",
  		data: 'jd=1&is_ajax=1&mode=modal&data=role&role_id='+role_id,
  		success: function (response) {
  			if(response) {
  				$("#ajax_modal").html(response);
  			}
  		},error: function(xhr, textStatus, error) {
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
	/* add */
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=role&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('.add-form').removeClass('in');
					$('.select2-selection__rendered').html('--Select--');
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			},error: function(xhr, textStatus, error) {
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
});
//del
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
// luffy restore
$( document ).on( "click", ".restore", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#restore_record').attr('action',base_url+'/restore/'+$(this).data('record-id'));
});
$(document).ready(function(){
	$("#role_access").change(function(){
		var sel_val = $(this).val();
		if(sel_val=='1') {
			$('.role-checkbox').prop('checked', true);
		} else {
			$('.role-checkbox').prop("checked", false);
		}
	});
});
