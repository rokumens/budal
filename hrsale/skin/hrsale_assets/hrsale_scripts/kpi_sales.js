$(document).ready(function() {
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/kpi_sales_list/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery(".taskId").change(function(){
		jQuery.get(base_url+"/get_requirement/"+jQuery(this).val(), function(data, status){
			jQuery('.minRequirement').html(data);
		});
	});
  $('.valuePercentage, .minimumAmount').bind('keyup mouseup', function () {
			var minimumAmountVal=$('.minimumAmount');
			var monthlyRequirement=$('.monthlyRequirement').val();
			var minimumAmount=minimumAmountVal.val().split('.').join('');
			let result = Math.floor(parseInt($(".valuePercentage").val()*parseInt(minimumAmount/100))).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			let resultEmpBonus = Math.floor(parseInt($(".valuePercentage").val()*parseInt(minimumAmount/100)));
			let employeeBonus = Math.floor(resultEmpBonus*monthlyRequirement).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			let totalDeposit = Math.floor(minimumAmount*monthlyRequirement).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      $('.valueAmount').val(result || '');
      $('.employeeBonus').val(employeeBonus);
      $('.totalDeposit').val(totalDeposit);
	});
	/* add */
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'add_kpi_sales');
		fd.append("form", action);
		e.preventDefault();
		$('.btn').prop('disabled', true); // luffy 8 January 2020 03:23 pm
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
					// luffy 8 January 2020 03:23 pm
					$('.btn').prop('disabled', true);
					$('.btn').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('in');
					$('.btn').prop('disabled', false);
					// luffy 8 January 2020 03:23 pm
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
		var kpi_sales_id = button.data('kpi_sales_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=kpi_sales_update&kpi_sales_id='+kpi_sales_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	// view and get data
	$('.view-modal-data-bg').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var kpi_sales_id = button.data('kpi_sales_id');
		var modal = $(this);
	  $.ajax({
			url: base_url+'/read/',
			type: "GET",
			data: 'jd=1&is_ajax=4&mode=modal&data=view_kpi_sales_task&type=view_kpi_sales_task&kpi_sales_id='+kpi_sales_id,
			success: function (response) {
				if(response) {
					$("#pajax_modal_view").html(response);
				}
			}
		});
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
			},
			error: function(xhr, textStatus, error) {
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
}); // end document
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});