<?php

namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;

class AppAdminController extends Controller
{
    public array $menu_items = [];
    public string $blog_name;
    public string $default_article_img;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->menu_items = $this->getMenuItems();
        $this->blog_name = \Yii::$app->params['blog_name'];
        $this->default_article_img = \Yii::$app->params['default_article_img'];

    }

    public function behaviors()
    {
        return [
            'access'=> [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $user = \Yii::$app->user->getIdentity();
                            return $user->hasAdminPanelAccess();
                        }
                    ]
                ]
            ]
        ];
    }

    public function getMenuItems(): array
    {

        $items = [
            ['label' => Html::tag('i', '', ['class'=>'fa-solid fa-home mr-2']).' Dashboard', 'url' => ['/admin/index']],
            ['label' => Html::tag('i', '', ['class'=>'fa-solid fa-book-open mr-2']).' Articles', 'url' => ['/admin/article']],
            ['label' => Html::tag('i', '', ['class'=>'fa-solid fa-tag mr-2']).' Tag', 'url' => ['/admin/tag']],
            ['label' => Html::tag('i', '', ['class'=>'fa-solid fa-list mr-2']).' Categories', 'url' => ['/admin/category']],
            ['label' => Html::tag('i', '', ['class'=>'fa-solid fa-comment mr-2']).' Comments', 'url' => ['/admin/comment']],
        ];

        if(\Yii::$app->getUser()->identity->isAdmin()){
            $items[] = ['label' => Html::tag('i', '', ['class'=>'fa-solid fa-user mr-2']).' Users', 'url' => ['/admin/user']];
        }
        return $items;
    }
}