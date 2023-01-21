<?php

use app\models\Comment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CommentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'label' => 'User',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->user->username, ['user/view/?id='.$model->id]);
                }
            ],
            [
                'attribute' => 'article_id',
                'label' => 'Article',
                'format' => 'raw',
                'value'=> function ($model) {
                    return Html::a($model->article->title, ['article/view/?id='.$model->id]);
                },
            ],
            [
                'attribute' => 'comment_id',
                'label' => 'Comment',
                'format' => 'raw',
                'value'=> function ($model) {
                    return $model->comment ? Html::a($model->comment->id, ['comment/view/?id='.$model->id]) : null;
                },
            ],
            'text:ntext',
            //'datetime',
            //'delete',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Comment $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
