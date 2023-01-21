<?php

/** @var yii\web\View $this */

$this->title = 'IT Blog Головна сорінка';
?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8  mb-5 mb-lg-0">
                <?php foreach($articles as $article):?>
                    <?= $this->render('components/_article', compact('article'))?>
                <?php endforeach;?>

                <?php if(empty($articles)):?>
                <h4>Статті не знайдено. 	&#129402</h4>
                <?php endif?>
            </div>
            <aside class="col-lg-4">
                <?= $this->render('components/_sidebar', compact('categories','tags','latest_articles'))?>
            </aside>
        </div>
    </div>
</section>
