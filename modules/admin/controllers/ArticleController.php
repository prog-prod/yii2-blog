<?php

namespace app\modules\admin\controllers;

use app\controllers\DefaultController;
use app\models\Article;
use app\models\ArticleSearch;
use app\models\Category;
use app\models\Tag;
use app\models\TagArticle;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends AppAdminController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all Article models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch;

        if(\Yii::$app->getUser()->identity->isAuthor()){
            $dataProvider = $searchModel->search($this->request->queryParams, \Yii::$app->getUser()->id);
        } else {
            $dataProvider = $searchModel->search($this->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Article();
        $data = $this->request->post();

        if ($this->request->isPost) {

            if ($model->load($data) && $model->save()) {
                $this->linkTagsToArticles($model,$data[TagArticle::class]['tag_id']);

                return $this->redirect(['view', 'id' => $model->id]);
            }else {
                \Yii::$app->session->setFlash('error', join(' ',$model->getErrorSummary(1)));
            }
        } else {
            $model->loadDefaultValues();
        }

        $users = $this->getUsersExceptMe();
        $categories = $this->getCategories();
        $tags = $this->getTags();

        return $this->render('create', [
            'model' => $model,
            'users' => $users,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    private function linkTagsToArticles($article, array $tags = []) {
        foreach ($tags as $tag){
            $tagArticle = new TagArticle();
            $tagArticle->article_id = $article->primaryKey();
            $tagArticle->tag_id = $tag;
            $tagArticle->save();
        }
    }
    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $users = $this->getUsersExceptMe();
        $categories = $this->getCategories();
        $tags = $this->getTags();

        return $this->render('create', [
            'model' => $model,
            'users' => $users,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    private function getUsersExceptMe(){
        return ArrayHelper::map(User::find()->where(['!=', 'id', \Yii::$app->user->identity->getId()])->all(), 'id', 'username');
    }

    private function getCategories() {
        return ArrayHelper::map(Category::find()->all(), 'id', 'name');
    }

    private function getTags() {
        return ArrayHelper::map(Tag::find()->all(), 'id', 'name');
    }
    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
