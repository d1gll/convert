$(document).ready(function() {
    $('#form-convert-img').on('beforeSubmit', function() {
        var img = $('.active').find('img');
        var src = img.attr('src');
        var num_convert = $('#num_convert').text();
        var $img_convert = $(this);
            $.ajax({
                // Метод отправки данных     (тип запроса)
                type: 'post',
                // URL для отправки запроса
                url: $img_convert.attr("action"),
                // Данные формы
                data : {num_convert:num_convert,path_img:src},
                success: function (add_img) {
                    if (add_img) {
                        $("#second_block").addClass('inactive_block');
                        $("#third_block").removeClass('inactive_block');
                        $('#submit_go_2').css('display','none');
                        $('#submit_out_2').css('display','block');
                        window.scrollTo( 0, 1000 );
                    } else {

                    }
                }
            })
        return false;
        });



    $('#submit_out_2').click(function (e) {
        $("#second_block").removeClass('inactive_block');
        $("#third_block").addClass('inactive_block');
        $('#submit_go_2').css('display','block');
        $('#submit_out_2').css('display','none');
        window.scrollTo( 0, 500 );
    });
})