<?php

namespace app\controllers;
 
use yii\rest\ActiveController;
 
class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';


    public function actionIndex()
    {
        return User::getAll();
    }

    public function actionCreate(){
        
        $request = \Yii::$app->request;
        $user = new $modelClass;
        return $request;
/*
        if ($request->post('name')) {
            $user->name = $request->post('name');
        }
        if ($request->post('email')) {
            $user->email = $request->post('email');
        }
        if ($request->post('password')) {
            $hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('password')); 
            $user->password_hash = $hash;
        }
        
        if ($user->save()) {
            return [
                'status' => true,
                'user_id' => $user->id
            ];
        } else {
            return [
                'status' => false,
                'code' => 2,
                'error' => 'Error with creation user'
            ];
        }
*/        
        
    }

}
