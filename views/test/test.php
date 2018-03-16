<?php
/**
 *
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
?>

<h1 class="text-center">Подать заявку</h1>
<p class="text-center">Все поля обязательны для заполнения. Заявка приходит на имейл.</p>
<?php $form = ActiveForm::begin(['class' => 'test-form']); ?>

<?= $form->field($model, 'name', [
    'template' => "{label}\n<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>{input}\n</div>\n{hint}\n{error}"])
    ->textInput()->input('text', array('placeholder' => 'Имя'))
    ->label(false)
?>
<?= $form->field($model, 'email', [
    'template' => "{label}\n<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>{input}\n</div>\n{hint}\n{error}"])
    ->textInput()->input('email', array('placeholder' => 'Email'))
    ->label(false)
?>
<?= $form->field($model, 'age', [
    'template' => "{label}\n<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-hourglass\"></i></span>{input}\n</div>\n{hint}\n{error}"])
    ->textInput()->input('text', array('placeholder' => 'Возраст (полных лет)'))
    ->label(false)
?>
<?= $form->field($model, 'height', [
    'template' => "{label}\n<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-resize-vertical\"></i></span>{input}\n</div>\n{hint}\n{error}"])
    ->textInput()->input('text', array('placeholder' => 'Рост'))
    ->label(false)
?>
<?= $form->field($model, 'weight', [
    'template' => "{label}\n<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-scale\"></i></span>{input}\n</div>\n{hint}\n{error}"])
    ->textInput()->input('text', array('placeholder' => 'Вес'))
    ->label(false)
?>
<?= $form->field($model, 'city', [
    'template' => "{label}\n<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-home\"></i></span>{input}\n</div>\n{hint}\n{error}"])
    ->textInput()->input('text', array('placeholder' => 'Город проживания'))
    ->label(false)
?>
<?= $form->field($model,'technique', [
    'template' => "\n<div class=\"input-group checkboxes\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-print\"></i></span>{label}{input}</div>\n{hint}\n{error}"])
    ->radioList(['no' => 'нет', 'camera' => 'да, только камера', 'yes' => 'да, компьютер и камера'])
    ->label('Нужна ли техника в аренду');
?>
<?= $form->field($model,'english', [
    'template' => "\n<div class=\"input-group checkboxes\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-text-background\"></i></span>{label}{input}</div>\n{hint}\n{error}"])
    ->radioList(['no' => 'без знания', 'basic' => 'базовый', 'intermediate' => 'средний', 'advanced' => 'высокий', 'fluent' => 'превосходный'])
    ->label('Знание английского');
?>
<?= $form->field($model, 'images')->widget(FileInput::classname(), [
    'name'=> 'images[]',
    'options'=>['accept'=>'image/*', 'multiple'=>true, ],
    'pluginOptions'=>[
        'allowedFileExtensions'=>['jpg','gif','png'],
        'overwriteInitial'=>false,
    ]
])->label('Добавить фото (до 5шт.)');
?>
    <div class="form-group text-center">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>