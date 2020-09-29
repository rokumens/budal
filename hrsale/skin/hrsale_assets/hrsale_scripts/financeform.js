$(document).ready(function() {
  var xin_table = $('#xin_table').dataTable({
    "bDestroy": true,
    "ajax": {
      url : site_url+"accounting/financeform_list/0/",
      type : 'GET'
    },
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
	    $('[data-toggle="tooltip"]').tooltip();
		}
  });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	/* roles report */
	$("#financeform_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var formId = $('#formId').val();
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"accounting/financeform_list/"+formId+"/",
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			  $('[data-toggle="tooltip"]').tooltip();
			}
		});
		toastr.success('Request Submit.');
		xin_table2.api().ajax.reload(function(){ }, true);
	});
});
