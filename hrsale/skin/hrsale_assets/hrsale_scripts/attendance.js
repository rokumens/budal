$(document).ready(function() {
	//attendance list
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/attendance_list/?attendance_date="+$('#attendance_date').val()+'&attendance_to_date='+$('#attendance_to_date').val(),
			type : 'GET',
			error: function(xhr, textStatus, error) {
					// console.log('Error Berat: ' + xhr.responseText);  // luffy
					// console.log('Error Berat: ' + xhr.statusText); // luffy
					// console.log('Error Berat: ' + textStatus); // luffy
					// console.log('Error Berat: ' + error); // luffy
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.saveManualClock').prop('disabled', true);	//$('.save').prop('disabled', true);
					xin_table.api().ajax.reload(function(){
						toastr.error("Error. Please contact dev team.");
					}, true);
			},
		},
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}
	});
	//approval
	var xin_table = $('#xin_table_attendance_approval').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/attendance_approval_list",
			type : 'GET',
			error: function(xhr, textStatus, error) {
					// console.log('Error Berat: ' + xhr.responseText);  // luffy
					// console.log('Error Berat: ' + xhr.statusText); // luffy
					// console.log('Error Berat: ' + textStatus); // luffy
					// console.log('Error Berat: ' + error); // luffy
			},
		},
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// add
	$("#add-clock-manually-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'add_clockin');
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
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('#add-clock-manually-form')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);``
					}, true);
					setTimeout(function(){
						//location.reload();
						window.location.href=base_url+'/attendance_approval';
					}, 1000);
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
	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var attendance_id = button.data('attendance_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read_timesheet_approval/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=timesheet_approval_update&attendance_id='+attendance_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			},error: function(xhr, textStatus, error) {
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
		});
	});
	$("#update_approval").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=update_approval&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					setTimeout(function(){
						location.href=base_url+'/attendance_approval';
					},500);
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
			},
		});
	});
	// get data
	$('.view-modal-data-bg').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var attendance_id = button.data('attendance_id');
		var modal = $(this);
	$.ajax({
		url: base_url+'/read_timesheet_approval/',
		type: "GET",
		data: 'jd=1&is_ajax=4&mode=modal&data=view_timesheet_approval&type=view_timesheet_approval&attendance_id='+attendance_id,
		success: function (response) {
			if(response) {
				$("#pajax_modal_view").html(response);
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
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var ipaddress = button.data('ipaddress');
		var uid = button.data('uid');
		var start_date = button.data('start_date');
		var att_type = button.data('att_type');
		var modal = $(this);
	$.ajax({
		url :  site_url+"timesheet/read_map_info/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_map&type=view_map&ipaddress='+ipaddress+'&uid='+uid+'&start_date='+start_date+'&att_type='+att_type,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});

	// Clock In & Out
	var input = $('.timepicker').clockpicker({
		placement: 'bottom',
		align: 'left',
		autoclose: true,
		'default': 'now'
	});
	// Month & Year
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
	$("#clockInRadio").click(function(){
			$('#idClockIn').val('');
			$('#idClockOut').val('00:00:00');
			$("#rowClockIn").show("normal");
			$("#rowClockOut").hide("normal");
	});
	$("#clockOutRadio").click(function(){
			$('#idClockOut').val('');
			$('#idClockIn').val('00:00:00');
			$("#rowClockOut").show("normal");
			$("#rowClockIn").hide("nnormal");
	});

	/* attendance daily report */
	$("#attendance_daily_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var attendance_date = $('#attendance_date').val();
		var date_format = $('#date_format').val();
		if(attendance_date == ''){
			toastr.error('Please select date.');
		} else {
		$('#att_date').html(date_format);
			 var xin_table2 = $('#xin_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : site_url+"timesheet/attendance_list/?attendance_date="+$('#attendance_date').val()+'&attendance_to_date='+$('#attendance_to_date').val(),
					type : 'GET'
				},
				dom: 'lBfrtip',
				"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
				"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();
				}
			});
			xin_table2.api().ajax.reload(function(){ }, true);
		}
	});
});
