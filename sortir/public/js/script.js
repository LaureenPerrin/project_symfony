
$(function(){

    //Utilisation de la librairie tootip.js (utilise popper.js)
    $('[data-toggle="tooltip"]').tooltip();


    /**
     * Click lien suppression
     */
    $('.delete-item').on('click',
        function(e){
            //arrête progagation de l'evenement
            e.preventDefault();

            //Récupération du lien générer dans le bouton
            let link = $(this).data('link');
            var title = $(this).attr('title');
            var tooltipTitle = $(this).data('original-title');
            var idea = $(this).parent().find('span:eq( 0 )');

            //Modification du contenu de la fenêtre modale
            if(idea.length > 0){
                $('.modal-body p').empty().html("Delete : "+ idea.html());
            }

            //A cause de la librairie tooltip.js
            if(title == '' && tooltipTitle != ''){
                title = tooltipTitle;
            }

            //Modification du titre de la fenêtre modale
            $('#deleteModalLabel').empty().html(title);

            //Insertion d'un data-link dans la div d'id deleteModal
            $('#deleteModal').data('link', link).modal();

        }
    );


    /**
     * Click bouton delete
     */
    $('#delete-modal-btn').on('click', function(){

        //récupération du lien
        var link = $('#deleteModal').data('link');

        if(link == ''){
            //TODO : prevoir une erreur
           console.log('Aucun lien assigné');
        }
        else{
            console.log(link);

            //provoque la redirection vers le lien dans link
            document.location.href = link;

            //Cache la fenêtre modal
            $('#deleteModal').modal('hide');

        }

    });


    //Filtre par catégorie d'idée
    $('#filtre_categorie').on('change', function () {

        var cat = $(this).val();
        document.location.href = $(this).data('route') + "" + cat;
    });

});