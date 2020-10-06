$(document).ready(function() {
    $('#form-convert-offer').submit(function () {
        var $img_convert = $(this);

        var data;

        data = new FormData($img_convert[0]);

        $.ajax({
            url: $img_convert.attr("action"),
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            success: function () {
                $("#msg_offer").text('Предложение отправлено');
                $("#msg_offer").toggleClass('alert-success');
            },
            error: function () {
                $("#msg_offer").text('Ошибка');
            }
        });
        return false;
    });
})