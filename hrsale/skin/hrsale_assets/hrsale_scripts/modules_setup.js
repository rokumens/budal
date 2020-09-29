$(document).ready(function(){
jQuery(".switch").change(function(){
	if($('#m-recruitment').is(':checked')){
		var mrecruitment = $("#m-recruitment").val();
	} else {
		var mrecruitment = '';
	}
	if($('#m-travel').is(':checked')){
		var mtravel = $("#m-travel").val();
	} else {
		var mtravel = '';
	}
	if($('#m-performance').is(':checked')){
		var mperformance = $("#m-performance").val();
	} else {
		var mperformance = '';
	}
	if($('#m-files').is(':checked')){
		var mfiles = $("#m-files").val();
	} else {
		var mfiles = '';
	}
	if($('#m-awards').is(':checked')){
		var mawards = $("#m-awards").val();
	} else {
		var mawards = '';
	}
	if($('#m-training').is(':checked')){
		var mtraining = $("#m-training").val();
	} else {
		var mtraining = '';
	}
	if($('#m-inquires').is(':checked')){
		var minquires = $("#m-inquires").val();
	} else {
		var minquires = '';
	}
	if($('#m-language').is(':checked')){
		var mlanguage = $("#m-language").val();
	} else {
		var mlanguage = '';
	}
	if($('#m-orgchart').is(':checked')){
		var morgchart = $("#m-orgchart").val();
	} else {
		var morgchart = '';
	}
	if($('#m-accounting').is(':checked')){
		var maccounting = $("#m-accounting").val();
	} else {
		var maccounting = '';
	}
	if($('#m-events').is(':checked')){
		var mevents = $("#m-events").val();
	} else {
		var mevents = '';
	}
	if($('#m-goal-tracking').is(':checked')){
		var goal_tracking = $("#m-goal-tracking").val();
	} else {
		var goal_tracking = '';
	}
	if($('#m-project').is(':checked')){
		var project = $("#m-project").val();
	} else {
		var project = '';
	}
	if($('#m-asset').is(':checked')){
		var asset = $("#m-asset").val();
	} else {
		var asset = '';
	}
	if($('#m-chatbox').is(':checked')){
		var chatbox = $("#m-chatbox").val();
	} else {
		var chatbox = '';
	}
	// luffy for new modules
	if($('#m-appraisal').is(':checked')){
		var appraisal = $("#m-appraisal").val();
	} else {var appraisal = '';}
	if($('#m-offday').is(':checked')){
		var offday = $("#m-offday").val();
	} else {var offday = '';}
	if($('#m-immigrations').is(':checked')){
		var immigrations = $("#m-immigrations").val();
	} else {var immigrations = '';}
	$.ajax({
		// luffy
		type: "GET",  url: site_url+"settings/modules_info/?is_ajax=2&type=modules_info&form=2&mrecruitment="+mrecruitment+"&mtravel="+mtravel+"&mperformance="+mperformance+"&mfiles="+mfiles+"&mawards="+mawards+"&mtraining="+mtraining+"&minquires="+minquires+"&mlanguage="+mlanguage+"&morgchart="+morgchart+"&maccounting="+maccounting+"&mevents="+mevents+"&project="+project+"&asset="+asset+"&goal_tracking="+goal_tracking+"&chatbox="+chatbox+"&appraisal="+appraisal+"&offday="+offday+"&immigrations="+immigrations,
		//data: order,
		success: function(response) {
			if (response.error != '') {
				toastr.error(response.error);
				$('.save').prop('disabled', false);
			} else {
				toastr.success(response.result);
				$('.save').prop('disabled', false);
			}
		}
	});
});
});//jquery
