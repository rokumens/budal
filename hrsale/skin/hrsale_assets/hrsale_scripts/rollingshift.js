/*
	jazz7381 - 30jan2020 : 12:14
*/
$(document).ready(function() {
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
		"ajax": {
      url : base_url+"/rollingshift_list/",
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
			data: obj.serialize()+"&is_ajax=1&add_type=add_rollingshift&form="+action,
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
  // ajax detail shift
  $(document).on( "click", ".detailShift", function() {
		id = $(this).data('id');
		user_id = $(this).data('user_id');
		$.ajax({
			type: "GET",
			url: site_url+'rollingshift/ajaxDetail/',
			dataType: 'json',
			data: {
				id : id,
				user_id : user_id,
			},
			success: function(data){
				var selectedDate = moment(data.rollingshift_date,).format('D MMMM YYYY'); // date format
				$('#myModalLabel').html('Rolling Shift on: '+ selectedDate);
				$('#username').val(data.username);
				$('#employee_id').val(data.employee_id);
				$('#divisi').val(data.sub_department_id);
				$('#shift').val(data.office_shift_id);
				$('#date').val(data.rollingshift_date);
				$('#user_id').val(data.user_id);
				$('#rollingshift_id').val(data.id);
				$('#anual_leave_date').val(data.rollingshift_date);
				$('#period').val(data.period);
				$('#id').val(data.id);
				if(data.is_leave_at != null){
					$('#anual_leave').val('1');
					$('#divisi').attr('disabled', 'disabled');
					$('#shift').attr('disabled', 'disabled');
				}else{
					$('#anual_leave').val('0');
					$('#divisi').removeAttr('disabled');
					$('#shift').removeAttr('disabled');
				}
			}
		});
	});
	/* update dayoff */
	$("#edit_rollingshift").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&type=edit_rollingshift&view=user&form="+action,
			cache: false,
			success: function (JSON) {
				$('.save').prop('disabled', false);
				if (JSON.error != "") {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					// console.log('eror @ sukses: ' + JSON.error); // luffy
				}else {
					toastr.success(JSON.result);
					setTimeout(function(){
						window.location.href=window.location;
					}, 1000);
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
    // Month & Year
	// $("#dateFrom").datepicker({ 
	// 	changeMonth: true,
  //   changeYear: true,
  //   forceParse: false,
  //   firstDay: 1,
	// 	dateFormat:'yy-mm-dd',
	// 	altField: "#date_format",
	// 	altFormat: js_date_format,
	// 	yearRange: '1970:' + new Date().getFullYear(),
	// 	beforeShow: function(input) {
  //     $(input).datepicker("widget").show();
  //   },
  //   beforeShowDay: function(date){ 
  //     var day = date.getDay(); 
  //     // return [day == 1 || day == 4,""];
  //     return [day == 1,""];
  //   },
	// 	onSelect: function(date){
	// 		var selectedDate = new Date(date);
	// 		var msecsInADay = 86400000;
	// 		var endDate = new Date(selectedDate.getTime() + msecsInADay);
	// 	//Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
	// 		$("#dateTo").datepicker( "option", "minDate", endDate );
	// 		$("#dateTo").datepicker( "option", "maxDate", '+2y' );
	// 	}
	// });
	// $("#dateTo").datepicker({ 
	// 	dateFormat: 'yy-mm-dd',
	// 	changeMonth: true,
	// 	firstDay: 1,
	// 	beforeShowDay: function(date){ 
  //     var day = date.getDay(); 
  //     // return [day == 1 || day == 4,""];
  //     return [day == 0,""];
  //   },
	// });
	// $(document).on( "click", ".generateRollingshift", function(e) {
	// 	// strat : 7381-jazz 17jan2020 21:28
	// 	// add variable to get filter type
  //   // var importType = $(".typeImport:checked").val();
  //   e.preventDefault();
  //   const dateFrom = $('#dateFrom').val();
  //   const dateTo = $('#dateTo').val();
	// 	$.ajax({
  //     type: "GET",
	// 		url: site_url+'rollingshift/ajaxGenerateRollingshift/',
	// 		dataType: 'json',
	// 		data: {
	// 			dateFrom : dateFrom,
  //       dateTo : dateTo,
	// 		},
	// 		success: function(JSON){
	// 			// console.log('all: '+DNSresponse);
	// 			// console.log('kps: '+DNSresponse);
	// 			// console.log('poipet: '+DNSresponse);
	// 			if(JSON.error != ''){
  //         toastr.error(JSON.error);
  //       }else{
  //         toastr.success(JSON.result);
  //         setTimeout(function(){
	// 					window.location.href=base_url;
	// 				}, 3000);
  //       }
	// 		},
	// 		// error: function(xhr, textStatus, error){
	// 		// 	// console.log('Error Berat: ' + xhr.responseText);  // luffy
	// 		// 	// console.log('Error Berat: ' + xhr.statusText); // luffy
	// 		// 	// console.log('Error Berat: ' + textStatus); // luffy
	// 		// 	// console.log('Error Berat: ' + error); // luffy
	// 		// },
	// 	});
	// });
  // Month & Year
  $('#dateFrom').datepicker({
    changeMonth: true,
    changeYear: true,
    maxDate: '1m',
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
    onSelect: function(_date, _datepicker){
      var minValue = $(this).val();
      minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
      minValue.setDate(minValue.getDate()+6);
      $("#dateTo").datepicker( "option", "minDate", minValue );
      $("#dateTo").val($.datepicker.formatDate('yy-mm-dd', minValue));
    }
  }).datepicker('setDate', date2);
  $('#dateTo').datepicker({
    changeMonth: true,
    changeYear: true,
    // minDate: 0,
    // maxDate: '7d',
    maxDate: 0,
    dateFormat:'yy-mm-dd',
    altField: "#date_format",
    altFormat: js_date_format
  });
}); // end document

