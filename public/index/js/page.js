/**
 * Animacion de las imagenes de la galeria.
 */

$(document).ready(function() {
    $('.item-img .thumbnail,.item-vid .thumbnail').mouseenter(function(e) {
        $(this).children('a').children('img').animate({ height: '220', left: '0', top: '0'}, 1000);
        $(this).children('a').children('span').fadeIn(450);
    }).mouseleave(function(e) {
        $(this).children('a').children('img').animate({ height: '220', left: '-185', top: '-185'}, 1000);
        $(this).children('a').children('span').fadeOut(300);
    });
});