<?php

use app\models\Article;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ArticleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value'=> function ($model) {
                        return Html::a($model->title, ['article/view/?id='.$model->id]);
                      },
            ],
            [
                'attribute' => 'category_id',
                'label' => 'Category',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->category->name, ['category/view/?id='.$model->category->id]);
                }
            ],
            [
                'attribute' => 'user_id',
                'label' => 'User',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->user->username, ['category/view/?id='.$model->user->id]);
                }
            ],
            'content',
            'description:ntext',
            'image',
            [
                'attribute' => 'user_id',
                'label' => 'User',
                'format' => 'raw',
                'value' => function ($model) {
                    return "<img width=100 src='/images/post/".$model->getBgImage()."' >";
                }
            ],
            'views',
            'createdAt',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Article $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
