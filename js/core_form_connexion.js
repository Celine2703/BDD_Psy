// Rayan Anki
// Colombe Blachère
// Céline Martin-Parisot
// L3-APP LSI2
$(document).ready(function()
{
    $('#connexion_btn_header').click(function(e) 
    {
        e.preventDefault();
        let overlay = $('.modal-overlay');
        let modal_connexion = $('#modal_form_connexion');
    
        $('.wrapper').css('background', "none");
    
        
        overlay.toggle();
        modal_connexion.toggle();
    });

    $('#modal_form_connexion').click(function(e) 
    {
        e.stopPropagation();
    });

    $('.wrapper').click(function(e) 
    {
        if (e.target === this)
        {
            $('#modal_form_connexion').hide();
            $('.modal-overlay').hide();
            // overlay.css('visibility', 'hidden');
        }
    });

    $
});
