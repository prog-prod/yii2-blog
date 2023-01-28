<?php

use yii\helpers\Url;

?>
<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; IT Blog <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<footer class="section-sm pb-0 border-top border-default">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-3 mb-4">
                <a class="mb-4 d-block" href="/">
                    <img class="img-fluid" width="150px" src="<?=  Url::to(['images/logo.png'])?>" alt="IT Blog">
                </a>
                <p><?=$this->context->blog_desc?></p>
            </div>

            <div class="col-lg-2 col-md-3 col-6 mb-4">
                <h6 class="mb-4">Додаткове Меню</h6>
                <ul class="list-unstyled footer-list">
                    <?php foreach ($this->context->footer_items as $menu_item):?>
                        <?php if(isset($menu_item['label'])):?>
                            <li><a href="<?=Url::to($menu_item['url'][0])?>"><?= $menu_item['label']?></a></li>
                        <?php else:?>
                            <?=$menu_item?>
                        <?php endif?>
                    <?php endforeach;?>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 col-6 mb-4">
                <h6 class="mb-4">Соціальні мережі</h6>
                <ul class="list-unstyled footer-list">
                    <?php foreach ($this->context->social_networks as $social_network):?>
                        <?php if(isset($social_network['label'])):?>
                            <li><a href="<?=Url::to($social_network['url'][0])?>"><?= $social_network['label']?></a></li>
                        <?php else:?>
                            <?=$social_network?>
                        <?php endif?>
                    <?php endforeach;?>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h6 class="mb-4">Підпишись</h6>
                <form class="subscription" action="javascript:void(0)" method="post">
                    <div class="position-relative">
                        <i class="ti-email email-icon"></i>
                        <input type="email" class="form-control" placeholder="Ваш Email">
                    </div>
                    <button class="btn btn-primary btn-block rounded" type="submit">Підписатись зараз</button>
                </form>
            </div>
        </div>
        <div class="scroll-top">
            <a href="javascript:void(0);" id="scrollTop"><i class="ti-angle-up"></i></a>
        </div>
        <div class="text-center">
            <p class="content">&copy; <?=date("Y")?> - <?=$this->context->blog_name?></p>
        </div>
    </div>
</footer>
