<script type="text/javascript">
  $(document).ready(function () {
    $('#check_all').on('click', function(e) {
    if($(this).is(':checked',true))
    {
        $(".checkbox").prop('checked', true);
    } else {
        $(".checkbox").prop('checked',false);
    }
    });

    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#check_all').prop('checked',true);
        }else{
            $('#check_all').prop('checked',false);
        }
    });
    
    // Jazz 7381 21 februari 2020
    var dataTableAdminLeader = $('#clients_ajax_table_server_side').DataTable({
      "processing": true,
      "serverSide": true,
      "lengthMenu": [[25, 50, 100, 150], [25, 50, 100, 150]],
      "stateSave": false,
      "bFilter": true,
      "language": {
          "processing": '<i class="fa fa-spinner fa-spin" style="font-size:22px; color:#3279FD; position:relative; top:2px;"></i> Processing...'
      },
      "ajax":{
          url: "{{ route('ajaxdata.user.deleted') }}",
          type: "get",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      },
      "columns":[
        { "data": "nik" },
        { "data": "name" },
        { "data": "email" },
        { "data": "button" },
      ],
    });
  });

</script>
