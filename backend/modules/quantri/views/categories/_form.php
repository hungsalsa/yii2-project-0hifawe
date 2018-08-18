<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\quantri\models\Group;
use backend\modules\quantri\models\Categories;
/* @var $this yii\web\View */
/* @var $model backend\modules\quantri\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cateName')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'groupId')->dropDownlist($dataGroups,['prompt'=>'-Chọn danh mục']) ?>
<?php 
// Normal select with ActiveForm & model
echo $form->field($model, 'groupId')->widget(Select2::classname(), [
    'data' => $dataGroups,
    'language' => 'en',
    'options' => ['placeholder' => 'Select a Groups ...',
    'onchange'=>'
        $.post("'.Yii::$app->homeUrl.'quantri/categories/lists?id='.'"+$(this).val(),function(data){
            $("select#categories-parent_id").html( data );
        });'
],
    'pluginOptions' => [
        'allowClear' => true
    ],
    
]);
     ?>
    

         <?php 
// Normal select with ActiveForm & model
echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
    'data' => Categories::dropdown(),
    'language' => 'en',
    'options' => ['placeholder' => 'Select a Groups ...',
    // 'onchange'=>'
    //     $.post("'.Yii::$app->homeUrl.'quantri/categories/lists?id='.'"+$(this).val(),function(){
    //         $("select#categories-parent_id").html( data );
    //     });'
],
    'pluginOptions' => [
        'allowClear' => true
    ],
    
]);
     ?>

    <?php // $form->field($model, 'parent_id')->dropDownlist($datacat,['prompt'=>'-Chọn danh mục']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'images')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descriptions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
