<?php

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
?>
<!-- navigation -->
<header class="sticky-top bg-white border-bottom border-default">
    <div class="container">
        <?php NavBar::begin([
            'brandLabel' => '<img class="img-fluid" width="150px" src="' . Yii::getAlias("@web/images/logo.png") . '" alt="LogBook">',
            'brandUrl' => Yii::$app->homeUrl,
            'brandOptions' => [],
            'options' => ['class' => 'navbar navbar-expand-lg navbar-white']
        ]); ?>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
            <i class="ti-menu"></i>
        </button>
        <div class="collapse navbar-collapse text-center" id="navigation">
            <?= Nav::widget([
                'options' => ['class' => 'navbar-nav ml-auto'],
                'items' => $items
            ]); ?>
        </div>
        <!-- search -->
        <div class="search px-4">
            <button id="searchOpen" class="search-btn"><i class="ti-search"></i></button>
            <div class="search-wrapper">
                <form action="" method="get" class="h-100">
                    <input class="search-box pl-4" id="search-query" name="s" type="search"
                           placeholder="Напиши що шукаєш...">
                </form>
                <button id="searchClose" class="search-close"><i class="ti-close text-dark"></i></button>
            </div>
        </div>
        <? NavBar::end(); ?>
    </div>
</header>
<!-- /navigation -->
