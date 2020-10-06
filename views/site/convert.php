<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
use kartik\typeahead\TypeaheadBasic;

$this->title = 'Конвертики';

$data = file("../web/text/City.txt");
$name = file("../web/text/name.txt");
?>



<div class="jumbotron-fluid text-center">

    <h3>Создать Конвертик</h3>

    <div class="container">

        <div id="first_block">

            <p id="output"></p>

            <div >Конверт №: <p id="num_convert"></p></div>

            <br>

            <?php $form = ActiveForm::begin([
                    'id' => 'form-convert',
                    'class' => 'needs-validation ',
                    'layout' => 'horizontal',
                    'action' => Url::to(['site/convert']),
                    'method'=>'post',
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'template' => "<div class=\"label-small\">{label}</div>\n<div class=\"form-group col-md-6\">{input}</div>\n<div class=\"col-sm-5\">{error}</div>",
                        'errorOptions' => ['class' => 'col-sm-6 alert-danger', 'style'=>'font-size:10px'],
            ],]); ?>

            <div class="row justify-content-center align-items-center h-100">

                <div class="col-lg-7 p-3 col-md-offset-2 ">

                    <?= $form->field($model, 'name_out')->textInput(['autofocus' => true,  'class' => 'form-control form-control-error'])->label(false)
                        ->widget(TypeaheadBasic::classname(), [
                            'data' => $name,
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['autofocus' => true, 'placeholder' => 'Имя отправителя', 'autocomplete'=>"off"],
                        ]);; ?>

                </div>

                    <div class="col-lg-7 p-3 col-lg-offset-6">

                        <?= $form->field($model, 'name_in')->textInput(['autofocus' => true, 'class' => 'form-control form-control-error'])->label(false)
                            ->widget(TypeaheadBasic::classname(), [
                            'data' => $name,
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['autofocus' => true, 'placeholder' => 'Имя получателя', 'autocomplete'=>"off"],
                        ]);
                        ?>

                    </div>

                    <div class="col-lg-7 pb-3 col-md-offset-2">
                        <?= $form->field($model, 'adress_out')->textInput(['autofocus' => true,  'class' => 'form-control form-control-error'])->label(false)
                            ->widget(TypeaheadBasic::classname(), [
                                'data' => $data,
                                'pluginOptions' => ['highlight' => true],
                                'options' => ['placeholder' => 'Откуда (адрес)', 'autocomplete'=>"off"],
                            ]); ?>

                    </div>

                    <div class="col-lg-7 pb-3 col-lg-offset-6">

                        <?= $form->field($model, 'adress_in')->textInput(['autofocus' => true,  'class' => 'form-control form-control-error'])->label(false)
                            ->widget(TypeaheadBasic::classname(), [
                            'data' => $data,
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['placeholder' => 'Куда (адрес)', 'autocomplete'=>"off"],
                        ]); ?>

                    </div>

                    <div class="col-lg-7 pb-3 col-md-offset-2">

                        <?= $form->field($model, 'index_out')->textInput(['autofocus' => true,  'class' => 'form-control form-control-error', 'placeholder'=>'Индекс отправителя', 'autocomplete'=>"off"])->label(false) ?>

                    </div>

                    <div class="col-lg-7 col-lg-offset-6">

                        <?= $form->field($model, 'index_in')->textInput(['autofocus' => true,  'class' => 'form-control form-control-error', 'placeholder'=>'Индекс получателя', 'autocomplete'=>"off"])->label(false) ?>

                    </div>

                        <?= $form->field($model, 'num_convert')->hiddenInput(['value'=>'', 'id'=>'num_convert_1'])->label(false) ?>

            </div>

                        <?= Html::submitButton('Далее', ['class' => 'btn btn-primary btn-lg btn-block', 'id' =>'submit_go_1', 'name' => 'convert-button']) ?>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

    <br>

    <div class="container">

        <div id="second_block" class="inactive_block">

            <?= Html::submitButton('Изменить данные', ['class' => 'btn btn-warning btn-lg btn-block', 'style' => 'display:none', 'id' =>'submit_out_1', 'name' => 'convert-button1']) ?>

            <div class="row justify-content-center align-items-center h-100 ml-0">

                <div class="col-md-6">

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-convert-img',
                        'layout' => 'horizontal',
                        'action' => Url::to(['site/addimg']),
                        'method'=>'post',
                        'enableAjaxValidation' => false,
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-sm-4\">{input}</div>\n<div class=\"col-sm-5\">{error}</div>",
                            'errorOptions' => ['class' => 'col-sm-6 alert-danger', 'style'=>'font-size:13px']
                    ],]); ?>

                        <div class="row wrap">

                            <div class="col-xl-1">

                                <?php echo Carousel::widget(
                                    [ 'options' => ['style'=>'height:400px;width:500px', 'data-interval' => "false"],
                                            'items' => [
                                        ['content' => '<img src="../../web/converts/convert_1.jpg"/>',
                                            'caption' => '<h4>Шаблон письма</h4>',
                                            'options' => ['style'=>'height:400px;width:500px'],
                                        ],
                                        ['content' => '<img src="../../web/converts/convert_2.jpg"/>',
                                            'caption' => '<h4>Шаблон письма</h4>',
                                            'options' => ['style'=>'height:400px;width:500px'],
                                        ],
                                        ['content' => '<img src="../../web/converts/convert_3.jpg"/>',
                                            'caption' => '<h4>Шаблон письма</h4>',
                                            'options' => ['style'=>'height:400px;width:500px'],
                                        ],
                                    ]
                                ]); ?>

                                <?= Html::submitButton('Выбрать шаблон', ['class' => 'btn btn-primary btn-lg btn-block', 'id' =>'submit_go_2', 'name' => 'convert-button_2']) ?>

                            </div>

                        </div>

                    <?php ActiveForm::end(); ?>

                </div>

                <div class="col-md-6">

                    <?php $form = ActiveForm::begin([
                            'id' => 'form-convert-offer',
                            'layout' => 'horizontal',
                            'action' => Url::to(['site/addoffer']),
                            'method'=>'post',
                            'enableAjaxValidation' => false,
                       ]); ?>

                    <p>Предложи конверт автору и втечении 24 часов автор проврит его и добавит:</p>

                    <?= $form->field($model_img, 'imageFile')->fileInput()->label(false) ?>

                    <div id="msg_offer"></div>

                    <?= Html::submitButton('Предложить шаблон', ['class' => 'btn btn-primary', 'id' =>'submit_go_88', 'name' => 'convert-button_88']) ?>

                    <?php ActiveForm::end() ?>
                </div>

            </div>

        </div>

    </div>

    <div class="container">

        <div id="third_block" class="inactive_block">

            <?= Html::submitButton('Изменить шаблон', ['class' => 'btn btn-warning btn-lg btn-block', 'style' => 'display:none', 'id' =>'submit_out_2', 'name' => 'convert-button1']) ?>

            <p id="msg_3"></p>

            <?= Html::submitButton('Добавить письмо', ['data-target'=>'#myModal','data-toggle'=>'modal','class' => 'btn btn-primary btn-lg btn-block', 'id' =>'submit_go_3', 'name' => 'convert-button_3'])?>

            <?php $form = ActiveForm::begin([
                'id' => 'form-convert-letter',
                'layout' => 'horizontal',
                'action' => Url::to(['site/addletter']),
                'method'=>'post',
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'template' => "<div class=\"col-sm-12\">{input}</div><div class=\"col-sm-12\">{error}</div>",
                    'errorOptions' => ['class' => 'col-sm-12 alert-danger', 'style'=>'font-size:13px']
            ],]); ?>
                <!-- Модальное окно -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                    <div class="modal-dialog" role="document">

                        <div class="modal-content">

                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                    <span aria-hidden="true">&times;</span>

                                </button>

                                <h4 class="modal-title" id="myModalLabel">Новое письмо</h4>

                            </div>

                            <div class="modal-body">

                               <p id="text_letter">

                                    <?= $form->field($model_letter, 'letter')->textarea(['id'=>'textletter'])->label(false) ?>

                               </p>

                                    <?= $form->field($model_letter, 'num_convert1')->hiddenInput(['value'=>'', 'id'=>'num'])->label(false) ?>

                            </div>

                            <div class="modal-footer">

                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'id' =>'submit_go_4', 'name' => 'convert-button_4']) ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <div class="container">

        <div id="fourth_block" class="">

            <?= Html::submitButton('Изменить письмо', ['class' => 'btn btn-warning btn-lg btn-block', 'style' => 'display:none', 'id' =>'submit_out_3', 'name' => 'convert-button2']) ?>

            <div class="footer">

                <p id="msg_4"></p>

                <?= Html::submitButton('Сформировать', ['class' => 'btn btn-success', 'style' => 'display:none', 'id' =>'submit_create', 'name' => 'convert-button3', ]) ?>

            </div>

                <p id="msg_5"></p>

                <?= Html::a('Распечатать', [''], ['class' => 'btn btn-success', 'id'=>'printed', 'target'=>"_blank", 'style'=>'display:none']); ?>
                <?= Html::submitButton('Поделиться', ['class' => 'btn btn-warning', 'id' =>'submit_go_6', 'name' => 'convert-button_6', 'style'=>'display:none']) ?>

        </div>

    </div>

</div>
