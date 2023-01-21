<?php

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Html;
?>
<header id="header">

    <?= $this->render('_navbar', ['items' => $menuItems])?>
</header>