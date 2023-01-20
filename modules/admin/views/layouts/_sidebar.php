<?php

use yii\bootstrap5\Nav;

?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <?= Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'nav flex-column'],
                'items' => $items
        ]); ?>
    </div>
</nav>
