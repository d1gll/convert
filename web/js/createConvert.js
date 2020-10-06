
$('#submit_create').click(function () {
    $.ajax({
        // Метод отправки данных     (тип запроса)
        type: 'post',
        url: 'http://localhost/web/index.php?r=site%2Fcreateconvert',
        dataType: 'json',
        // Данные формы
        data: {convert: $("#num_convert_1").val()},
        success: function (add) {
            if (add) {
                $("#msg_5").toggleClass('alert-success');
            } else {
                // Если при обработке данных на сервере произошла ошибка
                $("#msg_5").text('Ошибка!');
                $("#msg_5").toggleClass('alert-danger');

            }

        }
    })
})