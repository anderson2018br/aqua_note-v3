$('.genus').mouseenter(function () {
    $('menu').addClass('side-menu-logo');
    $('.genus').addClass('sub-menu-activate');
});
$('.genus').mouseleave(function () {
    $('menu').removeClass('side-menu-logo');
    $('.genus').removeClass('sub-menu-activate');
});
$('.sub-family').mouseenter(function () {
    $('menu').addClass('side-menu-logo');
    $('.sub-family').addClass('sub-menu-activate');
});
$('.sub-family').mouseleave(function () {
    $('menu').removeClass('side-menu-logo');
    $('.sub-family').removeClass('sub-menu-activate');
});

$('#side-menu-genus').mouseenter(function () {
    $('.genus').addClass('sub-menu-activate');
});
$('#side-menu-genus').mouseleave(function () {
    $('.genus').removeClass('sub-menu-activate');
});
$('#side-menu-sub-family').mouseenter(function () {
    $('.sub-family').addClass('sub-menu-activate');
});
$('#side-menu-sub-family').mouseleave(function () {
    $('.sub-family').removeClass('sub-menu-activate');
});
