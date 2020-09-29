<script>
    $(function() {
        var cardTitle = $('#card_title');
        var usersTable = $('#items_table');
        var resultsContainer = $('#search_results');
        var usersCount = $('#user_count');
        var clearSearchTrigger = $('.clear-search');
        var searchform = $('#livechat_users');
        var searchformInput = $('#livechat_search_box');
        var userPagination = $('#user_pagination');
        var searchSubmit = $('#search_trigger');
        var btnGroupAssigned = $('#btnGroupAssigned');
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
                               '<td colspan="8" align="center">No Result</td>' +
                               '</tr>';
            let loadingData = '<tr id="loadingData">' +
                                '<td colspan="8" align="center"><i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Collecting data, please wait...</td>' +
                                '</tr>';

            $.ajax({
                type:'POST',
                url: "{{ route('search-livechat') }}",
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
                            // let assignedTo = '';
                            //
                            // if (val.assign_to === null) {
                            //     assignedTo = 'not yet';
                            // } else {
                            //     assignedTo = val.name;
                            // };

                            resultsContainer.append('<tr>' +
                                '<td>test</td>' +
                            '</tr>');
                        });
                    } else {
                        resultsContainer.append(noResulsHtml);
                    };
                    usersCount.html(jsonData.length + " {!! trans('usersmanagement.search.found-footer') !!}");
                    userPagination.hide();
                    cardTitle.html("{!! trans('usersmanagement.search.title') !!}");
                    btnGroupAssigned.hide();
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
            if ($('#livechat_search_box').val() != '') {
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
            $('#startDate').val("");
            $('#endDate').val("");
            btnGroupAssigned.show();
        });
    });

</script>
