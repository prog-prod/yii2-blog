
<?= $this->render('components/_author', compact('author'))?>
<section class="section-sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title text-center">
                    <h2 class="mb-5">Опубліковано цим автором</h2>
                </div>
            </div>
            <?php foreach($articles as $article): ?>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <?= $this->render('components/_author_article', compact('article'))?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</section>