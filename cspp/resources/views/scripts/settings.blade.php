<script type="text/javascript">
  $(document).ready(function () {

    // edit constant event handler
    $('.editConstantBtn').click(function(){
      $('#cosntantEditModal').modal('show');
      let id = $(this).data('id');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url : '{{ route("ajax-constant-yesno") }}',
        data : {
          id : id,
        },
        type : 'post',
        success: function(data){
          $('#constantId').val(data.id);
          $('#constantValue').val(data.value);
          $('#constantName').val(data.name);
          $('form#constant').attr('action', '{{ url('constant-yesno/update') }}/'+data.id);
        }
      });
    });

    // edit connect response event handler
    $('.editConnectResponseBtn').click(function(){
      $('#connectResponseEditModal').modal('show');
      let id = $(this).data('id');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url : '{{ route("ajax-connect-response") }}',
        data : {
          id : id,
        },
        type : 'post',
        success: function(data){
          $('#connectResponseId').val(data.id);
          $('#connectResponseName').val(data.name);
          $('#connectResponseDescription').val(data.description);
          $('form.connectResponse').attr('action', '{{ url('connect-response/update') }}/'+data.id);
        }
      });
    });

    // edit campaign result event handler
    $('.editCampaignResultBtn').click(function(){
      $('#campaignResultEditModal').modal('show');
      let id = $(this).data('id');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url : '{{ route("ajax-campaign-result") }}',
        data : {
          id : id,
        },
        type : 'post',
        success: function(data){
          $('#campaignResultId').val(data.id);
          $('#campaignResultName').val(data.name);
          $('form.campaignResult').attr('action', '{{ url('campaign-result/update') }}/'+data.id);
        }
      });
    });

    // edit next action event handler
    $('.editNextActionBtn').click(function(){
      $('#nextActionEditModal').modal('show');
      let id = $(this).data('id');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url : '{{ route("ajax-next-action") }}',
        data : {
          id : id,
        },
        type : 'post',
        success: function(data){
          $('#nextActionId').val(data.id);
          $('#nextActionName').val(data.name);
          $('form.nextAction').attr('action', '{{ url('next-action/update') }}/'+data.id);
        }
      });
    });

    // edit category web event handler
    $('.editCategoryWebBtn').click(function(){
      $('#categoryWebEditModal').modal('show');
      let id = $(this).data('id');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url : '{{ route("ajax-category-web") }}',
        data : {
          id : id,
        },
        type : 'post',
        success: function(data){
          $('#categoryWebId').val(data.id);
          $('#categoryWebName').val(data.name);
          $('form.categoryWeb').attr('action', '{{ url('category-web/update') }}/'+data.id);
        }
      });
    });

    // edit category game event handler
    $('.editCategoryGameBtn').click(function(){
      $('#categoryGameEditModal').modal('show');
      let id = $(this).data('id');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url : '{{ route("ajax-category-game") }}',
        data : {
          id : id,
        },
        type : 'post',
        success: function(data){
          $('#categoryGameId').val(data.id);
          $('#categoryGameName').val(data.name);
          $('form.categoryGame').attr('action', '{{ url('category-game/update') }}/'+data.id);
        }
      });
    });

  });
</script>