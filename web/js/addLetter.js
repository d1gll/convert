
$(document).ready(function() {

    $('#form-convert-letter').on('beforeSubmit', function() {

        var $letterform = $(this);
        $.ajax({
            // Метод отправки данных     (тип запроса)
            type: 'post',
            url: $letterform.attr("action"),
            // Данные формы
            data : $letterform.serializeArray(),
            success: function (add) {
                if (add) {
                    $('#myModal').modal('hide');
                    $("#msg_3").text('Письмо сохранено!');
                    $('#submit_go_3').html('Изменить письмо');
                    $("#msg_3").toggleClass('alert-success');
                    $("#third_block").addClass('inactive_block');
                    $("#fourth_block").removeClass('inactive_block');
                    $('#submit_go_3').css('display','none');
                    $('#submit_out_3').css('display','');
                    $('#submit_create').css('display','');
                } else {
                    // Если при обработке данных на сервере произошла ошибка
                    $("#msg_3").text('Ошибка!');
                    $("#msg_3").toggleClass('alert-danger');

                }

            }
        })
        return false;

    });
    $('#submit_out_3').click(function () {
        $("#msg_3").text('');
        $("#third_block").removeClass('inactive_block');
        $("#fourth_block").addClass('inactive_block');
        $('#submit_go_3').css('display','');
        $('#submit_out_3').css('display','none');
        $('#printed').css('display','none');
        $('#submit_go_6').css('display','none');
        $("#msg_4").text('');
        $("#msg_5").text('');
    });


})