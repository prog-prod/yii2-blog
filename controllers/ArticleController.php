<?php

namespace app\controllers;

use app\models\Article;
use yii\web\NotFoundHttpException;

class ArticleController extends DefaultController
{

    public function actionView($id): string
    {
        return $this->render('view',[
            'article' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}