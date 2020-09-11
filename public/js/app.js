/** Ouverture profil **/
$(document).ready(function(){

  $( "#BtnAvatar" ).click(function() {
  $(".dropdown-content").toggle("fast");
});

$( "#BtnAv, .avatarName" ).click(function() {
  $(".dropdown-content").toggle("fast");
});


/** Navbar responsive et menu offcanas **/

$( "#btnStat" ).click(function() {
  $( ".resp-searchdiv" ).toggle( "fast" );
});


$( "#btnUser" ).click(function() {
  $( ".logreg__div" ).toggle( "fast" );
});

// ouvrir le menu offcanvas

$( "#btnOffcanvas" ).click(function() {
  $( "#menu__offcanvas" ).toggle( "fast" );
  $("#overlay").css('visibility', 'visible');
});

$( "#overlay" ).click(function( event ) {
  event.preventDefault();
  if ($("#menu__offcanvas").css("display","block")) {
    $("#menu__offcanvas").hide();
    $("#overlay").css("visibility","hidden");
  }
});

/** Changement de placeholder dans la barre de recherche
du banner page d'acceuil index.html **/

(function () {
  var placeHolder = ['Cherchez un cours','Mathématique','Ingenierie','Science Physique','Droit'];
  var n=0;
  var loopLength=placeHolder.length;

  setInterval(function(){
     if(n<loopLength){
        var newPlaceholder = placeHolder[n];
        n++;
        $('#search-bar').attr('placeholder',newPlaceholder);
     } else {
        $('#search-bar').attr('placeholder',placeHolder[0]);
        n=0;
     }
  },2000);
})();


(function () {
  $(".toggle-password").click(function() {
  
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
})();


// Ajax de la page chapter pour récuperer le chapitre
(function () {
$('.chapter').on('click', function(e){
  e.preventDefault();
  const $a = $(this);
  let $id = $a.attr('id');

  $id = $id.split("-")[1];

      $.ajax({
        dataType : "json",
        beforeSend: function() {
          
          $( ".loader" ).addClass('loading');
        },
        url: "/assets/js/ajax/chapterFind.php",
        type: 'POST',
        data: {
          'idChap': $id,
        },
        success: function (data, statut, jxqr) {
          // console.log(jxqr.readyState);
          if (data == 'null') {
            
          } else {
            $('#current-course').hide();
            $('#chapter-title').text(data.title);
            $('#chapter-content').html(data.content);
            $( ".loader" ).removeClass('loading');
            $('#current-course').fadeIn(1000);
            history.replaceState(null, "ma page", data.url);
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(errorThrown);
        }
      });

  });
})();

});