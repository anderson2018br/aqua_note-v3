$('.sub-menu').mouseenter(function () {
    $('menu').addClass('side-menu-logo');
    $('.sub-menu').addClass('sub-menu-activate');
});
$('.sub-menu').mouseleave(function () {
    $('menu').removeClass('side-menu-logo');
    $('.sub-menu').removeClass('sub-menu-activate');
});

$('#side-menu-genus').mouseenter(function () {
    $('.sub-menu').addClass('sub-menu-activate');
});
$('#side-menu-genus').mouseleave(function () {
    $('.sub-menu').removeClass('sub-menu-activate');
});
