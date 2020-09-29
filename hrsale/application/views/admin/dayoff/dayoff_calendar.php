<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<style type="text/css">
	.popover-title {
		font-size: .9rem !important;
		border-color: rgba(0,0,0,.05) !important;
		background-color: #fff !important;
		font-weight:bold !important;
	}
	.popover-title {
		padding: .5rem .75rem !important;
		margin-bottom: 0 !important;
		color: inherit !important;
		border-bottom: 1px solid #ebebeb !important;
		border-top-left-radius: calc(.3rem - 1px) !important;
		border-top-right-radius: calc(.3rem - 1px) !important;
	}
	.popover {
		border-color: rgba(0,0,0,.1) !important;
	}
	.popover {
		color: rgba(70,90,110,.85) !important;
	}
	.popover .arrow {
		position: absolute !important;
		display: block !important;
	}
	.popover-content {
		font-size: .8rem !important;
		color: rgba(70,90,110,.85) !important;
	}
	.popover-content {
		padding: .5rem .75rem !important;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	// Start jazz7381
	/* initialize the calendar
	-----------------------------------------------------------------*/
	$('#dayoff_list').fullCalendar({
		header: {
			// left: 'prev,next today',
			left: 'prev,next',
			center: 'title',
			right: 'agendaWeek, month',
		},
		themeSystem: 'bootstrap4',
		bootstrapFontAwesome: {
			close: ' ion ion-md-close',
			prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
			next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
			prevYear: ' ion ion-ios-arrow-dropleft-circle scaleX--1-rtl',
			nextYear: ' ion ion-ios-arrow-dropright-circle scaleX--1-rtl'
		},
		eventRender: function(event, element, date) { 
			element.attr('title', event.title).tooltip().append("<br>" + event.subdept);
			element.attr('data-id', event.id);
			element.attr('class', event.class);
			element.attr('data-toggle', event.toggle);
			element.attr('data-target', event.target);
			element.attr('data-date', event.date);
			element.attr('data-user_id', event.user_id); 
			element.attr('data-period', event.period); 
			element.attr('data-original-title', event.shift);
		},
		// dayClick: function(date, jsEvent, view) {
		// 	date_last_clicked = $(this);
		// 	var event_date = date.format();//get date
		// 	$('#exact_date').val(event_date);
		// 	var subdept = $('.currentSubDept').val();// get subdept
		// 	$('.data_dayoff').children().attr("data-date", event_date);
		// 	$.get(base_url+"/ajaxDayoff/"+event_date+'/'+subdept, function(data, status){
		// 		$('.value_dayoff').html(data);
		// 	});
		// 	var eventInfo = $("#dayoffName");
		// 	var mousex = jsEvent.pageX + 20; //Get X coodrinates
		// 	var mousey = jsEvent.pageY + 20; //Get Y coordinates
		// 	var tipWidth = eventInfo.width(); //Find width of tooltip
		// 	var tipHeight = eventInfo.height(); //Find height of tooltip

		// 	//Distance of element from the right edge of viewport
		// 	var tipVisX = $(window).width() - (mousex + tipWidth);
		// 	//Distance of element from the bottom of viewport
		// 	var tipVisY = $(window).height() - (mousey + tipHeight);

		// 	if (tipVisX < 20) { //If tooltip exceeds the X coordinate of viewport
		// 			mousex = jsEvent.pageX - tipWidth - 20;
		// 	} if (tipVisY < 20) { //If tooltip exceeds the Y coordinate of viewport
		// 			mousey = jsEvent.pageY - tipHeight - 0;
		// 	}
		// 	//Absolute position the tooltip according to mouse position
		// 	eventInfo.css({ top: mousey, left: mousex });
		// 	eventInfo.show(); //Show tool tip
		// },
		theme:true,
		defaultDate: '<?=$this->uri->segment(5);?>',// jazz 7381 31Jan2020 14:54 - get default start date from uri segment
		firstDay: 1, // luffy 29 january2020 02:58 pm
		defaultView: 'month',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		editable:true,
		eventDrop: function(event, delta, revertFunc) {
			alert(event.title + "'s dayoff will be changed to " + event.start.format());
			if (!confirm("Are you sure about this change?")) {
				revertFunc();
			}else{
				$.ajax({
					type: "GET",
					url: site_url+'dayoff/update/',
					dataType: 'json',
					data: {
						id : event.id,
						date : event.date,
						date_drop : event.start.format(),
						user_id : event.user_id,
						period : event.period
					},
					success: function(JSON){
						if(JSON.error != ''){
							revertFunc();
							toastr.error(JSON.error);
						}else{
							toastr.success(JSON.result);
							setTimeout(function(){
								window.location.href=location.href;
							}, 1500);
						}
					}
				});
			}
		},
		events: [
			<?php foreach($dayoff as $d): ?>
			{
				title: "<?=$d['employee_id'].' - '.$d['username'];?>",
				shift: "<?=$d['shift_name'];?>",
				subdept: "<?=$d['department_name'];?>",
				start: "<?=$d['dayoff_date']?>",
				user_id: "<?=$d['user_id'];?>",
				color: "<?=($d['office_shift_id'] == 1 ? '#56c4e8 !important' : '#58506e !important' );?>",
				id: "<?=$d['id']?>",
				period: "<?=$d['period']?>",
				class: "delete fc-day-grid-event fc-h-event fc-event fc-start fc-end",
				// toggle: "modal",
				// target: ".delete-modal",
				date: "<?=$d['dayoff_date']?>",
			},
			<?php endforeach; ?>
		]
	});
	$('.fc-icon-x').click(function() {
		$('#dayoffName').hide();
	});
	/* initialize the external events
	-----------------------------------------------------------------*/
	$('#external-events .fc-event').each(function() {
		// Different colors for events
        $(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});
		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			color: $(this).data('color'),
			stick: true // maintain when user navigates (see docs on the renderEvent method)
		});
	});
});
</script>

<script>
$(document).ready(function(){
	$("#dayoffDeptList a").click(function(){
		$('#dayoffDeptList a').removeClass('active');
		$(this).addClass('active');
	});
	$(".department-file").click(function(){
		var dep_id = $(this).data('department-id');
		$('.currentSubDept').val(dep_id);
	});
	$(".data_dayoff").click(function(){
		const id = $(this).data('id');
		const date = $(this).children('div.fc-content').attr('data-date');
		$.ajax({
			type: "GET",
			url: site_url+'dayoff/detail/',
			data: {id : id},
			dataType: 'json',
			success: function(data){
				$('h4.modal-title').html(data.employee_id+' - '+data.username);
				$('#user_id').val(data.user_id);
				$('#username').val(data.username);
				$('#employee_id').val(data.employee_id);
				$('#site').val(data.fingerprint_location);
				$('#divisi').val(data.department_name);
				$('#sub_department_id').val(data.sub_department_id);
				$('#shift').val(data.shift_name);
				$('#office_shift_id').val(data.office_shift_id);
				$('#date').val(date);
			}
		});
	});
	// add dayoff
  $('button.add_dayoff').click(function(){
    $.ajax({
      type: "GET",
      url: site_url+'dayoff/add_dayoff/',
      dataType: 'json',
      data: {
        user_id : $('#user_id').val(),
        employee_id : $('#employee_id').val(),
        sub_department_id : $('#sub_department_id').val(),
        office_shift_id : $('#office_shift_id').val(),
        date : $('#date').val(),
      },
      dataType: 'text',
      success: function(data){
        if(data == "success"){
			window.location.href = base_url;
			toastr.success("Success");
		}else{
			toastr.error("Full Quota!");
		}
      }
    });
	});
	// // remove dayoff
	// $("#delete_record").submit(function(e){
	//   	e.preventDefault();
	// 	var obj = $(this), action = obj.attr('name');
	// 	$.ajax({
	// 		type: "POST",
	// 		url: e.target.action,
	// 		data: obj.serialize()+"&is_ajax=2&form="+action,
	// 		cache: false,
	// 		success: function (JSON) {
	// 			if (JSON.error != '') {
	// 				toastr.error(JSON.error);
	// 				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
	// 			} else {
	// 				$('.delete-modal').modal('toggle');
	// 				// dayoff_calendar_div.api().ajax.reload(function(){
	// 					toastr.success(JSON.result);
	// 					// refresh_calendar_div();
	// 					window.location.href = base_url;
	// 				// }, true);
	// 				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
	// 			}
	// 		},
	// 	});
	// });
	// $('#delete-record').submit(function(e){
	// 	e.preventDefault();
	// 	var obj = $(this), action = obj.attr('name');
	// 	$.ajax({
	// 		type: "POST",
	// 		url: e.target.action,
	// 		data: obj.serialize()+"&is_ajax=2&form="+action,
	// 		cache: false,
	// 		success: function (JSON) {
	// 			if (JSON.error != '') {
	// 				toastr.error(JSON.error);
	// 				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
	// 			} else {
	// 				$('.delete-modal').modal('toggle');
	// 				// xin_table.api().ajax.reload(function(){
	// 				// 	toastr.success(JSON.result);
	// 				// }, true);
	// 				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
	// 				$('#dayoff_list').fullCalendar('refetchEvents');
	// 				$('input[name=_token]').val($(this).data('record-id'));
	// 				$('#delete_record').attr('action',);
	// 			}
	// 		},
	// 		error: function(xhr, textStatus, error) {
	// 			console.log('Error Berat: ' + xhr.responseText);  // luffy
	// 			console.log('Error Berat: ' + xhr.statusText); // luffy
	// 			console.log('Error Berat: ' + textStatus); // luffy
	// 			console.log('Error Berat: ' + error); // luffy
	// 			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
	// 			// $('.save').prop('disabled', true);
	// 			// xin_table.api().ajax.reload(function(){
	// 			// 	toastr.error("Error. Please contact dev team.");
	// 			// }, true);
	// 			// setTimeout(function(){
	// 			//   location.reload();
	// 			// }, 1500);
	// 		},
	// 	});
	// });
	// $( document ).on( "click", ".delete", function() {
	// 	$('input[name=_token]').val($(this).data('record-id'));
	// 	const id = $(this).data('id');
	// 	$('#delete_record').attr('action',base_url+'/delete_dayoff/'+id);
	// });
	// // end remove dayoff
});
</script>
<!-- 7381jazz Modal -->
<div class="modal fade" id="myModalDayoff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="username">Nama</label>
					<input type="text" id="username" class="form-control" readonly>
					<input type="hidden" id="user_id">
				</div>
				<div class="form-group">
					<label for="employee_id">NIK</label>
					<input type="text" id="employee_id" class="form-control" readonly>
				</div>
				<div class="form-group">
					<label for="site">Site</label>
					<input type="text" id="site" class="form-control" readonly>
				</div>
				<div class="form-group">
					<label for="divisi">Divisi</label>
					<input type="text" id="divisi" class="form-control" readonly>
					<input type="hidden" id="sub_department_id">
				</div>
				<div class="form-group">
					<label for="shift">Shift</label>
					<input type="text" id="shift" class="form-control" readonly>
					<input type="hidden" id="office_shift_id">
				</div>
				<div class="form-group">
					<label for="shift">Current Day Off Select</label>
					<input type="text" id="date" class="form-control" readonly>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary add_dayoff">Submit Day off</button>
			</div>
		</form>
    </div>
  </div>
</div>
<!-- end modal -->
<!-- 7381jazz Content event -->
<div id="dayoffName" class="fc-popover fc-more-popover" style="display:none; z-index: 100;">
  <div class="fc-header fc-widget-header"> <span class="fc-close fc-icon fc-icon-x">&nbsp;</span><span class="fc-title"><?php echo $this->lang->line('xin_hr_add_options');?></span>
    <div class="fc-clear"></div>
  </div>
	<div class="fc-body fc-widget-content" style=" overflow: auto; height: 250px;">
    <div class="fc-event-container value_dayoff">
		</div>
	</div>
</div>
<!-- end Content -->
<style type="text/css">
.trumbowyg-box.trumbowyg-editor-visible {
  min-height: 90px !important;
}
.fc-day-grid-event {
    padding: 0px 5px !important;
}
.fc-events-container .fc-event {
    padding: 2px !important;
}
.trumbowyg-editor {
  min-height: 90px !important;
}
.fc-day:hover, .fc-day-number:hover, .fc-content:hover{cursor: pointer;}

.fc-close {
    font-size: .9em !important;
    margin-top: 2px !important;
}
.fc-close {
    float: right !important;
}

.fc-close {
    color: #666 !important;
}
.fc-event.fc-draggable, .fc-event[href], .fc-popover .fc-header .fc-close {
    cursor: pointer;
}
.fc-widget-header {
    background: #E4EBF1 !important;
}
.fc-widget-content {
	background: #FFFFFF;
}

.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
.fc-event { line-height: 2.0 !important; }
.list-group .active{
	background-color : #3c8dbc !important;
	color : #FFFFFF !important;
}
</style>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>