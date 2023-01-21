<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot/admin';
    public $baseUrl = '@web/admin';

    public $css = [
        'css/bootstrap.min.css',
        'css/dashboard.css',
        'css/font-icons.min.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js',
        'js/bootstrap.bundle.min.js',
    ];

}