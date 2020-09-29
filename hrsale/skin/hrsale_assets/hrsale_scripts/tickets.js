$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
		"ajax": {
      url : base_url+"/ticket_list/",
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
	$('[data-plugin="select_hrm"]').select2({width:'100%'});
	$('#description').trumbowyg();
  //luffy start
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajax').html(data);
		});
    $("#companyValByAjCompany").val($("#aj_company").val());
    jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
  		jQuery('#department_ajax').html(data);
  	});
	});
	jQuery("#aj_department").change(function(){
    jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
  		jQuery('#aj_subdepartments').html(data);
  	});
	});
  $("#ticketForEmployee").click(function(){
    $('#aj_company').val('');
    $('#companyValByAjCompany').val('');
    $('#aj_department').val('');
    jQuery.get(base_url+"/get_employees/"+$("aj_company").val(), function(data, status){
      jQuery('#employee_ajax').html(data);
    });
    $("#rowEmployee").show("fast");
    $("#rowDepartment").hide("fast");
	});
  $("#ticketForDepartment").click(function(){
    $('#aj_company').val('');
    $('#companyValByAjCompany').val('');
    $('#selectemployee').val('');
    jQuery.get(base_url+"/get_departments/"+$("#aj_company").val(), function(data, status){
  		jQuery('#department_ajax').html(data);
  	});
    $("#rowDepartment").show("fast");
    $("#rowEmployee").hide("fast");
	});
  // end
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
		var ticket_id = button.data('ticket_id');
		var modal = $(this);
  	$.ajax({
  		url : base_url+"/read/",
  		type: "GET",
  		data: 'jd=1&is_ajax=1&mode=modal&data=ticket&ticket_id='+ticket_id,
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
		$('.btn').prop('disabled', true); // luffy 9 January 2020 12:01 pm
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=ticket&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          // luffy 9 January 2020 12:01 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
          // console.log('eror @ sukses: ' + JSON.error); // luffy
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
          // luffy 9 January 2020 12:01 pm
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
				$('.btn').prop('disabled', false);
				xin_table.api().ajax.reload(function(){
					toastr.error("Error. Please contact dev team.");
				}, true);
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
      //luffy start
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});
