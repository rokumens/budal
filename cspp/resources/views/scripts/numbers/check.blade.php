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
  
      // buat Category Web sewaktu upload Excel
      $('#listCatWeb a').on('click', function(){
          $('#catWebExcelValue').val($(this).attr("data-value"));
          $("#btnGroupCatWeb").html($(this).text() + ' <span class="caret"></span>');
          $("#btnGroupCatWeb").val($(this).data('value'));
          $('#btnGroupCatWeb').removeClass("tombolKedip-outline");
  
          $("#divCatGame").show("fast");
  
          if( $(this).data('value') == 1 ){
            $('#catExcelValue').val("");
            $("#btnGroupCatGame").html('Game <span class="caret"></span>');
            $("#btnGroupCatGame").removeAttr("disabled");
          }
          if( $(this).data('value') == 2 ){
            $('#catExcelValue').val(8);
            $("#btnGroupCatGame").html('Whitelabel Umum');
            $("#btnGroupCatGame").val($(this).data('value'));
            $("#btnGroupCatGame").attr("disabled", true);
            $('#btnGroupCatGame').removeClass("tombolKedip-outline");
          }
          if( $(this).data('value') == 3 ){
            $('#catExcelValue').val(6);
            $("#btnGroupCatGame").html('Poker/P2P');
            $("#btnGroupCatGame").val($(this).data('value'));
            $("#btnGroupCatGame").attr("disabled", true);
            $('#btnGroupCatGame').removeClass("tombolKedip-outline");
          }
          if( $(this).data('value') == 4 ){
            $('#catExcelValue').val(5);
            $("#btnGroupCatGame").html('Togel');
            $("#btnGroupCatGame").val($(this).data('value'));
            $("#btnGroupCatGame").attr("disabled", true);
            $('#btnGroupCatGame').removeClass("tombolKedip-outline");
          }
          if( $(this).data('value') == 5 ){
            $('#catExcelValue').val(4);
            $("#btnGroupCatGame").html('Tembak Ikan');
            $("#btnGroupCatGame").val($(this).data('value'));
            $("#btnGroupCatGame").attr("disabled", true);
            $('#btnGroupCatGame').removeClass("tombolKedip-outline");
          }
          if( $(this).data('value') == 6 ){
            $('#catExcelValue').val(3);
            $("#btnGroupCatGame").html('Casino Games');
            $("#btnGroupCatGame").val($(this).data('value'));
            $("#btnGroupCatGame").attr("disabled", true);
            $('#btnGroupCatGame').removeClass("tombolKedip-outline");
          }
  
      });
      // buat Category Game sewaktu upload Excel
      $('#listCatGame a').on('click', function(){
          $('#catExcelValue').val($(this).attr("data-value"));
          $("#btnGroupCatGame").html($(this).text() + ' <span class="caret"></span>');
          $("#btnGroupCatGame").val($(this).data('value'));
          $('#btnGroupCatGame').removeClass("tombolKedip-outline");
      });
      
      // Jazz 7381 21 februari 2020
      var dataTableAdminLeader = $('#clients_ajax_table_server_side').DataTable({
          "processing": true,
          "serverSide": true,
          "lengthMenu": [[25, 50, 100, 150], [25, 50, 100, 150]],
          "stateSave": false,
          "bFilter": false,
          "language": {
              "processing": '<i class="fa fa-spinner fa-spin" style="font-size:22px; color:#3279FD; position:relative; top:2px;"></i> Processing...'
          },
          "ajax":{
              url: "{{ route('ajaxdata.getdataCheck') }}",
              data: function(d) {
                  d.startContactedDateVal = $('input[name=contactedStartDate]').val();
                  d.endContactedDateVal = $('input[name=contactedEndDate]').val();
                  d.uploadDateVal = $('input[name=uploadDate]').val();
              },
              type: "get",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          },
          "columns":[
            @can('change-cs-check')
            {
              sortable: false,
              render: function ( data, type, full, meta ) {
                var itemsId = full.id;
                if(full.is_cs_exist == ''){
                  return '';
                }else{
                  return '<div class="custom-control custom-checkbox" style="position:relative; left:-8px;"><input type="checkbox" class="custom-control-input checkbox" id="chk' + itemsId + '" data-id="' + itemsId + '"><label class="custom-control-label" for="chk' + itemsId + '"></label></div>';
                }
              },
            },
            @endcan
            { "data": "phone" },
            { "data": "category_web" },
            { "data": "category_game" },
            @can('change-cs-check')
            { "data": "is_cs_exist" },
            @endcan
            { "data": "button" },
          ],
          dom : 'Blfrtip',
          buttons: [
              {
                  extend: 'colvis',
                  text : '<i class="fa fa-eye"></i> Column',
                  titleAttr : 'Column visibility',
                  collectionLayout: 'fixed four-column',
                  postfixButtons: [ 'colvisRestore' ],
                  init: function(api, node, config) {
                      $(node).removeClass('dt-button').addClass("btn btn-outline-secondary .px-2");
                  }
              },
              @role('Biarkan.Begini:alsdfj;ladkjsfl;dkjasf;ldjas;fldaskjdlasfkj')
              // {
              //     extend : 'excel',
              //     text : '<i class="fa fa-file-excel-o"></i> Excel',
              //     titleAttr : 'Export to excel',
              //     exportOptions: {
              //         modifier : {
              //             order : 'applied',  // 'current', 'applied', 'index',  'original'
              //             page : 'all',      // 'all', 'current'
              //             search : 'applied'     // 'none', 'applied', 'removed'
              //         }
              //     },
              //     init: function(api, node, config) {
              //        $(node).removeClass('dt-button').addClass("btn btn-outline-secondary");
              //     }
              // }
              @endrole
          ],
          columnDefs: [
              {
                targets: [], // -2 -3 cat web cat game
                visible: false
              }
          ],
        });
  
        // filtered by Connect Response > Error
        $('.byError').on('click', function() {
            dataTableAdminLeader.columns().search('').draw();
            dataTableAdminLeader.columns(-15).search(9).draw(); //error
        });
        //filtering button mana yg udah / belum di assigned
        $('.clearFilter').on('click', function () {
            dataTableAdminLeader.columns().search('').draw();
            $('.search-thead').val('');
            $('input[name=contactedStartDate]').val('');
            $('input[name=contactedEndDate]').val('');
            $('input[name=uploadDate]').val('');
            $(".searchBox").show("slow");
            $(".datePickerContacted").hide( 1500 );
        });
        $('.notAssigned').on('click', function () {
            dataTableAdminLeader.columns().search('').draw();
            dataTableAdminLeader.columns(-1).search(0).draw();
        });
        $('.doneAssigned').on('click', function () {
            dataTableAdminLeader.columns().search('').draw();
            dataTableAdminLeader.columns(-1).search(1).draw();
        });
        //filtering button mana yg udah / belum di contacted
        $('.notContacted').on('click', function () {
            dataTableAdminLeader.columns().search('').draw();
            @role('admin')dataTableAdminLeader.columns(7).search(0).draw();@endrole
            @role('leader')dataTableAdminLeader.columns(6).search(0).draw();@endrole
        });
        $('.doneContacted').on('click', function () {
            dataTableAdminLeader.columns().search('').draw();
            @role('admin')dataTableAdminLeader.columns(7).search(1).draw();@endrole
            @role('leader')dataTableAdminLeader.columns(6).search(1).draw();@endrole
        });
        // luffy 14 Dec 2019 12:22 pm
        // filtering by Category Web
        @if($catWeb)
          @foreach($catWeb as $singWeb)
            $('.catWeb{{ $singWeb->id }}').on('click', function() {
                dataTableAdminLeader.columns().search('').draw();
                dataTableAdminLeader.columns(-3).search({{ $singWeb->id }}).draw();
            });
          @endforeach
        @endIf
        // luffy 14 Dec 2019 12:07 pm
        // filtering by Category Game
        @if($catGames)
          @foreach($catGames as $singGame)
            $(".catGame{{ $singGame->id }}").on('click', function() {
                dataTableAdminLeader.columns().search('').draw();
                dataTableAdminLeader.columns(-2).search({{ $singGame->id }}).draw();
            });
          @endforeach
        @endIf
  
        // custom search di thead table
        $('.search-thead').on( 'keyup click', function() {   // for text boxes
          var i =$(this).attr('data-column');  // getting column index
          var v =$(this).val();  // getting search input value
          dataTableAdminLeader.columns(i).search(v).draw();
        } );
        $('.search-input-select').on( 'change', function() {   // for select box
          var i =$(this).attr('data-column');
          var v =$(this).val();
          dataTableAdminLeader.columns(i).search(v).draw();
        });
  
        // geser show entries ke kanan
        $( "select[name*='clients_ajax_table_server_side_length']" ).removeClass("custom-select-sm form-control-sm").addClass("custom-select-md form-control-md");
        $( "#clients_ajax_table_server_side_length" ).addClass("pull-right");
  
        // // pastikan hanya excel saja yg diperbolehkan, khususnya csv saja
        // $("#uploadExcel").change(function(){
        //     var validExts = new Array(".csv");
        //     var fileExt = this.value;
        //     fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        //     if (validExts.indexOf(fileExt) < 0) {
        //       alert("Please only use " + validExts.toString() + " types.");
        //       $( "#submitExcel" ).prop( "disabled", true );
        //       return false;
        //     }else{
        //       $( "#submitExcel" ).prop( "disabled", false );
        //       return true;
        //     }
        // });
  
        // // pastikan pilih category web & game sebelum upload.
        // $('#submitExcel').on('click', function(){
        //     if ( $("#catWebExcelValue").val()==='' ) {
        //         $('#btnGroupCatWeb').addClass("tombolKedip-outline");
        //         alert( "Please chooose Web Category." );
        //         return false;
        //     }
        //     if ( $("#catExcelValue").val()==='' ) {
        //         $('#btnGroupCatGame').addClass("tombolKedip-outline");
        //         alert( "Please chooose Game Category." );
        //         return false;
        //     }
        // });
  
        // show / hide filter date by: [ Contacted / Upload]
        $('.filterContactedDate').on('click', function () {
            $(".datePickerContacted").show("slow");
            $(".searchBox").hide( 1500 );
        });
  
        // search by date
        $('.input-daterange').datepicker({
              format: 'dd MM yyyy',
              autoclose: true,
              todayHighlight: true
        });
        $('#contactedDateSearch').on('click', function() {
            dataTableAdminLeader.draw();
        });
        $('#uploadDateSearch').on('click', function() {
            dataTableAdminLeader.draw();
        });
  
        // dropdown Filter by Category Web
        $('.dropdown-submenu a.subMenuCatWeb').on("click", function(e){
          $(this).next('#catWebUl').toggle('fast');
          $('#catGameUl').hide('fast');
          e.stopPropagation();
          e.preventDefault();
        });
        // dropdown Filter by Category Game
        $('.dropdown-submenu a.subMenuCatGame').on("click", function(e){
          $(this).next('#catGameUl').toggle('fast');
          $('#catWebUl').hide('fast');
          e.stopPropagation();
          e.preventDefault();
        });
      
      // when edit button clicked
      $(document).on('click', '.editModalBtn', function(){
        $('#editModal').modal('show');
        $('.hide_note').hide();
        var id = $(this).data('id');
        var master_numbers_id = $(this).data('master_numbers_id');
        var _token = $('input[name="_token"]').val();
        var msg = []; // array prepare for connect response
        $('#master_numbers_id').val($(this).data('master_numbers_id'));
        // ajax get connect response description
        $.ajax({
          url  : '{{ route("get-connect-response") }}',
          method: "get",
          success:function(data){
            $.each(data, function( index, value ) {
              msg[value.id] = value.description;
            });
          }
        });
        // csrf header
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        // ajax get contacted data by master numbers id
        // $.ajax({
        //   url  : '{{ route("ajax-master-numbers") }}',
        //   method: "post",
        //   data: {
        //     id : id,
        //     master_numbers_id : master_numbers_id,
        //     _token : _token,
        //   },
        //   success:function(data){
        //     $('#connectresponse').val(data.connect_response_by_cs);
        //     $('#campaignresult').val(data.campaign_result);
        //     $('.hide_note').val(data.note_check);
        //   }
        // });
        
        $('#connectresponse').val($(this).data('connectresponse'));

        $('form#classForm').attr('action', '{{URL::to("check-update")}}/'+id);
        //disabled when other than yes and no selected
        $('#connectresponse').change(function(){
          const connectResponse = $(this).find(":selected").val();
          // if connect response is active
          if(connectResponse == 1){
            $('.responseDesc').attr('style', 'display: block;');
            $('.responseDesc').html('<strong>Note : </strong>'+msg[connectResponse]);
            $('.hide_note').show();
            $('.hide_note').attr('placeholder', "Tell us your call result with this number...");
          }else if(connectResponse == ''){
            $('.responseDesc').attr('style', 'display: none;');
            $('.hide_note').hide();
          }else if(connectResponse != 1){
            const optionsConnectresponse = $('#connectresponse option');
            // get all value from select option
            const valuesConnectresponse = $.map(optionsConnectresponse ,function(option) {
                return [option.text];
            });
            $('.hide_note').attr('placeholder', "Tell us your call result in more detail why this number "+valuesConnectresponse[connectResponse].toLowerCase()+ '...');
            $('.responseDesc').attr('style', 'display: block;');
            $('.responseDesc').html('<strong>Note : </strong>'+msg[connectResponse]);
            $('#campaignresult').val(3);
            $('.hide_note').show();
          }else if(connectResponse == 1 && campaignResult == 1){
            $('.hide_note').hide();
          }else{
            $('.hide_note').show();
          }
        });
        // button save handler
        $(document).on('click', '.btn-save', function(event){
          if($('#connectresponse').val() == ""){
            event.preventDefault();
            alert('Please fill connect response');
          }else{
            $('#connectresponse').attr("readonly",true);
            $('#connectresponse').removeAttr("disabled");
            return true;
          }
        });
      });

      // view modal
      $(document).on('click', '.viewModalBtn', function(){
        $('#viewModal').modal('show');
        let id = $(this).data('id');
        let master_numbers_id = $(this).data('master_numbers_id');
        let is_cs_exist = $(this).data('is_cs_exist');
        // csrf header
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url : '{{ route("ajax-master-numbers") }}',
          data : {
            id : id,
            master_numbers_id : master_numbers_id,
          },
          type : 'post',
          success: function(data){
            $('.prepend-remove').remove();
            // luffy 12 March 2020 16:43
            var contacted_byNIK_if_null='';
            var contacted_byName_if_null='';
            if(data.contacted_by_nik===null || data.contacted_by_name===null){
              contacted_byNIK_if_null=data.assigned_by_nik;
              contacted_byName_if_null=data.assign_to_name;
            }else{
              contacted_byNIK_if_null=data.contacted_by_nik;
              contacted_byName_if_null=data.contacted_by_name;
            }
            $('.modal-title').html('Check Detail');
            $('#phone').html(data.phone);
            $('#phone').text(function(i, text) {
              return '+'+text.replace(/(\d{2})(\d{4})(\d{4})/, '$1-$2-$3');
            });
            $('#email').html(data.email);
            $('#category_web').html(data.category_web_name);
            $('#category_game').html(data.category_game_name);
            $('#contacted_by').html(contacted_byNIK_if_null +' - '+ contacted_byName_if_null);
            $('#contacted_date').html(moment(data.contacted_date).locale('id').format('LLLL'));
            $('#connect_response_cs').html(data.connect_response_cs_name);
            $('#campaign_result').html(data.campaign_result_name);
            $('#note_contacted').html(data.note_contacted);
            $('#contacted_times').html(data.contacted_times);
            $('#assigned_times').html(data.assigned_times);
            if(is_cs_exist == false){
              $('.is_cs_exist').html(
                '<div class="d-flex align-items-center p-3 my-3 text-white-50 bg-danger rounded box-shadow prepend-remove">' +
                  '<div class="lh-100">' +
                    '<h6 id="phone" class="mb-0 text-white lh-100">Must change CS, due to ' + contacted_byNIK_if_null +' - '+ contacted_byName_if_null + ' is not working on APG anymore.</h6>' +
                  '</div>' +
                '</div>'
              );
            }
          }
        });
      });

      $('.assignto').on('change', function(e) {
        var idsArr = [];
        $(".checkbox:checked").each(function() {
          idsArr.push($(this).attr('data-id'));
        });
        var assigntovalue = this.value;
        if(assigntovalue <=0){
          alert("Please select at least one contact to assign.");
        }
        if(idsArr.length <=0){
          alert("Please select atleast one contact to assign.");
        }else{
          if(confirm("Are you sure, you want to assign the selected contact(s)?")){
            var strIds = idsArr.join(",");
            $.ajax({
              url: "{{ route('numbers'.".$pageName.".'assignto') }}",
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: 'ids=' + strIds + '&assignto=' + assigntovalue,
              success: function (data) {
                if (data['status']==true) {
                  // alert(data['message']);
                  window.location.reload();
                } else {
                  alert('Whoops, something went wrong! Please try again or refresh the page.');
                }
              },
              error: function (data) {
                // alert("error: " + data['status']);
                // alert(data.responseText);
                console.log(data.responseText);
              }
            });
          }
        }
      });

    });

    // Search function
    $(function() {
      var cardTitle = $('#card_title');
      var usersTable = $('#numbers_table');
      var resultsContainer = $('#search_results');
      var usersCount = $('#clients_ajax_table_server_side_info');
      var clearSearchTrigger = $('.clear-search');
      var searchform = $('#search_numbers');
      var searchformInput = $('#numbers_search_box');
      var userPagination = $('#clients_ajax_table_server_side_paginate');
      var searchSubmit = $('#search_trigger');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      searchform.submit(function(e) {
        e.preventDefault();
        resultsContainer.html('');
        usersTable.hide();
        clearSearchTrigger.show();
        let noResulsHtml = '<tr>' +
                            '<td colspan="11" align="center">- No Result -</td>' +
                            '</tr>';
        let loadingData = '<tr id="loadingData">' +
                            '<td colspan="11" align="center"><i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Processing...</td>' +
                            '</tr>';
        $.ajax({
          type:'POST',
          url: "{{ route('search-check') }}",
          data: searchform.serialize(),
          beforeSend: function(){
            resultsContainer.append(loadingData);
          },
          complete: function(){
            $("#loadingData").hide();
          },
          success: function (result) {
            let jsonData = JSON.parse(result);
            if (jsonData.length != 0) {
              $.each(jsonData, function(index, val) {
                resultsContainer.append('<tr>' +
                  '<td>' + val.phone + '</td>' +
                  '<td>' + val.category_web + '</td>' +
                  '<td>' + val.category_game + '</td>' +
                  '<td>' + '<a href="#" class="btn btn-sm btn-success viewModalBtn" data-toggle="modal" data-id="' + val.id  +'" data-master_numbers_id="' + val.master_numbers_id  +'">View</a>' + '<a href="#" class="btn btn-sm btn-info editModalBtn" data-toggle="modal" data-id="' + val.id  +'" data-master_numbers_id="' + val.master_numbers_id  +'">Edit</a></td>' +
                '</tr>');
              });
            } else {
              resultsContainer.append(noResulsHtml);
            };
            usersCount.html(jsonData.length + " {!! trans('usersmanagement.search.found-footer') !!}");
            userPagination.hide();
            cardTitle.html("{!! trans('usersmanagement.search.title') !!}");
          },
          error: function (response, status, error) {
            if (response.status === 422) {
              resultsContainer.append(noResulsHtml);
              usersCount.html(0 + " {!! trans('usersmanagement.search.found-footer') !!}");
              userPagination.hide();
              cardTitle.html("{!! trans('usersmanagement.search.title') !!}");
            };
          },
        });
      });
      searchSubmit.click(function(event) {
        event.preventDefault();
        searchform.submit();
      });
      searchformInput.keyup(function(event) {
        if ($('#numbers_search_box').val() != '') {
          clearSearchTrigger.show();
        } else {
          clearSearchTrigger.hide();
          resultsContainer.html('');
          usersTable.show();
          cardTitle.html("{!! trans('usersmanagement.showing-all-users') !!}");
          userPagination.show();
          usersCount.html(" ");
        };
      });
      clearSearchTrigger.click(function(e) {
        e.preventDefault();
        clearSearchTrigger.hide();
        usersTable.show();
        resultsContainer.html('');
        searchformInput.val('');
        cardTitle.html("{!! trans('usersmanagement.showing-all-users') !!}");
        userPagination.show();
        usersCount.html(" ");
      });
    });
  </script>
  