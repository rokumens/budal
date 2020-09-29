$(document).ready(function(){
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 3);
		fd.append("type", 'imp_attendance');
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
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
				}
			},
			error: function(){
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			}
	   });
	});
	// type import on change
	$('.range').change(function(){
		$('.range-date').show();
	});
	$('.normal').change(function(){
		$('.range-date').hide();
	});
	// ajax import fingerprint
	$('.importFingerprint').click(function(){
		var btnImport = $('.importFingerprint');
		// strat : 7381-jazz 17jan2020 21:28
		// add variable to get filter type
		var importType = $(".typeImport:checked").val();
		var url = base_url+"/ajaxFingerprint/";
		if(importType == 'range'){
			const dateFrom = $('#attendance_date').val();
			const dateTo = $('#attendance_to_date').val();
			url = base_url+"/ajaxFingerprint/"+importType+"/"+dateFrom+'/'+dateTo;
		}else if(importType == 'all'){
      url = base_url+"/ajaxFingerprint/"+importType;
		}else{
      url = base_url+"/ajaxFingerprint/"+importType;
    }
		$.ajax({
			url : url, // add param from filter
			cache: false,
	    beforeSend: function(DNSresponse){
				if(DNSresponse){
					toastr.success('Start importing process.');
					btnImport.prop('disabled', true);
					$('.txtFingerprintStart').show();
					$('.txtFingerprintDone').hide();
					$('.fingerprintResponse').addClass('animated fadeOutUp');
				}
	    },
	    complete: function(DNSresponse){
					btnImport.prop('disabled', false);
					$('.txtFingerprintStart').hide();
					$('.txtFingerprintDone').show();
					$('.fingerprintResponse').removeClass('animated fadeOutUp');
					$('.fingerprintResponse').addClass('animated fadeInUp');
	    },
			success: function(DNSresponse){
				// console.log('all: '+DNSresponse);
				// console.log('kps: '+DNSresponse);
				// console.log('poipet: '+DNSresponse);
				if(DNSresponse){
					toastr.success('Importing process completed.');
					$(".result").show();
					$(".result").html(DNSresponse);
				}else{
					// const locations = location.href;
					toastr.error('<a href="'+site_url+'admin/location">click here</a> to active at least 1 location ');
				}
			},
			error: function(xhr, textStatus, error){
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
			},
		});
	});
	$('.attendance_date').datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: '0',
		dateFormat:'yy-mm-dd',
		altField: "#date_format",
		altFormat: js_date_format,
		yearRange: '1970:' + new Date().getFullYear(),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
});