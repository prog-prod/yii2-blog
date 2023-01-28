<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;

class DefaultController extends Controller
{
    public array $menu_items = [];
    public array $footer_items = [];
    public array $social_networks = [];
    public string $blog_name;
    public string $blog_desc;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->menu_items = $this->getMenuItems();
        $this->footer_items = $this->getFooterMenuItems();
        $this->social_networks = $this->getSocialNetworks();
        $this->blog_name = \Yii::$app->params['blog_name'];
        $this->blog_desc = \Yii::$app->params['blog_desc'];
    }

    public function getSocialNetworks(): array
    {
        return [
            [
                'label' => 'Linkedin',
                'url' => [''],
            ],
            [
                'label' => 'Github',
                'url' => [''],
            ],
        ];
    }

    public function getFooterMenuItems() {
        return ArrayHelper::merge($this->menu_items, [
            ['label' => 'Правила та умови', 'url' => ['/terms']],
        ]);
    }

    public function getMenuItems(): array
    {

        $menuItems = [
            ['label' => 'Головна', 'url' => ['/']],
            ['label' => 'Про нас', 'url' => ['/about']],
            ['label' => 'Контакти', 'url' => ['/contact']]
        ];

        if (\Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Реєстрація', 'url' => ['/register']];
            $menuItems[] = ['label' => 'Вхід', 'url' => ['/login']];
        } else {
             if(\Yii::$app->getUser()->identity->hasAdminPanelAccess()) {
                 $menuItems[] =  ['label' => 'Адмін панель', 'url' => ['/admin/index']];
             }


            $menuItems[] = '<li class="nav-item">'
                . Html::beginForm(['/logout'], 'post', ['id' => 'logout']) . Html::endForm()
                . '<a href="javascript:void(0)" class="nav-link" onclick="$(\'#logout\').submit()">Вихід (' . \Yii::$app->user->identity->username . ')</a>'
                . '</li>';
        }

        return $menuItems;

    }


}