<?php

namespace app\controllers;

use app\models\User;
use app\services\RegistrationDispatcher;
use cs\base\BaseController;
use Yii;
use cs\web\Exception;
use app\services\Subscribe;
use yii\filters\AccessControl;
use yii\helpers\Url;

class UploadController extends BaseController
{
    public $layout = 'menu';
    public $refererServer = ['galaxysss.ru', 'galaxysss.com'];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'matchCallback' => function() {
                            /** @var \app\models\User $user */
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                return false;
                            }
                            $url = new \cs\services\Url($_SERVER['HTTP_REFERER']);
                            if (is_array($this->refererServer)) {
                                foreach($this->refererServer as $serverName) {
                                    if (strpos($url->host, $serverName) !== false) {
                                        return true;
                                    }
                                }
                                return false;
                            } else {
                                if (strpos($url->host, $this->refererServer) !== false) {
                                    return true;
                                }
                                return false;
                            }
                        }
                    ],
                ],
            ],
        ];
    }

}
