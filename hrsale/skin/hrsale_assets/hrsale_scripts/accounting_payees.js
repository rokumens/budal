$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
    "ajax": {
    url : base_url+"/payees_list/",
    type : 'GET'
    },
    "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();
    }
  });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$(".add-new-form").click(function(){
		$(".add-form").slideToggle('slow');
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
	$('.payroll_template_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var payee_id = button.data('payee_id');
		var modal = $(this);
  	$.ajax({
  		url : base_url+"/read_payee/",
  		type: "GET",
  		data: 'jd=1&is_ajax=1&mode=modal&data=payee&payee_id='+payee_id,
  		success: function (response) {
  			if(response) {
  				$("#ajax_modal_payroll").html(response);
  			}
  		}
		});
	});
	/* add */
	$("#xin-form").submit(function(e){
	  e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.btn').prop('disabled', true); // luffy 9 January 2020 07:19 pm
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=add_payee&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          // luffy 9 January 2020 07:19 pm
					$('.btn').prop('disabled', false);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.btn').prop('disabled', false);
          // luffy 9 January 2020 07:19 pm
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
	$('#delete_record').attr('action',base_url+'/delete_payee/'+$(this).data('record-id'));
});
