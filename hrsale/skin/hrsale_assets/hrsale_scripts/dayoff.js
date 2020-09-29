// 7381 - Jazz 31-01-2020 13:25
$(document).ready(function() {
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('.note').trumbowyg();
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
		"ajax": {
      url : base_url+"/dayoff_list/",
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
	/* add */
	$("#xin-form").submit(function(e){
	  e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.btn').prop('disabled', true); // luffy 9 January 2020 12:01 pm
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=add_dayoff&form="+action,
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
	/* update dayoff */
	$("#update_dayoff").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&type=update_dayoff&view=user&form="+action,
			cache: false,
			success: function (JSON) {
				$('.save').prop('disabled', false);
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					// console.log('eror @ sukses: ' + JSON.error); // luffy
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					// console.log('eror @ sukses: ' + JSON.result); // luffy
				}
			},
			error: function (xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.btn').prop('disabled', false);	//$('.save').prop('disabled', true);
				toastr.error("Error. Please contact dev team.");
			},
		});
	});
	$("#dateFrom").datepicker({ 
		changeMonth: true,
    changeYear: true,
    forceParse: false,
    firstDay: 1,
		dateFormat:'yy-mm-dd',
		altField: "#date_format",
		altFormat: js_date_format,
		yearRange: '1970:' + new Date().getFullYear(),
		beforeShow: function(input) {
      $(input).datepicker("widget").show();
    },
    beforeShowDay: function(date){ 
      var day = date.getDay(); 
      // return [day == 1 || day == 4,""];
      return [day == 1,""];
    },
		onSelect: function(date){
			var selectedDate = new Date(date);
			var msecsInADay = 86400000;
			var endDate = new Date(selectedDate.getTime() + msecsInADay);
		//Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
			$("#dateTo").datepicker( "option", "minDate", endDate );
			// $("#dateTo").datepicker( "option", "maxDate", '+2y' );
		}
	});
	$("#dateTo").datepicker({ 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		firstDay: 1,
		beforeShowDay: function(date){ 
      var day = date.getDay(); 
      return [day == 0,""];
    },
	});
});