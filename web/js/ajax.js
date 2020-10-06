
$(document).ready(function()
{
    $.ajax({
        // Метод отправки данных     (тип запроса)
        type: 'post',
        // URL для отправки запроса
        url: 'http://localhost/web/index.php?r=site%2Fcount',
        success: function (count) {
            if (count.error == null) {
                $("#num_convert").text(count);
                $("#num_convert_1").val(count);
                $("#num").val(count);
                $('#printed').attr("href", "http://localhost/web/index.php?r=site%2Fkohbept&convert="+count);
            } else {
                // Если при обработке данных на сервере произошла ошибка
                $("#num_convert").text('Ошибка')
            }
        }
    })

    $('#submit_go_6').click(function () {
        $.ajax({
            // Метод отправки данных     (тип запроса)
            type: 'post',
            url: 'http://localhost/web/index.php?r=site%2Fcreatelink',
            dataType: 'json',
            // Данные формы
            data: {convert: $("#num_convert_1").val()},
            success: function (link) {
                if (link) {
                    $("#msg_5").text(link);
                    var element = "#msg_5";
                    var $temp = $("<input>");
                    $("body").append($temp);
                    $temp.val($(element).text()).select();
                    document.execCommand("copy");
                    $temp.remove();
                    $("#msg_5").text('Ссылка скопирована');
                    setTimeout('$("#msg_5").text("")',1000);
                    $("#msg_5").toggleClass('alert-success');
                } else {
                    $("#msg_5").text('Ошибка!');
                    $("#msg_5").toggleClass('alert-danger');

                }

            }
        })
    })

    $('#submit_create').click(function () {
        $("#msg_4").text('Письмо сформировано!');

        $('#printed').css('display','');
        $('#submit_go_6').css('display','');
        $('#submit_create').css('display','none');
    })

})