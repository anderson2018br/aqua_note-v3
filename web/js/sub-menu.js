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
$('.notes').mouseenter(function () {
    $('menu').addClass('side-menu-logo');
    $('.notes').addClass('sub-menu-activate');
});
$('.notes').mouseleave(function () {
    $('menu').removeClass('side-menu-logo');
    $('.notes').removeClass('sub-menu-activate');
});
$('.user').mouseenter(function () {
    $('menu').addClass('side-menu-logo');
    $('.user').addClass('sub-menu-activate');
});
$('.user').mouseleave(function () {
    $('menu').removeClass('side-menu-logo');
    $('.user').removeClass('sub-menu-activate');
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
$('#side-menu-notes').mouseenter(function () {
    $('.notes').addClass('sub-menu-activate');
});
$('#side-menu-notes').mouseleave(function () {
    $('.notes').removeClass('sub-menu-activate');
});
$('#side-menu-user').mouseenter(function () {
    $('.user').addClass('sub-menu-activate');
});
$('#side-menu-user').mouseleave(function () {
    $('.user').removeClass('sub-menu-activate');
});
