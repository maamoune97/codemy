$(function () {

    //Indexation numérique des chapitres et retourne un tableau de chapitres (li)
    function indexingChapters() {
        li = $('ul.ccChapitre-list li');
        pos = 1
        tabLi = Array();
        li.each(function() {
            $(this).children('div').children('span').find('span.ccChapitre-index').text(pos);
            tabLi.push(li);
            pos++;
        });
        return tabLi;
    }


    //Ajouter un Chapitre
    $('#addChapitre').click(function (e) {
        e.preventDefault();
        chaptersList = $('.ccChapitre-list');
        let nextIndex = indexingChapters().length + 1
        $.ajax({
            url: '/assets/js/ajax/addChapter.php',
            type: 'POST',
            data: {
                'index': nextIndex,
            },
            success: function (chapter) {
                chaptersList.append(chapter);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    })


    //Supprimer un Chapitre
    $('body').on('click', '.ccDelete-chapitre', function (e) {
        e.preventDefault();
        if (confirm('Voulez vous supprimer ce chapitre?')) {
            $(this).parent().parent('li').remove();
            indexingChapters();
        }
    });


    // Modifier le titre d'un chapitre
    $('body').on('click', '.ccEdit-chapitre', function (e) {
        e.preventDefault();
        const chapterEdit = $(this).parent('div').next('div').next('form').children('div.ccEditChapitre');
        const chapterContent = $(this).parent('div.ccChapitre-content');

        chapterEdit.css('display', 'block');
        chapterContent.css('display', 'none');

        //remplisage auto du input du modification par la valeur courante
        chapterEdit.children('input.titreChapitre').val(chapterContent.children('span').children('span.ccChapitre-title').text());
    });

    //Valider l'edition du titre du chapitre
    $('body').on('click', '.valideTitreChapitre', function (e) {
        e.preventDefault()
        var valeurSaisie = $(this).parent('div').prev('input').val();
        $(this).parent('div').parent('div.ccEditChapitre').css('display', 'none');
        $(this).parent('div').parent('div').parent('form').prev('div').prev('div.ccChapitre-content').css('display', 'block')
        // if (valeurSaisie != tChapitre) {
        // tChapitre = valeurSaisie;
        $(this).parent('div').parent('div').parent('form').prev('div').prev('div.ccChapitre-content').children('span.ccChapitre-text').children('span.ccChapitre-title').text(valeurSaisie);
        // }
    });


    //Annuler l'edition du titre du chapitre
    $('body').on('click', '.annuleEditTitre', function (e) {
        e.preventDefault()
        $(this).parent('div').parent('div.ccEditChapitre').css('display', 'none');
        $(this).parent('div').parent('div').parent('form').prev('div').prev('div.ccChapitre-content').css('display', 'block')
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





});