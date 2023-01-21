<?php

use yii\helpers\Url;

?>
<ul class="list-unstyled widget-list">
    <li class="media widget-post align-items-center">
        <a href="<?=Url::to(['article/view', 'id' => $article->id])?>">
            <img loading="lazy" class="mr-3" src="/images/post/<?=$article->getBgImage()?>">
        </a>
        <div class="media-body">
            <h5 class="h6 mb-0"><a href="<?=Url::to(['article/view', 'id' => $article->id])?>"><?=$article->title?></a></h5>
            <small><?= \Yii::$app->formatter->asDate($article->createdAt)?></small>
        </div>
    </li>
</ul>