

    var startCountdown = {{ strtotime($configCountdown['startCountdown']) }};
    var nowTime = {{ strtotime(date('Y-m-d H:i:s')) }};
    var resultTime = (startCountdown - nowTime) * 1000;

    @if($configCountdown['countdown_status'] == FALSE)

      // setTimeout(function(){
        $.ajax({
          type: "get",
          url: "{{ route('ajax/livedraw') }}",
          dataType: "json",
          success: function (response) {
            var firstSpaceCountdown = randomNumber();
            // Consolation apppear in first section
            setTimeout(function(){
              $('.consolation6').html(
                '<div class="team-title">'+
                  '<div class="team-name">'+response[2][0].number+'</div>'+
                  '<div class="team-country">Consolation</div>'+
                '</div>'
              );
              if(ajaxUpdateLivedraw(response[2][0].id, 'consolation', firstSpaceCountdown) == true){
                // $x=?
                // store -> x + stp = start
                // refresh / si countdown mulai = $Strat
                setTimeout(function(){        
                  $('.consolation5').html(
                    '<div class="team-title">'+
                      '<div class="team-name">'+response[2][1].number+'</div>'+
                      '<div class="team-country">Consolation</div>'+
                    '</div>'
                  );
                  if(ajaxUpdateLivedraw(response[2][1].id, 'consolation') == true){
                    setTimeout(function(){        
                      $('.consolation4').html(
                        '<div class="team-title">'+
                          '<div class="team-name">'+response[2][2].number+'</div>'+
                          '<div class="team-country">Consolation</div>'+
                        '</div>'
                      );
                      if(ajaxUpdateLivedraw(response[2][2].id, 'consolation') == true){
                        setTimeout(function(){        
                          $('.consolation3').html(
                            '<div class="team-title">'+
                              '<div class="team-name">'+response[2][3].number+'</div>'+
                              '<div class="team-country">Consolation</div>'+
                            '</div>'
                          );
                          if(ajaxUpdateLivedraw(response[2][3].id, 'consolation') == true){
                            setTimeout(function(){        
                              $('.consolation2').html(
                                '<div class="team-title">'+
                                  '<div class="team-name">'+response[2][4].number+'</div>'+
                                  '<div class="team-country">Consolation</div>'+
                                '</div>'
                              );
                              if(ajaxUpdateLivedraw(response[2][4].id, 'consolation') == true){
                                setTimeout(function(){        
                                  $('.consolation1').html(
                                    '<div class="team-title">'+
                                      '<div class="team-name">'+response[2][5].number+'</div>'+
                                      '<div class="team-country">Consolation</div>'+
                                    '</div>'
                                  );
                                  if(ajaxUpdateLivedraw(response[2][5].id, 'consolation') == true){
                                    // Starter appear in second section
                                    setTimeout(function(){
                                      $('.starter6').html(
                                        '<div class="team-title">'+
                                          '<div class="team-name">'+response[1][0].number+'</div>'+
                                          '<div class="team-country">Starter</div>'+
                                        '</div>'
                                      );
                                      if(ajaxUpdateLivedraw(response[1][0].id, 'starter') == true){
                                        setTimeout(function(){
                                          $('.starter5').html(
                                            '<div class="team-title">'+
                                              '<div class="team-name">'+response[1][1].number+'</div>'+
                                              '<div class="team-country">Starter</div>'+
                                            '</div>'
                                          );
                                          if(ajaxUpdateLivedraw(response[1][1].id, 'starter') == true){
                                            setTimeout(function(){
                                              $('.starter4').html(
                                                '<div class="team-title">'+
                                                  '<div class="team-name">'+response[1][2].number+'</div>'+
                                                  '<div class="team-country">Starter</div>'+
                                                '</div>'
                                              );
                                              if(ajaxUpdateLivedraw(response[1][2].id, 'starter') == true){
                                                setTimeout(function(){
                                                  $('.starter3').html(
                                                    '<div class="team-title">'+
                                                      '<div class="team-name">'+response[1][3].number+'</div>'+
                                                      '<div class="team-country">Starter</div>'+
                                                    '</div>'
                                                  );
                                                  if(ajaxUpdateLivedraw(response[1][3].id, 'starter') == true){
                                                    setTimeout(function(){
                                                      $('.starter2').html(
                                                        '<div class="team-title">'+
                                                          '<div class="team-name">'+response[1][4].number+'</div>'+
                                                          '<div class="team-country">Starter</div>'+
                                                        '</div>'
                                                      );
                                                      if(ajaxUpdateLivedraw(response[1][4].id, 'starter') == true){
                                                        setTimeout(function(){
                                                          $('.starter1').html(
                                                            '<div class="team-title">'+
                                                              '<div class="team-name">'+response[1][5].number+'</div>'+
                                                              '<div class="team-country">Starter</div>'+
                                                            '</div>'
                                                          );
                                                          if(ajaxUpdateLivedraw(response[1][5].id, 'starter') == true){
                                                            // winner 3 and winner 2 appear in third section
                                                            setTimeout(function(){
                                                              $('.winner3').html(
                                                                '<div class="team-title">'+
                                                                  '<div class="team-name">'+response[0][0].number+'</div>'+
                                                                  '<div class="team-country">3rd Prize</div>'+
                                                                '</div>'
                                                              );
                                                              if(ajaxUpdateLivedraw(response[0][0].id, 'winner') == true){
                                                                setTimeout(function(){
                                                                  $('.winner2').html(
                                                                    '<div class="team-title">'+
                                                                      '<div class="team-name">'+response[0][1].number+'</div>'+
                                                                      '<div class="team-country">2nd Prize</div>'+
                                                                    '</div>'
                                                                  );
                                                                  if(ajaxUpdateLivedraw(response[0][1].id, 'winner') == true){
                                                                    // winner 1 appear in last section
                                                                    setTimeout(function(){
                                                                      $('.winner1').html(
                                                                        '<div class="team-title">'+
                                                                          '<div class="team-name">'+response[0][2].number+'</div>'+
                                                                          '<div class="team-country">1st Prize</div>'+
                                                                        '</div>'
                                                                      );
                                                                      ajaxUpdateLivedraw(response[0][2].id, 'winner')
                                                                    }, randomNumber());
                                                                  }
                                                                }, randomNumber());
                                                              }
                                                            }, randomNumber());
                                                          }
                                                        }, randomNumber());
                                                      }
                                                    }, randomNumber());
                                                  }
                                                }, randomNumber());
                                              }
                                            }, randomNumber());
                                          }
                                        }, randomNumber());
                                      }
                                    }, randomNumber());
                                  }
                                }, randomNumber());
                              }
                            }, randomNumber());
                          }
                        }, randomNumber());
                      }
                    }, randomNumber());
                  }
                }, randomNumber());
              }
            }, firstSpaceCountdown);
          }
        });
      // }, resultTime);

    @endif

    function randomNumber() {
      let randNumber = Math.floor((Math.random() * 500000) + 100000);
      return randNumber;
    }

    function ajaxUpdateLivedraw(id, prize, firstSpaceCountdown = 0) {
      var response;
      $.ajax({
        type: "post",
        url: "{{ route('ajax.livedraw.updateshow') }}",
        async: false,
        dataType: "json",
        data: {
          id : id,
          prize : prize,
          firstSpaceCountdown : firstSpaceCountdown,
        },
        success: function (json) {
          response = json;
        }
      });
      return response;
    }