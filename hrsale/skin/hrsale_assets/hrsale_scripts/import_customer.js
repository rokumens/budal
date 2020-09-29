$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var getUrl = window.location;
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 3);
		fd.append("type", 'imp_customer');
		fd.append("form", action);
		e.preventDefault();
		$('.import').prop('disabled', true);
		$('#file').val('');
		$('#file').prop('disabled', true);
		var loadingProcess = 0;
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(JSON) {
				toastr.options.timeOut = 0;
				toastr.options.extendedTimeOut = 0;
				toastr.options.tapToDismiss = false;
				toastr.options.closeButton = false;
				onclick: false,
				toastr.info('Importing, please wait...');
      },
			success: function(JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.import').prop('disabled', false);
				} else {
					toastr.options.timeOut = 0;
					toastr.options.extendedTimeOut = 0;
					toastr.options.closeButton = false;
					onclick: false,
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.import').prop('disabled', false);
					// go back to customer data once importing data completed.
					var getUrl = window.location;
					if(getUrl.host=='localhost'){
						var url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + '/' + getUrl.pathname.split('/')[2] + "/admin/customer";
					}else{
						var url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/customer";
					}
					var delay = 4000;	//4 detik
					setTimeout(function(){ window.location = url; }, delay);
				}
			},
			error: function(xhr, textStatus, error) {
					// console.log('Error: ' + xhr.responseText);  // luffy
					console.log('Error: ' + xhr.statusText); // luffy
					// console.log('Error: ' + textStatus); // luffy
					console.log('Error: ' + error); // luffy
					// if (xhr.statusText == 'Gateway Time-out'){
					if (error == 'Gateway Time-out'){
							toastr.options.closeButton = false;
							onclick: false,
							toastr.error("Server "+error+". Don't worry data still is still in progress importing.");
							// go back to customer data once importing data completed.
							var getUrl = window.location;
							if(getUrl.host=='localhost'){
								var url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + '/' + getUrl.pathname.split('/')[2] + "/admin/customer";
							}else{
								var url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/customer";
							}
							var delay = 1000;	//1 detik
							setTimeout(function(){ window.location = url; }, delay);
	        }
			},
			complete: function() {

	    }
	   });
	});
});
