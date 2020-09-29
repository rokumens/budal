$(document).ready(function() {
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#remarks').trumbowyg({
		btns: [
					['formatting'],
					'btnGrp-semantic',
					['superscript', 'subscript'],
					['removeformat'],
			],
		autogrowOnEnter: true
	});
	/* Add */
	$("#update_status").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&update_type=leave&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}
			},
			error: function(xhr, textStatus, error) {
					console.log('Error Berat: ' + xhr.responseText);  // luffy
					console.log('Error Berat: ' + xhr.statusText); // luffy
					console.log('Error Berat: ' + textStatus); // luffy
					console.log('Error Berat: ' + error); // luffy
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', true);
					// xin_table.api().ajax.reload(function(){
					// 	toastr.error("Error. Please contact dev team.");
					// }, true);
					// setTimeout(function(){
					// 	location.reload();
					// }, 1500);
			},
		});
	});
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_update_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	});
	$('#remarks2').trumbowyg();
	// Date
	$('.e_date').datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat:'yy-mm-dd',
	  yearRange: '1900:' + (new Date().getFullYear() + 15),
	});
	/* Edit*/
	// edit leave from detail
	$("#edit_leave").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=leave&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					setTimeout(function(){
						location.reload();
					}, 1500);
				}
			},error: function(xhr, textStatus, error) {
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
	// edit approval from detail
	$("#edit_approval").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=approval&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					setTimeout(function(){
						location.reload();
					}, 1500);
				}
			},error: function(xhr, textStatus, error) {
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
});
