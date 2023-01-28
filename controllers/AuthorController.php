<?php

namespace app\controllers;

use app\models\User;
use yii\web\NotFoundHttpException;

class AuthorController extends DefaultController
{
    /**
     * Displays author page.
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $author = User::find()->andFilterWhere(['id' => $id])->andFilterWhere(['role' => User::ROLE_AUTHOR])->one();
        $articles = [];

        if(!$author){
            throw new \yii\web\NotFoundHttpException();
        }

        if (!empty($author->articles)) {
            $articles = $author->articles;
        }

        return $this->render('view',compact('author','articles'));
    }
}