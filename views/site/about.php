<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <!-- <img src="images/about_banner.png" alt="альтернативний текст"> -->
    <div style="text-align: center;">
        <img src="images/about_banner.png" style="max-width: 60%;" class="img-fluid" alt="...">
    </div>
    
    <p><b>IT BLOG</b> - одна з лідируючих платформ, що дозволяє ділитись та розповсюджувати найсвіжіші новини з усього світу. Кожен день наша команда робить усе можливе, щоб надати можливість обговорювати та ділитись новинами в сфері ІТ. Саме тут ви можете знайти статті стосовно технологій, які є трендом у всьому світі.</p>
    <p>Тож реєструйся зараз і насолоджуйся!</p>

    <!-- <code><?= __FILE__ ?></code> -->
</div>
