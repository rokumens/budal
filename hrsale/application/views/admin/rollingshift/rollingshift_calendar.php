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
.fc-today {
    background: #FFF !important;
    border: none !important;
    border-top: 1px solid #ddd !important;
    font-weight: bold;
} 
.popover-title {
    font-size: 1.2rem !important;
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
    font-size: 1.1rem !important;
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
	// $('.fc-time-grid-container').removeAttr();
	$('#rollingshift_list').fullCalendar({
		header: {
			// left: 'prev,next today',
			left: 'prev,next',
			center: 'title',
			right: '',
		},
		themeSystem: 'bootstrap4',
		firstDay : 1,
		bootstrapFontAwesome: {
			close: ' ion ion-md-close',
			prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
			next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
		}, 
		eventRender: function(event, element, date) {
			element.attr('title',event.title).tooltip().append(event.subdept);
			// element.attr('href', 'javascript:;');
			element.attr('data-id', event.id);
			element.attr('data-user_id', event.user_id);
			// element.attr('class', event.class);
			element.attr('data-toggle', event.toggle);
			element.attr('data-target', event.target);
			element.attr('data-date', event.dates);
			element.attr('class', event.class);
			element.attr('data-original-title', event.shift);
			element.attr('orderBySubDept', event.orderBySubDept);
		},
		theme:true,
		defaultDate: '<?=$this->uri->segment(5);?>',
		defaultView: 'agendaWeek',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		// editable:true, // make dragable
		// eventDrop: function(event, delta, revertFunc) { // event when drop
		nextDayThreshold: '00:00:00',
		eventOrder: ['shift', 'orderBySubDept'],
		events: [
			<?php foreach($rollingshift as $d): ?>
				<?php if(!empty($checkDayoff)): ?>
				{
						title: '<?=$d['employee_id'].' - '.$d['username'];?>',
						shift: '<?=$d['shift_name'];?>',
						start: '<?=$d['rollingshift_date']?>',
						color: "<?=$d['is_leave_at'] == NULL ? ($d['rollingshift_date'] == $d['dayoff_date'] ? '#eb3d34 !important' : ($d['office_shift_id'] == 1 ? '#56c4e8 !important' : '#58506e !important')) : '#97a832 !important' ;?>",
						user_id: "<?=$d['user_id'];?>",
						subdept: "<?=$d['is_leave_at'] == NULL ? ($d['rollingshift_date'] == $d['dayoff_date'] ? $d['department_name'].' (Dayoff)' : $d['department_name']) : $d['department_name'].' (Leave)' ;?>",
						orderBySubDept: "<?=$d['department_name'];?>",
						id: '<?=$d['id']?>',
						class: 'detailShift fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable',
						toggle: 'modal',
						target: '#myModalRollingshift',
						dayoff: "<?=($d['rollingshift_date'] == $d['dayoff_date']) ? ' Dayoff' : '';?>"
				},
				<?php else: ?>
				{
					title: '<?=$d['employee_id'].' - '.$d['username'];?>',
					shift: '<?=$d['shift_name'];?>',
					start: '<?=$d['rollingshift_date']?>',
					color: "<?=$d['is_leave_at'] == NULL ? ($d['office_shift_id'] == 1 ? '#56c4e8 !important' : '#58506e !important') : '#97a832 !important';?>",
					user_id: "<?=$d['user_id'];?>",
					subdept: "<?=$d['is_leave_at'] == NULL ? $d['department_name'] : $d['department_name'].' (Leave)';?>",
					orderBySubDept: "<?=$d['department_name'];?>",
					id: '<?=$d['id']?>',
					class: 'detailShift fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable',
					toggle: 'modal',
					target: '#myModalRollingshift',
				},
				<?php endif; ?>
			<?php endforeach; ?>
		],
	});
	$('.fc-icon-x').click(function() {
		$('#rollingshiftName').hide();
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
	// End jazz7381
});
$(document).ready(function(){
	$("#dayoffDeptList a").click(function(){
		$('#dayoffDeptList a').removeClass('active');
		$(this).addClass('active');
	});
	$(".department-file").click(function(){
		var dep_id = $(this).data('department-id');
		$('.currentSubDept').val(dep_id);
	});
	$("#delete_record").submit(function(e){
	  	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					// rollingshift_calendar_div.api().ajax.reload(function(){
						toastr.success(JSON.result);
						// refresh_calendar_div();
						window.location.href = base_url;
					// }, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}
			},
			// error: function(xhr, textStatus, error) {
			// 	console.log('Error Berat: ' + xhr.responseText);  // luffy
			// 	console.log('Error Berat: ' + xhr.statusText); // luffy
			// 	console.log('Error Berat: ' + textStatus); // luffy
			// 	console.log('Error Berat: ' + error); // luffy
			// },
		});
	});
	$('#delete-record').submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					toastr.success(JSON.result);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('#rollingshift_list').fullCalendar('refetchEvents');
					$('input[name=_token]').val($(this).data('record-id'));
					$('#delete_record').attr('action',);
				}
			},
			error: function(xhr, textStatus, error) {
				// console.log('Error Berat: ' + xhr.responseText);  // luffy
				// console.log('Error Berat: ' + xhr.statusText); // luffy
				// console.log('Error Berat: ' + textStatus); // luffy
				// console.log('Error Berat: ' + error); // luffy
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				toastr.error("Error. Please contact dev team.");
				setTimeout(function(){
				  location.reload();
				}, 1500);
			},
		});
	});
	$( document ).on( "click", ".delete", function() {
		$('input[name=_token]').val($(this).data('record-id'));
		const id = $(this).data('id');
		$('#delete_record').attr('action',base_url+'/delete_rollingshift/'+id);
	});
});
</script>

<!-- Modal -->
<div class="modal fade" id="myModalRollingshift" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
			<?php $attributes = array('name' => 'edit_rollingshift', 'id' => 'edit_rollingshift', 'autocomplete' => 'off');?>
      <?php $hidden = array();?>
      <?php echo form_open('admin/rollingshift/edit_rollingshift', $attributes, $hidden);?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="id" name="id">
				<input type="hidden" id="date" name="date">
				<input type="hidden" id="anual_leave_date" name="anual_leave_date">
				<input type="hidden" id="period" name="period">
				<div class="form-group">
					<label for="username">Name</label>
					<input type="text" id="username" name="username" class="form-control" readonly>
					<input type="hidden" id="user_id">
				</div>
				<div class="form-group">
					<label for="employee_id">NIK</label>
					<input type="text" id="employee_id" name="employee_id" class="form-control" readonly>
				</div>
				<div class="form-group">
					<label for="divisi">Division</label>
					<?=form_dropdown('divisi', $oprasional, set_value('divisi'), 'id="divisi" class="form-control"');?>
				</div>
				<div class="form-group">
					<label for="shift">Shift</label>
					<?=form_dropdown('shift', $shift, '', 'id="shift" class="form-control"');?>
				</div>
				<div class="form-group">
					<label for="anual_leave">Current Anual Leave?</label>
					<?=form_dropdown('anual_leave', ['0'=>'No', '1'=>'Yes'], set_value('anual_leave'), 'id="anual_leave" class="form-control"');?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
    </div>
  </div>
</div>
<!-- jazz -->
<div id="rollingshiftName" class="fc-popover fc-more-popover" style="display:none; z-index: 100;">
  <div class="fc-header fc-widget-header"> <span class="fc-close fc-icon fc-icon-x">&nbsp;</span><span class="fc-title"><?php echo $this->lang->line('xin_hr_add_options');?></span>
    <div class="fc-clear"></div>
  </div>
  <div class="fc-body fc-widget-content" style=" overflow: auto; height: 250px;">
    <div class="fc-event-container value_rollingshift">
		</div>
	</div>
</div>
<!-- end jazz -->
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
