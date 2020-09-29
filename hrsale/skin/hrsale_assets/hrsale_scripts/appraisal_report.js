$(document).ready(function(){
	$('#submitReportDaily').click(function(){
		let filterReportBy='ajaxDaily='+$('#report_daily').val();
		var xin_table = $('.luffyReport').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"appraisal_report/report_list?"+filterReportBy,
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
		let d=new Date(filterReportBy);
		let formattedDateAh=$.datepicker.formatDate('dd MM yy', d);
		$('.reportMonthFormat').html(formattedDateAh);
	})
	$('#submitReportMonthly').click(function(){
		let filterReportBy='ajaxMonthly='+$('#report_month').val();
		var xin_table = $('.luffyReport').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"appraisal_report/report_list?"+filterReportBy,
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
		let d=new Date(filterReportBy);
		let formattedDateAh=$.datepicker.formatDate('MM yy', d);
		$('.reportMonthFormat').html(formattedDateAh);
	})
	$('#submitReportCustom').click(function(){
		let filterReportBy='ajaxCustomFrom='+$('#report_custom_from').val()+'&ajaxCustomTo='+$('#report_custom_to').val();
		var xin_table = $('.luffyReport').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"appraisal_report/report_list?"+filterReportBy,
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
		let customFrom=$('#report_custom_from').val();
		let customTo=$('#report_custom_to').val();
		let d=new Date(customFrom);
		let dt=new Date(customTo);
		let formattedFrom=$.datepicker.formatDate('dd MM yy', d);
		let formattedTo=$.datepicker.formatDate('dd MM yy', dt);
		$('.reportMonthFormat').html(formattedFrom+' &nbsp;to&nbsp; '+formattedTo);
	})
	//by default use monthly as report.
	let filterReportBy='ajaxMonthly='+$('#report_month').val();
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"appraisal_report/report_list?"+filterReportBy,
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
	var xin_table = $('#xin_table_attendance_approval').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"appraisal_report/report_list",
			type : 'GET',
		},
	});
	$(".luffyputar").click(function(){
    $('.luffyputar').toggleClass("putar");
    $('.luffyputar').removeClass("naik");
  })
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$("#dailyRadio").click(function(){
			$("#rowDaily").show("normal");
			$("#rowMonthly").hide("normal");
			$("#rowCustom").hide("normal");
	});
	$("#monthlyRadio").click(function(){
			$("#rowMonthly").show("normal");
			$("#rowDaily").hide("normal");
			$("#rowCustom").hide("normal");
	});
	$("#customRadio").click(function(){
			$("#rowCustom").show("normal");
			$("#rowDaily").hide("normal");
			$("#rowMonthly").hide("normal");
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
	$('.report_daily').datepicker({
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
	$('.report_date').datepicker({
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
	/* Generate general report */
	$("#general_report").submit(function(e){
		e.preventDefault();
		var report_month = $('#report_month').val();
		if(report_month == ''){
			toastr.error('Please select month.');
		} else {
			 // var d=new Date(report_month);
			 // var formattedDateAh=$.datepicker.formatDate('MM yy', d);
			 // $('.reportMonthFormat').html(formattedDateAh);
			//  var xin_table2 = $('#xin_table').dataTable({
			// 	"bDestroy": true,
			// 	"ajax": {
			// 		url : site_url+"appraisal_report/report_list?report_month="+$('#report_month').val(),
			// 		type : 'GET'
			// 	},
			// });
			// xin_table2.api().ajax.reload(function(){}, true);
		}
	});
});
//by default current page report list opened.
var report_month = $('#report_month').val();
var d=new Date(report_month);
var formattedDateAh=$.datepicker.formatDate('MM yy', d);
$('.reportMonthFormat').html(formattedDateAh);
