$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
      "bDestroy": true,
		"ajax": {
      url : base_url+"/assets_list/",
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
		  $('[data-toggle="tooltip"]').tooltip();
		}
  });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$(".add-new-form").click(function(){
		$(".add-form").slideToggle('slow');
	});
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
	});
	// Award Month & Year
	$('.asset_date').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
	// delete
	$("#delete_record").submit(function(e){
	  e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete_record&form="+action,
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
		var asset_id = button.data('field_id');
		var modal = $(this);
  	$.ajax({
  		url : base_url+"/asset_read/",
  		type: "GET",
  		data: 'jd=1&is_ajax=1&mode=modal&data=eassets&asset_id='+asset_id,
  		success: function (response) {
  			if(response) {
  				$("#ajax_modal").html(response);
  			}
  		}
		});
	});
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var asset_id = button.data('asset_id');
		var modal = $(this);
  	$.ajax({
  		url :  base_url+"/asset_read/",
  		type: "GET",
  		data: 'jd=1&is_ajax=1&mode=modal&data=view_asset&type=view_asset&asset_id='+asset_id,
  		success: function (response) {
  			if(response) {
  				$("#ajax_modal_view").html(response);
  			}
  		},
      error: function(xhr, textStatus, error) {
  				// console.log('Error Berat: ' + xhr.responseText);  // luffy
  				// console.log('Error Berat: ' + xhr.statusText); // luffy
  				// console.log('Error Berat: ' + textStatus); // luffy
  				// console.log('Error Berat: ' + error); // luffy
  				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
  				$('.saveManualClock').prop('disabled', true);
  				xin_table.api().ajax.reload(function(){
  					toastr.error("Error. Please contact dev team.");
  				}, true);
  				setTimeout(function(){
  					location.reload();
  				}, 1500);
  		},
		});
	});
	/* Add data */
  $("#xin-form").submit(function(e){
  	var fd = new FormData(this);
  	var obj = $(this), action = obj.attr('name');
  	$('.icon-spinner3').show();
  	//var description = $("#description").code();
  	fd.append("is_ajax", 1);
  	fd.append("add_type", 'add_asset');
  	fd.append("form", action);
  	e.preventDefault();
  	$('.btn').prop('disabled', true); // luffy 10 January 2020 01:29 pm
  	$.ajax({
  		url: e.target.action,
  		type: "POST",
  		data:  fd,
  		contentType: false,
  		cache: false,
  		processData:false,
  		success: function(JSON){
  			if (JSON.error != '') {
  				toastr.error(JSON.error);
  				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          // luffy 10 January 2020 01:29 pm
  				$('.btn').prop('disabled', true);
  				$('.btn').prop('disabled', false);
  				$('.icon-spinner3').hide();
  			} else {
  				xin_table.api().ajax.reload(function(){
  					toastr.success(JSON.result);
  				}, true);
  				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
  				$('.icon-spinner3').hide();
  				$('.add-form').removeClass('in');
  				$('.btn').prop('disabled', false);
          // luffy 10 January 2020 01:29 pm
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
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete_asset/'+$(this).data('record-id'));
});
