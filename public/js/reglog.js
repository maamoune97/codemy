$(function () {
  $('#con_error').fadeOut();
  $('.reg_error').fadeOut();
  var connexionModal = document.getElementById("loginModal");
  var registerModal = document.getElementById("registerModal");
  // Fenetre modal connexion
  (function () {
    $('#login, #loginBeforeCreateCourse').click(function () {
      connexionModal.style.display = "block";
    });

    $('#login_mob').click(function () {
      connexionModal.style.display = "block";
    });
    

    $('.closeLogin').click(function () {
      connexionModal.style.display = "none";
    });

    // Fenetre modal inscription

    $('#register').click(function () {
      registerModal.style.display = "block";
    });

    $('#register_mob').click(function () {
      registerModal.style.display = "block";
    });

    $('.closeRegister').click(function () {
      registerModal.style.display = "none";
    });

    // Lorsque'on clique sur l'écran à l'éxterieur de la fenetre modal

    window.onclick = function (event) {
      if (event.target == connexionModal) {
        connexionModal.style.display = "none";
      }

      if (event.target == registerModal) {
        registerModal.style.display = "none";
      }
    }

  })();


  
  //Connect user by ajax
  function checkLogin() {
    let username = $('#username').val();
    let password = $('#password').val();
    let data = JSON.stringify({username: username, password: password});
    $.ajax({
        url: '/login',
        type: 'POST',
        contentType: "application/json",
        dataType: 'json',
        data: data,
        success: function (data, status) {
            console.log("DATA", data);
            window.location.reload();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          $('#con_error').fadeOut();
          $('#con_error').fadeIn();
          console.log(errorThrown);
          console.log(textStatus);
        }
    });
}

// try connexion if login Form is submitted
(function login() {
  $('#login-submit').click(checkLogin);

})();

// try connexion if enter button of login Form is pressed on password or username input
$('input#password,input#username').keypress(function (e) {
  if (e.which == 13) {
      checkLogin()
  }
});


  // Affiche le message d'erreur sur la div .reg_error de l'input concerné
  function showMsgError(input, msg) {
    input.parent().next('.reg_error').html('<p>' + msg + '</p>').fadeOut();
    input.parent().next('.reg_error').html('<p>' + msg + '</p>').fadeIn();
  }

  function hideMsgError(input) {
    input.parent().next('.reg_error').fadeOut();
    input.parent().next('.reg_error').html('<p> </p>');
  }

  // Verifie si un champs est valide

  function isInputValid(input,name, msg, max = 0, min = 0) {
    if (input.val().length == 0) {
      msg = msg ? msg : 'Veuillez renseigner votre ' + name
      showMsgError(input, msg);
      return false;
    } else {

      if (max > 0) {
        if (input.val().length > max) {
          msg = 'le ' + name + ' ne doit pas dépasser ' + max + ' charactères';
          showMsgError(input, msg);
          return false;
        }
      }

      if (min > 0) {
        if (input.val().length < min) {
          msg = 'le ' + name + ' doit contenir aux moins ' + min + ' charactères';
          showMsgError(input, msg);
          return false;
        }
      }

      input.parent().next('.reg_error').fadeOut();
      input.parent().next('.reg_error').html('<p> </p>');
      return true;
    }
  }

  // Verifie si c'est un mot de passe est valide

  function isInputPassword(input, min = 8, max = 50,) {
    let hasNumber = /[0-9]+/g;

    if (input.val() === input.val().toLowerCase() || input.val() === input.val().toUpperCase() || !hasNumber.test(input.val())){
      msg = 'le mot de passe doit contenir aux moins '+min+' charactères, 1 majuscule, 1 miniscule et 1 chiffre';
      showMsgError(input, msg);
      return false;
    }

    if (input.val().length > max) {
          msg = 'le mot de passe ne doit pas dépasser ' + max + ' charactères';
          showMsgError(input, msg);
          return false;
    }

    hideMsgError(input);
    return true;
  }

  // verifie si des champs sont identique (les mots de passe)
  function isInput2Confirm(input, input2Confirm) {
    
    if (input.val() == '') {
          msg = 'Veuillez confirmer le mot de passe';
          showMsgError(input, msg);
          return false;
    }

    if (input.val() !== input2Confirm.val()) {
          msg = 'les mots de passe ne sont pas identique';
          showMsgError(input, msg);
          return false;
    }

    hideMsgError(input);
    return true;
  }

  function isInputEmail(input) {
    isEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/

    if(input.val() == ''){
        showMsgError(input, 'Veuillez renseigner votre adresse email');
        return false;
    } 
    if(!isEmail.test(input.val())) {
        showMsgError(input, 'Veuillez entrez un adresse email valide');
        return false;
    }

    hideMsgError(input);
    return true;
  }

  // Validation du formulaire d'inscription User Guest (student) 

  (function () {
    $('#registerForm').submit(function () {
      let validation = true;
      validation = isInputValid($('#reg_l_name'), 'nom', null, 25) ? validation : false;
      validation = isInputValid($('#reg_f_name'), 'prénom', null, 25) ? validation : false;
      validation = isInputEmail($('#reg_email')) ? validation : false;
      validation = isInputPassword($('#reg_pwd')) ? validation : false;
      validation = isInput2Confirm($('#reg_pwd2'), $('#reg_pwd')) ? validation : false;

      
      // Inscription si validation ok

      if (validation === true) {


        axios.post('/register',{
          lastName: $('#reg_l_name').val(),
          firstName: $('#reg_f_name').val(),
          email: $('#reg_email').val(),
          password: $('#reg_pwd').val(),
          })
          .then(response => {
            response.data == '1' ? window.location.reload() : console.log(response);
          })
          .catch(errors => console.log('erreur: '+errors))
      }

      return false;
    });

  })();

});