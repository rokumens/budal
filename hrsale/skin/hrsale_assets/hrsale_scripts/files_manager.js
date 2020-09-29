$(document).ready(function(){
  var xin_table_files = $('#xin_table_files').dataTable({
    "bDestroy": true,
    "ajax": {
    	url : site_url+'files/files_list/dId/'+$('#depval').val(),
    	type : 'GET'
    },
    "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();
    }
  });
  /* add */
  $("#xin-form").submit(function(e){
  var fd = new FormData(this);
  var obj = $(this), action = obj.attr('name');
  fd.append("is_ajax", 2);
  fd.append("type", 'file_info');
  fd.append("data", 'file_info');
  fd.append("form", action);
  var dep_id = $('#department_id').val();
  e.preventDefault();
  $('.btn').prop('disabled', true); // luffy 9 January 2020 08:48 pm
  $.ajax({
  	url: e.target.action,
  	type: "POST",
  	data:  fd,
  	contentType: false,
  	cache: false,
  	processData:false,
  	success: function(JSON){
  		if(JSON.error != '') {
  			toastr.error(JSON.error);
  			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
        // luffy 9 January 2020 08:48 pm
  			$('.btn').prop('disabled', true);
  			$('.btn').prop('disabled', false);
  		} else {
  			var xin_table_files2 = $('#xin_table_files').dataTable({
  				"bDestroy": true,
  				"ajax": {
  					url : site_url+'files/files_list/dId/'+dep_id,
  					type : 'GET'
  				},
  				"fnDrawCallback": function(settings){
  				 $('[data-toggle="tooltip"]').tooltip();
  				}
  			});
  			xin_table_files2.api().ajax.reload(function(){
  				toastr.success(JSON.result);
  			}, true);
  			$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
  			$('#xin-form')[0].reset();
  			$('.btn').prop('disabled', false);
        // luffy 9 January 2020 08:48 pm
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
      xin_table_files.api().ajax.reload(function(){
        toastr.error("Error. Please contact dev team.");
      }, true);
      setTimeout(function(){
        location.reload();
      }, 1500);
    },
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
      			xin_table_files.api().ajax.reload(function(){
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
          $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
          xin_table_files.api().ajax.reload(function(){
            toastr.error("Error. Please contact dev team.");
          }, true);
          setTimeout(function(){
            location.reload();
          }, 1500);
        },
      });
  });
  // update
  $('.payroll_template_modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var file_id = button.data('file_id');
    var modal = $(this);
    $.ajax({
      url :  site_url+"files/read/",
      type: "GET",
      data: 'jd=1&is_ajax=1&mode=modal&data=file_manager&file_id='+file_id,
      success: function (response) {
      	if(response) {
      		$("#ajax_modal_payroll").html(response);
      	}
      }
    });
  });
  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
  $('[data-plugin="select_hrm"]').select2({ width:'100%' });
  // get department files
  $(".department-file").click(function(){
    var dep_id = $(this).data('department-id');
    var xin_table_files = $('#xin_table_files').dataTable({
      "bDestroy": true,
      "ajax": {
      	url : site_url+'files/files_list/dId/'+dep_id,
      	type : 'GET'
      },
      "fnDrawCallback": function(settings){
        $('[data-toggle="tooltip"]').tooltip();
      }
    });
  });
  $(".not-allowed").click(function(){
    toastr.error('You can access only own department files!!!');
  });
  $(".nav-tabs-link").click(function(){
    var config_id = $(this).data('config');
    var config_block = $(this).data('config-block');
    $('.nav-tabs-link').removeClass('active');
    $('#config_'+config_id).addClass('active');
  });
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'files/delete/'+$(this).data('record-id'));
});
