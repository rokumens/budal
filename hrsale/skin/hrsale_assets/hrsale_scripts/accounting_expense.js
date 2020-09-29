$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
    "ajax": {
      url : base_url+'/expense_list/',
      type : 'GET'
    },
    "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();
    }
  });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#description').trumbowyg();
	$(".from-account").change(function(){
		var ac_balance = $(this).find('option:selected').attr('account-balance');
		$('#acc_balance').html(' Available Balance: '+ac_balance);
		$('#account_balance').val(ac_balance);
		$('#acc_balance').show();
	});
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
		var expense_id = button.data('expense_id');
		var modal = $(this);
	$.ajax({
		url :  base_url+"/read_expense/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=expense&expense_id='+expense_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var deposit_id = button.data('deposit_id');
		var modal = $(this);
	$.ajax({
		url :  base_url+"/read_deposit/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_award&deposit_id='+deposit_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
	/* Update logo */
	$("#xin-form").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 1);
	fd.append("add_type", 'expense');
	fd.append("form", action);
	e.preventDefault();
	$('.icon-spinner3').show();
	$('.btn').prop('disabled', true); // luffy 9 January 2020 07:37 pm
	$.ajax({
		url: e.target.action,
		type: "POST",
		data:  fd,
		contentType: false,
		cache: false,
		processData:false,
		success: function(JSON)
		{
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
        // luffy 9 January 2020 07:37 pm
				$('.btn').prop('disabled', true);
				$('.btn').prop('disabled', false);
				$('.icon-spinner3').hide();
			} else {
				xin_table.api().ajax.reload(function(){
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.add-form').removeClass('in');
				$('.btn').prop('disabled', false);
        // luffy 9 January 2020 07:37 pm
        // clear all fields
        $('#xin-form')[0].reset(); // To reset form fields
        $(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
        $(':checkbox, :radio').prop('checked', false);
        $('#description').trumbowyg('empty');
        $('.select2-hidden-accessible').val(null).trigger('change');
			}
		},
    // luffy 9 January 2020 07:38 pm
    error: function(xhr, textStatus, error) {
      // console.log('Error Berat: ' + xhr.responseText);  // luffy
      // console.log('Error Berat: ' + xhr.statusText); // luffy
      // console.log('Error Berat: ' + textStatus); // luffy
      // console.log('Error Berat: ' + error); // luffy
      $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
      xin_table.api().ajax.reload(function(){
        toastr.error("Error. Please contact dev team.");
      }, true);
    },
		// error: function()
		// {
		// 	toastr.error(JSON.error);
		// 	$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
		// 	$('.icon-spinner3').hide();
		// 	$('.save').prop('disabled', false);
		// }
   });
});
/* Add data */ /*Form Submit*/
//	$("#xin-form").submit(function(e){});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete_expense/'+$(this).data('record-id'));
});
