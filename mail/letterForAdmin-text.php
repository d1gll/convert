<?php
use app\models\User;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
    Добрый день!
    Новый пользователь: <?=$user?>
    Для подтверждения перейдите по ссылки:

<?= $resetLink ?>