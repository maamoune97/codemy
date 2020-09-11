$(document).ready(function () {
    var tChapitre = $(".ccChapitre-title").text();
    var input = $('.titreChapitre');
    var tPart = $(".ccPart-title-text").text();
    var inputPart = $("#titrePart");
    var maxField = 10; //Input fields increment limitation
    var addButton = $('#btnAdd'); //Add button selector
    var wrapper = $('#addInput'); //Input field wrapper
 //var divButton = $('.btnAddContent'); // Div qui contient le bouton add
    var list = $('#addList'); // list des prerequis
    var x = 0; //Initial field counter is 0
     //New input field html 
    var fieldHTML = '<div class="mt-3"><input class="creatCourse-input form-control prerequis" id="prerequis" placeholder="Ajoutez un prerequis" type="text">'+
                    '<div class="valide-and-annuled-btn text-center">'+
                    '<button class="valide-btn btn btn-primary mr-2 addValide">Ajouter</button>'+
                    '<button class="annuled-btn btn btn-outline-secondary ml-2 addRemove">Annuler</button></div></div>';
    // Input fiel pour la réedition d'un prerequis
    
    //Chaque fois que le bouton est cliqué
    $(addButton).click(function(e){
        //Check maximum number of input fields
        e.preventDefault();
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html

        }
    });

    // annuler l'ajout d'un prerequis
    $(wrapper).on('click', '.addRemove', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    // ajout d'un prerequis à la liste ol
    $(wrapper).on('click', '.addValide', function(e){
        var saisie = $('#prerequis').val();
        //alert(saisie);
        e.preventDefault();
        $(list).append('<div id="hidden"><li class="list-item-prerequi">'+
                        '<span class="essai">'+saisie+'</span>'+
                        '<span class="icon-item-edit editBtn"><i class="fas fa-pencil-alt"></i></span>'+
                        '</li></div>');
        $(this).parent('div').parent('div').remove();
    });

    // formaulaire edit prerequis
    $(list).on('click', '.editBtn', function(e){
        //alert('okkkk');
        var valeur = $('.essai').text();
        var editHtml = '<div class="mt-3"><input class="creatCourse-input form-control" id="editInput" value="'+valeur+'" type="text">'+
                    '<div class="valide-and-annuled-btn text-center">'+
                    '<button class="valide-btn btn btn-primary mr-2 editValide">Enregister les modifications</button>'+
                    '<button class="annuled-btn btn btn-outline-secondary ml-2 addRemove">Annuler</button></div></div>';
        $('#hidden').replaceWith(editHtml);
    });

    // valider un prerequis modifier
    $(list).on('click', '.editValide', function(e) {
            var editSaisie = $('#editInput').val();
            //e.preventDefault();
            $(list).append('<div class="hidden"><li class="list-item-prerequi">'+
                            '<span class=essai>'+editSaisie+'</span>'+
                            '<span class="icon-item-edit editBtn"><i class="fas fa-pencil-alt"></i></span>'+
                            '</li></div>');
            $(this).parent('div').parent('div').remove();
    });

    // Modifier le titre d'un chapitre
    $('body').on('click', '.ccEdit-chapitre', function(e){
        e.preventDefault();
        //alert(tChapitre);
        //var valeur = $('.titreChapitre').val();
        $(this).parent('div').next('div').next('form').children('div.ccEditChapitre').css('display', 'block');
        $(this).parent('div.ccChapitre-content').css('display', 'none')
        input.val(tChapitre);
    });

    $('body').on('click', '.valideTitreChapitre', function(e){
        e.preventDefault()
        var valeurSaisie = $(this).parent('div').prev('input').val();
        $(this).parent('div').parent('div.ccEditChapitre').css('display', 'none');
        $(this).parent('div').parent('div').parent('form').prev('div').prev('div.ccChapitre-content').css('display', 'block')
        // if (valeurSaisie != tChapitre) {
            // tChapitre = valeurSaisie;
            $(this).parent('div').parent('div').parent('form').prev('div').prev('div.ccChapitre-content').children('span.ccChapitre-text').children('span.ccChapitre-title').text(valeurSaisie);
        // }
    });

    $('.annuleEditTitre').click(function (e) {
        e.preventDefault()
        $('.ccEditChapitre').css('display', 'none');
        $('.ccChapitre-content').css('display', 'block')
        input.val(tChapitre);
    });

    //Supression de Chapitre
    
    $('body').on('click', '.ccDelete-chapitre', function(e){
        e.preventDefault();
        $(this).parent().parent('li').remove();
    });

    // Ajout de video

    $('.addVideo').click(function (e) {
        e.preventDefault();
        $('.ccChapitre-video-div-one').css('display', 'block');
        $('.ccCollapse-btn').css('display', 'none');
    });

    $('.closeInputVideo').click(function () {
        $('.ccChapitre-video-div-one').css('display', 'none');
        $('.ccCollapse-btn').css('display', 'block');
    });

// Ecrire un contenu

    $('.writeText').click(function (e) {
        e.preventDefault();
        $('.ccChapitre-write-form').css('display', 'block');
        $('.ccCollapse-btn').css('display', 'none');
    });

    $('.closeInputVideo').click(function () {
        $('.ccChapitre-write-form').css('display', 'none');
        $('.ccCollapse-btn').css('display', 'block');
    });

    // Editer une partie

    $('.ccEdit-part').click(function () {
        //alert(tChapitre);
        //var valeur = $('.titreChapitre').val();
        $('#ccEditPart').css('display', 'block');
        $('.ccTitle-part-content').css('display', 'none');
        inputPart.val(tPart);
    });

    $('#valideTitrePart').click(function (e) {
        var inputSaisie = $('#titrePart').val();
        e.preventDefault()
        $('#ccEditPart').css('display', 'none');
        $('.ccTitle-part-content').css('display', 'flex')
        if (inputSaisie != tPart) {
            tPart = inputSaisie;
            $(".ccPart-title-text").text(tPart);
        }
    });

    $('#annuleEditPart').click(function (e) {
        e.preventDefault()
        $('#ccEditPart').css('display', 'none');
        $('.ccTitle-part-content').css('display', 'flex')
        inputPart.val(tPart);
    });

    /// Editer video

    $('.ccEdit-video-uploaded').click(function () {
        //alert(tChapitre);
        //var valeur = $('.titreChapitre').val();
        $('.ccEditVideo').css('display', 'block');
        $('.ccChapitre-video-uploaded-content').css('display', 'none');
        ///inputPart.val(tPart);
    });

    $('#valideTitrePart').click(function (e) {
        var inputSaisie = $('#titrePart').val();
        e.preventDefault()
        $('#ccEditPart').css('display', 'none');
        $('.ccTitle-part-content').css('display', 'flex')
        if (inputSaisie != tPart) {
            tPart = inputSaisie;
            $(".ccPart-title-text").text(tPart);
        }
    });

    $('#annuleEditPart').click(function (e) {
        e.preventDefault()
        $('#ccEditPart').css('display', 'none');
        $('.ccTitle-part-content').css('display', 'flex')
        inputPart.val(tPart);
    });


    //Ajouter Chapitre

    $('#addChapitre').click(function(e) {
        e.preventDefault();
        chapterList = $('.ccChapitre-list');
        $.ajax({
            url: '/assets/js/ajax/addChapter.html',
            type: 'GET',
            success: function (chapter) {
              chapterList.append(chapter);  
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
          });
    })

});