<?php

namespace app\modules\admin\controllers;

use \app\controllers\DefaultController;

/**
 * Default controller for the `admin` module
 */
class IndexController extends DefaultController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
