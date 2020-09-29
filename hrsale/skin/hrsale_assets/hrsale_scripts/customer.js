$(document).ready(function() {
	var customerDataTable = $('#customer_data').dataTable({
			"bDestroy": true,
			"ajax": {
				url : base_url+"/customer_list/",
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();
			},
			dom: 'Bfrtip',
      buttons: [{
				extend : 'csv',
				text : '<i class="fa fa-file-excel-o"></i> Download CSV',
				titleAttr : 'Export to excel',
				exportOptions: {
						columns: [ 1, 2],
						modifier : {
								order : 'applied',  // 'current', 'applied', 'index',  'original'
								page : 'all',      // 'all', 'current'
								search : 'applied'     // 'none', 'applied', 'removed'
						},
				},
			}]
		});
		var duplicateNumberTable = $('#duplicate_number_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : base_url+"/duplicate_contacts_list/",
				type : 'GET'
			},
		});

	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
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
					customerDataTable.api().ajax.reload(function(){
						// toastr.success(JSON.result);
					}, true);
					duplicateNumberTable.api().ajax.reload(function(){
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}
			}
		});
	});
}); // end document

$( document ).on( "click", ".delete", function() {
// $('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',base_url+'/delete');
});
