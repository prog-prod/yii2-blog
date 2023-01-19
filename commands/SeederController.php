<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command fill database test data.
 * @param string $message the message to be echoed.
 * @return int Exit code
 */
class SeederController extends Controller
{
    /**
     * This command seed all
     * @return int Exit code
     */
    public function actionCreateAdmin(): int
    {

        // create admin user
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->setPassword("admin");
        $user->generateAuthKey();

        if ($user->save()) {
            return ExitCode::OK;
        }

        return ExitCode::NOUSER;

    }

}