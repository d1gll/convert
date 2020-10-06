$(document).ready(function ($) {
    // Проверяем, что вызов производится на странице корзины заказа
    if ($('#js-Field2').length > 0) {
        (function () {
            var $container = $(document.getElementById('msOrder'));
            var $zip = $container.find('[name="index"]'),
                $region = $container.find('[name="region"]'),
                $district = $container.find('[name="district"]'),
                $city = $container.find('[name="city"]'),
                $street = $container.find('[name="street"]'),
                $building = $container.find('[name="building"]');

            $()
                .add($region)
                .add($district)
                .add($city)
                .add($street)
                .add($building)
                .kladr({
                    parentInput: $container.find('.js-form-address'),
                    verify: true,
                    select: function (obj) {
                        setLabel($(this), obj.type);
                        miniShop2.Message.close();
                    },
                    check: function (obj) {
                        var $input = $(this);

                        if (obj) {
                            setLabel($input, obj.type);
                            miniShop2.Message.close();
                        }
                        else {
                            showError('Введено неверно');
                        }
                    },
                    checkBefore: function () {
                        var $input = $(this);

                        if (!$.trim($input.val())) {
                            miniShop2.Message.close();
                            return false;
                        }
                    }
                });

            $region.kladr('type', $.kladr.type.region);
            $district.kladr('type', $.kladr.type.district);
            $city.kladr('type', $.kladr.type.city);
            $street.kladr('type', $.kladr.type.street);
            $building.kladr('type', $.kladr.type.building);

            // Отключаем проверку введённых данных для строений
            $building.kladr('verify', false);

            // Подключаем плагин для почтового индекса
            $zip.kladrZip($container);
            function setLabel($input, text) {
                text = text.charAt(0).toUpperCase() + text.substr(1).toLowerCase();
                $input.parent().find('label').text(text);
            }
            // Переключаем вывод сообщения на minishop
            function showError(message) {
                miniShop2.Message.error(message);
            }
            // Если поле Город заполнено при загрузке, учитываем его значение для зависимых полей
            if ($city.val()) {
                $city.kladr('controller').setValue($city.val());
            }
        })();
    }
});