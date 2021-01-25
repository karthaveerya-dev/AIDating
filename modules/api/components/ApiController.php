<?php

namespace app\modules\api\components;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller {

    public function beforeAction($action) {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $this->enableCsrfValidation = false;

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

}
