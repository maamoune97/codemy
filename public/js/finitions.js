$(function () {
    
    //GESTION DU BOUTTON SCROLL TOP
     (function () {
        $('#scrollTop').hide();
      
        $('#scrollTop').click(function() {
          $('html ,body').animate({scrollTop : 0}, 800);
        });
      
        $(window).scroll(function () {
          if (scrollY > 60) {
            $('#scrollTop').fadeIn();
          } else {
            $('#scrollTop').fadeOut();
          }
        });
      })();


 });

