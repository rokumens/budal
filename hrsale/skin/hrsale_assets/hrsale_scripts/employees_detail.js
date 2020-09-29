$(document).ready(function(){
	// luffy 7 Dec 2019 08:31 pm
	jQuery('#statusIsActive').change(function(){
		if(jQuery(this).val()==0){
			jQuery('#rowInactiveReason').show('normal');
		}else{
			jQuery('#rowInactiveReason').hide('normal');
		}
	});
	// get data
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'contact'){
			var field_add = '&data=emp_contact&type=emp_contact&';
		}else if(field_tpe == 'document'){
			var field_add = '&data=emp_document&type=emp_document&';
		}else if(field_tpe == 'qualification'){
			var field_add = '&data=emp_qualification&type=emp_qualification&';
		}else if(field_tpe == 'work_experience'){
			var field_add = '&data=emp_work_experience&type=emp_work_experience&';
		}else if(field_tpe == 'bank_account'){
			var field_add = '&data=emp_bank_account&type=emp_bank_account&';
		}else if(field_tpe == 'contract'){
			var field_add = '&data=emp_contract&type=emp_contract&';
		}else if(field_tpe == 'leave'){
			var field_add = '&data=emp_leave&type=emp_leave&';
		}else if(field_tpe == 'shift'){
			var field_add = '&data=emp_shift&type=emp_shift&';
		}else if(field_tpe == 'location'){
			var field_add = '&data=emp_location&type=emp_location&';
		}else if(field_tpe == 'imgdocument'){
			var field_add = '&data=e_imgdocument&type=e_imgdocument&';
		}else if(field_tpe == 'salary_allowance'){
			var field_add = '&data=e_salary_allowance&type=e_salary_allowance&';
		}else if(field_tpe == 'adjustment_minus'){ // luffy 29 nov 2019 - 08:40 pm
			var field_add = '&data=update_adjustment_minus&type=update_adjustment_minus&';
		}else if(field_tpe == 'salary_loan'){
			var field_add = '&data=e_salary_loan&type=e_salary_loan&';
		}else if(field_tpe == 'emp_overtime'){
			var field_add = '&data=emp_overtime_info&type=emp_overtime_info&';
		}
		var modal = $(this);
		$.ajax({
			url: site_url+'employees/dialog_'+field_tpe+'/',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
			},
		});
   });

	 // view and get data immigration
 	$('.view-modal-data-bg').on('show.bs.modal', function (event) {
 		var button = $(event.relatedTarget);
 		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'imgdocument'){
			var field_add = '&data=view_immigration&type=view_immigration&';
		}
 		var modal = $(this);
 		$.ajax({
 			url: site_url+'employees/dialog_'+field_tpe+'/',
 			type: "GET",
 			data: 'jd=1&is_ajax=4&mode=modal&data=view_immigration&type=view_immigration&field_id='+field_id,
 			success: function (response) {
 				if(response) {
 					$("#pajax_modal_view").html(response);
 				}
 			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
			},
 		});
 	});

	 // use employee ID for email too
	 $('.employeeId').keyup(function(){
 		let empId=$(this).val()+'@asiapowergames.com';
 		$('.employeeEmail').val(empId);
 	});
	// Time of birth
	var input = $('.timepicker').clockpicker({
		placement: 'bottom',
		align: 'left',
		autoclose: true,
		'default': 'now'
	});
	// Month & Year
	$('.ln_month_year').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").addClass('hide-calendar');
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(year, month, 1));
			$(this).datepicker('widget').removeClass('hide-calendar');
			$(this).datepicker('widget').hide();
		}
	});

	/* Update basic info */
	// luffy modified: 7 Dec 2019 - 01:39 pm
	$("#basic_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'basic_info');
		fd.append("data", 'basic_info');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data: fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON){
				if(JSON.error != ''){
					toastr.error(JSON.error);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
				setTimeout(function(){
					location.reload();
				}, 1500);
			},
		});
	});
	// get current val
	$(".basic_salary").keyup(function(e){
		var to_currency_rate = $('#to_currency_rate').val();
		var curr_val = $(this).val();
		var final_val = to_currency_rate * curr_val;
		var float_val = final_val.toFixed(2);
		$('#current_cur_val').html(float_val);
	});
	$(".daily_wages").keyup(function(e){
		var to_currency_rate = $('#to_currency_rate').val();
		var curr_val = $(this).val();
		var final_val = to_currency_rate * curr_val;
		var float_val = final_val.toFixed(2);
		$('#current_cur_val2').html(float_val);
	});

	/* Update profile picture */
	$("#f_profile_picture").submit(function(e){
		var fd = new FormData(this);
		var user_id = $('#user_id').val();
		var session_id = $('#session_id').val();
		$('.icon-spinner3').show();
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'profile_picture');
		fd.append("data", 'profile_picture');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
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
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					toastr.success(JSON.result);
					$('.icon-spinner3').hide();
					$('#remove_file').show();
					$(".profile-photo-emp").remove('checked');
					$('#u_file').attr("src", JSON.img);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					if(user_id == session_id){
						$('.user_avatar').attr("src", JSON.img);
					}
					$('.save').prop('disabled', false);
				}
			},
			error: function(){
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			}
	   });
	});
	/* Update social networking */
	$("#f_social_networking").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=social_info&type=social_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
		});
	});
	// get departments
	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#department_ajax').html(data);
		});
	});
	// get sub departments
	jQuery("#aj_subdepartments").change(function(){
		jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#subdepartment_ajax').html(data);
		});
	});
	// get designations
	jQuery("#aj_subdepartment").change(function(){
		jQuery.get(base_url+"/designation/"+jQuery(this).val(), function(data, status){
			jQuery('#designation_ajax').html(data);
		});
	});

	$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('profile');
		var profile_block = $(this).data('profile-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#user_profile_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});
	$(".salary-tab").click(function(){
		var profile_id = $(this).data('profile');
		var profile_block = $(this).data('profile-block');
		$('.salary-tab-list').removeClass('active');
		$('.salary-current-tab').hide();
		$('#suser_profile_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});

	// On page load: table_contacts
	 var xin_table_contact = $('#xin_table_contact').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/contacts/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}
    });

	// On page load > documents
	var xin_table_immigration = $('#xin_table_imgdocument').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/immigration/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
    });

	// On page load > documents
	var xin_table_document = $('#xin_table_document').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/documents/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load > qualification
	var xin_table_qualification = $('#xin_table_qualification').dataTable({
    "bDestroy": true,
		"ajax": {
	    url : site_url+"employees/qualification/"+$('#user_id').val(),
	    type : 'GET'
    },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}
    });

	// On page load
	var xin_table_work_experience = $('#xin_table_work_experience').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/experience/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load
	var xin_table_bank_account = $('#xin_table_bank_account').dataTable({
    "bDestroy": true,
		"ajax": {
	    url : site_url+"employees/bank_account/"+$('#user_id').val(),
	    type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
    });
	// On page load > contract
	var xin_table_contract = $('#xin_table_contract').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/contract/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load > leave
	var xin_table_leave = $('#xin_table_leave').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/leave/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load
	var xin_table_shift = $('#xin_table_shift').dataTable({
    "bDestroy": true,
		"ajax": {
	    url : site_url+"employees/shift/"+$('#user_id').val(),
	    type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load
	var xin_table_location = $('#xin_table_location').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/location/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load
	var xin_table_emp_overtime = $('#xin_table_emp_overtime').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/salary_overtime/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load
	var xin_table_allowances_ad = $('#xin_table_all_allowances').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/salary_all_allowances/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load
	var xin_table_adjustment_minus = $('#xin_table_adjustment_minus').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/all_adjustment_minus/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// On page load
	var xin_table_all_deductions = $('#xin_table_all_deductions').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/salary_all_deductions/"+$('#user_id').val(),
      type : 'GET'
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	/* Add contact info */
	$("#contact_info").submit(function(e){
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		// luffy 7 January 2020 10:19 am
		// jQuery('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=contact_info&type=contact_info&form="+action,
			cache: false,
			success: function (JSON) {
				if(JSON.error != ''){
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 7 January 2020 10:20 am
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.save').prop('disabled', false);
				} else {
					xin_table_contact.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					// $('#contact_info')[0].reset(); // To reset form fields
					// jQuery('.save').prop('disabled', false);
					// luffy 7 January 2020 10:22 am
					$('.btn').prop('disabled', false);
					// luffy 7 January 2020 - 10:23 am
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			},
			// luffy 7 January 2020 10:18 am
			error: function(xhr, textStatus, error){
        // console.log('Error Berat: ' + xhr.responseText);  // luffy
        // console.log('Error Berat: ' + xhr.statusText); // luffy
        // console.log('Error Berat: ' + textStatus); // luffy
        // console.log('Error Berat: ' + error); // luffy
        toastr.error("Error. Please contact dev team.");
			}
		});
	});

	/* Add contact info */
	jQuery("#contact_info2").submit(function(e){
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save2').prop('disabled', true);
		$('.icon-spinner33').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=contact_info&type=contact_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner33').hide();
					jQuery('.save2').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner33').hide();
					jQuery('.save2').prop('disabled', false);
				}
			}
		});
	});

	// luffy
	/* Add document info */
	$("#document_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 7);
		fd.append("type", 'document_info');
		fd.append("data", 'document_info');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		// luffy 7 January 2020 02:24 pm
		// $('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
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
					// luffy 7 January 2020 02:25 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table_document.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					// $('.icon-spinner3').hide();
					// jQuery('#document_info')[0].reset(); // To reset form fields
					// $('.save').prop('disabled', false);
					$('.btn').prop('disabled', false);
					// luffy 7 January 2020 02:27 pm
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			},
			// error: function() {
			// 	$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
			// 	$('.save').prop('disabled', true);
			// 	xin_table_document.api().ajax.reload(function(){
			// 		toastr.success("Document Added.");
			// 	}, true);
			// 	setTimeout(function(){
			// 	  location.reload();
			// 	}, 1500);
			// },
			// luffy 7 January 2020 02:18 pm
			error: function(xhr, textStatus, error){
        // console.log('JSON: ' + JSON.error);  // luffy
        // console.log('Error Berat: ' + xhr.responseText);  // luffy
        // console.log('Error Berat: ' + xhr.statusText); // luffy
        // console.log('Error Berat: ' + textStatus); // luffy
        // console.log('Error Berat: ' + error); // luffy
        toastr.error("Error. Please contact dev team.");
			}
			// ,
			// error: function()
			// {
			// 	toastr.error(JSON.error);
			// 	$('.save').prop('disabled', false);
			// }
	   });
	});

	/* Add immgigration info */
	$("#immigration_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 7);
		fd.append("type", 'immigration_info');
		fd.append("data", 'immigration_info');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		// luffy 5 January 2020 06:22 pm
		// $('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 5 January 2020 06:38 pm
					// $('.save').prop('disabled', false);
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table_immigration.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
					// luffy 5 January 2020 06:23 pm
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
			}
	   });
	});

	/* Add qualification info */
	jQuery("#qualification_info").submit(function(e){
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		// luffy 7 January 2020 03:52 pm
		// jQuery('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=10&data=qualification_info&type=qualification_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// 7 January 2020 03:53 pm
					// jQuery('.save').prop('disabled', false);
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table_qualification.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('.icon-spinner3').hide();
					$('.btn').prop('disabled', false);
					// luffy 7 January 2020 03:56 pm
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
					$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			}
		});
	});

	/* Add work experience info */
	jQuery("#work_experience_info").submit(function(e){
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		// luffy 7 January 2020 04:26 pm
		// $('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=13&data=work_experience_info&type=work_experience_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 7 January 2020 04:27 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table_work_experience.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('.icon-spinner3').hide();
					$('.btn').prop('disabled', false);
					// luffy 7 January 2020 04:28 pm
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
					$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			}
		});
	});

	/* Add bank account info */
	$("#bank_account_info").submit(function(e){
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		$('.btn').prop('disabled', true); // luffy 7 January 2020 05:39 pm
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=16&data=bank_account_info&type=bank_account_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 7 January 2020 05:39 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
				} else {
					xin_table_bank_account.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('.icon-spinner3').hide();
					$('.btn').prop('disabled', false);
					// luffy 7 January 2020 04:28 pm
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
					$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			}
		});
	});

	/* Add contract info */
	jQuery("#contract_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=19&data=contract_info&type=contract_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_contract.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#contract_info')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	/* Add leave info */
	jQuery("#leave_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=22&data=leave_info&type=leave_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_leave.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#leave_info')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	/* Add shift info */
	jQuery("#shift_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=25&data=shift_info&type=shift_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_shift.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#shift_info')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	/* Add location info */
	jQuery("#location_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=location_info&type=location_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					xin_table_location.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#location_info')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	/* Add change password */
	jQuery("#e_change_password").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=31&data=e_change_password&type=change_password&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#e_change_password')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	/* */
	$("#employee_update_salary").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=employee_update_salary&type=employee_update_salary&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	// add loan
	$("#add_loan_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=loan_info&type=loan_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					xin_table_all_deductions.api().ajax.reload(function(){
						toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#add_loan_info')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});

	/* it's for adustment (+) */
	$("#employee_update_allowance").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		// luffy 4 January 2020 12:44 pm
		// $('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=employee_update_allowance&type=employee_update_allowance&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					// luffy 4 January 2020 12:46 pm
					xin_table_allowances_ad.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
					// luffy 4 January 2020 12:47 pm
					// clear all fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			}
		});
	});

	// On page load
	var xin_table_adjustment_minus = $('#xin_table_adjustment_minus').dataTable({
    "bDestroy": true,
		"ajax": {
      url : site_url+"employees/all_adjustment_minus/"+$('#user_id').val(),
      type : 'GET',
      error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
    },
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
  });

	// luffy 29 nov 2019 - 08:07 pm
	// Add adjustment (-)
	$("#employee_add_adjustment_minus").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		// luffy 4 January 2020 11:32 am
		// $('.save').prop('disabled', true);
		$('.btn').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=employee_add_adjustment_minus&type=employee_add_adjustment_minus&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					// luffy 4 January 2020 11:39 am
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table_adjustment_minus.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
					// luffy 4 January 2020 11:41 am
					// clear all fields
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
				toastr.error("Error. Please contact dev team.");
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
		});
	});

	/* */
	$("#statutory_deductions_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=statutory_info&type=statutory_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	/* */
	$("#other_payments_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=other_payments&type=other_payments&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	/* */
	$("#overtime_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=emp_overtime&type=emp_overtime&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					xin_table_emp_overtime.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#overtime_info')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});

   /* Delete data */
	$("#delete_record").submit(function(e){
	var tk_type = $('#token_type').val();
	if(tk_type == 'contact'){
		var field_add = '&is_ajax=6&data=delete_record&type=delete_contact&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'document'){
		var field_add = '&is_ajax=8&data=delete_record&type=delete_document&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'qualification'){
		var field_add = '&is_ajax=12&data=delete_record&type=delete_qualification&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'work_experience'){
		var field_add = '&is_ajax=15&data=delete_record&type=delete_work_experience&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'bank_account'){
		var field_add = '&is_ajax=18&data=delete_record&type=delete_bank_account&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'contract'){
		var field_add = '&is_ajax=21&data=delete_record&type=delete_contract&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'leave'){
		var field_add = '&is_ajax=24&data=delete_record&type=delete_leave&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'shift'){
		var field_add = '&is_ajax=27&data=delete_record&type=delete_shift&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'location'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_location&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'imgdocument'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_imgdocument&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'all_allowances'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_salary_allowance&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'all_adjustment_minus'){ // luffy 30 nov 2019 - 11:16 am
		var field_add = '&is_ajax=30&data=delete_record&type=delete_adjustment_minus&';
		var tb_name = 'xin_table_adjustment_minus';
	}else if(tk_type == 'all_deductions'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_salary_loan&';
		var tb_name = 'xin_table_'+tk_type;
	}else if(tk_type == 'emp_overtime'){
		var field_add = '&is_ajax=30&data=delete_record&type=delete_salary_overtime&';
		var tb_name = 'xin_table_'+tk_type;
	}

	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			url: e.target.action,
			type: "post",
			data: '?'+obj.serialize()+field_add+"form="+action,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					// luffy 4 January 2020 08:43 pm
          // remove the white background dialog after deleted the record successfully.
          // $('.delete-modal').modal('toggle');
					$('.delete-modal').removeClass('in');
          $('.modal-backdrop').remove();
          $('body').removeClass('modal-open');
          $('.delete-modal').attr('style','display:none;'); // ato mo gini jg bisa $('.delete-modal').css('display', 'none');
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#'+tb_name).dataTable().api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				toastr.error("Error. Please contact dev team.");
			},
		});
	});
  /// delete a record
	$( document ).on( "click", ".delete", function() {
		$('input[name=_token]').val($(this).data('record-id'));
		$('input[name=token_type]').val($(this).data('token_type'));
		$('#delete_record').attr('action',site_url+'employees/delete_'+$(this).data('token_type')+'/'+$(this).data('record-id'));
	});
}); //end document ready function #luffy
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('.cont_date').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: '1990:' + (new Date().getFullYear() + 10),
	});
});
