$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/goal_tracking_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		  $('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#description').trumbowyg();
	/* del */
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
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}
			}
		});
	});
	// update
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var tracking_id = button.data('tracking_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read_goal/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=tracking&tracking_id='+tracking_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	$('.view-modal-data').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var tracking_id = button.data('tracking_id');
			var modal = $(this);
			$.ajax({
				url : base_url+'/read_goal/',
				type: "GET",
				data: 'jd=1&is_ajax=1&mode=modal&data=view_tracking&tracking_id='+tracking_id,
				success: function (response) {
					if(response) {
						$("#ajax_modal_view").html(response);
					}
				}
			});
		});
	/* add */
	$("#xin-form").submit(function(e){
	  e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.btn').prop('disabled', true);
		$(".icon-spinner3").show();// luffy 12 January 2020 05:22 pm
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=tracking&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					// luffy 12 January 2020 05:22 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$(".icon-spinner3").hide();
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$(".icon-spinner3").hide();
					$('.btn').prop('disabled', false);
					// luffy 12 January 2020 05:22 pm
					// clear all fields
					$('#xin-form')[0].reset(); // To reset form fields
					$(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    			$(':checkbox, :radio').prop('checked', false);
					$('#description').trumbowyg('empty');
					$('.select2-hidden-accessible').val(null).trigger('change');
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/tracking_delete/'+$(this).data('record-id'))+'/';
});
