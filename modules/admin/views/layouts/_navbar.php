<?php

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;use yii\helpers\Html;
?>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="https://getbootstrap.com/docs/4.6/examples/dashboard/#"><span class="text-primary">Admin Panel</span> | <?= $this->context->blog_name?></a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <?= Html::beginForm(['/logout'], 'post', ['id' => 'logout']) . Html::endForm()?>
            <a href="javascript:void(0)" onclick="$('#logout').submit()" class="nav-link">Вихід (<?= \Yii::$app->user->identity->username?> )</a>
        </li>
    </ul>
</nav>
