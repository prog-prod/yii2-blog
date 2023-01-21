<!-- Search -->
<div class="widget">
    <h5 class="widget-title"><span>Пошук</span></h5>
    <form action="/" class="widget-search">
        <input id="search-query" name="s" type="search" value="<?=$this->context->request->get()['s'] ?? ''?>" placeholder="Напиши що шукаєш...">
        <button type="submit"><i class="ti-search"></i>
        </button>
    </form>
</div>
<!-- categories -->
<div class="widget">
    <h5 class="widget-title"><span>Категорії</span></h5>
    <ul class="list-unstyled widget-list">
        <?php foreach($categories as $category):?>
            <li><a href="?category=<?=$category->id?>" class="d-flex"><?= $category->name?>
                    <small class="ml-auto">(1)</small></a>
            </li>
        <?php endforeach?>
    </ul>
</div>
<!-- tags -->
<div class="widget">
    <h5 class="widget-title"><span>Теги</span></h5>
    <ul class="list-inline widget-list-inline">
        <?php foreach($tags as $tag):?>
            <li class="list-inline-item"><a href="?tag=<?=$tag->id?>"><?= $tag->name?></a></li>
        <?php endforeach?>
    </ul>
</div>
<!-- latest post -->
<div class="widget">
    <h5 class="widget-title"><span>Останні додані статті</span></h5>
    <!-- post-item -->
    <?php foreach($latest_articles as $article){
        echo $this->render('_latest_article', compact('article'));
    }?>
</div>