
<section class="section">
    <div class="container">
        <article class="row mb-4">
            <div class="col-lg-10 mx-auto mb-4">
                <h1 class="h2 mb-3"><?= $article->title?></h1>
                <ul class="list-inline post-meta mb-3">
                    <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="/?author=<?=$article->user->id?>"><?= $article->user->username?></a>
                    </li>
                    <li class="list-inline-item">Перегляди: <?= $article->views?>
                    </li>
                    <li class="list-inline-item">Дата : <?= \Yii::$app->formatter->asDate($article->created_at)?></li>
                    <li class="list-inline-item">Категорія : <a href="/?category=<?=$article->category->id?>" class="ml-1"><?=$article->category->name?> </a>
                    </li>
                    <li class="list-inline-item">Теги :   <?php foreach($article->tags as $key => $tag):?>
                            <a href="/?tag=<?=$tag->id?>" class="ml-1"><?= $tag->name?> </a> <?php if($key < count($article->tags)-1):?>,<?php endif?>
                        <?php endforeach;?>
                    </li>
                </ul>
            </div>
            <div class="col-12 mb-3">
                <div class="post-slider">
                    <?php foreach($article->getImages() as $image):?>
                        <img loading="lazy" src="/images/post/<?=$image?>" class="img-fluid" alt="post-thumb">
                    <?php endforeach;?>
                </div>
            </div>
            <div class="col-lg-10 mx-auto">
                <div class="content">

                    <?= $article->content?>

                </div>
            </div>
        </article>
    </div>
</section>
