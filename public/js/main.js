function location_confirm(txt, url) {
    ret = confirm(txt);
    if (ret) {
        window.location.href = url;
    }
}

$(document).ready(function () {
    $('#description-secret-button').click(function () {
        $('#description-secret').slideDown();
        $(this).parent().parent().slideUp();
    })
})