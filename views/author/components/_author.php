<section class="section-sm border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="title-bordered mb-5 d-flex align-items-center">
                    <h1 class="h4"><?=$author->getFullName()?></h1>
                    <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
                        <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 mb-4 mb-md-0 text-center text-md-left">
                <img loading="lazy" class="rounded-lg img-fluid" src="/images/avatar/<?=$author->getAvatar()?>">
            </div>
            <div class="col-lg-9 col-md-8 content text-center text-md-left">
                <?= $author->getAboutMeText()?>
            </div>
        </div>
    </div>
</section>