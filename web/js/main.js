$(document).ready(function() {
    $('.captcha-refresh-link').click(function(e) {
        e.preventDefault();
        $(this).parent().children('img').click();
    });
});