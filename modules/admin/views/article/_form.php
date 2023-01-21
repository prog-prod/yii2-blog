<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */

$tagArticle = new \app\models\TagArticle();
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=  $form->field($model, 'category_id')
        ->dropDownList(
            $categories,           // Flat array ('id'=>'label')
            ['prompt'=>'']    // options
        )->label('Category');?>

    <?php

    if(\Yii::$app->getUser()->identity->isAdmin()){
        echo $form->field($model, 'user_id')
            ->dropDownList(
                $users,           // Flat array ('id'=>'label')
                ['prompt'=>'']    // options
            )->label('User');
    }else {
        echo $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->getUser()->id])->label(false);
    }
    ?>

    <?=  $form->field($tagArticle, 'tag_id')
        ->dropDownList(
            $tags,           // Flat array ('id'=>'label')
            ['prompt'=>'', 'multiple' => true]    // options
        )->label('Tags')?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
