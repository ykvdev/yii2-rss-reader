$(document).ready(function() {
    $('.sign-up-page .captcha-refresh-link').click(function(e) {
        e.preventDefault();
        $(this).parent().children('img').click();
    });
});