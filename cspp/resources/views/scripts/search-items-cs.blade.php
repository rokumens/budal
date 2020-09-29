<script>
    $(function() {
        var cardTitle = $('#card_title');
        var usersTable = $('#items_table_cs');
        var resultsContainer = $('#search_results');
        var usersCount = $('#user_count');
        var clearSearchTrigger = $('.clear-search');
        var searchform = $('#search_users');
        var searchformInput = $('#user_search_box');
        var userPagination = $('#user_pagination');
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
                url: "{{ route('search-items-cs') }}",
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

                            let contacted = '';
                            let notes = '';
                            let merchant = '';
                            let connect_response = '';
                            let campaign_result = '';

                            if ((val.merchant === null) || (val.merchant === "")) {
                                merchant = '-';
                            } else {
                                merchant = val.merchant.substr(0, 10)+"...";
                            };

                            if (val.contacted === 0) {
                                contacted = 'not yet';
                            } else {
                                contacted = "done";
                            };

                            if ((val.notes_1 === null) || (val.notes_1 === "")) {
                                notes = '-';
                            } else {
                                notes = val.notes_1.substr(0, 10)+"...";
                            };

                            if ((val.connect_response === null) || (val.connect_response === ""))  {
                                connect_response = '-';
                            } else {
                                connect_response = val.connect_response;
                            };

                            if ((val.campaign_result === null) || (val.campaign_result === "")) {
                                campaign_result = '-';
                            } else {
                                campaign_result = val.campaign_result;
                            };

                            resultsContainer.append('<tr>' +
                                '<td>' + val.bank_account_name + '</td>' +
                                '<td>' + val.mobile_1 + '</td>' +
                                '<td class="hidden-xs">' + val.bank + '</td>' +
                                '<td class="hidden-xs">' + val.bank_account_number + '</td>' +
                                '<td class="hidden-xs">' + merchant + '</td>' +
                                '<td class="hidden-sm hidden-xs">' + val.provider  +'</td>' +
                                '<td class="hidden-sm hidden-xs">' + contacted  +'</td>' +
                                '<td class="hidden-sm hidden-xs hidden-md">' + connect_response + '</td>' +
                                '<td class="hidden-sm hidden-xs hidden-md">' + campaign_result + '</td>' +
                                '<td class="hidden-sm hidden-xs hidden-md">' + notes + '</td>' +
                                '<td><a href="#" class="btn btn-sm btn-info btn-block editModalBtn" data-toggle="modal" data-id="' + val.id  +'" data-contacted="' + val.contacted  +'" data-notes="' + val.notes_1  +'">Edit</a></td>' +
                            '</tr>');
                        });

                        // update in modal
                        $('.editModalBtn').click(function() {
                          var id=$(this).data('id');
                          var contacted=$(this).data('contacted');
                          var notes=$(this).data('notes');
                          var action ='{{URL::to('contacted-update')}}/'+id;
                          var url = '{{URL::to('contacted-update')}}';
                          $.ajax({
                            url  : url,
                            data: {'id': id},
                            method: "get",
                            success:function(data){
                                $('.contacted_id').prop('checked', contacted == 1); //will checked the checkbox if done contacted
                                $('.notes_id').val(notes);
                                $('.classFormUpdate').attr('action',action);
                                $('#editModal').modal('show');
                            },
                            error: function (xhr, textStatus, errorThrown) {
                    						alert(textStatus + ':' + errorThrown);
                    				},
                          });
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
            if ($('#user_search_box').val() != '') {
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

    // update in modal
    $('.editModalBtn').click(function() {
      var id=$(this).data('id');
      var contacted=$(this).data('contacted');
      var notes=$(this).data('notes');
      var action ='{{URL::to('contacted-update')}}/'+id;
      var url = '{{URL::to('contacted-update')}}';
      $.ajax({
        url  : url,
        data: {'id': id},
        method: "get",
        success:function(data){
            $('.contacted_id').prop('checked', contacted == 1); //will checked the checkbox if done contacted
            $('.notes_id').val(notes);
            $('.classFormUpdate').attr('action',action);
            $('#editModal').modal('show');
        },
        error: function (xhr, textStatus, errorThrown) {
						alert(textStatus + ':' + errorThrown);
				},
      });
    });

</script>
