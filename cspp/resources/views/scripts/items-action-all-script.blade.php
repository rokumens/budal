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

  });
</script>
