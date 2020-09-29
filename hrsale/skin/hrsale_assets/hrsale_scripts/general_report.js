$(document).ready(function(){
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"reports/general_report_list?report_month="+$('#report_month').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	var xin_table = $('#xin_table_attendance_approval').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"reports/general_report_list",
			type : 'GET',
		},
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// Quick View dialog
	$('.payroll_template_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var employee_id = button.data('employee_id');
		var report_month = button.data('report_month');
		var modal = $(this);
		$.ajax({
			url: site_url+'reports/general_report_quickview/',
			type: "GET",
			data: 'jd=1&is_ajax=11&mode=not_paid&data=payroll_template&type=payroll_template&employee_id='+employee_id+'&report_month='+report_month,
			success: function (response) {
				if(response) {
					$("#ajax_modal_payroll").html(response);
				}
			},
			error: function(xhr, textStatus, error) {
					console.log('Error Berat: ' + xhr.responseText);  // luffy
					console.log('Error Berat: ' + xhr.statusText); // luffy
					console.log('Error Berat: ' + textStatus); // luffy
					console.log('Error Berat: ' + error); // luffy
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', true);
					xin_table.api().ajax.reload(function(){
						toastr.error("Error. Please contact dev team.");
					}, true);
					// setTimeout(function(){
					// 	location.reload();
					// }, 1500);
				},
		});
	});
	// Report Month
	$('.report_month').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1970:' + new Date().getFullYear(),
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
	/* Generate general report */
	$("#general_report").submit(function(e){
		e.preventDefault();
		var report_month = $('#report_month').val();
		if(report_month == ''){
			toastr.error('Please select month.');
		} else {
			 var d=new Date(report_month);
			 var formattedDateAh=$.datepicker.formatDate('MM yy', d);
			 $('.reportMonthFormat').html(formattedDateAh);
			 var xin_table2 = $('#xin_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : site_url+"reports/general_report_list/?report_month="+$('#report_month').val(),
					type : 'GET'
				},
				// dom: 'lBfrtip',
				// "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
				// "fnDrawCallback": function(settings){
				// $('[data-toggle="tooltip"]').tooltip();
				// }
			});
			xin_table2.api().ajax.reload(function(){ }, true);
		}
	});
	var report_month = $('#report_month').val();
	var d=new Date(report_month);
	var formattedDateAh=$.datepicker.formatDate('MM yy', d);
	$('.reportMonthFormat').html(formattedDateAh);
});
