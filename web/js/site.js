$(document).ready(function() {

    $('#form-convert').on('beforeSubmit', function() {
        // Получаем объект формы
        var $testform = $(this);
        // отправляем данные на сервер
        $.ajax({
            // Метод отправки данных (тип запроса)
            type : 'post',
            // URL для отправки запроса
            url: $testform.attr("action"),
            // Данные формы
            data : $testform.serializeArray()
        }).done(function(data) {

            if (data.error == null) {
                $("#output").text("");
                // Если ответ сервера успешно получен
                $("#first_block").addClass('inactive_block');
                $("#second_block").removeClass('inactive_block');
                $('#submit_go_1').css('display','none');
                $('#submit_out_1').css('display','block');
                window.scrollTo( 0, 500 );
            } else {
                // Если при обработке данных на сервере произошла ошибка
                $("#output").text(data.error)
            }

        }).fail(function() {
            // Если произошла ошибка при отправке запроса
            $("#output").text("Ошибка!");
        })
        // Запрещаем прямую отправку данных из формы
        return false;
    })

    $('#submit_out_1').click(function (e) {
        $("#first_block").removeClass('inactive_block');
        $("#second_block").addClass('inactive_block');
        $('#submit_go_1').css('display','block');
        $('#submit_out_1').css('display','none');
        window.scrollTo( 0, 0 );
    });
})


