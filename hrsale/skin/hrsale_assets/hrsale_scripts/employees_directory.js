$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/employees_directory/0/0/0/0/",
            type : 'GET'
        },
		// dom: 'lBfrtip',
		// "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();
		}
    });

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// get departments
	jQuery("#aj_company").change(function(){
		var c_id = jQuery(this).val();
		jQuery.get(base_url+"/location_directory/"+c_id, function(data, status){
			jQuery('#location_ajax').html(data);
		});
    jQuery.get(base_url+"/departments_directory/"+c_id, function(data, status){
      jQuery('#department_ajax').html(data);
    });
		// if(c_id == 0){
			jQuery.get(base_url+"/shift_directory/"+jQuery(this).val(), function(data, status){
				jQuery('#shift_ajax').html(data);
			});
		// }
	});

	/* direcotory form */
	$("#employees_directory_form").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var company_id = $('#aj_company').val();
		var location_id = $('#location_id').val();
		var department_id = $('#aj_department').val();
		var shift_id = $('#shift_id').val();
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"employees/employees_directory/"+company_id+"/"+location_id+"/"+department_id+"/"+shift_id+"/",
				type : 'GET'
			},
			// dom: 'lBfrtip',
			// "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();
			}
		});
		toastr.success('Filtered.');
		xin_table2.api().ajax.reload(function(){ }, true);
	});
});
