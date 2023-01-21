<?php

namespace app\controllers;

use yii\helpers\Html;
use yii\web\Controller;

class DefaultController extends Controller
{
    public array $menu_items = [];
    public array $social_networks = [];
    public string $blog_name;
    public string $blog_desc;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->menu_items = $this->getMenuItems();
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
    public function getMenuItems(): array
    {

        $menuItems = [
            ['label' => 'Головна', 'url' => ['/site/index']],
            ['label' => 'Про нас', 'url' => ['/site/about']],
            ['label' => 'Контакти', 'url' => ['/site/contact']]
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