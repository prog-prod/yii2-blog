<?php

use yii\helpers\Html;
use yii\helpers\Url;

$formatter = \Yii::$app->formatter;

?>
<article class="row mb-5">
    <div class="col-12">
        <div class="post-slider">
            <img loading="lazy" src="images/post/post-6.jpg" class="img-fluid" alt="post-thumb">
            <img loading="lazy" src="images/post/post-1.jpg" class="img-fluid" alt="post-thumb">
            <img loading="lazy" src="images/post/post-3.jpg" class="img-fluid" alt="post-thumb">
        </div>
    </div>
    <div class="col-12 mx-auto">
        <h3><a class="post-title" href="<?=Url::to(['article/view', 'id' => $article->id])?>"><?= $article->title?></a></h3>
        <ul class="list-inline post-meta mb-4">
            <li class="list-inline-item"><i class="ti-user mr-2"></i>
                <a href="/?author=<?=$article->user->id?>"><?= $article->user->username?></a>
            </li>
            <li class="list-inline-item">Дата : <?= $formatter->asDate($article->createdAt)?></li>
            <li class="list-inline-item">Категорія : <a href="/?category=<?=$article->category->id?>" class="ml-1"><?=$article->category->name?> </a>
            </li>
            <?php if(!empty($article->tags)):?>
                <li class="list-inline-item">Теги :
                    <?php foreach($article->tags as $key => $tag):?>
                    <a href="/?tag=<?=$tag->id?>" class="ml-1"><?= $tag->name?> </a> <?php if($key < count($article->tags)-1):?>,<?php endif?>
                    <?php endforeach;?>
                </li>
            <?php endif?>
        </ul>
        <p><?= $article->description ? Html::encode($article->description) : $article->getShortContent()?></p> <a href="post-elements.html" class="btn btn-outline-primary">Переглянути</a>
    </div>
</article>