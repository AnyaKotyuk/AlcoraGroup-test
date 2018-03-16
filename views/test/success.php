<?php
use yii\helpers\Html;
?>
<h1>Форма успешно отправлена. Ожидайте письмо на ваш email.</h1>
<h3>Ваши данные:</h3>
<p><b>Имя: </b><?= Html::encode($user_data->name); ?></p>
<p><b>E-mail: </b><?= Html::encode($user_data->email); ?></p>
<p><b>Возвраст: </b><?= Html::encode($user_data->age); ?></p>
<p><b>Рост: </b><?= Html::encode($user_data->height); ?></p>
<p><b>Вес: </b><?= Html::encode($user_data->weight); ?></p>
<p><b>Город проживания: </b><?= Html::encode($user_data->city); ?></p>
<p><b>Нужна ли техника в аренду: </b><?= Html::encode($user_data->technique); ?></p>
<p><b>Знание английского: </b><?= Html::encode($user_data->english); ?></p>



