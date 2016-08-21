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

    $('#btn-description-secret').click(function () {
        $('#description-secret').toggle(400, 'swing', function () {
            if ($(this).css('display') == 'none') {
                $('#btn-description-secret').html('<span class="glyphicon glyphicon-resize-full"></span>&nbsp;zobrazit');
            }
            else {
                $('#btn-description-secret').html('<span class="glyphicon glyphicon-resize-small"></span>&nbsp;skrýt');
            }
        });
    })

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
})